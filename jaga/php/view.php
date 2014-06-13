<?php

class AuthenticationView {

	public static function getAuthForm($type, $errorArray = array()) {
	
		$html = "\n\n";
		$html .= "\t<div class=\"container\" style=\"margin-top:30px;\">\n";
		$html .= "\t<!-- START AUTH CONTAINER -->\n\n";

		if ($type == 'login') {
	
			$html .= "\t\t<!-- START jagaLogin -->\n";
			$html .= "\t\t<div id=\"jagaLogin\" class=\"mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2\">\n\n";

				$html .= "\t\t\t<!-- START PANEL -->\n";
				$html .= "\t\t\t<div class=\"panel panel-default\" >\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-HEADING -->\n";
					$html .= "\t\t\t\t<div class=\"panel-heading\">\n\n";
						
						$html .= "\t\t\t\t\t<div class=\"panel-title\">Login to The Kutchannel</div>\n";
					
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-HEADING -->\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-BODY -->\n";
					$html .= "\t\t\t\t<div style=\"padding-top:30px\" class=\"panel-body\">\n\n";
					
						
						// if (!empty($errorArray)) {
							// foreach ($errorArray AS $value) { $html .= "\t\t\t\t\t<div id=\"login-alert\" class=\"alert alert-danger col-sm-12\">$value</div>\n"; }
						// }
						
						
						$html .= "\t\t\t\t\t<!-- START jagaLoginForm -->\n";
						$html .= "\t\t\t\t\t<form role=\"form\" id=\"jagaLoginForm\" name=\"login\" class=\"form-horizontal\" method=\"post\" action=\"/login/\">\n\n";
					
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom:25px;\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"login-username\" type=\"text\" class=\"form-control\" name=\"username\" value=\"\" placeholder=\"username or email\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom: 25px\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"login-password\" type=\"password\" class=\"form-control\" name=\"password\" placeholder=\"password\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-top:10px\" class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-12 controls\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"submit\" name=\"jagaLoginSubmit\" id=\"jagaLoginSubmit\" class=\"btn btn-default pull-right\" value=\"Login\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
			
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-md-12 control\">\n";
									$html .= "\t\t\t\t\t\t\t\t<div style=\"border-top: 1px solid#888; padding-top:15px; font-size:85%\" >Don\'t have a Kutchannel account? <a href=\"/register/\">Register</a></div>\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
			
						$html .= "\t\t\t\t\t</form>\n";
						$html .= "\t\t\t\t\t<!-- END jagaLoginForm -->\n\n";
			
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-BODY -->\n\n";
			
				$html .= "\t\t\t</div>\n";
				$html .= "\t\t\t<!-- END PANEL -->\n\n";
			
			$html .= "\t\t</div>\n";
			$html .= "\t\t<!-- END jagaLogin -->\n\n";
	
		}
		
		if ($type == 'register') {
		
			$html .= "\t\t<!-- START jagaRegister -->\n";
			$html .= "\t\t<div id=\"jagaRegister\" class=\"mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2\">\n\n";
			
				$html .= "\t\t\t<!-- START PANEL -->\n";
				$html .= "\t\t\t<div class=\"panel panel-default\" >\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-HEADING -->\n";
					$html .= "\t\t\t\t<div class=\"panel-heading\">\n\n";

						$html .= "\t\t\t\t\t<div class=\"panel-title\">Register for The Kutchannel</div>\n";
						// $html .= "\t\t\t\t\t<div style=\"float:right;font-size:85%;position:relative;top:-10px;\"><a href=\"/login/\">Login</a></div>\n";
						
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-HEADING -->\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-BODY -->\n";
					$html .= "\t\t\t\t<div class=\"panel-body\">\n\n";
					
					
						$html .= "\t\t\t\t\t<!-- START jagaRegisterForm -->\n";
						$html .= "\t\t\t\t\t<form name=\"jagaRegisterForm\" id=\"signupform\" class=\"form-horizontal\" role=\"form\" method=\"post\" action=\"/register/\">\n\n";
						
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom:25px;\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"register-username\" type=\"text\" class=\"form-control\" name=\"username\" value=\"\" placeholder=\"desired username\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom:25px;\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-envelope\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"register-email\" type=\"email\" class=\"form-control\" name=\"userEmail\" value=\"\" placeholder=\"email\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom: 25px\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"register-password\" type=\"password\" class=\"form-control\" name=\"password\" placeholder=\"password\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom: 25px\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"register-confirm-password\" type=\"password\" class=\"form-control\" name=\"confirmPassword\" placeholder=\"confirm password\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-top:10px\" class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-12 controls\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"submit\" name=\"jagaRegisterSubmit\" id=\"jagaRegisterSubmit\" class=\"btn btn-default pull-right\" value=\"Register\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";

						$html .= "\t\t\t\t\t</form>\n";
						$html .= "\t\t\t\t\t<!-- END jagaRegisterForm -->\n\n";
					
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-BODY -->\n\n";
					
				$html .= "\t\t\t\t</div>\n";
				$html .= "\t\t\t\t<!-- END PANEL -->\n\n";
			
			$html .= "\t\t</div>\n";
			$html .= "\t\t<!-- END jagaRegister -->\n\n";
		}
			
		$html .= "\t</div>\n";
		$html .= "\t<!-- END AUTH CONTAINER -->\n\n";
			
		return $html;
	
	}
}

class CarouselView {

	public function getCarousel() {
	
		$html = "
		<div class=\"container\">
			<div id=\"kutchannel-carousel\" class=\"carousel slide\" data-ride=\"carousel\">

				<!-- Indicators -->
				<ol class=\"carousel-indicators\">
					<li data-target=\"#kutchannel-carousel\" data-slide-to=\"0\" class=\"active\"></li>
					<li data-target=\"#kutchannel-carousel\" data-slide-to=\"1\"></li>
					<li data-target=\"#kutchannel-carousel\" data-slide-to=\"2\"></li>
				</ol>

				<!-- START SLIDES -->
				
				<div class=\"carousel-inner\">
					<div class=\"item active\">
						<img src=\"/jaga/images/test1.jpg\" alt=\"test1\" style=\"margin-left:auto;margin-right:auto;\">
					</div>
					<div class=\"item\">
						<img src=\"/jaga/images/test2.jpg\" alt=\"test2\" style=\"margin-left:auto;margin-right:auto;\">
					</div>
					<div class=\"item\">
						<img src=\"/jaga/images/test3.jpg\" alt=\"test3\" style=\"margin-left:auto;margin-right:auto;\">
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

class CategoryView {
	

	public function displayChannelCategories($channelID) {

		$core = Core::getInstance();
		$query = "
			SELECT `contentCategoryKey`, COUNT(`contentCategoryKey`)
			FROM `nisekocms_content`
			WHERE siteID = :channelID
			GROUP BY `contentCategoryKey`
			ORDER BY COUNT(`contentCategoryKey`) DESC
		";
		
		$statement = $core->database->prepare($query);
		$statement->execute(array(':channelID' => $channelID));
		
		$html = '';
		while ($row = $statement->fetch()) {
		
			$contentCategoryKey = $row['contentCategoryKey'];
		
			$html .= "<div class=\"col-md-4\">";
			
				$html .= "<div class=\"panel panel-default\">\n";
				
					$html .= "<div class=\"panel-heading\">" . $contentCategoryKey . "</div>\n";
					
					// $html .= "<div class=\"panel-body\">\n";
						// $html .= "<p>...</p>\n";
					// $html .= "</div>\n";

					$html .= "<ul class=\"list-group\">\n";
						$html .= "<li class=\"list-group-item\"><span class=\"badge\">14</span>Cras justo odio</li>\n";
						$html .= "<li class=\"list-group-item\"><span class=\"badge\">14</span>Dapibus ac facilisis in</li>\n";
						$html .= "<li class=\"list-group-item\"><span class=\"badge\">14</span>Morbi leo risus</li>\n";
						$html .= "<li class=\"list-group-item\"><span class=\"badge\">14</span>Porta ac consectetur ac</li>\n";
						$html .= "<li class=\"list-group-item\"><span class=\"badge\">14</span>Vestibulum at eros</li>\n";
					$html .= "</ul>\n";
					
				$html .= "</div>\n";
				
				
			$html .= "</div>";
		}
		
		return $html;
		
	
	}
	
}

class ContentView {

}

class MenuView {

	public function getNavBar() {
	
		$channel = new Channel($_SESSION['channelID']);
	
		$html = "
			<!-- START NAVIGATION DIV -->
			<div class=\"navbar-wrapper\">
				<!-- START NAV -->
				<nav class=\"navbar navbar-default navbar-fixed-top\" role=\"navigation\">
					<!-- START CONTAINER -->
					<div class=\"container\">
						<!-- START NAVBAR-HEADER -->
						<div class=\"navbar-header\">
							<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
								<span class=\"sr-only\">Toggle navigation</span>
								<span class=\"icon-bar\"></span>
								<span class=\"icon-bar\"></span>
								<span class=\"icon-bar\"></span>
							</button>
							";
							
							// if ($_SESSION['channelID'] == 55) {
								// $html .= "<a href=\"/\"><img id=\"kLogo\" src=\"/jaga/images/redpill-banner.png\"></a>";
							// } elseif ($_SESSION['channelID'] == 28) {
								// $html .= "<a href=\"/\"><img id=\"kLogo\" src=\"/jaga/images/agileeikaiwa-banner.png\"></a>";
							// } else
							
							if ($_SESSION['channelID'] == 2006 || $_SESSION['channelID'] == 14) {
								$html .= "<a href=\"/\"><img id=\"kLogo\" src=\"/jaga/images/banner.png\"></a>";
							} else {
								$html .= "<a class=\"navbar-brand\" href=\"/\">" . strtoupper($channel->getChannelTitle()) . "</a>";
							}
							
							
							$html .= "
						</div>
						<!-- END NAVBAR-HEADER -->

						<!-- START NAVBAR-COLLAPSE -->
						<div class=\"collapse navbar-collapse\">
						
							<ul class=\"nav navbar-nav navbar-right\">
								
								<li class=\"dropdown\"><a href=\"/\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">";

								// $channel = new Channel($_SESSION['channelID']);
								// $html .= strtoupper($channel->getChannelTitle());
								
								
					$html .= "THIS CHANNEL
								<b class=\"caret\"></b></a>
									<ul class=\"dropdown-menu\">
					";

										
					$channelContentCategoryArray = Channel::getChannelCategoryArray($_SESSION['channelID']);
					
					foreach ($channelContentCategoryArray AS $key => $value) {
						if ($key != '') {
							$html .= "<li><a href=\"/k/$key/\">" . strtoupper($key) . "<span class=\"badge pull-right\">$value</span></a></li>";
						}
					}

										
					$html .= "
										<li><a href=\"/k/\">...more</a></li>
									</ul>
								</li>
								
								<li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">YOUR CHANNELS <b class=\"caret\"></b></a>
									<ul class=\"dropdown-menu\">
								";
								
								if ($_SESSION['userID'] == 0) {
									$html .= "<li><a href=\"/login/\">LOGIN</a></li>";
									$html .= "<li><a href=\"/register/\">REGISTER</a></li>";
								} else {
								
									
								$userChannelArray = Channel::getUserChannelArray($_SESSION['channelID']);
					
								$i = 0;
								foreach ($userChannelArray AS $key => $value) {
									if ($i < 10) { 
										if ($key != '') {
											$html .= "<li><a href=\"http://$key.kutchannel.net/\">" . strtoupper($key);
												// $html .= "<span class=\"badge pull-right\">$value</span>";
											$html .= "</a></li>";
										}
									}
									$i++;
								}

								
									// $html .= "
										// <li><a href=\"http://redpill.kutchannel.net/\">RED PILL</a></li>
										// <li><a href=\"http://hakodate.kutchannel.net/\">HAKODATE</a></li>
										// <li><a href=\"http://seattle.kutchannel.net/\">SEATTLE</a></li>
										// <li><a href=\"http://eikaiwa.kutchannel.net/\">EIKAIWA</a></li>
										// <li><a href=\"http://chishiki.kutchannel.net/\">CHISHIKI</a></li>
										// <li><a href=\"http://the.kutchannel.net/\">...more</a></li>
									// ";
								}
								
										
								
								$html .= "
									</ul>
								</li>
								
								<li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">OTHER CHANNELS <b class=\"caret\"></b></a>
									<ul class=\"dropdown-menu\">
										<li><a href=\"http://redpill.kutchannel.net/\">RED PILL</a></li>
										<li><a href=\"http://hakodate.kutchannel.net/\">HAKODATE</a></li>
										<li><a href=\"http://seattle.kutchannel.net/\">SEATTLE</a></li>
										<li><a href=\"http://eikaiwa.kutchannel.net/\">EIKAIWA</a></li>
										<li><a href=\"http://chishiki.kutchannel.net/\">CHISHIKI</a></li>
										<li><a href=\"http://the.kutchannel.net/\">...more</a></li>
									</ul>
								</li>
								<li><a href=\"http://the.kutchannel.net/\"><span class=\"glyphicon glyphicon-home\"></span><span class=\"visible-xs\">HOME</span></a></li>
								";
		
								$user = new User($_SESSION['userID']);
								$username = $user->username;
								
								if ($_SESSION['userID'] == 0) {
									$html .= "<li><a href=\"/login/\"><span class=\"glyphicon glyphicon-log-in\"></span><span class=\"visible-xs\">LOGIN</span></a></li>";
								} else {
									$html .= "
									
									<li><a href=\"/u/" .  $username . "/\"><span class=\"glyphicon glyphicon glyphicon-user\"></span><span class=\"visible-xs\">PROFILE</span></a></li>
									
									";
									$html .= "<li><a href=\"/messages/\"><span class=\"glyphicon glyphicon-envelope\"></span><span class=\"visible-xs\">MESSAGES</span></a></li>";
									$html .= "<li><a href=\"/settings/\"><span class=\"glyphicon glyphicon-cog\"></span><span class=\"visible-xs\">SETTINGS</span></a></li>";
									$html .= "<li><a href=\"/logout/\"><span class=\"glyphicon glyphicon-log-out\"></span><span class=\"visible-xs\">LOGOUT</span></a></li>";
								}
								
								$html .= "
								
							</ul>
							
						</div>
						<!-- END NAVBAR-COLLAPSE -->
					</div>
					<!-- END CONTAINER -->
				</nav>
				<!-- END NAV -->
			</div>
			<!-- END NAVIGATION DIV -->
		";
		
		return $html;
		
	}

}

class ProfileView {

}

class PageView {

	public $pageTitle;
	public $pageKeywords;
	public $pageDescription;
	
	public function __construct() {
	
		$channelID = Session::getSession('channelID');
		$channel = new Channel($channelID);
		$this->pageTitle = $channel->channelTitle;
		$this->pageKeywords = $channel->channelKeywords;
		$this->pageDescription = $channel->channelDescription;
	}
	
	public function buildPage($urlArray, $errorArray = array()) {

		$html = $this->getHeader();
		
			$navBar = new MenuView();
			$html .= $navBar->getNavBar();
		
			if (!empty($errorArray)) {
				$html .= "\t\t<!-- START ERROR ARRAY -->\n";
				$html .= "\t\t<div class=\"container\">\n";
					foreach ($errorArray AS $value) {
						$html .= "\t\t\t<div class=\"alert alert-danger col-sm-12 jagaErrorArray\">$value</div>\n";
					}
				$html .= "\t\t</div>\n";
				$html .= "\t\t<!-- END ERROR ARRAY -->\n\n";
			}
		
			if ($urlArray[0] == '' && $_SESSION['channelID'] == 2006 && $_SESSION['userID'] == 0) {
				$carousel = new CarouselView();
				$html .= $carousel->getCarousel();
			}
			

			$html .= "\t\t<div class=\"container\">\n";

				if ($urlArray[0] == '') {
					
					$categoryView = new CategoryView();
					$html .= $categoryView->displayChannelCategories($_SESSION['channelID']);
					
					
				} elseif ($urlArray[0] == 'register') {
					$html .= AuthenticationView::getAuthForm('register', $errorArray);
				} elseif ($urlArray[0] == 'login') {
					$html .= AuthenticationView::getAuthForm('login', $errorArray);
				} elseif ($urlArray[0] == 'logout') {
					$html .= "logout";
				} elseif ($urlArray[0] == 'about') {
					$html .= "about";
				} elseif ($urlArray[0] == 'tos') {
					$html .= "tos";
				} elseif ($urlArray[0] == 'privacy') {
					$html .= "privacy";
				} elseif ($urlArray[0] == 'sponsor') {
					$html .= "sponsor";
				} elseif ($urlArray[0] == 'sitemap') {
					$html .= "sitemap";
				} elseif ($urlArray[0] == 'contact') {
					$html .= "contact";
				} elseif ($urlArray[0] == 'k') {
					$html .= "K is for Kontent";
					
					
					
				} else {
					$html .= "404: " . $urlArray[0];
				}
		
			$html .= "\t\t</div>\n";
			
			if ($_SESSION['userID'] == 2) {
			
				$html .= "\t\t<div class=\"container\">\n";

					$html .= "\t\t\t<div class=\"row\">\n";
					
						$html .= "\t\t\t\t<div class=\"col-md-3 bg-warning\">";
							$html .= '<h3>Session::sessionArray</h3>';
							$html .= '<pre>' . print_r(Session::sessionDump(), true) . '</pre>';
						$html .= "</div>\n";
						
						$html .= "\t\t\t\t<div class=\"col-md-3 bg-warning\">";
							$html .= '<h3>$_COOKIE</h3>';
							$html .= '<pre>' . print_r($_COOKIE, true) . '</pre>';
						$html .= "</div>\n";
						
						$html .= "\t\t\t\t<div class=\"col-md-3 bg-warning\">";
							$html .= '<h3>$_POST</h3>';
							$html .= '<pre>' . print_r($_POST, true) . '</pre>';
						$html .= "</div>\n";
						
						$html .= "\t\t\t\t<div class=\"col-md-3 bg-warning\">";
							$html .= '<h3>$urlArray</h3>';
							$html .= '<pre>' . print_r($urlArray, true) . '</pre>';
						$html .= "</div>\n";
						
					$html .= "\t\t\t</div>\n";
					
					$html .= "\t\t\t<div class=\"row\">\n";
					
						if (isset($_SESSION)) { 
							$html .= "\t\t\t\t<div class=\"col-md-12 bg-warning\">";
								$html .= '<h3>$_SESSION</h3>';
								$html .= '<pre>' . print_r($_SESSION, true) . '</pre>';
							$html .= "</div>\n";
						}

					$html .= "\t\t\t</div>\n";					
					
				$html .= "\t\t</div>\n";
			
			}
		
		$html .= $this->getFooter();
		
		return $html;
		
	}
	
	private function getHeader() {

		$html = "<!DOCTYPE html>\n";
		$html .= "<html lang=\"en\">\n\n";
		
			$html .= "\t<head>\n\n";
			
				$html .= "\t\t<title>" . $this->pageTitle . "</title>\n\n";

				$html .= "\t\t<meta charset=\"utf-8\">\n\n";
				
				$html .= "\t\t<meta name=\"robots\" content=\"INDEX, FOLLOW\">\n";
				$html .= "\t\t<meta name=\"description\" content=\"" . $this->pageDescription . "\">\n";
				$html .= "\t\t<meta name=\"keywords\" content=\"" . $this->pageKeywords . "\">\n";
				$html .= "\t\t<meta name=\"author\" content=\"Christopher Webb\">\n";
				$html .= "\t\t<meta name=\"generator\" content=\"The Kutchannel\">\n";
				$html .= "\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">\n";
				$html .= "\t\t<meta name=\"apple-mobile-web-app-capable\" content=\"yes\">\n";
				$html .= "\t\t<meta name=\"apple-mobile-web-app-status-bar-style\" content=\"black-translucent\">\n\n";

				$html .= "\t\t<link rel=\"icon\" type=\"image/x-icon\" href=\"/jaga/images/favicon.ico\"/>\n\n";

				$html .= "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"/jaga/bootstrap/3.1.1/css/bootstrap.min.css\">\n";
				$html .= "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"/jaga/css/kutchannel.css\" />\n";
				$html .= "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"/channel.css\" />\n\n";

			$html .= "\t</head>\n\n";

			$html .= "\t<body>\n\n";
			
		return $html;
		
	}
	
	private function getFooter() {

				$html = "\n\n";
				$html .= "\t\t<div id=\"footer\">\n";
					$html .= "\t\t\t<div class=\"container\">\n";
					
					
					
						$html .= "\t\t\t\t<p class=\"text-muted\">";
							$html .= "<a href=\"http://the.kutchannel.net/about/\">About</a> | ";
							$html .= "<a href=\"http://the.kutchannel.net/tos/\">Terms of Service</a> | ";
							$html .= "<a href=\"http://the.kutchannel.net/privacy/\">Privacy Policy</a> | ";
							$html .= "<a href=\"http://the.kutchannel.net/advertise/\">Advertise</a> | ";
							$html .= "<a href=\"http://the.kutchannel.net/sitemap/\">Sitemap</a> | ";
							$html .= "<a href=\"http://the.kutchannel.net/contact/\">Contact</a> | ";
							$html .= "&copy; The Kutchannel 2006-" . date('Y');
						$html .= "</p>\n";
						
					$html .= "\t\t\t</div>\n";
				$html .= "\t\t</div>\n\n";
				
				$html .= "\t\t<script type=\"text/javascript\" src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js\"></script>\n";
				$html .= "\t\t<script type=\"text/javascript\" src=\"/jaga/bootstrap/3.1.1/js/bootstrap.min.js\"></script>\n\n";
			$html .= "\t</body>\n\n";
		$html .= "</html>";
		
		return $html;
		
	}

}

class ThemeView {

	public $navbarBackgroundColor;
	public $navbarBackgroundColorActive;
	public $navbarBorderColor;
	public $navbarTextColor;
	public $navbarTextColorHover;
	public $navbarTextColorActive;
	
	public function __construct() {
	
		$channelKey = $_SESSION['channelID'];

		$core = Core::getInstance();
		$query = "
			SELECT 
				navbarBackgroundColor, 
				navbarBackgroundColorActive, 
				navbarBorderColor, 
				navbarTextColor, 
				navbarTextColorHover, 
				navbarTextColorActive
			FROM jaga_channel
			WHERE siteID = :channelKey
			LIMIT 1
		";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':channelKey' => $channelKey));
		$row = $statement->fetch();

		$this->navbarBackgroundColor = $row['navbarBackgroundColor'];
		$this->navbarBackgroundColorActive = $row['navbarBackgroundColorActive'];
		$this->navbarBorderColor = $row['navbarBorderColor'];
		$this->navbarTextColor = $row['navbarTextColor'];
		$this->navbarTextColorHover = $row['navbarTextColorHover'];
		$this->navbarTextColorActive = $row['navbarTextColorActive'];
		
	}
	
	public function getTheme() {
	
		$navbarBackgroundColor = $this->navbarBackgroundColor;
		$navbarBackgroundColorActive = $this->navbarBackgroundColorActive;
		$navbarBorderColor = $this->navbarBorderColor;
		$navbarTextColor = $this->navbarTextColor;
		$navbarTextColorHover = $this->navbarTextColorHover;
		$navbarTextColorActive = $this->navbarTextColorActive; // #$navbarTextColorActive : active color

		$css = "#footer {
			background-color:#$navbarBackgroundColor;
			a { color:#$navbarTextColor !important; }
		}\n\n";

		$css .= "
		
			.navbar-default {
				background-color: #$navbarBackgroundColor;
				border-color: #$navbarBorderColor;
			}
			/* title */
			.navbar-default .navbar-brand {
				color: #$navbarTextColor;
			}
			.navbar-default .navbar-brand:hover,
			.navbar-default .navbar-brand:focus {
				color: #5E5E5E;
			}
			/* link */
			.navbar-default .navbar-nav > li > a {
				color: #$navbarTextColor;
			}
			.navbar-default .navbar-nav > li > a:hover,
			.navbar-default .navbar-nav > li > a:focus {
				color: #$navbarTextColorHover;
			}
			.navbar-default .navbar-nav > .active > a, 
			.navbar-default .navbar-nav > .active > a:hover, 
			.navbar-default .navbar-nav > .active > a:focus {
				color: #$navbarTextColorActive;
				background-color: #$navbarBorderColor;
			}
			.navbar-default .navbar-nav > .open > a, 
			.navbar-default .navbar-nav > .open > a:hover, 
			.navbar-default .navbar-nav > .open > a:focus {
				color: #$navbarTextColorActive;
				background-color: #$navbarBackgroundColorActive;
			}
			/* caret */
			.navbar-default .navbar-nav > .dropdown > a .caret {
				border-top-color: #$navbarTextColor;
				border-bottom-color: #$navbarTextColor;
			}
			.navbar-default .navbar-nav > .dropdown > a:hover .caret,
			.navbar-default .navbar-nav > .dropdown > a:focus .caret {
				border-top-color: #$navbarTextColorHover;
				border-bottom-color: #$navbarTextColorHover;
			}
			.navbar-default .navbar-nav > .open > a .caret, 
			.navbar-default .navbar-nav > .open > a:hover .caret, 
			.navbar-default .navbar-nav > .open > a:focus .caret {
				border-top-color: #$navbarTextColorActive;
				border-bottom-color: #$navbarTextColorActive;
			}
			/* mobile version */
			.navbar-default .navbar-toggle {
				border-color: #DDD;
			}
			.navbar-default .navbar-toggle:hover,
			.navbar-default .navbar-toggle:focus {
				background-color: #DDD;
			}
			.navbar-default .navbar-toggle .icon-bar {
				background-color: #CCC;
			}
			@media (max-width: 767px) {
				.navbar-default .navbar-nav .open .dropdown-menu > li > a {
					color: #$navbarTextColor;
				}
				.navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
				.navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
					color: #$navbarTextColorHover;
				}
			}
			
		";
		
		return $css;
	
	}


}

?>