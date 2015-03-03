<?php

class CarouselView {

	public function getCarousel() {
	
		$html = "
		<div class=\"container\" style=\"margin-bottom:20px;\">
			<div id=\"kutchannel-carousel\" class=\"carousel slide\" data-ride=\"carousel\">

				<!-- Indicators -->
				<ol class=\"carousel-indicators\">
					<li data-target=\"#kutchannel-carousel\" data-slide-to=\"0\" class=\"active\"></li>
					<li data-target=\"#kutchannel-carousel\" data-slide-to=\"1\"></li>
					<li data-target=\"#kutchannel-carousel\" data-slide-to=\"2\"></li>
				</ol>

				<!-- START SLIDES -->
				
				<div class=\"carousel-inner\">
					<div class=\"item\">
						<img src=\"/jaga/images/carousel-mountain.jpg\" alt=\"test0\" style=\"margin-left:auto;margin-right:auto;\">
					</div>
					<div class=\"item\">
						<img src=\"/jaga/images/carousel-roll-tide.jpg\" alt=\"test2\" style=\"margin-left:auto;margin-right:auto;\">
					</div>
					<div class=\"item active\">
						<img src=\"/jaga/images/carousel-ballpit.jpg\" alt=\"test1\" style=\"margin-left:auto;margin-right:auto;\">
					</div>
				</div>

				<!-- END SLIDES -->
				
				<!-- Controls -->
				<a class=\"left carousel-control\" href=\"#kutchannel-carousel\" data-slide=\"prev\"><span class=\"glyphicon glyphicon-chevron-left\"></span></a>
				<a class=\"right carousel-control\" href=\"#kutchannel-carousel\" data-slide=\"next\"><span class=\"glyphicon glyphicon-chevron-right\"></span></a>

			</div>
		</div>
		";
		return $html;
	}
}

?>