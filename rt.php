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

require_once('include/twitterbot/retweetbot.php');

echo "oi3";

$oTwitterBot = new RetweetBot(array(
	'sUsername'			=> 'yurisa2',
	'aSearchStrings'	=> array(
		1 => 'fuzzy logic',
		2 => 'zadeh'
	),
));


echo "<pre>";
var_dump($oTwitterBot);

$oTwitterBot->run();
