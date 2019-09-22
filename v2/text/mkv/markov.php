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
    if($this->set == '') {
    $sql = 'SELECT mkv_seq FROM mkv_words
            WHERE SUBSTRING(mkv_seq, 1, 1) REGEXP BINARY \'[A-Z]\'
            ORDER BY rand()'; // Incluir limit e fallback if none
  } else {
    $sql = 'SELECT mkv_seq FROM mkv_words
            WHERE `set` = $this->set and SUBSTRING(mkv_seq, 1, 1) REGEXP BINARY \'[A-Z]\'
            ORDER BY rand()'; // Incluir limit e fallback if none
  }

    $data = $this->DB->query($sql);
    $data->setFetchMode(PDO::FETCH_ASSOC);
    $new_data = $data->fetch();

    return $new_data;
  }

  private function trimLastSentence($input, $max_chars) {

    $input = (string)S::create($input)->truncate($max_chars, '');

    $idx_period = (string)S::create($input)->indexOfLast('.');
    $idx_exp = (string)S::create($input)->indexOfLast('!');
    $idx_int = (string)S::create($input)->indexOfLast('?');
    $idx_ret = (string)S::create($input)->indexOfLast('...');

    $last_idx = max($idx_period,$idx_exp,$idx_int,$idx_ret);

    $input = (string)S::create($input)->truncate($last_idx+1, '');

    return $input;
  }

  public function generateText($max_chars = 280) {
    $string = NULL;

    $initial = $this->initializeString();

    $string .= $initial["mkv_seq"];

    // $bootstrap = str_word_count($initial["mkv_seq"], 1, '\'"-,.;:0123456789%?!');
    $bootstrap = explode(" ",$initial["mkv_seq"]);

    $new_seq = $bootstrap[1]." ".$initial["next_word"];

    $string .= " ".$initial["next_word"];

    for ($i=0; $i < 1000; $i++) {

      $sql_new_seq = 'SELECT * FROM mkv_words WHERE mkv_seq = "'.$new_seq.'" order by rand()';

      $data_sq = $this->DB->query($sql_new_seq);
      $data_sq->setFetchMode(PDO::FETCH_ASSOC);
      $new_sq_data = $data_sq->fetch();

      $count_new_sq_data = count($new_sq_data);
      if($count_new_sq_data == 0) break;

      $string .= " ".$new_sq_data["next_word"];

      $new_seq = explode(" ",$new_seq);

      $count_new_seq = count($new_seq);
      if($count_new_seq == 0) break;


      $new_seq = $new_seq[1]." ".$new_sq_data["next_word"];

      if(strlen($string) > $max_chars) break;

    }
    $string = $this->trimLastSentence($string,$max_chars);

    return $string;
  }

}
?>
