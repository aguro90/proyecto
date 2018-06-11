<?php

  require "security/security1.php";
require 'connections/connection2.php';
if(isset($_SESSION['id_account']) and !empty($_SESSION['id_account'])) {
$query = "SELECT date,number FROM followers where account_id = ".$_SESSION['id_account']."";
$result = mysqli_query($con2, $query);
$chart_data = '';
while($row = mysqli_fetch_array($result))
{
 $chart_data .= "{ date:'".$row["date"]."', followers:".$row["number"]."}, ";
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
                        <li class="activo">
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
        <!-- /Navigation -->

        <!-- Contenido aqui-->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Panel de Control</h1>
                </div>
                <!-- /.col-lg-12 -->


             <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i><?php session_start();if(isset($_SESSION['id_account']) and !empty($_SESSION['id_account'])) {echo " Numero de seguidores de la cuenta @".$_SESSION['screen_name'];} else{ echo "Aún no dispone de cuenta, añade una";}?>
                        <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Cuentas
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                    <?php
                                    if(isset($_SESSION['id_account']) and !empty($_SESSION['id_account'])) {
                                    $query1= "SELECT id_account,screen_name FROM accounts where user_id = ".$_SESSION['user_id']."";
												$result1 = mysqli_query($con2, $query1);
												while($row1 = mysqli_fetch_array($result1))
												{
 													echo "<li><a href='change_account.php?id_account=".$row1['id_account']."' >".$row1['screen_name']."</a></li>";
												}
												}else {
													echo "No hay datos disponibles";
													}
                                    ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
									                           <div id="linea"><?php  if(isset($_SESSION['id_account']) and empty($_SESSION['id_account'])) { echo "<p>No hay datos disponibles.</p>"; }?></div>
                        </div>

                        <!-- /.panel-body -->
                   
        </div>
        </div>
			</div>
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

<script>
Morris.Bar({
 element : 'linea',
 data:[<?php if (isset($chart_data) and !empty($chart_data)){echo $chart_data;} ?>],
 xkey:'date',
 ykeys:['followers'],
 labels:['followers'],
 hideHover:'auto',
 stacked:true
});
</script>
