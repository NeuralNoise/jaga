<?php

class SubscriptionView {

	public static function displaySubscriptionSettingsList() {
	
		$subscriptionArray = Subscription::getUserSubscriptionArray($_SESSION['userID']);

		$html = '';
		
		$html .= "\t<!-- START SUBSCRIPTION LIST -->\n";
		$html .= "\t<div class=\"container\">\n\n";
		
			$html .= "\t<div class=\"row\">\n\n";
		
			$html .= "<div class=\"panel panel-default\">\n";
				
				$html .= "<div class=\"panel-heading jagaContentPanelHeading\"><h4>YOUR SUBSCRIPTIONS</h4></div>\n";
				
				$html .= "<div class=\"table-responsive\">\n";
					$html .= "<table class=\"table table-hover\">\n";
						$html .= "<thead>\n";
							$html .= "<tr>";
								$html .= "<th>Channel</th>\n";
							$html .= "</tr>";
						$html .= "</thead>\n";
						$html .= "<tbody>\n";

							foreach ($subscriptionArray AS $channelID) {
								$channelKey = Channel::getChannelKey($channelID);
								$html .= "<tr class=\"jagaClickableRow\" data-url=\"http://" . $channelKey . ".kutchannel.net/\">";
									$html .= "<td>" . $channelKey . "</td>\n";
								$html .= "</tr>";
							}
							
						$html .= "</tbody>\n";
					$html .= "</table>\n";
				$html .= "</div>\n";
				
			$html .= "</div>\n";

			$html .= "\t\t</div>\n\n";
			
		$html .= "\t</div>\n";
		$html .= "\t<!-- END SUBSCRIPTION LIST -->\n\n";
		
		return $html;	

	}
	
}

?>