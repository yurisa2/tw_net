<?php
include "include/db/conn.php";


echo "<pre>";

$filename = "testfilea";
// $file_string = file_get_contents($filename);
$data = $file_db->query('SELECT text FROM txt')->fetchAll(PDO::FETCH_COLUMN);

foreach ($data as $key => $value) {

    file_put_contents($filename,$value,FILE_APPEND);
    file_put_contents($filename," ",FILE_APPEND);

    exit;
}




?>
