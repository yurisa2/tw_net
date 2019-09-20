<?php
ini_set("display_errors",1);

ini_set('max_execution_time', 6);


function shutdown() {
    $error = error_get_last();
    if ($error['type'] === E_ERROR) {

      echo "tuc tuc tuc";

      $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

      if(strpos($error["message"],"Maximum execution time") !== FALSE) {

        file_get_contents($actual_link);
        var_dump($error);
      }
      // var_dump(strpos($error["message"],"Maximum execution time"));

    }
}



 ?>
