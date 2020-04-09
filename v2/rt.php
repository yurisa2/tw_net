<?php
ini_set("display_errors",1);
ini_set('max_execution_time', 3600);
error_reporting(E_ALL);

$start_time = microtime(TRUE);

date_default_timezone_set('UTC');

include __DIR__."/include/include_all.php";


$user = new Controller_User;
$freq = new Controller_Frequency;
$twit = new Controller_Twitter;


echo '<pre>';

$meutw = $twit->rate_tweets("");
asort($meutw);
var_dump($meutw);
var_dump(array_key_first($meutw));

// foreach ($meutw as $key => $value) {
//   echo 'id '.$value->id.'<br>';
//
//   echo 'favorite_count '.$value->favorite_count.'<br>';
//   echo 'retweet_count '.$value->retweet_count.'<br>';
//
//   echo 'In Reply '.$value->in_reply_to_status_id.'<br>';
//   echo 'retweeted '.$value->retweeted.'<br>';
//   echo 'favorited '.$value->favorited.'<br>';
//
//   echo 'Text '.$value->text.'<br>';
//   var_dump($value);
//   break;
// }

 ?>
