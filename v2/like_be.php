<?php
ini_set("display_errors",1);
ini_set('max_execution_time', 3600);
error_reporting(E_ALL);

$start_time = microtime(TRUE);

date_default_timezone_set('UTC');

include __DIR__."/include/include_all.php";


$freq = new Controller_Frequency;
$twit = new Controller_Twitter;


echo '<pre>';

// $twit->select_user_by_id(14);
$twit->select_user_by_sn($_GET["screenname"]);

// var_dump($twit->selected_user);

$debug = NULL;

if(isset($_GET["debug"])) $debug = $_GET["debug"];


if($freq->get_permit($twit->selected_user) || $debug == '1234') {

  $search_people = $twit->get_user_search_people();

  // var_dump($search_people);
  // var_dump(!is_null($search_people)); exit;


  if(!is_null($search_people)) {

    $meutw = $twit->rate_tweets($search_people[array_rand($search_people)]);
    asort($meutw);
    $least_rated = array_key_first($meutw);

    $generic_data = json_encode(array('like_id' => $least_rated));

    if(isset($least_rated) && $least_rated > 0)
    {
      $twit->generic_data = $generic_data;
      $twit->like($least_rated);
      var_dump($twit->last_response);
    } else {
      echo "No Rated tweets";

      $friends_list = $twit->get_friends($twit->selected_user["screenname"])->users;
      $friend_screenname = $friends_list[array_rand($friends_list)]->screen_name;

      $meutw = $twit->rate_tweets($friend_screenname);
      asort($meutw);
      $least_rated = array_key_first($meutw);

      $generic_data = json_encode(array('like_id' => $least_rated));

      $twit->generic_data = $generic_data;
      $twit->like($least_rated);
      var_dump($twit->last_response);

    }
  } else {
    echo "no Search People";
  }


} else {
  exit("Freq DENIED");
}

?>
