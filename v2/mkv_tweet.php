<?php
ini_set("display_errors",1);
ini_set('max_execution_time', 3600);
error_reporting(E_ALL);

$start_time = microtime(TRUE);

date_default_timezone_set('UTC');

include __DIR__."/include/include_all.php";

$markov = new Markov;

$freq = new Controller_Frequency;
$twit = new Controller_Twitter;


echo '<pre>';

// var_dump($twit->select_random_dataset());
// var_dump($twit->selected_user);
// exit;
$twit->select_user_by_sn($_GET["screenname"]);
$markov->set = $twit->select_random_dataset();

// use Abraham\TwitterOAuth\TwitterOAuth;
// $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $twit->selected_user["token"],  $twit->selected_user["token_secret"]);
//

var_dump($freq->get_permit($twit->selected_user));
// exit;

if($freq->get_permit($twit->selected_user)) {

  $tw_text =  $markov->generateText();

  $end_Time =  microtime(TRUE);

  // Add Hashtags if possible

  $txt_len = strlen($tw_text);

  $ht_num = rand(0, count($twit->get_user_hashtags())-1);

  $hashtags = NULL;

    for ($i=0; $i <= $ht_num; $i++) {
      if(rand(0,1) == 1) $hashtags .= ' '.$twit->get_user_hashtags()[$i];
    }

  $total_len = $txt_len + strlen($hashtags);

  if(!is_null($hashtags) && $total_len < 280) $tw_text = $tw_text . $hashtags;

  // End of hashtags


  $generic_data = json_encode(array('num_mkv_chains' => $markov->mkv_chains,
                                    'time' => ($end_Time - $start_time),
                                    'set' => $markov->set
                                    )
                              );

   $twit->selected_user = $twit->selected_user;
   $twit->generic_data = $generic_data;
   $twit->tweet($tw_text);

   var_dump($twit->last_response);


} else {
  exit("Freq DENIED");
}

 ?>
