<?php

class CarouselView {

	public function getCarousel($urlArray) {
	
		$html = "\t\t<div class=\"container\" style=\"margin-bottom:20px;\">
			<div id=\"kutchannel-carousel\" class=\"carousel slide\" data-ride=\"carousel\">\n";

			$html .= "
			
				<!-- START SLIDES -->\n\n";
				
				if ($_SESSION['channelKey'] == 'www') { // jaga.io
					$html .= "\t\t\t\t<div class=\"carousel-inner\">
						<div class=\"item active\"><a href=\"http://hakodate.jaga.io/\"><img src=\"/jaga/images/carousel-hakodate-goryokaku.jpg\" alt=\"test0\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						<div class=\"item\"><a href=\"http://kagi.io/\"><img src=\"/jaga/images/carousel-zenidev.jpg\" alt=\"test1\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						<div class=\"item\"><a href=\"http://kids.jaga.io/\"><img src=\"/jaga/images/carousel-ballpit.jpg\" alt=\"test2\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
					</div>\n\n";
				} elseif ($_SESSION['channelKey'] == 'niseko') { // The Kutchannel
					
					if ($urlArray[0] == 'first-snow-contest') {
						$html .= "<div class=\"carousel-inner\">
						<div class=\"item active\"><a href=\"http://www.lecochon-niseko.com/\" target=\"_blank\"><img src=\"/jaga/images/carousel-roll-tide.jpg\" alt=\"test0\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						</div>";
					} else {
						$html .= "\t\t\t\t<div class=\"carousel-inner\">
						<div class=\"item active\"><img src=\"/jaga/images/carousel-mountain.jpg\" alt=\"test0\" style=\"margin-left:auto;margin-right:auto;\"></div>
						<div class=\"item\"><a href=\"http://kagi.io/\"><img src=\"/jaga/images/carousel-zenidev.jpg\" alt=\"test1\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						<div class=\"item\"><a href=\"http://www.lecochon-niseko.com/\" target=\"_blank\"><img src=\"/jaga/images/carousel-roll-tide.jpg\" alt=\"test2\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						<div class=\"item\"><a href=\"http://holidayniseko.com/\" target=\"_blank\"><img src=\"/jaga/images/carousel-holidayniseko.jpg\" alt=\"test3\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						</div>\n\n";
					}

				} elseif ($_SESSION['channelKey'] == 'hakodate') { // Hakodate Guide
					$html .= "\t\t\t\t<div class=\"carousel-inner\">
						<div class=\"item active\"><img src=\"/jaga/images/carousel-hakodate-goryokaku.jpg\" alt=\"test0\" style=\"margin-left:auto;margin-right:auto;\"></div>
						<div class=\"item\"><img src=\"/jaga/images/carousel-hakodate-ishikawa.jpg\" alt=\"test1\" style=\"margin-left:auto;margin-right:auto;\"></div>
						<div class=\"item\"><a href=\"http://kagi.io/\"><img src=\"/jaga/images/carousel-zenidev.jpg\" alt=\"test2\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						</div>\n\n";
				} elseif ($_SESSION['channelKey'] == 'shoreline' || $_SESSION['channelKey'] == 'seattle') { // Local
					$html .= "\t\t\t\t<div class=\"carousel-inner\">
						<div class=\"item active\"><a href=\"http://refer.vonage.com/v2/share/6185926949894533561\" target=\"_blank\"><img src=\"/jaga/images/carousel-vonage.jpg\" alt=\"test0\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						<div class=\"item\"><a href=\"https://nextdoor.com/invite/ysarxeamsfbznkkmzhut\" target=\"_blank\"><img src=\"/jaga/images/carousel-nextdoor.jpg\" alt=\"test1\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						<div class=\"item\"><a href=\"http://kagi.io/\"><img src=\"/jaga/images/carousel-zenidev.jpg\" alt=\"test2\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						</div>\n\n";
				} elseif ($_SESSION['channelKey'] == 'redpill') { // Red Pill
					$html .= "\t\t\t\t<div class=\"carousel-inner\">
						<div class=\"item active\"><img src=\"/jaga/images/carousel-redpill.jpg\" alt=\"test0\" style=\"margin-left:auto;margin-right:auto;\"></div>
						</div>\n\n";
				}

				$html .= "\t\t\t<!-- END SLIDES -->\n\n";

				$html .= "\t\t\t</div>\n\t\t</div>";
				
		return $html;
	}

}

?>