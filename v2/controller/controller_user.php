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

  public function select_user_by_id($tw_user_id) {
    $all_users = $this->get_users();

    $user = $all_users[$tw_user_id];

    $this->selected_user = $user;

    return $user;
  }

  public function select_user_by_sn($tw_screen_name) { //USE WITH CAUTION
    $all_users = $this->get_users();
    $user = NULL;

    foreach ($all_users as $key => $value) {
      // var_dump($value["screenname"]);


      if($value["screenname"] == $tw_screen_name) {
        $user = $value;
        break;
      }
    }

    if(!is_null($user)) {
      $this->selected_user = $user;
    } else {
      exit("No User Selected");
    }
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

  public function get_user_search_people() {
    if(!isset($this->selected_user)) $this->select_random_user();
    $people = NULL;

    $search = $this->selected_user["search"];
    $search = json_decode($search);

    if(isset($search->people)) $people = $search->people;

    return $people;
  }

  public function get_user_hashtags() {
    if(!isset($this->selected_user)) $this->select_random_user();
    $hashtags = NULL;

    $search = $this->selected_user["search"];
    $search = json_decode($search);

    if(isset($search->hashtags)) $hashtags = $search->hashtags;

    return $hashtags;
  }


}



?>
