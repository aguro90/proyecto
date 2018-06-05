
<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">

function myFunction(e) {
    document.getElementById("programacion").value = e.target.value
}
function myFunction1(e) {
    document.getElementById("cuenta").value = e.target.value
}

var geocoder = new google.maps.Geocoder();


function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      updateMarkerAddress(responses[0].formatted_address);
    } else {
      updateMarkerAddress('Cannot determine address at this location.');
    }
  });
}

function updateMarkerStatus(str) {
  document.getElementById('markerStatus').innerHTML = str;
}

function updateMarkerPosition(latLng) {

    document.getElementById('lat').value = [
    latLng.lat()
  ];


  document.getElementById('lng').value = [
    latLng.lng()
  ];
}

function updateMarkerAddress(str) {
  document.getElementById('address').innerHTML = str;
}




function initialize(radio,lat,lng) { 


if (typeof radio !== 'number'){
  radio=1000;
};



if (typeof lat !== 'number'){
  lat=37.89995;
};



if (typeof lng !== 'number'){
  lng= "-4.753081";
};



  var latLng = new google.maps.LatLng(lat,lng);
  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
    zoom: 13,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  var marker = new google.maps.Marker({
    position: latLng,
    title: 'Point A',
    map: map,
    draggable: true
  });
  if (radio != 2000 && radio !=3000) {
        radio = 1000;
    } 
  var circle = new google.maps.Circle({
  map: map,
  radius: parseFloat(radio),
  fillColor: '#AA0000'
});
circle.bindTo('center', marker, 'position');

  // Update current position info.
  updateMarkerPosition(latLng);
  geocodePosition(latLng);

  // Add dragging event listeners.
  google.maps.event.addListener(marker, 'dragstart', function() {
    updateMarkerAddress('Dragging...');
  });

  google.maps.event.addListener(marker, 'drag', function() {
    updateMarkerStatus('Dragging...');
    updateMarkerPosition(marker.getPosition());
  });

  google.maps.event.addListener(marker, 'dragend', function() {
    updateMarkerStatus('Drag ended');
    geocodePosition(marker.getPosition());
  });
    
}

// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize);


</script>

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
    
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
</head>

<style>
* {
  box-sizing: border-box;
}

.activo{background: darkgray;};

body {
  background-color: #f1f1f1;
}

#regForm {
  background-color: #ffffff;
  font-family: Raleway;
  padding: 40px;
  width: 70%;
  min-width: 300px;
}
 #mapCanvas {
    width: 300px;
    height: 300px;
    float: left;
  }
  #infoPanel {
    float: left;
    margin-left: 10px;
  }
 
h1 {
  text-align: center;  
}

input {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
}

/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #ffdddd;
}

/* Hide all steps by default: */
.tab {
  display: none;
}

.boton {
  background-color: #4CAF50;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  font-size: 17px;
  font-family: Raleway;
  cursor: pointer;
}

.boton:hover {
  opacity: 0.8;
}

#prevBtn {
  background-color: #bbbbbb;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;  
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #4CAF50;
}
</style>
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
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
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
                            <a href="cuentas.php"><i class="fa fa-table fa-fw"></i> Cuentas</a>
                        </li>
                        <li class="activo">
                            <a href="tasks.php"><i class="fa fa-edit fa-fw"></i> Tareas</a>
                        </li>
                       
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <!-- /Navigation -->
                <div id="page-wrapper">
        <div class="row">
<form id="regForm" action="check.php">
  <h1>Nueva Tarea:</h1>
  <!-- One "tab" for each step in the form: -->
	<div class="tab"><b>Información de la tarea:</b>
    <p><input placeholder="Nombre..." name="name"></p>
       <p> <label for="programacion">Programación de la tarea:</label>
    <select  class="form-control" id="select" onchange="myFunction(event)">
      <option value="now">Ahora</option>
      <option value="0 4 * * *">Cada Dia</option>
      <option value="0 4 * * 1">Cada Semana</option>
      <option value="0 4 15 * *">Una vez al mes</option>
      <option value="0 4 1,15 * *">Dos veces al mes</option>
    </select></p>
 	<p><input id="programacion" name="programacion" value="now" readonly="readonly"></p>
 	<p> <label for="cuenta">Cuenta :</label>
    <select class="form-control" id="select" onchange="myFunction1(event)">
    	<option value="" selected="selected" disabled="disabled">Selecciona</option>
<?php
												require ('connections/connection2.php');
												session_start();
												echo $_SESSION['user_id'];
                                    if(isset($_SESSION['id_account']) and !empty($_SESSION['id_account'])) {
                                    $query1= "SELECT id_account,screen_name FROM accounts where user_id = ".$_SESSION['user_id']."";
												$result1 = mysqli_query($con2, $query1);
												while($row1 = mysqli_fetch_array($result1))
												{
 													echo "<option>".$row1['screen_name']."</option>";
												}
												}else {
													echo "<option disabled=\"disabled\">No hay datos disponibles</option>";
													}
                                    ?>
    </select></p>
 	<p><input id="cuenta" name="cuenta" disabled="disabled"value=""></p>
    
  </div>
  <div class="tab"><p>Mapa:</p>
      <div id="mapCanvas"></div>
  <div id="infoPanel">
    <div id="markerStatus" style="display: none;"><i>Click and drag the marker.</i></div>
    <p><b>Posición actual:</b></p>
     <p><b>Latitud</b></p>
     <input id="lat" name="latitud" value="" readonly="readonly"></p>
     <p><b>Longitud</b></p>
     <input id="lng" name="longitud" value="" readonly="readonly"></p>
    <b>Dirección más cercana:</b>
    <div id="address"></div></p>
     
   <p><b>Radio:<br></b>
   <select name="radio" id="radio">    
       <option value="1000" selected="selected">1 KM</option>
       <option value="2000">2 KM</option>
       <option value="3000">3 KM</option>
   </select>
   <button type="button" onclick="initialize(parseInt(document.getElementById('radio').value),parseFloat(document.getElementById('lat').value),parseFloat(document.getElementById('lng').value));">Pincha</button>
</p>
<p>

 <b>Utilizar estas coordenadas :</b> <input type="checkbox" name="coordenadas" value="si">
  
  </p>
  
  </div>
  </div>
  <div class="tab">Hashtag:
    <p><input  name="hashtag" value="#hashtag"></p>
 <b>Utilizar este hashtag :</b> <input type="checkbox" name="conhashtag" value="si">
  <b>Utilizar interacciones de este hashtag :</b> <input type="checkbox" name="coninteracciones" value="si">
  </div>
  </div>
  <div class="row">
  <div style="overflow:auto;text-align: center;">
    <div>
      <button class="boton" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button class="boton" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
    </div>
  </div>
  <!-- Circles which indicates the steps of the form: -->
  <div style="text-align:center;margin-top:20px;">
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
  </div>
</form>

</div>
</div>
 <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
   <script src="dist/js/sb-admin-2.js"></script> 
   
<script>
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the crurrent tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}
</script>

</body>
</html>
