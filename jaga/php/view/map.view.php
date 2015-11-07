<?php

class MapView {

	public $html;

	public function __construct($channelID, $urlArray) {
		
		if ($urlArray[1] == 'k' && $urlArray[2] != '') { // => /map/k/<category>/
			$locations = Map::getContentMapArray($channelID, $urlArray[2], 100);
		} else {
			$locations = Map::getContentMapArray($channelID, '', 100); // => /map/
		}
		
		$channel = new Channel($channelID);
		$channelLatitude = 0;
		$channelLongitude = 0;
		
		$html = "<div class=\"container\">";
			$html .= "<div class=\"row\">";
				$html .= "<div class=\"col-xs-12\">";
					$html .= "<div id=\"map-canvas\" class=\"jaga-map-canvas\" style=\"height:500px;\"></div>";
				
					$html .= "
					<script type=\"text/javascript\">
						var locations = [";
					
					foreach ($locations AS $contentID) {
						$content = new Content($contentID);
						$html .= "\t\t\t\t\t\t['<div class=\"googleMapMarkerContainer\">";
						$html .= "<a href=\"/k/" . $content->contentCategoryKey . "/" . $content->contentURL . "/\">" . addslashes($content->getTitle()) . "</a>";
						$html .= "</div>', " . $content->contentLatitude . ", " . $content->contentLongitude . "],\n";
					}
					
					$html .= "
						];

						var mapOptions = {
							zoom: 8,
							scrollwheel: false,
							center: new google.maps.LatLng(" . $channelLatitude . "," . $channelLongitude . "),
							mapTypeId: google.maps.MapTypeId.ROADMAP
						};
						map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
						var infowindow = new google.maps.InfoWindow(maxWidth=400);
					
							var marker, i;
							var bounds = new google.maps.LatLngBounds();
							
							for (i = 0; i < locations.length; i++) {  
							  marker = new google.maps.Marker({
								position: new google.maps.LatLng(locations[i][1], locations[i][2]),
								map: map
							  });
							  google.maps.event.addListener(marker, 'click', (function(marker, i) {
								return function() {
								  infowindow.setContent(locations[i][0]);
								  infowindow.open(map, marker);
								}
							  })(marker, i));
						
							if (locations[i][1] > 0) { bounds.extend(marker.position); }
							map.fitBounds(bounds); 
							
							}
					</script>
					";
					
				$html .= "</div>";
			$html .= "</div>";
		$html .= "</div>";
		
		$this->html = $html;

	}

}

?>