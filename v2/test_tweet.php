<?php
ini_set("display_errors",1);

include __DIR__."/include/include_all.php";
$json = json_decode(file_get_contents("files/tokens/BengoWengo.json"));

use Abraham\TwitterOAuth\TwitterOAuth;
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $json->oauth_token, $json->oauth_token_secret);


$markov = new Markov;
$markov->set = ' lyrics, metal';

for ($i=0; $i < 10; $i++) {
  $status = $markov->generateText();
  if(strlen($status) > 10) break;
}

$statues = $connection->post("statuses/update", ["status" => $markov->generateText()]);


var_dump($statues);


 ?>
