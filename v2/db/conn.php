<?php

class DB {

  public function __construct() {

    $this->conn = new PDO('mysql:host='.MYSQL_SERVER.';dbname='.MYSQL_DB,
    MYSQL_USER,
    MYSQL_PASS,
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")

  );

      $this->conn->setAttribute(PDO::ATTR_ERRMODE,
                                PDO::ERRMODE_EXCEPTION
                              );

  }

}
?>
