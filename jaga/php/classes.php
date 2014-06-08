<?php

class Authentication {

	public function login() {
	
	}
	
	public function logout() {
	
	}
	
	public function register() {
	
	}
	
	public function isLoggedIn() {
	
	}
	
}

class Calendar {

}

class Carousel {

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

class Category {

}

class Channel {

	public $channelID;
	public $channelTitle;
	public $channelKeywords;
	public $channelDescription;
	
	public function __construct($channelID) {
		
		$query = "
			SELECT siteID, siteTitleEnglish,  siteKeywordsEnglish, siteDescriptionEnglish 
			FROM nisekocms_site WHERE siteID = '$channelID' LIMIT 1
		";
		$core = Core::getInstance();
		$statement = $core->database->query($query);
		$row = $statement->fetch();
		
		$this->channelID = $row['siteID'];
		$this->channelTitle = $row['siteTitleEnglish'];
		$this->channelKeywords = $row['siteKeywordsEnglish'];
		$this->channelDescription = $row['siteDescriptionEnglish'];
		
	}
	
	public function getChannelTitle() {
		return $this->channelTitle;
	}
	
	public function getChannelKeywords() {
		return $this->channelKeywords;
	}
	
	public function getChannelDescription() {
		return $this->channelDescription;
	}
	
	
	static function getSelectedChannelID() {
	
		$channelID = 0;
		$httpHost = $_SERVER['HTTP_HOST'];
		$url = preg_replace('/^www./', '', $httpHost);
		$siteURL = 'http://' . $url;
		
		$query = "SELECT siteID FROM nisekocms_site WHERE siteUrlEnglish = '$siteURL' LIMIT 1";
		$core = Core::getInstance();
		$statement = $core->database->query($query);
		$row = $statement->fetch();
		$channelID = $row['siteID'];
		
		return $channelID;
		
	}

}

class Comment {

}

class Config {
    static $confArray;
    public static function read($name) { return self::$confArray[$name]; }
    public static function write($name, $value) { self::$confArray[$name] = $value; }
}

class Content {

	public $contentID;
	public $contentCategoryKey;
	public $contentURL;
	public $contentTitleEnglish;
	public $contentEnglish;
	
	public function getContent($contentID) {
	
	}
	
	public function getContentArray($contentCategoryKey) {
	
	}
	

	function getContentList($contentCategoryKey = 'forum', $limitClausePage = 1) {

			$limitClausePageAdjusted = $limitClausePage - 1;
			$entriesPerPage = 25;
			$firstRecord = $limitClausePageAdjusted * $entriesPerPage;
			$limitClause = "LIMIT $firstRecord, $entriesPerPage";
			$currentDate = date('Y-m-d');
			$siteID = 14;


			$query = "
				SELECT * FROM nisekocms_content 
				WHERE contentCategoryKey = '$contentCategoryKey'
					AND entryPublished = 1 
					AND entryPublishStartDate <= '$currentDate' 
					AND (entryPublishEndDate >= '$currentDate' OR entryPublishEndDate = '0000-00-00')
					AND siteID = '$siteID'
				ORDER BY entryLastModified DESC
				$limitClause
			";

			$core = Core::getInstance();
			$statement = $core->database->query($query);
			$row = $statement->fetchAll();
			
			echo $query . '<hr />';
			print_r($row);
		
	}

	
	function displayContentForm(
		$type = 'create', 
		$contentCategoryKey = '', 
		$entryID = 0, 
		$entryTitleEnglish = '', 
		$entryTitleJapanese = '',
		$entryPublished = 1, 
		$entryContentEnglish = '',
		$entryContentJapanese = '',
		$entryPublishStartDate = '',
		$entryPublishEndDate = '',
		$isEvent = 0,
		$eventDate = '',
		$eventStartTime = '',
		$eventEndTime = ''
	) {

	}

	function displayContentView($entryID) {
	
	}

}

class Controller {
	
	public function __construct() {
	
		$cookie = new Cookie();
	
		$channelID = Channel::getSelectedChannelID();
		Session::setSession('channnelID', $channelID);
		
		// $_SESSION['userID'] = 2;
		if (isset($_SESSION['userID'])) { $userID = $_SESSION['userID']; } else { $userID = 0; }
		Session::setSession('userID', $userID);

	}

	public function getResource($urlArray) {
	
		if ($urlArray[0] == 'ja') {
			Session::setSession('lang', 'ja');
			array_shift($urlArray);
		} else {
			Session::setSession('lang', 'en');
		}

		$i = 0; while ($i <= 3) { if (!isset($urlArray[$i])) { $urlArray[$i] = ''; } $i++; } // minimum 3 array pointers

		if ($urlArray[0] == 'rss') {

			$rss = new Rss();
			$feed = $rss->getFeed($urlArray);
			return $feed;
			
		} elseif ($urlArray[0] == 'sitemap.xml') {
		
			$sitemap = new Sitemap();
			$xml = $sitemap->getSitemap($urlArray);
			return $xml;
			
		} else {
			
			$page = new Page();
			$html = $page->buildPage($urlArray);
			return $html;
			
		}

	}
	
}

class Cookie {
	
	public function __construct() {
		setcookie(
			'TheKutchannel',
			'testing',
			time() + (10 * 365 * 24 * 60 * 60),
			'',
			'.kutchannel.net',
			FALSE
		);
	}
	
}

class Core {

    public $database;
    private static $instance;

    private function __construct() {
        
		$dsn = 'mysql:host=' . Config::read('db.host') . ';dbname='    . Config::read('db.basename') . ';connect_timeout=15';
        $user = Config::read('db.user');            
        $password = Config::read('db.password');
		$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
		
		try {
			$this->database = new PDO($dsn, $user, $password, $options);
		} catch (PDOException $Exception) {
			throw new DatabaseException($Exception->getMessage(),(int)$s->getCode());
		}

    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }

    // others global functions
}

class Form {

}

class Language {

	public $lang;

	public function setLanguage($langKey) {
		if($langKey == 'ja') { $this->lang = 'ja'; } else { $this->lang = 'en'; }
	}
	
	public function getLanguage($langKey) {
		return $this->lang;
	}
	
}

class Menu {

	public function getNavBar() {
	
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
							<a href=\"/\"><img id=\"kLogo\" src=\"/jaga/images/banner.png\"></a>
						</div>
						<!-- END NAVBAR-HEADER -->

						<!-- START NAVBAR-COLLAPSE -->
						<div class=\"collapse navbar-collapse\">
							<ul class=\"nav navbar-nav navbar-right\">
								<li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">NISEKO <b class=\"caret\"></b></a>
									<ul class=\"dropdown-menu\">
										<li><a href=\"/k/news/\">NEWS</a></li>
										<li><a href=\"/k/events/\">EVENTS</a></li>
										<li><a href=\"/k/forum/\">FORUM</a></li>
										<li><a href=\"/k/for-sale/\">FOR SALE</a></li>
										<li><a href=\"/k/wanted/\">WANTED</a></li>
										<li><a href=\"/k/jobs/\">JOBS</a></li>
										<li><a href=\"/k/accommodation/\">ACCOMMODATION</a></li>
										<li><a href=\"/k/snow-forecast/\">SNOW FORECAST</a></li>
										<li><a href=\"/k/snow-report/\">SNOW REPORT</a></li>
										<li><a href=\"/k/avalanche-info/\">AVALANCHE INFO</a></li>
										<li><a href=\"/categories/\">more...</a></li>
									</ul>
								</li>
								<li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">OTHER CHANNELS <b class=\"caret\"></b></a>
									<ul class=\"dropdown-menu\">
										<li><a href=\"http://redpill.kutchannel.net/\">RED PILL</a></li>
										<li><a href=\"http://hakodate.kutchannel.net/\">HAKODATE</a></li>
										<li><a href=\"http://seattle.kutchannel.net/\">SEATTLE</a></li>
										<li><a href=\"http://eikaiwa.kutchannel.net/\">EIKAIWA</a></li>
										<li><a href=\"http://chishiki.kutchannel.net/\">CHISHIKI</a></li>
										<li><a href=\"http://kutchannel.net/\">more...</a></li>
									</ul>
								</li>
								<li><a href=\"/login/\">LOGIN</a></li>
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

class Message {

}

class Page {

	public $pageTitle;
	public $pageKeywords;
	public $pageDescription;
	
	public function __construct() {
	
		$channelID = Session::getSession('channnelID');
		$channel = new Channel($channelID);
		$this->pageTitle = $channel->channelTitle;
		$this->pageKeywords = $channel->channelKeywords;
		$this->pageDescription = $channel->channelDescription;
	}
	
	public function buildPage($urlArray) {

		$html = $this->getHeader();
		
			$navBar = new Menu();
			$html .= $navBar->getNavBar();
		
			$carousel = new Carousel();
			$html .= $carousel->getCarousel();

			$html .= "\t\t<div class=\"container\">\n";

				if ($urlArray[0] == '') {
					$html .= "index";
				} elseif ($urlArray[0] == 'register') {
					$html .= "register";
				} elseif ($urlArray[0] == 'login') {
					$html .= "login";
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
			
			$html .= "\t\t<div class=\"container\">\n";
			
				$html .= "\t\t\t<div class=\"row\">\n";
				
					$html .= "\t\t\t\t<div class=\"col-md-6 bg-warning\">";
						$html .= '<h3>$_SESSION</h3>';
						$html .= '<pre>' . print_r($_SESSION, true) . '</pre>';
					$html .= "</div>\n";

					$html .= "\t\t\t\t<div class=\"col-md-6 bg-warning\">";
						$html .= '<h3>Session::sessionArray</h3>';
						$html .= '<pre>' . print_r(Session::sessionDump(), true) . '</pre>';
					$html .= "</div>\n";

				$html .= "\t\t\t</div>\n";
				
				$html .= "\t\t\t<div class=\"row\">\n";
				
					$html .= "\t\t\t\t<div class=\"col-md-4 bg-warning\">";
						$html .= '<h3>$_COOKIE</h3>';
						$html .= '<pre>' . print_r($_COOKIE, true) . '</pre>';
					$html .= "</div>\n";
					
					$html .= "\t\t\t\t<div class=\"col-md-4 bg-warning\">";
						$html .= '<h3>$_POST</h3>';
						$html .= '<pre>' . print_r($_POST, true) . '</pre>';
					$html .= "</div>\n";
					
					$html .= "\t\t\t\t<div class=\"col-md-4 bg-warning\">";
						$html .= '<h3>$urlArray</h3>';
						$html .= '<pre>' . print_r($urlArray, true) . '</pre>';
					$html .= "</div>\n";
					
				$html .= "\t\t\t</div>\n";
				
			$html .= "\t\t</div>\n";
		
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
				$html .= "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"/jaga/css/kutchannel.css\" />\n\n";

			$html .= "\t</head>\n\n";

			$html .= "\t<body>\n\n";
			
		return $html;
		
	}
	
	private function getFooter() {

				$html = "\n\n";
				$html .= "\t\t<div id=\"footer\">\n";
					$html .= "\t\t\t<div class=\"container\">\n";
					
					
					
						$html .= "\t\t\t\t<p class=\"text-muted\">";
							$html .= "<a href=\"http://kutchannel.net/about/\">About</a> | ";
							$html .= "<a href=\"http://kutchannel.net/tos/\">Terms of Service</a> | ";
							$html .= "<a href=\"http://kutchannel.net/privacy/\">Privacy Policy</a> | ";
							$html .= "<a href=\"http://kutchannel.net/advertise/\">Advertise</a> | ";
							$html .= "<a href=\"http://kutchannel.net/sitemap/\">Sitemap</a> | ";
							$html .= "<a href=\"http://kutchannel.net/contact/\">Contact</a> | ";
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

class Rss {

	public function getFeed($urlArray) {
		return 'derp';
	}

}

class Session {

	static $sessionArray;
	
	public static function getSession($name) { return self::$sessionArray[$name]; }
    
	public static function setSession($name, $value) {
		if (!isset($_SESSION)) { session_start(); }
		self::$sessionArray[$name] = $value;
		$_SESSION[$name] = $value;
	}

	public static function sessionDump () {
		return self::$sessionArray;
	}
	
	
}

class Shop {

}

class Sitemap {

	public function getSitemap($urlArray) {
		return 'derp: the sequel';
	}
}

class User {

	public $userID;
	public $username;
	
	public function __construct($userID = 0) {
	
		$this->userID = $userID;
		
		$query = "SELECT userName FROM j00mla_ver4_users WHERE id = '$userID' LIMIT 1";
		$core = Core::getInstance();
		$statement = $core->database->query($query);
		$row = $statement->fetch();
		
		$this->username = $row['userName'];

	}
	
}

?>
