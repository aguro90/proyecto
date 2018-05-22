<?php

session_start();
require 'autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

include  '../connections/connection2.php'

if (!isset($_SESSION['access_token'])) {
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
        $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
        $_SESSION['oauth_token'] = $request_token['oauth_token'];
        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
        $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
        //echo $url;
        echo "<a href='$url'><img src='twitter-login-blue.png' style='margin-left:4%; margin-top: 4%'></a>";
} else {
        $access_token = $_SESSION['access_token'];
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
        $user = $connection->get("account/verify_credentials", ['include_email' => 'true']);
//    $user1 = $connection->get("https://api.twitter.com/1.1/account/verify_credentials.json", ['include_email' => true]);
    echo "<img src='$user->profile_image_url'>";echo "<br>";            //profile image twitter link
    echo $user->name;echo "<br>";                                                                       //Full Name
    echo $user->location;echo "<br>";                                                           //location
    echo $user->screen_name;echo "<br>";                                                        //username
    echo $user->created_at;echo "<br>";
        echo $access_token['oauth_token_secret'];echo "<br>";
        echo $access_token['oauth_token'];echo "<br>";
//    echo $user->profile_image_url;echo "<br>";
    echo $user->email;echo "<br>";                                                                      //Email, note you need to check permission on Twitter App Dashboard and it will take$
    echo "<pre>";
    print_r($user);
    echo "<pre>";

<?
