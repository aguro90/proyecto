<?php

session_start();
if ($_SESSION['Logged'] != 1){

header("location:login.php");

};


?>
