<?php
ini_set("display_errors",1);
ini_set('max_execution_time', 3600);
error_reporting(E_ALL);

include __DIR__."/include/include_all.php";

echo '<pre>';

$db = new DB;

$shakes =  addslashes(file_get_contents($file_name));

$sql_del = 'INSERT into txt (`set`, `text`) values ("leis, brasil, legis, portuguese", ?)' ;
$data = $db->conn->prepare($sql_del);
$data->execute(array($shakes));

var_dump($file_name);
unlink($file_name);


// var_dump($input);

 ?>
