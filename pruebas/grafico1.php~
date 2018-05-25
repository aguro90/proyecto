<?php
  require "../connections/connection2.php";
$dias=array();
$followers=array();
$sth = mysqli_query($con,"select date,number from followers where account_id = 273587264 limit 30");

        while($row = mysqli_fetch_array($sth))
  {
  	array_push($dias,$row['date']);
  	array_push($followers,$row['number']);
  } 
  ?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Tráfico mensual</title>
 
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="http://code.highcharts.com/highcharts.js"></script>
        <script type="text/javascript">
$(function () {
    $('#linea').highcharts({
        chart: {
            type: 'line',  // tipo de gráfica
            borderWidth: 0 // ancho del borde de la gráfica
        },
        title: {
            text: 'Numero de seguidores de la cuenta', // título
            x: -20 
        },
        
        xAxis: {
            categories: [<?php   
             $n=0;
  foreach ($dias as $dia){
  	if($n==0) {
  echo "'".$dia."'";
  $n++;
  }else {
  	echo ",'".$dia."'";
  	$n++;
  }
  } ?>] // categorías
        },
        yAxis: {
            title: {
                text: 'Número de seguidores' // nombre del eje de Y
            },
            plotLines: [{
                color: '#808080' 
            }]
        },
        legend: { // configuración de la leyenda
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom',
            borderWidth: 1
        },
        series: [{ // configuración de las series
            name: 'Seguidores',
            data: [<?php   $n=0;
  foreach ($followers as $follower){
  	if($n==0) {
  echo $follower;
  $n++;
  }else {
  	echo ",".$follower;
  	$n++;
  }
  } ?>]
        }]
    });
         
        $(document).ready(function() {
            Highcharts.setOptions({
                global: {
                    useUTC: false
                }
            });
        });
    });
     
 
        </script>
    </head>
    <body>
        <!-- div que contendrá la gráfica lienal -->
        <div id="linea" style="width: 50%; height: 350px; margin: 0 auto;float:left;"></div>
    </body>
</html>