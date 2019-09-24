<?php
ini_set("display_errors",1);


include __DIR__."/include/include_all.php";
use Abraham\TwitterOAuth\TwitterOAuth;

echo '<pre>';
session_start();

$request_token = [];
$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];


$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);

$access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);

$_SESSION['access_token'] = $access_token;

unset($connection);

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

$user = $connection->get('account/verify_credentials', ['tweet_mode' => 'extended', 'include_entities' => 'true']);


$content = [
  'oauth_token' => $access_token['oauth_token'],
  'oauth_token_secret' => $access_token['oauth_token_secret'],
  'id' => $user->id
];

file_put_contents("files/tokens/".$user->screen_name.'.json',json_encode($content));
$db = new DB;

$sql_user = 'INSERT into user_data (`service`, `screenname`,`token`,
                                    `token_secret`) values
                                    ("twitter", ?, ?, ?)' ;
$data = $db->conn->prepare($sql_user);

$data_entry = [ $user->screen_name,
                $access_token['oauth_token'],
                $access_token['oauth_token_secret']
              ];

$data->execute($data_entry);


 ?>
