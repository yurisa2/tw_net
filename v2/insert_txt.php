<?php
ini_set("display_errors",1);
ini_set('max_execution_time', 3600);
error_reporting(E_ALL);

include __DIR__."/include/include_all.php";

do {
$sql = 'SELECT * FROM txt';
$data = $file_db->query($sql);
$data->setFetchMode(PDO::FETCH_ASSOC);
$input = $data->fetch();



// var_dump($input["text"]);
// exit;

echo '<pre>';

Markov::generateMarkovChainsWords($input["text"],$input["set"]);

$sql_del = 'DELETE FROM txt where id = '.$input["id"] ;
$data = $file_db->query($sql_del);
} while (count($input) > 0);


// var_dump($input);

 ?>
