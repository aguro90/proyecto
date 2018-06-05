<?php

session_start();
require 'autoload.php';
require '../security/security2.php';
use Abraham\TwitterOAuth\TwitterOAuth;

define('CONSUMER_KEY', '0NLqf3W3RusCKFfk2cj1NAXVl');    // add your app consumer key between single quotes
define('CONSUMER_SECRET', '2JLKstfcDXpZTpbRFUHk9khe64N9JHDI8eStNhKPGCtF5nnKoB'); // add your app consumer


include  '../connections/connection2.php';

if (isset($_SESSION['access_token'])) {
        $access_token = $_SESSION['access_token'];
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
        $user = $connection->get("account/verify_credentials", ['include_email' => 'true']);
//    $user1 = $connection->get("https://api.twitter.com/1.1/account/verify_credentials.json", ['include_email' => true]);
//echo "<img src='$user->profile_image_url'>";echo "<br>";            //profile image twitter link
    $id = $user->id;
    $name = $user->name;                                                                       //Full Name
    $screen_name = $user->screen_name;                                                        //username
    $secret = $access_token['oauth_token_secret'];
    $token = $access_token['oauth_token'];
	$followers = $user->followers_count;
	if (isset($id)){
	$stmt = $con2->prepare("SELECT id_account  FROM accounts WHERE id_account=? LIMIT 1");
    	$stmt->bind_param('s', $id);
    	$stmt->execute();
    	$stmt->bind_result($comp);
    	$stmt->store_result();
		if($stmt->num_rows == 0){
				//echo "Insertando...<br>";
					$stmt = $con2->prepare("INSERT INTO accounts values(?,?,?,now(),?,?,?)");
					//echo $id;echo "<br>";
    				$stmt->bind_param('issssi', $id,$screen_name,$name,$token,$secret,intval($_SESSION['user_id']));
    				
    				//echo $stmt;
    				$stmt->execute();
    				
    				mysqli_query($con2,"insert into followers values (".$id.",now(),".$followers." )");
    				unset($_SESSION['access_token']);
    				?>
    								<html>
				<head>
				<title>Error al añadir</title>
				    <!-- Bootstrap Core CSS -->
  			  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

				    <!-- Custom CSS -->
 			   <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
				</head>
				<div class="row">
    <div class="col-md-2 col-md-offset-5"style="margin-top: 50px;"><div class="alert alert-success" role="alert">
  Éxito al insertar
</div></div>
				</div>
				
				</html>
				
				<?php
				header( "refresh:1;url=../cuentas.php" );
		}else{
				//header( "refresh:5;url=../logout.php" );
				
				    				?>
    								<html>
				<head>
				<title>Error al añadir</title>
				    <!-- Bootstrap Core CSS -->
  			  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

				    <!-- Custom CSS -->
 			   <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
				</head>
				<div class="row">
    <div class="col-md-2 col-md-offset-5"style="margin-top: 50px;"><div class="alert alert-danger" role="alert">
Error al insertar , esa cuenta ya está en la aplicación.
</div></div>
				</div>
				
				</html>
				
				<?php
				
				
				
				
							  unset($_SESSION['access_token']);
				header( "refresh:1;url=../cuentas.php" );
				}

}

}
?>
