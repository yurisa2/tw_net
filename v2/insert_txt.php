<?php
ini_set("display_errors",1);
ini_set('max_execution_time', 3600);
ini_set('memory_limit', '2048M');
error_reporting(E_ALL);

include __DIR__."/include/include_all.php";

$input_txt = file_get_contents("ts.txt");


echo '<pre>';

var_dump(Markov::generateMarkovChainsWords($input_txt,"set Text"));


 ?>
