<?php

function include_all_php($folder){
    foreach (glob("{$folder}/*.php") as $filename)
    {
        include $filename;
        // echo 'including ' . $filename . '<Br>'; // DEBUG
    }
}

include __DIR__.'/vendor/autoload.php';
include __DIR__.'/basic.php';
include __DIR__.'/config.php';
include __DIR__.'/../db/conn.php';
include __DIR__.'/../db/generic_db_ops.php';
include __DIR__.'/../text/mkv/markov.php';
include __DIR__.'/../text/mkv/convert_txt_mkv.php';



include_all_php(__DIR__.'/../model');
// include_all_php(__DIR__.'/../controller');

include __DIR__.'/../controller/controller_freq.php';
include __DIR__.'/../controller/controller_user.php';
include __DIR__.'/../controller/controller_twitter.php';


if (!function_exists('array_key_first')) {
    function array_key_first(array $arr) {
        foreach($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }
}

// echo __DIR__.'/../model';

 ?>
