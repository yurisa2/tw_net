<?php


class Markov  {

  public function generateMarkovChainsWords($sInput) {
    global $file_db; //temp

    $lStart = microtime(TRUE);
    $aWords = str_word_count($sInput, 1, '\'"-,.;:0123456789%?!');

    // var_dump($aWords);

    $file_db->beginTransaction();
    $insert = "insert into mkv_words ('mkv_seq','next_word','set') VALUES ";

    $insert_values = NULL;

    foreach ($aWords as $i => $sWord) {
      if (!empty($aWords[$i + 2])) {
        $aMarkovChains[$sWord . ' ' . $aWords[$i + 1]][] = $aWords[$i + 2];

        $insert_values .= "('".SQLite3::escapeString($sWord . ' ' . $aWords[$i + 1])."', '".SQLite3::escapeString($aWords[$i + 2])."', 'TESTE'),";

          if($j >= 400) {
            $insert_values = substr_replace($insert_values ,"", -1);
            $stmt = $file_db->prepare($insert.$insert_values);
            $stmt->execute();
            $insert_values = NULL;
            $j = 0;
          }
          $j++;
      }
    }

    $insert_values = substr_replace($insert_values ,"", -1);
    $stmt = $file_db->prepare($insert.$insert_values);
    $stmt->execute();
    $file_db->commit();

    // var_dump($aMarkovChains);
    var_dump($stmt);

    return $aMarkovChains;
  }

  private function initialize_markov() {
    global $file_db;

    $sql = 'SELECT * FROM mkv_words WHERE substr(mkv_seq, 1, 1) GLOB(\'[A-Z]\') order by random()';
    $data = $file_db->query($sql);
    $data->setFetchMode(PDO::FETCH_ASSOC);
    $new_data = $data->fetch();

    return $new_data;
  }

  private function trim_last_sentence($input, $method = "longer") {

    $imploded_period = explode(".", $input);
    $imploded_exc = explode("!", $input);
    $imploded_int = explode("?", $input);

    $new_array = max($imploded_period, $imploded_exc, $imploded_int);



  }

  public function generateText($max_chars = 280) {
    global $file_db; //temp

    //INITIALIZE WITH capital

    $string = NULL;

    $initial = $this->initialize_markov();

    $string .= $initial["mkv_seq"];

    $bootstrap = str_word_count($initial["mkv_seq"], 1, '\'"-,.;:0123456789%?!');


    $new_seq = $bootstrap[1]." ".$initial["next_word"];

    $string .= " ".$initial["next_word"];

    for ($i=0; $i < 1000; $i++) {

      $sql_new_seq = 'SELECT * FROM mkv_words WHERE mkv_seq = "'.$new_seq.'" order by random()';
      $data_sq = $file_db->query($sql_new_seq);
      $data_sq->setFetchMode(PDO::FETCH_ASSOC);
      $new_sq_data = $data_sq->fetch();

      $count_new_sq_data = count($new_sq_data);
      if($count_new_sq_data == 0) break;

      $string .= " ".$new_sq_data["next_word"];

      $new_seq = str_word_count($new_seq, 1, '\'"-,.;:0123456789%?!');

      $count_new_seq = count($new_seq);
      if($count_new_seq == 0) break;


      $new_seq = $new_seq[1]." ".$new_sq_data["next_word"];

      if(strlen($string) > $max_chars) break;

    }


    var_dump($string);



  }

}
?>
