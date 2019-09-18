<?php
ini_set("display_errors",1);

include __DIR__."/include/include_all.php";

do {
$sql = 'SELECT * FROM txt';
$data = $file_db->query($sql);
$data->setFetchMode(PDO::FETCH_ASSOC);
$input = $data->fetch();



// var_dump($input["text"]);
// exit;

echo '<pre>';

Markov::generateMarkovChainsWords($input["text"],$input["set"]." , porn, contoseroticos.com, portuguese");

$sql_del = 'DELETE FROM txt where id = '.$input["id"] ;
$data = $file_db->query($sql_del);
} while (count($input) > 0);


// var_dump($input);

 ?>
