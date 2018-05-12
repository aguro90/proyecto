<?php
$con = mysqli_connect("127.0.0.1", "twitter_users", "twitter.users1@", "twitter");

if (!$con) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

//salt
$salt="nmxdklsdnmdhj383";
?>