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
	
		#miramos si quiere ejecutarlo ahora o asignarlo en crontab	
		if($_REQUEST['programacion'] == "now") {
				echo "quieres buscar por un hashtag con interacciones sin tener en cuenta la ubicacion y justo ahora"; 
 			}else {
				echo "quieres buscar por un hashtag con interacciones sin tener en cuenta la ubicacion y programado para ".$_REQUEST['programacion'].""; 
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

	
	#miramos si quiere ejecutarlo ahora o crontab
		if($_REQUEST['programacion'] == "now") {
				echo "quieres buscar por un ubicacion sin tener en cuenta hashtag e interacciones y justo ahora"; 
 			}else {
				echo "quieres buscar por un ubicacion sin tener en cuenta hashtag e interacciones y programado para ".$_REQUEST['programacion'].""; 
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
	
		#miramos si quiere ejecutarlo ahora o asignarlo en crontab	
		if($_REQUEST['programacion'] == "now") {
				echo "quieres buscar por un hashtag sin interacciones, ubicacion y justo ahora"; 
 			}else {
				echo "quieres buscar por un hashtag sin interacciones, ubicacion y programado para ".$_REQUEST['programacion'].""; 
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
		#miramos si quiere ejecutarlo ahora o asignarlo en crontab	
		if($_REQUEST['programacion'] == "now") {
				echo "quieres buscar por un hashtag con interacciones y coordenadas  y justo ahora"; 
 			}else {
				echo "quieres buscar por un hashtag con interacciones, ubicacion y programado para ".$_REQUEST['programacion'].""; 
 		}
 	}
 	
 #header("location:tasks.php");
 	 	
  }else {
  	#Si no tiene el minimo de parametros necesarios
  	echo "tienes que asignar un nombre y coordenadas o hashtag o los dos";
  	}
 
 ?>