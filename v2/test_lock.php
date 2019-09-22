<?php
ini_set("display_errors",1);
ini_set('max_execution_time', 30);
ini_set('memory_limit', '2048M');
error_reporting(E_ALL);

include __DIR__."/include/include_all.php";

$lock_location = __DIR__.'/files/lock_test.pid';


echo '<pre>';



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

/*
    The main body of your script goes here.




*/

sleep(10);

echo "Hello, world!";

unlink($lock_location);


?>
