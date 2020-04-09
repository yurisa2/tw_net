<?php

class Controller_User extends Model_User {

  public function __construct() {
    if(!isset($this->conn)) $this->connect();
  }

  public function select_random_user() {
    $all_users = $this->get_users();

    $pointer = array_rand($all_users);

    $user = $all_users[$pointer];

    $this->selected_user = $user;
    return $user;
  }

  public function select_user($user_id) {
    $all_users = $this->get_users();

    $user = $all_users[$user_id];

    $this->selected_user = $user;

    return $user;
  }

  public function select_random_dataset() {
    if(!isset($this->selected_user)) $this->select_random_user();

    if($this->selected_user["search"] != NULL) {
      $datasets = json_decode($this->selected_user["search"]);
      // var_dump($datasets->datasets[array_rand($datasets->datasets)]); //DEBUG
      $set = $datasets->datasets[array_rand($datasets->datasets)];
      // var_dump($datasets); //DEBUG
    } else {
      $set = NULL;
    }

    return $set;
  }



}



?>
