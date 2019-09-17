<?php

$file = __DIR__."/text.db";

$file_db = new PDO('sqlite:'.$file);

$file_db->setAttribute(PDO::ATTR_ERRMODE,
PDO::ERRMODE_EXCEPTION);

// Create new database in memory
$memory_db = new PDO('sqlite::memory:');
// Set errormode to exceptions
$memory_db->setAttribute(PDO::ATTR_ERRMODE,
PDO::ERRMODE_EXCEPTION);


 ?>
