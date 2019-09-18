<?php
ini_set("display_errors",1);

include __DIR__."/include/include_all.php";

$json = json_decode(file_get_contents("files/tokens/BengoWengo.json"));


use DG\Twitter\Twitter;

$twitter = new Twitter(CONSUMER_KEY, CONSUMER_SECRET, $json->oauth_token, $json->oauth_token_secret);

$markov = new Markov;

// var_dump($markov->generateText());
// exit;

$envio = $twitter->send($markov->generateText());

var_dump($envio);


 ?>
