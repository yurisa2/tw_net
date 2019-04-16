<?php


$file_db = new PDO('sqlite:include/db/main.db');

$file_db->setAttribute(PDO::ATTR_ERRMODE,
PDO::ERRMODE_EXCEPTION);

// Create new database in memory
$memory_db = new PDO('sqlite::memory:');
// Set errormode to exceptions
$memory_db->setAttribute(PDO::ATTR_ERRMODE,
PDO::ERRMODE_EXCEPTION);


 ?>
