<?php
  require "security/security1.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Auto CM Project</title>

    <style>
    .activo{background: darkgray;};
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
                        <li><a href="settings.php"><i class="fa fa-gear fa-fw"></i> Settings</a>
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
                        <li >
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="accounts.php"><i class="fa fa-table fa-fw"></i> Cuentas</a>
                        </li>
                        <li  class="activo">
                            <a href="tasks.php"><i class="fa fa-edit fa-fw"></i> Tareas</a>
                        </li>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <!-- /Navigation -->
        <!-- Contenido aqui-->
        <div id="page-wrapper">
        
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Acciones
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                    <li><a href="form.php">Añadir Tarea</a></li>
                                    </ul>
                                </div>
                            </div>
                            <strong>Tareas de tus cuentas:</strong>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Cuenta</th>
                                            <th>Latitud</th>
                                            <th>Longitud</th>
                                            <th>Hashtag</th>
                                            <th>Interacciones con Hashtag</th>                                            
                                            <th>Programación</th>
                                            <th>Encontrados</th>
	                                         <th>Borrar</th>													

                                        </tr>
                                    </thead>
                                    <tbody>

                                         <?php
                                         require 'connections/connection2.php';
                                    $query1= "SELECT tasks.id_task,accounts.screen_name,tasks.name,tasks.latitude,tasks.length,tasks.hashtag,tasks.interacciones,tasks.schedule FROM tasks,accounts WHERE tasks.id_account=accounts.id_account and accounts.user_id = ".$_SESSION['user_id'].";";
												$result1 = mysqli_query($con2, $query1);
												if (mysqli_num_rows($result1)!= 0){
												while($row1 = mysqli_fetch_array($result1))
												{
												$query2= "SELECT count(*) FROM followed_tasks WHERE id_task=".$row1['id_task']."";
												$result2 = mysqli_query($con2, $query2);
												$number=mysqli_fetch_array($result2);
													if($row1['latitude']=="") {$row1['latitude']="No definido";}
													if($row1['length']=="") {$row1['length']="No definido";}
													if($row1['hashtag']=="") {$row1['hashtag']="No definido";}
													if($row1['interacciones']==0) {$row1['interacciones']="NO";}
													if($row1['interacciones']==1) {$row1['interacciones']="SI";}																																								
 													echo "<tr><td>".$row1['name']."</td><td>".$row1['screen_name']."</td><td>".$row1['latitude']."</td><td>".$row1['length']."</td><td>".$row1['hashtag']."</td><td>".$row1['interacciones']."</td><td>".$row1['schedule']."</td><td>".$number[0]."</td><td><a href=delete_task.php?id_task=".$row1['id_task']."><i class=\"fa fa-trash\"></i></a></td></tr>";
												
												}
												}else {
													echo "<tr><td></td><td>No tiene ninguna tarea creada</td><td></td><td></td><td></td><td></td><td></td></tr>";
													}
							
                                    ?>
                                    </tbody>

                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
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
   
</body>

</html>
        
        