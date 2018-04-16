<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">


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
  document.getElementById('lati').innerHTML = [
    latLng.lat()
  ];
  document.getElementById('longi').innerHTML = [
    latLng.lng()
  ];
}

function updateMarkerAddress(str) {
  document.getElementById('address').innerHTML = str;
}




function initialize(radio) { 

  var latLng = new google.maps.LatLng(37.89995,-4.753081);
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
  if (radio === undefined) {
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
</head>
<body>
  <style>
  #mapCanvas {
    width: 500px;
    height: 400px;
    float: left;
  }
  #infoPanel {
    float: left;
    margin-left: 10px;
  }
  #infoPanel div {
    margin-bottom: 5px;
  }
  </style>

  <div id="mapCanvas"></div>
  <div id="infoPanel">
    <b>Marker status:</b>
    <div id="markerStatus"><i>Click and drag the marker.</i></div>
    <b>Current position:</b>
    <div id="lati"><b>Latitud : </b></div>
    <div id="longi"><b>Longitud : </b></div>
    <b>Closest matching address:</b>
    <div id="address"></div>

    
   Radio:<br /> 
   <select name="radio" id="radio">    
       <option value="1000" selected="selected">1 KM</option>
       <option value="2000">2 KM</option>
       <option value="3000">3 KM</option>
   </select>
   
   <button onclick="initialize(document.getElementById('radio').value,document.getElementById('lati').value,document.getElementById('longi').value);">Pincha</button>
  </div>
 <p id="demo"></p>

 </body>
</html>