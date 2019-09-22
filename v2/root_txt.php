<?php
ini_set("display_errors",1);
ini_set('max_execution_time', 3600);
error_reporting(E_ALL);


include __DIR__."/include/include_all.php";

// var_dump($input["text"]);
// exit;

$shakes = addslashes(file_get_contents("ts.txt"));

echo '<pre>';

$db = new DB;

$sql_del = 'INSERT into txt (`set`, `text`) values ("shakespeare, literature, books, english", ?)' ;
$data = $db->conn->prepare($sql_del);
$data->execute(array($shakes));

// var_dump($input);

 ?>
