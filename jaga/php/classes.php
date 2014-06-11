<?php

class Audit {

}

class Authentication {

	public static function checkAuth($username, $password) {

		$encryptedPassword = md5($password);
		$errorArray = array();
	
		$core = Core::getInstance();
		$query = "SELECT id, username, email, password FROM j00mla_ver4_users WHERE username = :username OR email = :username LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':username' => $username));
		

		if (!$row = $statement->fetch()) { // account does not exist
			$errorArray[] = 'That account does not exist. Please try again.';
		} else { // account exists => check password
			if ($row['password'] != $encryptedPassword) { $errorArray[] = 'Your password is incorrect. Please try again.'; }
		}

		return $errorArray;

	}
	
	public static function logout() {
		session_unset();
		session_destroy();
		// kill cookie
		// kill db session
	}
	
	public static function register() {
	
	}
	
	public static function isLoggedIn() {
	
	}
	
	public static function getAuthForm($type, $errorArray = array()) {
	
		$html = "\n\n";
		$html .= "\t<div class=\"container\">\n";
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
					
						/*
						if (!empty($errorArray)) {
							foreach ($errorArray AS $value) { $html .= "\t\t\t\t\t<div id=\"login-alert\" class=\"alert alert-danger col-sm-12\">$value</div>\n"; }
						}
						*/
						
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
	
		if (!isset($_COOKIE['TheKutchannel'])) { $cookie = new Cookie(); }
	
		$channelID = Channel::getSelectedChannelID();
		Session::setSession('channnelID', $channelID);
		
		if (!isset($_SESSION['userID'])) { $userID = 0; } else { $userID = $_SESSION['userID']; }
		Session::setSession('userID', $userID);
		
		// Session::unsetSession('POST');
		// if (!empty($_POST)) { Session::setSession('POST', $_POST); }

	}

	public function getResource($urlArray) {
	
		$arrayOfSupportedLanguages = array('en','ja');
		if (in_array($urlArray[0], $arrayOfSupportedLanguages)) {
			Session::setSession('lang', $urlArray[0]);
			array_shift($urlArray);
		} else {
			Session::setSession('lang', 'en');
		}

		$i = 0; while ($i <= 3) { if (!isset($urlArray[$i])) { $urlArray[$i] = ''; } $i++; } // minimum 3 array pointers

		if ($urlArray[0] == 'login') {
			
			$errorArray = array();
			
			if (isset($_POST['jagaLoginSubmit'])) {
			
				$username = $_POST['username'];
				$password = $_POST['password'];
			
				$errorArray = Authentication::checkAuth($username, $password);
				
				if (empty($errorArray)) {
				
					// log user in
					$userID = User::getUserIDwithUserNameOrEmail($username);
					Session::setSession('userID', $userID);
					
					// set cookie
					$cookie = new Cookie();
					
					
					// save session to db
					$sessionID = $_COOKIE['TheKutchannel'];
					
					/*
						CREATE TABLE IF NOT EXISTS `jaga_session` (
						  `sessionID` int(11) NOT NULL,
						  `sessionDateTimeSet` datetime NOT NULL,
						  `sessionDateTimeExpires` datetime NOT NULL,
						  `sessionIP` varchar(50) NOT NULL,
						  `sessionUserAgent` varchar(255) NOT NULL,
						  `sessionArray` text NOT NULL,
						  `userID` int(8) NOT NULL,
						  PRIMARY KEY (`sessionID`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8;
					*/
					
					// terminate script; forward header
					header("Location: /");
					
				}
				
			}
			
			$page = new Page();
			$html = $page->buildPage($urlArray, $errorArray);
			return $html;
			
		} elseif ($urlArray[0] == 'logout') {

			Authentication::logout();
			header("Location: /");
			
		} elseif ($urlArray[0] == 'rss') {

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
	
		// to delete cookie
		// setcookie ("TheKutchannel", "", time() - 3600);

		$sessionID = md5($_SERVER['REMOTE_ADDR'].'-'.time().'-natto');
		$sessionExpiry = strtotime("+1 month", time());
		
		setcookie(
			'TheKutchannel',
			$sessionID,
			// time() + (31 * 24 * 60 * 60), // one month
			$sessionExpiry,
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

class Image {

}

class File {

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

class Mail {

	public $mailRecipient;
	public $mailSender;
	public $mailSubject;
	public $mailMessage;
	public $channelID;
	public $userID;
	public $mailType;

	/*
		CREATE TABLE IF NOT EXISTS `nisekocms_mail` (
		  `mailID` int(8) NOT NULL AUTO_INCREMENT,
		  `siteID` int(8) NOT NULL,
		  `mailSentByUserID` int(8) NOT NULL,
		  `mailSentDateTime` datetime NOT NULL,
		  `mailToAddress` varchar(255) NOT NULL,
		  `mailFromAddress` varchar(255) NOT NULL,
		  `mailSubject` varchar(255) NOT NULL,
		  `mailMessage` text NOT NULL,
		  PRIMARY KEY (`mailID`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000001 ;
	*/

	public function sendMail($mailRecipient, $mailSender, $mailSubject, $mailMessage, $channelID = 0, $userID = 0, $mailType = 'plaintext') {

		// if ($channelID == 0) { if (isset($_SESSION['channelID'])) { $channelID = $_SESSION['channelID']; } }
		// if ($userID == 0) { if (isset($_SESSION['userID'])) { $userID = $_SESSION['userID']; } }

		$mailHeader = "From: $mailSender\n";
		$mailHeader .= "Reply-To: $mailSender\n";
			
		if ($mailType == 'html') {
			$mailHeader .= "MIME-Version: 1.0\n";
			$mailHeader .= "Content-Type: text/html; charset=UTF-8\n";
		}
		
		mail("$toAddress","$mailSubject","$mailMessage","$mailHeader");
		
		// $auditTrailAction = 'mail to ' . $mailRecipient . ' from ' . $mailSender;
		// $auditTrailMailMessage = substr(strip_tags($mailMessage), 0, 200);
		
		$auditTrailAction = 'sendMail';
		$auditTrailMailMessage = 'to ' . $mailRecipient . ' from ' . $mailSender;

		/*
		
		$mailSentByUserID = $userID;
		$mailSentDateTime = date('Y-m-d H:i:s');
		$mailToAddress = mysql_real_escape_string($mailRecipient);
		$mailFromAddress = mysql_real_escape_string($mailSender);
		$mailSubject = mysql_real_escape_string($mailSubject);
		$mailMessage = mysql_real_escape_string($mailMessage);
		
		$querySaveMessage = "INSERT INTO nisekocms_mail (
			siteID,
			mailSentByUserID,
			mailSentDateTime,
			mailToAddress,
			mailFromAddress,
			mailSubject,
			mailMessage
		) VALUES (
			'$siteID',
			'$mailSentByUserID',
			'$mailSentDateTime',
			'$mailToAddress',
			'$mailFromAddress',
			'$mailSubject',
			'$mailMessage'
		)";

		// echo '<pre>' . $querySaveMessage . '</pre>';
		
		mysql_query ($querySaveMessage) or die ('error saving mail to DB');
		
		$mailID = mysql_insert_id();
		
		postToAuditTrail(
			$userID, 
			$auditTrailAction, 
			'successful', 
			'',
			$auditTrailMailMessage,
			'mail',
			$mailID
		);
	*/
	
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
								<li class=\"dropdown\"><a href=\"/\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">NISEKO <b class=\"caret\"></b></a>
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
									$html .= "
										<li><a href=\"http://redpill.kutchannel.net/\">RED PILL</a></li>
										<li><a href=\"http://hakodate.kutchannel.net/\">HAKODATE</a></li>
										<li><a href=\"http://seattle.kutchannel.net/\">SEATTLE</a></li>
										<li><a href=\"http://eikaiwa.kutchannel.net/\">EIKAIWA</a></li>
										<li><a href=\"http://chishiki.kutchannel.net/\">CHISHIKI</a></li>
										<li><a href=\"http://the.kutchannel.net/\">...more</a></li>
									";
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
								";
		
								$user = new User($_SESSION['userID']);
								$username = $user->username;
								
								if ($_SESSION['userID'] == 0) {
									$html .= "<li><a href=\"/login/\"><i class=\"glyphicon glyphicon-log-in\"></i></a></li>";
								} else {
									$html .= "<li><a href=\"/u/" .  $username . "/\"><i class=\"glyphicon glyphicon glyphicon-user\"></i></a></li>";
									$html .= "<li><a href=\"/settings/\"><i class=\"glyphicon glyphicon-cog\"></i></a></li>";
									$html .= "<li><a href=\"/logout/\"><i class=\"glyphicon glyphicon-log-out\"></i></a></li>";
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
	
	public function buildPage($urlArray, $errorArray = array()) {

		$html = $this->getHeader();
		
			$navBar = new Menu();
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
		
			if ($urlArray[0] == '') {
				$carousel = new Carousel();
				$html .= $carousel->getCarousel();
			}
			

			$html .= "\t\t<div class=\"container\">\n";

				if ($urlArray[0] == '') {
					$html .= "index";
				} elseif ($urlArray[0] == 'register') {
				
					$html .= Authentication::getAuthForm('register', $errorArray);
					
				} elseif ($urlArray[0] == 'login') {
					
					$html .= Authentication::getAuthForm('login', $errorArray);
					
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
			
			// $html .= "\t\t<div class=\"container\" style=\"display:none;\">\n";
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

	public $sessionID;
	public $userID;
	public $sessionDateTimeSet;
	public $sessionDateTimeExpire;
	public $sessionIP;
	public $sessionUserAgent;
	
	/*
		CREATE TABLE IF NOT EXISTS `jaga_session` (
		  `sessionID` varchar(32) NOT NULL,
		  `userID` int(8) NOT NULL,
		  `sessionDateTimeSet` datetime NOT NULL,
		  `sessionDateTimeExpire` datetime NOT NULL,
		  `sessionIP` varchar(50) NOT NULL,
		  `sessionUserAgent` varchar(255) NOT NULL,
		  PRIMARY KEY (`sessionID`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
	*/
	
	public function createAuthSession() {
		
	}


	static $sessionArray;
	
	public static function getSession($name) {
		if (isset(self::$sessionArray[$name])) {
			return self::$sessionArray[$name];
		} else {
			return "Session variable '$name' has not been set properly.";
		}
	}
    
	public static function setSession($name, $value) {
		
		self::$sessionArray[$name] = $value;
		
		if (!isset($_SESSION)) { session_start(); }
		$_SESSION[$name] = $value;
		
	}
	
	public static function unsetSession($name) {
	
		unset(self::$sessionArray[$name]);
		unset($_SESSION[$name]);
		
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
	public $userEmail;
	
	public function __construct($userID = 0) {
	
		$this->userID = $userID;
		
		$query = "SELECT userName, email FROM j00mla_ver4_users WHERE id = '$userID' LIMIT 1";
		$core = Core::getInstance();
		$statement = $core->database->query($query);
		$row = $statement->fetch();
		
		$this->username = $row['userName'];
		$this->userEmail = $row['email'];

	}
	
	public static function getUserIDwithUserNameOrEmail($username) {
	
		$core = Core::getInstance();
		$query = "SELECT id FROM j00mla_ver4_users WHERE username = :username OR email = :username LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':username' => $username));
		$row = $statement->fetch();
		return $row['id'];
	
	}
	
}

?>