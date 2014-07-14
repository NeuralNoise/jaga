<?php
class PageView {

	public $pageTitle;
	public $pageKeywords;
	public $pageDescription;
	
	public function __construct() {
	
		$channelID = Session::getSession('channelID');
		$channel = new Channel($channelID);
		$this->pageTitle = $channel->channelTitleEnglish;
		$this->pageKeywords = $channel->channelKeywordsEnglish;
		$this->pageDescription = $channel->channelDescriptionEnglish;
	}
	
	public function buildPage($urlArray, $inputArray = array(), $errorArray = array()) {

		// print_r($inputArray);
		
		$html = $this->getHeader();
		
			$navBar = new MenuView();
			$html .= $navBar->getNavBar();
		
			if (!empty($errorArray)) {
				$html .= "\t<!-- START ERROR ARRAY -->\n";
				$html .= "\t<div class=\"container\">\n";
					foreach ($errorArray AS $value) {
						$html .= "\t\t<div class=\"alert alert-danger col-sm-12 jagaErrorArray\">$value</div>\n";
					}
				$html .= "\t</div>\n";
				$html .= "\t<!-- END ERROR ARRAY -->\n\n";
			}
		
			if ($urlArray[0] == '' && $_SESSION['channelID'] == 2006 && $_SESSION['userID'] == 0) {
				$carousel = new CarouselView();
				$html .= $carousel->getCarousel();
			}
			

			

			if ($urlArray[0] == '') {
			
				$categoryView = new CategoryView();
				$html .= $categoryView->displayChannelCategories($_SESSION['channelID']);
				
			} elseif ($urlArray[0] == 'register') {
			
				$html .= AuthenticationView::getAuthForm('register', $errorArray);
				
			} elseif ($urlArray[0] == 'login') {
			
				$html .= AuthenticationView::getAuthForm('login', $errorArray);
				
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

				if ($urlArray[1] == '') { // /k/
					$html .= $this->getBreadcrumbs($urlArray);
					$html .= CategoryView::displayChannelCategoryList($_SESSION['channelID']);
				} elseif ($urlArray[1] == 'update') { // /k/update/<contentID>/
					$html .= ContentView::getContentForm('update', $urlArray[2], '', $inputArray, $errorArray);
				} elseif ($urlArray[1] == 'create') { // /k/create/<contentCategoryKey>/
					if (isset($inputArray['contentCategoryKey'])) { $contentCategoryKey = $inputArray['contentCategoryKey'];
					} else { $contentCategoryKey = $urlArray[2]; }
					$html .= ContentView::getContentForm('create', 0, $contentCategoryKey, $inputArray, $errorArray);
				} else {
					if ($urlArray[2] == '') { // /k/<contentCategoryKey>/
						$html .= $this->getBreadcrumbs($urlArray);
						$html .= ContentView::displayChannelContentList($_SESSION['channelID'],$urlArray[1]);
					} else { // /k/<contentCategoryKey>/<contentURL>/
						$contentURL = urldecode($urlArray[2]);
						$contentID = Content::getContentID($contentURL);
						$html .= $this->getBreadcrumbs($urlArray);
						$html .= ContentView::displayContentView($contentID);
						$html .= CommentView::displayContentCommentsView($contentID);
					}
				}
				
			} elseif ($urlArray[0] == 'u') {
			
				$username = $urlArray[1];
				if (!User::usernameExists($username)) { die ('That username does not exist.'); }
				$html .= "I fight for the Users (user profiles: /u/" . $username . "/)";
				
			} elseif ($urlArray[0] == 'manage-channels') {
			
				if ($urlArray[1] == 'create') {
					$html .= ChannelView::getChannelForm('create', 0, $inputArray, $errorArray);
				} elseif ($urlArray[1] == 'update') {
					$channelID = Channel::getChannelID($urlArray[2]);
					$html .= ChannelView::getChannelForm('update', $channelID, $inputArray, $errorArray);
				} else {
					$html .= ChannelView::displayUserChannelList();
				}
				
			} elseif ($urlArray[0] == 'subscriptions') {
			

				
			} else {
				$html .= "\n\n\t<!-- START 404 TEXT -->\n";
					$html .= "\t\t<div class=\"container\">404: " . $urlArray[0] . "</div>\n";
				$html .= "\t<!-- END 404 TEXT -->\n\n";
			}
		
			
			
			
			
			if ($_SESSION['userID'] == 2) {
			
				$html .= "\t<div class=\"container\">\n";

					$html .= "\t\t<div class=\"row\">\n";
					
						$html .= "\t\t\t<div class=\"col-md-3 bg-warning\">";
							$html .= '<h3>Session::sessionArray</h3>';
							$html .= '<pre>' . print_r(Session::sessionDump(), true) . '</pre>';
						$html .= "</div>\n";
						
						$html .= "\t\t\t<div class=\"col-md-3 bg-warning\">";
							$html .= '<h3>$_COOKIE</h3>';
							$html .= '<pre>' . print_r($_COOKIE, true) . '</pre>';
						$html .= "</div>\n";
						
						$html .= "\t\t\t<div class=\"col-md-3 bg-warning\">";
							$html .= '<h3>$_POST</h3>';
							$html .= '<pre>' . print_r($_POST, true) . '</pre>';
						$html .= "</div>\n";
						
						$html .= "\t\t\t<div class=\"col-md-3 bg-warning\">";
							$html .= '<h3>$urlArray</h3>';
							$html .= '<pre>' . print_r($urlArray, true) . '</pre>';
						$html .= "</div>\n";
						
					$html .= "\t\t</div>\n";
					
					$html .= "\t\t<div class=\"row\">\n";
					
						if (isset($_SESSION)) { 
							$html .= "\t\t\t\t<div class=\"col-md-12 bg-warning\">";
								$html .= '<h3>$_SESSION</h3>';
								$html .= '<pre>' . print_r($_SESSION, true) . '</pre>';
							$html .= "</div>\n";
						}

					$html .= "\t\t</div>\n";					
					
				$html .= "\t</div>\n";
			
			}
		
		$html .= $this->getFooter();
		
		return $html;
		
	}
	
	private function getHeader() {

		$html = "<!DOCTYPE html>\n";
		$html .= "<html lang=\"en\">\n\n";
		
			$html .= "\t<head>\n\n";
			
				$html .= "\t\t<title>" . $this->pageTitle . "</title>\n\n";
				
				$html .= "\t\t<meta charset=\"utf-8\">\n";
				$html .= "\t\t<meta name=\"robots\" content=\"NOINDEX, NOFOLLOW\">\n\n";
				
				$html .= "\t\t<meta name=\"keywords\" content=\"" . $this->pageKeywords . "\">\n";
				$html .= "\t\t<meta name=\"description\" content=\"" . $this->pageDescription . "\">\n\n";
				
				$html .= "\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">\n";
				$html .= "\t\t<meta name=\"apple-mobile-web-app-capable\" content=\"yes\">\n";
				$html .= "\t\t<meta name=\"apple-mobile-web-app-status-bar-style\" content=\"black-translucent\">\n\n";

				$html .= "\t\t<meta name=\"author\" content=\"Chishiki\">\n";
				$html .= "\t\t<meta name=\"generator\" content=\"The Kutchannel\">\n\n";
				
				$html .= "\t\t<link rel=\"icon\" type=\"image/x-icon\" href=\"/jaga/images/favicon.ico\"/>\n\n";

				$html .= "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"/jaga/bootstrap/3.1.1/css/bootstrap.min.css\">\n";
				$html .= "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"/jaga/css/kutchannel.css\" />\n";
				$html .= "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"/channel.css\" />\n\n";

				// $html .= "\t\t<script type=\"text/javascript\">";
					// $html .= "
					// $(document).ready(function () {
						// if ($(\"[rel=tooltip]\").length) {
						// $(\"[rel=tooltip]\").tooltip();
						// }
					// });
					// \n";
				// $html .= "\t\t</script>\n\n";

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
				$html .= "\t\t<script type=\"text/javascript\" src=\"/jaga/bootstrap/3.1.1/js/bootstrap.min.js\"></script>\n";
				
				$html .= "
				<script>
				jQuery(document).ready(function($) {
					  $(\".jagaClickableRow\").click(function() {
							window.document.location = $(this).data('url');
					  });
				});
				</script>
				";
			
				// $html .= "\t\t<script type=\"text/javascript\" src=\"/jaga/js/tooltip.js\"></script>\n\n";
				
				// $html .= "\t\t<script type=\"text/javascript\">\n";
					// $html .= "\t\t\t$(function () {\n";
						// $html .= "\t\t\t\t$(\"[rel='tooltip']\").tooltip();\n";
					// $html .= "\t\t\t});\n";
				// $html .= "\t\t</script>\n\n";
				
			$html .= "\t</body>\n\n";
		$html .= "</html>";
		
		return $html;
		
	}

	private function getBreadcrumbs($urlArray) {
	
		$channel = new Channel($_SESSION['channelID']);
		$channelKey = $channel->channelKey;
		$channelTitle = $channel->channelTitleEnglish;
		
		
		$html = "<div class=\"container\"><ol class=\"breadcrumb\">";
			$html .= "<li><a href=\"http://the.kutchannel.net/\">THE KUTCHANNEL</a></li>";
			$html .= "<li><a href=\"http://" . $channelKey . ".kutchannel.net/\">" . strtoupper($channelTitle) . "</a></li>";
			if ($urlArray[0] == 'k' && $urlArray[1] != '' && $urlArray[2] == '') { // /k/<contentCategoryKey>/
				$html .= "<li class=\"active\"><a href=\"http://" . $channelKey . ".kutchannel.net/k/" . $urlArray[1] . "\">" . strtoupper($urlArray[1]) . "</a></li>";
			} elseif ($urlArray[0] == 'k' && $urlArray[1] != '' && $urlArray[2] != '') { // /k/<contentCategoryKey>/<contentURL>/
				$html .= "<li class=\"active\"><a href=\"http://" . $channelKey . ".kutchannel.net/k/" . $urlArray[1] . "/" . strtoupper($urlArray[2]) . "/\">" . strtoupper(urldecode($urlArray[2])) . "</a></li>";	
			}
		$html .= "</ol></div>";
		return $html;
		
	}
	
}

?>