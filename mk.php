<?php
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$prefix_path = "include/twitterbot/";

define("CONSUMER_KEY", "7w3pZVva85bQjNO4k6moZWmIs");
define("CONSUMER_SECRET", "DEvAz6e3691uQ0YN1AZTTl6YhyfUUUTGxuAii3hXyTjMkAPbde");

define("ACCESS_TOKEN", "1104397298774220800-qqqm7o8ogXCfScKOdG9mfYaaD6wu1Z");
define("ACCESS_TOKEN_SECRET", "ee37ej6EURLBMmuCcdGv4tObitOs7gqPe6q5NeNqH6Jl8");

define("MYPATH","/home/yurisa2/lampstack-5.6.22-0/apache2/htdocs/tw_net/");

require_once($prefix_path.'markovbot.php');


$oTwitterBot = new MarkovBot(array(
	'sUsername'			=> 'BengoWengo',
	'sInputFile'	=> 'testfile',
	'sInputType'	=> 'generate'

));


echo "<pre>";
var_dump($oTwitterBot);

$oTwitterBot->run();
