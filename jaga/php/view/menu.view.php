<?php

class MenuView {

	public function getNavBar() {
	
		$channel = new Channel($_SESSION['channelID']);
		if ($_SESSION['lang'] == 'ja') { $channelTitle = $channel->channelTitleJapanese; } else { $channelTitle = $channel->channelTitleEnglish; }
		
		$user = new User($_SESSION['userID']);
		$username = $user->username;

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
						
						
						$html .= "\t\t\t\t\t<ul class=\"nav navbar-nav\">\n";

							// START "THIS CHANNEL" DROPDOWN //
							if ($_SESSION['channelID'] != 2006) { // jaga.io categories are aggregate
								$html .= "\t\t\t\t\t\t<li class=\"dropdown\"><a href=\"/\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">" . Lang::getLang('thisChannel') . " <b class=\"caret\"></b></a>\n";
									$html .= "\t\t\t\t\t\t\t<ul class=\"dropdown-menu\">\n";
									
										// IF UNSUBCRIBED TO CURRENT CHANNEL
										if (!Subscription::userIsSubscribed($_SESSION['userID'], $_SESSION['channelID'])) {
											$html .= "\t\t\t\t\t<li><a href=\"/subscribe/" . $_SESSION['channelKey'] . "/\"><span class=\"glyphicon glyphicon-star-empty\"> <span class=\"\">" . Lang::getLang('subscribe') . "</span></span></a></li>\n\n";
										}

										$html .= self::getNavBarCategoryListItems();
										$html .= "\t\t\t\t\t\t\t\t<li><a href=\"/k/\"><em>ALL CATEGORIES...</em></a></li>\n";
																				
										// IF SUBCRIBED TO CURRENT CHANNEL
										if (Subscription::userIsSubscribed($_SESSION['userID'], $_SESSION['channelID'])) {
											$html .= "\t\t\t\t\t<li><a href=\"/unsubscribe/" . $_SESSION['channelKey'] . "/\"><span class=\"glyphicon glyphicon-remove\"> <span class=\"\">" . Lang::getLang('unsubscribe') . "</span></span></a></li>\n\n";
										}
										
									$html .= "\t\t\t\t\t\t\t</ul>\n";
								$html .= "\t\t\t\t\t\t</li>\n";

							}
							
							// END "THIS CHANNEL" DROPDOWN //
						$html .= "\t\t\t\t\t</ul>\n";

						/*
						$html .= "
						<div class=\"col-sm-3 col-md-3\">
							<form action=\"/explore/\" class=\"navbar-form\" role=\"search\">
								<div class=\"input-group\">
									<input type=\"text\" class=\"form-control\" placeholder=\"Search The Kutchannel\" name=\"srch-term\" id=\"srch-term\">
									<div class=\"input-group-btn\">
										<button class=\"btn btn-default\" type=\"submit\"><i class=\"glyphicon glyphicon-search\"></i></button>
									</div>
								</div>
							</form>
						</div>
						";
						*/

						$html .= "\t\t\t\t\t<ul class=\"nav navbar-nav navbar-right\">\n";

							
							if ($_SESSION['userID'] != 0) {
								$html .= "\t\t\t\t\t\t<li><a href=\"http://jaga.io/home/\"><span class=\"glyphicon glyphicon-home hidden-xs hidden-sm\"></span><span class=\"visible-xs visible-sm\">" . Lang::getLang('home') . "</span></a></li>\n";
							}
							
							$html .= "\t\t\t\t\t\t<li><a href=\"http://jaga.io/channels/\"><span class=\"glyphicon glyphicon-th-large hidden-xs hidden-sm\"></span><span class=\"visible-xs visible-sm\">" . Lang::getLang('channels') . "</span></a></li>\n";
							
							if ($_SESSION['userID'] != 0) {
								$html .= "\t\t\t\t\t\t<li><a href=\"http://jaga.io/u/" .  $username . "/\"><span class=\"glyphicon glyphicon glyphicon-user hidden-xs hidden-sm\"></span><span class=\"visible-xs-block visible-sm-block\">" . Lang::getLang('profile') . "</span></a></li>\n";
							}
								
							// START "YOUR CHANNELS" DROPDOWN //
							$html .= "\t\t\t\t\t\t<li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">" . Lang::getLang('yourChannels') . " <b class=\"caret\"></b></a>\n";
								if ($_SESSION['userID'] == 0) {
									$html .= "\t\t\t\t\t\t\t<ul class=\"dropdown-menu\">\n";
										$html .= "\t\t\t\t\t\t\t\t<li><a href=\"/login/\">" . Lang::getLang('login') . "</a></li>\n";
										$html .= "\t\t\t\t\t\t\t\t<li><a href=\"/register/\">" . Lang::getLang('register') . "</a></li>\n";
									$html .= "\t\t\t\t\t\t\t</ul>\n";	
								} else {
									$html .= "\t\t\t\t\t\t\t<ul class=\"dropdown-menu jagaDrop\">\n";
										$html .= self::navBarUserChannelDropdown();
										$html .= "\t\t\t\t\t\t\t\t<li><a href=\"http://jaga.io/settings/subscriptions/\"><em>" . Lang::getLang('yourSubscriptions') . "...</em></a></li>\n";
									$html .= "\t\t\t\t\t\t\t</ul>\n";
								}
							$html .= "\t\t\t\t\t\t</li>\n";
							// END "YOUR CHANNELS" DROPDOWN //

							// START "EXPLORE" DROPDOWN //
							$html .= "\t\t\t\t\t\t<li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">" . Lang::getLang('explore') . " <b class=\"caret\"></b></a>\n";
								$html .= "\t\t\t\t\t\t\t<ul class=\"dropdown-menu jagaDrop\">\n";
									$html .= self::getNavBarExploreListItems();
									$html .= "\t\t\t\t\t\t\t\t<li class=\"divider\"></li>\n";
									$html .= "\t\t\t\t\t\t\t\t<li><a href=\"http://jaga.io/channels/\">" . Lang::getLang('allChannels') . "...</a></li>\n";
								$html .= "\t\t\t\t\t\t\t</ul>\n";
							$html .= "\t\t\t\t\t\t</li>\n";
							// END "EXPLORE" DROPDOWN //
							
							if ($_SESSION['userID'] == 0) { // IF NOT LOGGED IN
								$html .= "\t\t\t\t\t\t<li><a href=\"/login/\"><span class=\"glyphicon glyphicon-log-in hidden-xs\"></span><span class=\"visible-xs\">" . Lang::getLang('login') . "</span></a></li>\n";
							} else { // IF LOGGED IN
								$html .= "\t\t\t\t\t\t<li><a href=\"http://jaga.io/imo/\"><span class=\"glyphicon glyphicon-envelope hidden-xs hidden-sm\"></span><span class=\"visible-xs-block visible-sm-block\">" . Lang::getLang('messages') . "</span></a></li>\n";
								$html .= "\t\t\t\t\t\t<li><a href=\"http://jaga.io/settings/profile/\"><span class=\"glyphicon glyphicon-cog hidden-xs hidden-sm\"></span><span class=\"visible-xs-block visible-sm-block\">" . Lang::getLang('settings') . "</span></a></li>\n";
								$html .= "\t\t\t\t\t\t<li><a href=\"/logout/\"><span class=\"glyphicon glyphicon-log-out hidden-xs hidden-sm\"></span><span class=\"visible-xs-block visible-sm-block\">" . Lang::getLang('logout') . "</span></a></li>\n";
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

			$category = new Category($key);
			if ($_SESSION['lang'] == 'ja') { $contentCategory = $category->contentCategoryJapanese; } else { $contentCategory = $category->contentCategoryEnglish; }

			if ($key != '' && $h < 14) {
				$html .= "\t\t\t\t\t\t\t\t<li";
					if ($h >= 5) { $html .= " class=\"hidden-xs\""; }
				$html .= "><a href=\"/k/$key/\">" . strtoupper($contentCategory) . "<span class=\"jagaBadge\">$value</span></a></li>\n";
			}
			$h++;
		}
		
		return $html;
		
	}

	private function navBarUserChannelDropdown() {

		$userSubscribedChannelArray = Channel::getUserSubscribedChannelArray($_SESSION['userID']);
		arsort($userSubscribedChannelArray);
		
		$html = '';
		
		$j = 0;
		foreach ($userSubscribedChannelArray AS $channelKey => $postCount) {
			
			$channelID = Channel::getChannelID($channelKey);
			$channel = new Channel($channelID);
			$channelTitle = $channel->getTitle(); 
			if ($postCount > 1000) { $postCount = round($postCount/1000, 1) . "K"; }

			$html .= "<li class=\"";
				if ($j >= 3) { $html .= "hidden-xs"; }
				if ($j >= 10) { $html .= " hidden-sm"; }
				if ($j >= 15) { $html .= " hidden-md"; }
				if ($j >= 20) { $html .= " hidden-lg"; }
			$html .= "\">";
				$html .= "<a href=\"http://$channelKey.jaga.io/\">" . strtoupper($channelTitle) . " <span class=\"jagaBadge\">$postCount</span></a>";
			$html .= "</li>";

			$j++;
			
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
			
			$channelID = Channel::getChannelID($channelKey);
			$channel = new Channel($channelID);
			if ($_SESSION['lang'] == 'ja') { $channelTitle = $channel->channelTitleJapanese; } else { $channelTitle = $channel->channelTitleEnglish; }
			
			
			
			if (
				!isset($userOwnChannelArray[$channelKey])
				&& !isset($userSubscribedChannelArray[$channelKey])
				&& $channelKey != ''
				&& $channelKey != 'the'
			) {
				if ($k < 14) {
					$html .= "\t\t\t\t\t\t\t\t<li";
						if ($k >= 3) { $html .= " class=\"hidden-xs\""; }
					$html .= "><a href=\"http://$channelKey.jaga.io/\">";
						$html .= strtoupper($channelTitle);
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