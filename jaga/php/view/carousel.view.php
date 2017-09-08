<?php

class CarouselView {

	public function getCarousel($urlArray) {
	
		$carouselID = Carousel::getCarouselID($urlArray);
		$html = "";
		
		if ($carouselID) {
			
			$carousel = new Carousel($carouselID);
			$panels = CarouselPanel::panels($carouselID);
			
			$html .= "<div class=\"container\" style=\"margin-bottom:20px;\">";
				$html .= "<div id=\"kutchannel-carousel\" class=\"carousel slide\" data-ride=\"carousel\">";
					$html .= "<div class=\"carousel-inner\">";

					foreach ($panels AS $carouselPanelID) {
						
						$panel = new CarouselPanel($carouselPanelID);
						
						$imageID = $panel->imageID;
						$url = $panel->url();
						$title = $panel->title();
						$subtitle = $panel->subtitle();
						$alt = $panel->alt();
						
						$html .= "<div class=\"item" . ($panels[0]==$carouselPanelID?" active":"") . "\">";
							if ($url) { $html .= "<a href=\"" . $url . "\">"; }
								$html .= "<img src=\"/jaga/images/" . $imageID . ".jpg\" alt=\"" . $alt . "\" style=\"margin-left:auto;margin-right:auto;\">";
							if ($url) { $html .= "</a>"; }
						$html .= "</div>";
						
					}

					$html .= "</div>";
				$html .= "</div>";
			$html .= "</div>";
			
		}
		
		return $html;
		
	}

}

?>