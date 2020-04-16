<?php
ini_set("display_errors",1);
ini_set('max_execution_time', 3600);
error_reporting(E_ALL);

$start_time = microtime(TRUE);

date_default_timezone_set('UTC');

include __DIR__."/include/include_all.php";

$user = new Controller_User;
$mc = JMathai\PhpMultiCurl\MultiCurl::getInstance();

echo '<pre>';

$user_list = $user->get_users();

$url =  "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";


function removeFilename($url)
{
    $file_info = pathinfo($url);
    return isset($file_info['extension'])
        ? str_replace($file_info['filename'] . "." . $file_info['extension'], "", $url)
        : $url;
}

$url = removeFilename($url);


if(sys_getloadavg()[0] < 40) {

  foreach ($user_list as $key => $value) {
    echo $url.'xxx.php?screenname='.$value["screenname"].'<br>';
    $call1 = $mc->addUrl($url.'mkv_tweet.php?screenname='.$value["screenname"]);
    $call2 = $mc->addUrl($url.'like_be.php?screenname='.$value["screenname"]);
    $call3 = $mc->addUrl($url.'rt_be.php?screenname='.$value["screenname"]);
  }
}
 ?>
