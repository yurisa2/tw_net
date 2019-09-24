<?php
ini_set("display_errors",1);
ini_set('max_execution_time', 3600);
error_reporting(E_ALL);

include __DIR__."/include/include_all.php";

$lock_location = __DIR__.'/files/lock_fileprocessor.pid';
$lock_file = fopen($lock_location, 'c');
$got_lock = flock($lock_file, LOCK_EX | LOCK_NB, $wouldblock);
if ($lock_file === false || (!$got_lock && !$wouldblock)) {
    throw new Exception(
        "Unexpected error opening or locking lock file. Perhaps you " .
        "don't  have permission to write to the lock file or its " .
        "containing directory?"
    );
}
else if (!$got_lock && $wouldblock) {
    exit("Another instance is already running; terminating.\n");
}

// Lock acquired; let's write our PID to the lock file for the convenience
// of humans who may wish to terminate the script.
ftruncate($lock_file, 0);
fwrite($lock_file, getmypid() . "\n");

///////////////////////////////////////////////////////////////////////////

$file_list = file_get_contents($files);
$file_list = json_decode($file_list);

echo '<pre>';

$files = __DIR__ . '/files/file_list.json';

$db = new DB;

foreach ($file_list as $key => $value) {

  if(file_get_contents($value->file) != NULL) {
  $shakes =  addslashes(file_get_contents($value->file));
  $set = $value->set;

  $sql_del = 'INSERT into txt (`set`, `text`) values (?, ?)' ;
  $data = $db->conn->prepare($sql_del);
  $data->execute(array($set, $shakes));

  // var_dump($value->file); //DEBUG
  unlink($value->file);
  }

  unset($file_list[$key]);

  $json_file_contents = json_encode($file_list);

  file_put_contents($files,$json_file_contents);
}




// All done; we blank the PID file and explicitly release the lock
// (although this should be unnecessary) before terminating.
ftruncate($lock_file, 0);
flock($lock_file, LOCK_UN);


 ?>
