 <?php

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
 	if(($_REQUEST['conhashtag'] =="si")and ($_REQUEST['coordenadas']!="si")) {
	#echo "quieres buscar por un hashtag sin tener en cuenta la ubicacion"; 
		#miramos si quiere ejecutarlo ahora o asignarlo en crontab	
		if($_REQUEST['programacion'] == "now") {
				echo "quieres buscar por un hashtag sin tener en cuenta la ubicacion y justo ahora"; 
 			}else {
				echo "quieres buscar por un hashtag sin tener en cuenta la ubicacion y programado para ".$_REQUEST['programacion'].""; 
 		}
 	}
 	 	if(($_REQUEST['coordenadas'] =="si")and ($_REQUEST['conhashtag']!="si")) {
	#echo "quieres buscar ubicacion sin tener en cuenta el hashtag"; 	
	#miramos si quiere ejecutarlo ahora o crontab
		if($_REQUEST['programacion'] == "now") {
				echo "quieres buscar por un ubicacion sin tener en cuenta hashtag y justo ahora"; 
 			}else {
				echo "quieres buscar por un ubicacion sin tener en cuenta hashtag y programado para ".$_REQUEST['programacion'].""; 
 		}
 	}
 
  }else {
  	#Si no tiene el minimo de parametros necesarios
  	echo "tienes que asignar un nombre y coordenadas o hashtag o los dos";
  	}
 
 ?>