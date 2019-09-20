<?php
ini_set("display_errors",1);
ini_set('max_execution_time', 3600);
// Report all PHP errors
error_reporting(E_ALL);

include __DIR__."/include/include_all.php";

$input = file_get_contents('ts.txt');

// var_dump($input);

echo '<pre>';


$markov = new Markov;
$markov->generateMarkovChainsWords($input,"tinyshakespeare, literature, books, english");
// var_dump($markov->generateMarkovChainsWords($input,"tinyshakespeare, literature, books, english"));

 ?>
