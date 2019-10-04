<?php
use Stringy\Stringy as S;

class Markov  {

  function __construct() {
    $this->db = new DB;
    $this->set = '';
  }

  public function generateMarkovChains($sInput, $set) {
    $aWords = explode(" ",$sInput);

    $aMarkovChains = array();
    foreach ($aWords as $i => $sWord) {
      if (!empty($aWords[$i + 2])) {

        $mkv_seq = $sWord . ' ' . $aWords[$i + 1];
        $next_word = $aWords[$i + 2];

        $aMarkovChains[] = [ "mkv_seq" => $mkv_seq,
                              "next_word" => $next_word,
                              "set" => $set
                            ];
      }
    }

    return $aMarkovChains;
  }

  private function initializeString() {
    if($this->set == '') { // Incluir limit e fallback if none
      exit("No set defined");
  } else {
    $sql = 'SELECT
    mkv_seq, next_word, `set`
FROM
    mkv_words AS r1
        JOIN
    (SELECT
        CEIL(RAND('.rand().') * (SELECT
                    MAX(id)
                FROM
                    mkv_words
                WHERE
                    `set` = \''.$this->set.'\'
                    )
		) AS id
    ) AS r2
WHERE
    r1.id >= r2.id
        AND                     `set` = \''.$this->set.'\'

        AND SUBSTRING(mkv_seq, 1, 1) REGEXP BINARY \'[A-Z]\'
		AND CHAR_LENGTH(mkv_seq) > 3
ORDER BY rand()
LIMIT 1
'; // Incluir limit e fallback if none
  }
  // var_dump($sql); //DEBUG

    $data = $this->db->conn->query($sql);
    $data->setFetchMode(PDO::FETCH_ASSOC);
    $new_data = $data->fetch();

    // var_dump($sql); //DEBUG
    // var_dump($new_data); //DEBUG
    // exit; //DEBUG

    return $new_data;
  }

  private function trimLastSentence($input, $max_chars) {

    // var_dump($input);
    // exit;

    $input = (string)S::create($input)->truncate($max_chars, '');

    $idx_period = (string)S::create($input)->indexOfLast('.');
    $idx_exp = (string)S::create($input)->indexOfLast('!');
    $idx_int = (string)S::create($input)->indexOfLast('?');
    $idx_ret = (string)S::create($input)->indexOfLast('...');

    $last_idx = max($idx_period,$idx_exp,$idx_int,$idx_ret);

if(is_numeric($last_idx))    $input = (string)S::create($input)->truncate($last_idx+1, '');

    return $input;
  }

  public function generateText($max_chars = 280, $min_chars = 15) {
    $this->mkv_chains = 1;

    $string = NULL;

    $initial = $this->initializeString();

    $string .= $initial["mkv_seq"];

    // $bootstrap = str_word_count($initial["mkv_seq"], 1, '\'"-,.;:0123456789%?!');
    $bootstrap = explode(" ",$initial["mkv_seq"]);

    $new_seq = $bootstrap[1]." ".$initial["next_word"];

    $string .= " ".$initial["next_word"];

    // var_dump($initial); //DEBUG

    for ($i=0; $i < 1000; $i++) {

      $this->mkv_chains++;

      $sql_new_seq = 'SELECT * FROM mkv_words WHERE mkv_seq = "'.$new_seq.'" and `set` = \''.$this->set.'\' order by rand() limit 1';
      // $sql_new_seq = '
      // SELECT
      // *
      // FROM
      // mkv_words AS r1
      //     JOIN
      // (SELECT
      //     CEIL(RAND() * (SELECT
      //                 MAX(id)
      //             FROM
      //                 mkv_words
      //             WHERE
      //                 `set` = \''.$this->set.'\'
      //                 )
      // ) AS id
      // ) AS r2
      // WHERE
      // r1.id >= r2.id
      //     AND `set` = \''.$this->set.'\'
      //     AND mkv_seq = "'.$new_seq.'"
      //
      // ORDER BY r1.id ASC
      // ';

      // var_dump($sql_new_seq); //DEBUG


      $data_sq = $this->db->conn->query($sql_new_seq);
      $data_sq->setFetchMode(PDO::FETCH_ASSOC);
      $new_sq_data = $data_sq->fetch();

      // $count_new_sq_data = count($new_sq_data);
      if($new_sq_data == FALSE) break;

      $string .= " ".$new_sq_data["next_word"];

      $new_seq = explode(" ",$new_seq);

      if($new_seq == FALSE) break;


      $new_seq = $new_seq[1]." ".$new_sq_data["next_word"];

      if(strlen($string) > $max_chars) break;

    }

    if(strlen($string) < 10) $this->generateText($max_chars,$min_chars);

    $string = $this->trimLastSentence($string,$max_chars);

    $string = stripslashes($string);

    return $string;
  }

}
?>
