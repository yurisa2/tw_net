<?php

class Model_Log extends DB {

  public function __construct() {
    if(!isset($this->conn)) $this->connect();
  }

  public function log_response($user_data,$response,$generic_data) {
    $sql_log = 'INSERT into `logs` (`link_user_data`, `response`, `generic_data`) values (?, ?, ?)' ;
    $data = $this->conn->prepare($sql_log);
    $data->execute(array($user_data, $response, $generic_data));
  }


}



?>
