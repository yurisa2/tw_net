<?php
echo '3';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

 ini_set('display_startup_errors', 1);
 ini_set('display_errors', 1);
 error_reporting(E_ALL);

 include 'include/include_all.php';

$files = glob('origins/*');
$file = array_rand($files);

var_dump($files[$file]);


$oTwitterBot = new MarkovBot(array(
	'sUsername'			=> USERNAME,
	'sInputFile'	=> $files[$file],
	'sInputType'	=> 'generate'

));


echo "<pre>";
var_dump($oTwitterBot);

$oTwitterBot->run();
