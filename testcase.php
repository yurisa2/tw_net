<?php
include "include/db/conn.php";


echo "<pre>";

$lStart = microtime(TRUE);

$filename = "testfilea";
$file_string = file_get_contents($filename);




$aWords = explode(" ",$file_string,1000);

foreach ($aWords as $key => $value) {
  var_dump($value);

// if last item, put it
  if($key == (count($aWords)-2)) {
    file_put_contents($filename,end($aWords));
    break;
  }

  //Deletes file if only one word
  if(count(explode(" ",$file_string,100)) == 1) unlink($filename);
}

echo "Tempo: ". (microtime(TRUE) - $lStart);



?>
