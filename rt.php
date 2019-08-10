<?php

 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);
 echo "oi2-";

// REFACTOR WITH INCLUDES

$prefix_path = "include/twitterbot/";

require_once('include/twitterbot/retweetbot.php');

echo "oi3";

$oTwitterBot = new RetweetBot(array(
	'sUsername'			=> 'BengoWengo',
	'aSearchStrings'	=> array(
		1 => 'erviegas',
		2 => 'easypath',
		3 => 'acqualife',
		4 => 'markov',
		5 => 'fuzzy logic',
		6 => 'myr',
		7 => 'patologia',
		8 => 'cancer',
		9 => 'unesp'
	),
));


echo "<pre>";
var_dump($oTwitterBot);

$oTwitterBot->run();
