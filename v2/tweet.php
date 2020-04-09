<?php
ini_set("display_errors",1);
ini_set('max_execution_time', 3600);
error_reporting(E_ALL);

$start_time = microtime(TRUE);

date_default_timezone_set('UTC');

include __DIR__."/include/include_all.php";

$markov = new Markov;

$user = new Controller_User;
$freq = new Controller_Frequency;
$twit = new Controller_Twitter;


echo '<pre>';

// var_dump($user->select_random_dataset());
// var_dump($user->selected_user);
// exit;

$markov->set = $user->select_random_dataset();

// use Abraham\TwitterOAuth\TwitterOAuth;
// $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $user->selected_user["token"],  $user->selected_user["token_secret"]);
//

var_dump($freq->get_permit($user->selected_user));
// exit;

if($freq->get_permit($user->selected_user)) {

  $tw_text =  $markov->generateText();

  $end_Time =  microtime(TRUE);

  $generic_data = json_encode(array('num_mkv_chains' => $markov->mkv_chains,
                                    'time' => ($end_Time - $start_time),
                                    'set' => $markov->set
                                    )
                              );

   $twit->selected_user = $user->selected_user;
   $twit->generic_data = $generic_data;
   $twit->tweet($tw_text);

   var_dump($twit->last_response);


} else {
  exit("Freq DENIED");
}

 ?>
