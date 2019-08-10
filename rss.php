<?php

 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);

 // REFACTOR WITH INCLUDES


require_once($prefix_path.'rssbot.php');

$oTwitterBot = new RssBot(array(
    'sUsername'     => 'BengoWengo',
    'sUrl'          => 'http://www.easypath.com.br/feed/',
	'sFeedFormat'	=> 'json',
    'sLastRunFile'  => 'rss-last.json',

    'sTweetFormat'  => ':title :link',

    'aTweetVars'    => array(
        array('sVar' => ':title', 'sValue' => 'title', 'bTruncate' => TRUE),

        array('sVar' => ':link', 'sValue' => 'permalink', 'sPrefix' => 'http://www.easypath.com.br'),

        array('sVar' => ':source', 'sValue' => 'url', 'bAttachImage' => TRUE),

    ),


    'sTimestampField' => 'created',
));


echo "<pre>";
var_dump($oTwitterBot);

$oTwitterBot->run();
