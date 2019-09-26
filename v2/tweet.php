<?php
ini_set("display_errors",1);
ini_set('max_execution_time', 3600);
error_reporting(E_ALL);

$start_time = microtime(TRUE);


date_default_timezone_set('UTC');

include __DIR__."/include/include_all.php";

$markov = new Markov;
$db = new DB;


echo '<pre>';
$sql_userdata = 'SELECT * FROM user_data';
$data_sq = $db->conn->query($sql_userdata);
// $data_sq->setFetchMode(PDO::FETCH_ASSOC);
$user_data = $data_sq->fetchAll();

$pointer = array_rand($user_data);

use Abraham\TwitterOAuth\TwitterOAuth;
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $user_data[$pointer]["token"],  $user_data[$pointer]["token_secret"]);

  if($user_data[$pointer]["search"] != NULL) {
    $datasets = json_decode($user_data[$pointer]["search"]);
    // var_dump($datasets->datasets[array_rand($datasets->datasets)]); //DEBUG
    $set = $datasets->datasets[array_rand($datasets->datasets)];
    // var_dump($datasets); //DEBUG
} else { exit("No search set!");}

// $array_se = ['datasets' => [
// " Contos Eroticos, contoseroticos.com.br, sex, porn, portuguese"
//
//
// ],
//              'hashtags' => ["#safadinho", "porn", "#contoseroticos", "#contoerotico"]
// ];
//
// $array_json = json_encode($array_se);
// var_dump($array_json);

// exit;

$markov->set = $set;

// GET THE FREQUENCIMETER
$h_now = date("G");

if($h_now >= $user_data[$pointer]["time_in"] && $h_now <= $user_data[$pointer]["time_out"]) {
  $freq_rand = $user_data[$pointer]["freq_in"];
  echo "Time In <br>";
} else {
  echo "Time Out <br>";
  $freq_rand = $user_data[$pointer]["freq_out"];
}

if(rand(0,100) < $freq_rand) {
  echo "Time authorized";
  for ($i=0; $i < 10; $i++) {
    $status = $markov->generateText();
    if(strlen($status) > 10) break;
  }
  // var_dump($status); //DEBUG
  // exit; //DEBUG
  $statues = $connection->post("statuses/update", ["status" => $markov->generateText()]);
  var_dump($statues);

  $end_Time =  microtime(TRUE);

  $generic_data = json_encode(array('num_mkv_chains' => $markov->mkv_chains,
                                    'time' => ($end_Time - $start_time)
));

  $log = new DBOPS;
  $log->log_response($user_data[$pointer]["id"] ,json_encode($statues),$generic_data);

} else {
  exit("Freq DENIED");
}

 ?>
