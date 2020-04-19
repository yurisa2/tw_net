<?php
use Abraham\TwitterOAuth\TwitterOAuth;

class Controller_Twitter extends Controller_User {

  public function initialize() {
    if(!isset($this->selected_user)) $this->select_random_user();


    $this->connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET,
                                   $this->selected_user["token"],
                                   $this->selected_user["token_secret"]);

  }

  public function tweet($txt) {
    if(!isset($this->connection)) $this->initialize();

    $response = $this->connection->post("statuses/update", ["status" => $txt]);

    $this->last_response = $response;

    $this->log_action($this->generic_data, $response);
  }

  public function get_tweets($screen_name) {
    if(!isset($this->connection)) $this->initialize();

    $response = $this->connection->get("statuses/user_timeline",
                                        ["screen_name" => $screen_name,
                                          "count" => 50]);

    return $response;
  }


  public function rate_tweets($screen_name, $tw_list=NULL, $rt=FALSE, $like=FALSE) {
    if(!isset($this->connection)) $this->initialize();

    if(is_null($tw_list)) $tw_list = $this->get_tweets($screen_name);

    $new_list = array();

    foreach ($tw_list as $key => $value) {
      // var_dump(isset($value->retweeted_status));
      // var_dump($value->retweeted_status);
      if($value->retweeted == $rt &&
          $value->favorited == $like &&
          isset($value->retweeted_status) == FALSE &&
          $value->in_reply_to_status_id == NULL) {

            $new_list[$value->id] =  $value->favorite_count + $value->retweet_count;

      }
    }
    return $new_list;
  }

  public function retweet($id) {
    if(!isset($this->connection)) $this->initialize();

    $response = $this->connection->post("statuses/retweet", ["id" => $id]);

    $this->last_response = $response;

    $this->log_action($this->generic_data, $response);
  }


  public function like($id) {
    if(!isset($this->connection)) $this->initialize();

    $response = $this->connection->post("favorites/create", ["id" => $id]);

    $this->last_response = $response;

    $this->log_action($this->generic_data, $response);
  }


  public function log_action($generic_data, $response) {
    $log = new Model_Log;
    $log->log_response($this->selected_user["id"] ,json_encode($response),$generic_data);
  }

  public function get_friends($screen_name) {
    if(!isset($this->connection)) $this->initialize();

    $response = $this->connection->get("friends/list",
                                        ["screen_name" => $screen_name,
                                          "count" => 200]);

    return $response;
  }

}



?>
