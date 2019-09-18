<?php
ini_set("display_errors",1);

include __DIR__."/include/include_all.php";

$input = file_get_contents('ts.txt');

// var_dump($input);

echo '<pre>';

Markov::generateMarkovChainsWords($input,"tinyshakespeare, literature, books, english");

 ?>
