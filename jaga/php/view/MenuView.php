<?php

class MenuView {

	public function getNavBar() {
	
		$channel = new Channel($_SESSION['channelID']);
		$channelTitle = $channel->getChannelTitle();
		
		$user = new User($_SESSION['userID']);
		$username = $user->username;
		
		// $categoryArray = ChannelCategory::getChannelCategoryArray($_SESSION['channelID']);
		// $userOwnChannelArray = Channel::getUserOwnChannelArray($_SESSION['userID']);
		// $userSubscribedChannelArray = Channel::getUserSubscribedChannelArray($_SESSION['userID']);
		
		
		// $channelArray = Channel::getChannelArray();

		$html = "\t<!-- START NAVIGATION DIV -->\n";
		$html .= "\t<div class=\"navbar-wrapper\">\n\n";
		
			$html .= "\t\t<!-- START NAV -->\n";
			$html .= "\t\t<nav class=\"navbar navbar-default navbar-fixed-top\" role=\"navigation\">\n\n";
			
				$html .= "\t\t\t<!-- START CONTAINER -->\n";
				$html .= "\t\t\t<div class=\"container\">\n\n";

					$html .= "\t\t\t\t<!-- START NAVBAR-HEADER -->\n";
					$html .= "\t\t\t\t<div class=\"navbar-header\">\n\n";
						
						$html .= "\t\t\t\t\t<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">\n";
							$html .= "\t\t\t\t\t\t<span class=\"sr-only\">Toggle navigation</span>\n";
							$html .= "\t\t\t\t\t\t<span class=\"icon-bar\"></span>\n";
							$html .= "\t\t\t\t\t\t<span class=\"icon-bar\"></span>\n";
							$html .= "\t\t\t\t\t\t<span class=\"icon-bar\"></span>\n";
						$html .= "\t\t\t\t\t</button>\n\n";
						
						if ($_SESSION['channelID'] == 14) {
							$html .= "\t\t\t\t\t<a href=\"/\"><img id=\"kLogo\" src=\"/jaga/images/banner.png\"></a>\n\n";
						} else {
							$html .= "\t\t\t\t\t<a class=\"navbar-brand\" href=\"/\">" . strtoupper($channelTitle) . "</a>\n\n";
						}
						
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END NAVBAR-HEADER -->\n\n";

					$html .= "\t\t\t\t<!-- START NAVBAR-COLLAPSE -->\n";
					$html .= "\t\t\t\t<div class=\"collapse navbar-collapse\">\n\n";
						
						$html .= "\t\t\t\t\t<ul class=\"nav navbar-nav navbar-right\">\n";

							$html .= "\t\t\t\t\t\t<li><a href=\"http://the.kutchannel.net/\"><span class=\"glyphicon glyphicon-home\"></span><span class=\"visible-xs\">HOME</span></a></li>\n";
							
							if ($_SESSION['userID'] != 0) {
								$html .= "\t\t\t\t\t\t<li><a href=\"http://the.kutchannel.net/newsfeed/\"><span class=\"glyphicon glyphicon-list-alt\"></span><span class=\"visible-xs\">NEWSFEED</span></a></li>\n";
							}
							
							
							
							// START "THIS CHANNEL" DROPDOWN //
							if ($_SESSION['channelID'] != 2006) { // the.kutchannel.net categories are aggregate
								$html .= "\t\t\t\t\t\t<li class=\"dropdown\"><a href=\"/\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">THIS CHANNEL <b class=\"caret\"></b></a>\n";
									$html .= "\t\t\t\t\t\t\t<ul class=\"dropdown-menu\">\n";
										$html .= self::getNavBarCategoryListItems();
										$html .= "\t\t\t\t\t\t\t\t<li><a href=\"/k/\"><em>ALL CATEGORIES...</em></a></li>\n";
									$html .= "\t\t\t\t\t\t\t</ul>\n";
								$html .= "\t\t\t\t\t\t</li>\n";
							}
							// END "THIS CHANNEL" DROPDOWN //
							
							
							
							// START "YOUR CHANNELS" DROPDOWN //
							$html .= "\t\t\t\t\t\t<li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">YOUR CHANNELS <b class=\"caret\"></b></a>\n";
								if ($_SESSION['userID'] == 0) {
									$html .= "\t\t\t\t\t\t\t<ul class=\"dropdown-menu\">\n";
										$html .= "\t\t\t\t\t\t\t\t<li><a href=\"/login/\">LOGIN</a></li>\n";
										$html .= "\t\t\t\t\t\t\t\t<li><a href=\"/register/\">REGISTER</a></li>\n";
									$html .= "\t\t\t\t\t\t\t</ul>\n";	
								} else {
									$html .= "\t\t\t\t\t\t\t<ul class=\"dropdown-menu jagaDrop\">\n";
										$html .= "\t\t\t\t\t\t\t\t<li><a href=\"/u/" .  $username . "/channels/\"><em>CHANNELS...</em></a></li>\n";
										$html .= self::getNavBarOwnChannelListItems();
										$html .= "\t\t\t\t\t\t\t\t<li class=\"divider\"></li>\n";
										$html .= "\t\t\t\t\t\t\t\t<li><a href=\"/u/" .  $username . "/subscriptions/\"><em>SUBSCRIPTIONS...</em></a></li>\n";
										$html .= self::getNavBarSubscriptionListItems();
									$html .= "\t\t\t\t\t\t\t</ul>\n";
								}
							$html .= "\t\t\t\t\t\t</li>\n";
							// END "YOUR CHANNELS" DROPDOWN //
							
							
							
							// START "EXPLORE" DROPDOWN //
							$html .= "\t\t\t\t\t\t<li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">EXPLORE <b class=\"caret\"></b></a>\n";
								$html .= "\t\t\t\t\t\t\t<ul class=\"dropdown-menu jagaDrop\">\n";
									$html .= self::getNavBarExploreListItems();
									$html .= "\t\t\t\t\t\t\t\t<li class=\"divider\"></li>\n";
									$html .= "\t\t\t\t\t\t\t\t<li><a href=\"http://the.kutchannel.net/\">ALL CHANNELS...</a></li>\n";
								$html .= "\t\t\t\t\t\t\t</ul>\n";
							$html .= "\t\t\t\t\t\t</li>\n";
							// END "EXPLORE" DROPDOWN //
							
							if ($_SESSION['userID'] == 0) { // IF NOT LOGGED IN
								
								$html .= "\t\t\t\t\t\t<li><a href=\"/login/\"><span class=\"glyphicon glyphicon-log-in\"></span><span class=\"visible-xs\">LOGIN</span></a></li>\n";
				
							} else { // IF LOGGED IN
							
								$html .= "\t\t\t\t\t\t<li><a href=\"/u/" .  $username . "/\"><span class=\"glyphicon glyphicon glyphicon-user\"></span><span class=\"visible-xs\">PROFILE</span></a></li>\n";
								
								$html .= "\t\t\t\t\t\t<li><a href=\"/imo/\"><span class=\"glyphicon glyphicon-envelope\"></span><span class=\"visible-xs\">MESSAGES</span></a></li>\n";
								
								$html .= "\t\t\t\t\t\t<li><a href=\"/settings/\"><span class=\"glyphicon glyphicon-cog\"></span><span class=\"visible-xs\">SETTINGS</span></a></li>\n";
								
								$html .= "\t\t\t\t\t\t<li><a href=\"/logout/\"><span class=\"glyphicon glyphicon-log-out\"></span><span class=\"visible-xs\">LOGOUT</span></a></li>\n";
								
							}
								
						$html .= "\t\t\t\t\t</ul>\n";
					
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END NAVBAR-COLLAPSE -->\n\n";
					
				$html .= "\t\t\t</div>\n";
				$html .= "\t\t\t<!-- END CONTAINER -->\n\n";
				
			$html .= "\t\t</nav>\n";
			$html .= "\t\t<!-- END NAV -->\n\n";
			
		$html .= "\t</div>\n";
		$html .= "\t<!-- END NAVIGATION DIV -->\n\n";
		
		return $html;
		
	}
	
	private function getNavBarCategoryListItems() {
		
		$categoryArray = ChannelCategory::getChannelCategoryArray($_SESSION['channelID']);
		$html = '';
		$h = 0;
		foreach ($categoryArray AS $key => $value) {
			if ($key != '' && $h < 14) {
				$html .= "\t\t\t\t\t\t\t\t<li";
					if ($h >= 5) { $html .= " class=\"hidden-xs\""; }
				$html .= "><a href=\"/k/$key/\">" . strtoupper($key) . "<span class=\"jagaBadge\">$value</span></a></li>\n";
			}
			$h++;
		}
		
		return $html;
		
	}
	
	private function getNavBarOwnChannelListItems() {

		$userOwnChannelArray = Channel::getUserOwnChannelArray($_SESSION['userID']);
		$html = '';
		$i = 0;
		foreach ($userOwnChannelArray AS $channelKey => $postCount) {
			if ($i < 7) {
				$html .= "\t\t\t\t\t\t\t\t<li";
					if ($i >= 3) { $html .= " class=\"hidden-xs\""; }
				$html .= "><a href=\"http://$channelKey.kutchannel.net/\">" . strtoupper($channelKey);
					$html .= " <span class=\"jagaBadge\">$postCount</span>";
				$html .= "</a></li>\n";
				$i++;
			}
		}
		return $html;

		
	}
	
	private function getNavBarSubscriptionListItems() {
		
		$userOwnChannelArray = Channel::getUserOwnChannelArray($_SESSION['userID']);
		$userSubscribedChannelArray = Channel::getUserSubscribedChannelArray($_SESSION['userID']);
		$html = '';
		$j = 0;
		foreach ($userSubscribedChannelArray AS $channelKey => $postCount) {
			if (!isset($userOwnChannelArray[$channelKey]) && $j < 7) {
				$html .= "\t\t\t\t\t\t\t\t<li";
					if ($j >= 3) { $html .= " class=\"hidden-xs\""; }
				$html .= "><a href=\"http://$channelKey.kutchannel.net/\">" . strtoupper($channelKey);
					$html .= " <span class=\"jagaBadge\">$postCount</span>";
				$html .= "</a></li>\n";
				$j++;
			}
		}
		return $html;
		
	}

	private function getNavBarExploreListItems() {
		
		$userOwnChannelArray = Channel::getUserOwnChannelArray($_SESSION['userID']);
		$userSubscribedChannelArray = Channel::getUserSubscribedChannelArray($_SESSION['userID']);
		$channelArray = Channel::getChannelArray();
		$html = '';
		$k = 0;
		foreach ($channelArray AS $channelKey => $totalPosts) {
			if (
				!isset($userOwnChannelArray[$channelKey])
				&& !isset($userSubscribedChannelArray[$channelKey])
				&& $channelKey != ''
				&& $channelKey != 'the'
			) {
				if ($k < 14) {
					$html .= "\t\t\t\t\t\t\t\t<li";
						if ($k >= 3) { $html .= " class=\"hidden-xs\""; }
					$html .= "><a href=\"http://$channelKey.kutchannel.net/\">";
						$html .= strtoupper($channelKey);
						$html .= "<span class=\"jagaBadge\">$totalPosts</span>";
					$html .= "</a></li>\n";
				}
				$k++;
			}
		}
		return $html;
		
	}

}

?>