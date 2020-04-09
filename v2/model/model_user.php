<?php

class Model_User extends DB {

  public function __construct() {
    if(!isset($this->conn)) $this->connect();
  }

  public function get_users() {
    $sql_userdata = 'SELECT * FROM user_data';
    $data_sq = $this->conn->query($sql_userdata);
    // $data_sq->setFetchMode(PDO::FETCH_ASSOC);
    $user_data = $data_sq->fetchAll();

    $user_data_new_index = array();

    foreach ($user_data as $key => $value) {
      $user_data_new_index[$value['id']] = $value;
    }

    return $user_data_new_index;
  }


}



?>
