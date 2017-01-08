<?php
/**
 * Causes Location
 *
 * @uses $vars['entity']
 */
$location = $vars['entity']->location;
$lat = '9.97626';
$long = '76.57918';
if($location){
			$url = 'http://maps.google.com/maps/geo?q='.urlencode($location).'&output=json&sensor=false'; 
			if($result = file_get_contents($url)) {
				$loc = json_decode($result); 
				$lat = $loc->Placemark[0]->Point->coordinates[1]; 
				$long = $loc->Placemark[0]->Point->coordinates[0]; 
			}			
		}
$content = '<div id="map_canvas" style="width: 400px; height: 200px"></div>';
echo elgg_view_module('aside', elgg_echo('causes:location'), $content);
?>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script>
         
		 function initialize_gmaps() {
			    var position = new google.maps.LatLng(<?php echo $lat ?>, <?php echo $long ?>);
                var center = new google.maps.LatLng(<?php echo $lat ?>, <?php echo $long ?>);
                var myOptions = {
                  zoom: 8,
                  center: center,
                  mapTypeId: google.maps.MapTypeId.ROADMAP,
                  disableDefaultUI: true,
                };
                var map = new google.maps.Map(
                        document.getElementById("map_canvas"),
                        myOptions);
                var infowindow = new google.maps.InfoWindow();
                var marker = new google.maps.Marker({
                        position: position,
                        map: map,
                        title:"<?php echo $location?>",
                        animation: google.maps.Animation.DROP,
                });  
                infowindow.open(map,marker); 
        }

      google.maps.event.addDomListener(window, 'load', initialize_gmaps);
    </script>
    
<?php
?>
