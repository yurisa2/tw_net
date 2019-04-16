<?php
include "include/db/conn.php";


echo "<pre>";

$filename = "testfilea";
$file_string = file_get_contents($filename);



function explode_words_into_db($string) {
  global $file_db;

  $aWords = explode(" ",$string);

  $insert = "insert into words ('word','set') values ";

  foreach ($aWords as $key => $value) {
    // var_dump($value);
    $insert .= "('".$value."','test'), ";
  }

  $insert .= "('','')";

  var_dump($insert);

  $stmt = $file_db->prepare($insert);
  $stmt->execute();
}

explode_words_into_db($file_string);

?>
