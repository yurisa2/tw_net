<?php

$file = __DIR__."/text.db";

$file_db = new PDO('mysql:host='.MYSQL_SERVER.';dbname='.MYSQL_DB,
    MYSQL_USER,
    MYSQL_PASS);

$file_db->setAttribute(PDO::ATTR_ERRMODE,
PDO::ERRMODE_EXCEPTION);


 ?>
