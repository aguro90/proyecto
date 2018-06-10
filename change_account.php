<?php
session_start();
require 'connections/connection2.php';
require 'security/security1.php';
if(!isset($_REQUEST['id_account'])) {
		            	header("location:logout.php");
	}
    $stmt = $con2->prepare("SELECT id_account,screen_name FROM accounts WHERE id_account=? AND user_id=? LIMIT 1");
    $stmt->bind_param('ii', $_REQUEST['id_account'], $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($id_account,$screen_name);
    $stmt->store_result();
    if($stmt->num_rows == 1)  //To check if the row exists
        {
            if($stmt->fetch()) //fetching the contents of the row
            {
            	$_SESSION['screen_name']=$screen_name;
                  $_SESSION['id_account']=$id_account;
                  header("location:index.php");
						exit();
            	}else {
	            	header("location:logout.php");
            		}
            	}
?>