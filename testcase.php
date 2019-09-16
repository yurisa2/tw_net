<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


include "include/db/conn.php";


echo "<pre>";

$filename = "origins/ep.txt";
$file_string = file_get_contents($filename);



function explode_words_into_db($string) {
  global $file_db;

  $aWords = explode(" ",$string);

  $insert = "insert into words ('word','set') values ";

  foreach ($aWords as $key => $value) {
    // var_dump($value);
    if(strlen($value) > 0)
    $insert .= "('".SQLite3::escapeString($value)."','test'), ";
  }

  $insert .= "('','')";

  var_dump($insert);

  $stmt = $file_db->prepare($insert);
  $stmt->execute();
}

explode_words_into_db($file_string);

?>
