<?php

 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);
 echo "oi2-";


$prefix_path = "include/twitterbot/";

DEFINE("CONSUMER_KEY", "");
DEFINE("CONSUMER_SECRET", "");

DEFINE("ACCESS_TOKEN", "");
DEFINE("ACCESS_TOKEN_SECRET", "");

define("MYPATH","C:\\Bitnami\\wampstack-7.1.28-0\\apache2\\htdocs\\tw_net");

require_once($prefix_path.'markovbot.php');

echo "oi3";

$oTwitterBot = new MarkovBot(array(
	'sUsername'			=> 'BengoWengo',
	'sInputFile'	=> 'olegis.txt',
	'sInputType'	=> 'generate'

));


echo "<pre>";
var_dump($oTwitterBot);

$oTwitterBot->run();
