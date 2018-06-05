    <?php
    echo "hola";
    $woeid = 2424766;
    $url= 'https://api.twitter.com/1.1/trends/place.json?id='.$woeid;
    $trends = $twitter->get($url);
    foreach ($trends[0]->trends as $trend) { 
            $trend->name; <br>         
 } ?>