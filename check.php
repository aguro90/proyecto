 <?php
 require "security/security1.php";
 require "connections/connection2.php";
 
/* if(($_REQUEST['programacion']!="now") and ($_REQUEST['programacion']!="0 4 * * *") and ($_REQUEST['programacion']!="0 4 * * 1") and ($_REQUEST['programacion']!="0 4 15 * *") and ($_REQUEST['programacion']!="0 4 1,15 * *")) {
 		            	#hackerito detectado manipulando inputs
 		            	header("location:logout.php");

 	}
 	*/
 if( 
 (isset($_REQUEST['name']) and !empty($_REQUEST['name']))
 and
 (
  (isset($_REQUEST['coordenadas']) and $_REQUEST['coordenadas'] =="si") or
  (isset($_REQUEST['conhashtag']) and $_REQUEST['conhashtag'] =="si")
  )
  )
 #Si tenemos las variables que necesitamos vamos a identificar el tipo de tarea a crear
   {
 	#evaluamos los campos
 	
 	#solo hashtag sin interacciones
 	#insert into tasks VALUES(NULL,'test5',NULL,NULL,'#CCF',0,'0 0 * * *','273587264')
 	if(($_REQUEST['conhashtag'] =="si")and ($_REQUEST['coordenadas']!="si")and($_REQUEST['coninteracciones']!="si")) {
	#echo "quieres buscar por un hashtag sin tener en cuenta la ubicacion"; 

	#siempre guardamos la tarea , para llevar un control del numero de seguidores nuevos
	$stmt = $con2->prepare("insert into tasks values(NULL,?,NULL,NULL,NULL,?,0,?,?)");
    $stmt->bind_param('ssss', $_REQUEST['name'], $_REQUEST['hashtag'],$_REQUEST['programacion'],$_REQUEST['cuenta']);
    $stmt->execute();
    #printf("Error: %s.\n", $stmt->error);
			$id=mysqli_query($con2,"select id_task from tasks where name = '".$_REQUEST['name']."'");
			while($row = mysqli_fetch_array($id)){
			$id_task=	$row['id_task'];
			}
			#echo $id_task;
		#miramos si quiere ejecutarlo ahora o asignarlo en crontab	
		if($_REQUEST['programacion'] == "now") {

				echo "quieres buscar por un hashtag, sin interacciones, sin tener en cuenta la ubicacion y justo ahora"; 
				echo "ejecutando....";
				$salida = shell_exec("python /var/www/html/proyecto/twitter.py -id_task=".$id_task." -cuenta=".$_REQUEST['cuenta']." -hashtag=".$_REQUEST['hashtag']."");
				echo "<pre>$salida</pre>";
 			}else {
				echo "quieres buscar por un hashtag,sin interacciones, sin tener en cuenta la ubicacion y programado para ".$_REQUEST['programacion'].""; 
 		shell_exec("crontab -l > cron/crontmp");
 		$orden="echo \"".$_REQUEST['programacion']." python /var/www/html/proyecto/twitter.py -id_task=".$id_task." -cuenta=".$_REQUEST['cuenta']." -hashtag=".$_REQUEST['hashtag']."\" >> cron/crontmp";
 		shell_exec($orden);
 		shell_exec("crontab /var/www/html/proyecto/cron/crontmp");
 		shell_exec("rm /var/www/html/proyecto/cron/crontmp");
 		}
 	}
 	
 	#Hashtag e interacciones
 	#insert into tasks VALUES(NULL,'test5',NULL,NULL,'#CCF',1,'0 0 * * *','273587264')
 	if(($_REQUEST['conhashtag'] =="si")and ($_REQUEST['coordenadas']!="si")and($_REQUEST['coninteracciones']=="si")) {
	#echo "quieres buscar por un hashtag con interaccimes sin tener en cuenta la ubicacion"; 
	
	#siempre guardamos la tarea , para llevar un control del numero de seguidores nuevos
	$stmt = $con2->prepare("insert into tasks values(NULL,?,NULL,NULL,NULL,?,1,?,?)");
    $stmt->bind_param('ssss', $_REQUEST['name'], $_REQUEST['hashtag'],$_REQUEST['programacion'],$_REQUEST['cuenta']);
    $stmt->execute();
    #printf("Error: %s.\n", $stmt->error);
				$id=mysqli_query($con2,"select id_task from tasks where name = '".$_REQUEST['name']."'");
			while($row = mysqli_fetch_array($id)){
			$id_task=	$row['id_task'];
			}
		#miramos si quiere ejecutarlo ahora o asignarlo en crontab	
		if($_REQUEST['programacion'] == "now") {
				echo "quieres buscar por un hashtag con interacciones sin tener en cuenta la ubicacion y justo ahora"; 
				echo "ejecutando...";
				$salida = shell_exec("python /var/www/html/proyecto/twitter.py -id_task=".$id_task." -cuenta=".$_REQUEST['cuenta']." -hashtag=".$_REQUEST['hashtag']." -interacciones=SI");
				echo "<pre>$salida</pre>";
 			}else {
				echo "quieres buscar por un hashtag con interacciones sin tener en cuenta la ubicacion y programado para ".$_REQUEST['programacion'].""; 
 		shell_exec("crontab -l > cron/crontmp");
 		$orden="echo \"".$_REQUEST['programacion']." python /var/www/html/proyecto/twitter.py -id_task=".$id_task." -cuenta=".$_REQUEST['cuenta']." -hashtag=".$_REQUEST['hashtag']." -interacciones=SI\" >> cron/crontmp";
 		shell_exec($orden);
 		shell_exec("crontab /var/www/html/proyecto/cron/crontmp");
 		shell_exec("rm /var/www/html/proyecto/cron/crontmp"); 		
 		}
 	} 	
 #Solo coordenadas
 	if(($_REQUEST['coordenadas'] =="si")and ($_REQUEST['conhashtag']!="si")) {
	#echo "quieres buscar ubicacion sin tener en cuenta el hashtag"; 	
	#echo $_REQUEST['latitud'];
	#echo $_REQUEST['longitud'];
		#siempre guardamos la tarea , para llevar un control del numero de seguidores nuevos
	$stmt = $con2->prepare("insert into tasks values(NULL,?,?,?,?,NULL,0,?,?)");
    $stmt->bind_param('sssiss', $_REQUEST['name'], $_REQUEST['latitud'],$_REQUEST['longitud'],$_REQUEST['radio'],$_REQUEST['programacion'],$_REQUEST['cuenta']);
    $stmt->execute();
    #printf("Error: %s.\n", $stmt->error);
				$id=mysqli_query($con2,"select id_task from tasks where name = '".$_REQUEST['name']."'");
			while($row = mysqli_fetch_array($id)){
			$id_task=	$row['id_task'];
			}
	
	#miramos si quiere ejecutarlo ahora o crontab
		if($_REQUEST['programacion'] == "now") {
				echo "quieres buscar por un ubicacion sin tener en cuenta hashtag e interacciones y justo ahora"; 
				$salida= shell_exec("python /var/www/html/proyecto/twitter.py -cuenta=".$_REQUEST['cuenta']." -id_task=".$id_task." -lat=".$_REQUEST['latitud']." -lng=".$_REQUEST['longitud']." -radio=".$_REQUEST['radio']."");
 							echo "<pre>$salida</pre>";
 			}else {
				echo "quieres buscar por un ubicacion sin tener en cuenta hashtag e interacciones y programado para ".$_REQUEST['programacion'].""; 
  		shell_exec("crontab -l > cron/crontmp");
 		$orden="echo \"".$_REQUEST['programacion']." python /var/www/html/proyecto/twitter.py -cuenta=".$_REQUEST['cuenta']." -id_task=".$id_task." -lat=".$_REQUEST['latitud']." -lng=".$_REQUEST['longitud']." -radio=".$_REQUEST['radio']."\" >> cron/crontmp";
 		shell_exec($orden);
 		shell_exec("crontab /var/www/html/proyecto/cron/crontmp");
 		shell_exec("rm /var/www/html/proyecto/cron/crontmp"); 		
 		}
 	}
 
 #Coordenadas con hashtag sin interacciones
 # insert into tasks VALUES(NULL,'test4',34.00,6.00,'#CCF',0,'0 0 * * *','273587264')
 	if(($_REQUEST['conhashtag']=="si")and ($_REQUEST['coordenadas']=="si")and($_REQUEST['coninteracciones']!="si")) {
	#echo "quieres buscar por un hashtag con interaccimes sin tener en cuenta la ubicacion"; 
	
			#siempre guardamos la tarea , para llevar un control del numero de seguidores nuevos
	$stmt = $con2->prepare("insert into tasks values(NULL,?,?,?,?,?,0,?,?)");
    $stmt->bind_param('sssisss', $_REQUEST['name'], $_REQUEST['latitud'],$_REQUEST['longitud'],$_REQUEST['radio'],$_REQUEST['hashtag'],$_REQUEST['programacion'],$_REQUEST['cuenta']);
    $stmt->execute();
    #printf("Error: %s.\n", $stmt->error);
    	$id=mysqli_query($con2,"select id_task from tasks where name = '".$_REQUEST['name']."'");
			while($row = mysqli_fetch_array($id)){
			$id_task=	$row['id_task'];
			}
	
		#miramos si quiere ejecutarlo ahora o asignarlo en crontab	
		if($_REQUEST['programacion'] == "now") {
			echo "entraste. Tarea=".$id_task;
				echo "quieres buscar por un hashtag sin interacciones, ubicacion y justo ahora"; 
				$salida= shell_exec("python /var/www/html/proyecto/twitter.py -cuenta=".$_REQUEST['cuenta']." -id_task=".$id_task." -lat=".$_REQUEST['latitud']." -lng=".$_REQUEST['longitud']." -radio=".$_REQUEST['radio']." -hashtag=".$_REQUEST['hashtag']."");
				echo "<pre>$salida</pre>";
 			}else {
				echo "quieres buscar por un hashtag sin interacciones, ubicacion y programado para ".$_REQUEST['programacion'].""; 
 	  	shell_exec("crontab -l > cron/crontmp");
 		$orden="echo \"".$_REQUEST['programacion']." python /var/www/html/proyecto/twitter.py -cuenta=".$_REQUEST['cuenta']." -id_task=".$id_task." -lat=".$_REQUEST['latitud']." -lng=".$_REQUEST['longitud']." -radio=".$_REQUEST['radio']." -hashtag=".$_REQUEST['hashtag']."\" >> cron/crontmp";
 		shell_exec($orden);
 		shell_exec("crontab /var/www/html/proyecto/cron/crontmp");
 		shell_exec("rm /var/www/html/proyecto/cron/crontmp"); 
 		}
 	}

#Coordenadas hashtag e interacciones 	
# insert into tasks VALUES(NULL,'test4',34.00,6.00,'#CCF',1,'0 0 * * *','273587264')
 	if(($_REQUEST['conhashtag'] =="si")and ($_REQUEST['coordenadas']=="si")and($_REQUEST['coninteracciones']=="si")) {
	#echo "quieres buscar por un hashtag con interaccimes sin tener en cuenta la ubicacion"; 
	$stmt = $con2->prepare("insert into tasks values(NULL,?,?,?,?,?,1,?,?)");
    $stmt->bind_param('sssisss', $_REQUEST['name'], $_REQUEST['latitud'],$_REQUEST['longitud'],$_REQUEST['radio'],$_REQUEST['hashtag'],$_REQUEST['programacion'],$_REQUEST['cuenta']);
    $stmt->execute();
    #printf("Error: %s.\n", $stmt->error);
        	$id=mysqli_query($con2,"select id_task from tasks where name = '".$_REQUEST['name']."'");
			while($row = mysqli_fetch_array($id)){
			$id_task=	$row['id_task'];
			}
		#miramos si quiere ejecutarlo ahora o asignarlo en crontab	
		if($_REQUEST['programacion'] == "now") {
				echo "quieres buscar por un hashtag con interacciones y coordenadas  y justo ahora"; 
			   $salida= shell_exec("python /var/www/html/proyecto/twitter.py -cuenta=".$_REQUEST['cuenta']." -id_task=".$id_task." -lat=".$_REQUEST['latitud']." -lng=".$_REQUEST['longitud']." -radio=".$_REQUEST['radio']." -hashtag=".$_REQUEST['hashtag']." -interacciones=SI");
				echo "<pre>$salida</pre>";
 			}else {
				echo "quieres buscar por un hashtag con interacciones, ubicacion y programado para ".$_REQUEST['programacion'].""; 
		shell_exec("crontab -l > cron/crontmp");
 		$orden="echo \"".$_REQUEST['programacion']." python /var/www/html/proyecto/twitter.py -cuenta=".$_REQUEST['cuenta']." -id_task=".$id_task." -lat=".$_REQUEST['latitud']." -lng=".$_REQUEST['longitud']." -radio=".$_REQUEST['radio']." -hashtag=".$_REQUEST['hashtag']." -interacciones=SI\" >> cron/crontmp";
 		shell_exec($orden);
 		shell_exec("crontab /var/www/html/proyecto/cron/crontmp");
 		shell_exec("rm /var/www/html/proyecto/cron/crontmp"); 
 		}
 	}
 	
 header("location:tasks.php");
 	 	
  }else {
  	#Si no tiene el minimo de parametros necesarios
  	
  					    				?>
    								<html>
				<head>
				<title>Error al añadir</title>
				    <!-- Bootstrap Core CSS -->
  			  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

				    <!-- Custom CSS -->
 			   <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
				</head>
				<div class="row">
    <div class="col-md-2 col-md-offset-5"style="margin-top: 50px;"><div class="alert alert-danger" role="alert">
Error al insertar la tarea, al menos debe contener o una ubicacion o un hashtag
</div></div>
				</div>
				
				</html>
				
				<?php
  	
  	
 				header( "refresh:1;url=tasks.php" );
  	}
 
 ?>