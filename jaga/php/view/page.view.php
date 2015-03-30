<?php

class PageView {

	public $pageTitle;
	public $pageKeywords;
	public $pageDescription;
	
	public function __construct() {
	
		$channelID = Session::getSession('channelID');
		$channel = new Channel($channelID);
		if ($_SESSION['lang'] == 'ja') {
			$this->pageTitle = $channel->channelTitleJapanese;
			$this->pageKeywords = $channel->channelKeywordsJapanese;
			$this->pageDescription = $channel->channelDescriptionJapanese;
		} else {
			$this->pageTitle = $channel->channelTitleEnglish;
			$this->pageKeywords = $channel->channelKeywordsEnglish;
			$this->pageDescription = $channel->channelDescriptionEnglish;
		}
	}
	
	private function getHeader() {

		$html = "<!DOCTYPE html>\n";
		$html .= "<html lang=\"" . $_SESSION['lang'] . "\">\n\n";
		
			$html .= "\t<head>\n\n";
			
				$html .= "\t\t<title>" . $this->pageTitle . "</title>\n\n";
				
				$html .= "\t\t<meta charset=\"utf-8\">\n";
				$html .= "\t\t<meta name=\"robots\" content=\"INDEX, FOLLOW\">\n\n";
				
				$html .= "\t\t<meta name=\"keywords\" content=\"" . $this->pageKeywords . "\">\n";
				$html .= "\t\t<meta name=\"description\" content=\"" . $this->pageDescription . "\">\n\n";
				
				$html .= "\t\t<meta name=\"msvalidate.01\" content=\"" . Config::read('ms.validate') . "\" />\n";
				$html .= "\t\t<meta name=\"p:domain_verify\" content=\"" . Config::read('pinterest.domain_verify') . "\"/>\n\n";
				
				$html .= "\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">\n";
				$html .= "\t\t<meta name=\"apple-mobile-web-app-capable\" content=\"yes\">\n";
				$html .= "\t\t<meta name=\"apple-mobile-web-app-status-bar-style\" content=\"black-translucent\">\n\n";

				$html .= "\t\t<meta name=\"author\" content=\"Chishiki\">\n";
				$html .= "\t\t<meta name=\"generator\" content=\"JAGA\">\n\n";
				
				$html .= "\t\t<link rel=\"icon\" type=\"image/x-icon\" href=\"/jaga/images/favicon.ico\"/>\n\n";

				$html .= "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"/jaga/lib/bootstrap/3.3.2/css/bootstrap.min.css\">\n";
				$html .= "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"/jaga/css/kutchannel.css\" />\n";
				$html .= "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"/channel.css\" />\n\n";

				$html .= "\t\t<script type=\"text/javascript\" src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js\"></script>\n";
				$html .= "\t\t<script type=\"text/javascript\" src=\"http://maps.google.com/maps/api/js?sensor=false&libraries=places\"></script>\n";
				$html .= "\t\t<script type=\"text/javascript\" src=\"/jaga/lib/bootstrap/3.3.2/js/bootstrap.min.js\"></script>\n";
				$html .= "\t\t<script type=\"text/javascript\" src=\"/jaga/lib/masonry/masonry.pkgd.min.js\"></script>\n";
				$html .= "\t\t<script type=\"text/javascript\" src=\"/jaga/lib/locationpicker/locationpicker.jquery.js\"></script>\n";
				$html .= "\t\t<script type=\"text/javascript\" src=\"/jaga/js/tooltip.js\"></script>\n";				
				$html .= "\t\t<script type=\"text/javascript\" src=\"/jaga/js/kutchannel.js\"></script>\n\n";

				$html .= "\t\t\t<script>\n";
				$html .= "
				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

				ga('create', '" . Config::read('analytics.trackingID') . "', 'auto');
				ga('send', 'pageview');
				";
				$html .= "\n\t\t\t</script>\n\n";
				
				$html .= "\t\t\t<script>\n";
				$html .= "
				var _prum = [['id', '" . Config::read('pingdom.rumID') . "'],['mark', 'firstbyte', (new Date()).getTime()]];
				(function() {
					var s = document.getElementsByTagName('script')[0]
					  , p = document.createElement('script');
					p.async = 'async';
					p.src = '//rum-static.pingdom.net/prum.min.js';
					s.parentNode.insertBefore(p, s);
				})();
				";
				$html .= "\n\t\t\t</script>\n\n";
				
				$html .= "\t\t\t<script type=\"text/javascript\">\n";
				$html .= "
				_atrk_opts = { atrk_acct:\"" . Config::read('alexa.atrk_acct') . "\", domain:\"" . Config::read('site.url') . "\",dynamic: true};
				(function() {
					var as = document.createElement('script');
					as.type = 'text/javascript';
					as.async = true;
					as.src = \"https://d31qbv1cthcecs.cloudfront.net/atrk.js\";
					var s = document.getElementsByTagName('script')[0];
					s.parentNode.insertBefore(as, s); 
				})();
				";
				$html .= "\n\t\t\t</script>\n";
				$html .= "\t\t\t<noscript><img src=\"https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=" . Config::read('alexa.atrk_acct') . "\" style=\"display:none\" height=\"1\" width=\"1\" alt=\"\" /></noscript>\n\n";
				
				
			$html .= "\n\t</head>\n\n";

			$html .= "\t<body>\n\n";
			
		return $html;
		
	}
	
	private function getFooter() {
	
				$html = "\n\n\t\t<div id=\"footer\">\n";
					$html .= "\t\t\t\t<div class=\"col-sm-8 hidden-xs\">\n";
						$html .= "\t\t\t\t\t<ul class=\"list-inline\">\n";
							$html .= "\t\t\t\t\t\t<li><a class=\"\" href=\"http://jaga.io/about/\">" . Lang::getLang('about') . "</a></li>\n";
							$html .= "\t\t\t\t\t\t<li><a class=\"\" href=\"http://jaga.io/tos/\">" . Lang::getLang('tos') . "</a></li>\n";
							$html .= "\t\t\t\t\t\t<li><a class=\"\" href=\"http://jaga.io/privacy/\">" . Lang::getLang('privacyPolicy') . "</a></li>\n";								
							$html .= "\t\t\t\t\t\t<li><a class=\"\" href=\"http://jaga.io/sitemap/\">" . Lang::getLang('sitemap') . "</a></li>\n";
							// $html .= "\t\t\t\t\t\t<li><a class=\"\" href=\"http://jaga.io/advertise/\">Advertise</a></li>\n";
							// $html .= "\t\t\t\t\t\t<li><a class=\"\" href=\"http://jaga.io/contact/\">Contact</a></li>\n";
						$html .= "\t\t\t\t\t</ul>\n";
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<div class=\"col-sm-4\">\n";
						$html .= "\t\t\t\t\t<div class=\"pull-right\">";
							if ($_SESSION['lang'] == 'ja') { $html .= "<a href=\"/lang/en/\">English</a> | "; } else { $html .= "<a href=\"/lang/ja/\">日本語</a> | "; }
							$html .= "Powered by <a href=\"http://github.com/chishiki/jaga/\">JAGA</a>";
						$html .= "</div>\n";
					$html .= "\t\t\t\t</div>\n";
				$html .= "\t\t</div>\n\n";
			$html .= "\t</body>\n\n";
		$html .= "</html>";
		
		return $html;
		
	}

	private function getBreadcrumbs($urlArray) {
	
		$channel = new Channel($_SESSION['channelID']);
		$channelKey = $channel->channelKey;
		if ($_SESSION['lang'] == 'ja') { $channelTitle = $channel->channelTitleJapanese; } else { $channelTitle = $channel->channelTitleEnglish; }
		
		$html = "<div class=\"container\"><ol class=\"breadcrumb\">";
			$html .= "<li><a href=\"http://jaga.io/\">" . Lang::getLang('jaga') . "</a></li>";
			if ($urlArray[1] == '') {
				$html .= "<li>" . strtoupper($channelTitle) . "</li>";
			} else {
				$html .= "<li><a href=\"http://" . $channelKey . ".jaga.io/\">" . strtoupper($channelTitle) . "</a></li>";
			}
			if ($urlArray[0] == 'k' && $urlArray[1] != '') { // /k/<contentCategoryKey>/
				$categoryTitle = strtoupper(Category::getCategoryTitle($urlArray[1]));
				if ($urlArray[2] != '') {
					$html .= "<li class=\"active\"><a href=\"http://" . $channelKey . ".jaga.io/k/" . $urlArray[1] . "/\">" . $categoryTitle . "</a></li>";
				} else {
					$html .= "<li class=\"active\">" . $categoryTitle . "</li>";
				}
			}
			if ($urlArray[0] == 'k' && $urlArray[1] != '' && $urlArray[2] != '') { // /k/<contentCategoryKey>/<contentURL>/
				$contentTitle = strtoupper(Content::getContentTitle($urlArray[2]));
				$html .= "<li class=\"active\">" . $contentTitle . "</li>";
			}
		$html .= "</ol></div>";
		return $html;
		
	}
	
	private function getSettingsNav($urlArray) {

		$html = "\t<div class=\"container\">\n";
			$html .= "\t\t<div class=\"row\" style=\"margin-bottom:10px;\">\n";
				$html .= "\t\t\t<div class=\"col-md-12\">\n";
					$html .= "\t\t\t\t<ul class=\"nav nav-tabs nav-justified\">\n";
						 $html .= "\t\t\t\t\t<li role=\"presentation\" class=\"" . ($urlArray[1]=='profile'?'active':'') . "\"><a href=\"/settings/profile/\"><span class=\"glyphicon glyphicon-user\"></span> <span>" . Lang::getLang('profile') . "</span></a></li>";
						 $html .= "\t\t\t\t\t<li role=\"presentation\" class=\"" . ($urlArray[1]=='channels'?'active':'') . "\"><a href=\"/settings/channels/\"><span class=\"glyphicon glyphicon-th-large\"></span>  <span>" . Lang::getLang('channels') . "</span></a></li>";
						 $html .= "\t\t\t\t\t<li role=\"presentation\" class=\"" . ($urlArray[1]=='subscriptions'?'active':'') . "\"><a href=\"/settings/subscriptions/\" ><span class=\"glyphicon glyphicon-star\"></span>  <span>" . Lang::getLang('subscriptions') . "</span> </a></li>";
					$html .= "\t\t\t\t</ul>\n";
				$html .= "\t\t\t</div>\n";
			$html .= "\t\t</div>\n";
		$html .= "\t</div>\n";
		
		return $html;
		
	}

	private function getProfileNav($username) {

		$html = "\t<div class=\"container\">\n";
			$html .= "\t\t<div class=\"row\" style=\"margin-bottom:10px;\">\n";
				$html .= "
					<div class=\"btn-group btn-group-lg\">
						<a href=\"/u/" . $username . "/posts/\" class=\"btn jagaFormButton\"><span class=\"glyphicon glyphicon-user\"></span> " . Lang::getLang('profile') . "</a>
						<a href=\"/u/" . $username . "/channels/\" class=\"btn jagaFormButton\"><span class=\"glyphicon glyphicon-th-large\"></span> " . Lang::getLang('channels') . "</a>
						<a href=\"/u/" . $username . "/subscriptions/\" class=\"btn jagaFormButton\"><span class=\"glyphicon glyphicon-star\"></span> " . Lang::getLang('subscriptions') . "</a>
					</div>
				";
			$html .= "\t\t</div>\n";
		$html .= "\t</div>\n";
		
		return $html;
		
	}	

	public function buildPage($urlArray, $inputArray = array(), $errorArray = array()) {

		$html = $this->getHeader();
		
			$navBar = new MenuView();
			$html .= $navBar->getNavBar();
		
			if (!empty($errorArray)) {
				$html .= "\t<!-- START ERROR ARRAY -->\n";
				$html .= "\t<div class=\"container\">\n";
					foreach ($errorArray AS $errorFlag) {
						foreach ($errorFlag AS $errorMessage) { $html .= "\t\t<div class=\"alert alert-danger col-sm-12 jagaErrorArray\">$errorMessage</div>\n"; }
					}
				$html .= "\t</div>\n";
				$html .= "\t<!-- END ERROR ARRAY -->\n\n";
			}
		
			if ($urlArray[0] == '') {
			
				if ($_SESSION['userID'] == 0 && (
					$_SESSION['channelID'] == 2006
					|| $_SESSION['channelID'] == 14
					|| $_SESSION['channelID'] == 21
				)) {
					$carousel = new CarouselView();
					$html .= $carousel->getCarousel();
				}
			
				if ($_SESSION['channelID'] == 2006) {

					$html .= ContentView::displayRecentContentItems(0, '', 50);
					
				} else {
				
					$html .= $this->getBreadcrumbs($urlArray);
					$categoryView = new CategoryView();
					$html .= $categoryView->displayChannelCategories($_SESSION['channelID']);
					
				}
				
			} elseif ($urlArray[0] == 'channels' && $_SESSION['channelID'] == 2006) {
				
				$html .= ChannelView::displayChannelList();

			} elseif ($urlArray[0] == 'imo') {
				
				$html .= MessageView::imo();
				
			} elseif ($urlArray[0] == 'home' && $_SESSION['channelID'] == 2006 && $_SESSION['userID'] != 0) {
				
				$html .= ContentView::displayRecentContentItems(0, '', 50, $_SESSION['userID']);

			} elseif ($urlArray[0] == 'register') {

				$html .= AuthenticationView::getAuthForm('register', $inputArray, $errorArray);

			} elseif ($urlArray[0] == 'thank-you-for-registering') {

				$html .= "\t\t<div class=\"container\">";
					$html .= "<div class=\"col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2\" style=\"margin-bottom:10px;\">";
						if ($_SESSION['lang'] == 'ja') {
							$html .= "ご登録をありがとうございました。よろしくお願い致します！";
						} else {
							$html .= "Thank you for registering for JAGA!";
						}
					$html .= "</div>";
				$html .= "</div>\n\n";
				$html .= AuthenticationView::getAuthForm('login', $inputArray, $errorArray);

			} elseif ($urlArray[0] == 'login') {
				$html .= AuthenticationView::getAuthForm('login', $inputArray, $errorArray);
			} elseif ($urlArray[0] == 'about') {
				$html .= ContentView::displayEasyContentView(10008);
			} elseif ($urlArray[0] == 'tos') {
				$html .= ContentView::displayEasyContentView(1000021);
			} elseif ($urlArray[0] == 'privacy') {
				$html .= ContentView::displayEasyContentView(1000022);
			} elseif ($urlArray[0] == 'sponsor') {
				$html .= "sponsor";
			} elseif ($urlArray[0] == 'sitemap') {
				$html .= "sitemap";
			} elseif ($urlArray[0] == 'contact') {
				$html .= "contact";
			} elseif ($urlArray[0] == 'k') {
			
				if ($urlArray[1] == '') { // /k/
					$html .= $this->getBreadcrumbs($urlArray);
					$html .= CategoryView::displayChannelCategoryList($_SESSION['channelID']);
				} elseif ($urlArray[1] == 'update') { // /k/update/<contentID>/
					$html .= ContentView::getContentForm('update', $urlArray[2], '', $inputArray, $errorArray);
				} elseif ($urlArray[1] == 'create') { // /k/create/<contentCategoryKey>/
					if (isset($inputArray['contentCategoryKey'])) { $contentCategoryKey = $inputArray['contentCategoryKey'];
					} else { $contentCategoryKey = $urlArray[2]; }
					$html .= ContentView::getContentForm('create', 0, $contentCategoryKey, $inputArray, $errorArray);
				} elseif ($urlArray[1] == 'comment') {
					$html .= $urlArray[2];
				} elseif ($urlArray[1] == 'delete' && is_numeric($urlArray[2])) {
					
					
					$html .= ContentView::displayContentDeleteConfirmationForm($urlArray[2]);
					
				} else {
					if ($urlArray[2] == '') { // /k/<contentCategoryKey>/
						$html .= $this->getBreadcrumbs($urlArray);
						$html .= ContentView::displayChannelContentList($_SESSION['channelID'],$urlArray[1]);
					} else { // /k/<contentCategoryKey>/<contentURL>/
						$contentURL = urldecode($urlArray[2]);
						$contentID = Content::getContentID($contentURL);
						$html .= $this->getBreadcrumbs($urlArray);
						$html .= ContentView::displayContentView($contentID);
						$html .= CommentView::displayCommentsView('Content', $contentID);
						$html .= CommentView::displayCommentForm('Content', $contentID);
					}
				}
				
			} elseif ($urlArray[0] == 'u') {
			
				$username = $urlArray[1];
				if (!User::usernameExists($username)) { die ('That username does not exist.'); }
				$userID = User::getUserID($username);
				$html .= UserView::displayUserProfile($userID);

			} elseif ($urlArray[0] == 'subscribe') {
			
				if ($_SESSION['userID'] == 0) {
					$html .= AuthenticationView::getAuthForm('login', $inputArray, $errorArray);
				} else {
					$html .= "<div class=\"container\">You have been subscribed to " . $_SESSION['channelKey'] . ".</div>";
				}
			
			} elseif ($urlArray[0] == 'unsubscribe') {
			
				if ($_SESSION['userID'] == 0) {
					$html .= AuthenticationView::getAuthForm('login', $inputArray, $errorArray);
				} else {
					$html .= "<div class=\"container\">You have been unsubscribed from " . $_SESSION['channelKey'] . ".</div>";
				}
			
			} elseif ($urlArray[0] == 'subscriptions') {

			} elseif ($urlArray[0] == 'settings') {
			
				$html .= $this->getSettingsNav($urlArray);
			
				if ($urlArray[1] == 'profile') {
				
					$userID = $_SESSION['userID'];
					$html .= UserView::displayUserForm($userID, $inputArray, $errorArray);

				} elseif ($urlArray[1] == 'channels') {
				
					if ($urlArray[2] == 'create') {
						$html .= ChannelView::getChannelForm('create', 0, $inputArray, $errorArray);
					} elseif ($urlArray[2] == 'update') {
						$channelID = Channel::getChannelID($urlArray[3]);
						$html .= ChannelView::getChannelForm('update', $channelID, $inputArray, $errorArray);
					} else {
						$html .= ChannelView::displayUserChannelList();
					}
				
				} elseif ($urlArray[1] == 'subscriptions') {
				
					$html .= SubscriptionView::displaySubscriptionSettingsList();
				
				}

			} elseif ($urlArray[0] == 'account-recovery') {
			
				$html .= AuthenticationView::accountRecoveryForm($inputArray, $errorArray);
			
			} elseif ($urlArray[0] == 'account-recovery-mail-sent') {
			
				$html .= AuthenticationView::accountRecoveryMailConfirmation();
			
			} elseif ($urlArray[0] == 'reset-password') {
			
				$html .= AuthenticationView::resetPasswordForm($urlArray, $inputArray, $errorArray);
			
			} elseif ($urlArray[0] == 'password-reset-successful') {
			
				$html .= AuthenticationView::passwordResetConfirmation();
				$html .= AuthenticationView::getAuthForm('login', $inputArray, $errorArray);

			} else {
				$html .= "\n\n\t<div class=\"container\">We upgraded The Kutchannel to <a href=\"http://github.com/chishiki/jaga/\">JAGA</a> on 3rd March 2015 and some URLs have changed; apologies for the inconvenience. You should be able to find what you were looking for from <a href=\"http://jaga.io/\">here</a>. Thanks for using The Kutchannel!</div>\n\n";
			}

			if ($_SESSION['userID'] == 2) {
			
				$html .= "\t<div class=\"container\">\n";

					if (!empty($_POST)) { 
						$html .= "\t\t<div class=\"row\">\n";
							$html .= "\t\t\t\t<div class=\"col-md-12 bg-warning\">";
								$html .= '<h3>$_POST</h3>';
								$html .= '<pre>' . print_r($_POST, true) . '</pre>';
							$html .= "</div>\n";
						$html .= "\t\t</div>\n";
					}
					
					$html .= "\t\t<div class=\"row\">\n";
					
						$html .= "\t\t\t<div class=\"col-md-3 bg-warning\">";
							$html .= '<h3>$urlArray</h3>';
							$html .= '<pre>' . print_r($urlArray, true) . '</pre>';
						$html .= "</div>\n";
						
						$html .= "\t\t\t<div class=\"col-md-3 bg-warning\">";
							$html .= '<h3>Session::sessionArray</h3>';
							$html .= '<pre>' . print_r(Session::sessionDump(), true) . '</pre>';
						$html .= "</div>\n";
						
						$html .= "\t\t\t<div class=\"col-md-3 bg-warning\">";
							$html .= '<h3>$_SESSION</h3>';
							$html .= '<pre>' . print_r($_SESSION, true) . '</pre>';
						$html .= "</div>\n";
						
						$html .= "\t\t\t<div class=\"col-md-3 bg-warning\">";
							$html .= '<h3>$_COOKIE</h3>';
							$html .= '<pre>' . print_r($_COOKIE, true) . '</pre>';
						$html .= "</div>\n";

					$html .= "\t\t</div>\n";

				$html .= "\t</div>\n";
			
			}
		
		$html .= $this->getFooter();
		
		$previousPage = trim(implode('/', $urlArray), '/');
		if ($previousPage == 'lang/en' || $previousPage == 'lang/ja' || $previousPage == '') { $_SESSION['previousPage'] = '/'; } else { $_SESSION['previousPage'] = $previousPage; }

		return $html;
		
	}

}

?>