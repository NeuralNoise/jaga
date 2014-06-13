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
	
		// kill session
		session_unset();
		session_destroy();
		
		// kill jaga_session
		$sessionID = $_COOKIE['TheKutchannel'];
		$currentDateTime = date('Y-m-d H:i:s');
		$core = Core::getInstance();
		$query = "UPDATE jaga_session SET sessionDateTimeExpire = :currentDateTime WHERE sessionID = :sessionID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':currentDateTime' => $currentDateTime, ':sessionID' => $sessionID));
		
		// kill cookie
		setcookie('TheKutchannel', 'loggedout', time()-3600, '/', '.kutchannel.net', FALSE);
		unset($_COOKIE['TheKutchannel']);
		
		
		
	}
	
	public static function register() {
	
	}
	
	public static function isLoggedIn() {
	
	}
	
	/*
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
	
	*/
	
}

class Calendar {

}

class Category {

}

class Channel {

	public $channelID;
	public $channelKey;
	public $channelTitle;
	public $channelKeywords;
	public $channelDescription;
	
	public function __construct($channelID) {
		
		if ($channelID != 0) {
		
			$query = "
				SELECT siteID, channelKey, siteTitleEnglish, siteKeywordsEnglish, siteDescriptionEnglish 
				FROM jaga_channel WHERE siteID = '$channelID' LIMIT 1
			";
			$core = Core::getInstance();
			$statement = $core->database->query($query);
			
			$row = $statement->fetch();
		
			$this->channelID = $row['siteID'];
			$this->channelKey = $row['channelKey'];
			$this->channelTitle = $row['siteTitleEnglish'];
			$this->channelKeywords = $row['siteKeywordsEnglish'];
			$this->channelDescription = $row['siteDescriptionEnglish'];
		
		} else {
		
			$this->channelID = 0;
			$this->channelKey = 'kutchannel';
			$this->channelTitle = 'The Kutchannel';
			$this->channelKeywords = 'The Kutchannel';
			$this->channelDescription = 'The Kutchannel';
		
		}
		
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
	
	public function getChannelCategoryArray($channelID) {
		
		// returns $array[contentCategoryKey][contentCategoryPostCount]
		
		$core = Core::getInstance();
		$query = "
			SELECT `contentCategoryKey`, COUNT(`contentCategoryKey`) AS `count`
			FROM `nisekocms_content`
			WHERE siteID = :channelID
			GROUP BY `contentCategoryKey`
			ORDER BY COUNT(`contentCategoryKey`) DESC
		";
		
		$statement = $core->database->prepare($query);
		$statement->execute(array(':channelID' => $channelID));
		
		$channelCategoryArray = array();
		while ($row = $statement->fetch()) {
		
			$contentCategoryKey = $row['contentCategoryKey'];
			$contentCategoryPostCount = $row['count'];
			$channelCategoryArray[$contentCategoryKey] = $contentCategoryPostCount;
		}
		
		return $channelCategoryArray;
	}
	
	public function getUserChannelArray($userID) {
		
		// returns $array[contentCategoryKey][contentCategoryPostCount]
		
		$core = Core::getInstance();
		$query = "
			SELECT channelKey
			FROM `jaga_channel`
			WHERE channelEnabled = 1
			ORDER BY channelKey ASC
		";
		
		$statement = $core->database->prepare($query);
		
		// $statement->execute(array(':channelID' => $channelID));
		$statement->execute();
		
		$channelCategoryArray = array();
		while ($row = $statement->fetch()) {
		
			$channelKey = $row['channelKey'];
			$channelKey = $row['channelKey'];
			$channelCategoryArray[$channelKey] = $channelKey;
		}
		
		return $channelCategoryArray;
	}
	
	
	static function getSelectedChannelID() {
	
		$channelID = 0;
		
		$domain = $_SERVER['HTTP_HOST'];
		$tmp = explode('.', $domain);
		$subdomain = current($tmp);
		
		$query = "SELECT siteID FROM jaga_channel WHERE channelKey = '$subdomain' LIMIT 1";
		$core = Core::getInstance();
		$statement = $core->database->query($query);
		
		if ($row = $statement->fetch()) {
			$channelID = $row['siteID'];
		}
		
		return $channelID;
		
	}

}

class Comment {

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

class Cookie {
	
	public function __construct() {

		$sessionID = md5($_SERVER['REMOTE_ADDR'].'-'.time().'-natto');
		$sessionExpiry = strtotime("+1 month", time());
		
		setcookie(
			'TheKutchannel',
			$sessionID,
			// time() + (31 * 24 * 60 * 60), // one month
			$sessionExpiry,
			'/',
			'.kutchannel.net',
			FALSE
		);

	}
	
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
	public $channelKey;
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

	public function sendMail($mailRecipient, $mailSender, $mailSubject, $mailMessage, $channelKey = 0, $userID = 0, $mailType = 'plaintext') {

		// if ($channelKey == 0) { if (isset($_SESSION['channelID'])) { $channelKey = $_SESSION['channelID']; } }
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

class Message {

}

class Rss {

	public function getFeed($urlArray) {
		return 'derp';
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