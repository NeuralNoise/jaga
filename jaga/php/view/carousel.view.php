<?php

class CarouselView {

	public function getCarousel($urlArray) {
	
		$html = "\t\t<div class=\"container\" style=\"margin-bottom:20px;\">
			<div id=\"kutchannel-carousel\" class=\"carousel slide\" data-ride=\"carousel\">\n";

			$html .= "<!-- START SLIDES -->\n\n";
				
				if ($_SESSION['channelKey'] == 'www') { // jaga.io
					$html .= "\t\t\t\t<div class=\"carousel-inner\">
						<div class=\"item active\"><a href=\"http://hakodate.jaga.io/\"><img src=\"/jaga/images/carousel-hakodate-goryokaku.jpg\" alt=\"Hakodate\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						<div class=\"item\"><a href=\"http://kagi.io/" . Lang::urlPrefix() . "plans-and-pricing/\"><img src=\"/jaga/images/carousel-kagidotio.jpg\" alt=\"Real Estate Websites\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						<div class=\"item\"><a href=\"http://kids.jaga.io/\"><img src=\"/jaga/images/carousel-ballpit.jpg\" alt=\"Jaga Kids\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						<div class=\"item\"><a href=\"http://niseko.jaga.io/\"><img src=\"/jaga/images/carousel-mountain.jpg\" alt=\"Niseko Hirafu\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
					</div>\n\n";
					
					
				} elseif ($_SESSION['channelKey'] == 'camacho2016') {
				
					$html .= "\t\t\t\t<div class=\"carousel-inner\">
						<div class=\"item active\"><img src=\"/jaga/images/carousel-camacho.jpg\" alt=\"Camacho 2016\" style=\"margin-left:auto;margin-right:auto;\"></div>
						</div>\n\n";
					
					
				} elseif ($_SESSION['channelKey'] == 'niseko') { // The Kutchannel
					
					if ($urlArray[0] == 'first-snow-contest') {
						$html .= "<div class=\"carousel-inner\">
						<div class=\"item active\"><a href=\"http://www.lecochon-niseko.com/\" target=\"_blank\"><img src=\"/jaga/images/carousel-bistrot-le-cochon-first-snow-contest.jpg\" alt=\"Niseko Restaurant\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						</div>";
					} elseif ($urlArray[0] == 'k' && $urlArray[1] == 'property') {
						$html .= "<div class=\"carousel-inner\">
						<div class=\"item active\"><img src=\"/jaga/images/carousel-hirafu-real-estate.jpg\" alt=\"Hirafu Real Estate &amp; Property\" style=\"margin-left:auto;margin-right:auto;\"></div>
						<div class=\"item\"><img src=\"/jaga/images/carousel-niseko-real-estate.jpg\" alt=\"Niseko Real Estate &amp; Property\" style=\"margin-left:auto;margin-right:auto;\"></div>
						<div class=\"item\"><a href=\"http://kagi.io/" . Lang::urlPrefix() . "plans-and-pricing/\" target=\"_blank\"><img src=\"/jaga/images/carousel-kagidotio.jpg\" alt=\"Real Estate Websites\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						</div>";
					} else {
						$html .= "
						
						<div class=\"carousel-inner\">
							<!--
							<div class=\"item active\"><a href=\"/first-snow-contest/\"><img src=\"/jaga/images/carousel-bistrot-le-cochon-first-snow-contest.jpg\" alt=\"Niseko First Snow Contest\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
							-->
							<div class=\"item active\"><a href=\"http://www.lecochon-niseko.com/\" target=\"_blank\"><img src=\"/jaga/images/carousel-roll-tide.jpg\" alt=\"Niseko Restaurant\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
							<div class=\"item\"><a href=\"http://360niseko.com/the-flying-fish/\" target=\"_blank\"><img src=\"/jaga/images/carousel-flying-fish.jpg\" alt=\"Niseko Flying Fish\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						</div>
						
						";
					}

				} elseif ($_SESSION['channelKey'] == 'hakodate') { // Hakodate Guide
					$html .= "\t\t\t\t<div class=\"carousel-inner\">
						<div class=\"item active\"><img src=\"/jaga/images/carousel-hakodate-goryokaku.jpg\" alt=\"Goryokaku Park in Hakodate\" style=\"margin-left:auto;margin-right:auto;\"></div>
						<div class=\"item\"><img src=\"/jaga/images/carousel-hakodate-ishikawa.jpg\" alt=\"Ishikawa Takuboku statue in Hakodate\" style=\"margin-left:auto;margin-right:auto;\"></div>
						<div class=\"item\"><a href=\"http://kagi.io/" . Lang::urlPrefix() . "plans-and-pricing/\"><img src=\"/jaga/images/carousel-kagidotio.jpg\" alt=\"Real Estate Websites\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						</div>\n\n";
				} elseif ($_SESSION['channelKey'] == 'shoreline' || $_SESSION['channelKey'] == 'seattle') { // Local
					$html .= "\t\t\t\t<div class=\"carousel-inner\">
						<div class=\"item  active\"><a href=\"http://refer.vonage.com/v2/share/6185926949894533561\" target=\"_blank\"><img src=\"/jaga/images/carousel-vonage.jpg\" alt=\"Vonage\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						<div class=\"item\"><a href=\"https://nextdoor.com/invite/ysarxeamsfbznkkmzhut\" target=\"_blank\"><img src=\"/jaga/images/carousel-nextdoor.jpg\" alt=\"Nextdoor\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						<div class=\"item\"><a href=\"http://kagi.io/" . Lang::urlPrefix() . "plans-and-pricing/\"><img src=\"/jaga/images/carousel-kagidotio.jpg\" alt=\"Real Estate Websites\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						</div>\n\n";
				} elseif ($_SESSION['channelKey'] == 'redpill') { // Red Pill
					$html .= "\t\t\t\t<div class=\"carousel-inner\">
						<div class=\"item active\"><img src=\"/jaga/images/carousel-redpill.jpg\" alt=\"test0\" style=\"margin-left:auto;margin-right:auto;\"></div>
						</div>\n\n";
				} elseif ($_SESSION['channelKey'] == 'starwars') { // Red Pill
					$html .= "
					<div class=\"carousel-inner\">
						<div class=\"item active\"><img src=\"/jaga/images/carousel-starwars.jpg\" alt=\"test0\" style=\"margin-left:auto;margin-right:auto;\"></div>
						<div class=\"item\"><a href=\"http://redpill.jaga.io/\"><img src=\"/jaga/images/carousel-redpill.jpg\" alt=\"test0\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
					</div>
					";
				} else {
					$html .= "\t\t\t\t<div class=\"carousel-inner\">
						<div class=\"item active\"><a href=\"http://kagi.io/" . Lang::urlPrefix() . "plans-and-pricing/\"><img src=\"/jaga/images/carousel-kagidotio.jpg\" alt=\"Real Estate Websites\" style=\"margin-left:auto;margin-right:auto;\"></a></div>
						</div>\n\n";
				}

				$html .= "\t\t\t<!-- END SLIDES -->\n\n";

			$html .= "\t\t\t</div>\n\t\t</div>";
				
		return $html;
	}

}

?>