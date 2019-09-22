<?php

class ConvertMkv {

  function __construct() {
    $this->start_time = microtime();
    $this->txt_count = 0;
    $this->mkv = new Markov;
    $this->db = new DB;

  }

  function __destruct() {
    $this->end_time = microtime();
    $this->total_microtime = $this->end_time - $this->start_time;

    echo "Converted $this->txt_count Chains in $this->total_microtime seconds";

  }

  private function getTxt() {
    $sql = 'SELECT * FROM txt ORDER BY rand()';
    $data = $this->db->conn->query($sql);
    $data->setFetchMode(PDO::FETCH_ASSOC);
    $input = $data->fetch();

    if(!$input) exit("Err: Txt empty");

    return $input;
  }

  private function sendChainsDB($insert,$insert_values) {
    $insert_values = substr_replace($insert_values ,"", -1);
    $stmt = $this->db->conn->prepare($insert.$insert_values);
    $stmt->execute();
  }

  private function deleteTxt($id) {
    $sql_del = 'DELETE FROM txt where id = '.$id ;
    $data = $this->db->conn->query($sql_del);
  }

  public function iterTxt() {
    $j = 0;
    $insert_values = NULL;

    do {
      $input = $this->getTxt();

      $arr_mkv = $this->mkv->generateMarkovChains($input["text"],$input["set"]);

      $insert = "INSERT INTO mkv_words (mkv_seq,next_word,`set`) VALUES ";

      $this->db->conn->beginTransaction();
      foreach ($arr_mkv as $key => $value) {

        $mkv_seq = addslashes($value["mkv_seq"]);
        $next_word = addslashes($value["next_word"]);

        $insert_values .= "('".$mkv_seq."', '".$next_word."',' ".$input["set"]."'),";

        if($j >= 400) {
          $this->sendChainsDB($insert,$insert_values);
          $insert_values = NULL;
          $j = 0;

        }
        $j++;
        $this->txt_count++;
      }
      $this->sendChainsDB($insert,$insert_values);
      $this->db->conn->commit();

      $input = $this->deleteTxt($input["id"]);

    } while ($input["text"] != NULL);

  }



}

echo '<pre>';



?>
