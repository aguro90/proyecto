<!DOCTYPE html>
<html lang="en">
<?php
require "connections/connection1.php";
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Twitter Geo Project</title>


    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<script>
function myerror() {
    alert("Login failed...");
}
</script>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST" action="login.php">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                                    <?php

                                    if (isset($_REQUEST['username']) and empty($_REQUEST['username'])) 
                                        {
                                            echo '<div style="color:red;">Debes introducir un usuario</div>';
                                        }


                                    ?>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                    <?php

                                    if (isset($_REQUEST['password']) and empty($_REQUEST['password'])) 
                                        {
                                            echo '<div style="color:red;">Debes introducir una contraseña</div>';
                                        }


                                    ?>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Login">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php

if (isset($_POST['password']) and !empty($_POST['password']) and isset($_POST['username']) and !empty($_POST['username']) ){

    $username = $_POST['username'];
    $password = md5($salt.$_POST['password']);
    $user_id = "";

    $stmt = $con->prepare("SELECT user_id, username, password FROM users WHERE username=? AND password=? LIMIT 1");
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $stmt->bind_result($user_id, $username, $password);
    $stmt->store_result();
    if($stmt->num_rows == 1)  //To check if the row exists
        {
            if($stmt->fetch()) //fetching the contents of the row
            {
                   session_start();
                   $_SESSION['Logged'] = 1;
                   $_SESSION['user_id'] = $user_id;
                   $_SESSION['username'] = $username;
                   header("location:index.php");
						exit();
               }
           }
            else{
                echo "<script type=\"text/javascript\"> myerror(); </script>";
                }

    }
   
    $stmt->close();


$con->close();
?>



</body>

</html>
