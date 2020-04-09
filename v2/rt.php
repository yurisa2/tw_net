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
//
// $meutw = $twit->rate_tweets("Charlotte69fr");
// asort($meutw);
// var_dump($meutw);
// var_dump(array_key_first($meutw));


// $user->select_user_by_id(14);
$user->select_user_by_sn("yurisa2");



var_dump($ht_num);
var_dump($hashtags);


// var_dump($user);

 ?>
