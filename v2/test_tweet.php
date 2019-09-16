<?php
ini_set("display_errors",1);

include __DIR__."/include/include_all.php";

$json = json_decode(file_get_contents("files/tokens/yurisa2.json"));


use DG\Twitter\Twitter;

$twitter = new Twitter(CONSUMER_KEY, CONSUMER_SECRET, $json->oauth_token, $json->oauth_token_secret);


$envio = $twitter->send('Is the audience hearing?');

var_dump($envio);


 ?>
