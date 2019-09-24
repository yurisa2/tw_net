<?php
ini_set("display_errors",1);

include __DIR__."/include/include_all.php";

// $input = file_get_contents('lipsum.txt');

// var_dump($input);

echo '<pre>';

$start_time = microtime(TRUE);

$markov = new Markov;
$markov->set = 'lyrics%rock';
var_dump($markov->generateText());

$end_Time =  microtime(TRUE);

echo "Gerado em: " .($end_Time - $start_time);
 ?>
