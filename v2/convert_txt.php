<?php
ini_set("display_errors",1);
ini_set('max_execution_time', 60000);
ini_set('memory_limit', '2048M');
error_reporting(E_ALL);

include __DIR__."/include/include_all.php";

echo '<pre>';

$conv_txt_mkv = new ConvertMkv;

$conv_txt_mkv->iterTxt();

?>
