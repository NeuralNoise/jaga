<?php

class SubscriptionView {

	public static function displaySubscriptionSettingsList() {
	
		$subscriptionArray = Subscription::getUserSubscriptionArray($_SESSION['userID']);

		$html = "\n\t<!-- START SUBSCRIPTION LIST -->\n";
		$html .= "\t<div class=\"container\">\n";
			$html .= "\t\t<div class=\"row\">\n";
				$html .= "\t\t\t<div class=\"col-md-12\">\n";
					$html .= "\t\t\t\t<div class=\"panel panel-default\">\n";
						$html .= "\t\t\t\t\t<div class=\"panel-heading jagaContentPanelHeading\"><h4>" . Lang::getLang('yourSubscriptions') . "</h4></div>\n";
						$html .= "\t\t\t\t\t<div class=\"table-responsive\">\n";
							$html .= "\t\t\t\t\t\t<table class=\"table table-hover table-striped\">\n";
								$html .= "\t\t\t\t\t\t\t<tr>\n";
									$html .= "\t\t\t\t\t\t\t\t<th>" . Lang::getLang('channel') . "</th>\n";
									$html .= "\t\t\t\t\t\t\t\t<th>" . Lang::getLang('title') . "</th>\n";
									$html .= "\t\t\t\t\t\t\t\t<th>" . Lang::getLang('manager') . "</th>\n";
									$html .= "\t\t\t\t\t\t\t\t<th>" . Lang::getLang('created') . "</th>\n";
								$html .= "\t\t\t\t\t\t\t</tr>\n";
								foreach ($subscriptionArray AS $channelID) {
									
									$channel = new Channel($channelID);
									$channelKey = $channel->channelKey;
									$channelTitle = $channel->channelTitleEnglish;
									$channelCreationDateTime = date('Y-m-d', strtotime($channel->channelCreationDateTime));
									$channelManager = User::getUserName($channel->siteManagerUserID);
									
									// channelCreationDateTime
									
									// $channelKey = Channel::getChannelKey($channelID);
									
									$html .= "\t\t\t\t\t\t\t<tr class=\"jagaClickableRow\" data-url=\"http://" . $channelKey . ".jaga.io/\">\n";
										$html .= "\t\t\t\t\t\t\t\t<td>" . $channelKey . "</td>\n";
										$html .= "\t\t\t\t\t\t\t\t<td>" . $channelTitle . "</td>\n";
										$html .= "\t\t\t\t\t\t\t\t<td>" . $channelManager . "</td>\n";
										$html .= "\t\t\t\t\t\t\t\t<td>" . $channelCreationDateTime . "</td>\n";
									$html .= "\t\t\t\t\t\t\t</tr>\n";
								}
							$html .= "\t\t\t\t\t\t</table>\n";
						$html .= "\t\t\t\t\t</div>\n";
					$html .= "\t\t\t\t</div>\n";
				$html .= "\t\t\t</div>\n";
			$html .= "\t\t</div>\n";
		$html .= "\t</div>\n";
		$html .= "\t<!-- END SUBSCRIPTION LIST -->\n\n";
		
		return $html;	

	}
	
}

?>