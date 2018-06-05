<?php

session_start();
require 'autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
define('CONSUMER_KEY', '0NLqf3W3RusCKFfk2cj1NAXVl'); 	// add your app consumer key between single quotes
define('CONSUMER_SECRET', '2JLKstfcDXpZTpbRFUHk9khe64N9JHDI8eStNhKPGCtF5nnKoB'); // add your app consumer 																			secret key between single quotes
define('OAUTH_CALLBACK', 'http://autocm.sytes.net/twitter/callback.php'); // your app callback URL i.e. page 																			you want to load after successful 																			  getting the data
if (!isset($_SESSION['access_token'])) {
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
	$_SESSION['oauth_token'] = $request_token['oauth_token'];
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
	$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
	//echo $url;
}

