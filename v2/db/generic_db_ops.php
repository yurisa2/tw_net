<?php

class DBOPS {


  public function __construct() {

    $this->db = new DB;

  }

  public function log_response($user_data,$response) {
    $sql_log = 'INSERT into `logs` (`link_user_data`, `response`) values (?, ?)' ;
    $data = $db->conn->prepare($sql_log);
    $data->execute(array($user_data, $response));
  }

}



?>
