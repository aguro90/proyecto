<?php

  require "security/security1.php";
	require "connections/connection2.php";
if(isset($_REQUEST['seguidores']) and !empty($_REQUEST['seguidores']) ) {
	$sql="update users set max_per_day = ".$_REQUEST['seguidores']." where user_id = ".$_SESSION['user_id']."";
	mysqli_query($con2,$sql);
	}
if(isset($_REQUEST['dias']) and !empty($_REQUEST['dias'])) {
	$sql="update users set check_after = ".$_REQUEST['dias']." where user_id = ".$_SESSION['user_id']."";
	mysqli_query($con2,$sql);
	}
if(isset($_REQUEST['username']) and isset($_REQUEST['pass']) and isset($_REQUEST['pass1']) and !empty($_REQUEST['username']) and !empty($_REQUEST['pass']) and !empty($_REQUEST['pass1'])) {
	if($_REQUEST['pass']==$_REQUEST['pass1']) {
		$sql="insert into users values (NULL,".$_REQUEST['username'].",".md5($salt,$_REQUEST['pass']).",10,3)";	
		mysqli_query($con2,$sql);
		$_SESSION['confirmar']=1;
		}else {
		$_SESSION['confirmar']=0;
			}
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Auto CM Project</title>

    <style>
#Form {
  background-color: #ffffff;
  font-family: Raleway;
  padding: 40px;
  width: 70%;
  min-width: 300px;
}

    input {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
}
.btn{
margin-top: 10px;

}

    </style>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Morris Charts CSS -->
    <link href="vendor/morrisjs/morris.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;background: #0d2737">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">AUTO CM </a><i class="fa fa-twitter" style="font-size:36px;margin-top: 5px;color: #1da1f2;"></i>
            </div>
            <!-- /.navbar-header derecha -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation" style="background: aliceblue;">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="accounts.php"><i class="fa fa-table fa-fw"></i> Cuentas</a>
                        </li>
                        <li>
                            <a href="tasks.php"><i class="fa fa-edit fa-fw"></i> Tareas</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <?php
			require "connections/connection1.php";        
        $result=mysqli_query($con,"select max_per_day,check_after from users where user_id = ".$_SESSION['user_id']."");
        $row=mysqli_fetch_array($result);
        ?>
        <div id="page-wrapper">
         <div class="row">
				<form class="form-group" style="margin-top: 30px;" action="#">		
					<label>Maximo de seguidores por dia: 
					<input  name="seguidores" value="<?php echo $row[0]  ?>">		
					<button type="submit" class="btn btn-default">Actualizar</button>
					</label>
				</form>
        </div>
       <hr>
        <div class="row">
				<form class="form-group" style="margin-top: 30px;" action="#">		
					<label>Dias a esperar para comprobar Follow Back: 
					<input  name="dias" value="<?php echo $row[1]  ?>">		
					<button type="submit" class="btn btn-default">Actualizar</button>
					</label>
				</form>
        </div>
               <hr>
        <div class="row">
          <h1>Nuevo Usuario:</h1>
				<form class="form-group" style="margin-top: 30px;" action="#">		
					<label>Nuevo Nombre de Usuario: 
					<input  name="username">		
					<label>Contraseña</label>
					<input  name="pass" type="password">
					<?php 
					if($_SESSION['confirmar']==1) {echo "<p style=\"color=green\"> Exito al insertar</p>";}					
					if($_SESSION['confirmar']==0) {echo "<p style=\"color=red\"> Fallo al insertar</p>";}					
					?>		
					<label>Repite Contraseña</label>
					<input  name="pass1" type="password">	
					<?php 
					if($_SESSION['confirmar']==1) {echo "<p style=\"color=green\"> Exito al insertar</p>";}					
					if($_SESSION['confirmar']==0) {echo "<p style=\"color=red\"> Fallo al insertar</p>";}					
					?>	
					<button type="submit" class="btn btn-default">Añadir Usuario</button>	
					</label>

				</form>
        </div>
        </div>


    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
   <script src="dist/js/sb-admin-2.js"></script> 
   
       <!-- Morris Charts JavaScript -->
    <script src="vendor/raphael/raphael.min.js"></script>
    <script src="vendor/morrisjs/morris.min.js"></script>



</body>
</html>
        
        
        