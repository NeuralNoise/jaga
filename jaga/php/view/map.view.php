<?php

class MapView {

	public $html;

	public function __construct($channelID, $urlArray) {
		
		if ($_SESSION['channelKey'] == 'www') { $channelID = 0; }

		if ($urlArray[1] == 'k' && $urlArray[2] != '') { // => /map/k/<category>/
			$locations = Map::getContentMapArray($channelID, $urlArray[2], 100);
		} else {
			$locations = Map::getContentMapArray($channelID, '', 250); // => /map/
		}

		$channel = new Channel($channelID);
		$channelLatitude = 0;
		$channelLongitude = 0;
		
		$h = "<div class=\"container\">";
			$h .= "<div class=\"row\">";
				$h .= "<div class=\"col-xs-12\">";
					$h .= "<div id=\"map-canvas\" class=\"jaga-map-canvas\" style=\"height:500px;\"></div>";
				
					$h .= "
					<script type=\"text/javascript\">
						var locations = [\n";
					
					foreach ($locations AS $contentID) {
						$content = new Content($contentID);
						$domain = "";
						$channel = new Channel($content->channelID);
						if ($content->channelID != $_SESSION['channelID']) { $domain = "http://" . $channel->channelKey . ".jaga.io"; }
						
						$h .= "\t['<div class=\"googleMapMarkerContainer\">";
						$h .= "<a href=\"" . $domain . "/k/" . $content->contentCategoryKey . "/" . $content->contentURL . "/\">" . addslashes($content->getTitle()) . "</a>";
						$h .= "</div>', " . $content->contentLatitude . ", " . $content->contentLongitude . "],\n";
					}
					
					$h .= "
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
					
				$h .= "</div>";
			$h .= "</div>";
		$h .= "</div>";
		
		$this->html = $h;

	}

}

?>