<?php

class Audit {

}

class Authentication {

	public static function checkAuth($username, $password) {

		$encryptedPassword = md5($password);
		$errorArray = array();
	
		$core = Core::getInstance();
		$query = "SELECT id, username, email, password FROM jaga_user WHERE username = :username OR email = :username LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':username' => $username));
		

		if (!$row = $statement->fetch()) { // account does not exist
		
			$errorArray[] = 'That account does not exist. Please try again.';
			
		} else { // account exists => check password
		
			// PRE-DEPLOYMENT ONLY
			if ($row['id'] != 2 && $row['id'] != 3 && $row['id'] != 64) { $errorArray[] = 'You are not a beta user.'; }
			
			
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

}

class Calendar {

}

class Category {


	public function getCategoryContent($channelID, $contentCategoryKey) {
	
		$currentDate = date('Y-m-d');
		
		$query = "
			SELECT `contentID`, `contentViews`
			FROM `jaga_Content`
			WHERE channelID = :channelID
			AND contentPublished =1
			AND contentPublishStartDate <=  '$currentDate'
			AND (
				contentPublishEndDate >=  '$currentDate'
				OR contentPublishEndDate =  '0000-00-00'
			)
			AND contentCategoryKey = :contentCategoryKey
			ORDER BY contentLastModified DESC
		";
		
		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		$statement->execute(array(':channelID' => $channelID, ':contentCategoryKey' => $contentCategoryKey));
		
		$categoryContentArray = array();
		while ($row = $statement->fetch()) { $categoryContentArray[] = $row['contentID']; }
		return $categoryContentArray;
		
	}

	public function getAllCategories() {
	

	
		$core = Core::getInstance();
		
		$query = "
			SELECT jaga_category.contentCategoryKey as contentCategoryKey, COUNT(jaga_Content.contentID) as postCount
			FROM jaga_category LEFT JOIN jaga_Content
			ON jaga_category.contentCategoryKey = jaga_Content.contentCategoryKey
			GROUP BY jaga_category.contentCategoryKey
			ORDER BY jaga_category.contentCategoryKey ASC
		";
		
		$statement = $core->database->prepare($query);
		$statement->execute();
		
		$categoryArray = array();
		while ($row = $statement->fetch()) { $categoryArray[$row['contentCategoryKey']] = $row['postCount']; }
		return $categoryArray;
		
	}
	
}

class Channel extends ORM {

	public $channelID;
	public $channelKey;
	public $channelCreationDateTime;
	public $channelEnabled;
	public $channelTitleEnglish;
	public $channelTitleJapanese;
	public $channelKeywordsEnglish;
	public $channelKeywordsJapanese;
	public $channelDescriptionEnglish;
	public $channelDescriptionJapanese;
	public $themeKey;
	public $pagesServed;
	public $siteManagerUserID;
	
	public function __construct($channelID) {
		
		if ($channelID != 0) {
		
			$query = "
				SELECT channelID, channelKey, channelCreationDateTime, channelEnabled, channelTitleEnglish, channelTitleJapanese, channelKeywordsEnglish, channelKeywordsJapanese, channelDescriptionEnglish, channelDescriptionJapanese, themeKey, pagesServed, siteManagerUserID
				FROM jaga_Channel WHERE channelID = '$channelID' LIMIT 1
			";
			$core = Core::getInstance();
			$statement = $core->database->query($query);
			
			$row = $statement->fetch();
		
			$this->channelID = $row['channelID'];
			$this->channelKey = $row['channelKey'];
			$this->channelCreationDateTime = $row['channelCreationDateTime'];
			$this->channelEnabled = $row['channelEnabled'];
			$this->channelTitleEnglish = $row['channelTitleEnglish'];
			$this->channelTitleJapanese = $row['channelTitleJapanese'];
			$this->channelKeywordsEnglish = $row['channelKeywordsEnglish'];
			$this->channelKeywordsJapanese = $row['channelKeywordsJapanese'];
			$this->channelDescriptionEnglish = $row['channelDescriptionEnglish'];
			$this->channelDescriptionJapanese = $row['channelDescriptionJapanese'];
			$this->themeKey = $row['themeKey'];
			$this->pagesServed = $row['pagesServed'];
			$this->siteManagerUserID = $row['siteManagerUserID'];
	
		} else {
		
			$this->channelID = 0;
			$this->channelKey = '';
			$this->channelCreationDateTime = date('Y-m-d H:i:s');
			$this->channelEnabled = 1;
			$this->channelTitleEnglish = '';
			$this->channelTitleJapanese = '';
			$this->channelKeywordsEnglish = '';
			$this->channelKeywordsJapanese = '';
			$this->channelDescriptionEnglish = '';
			$this->channelDescriptionJapanese = '';
			$this->themeKey = 'kutchannel';
			$this->pagesServed = 0;
			$this->siteManagerUserID = $_SESSION['userID'];
		
		}
		
	}
	
	public function getChannelTitle() {
		return $this->channelTitleEnglish;
	}
	
	public function getChannelKeywords() {
		return $this->channelKeywordsEnglish;
	}
	
	public function getChannelDescription() {
		return $this->channelDescriptionEnglish;
	}
	
	public function getChannelArray() {
		
		// returns $array[contentCategoryKey][contentCategoryPostCount]
		
		$core = Core::getInstance();
		$query = "
			SELECT jaga_Channel.channelKey AS channelKey, COUNT(jaga_Content.contentID) AS postCount
			FROM jaga_Channel LEFT JOIN jaga_Content
			ON jaga_Channel.channelID = jaga_Content.channelID
			WHERE jaga_Channel.channelEnabled = 1
			GROUP BY jaga_Channel.channelKey
			ORDER BY COUNT(jaga_Content.contentID) DESC
		";
		
		$statement = $core->database->prepare($query);
		
		// $statement->execute(array(':channelID' => $channelID));
		$statement->execute();
		
		$channelArray = array();
		while ($row = $statement->fetch()) {
			$channelKey = $row['channelKey'];
			$postCount = $row['postCount'];
			$channelArray[$channelKey] = $postCount;
		}
		
		return $channelArray;
	}
	
	public function getUserOwnChannelArray($userID) {
		
		$core = Core::getInstance();
		$query = "
			SELECT jaga_Channel.channelKey as channelKey, COUNT(jaga_Content.contentID) as postCount 
			FROM jaga_Channel LEFT JOIN jaga_Content 
			ON jaga_Channel.channelID = jaga_Content.channelID 
			WHERE jaga_Channel.siteManagerUserID = :userID 
			GROUP BY channelKey 
			ORDER BY postCount DESC
		";
		
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID));
		
		$userOwnChannelArray = array();
		while ($row = $statement->fetch()) {
			$userOwnChannelArray[$row['channelKey']] = $row['postCount'];
		}
		return $userOwnChannelArray;
		
	}
	
	public function getUserSubscribedChannelArray($userID) {
		
		$core = Core::getInstance();
		$query = "
			SELECT jaga_subscription.channelID as channelID, COUNT(jaga_Content.contentID) as postCount 
			FROM jaga_subscription, jaga_Content 
			WHERE jaga_subscription.channelID = jaga_Content.channelID 
			AND jaga_subscription.userID = :userID
			GROUP BY channelID 
			ORDER BY postCount DESC
		";
		
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID));
		
		$userSubscribedChannelArray = array();
		while ($row = $statement->fetch()) {
			$channelKey = self::getChannelKey($row['channelID']);
			$userSubscribedChannelArray[$channelKey] = $row['postCount'];
		}
		
		return $userSubscribedChannelArray;
		
	}
	
	public function getSelectedChannelID() {
	
		$channelID = 0;
		
		$domain = $_SERVER['HTTP_HOST'];
		$tmp = explode('.', $domain);
		$subdomain = current($tmp);
		
		$query = "SELECT channelID FROM jaga_Channel WHERE channelKey = '$subdomain' LIMIT 1";
		$core = Core::getInstance();
		$statement = $core->database->query($query);
		
		if ($row = $statement->fetch()) { $channelID = $row['channelID']; }
		
		return $channelID;
		
	}

	public function getChannelID($channelKey) {
	
		$channelID = 0;
		$query = "SELECT channelID FROM jaga_Channel WHERE channelKey = '$channelKey' LIMIT 1";
		$core = Core::getInstance();
		$statement = $core->database->query($query);
		
		if ($row = $statement->fetch()) { $channelID = $row['channelID']; }
		
		return $channelID;
		
	}
	
	public function getChannelKey($channelID) {
	
		$channelKey = '';
		$query = "SELECT channelKey FROM jaga_Channel WHERE channelID = '$channelID' LIMIT 1";
		$core = Core::getInstance();
		$statement = $core->database->query($query);
		
		if ($row = $statement->fetch()) { $channelKey = $row['channelKey']; }
		
		return $channelKey;
		
	}

	public function getThemeKey($channelID) {
	
		$themeKey = '';
		
		$query = "SELECT themeKey FROM jaga_Channel WHERE channelID = '$channelID' LIMIT 1";
		$core = Core::getInstance();
		$statement = $core->database->query($query);
		
		if ($row = $statement->fetch()) { $themeKey = $row['themeKey']; }
		
		return $themeKey;
		
	}
	
}

class ChannelCategory extends ORM {

	public $channelID;
	public $contentCategoryKey;
	
	public function __construct() {
		$this->channelID = 0;
		$this->contentCategoryKey = '';
	}
	
	public function getChannelCategoryArray($channelID) {
		
		// returns $array[contentCategoryKey][contentCategoryPostCount]
		
		$core = Core::getInstance();
		$query = "
			SELECT jaga_ChannelCategory.contentCategoryKey AS contentCategoryKey, COUNT( jaga_Content.contentID ) AS postCount
			FROM jaga_ChannelCategory
			LEFT JOIN jaga_Content ON jaga_ChannelCategory.channelID = jaga_Content.channelID
			AND jaga_ChannelCategory.contentCategoryKey = jaga_Content.contentCategoryKey
			WHERE jaga_ChannelCategory.channelID = :channelID
			GROUP BY contentCategoryKey
			ORDER BY postCount DESC 
		";
		
		$statement = $core->database->prepare($query);
		$statement->execute(array(':channelID' => $channelID));
		
		$channelCategoryArray = array();
		while ($row = $statement->fetch()) {
		
			$contentCategoryKey = $row['contentCategoryKey'];
			$contentCategoryPostCount = $row['postCount'];
			$channelCategoryArray[$contentCategoryKey] = $contentCategoryPostCount;
		}
		
		return $channelCategoryArray;
	}
	
}

class Comment extends ORM {

	public function getComments($contentID) {
		
		$channelID = $_SESSION['channelID'];
	
		$core = Core::getInstance();
		$query = "
			SELECT userID, commentDateTime, commentContent
			FROM jaga_comment 
			WHERE contentID = :contentID
			AND siteID = :channelID
		";

		$statement = $core->database->prepare($query);
		$statement->execute(array(':contentID' => $contentID, ':channelID' => $channelID));
		$comments = $statement->fetchAll();
		
		return $comments;
	}
	
}

class Content extends ORM {

	public $contentID;
	public $channelID;
	public $contentURL;
	public $contentCategoryKey;
	public $contentSubmittedByUserID;
	public $contentSubmissionDateTime;
	public $contentPublishStartDate;
	public $contentPublishEndDate;
	public $contentLastModified;
	public $contentTitleEnglish;
	public $contentTitleJapanese;
	public $contentEnglish;
	public $contentJapanese;
	public $contentLinkURL;
	public $contentPublished;
	public $contentViews;
	public $contentIsEvent;
	public $contentEventDate;
	public $contentEventStartTime;
	public $contentEventEndTime;
	public $contentLatitude;
	public $contentLongitude;
	
	public function __construct($contentID) {
	
		
		if ($contentID != 0) {
		
			$core = Core::getInstance();
			$query = "SELECT * FROM jaga_Content WHERE contentID = :contentID LIMIT 1";
			$statement = $core->database->prepare($query);
			$statement->execute(array(':contentID' => $contentID));
			if (!$row = $statement->fetch()) { die('Content does not exist.'); }
			foreach ($row AS $key => $value) { if (!is_int($key)) { $this->$key = $value; } }
			
		} else {

			$this->contentID = 0;
			$this->channelID = $_SESSION['channelID'];
			$this->contentURL = '';
			$this->contentCategoryKey = '';
			$this->contentSubmittedByUserID = $_SESSION['userID'];
			$this->contentSubmissionDateTime = date('Y-m-d H:i:s');
			$this->contentPublishStartDate = date('Y-m-d');
			$this->contentPublishEndDate = '0000-00-00';
			$this->contentLastModified = date('Y-m-d H:i:s');
			$this->contentTitleEnglish = '';
			$this->contentTitleJapanese = '';
			$this->contentEnglish = '';
			$this->contentJapanese = '';
			$this->contentLinkURL = '';
			$this->contentPublished = 1;
			$this->contentViews = 0;
			$this->contentIsEvent = 0;
			$this->contentEventDate = date('Y-m-d');
			$this->contentEventStartTime = date('H:00:00');
			$this->contentEventEndTime = date('H:30:00');
			$this->contentLatitude = '42.827200';
			$this->contentLongitude = '140.806995';

		}
		
	}
	
	public function getContent($contentID) {
	
	}
	
	public function getContentID($contentURL) {
		
		$core = Core::getInstance();
		$query = "SELECT contentID FROM jaga_Content WHERE contentURL = :contentURL LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':contentURL' => $contentURL));
		if ($row = $statement->fetch()) {
			return $row['contentID'];
		} else {
			die($contentURL);
		}
		
	}
	
	public function getContentArray($contentCategoryKey) {
	
	}
	
	public function getContentListArray($channelID, $contentCategoryKey, $limitClausePage) {

			$limitClausePageAdjusted = $limitClausePage - 1;
			$entriesPerPage = 25;
			$firstRecord = $limitClausePageAdjusted * $entriesPerPage;
			$limitClause = "LIMIT $firstRecord, $entriesPerPage";
			$currentDate = date('Y-m-d');

			$query = "
				SELECT * FROM jaga_Content 
				WHERE contentCategoryKey = :contentCategoryKey
					AND contentPublished = 1 
					AND contentPublishStartDate <= '$currentDate' 
					AND (contentPublishEndDate >= '$currentDate' OR contentPublishEndDate = '0000-00-00')
					AND channelID = :channelID
				ORDER BY contentLastModified DESC
				$limitClause
			";

			// print_r($query);
			
			$core = Core::getInstance();
			$statement = $core->database->prepare($query);
			$statement->execute(array(':channelID' => $channelID, ':contentCategoryKey' => $contentCategoryKey));
			
			$contentListArray = array();
			while ($row = $statement->fetch()) { $contentListArray[$row['contentID']] = $row['contentURL']; }
			return $contentListArray;
			

		
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
		  `channelID` int(8) NOT NULL,
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
			channelID,
			mailSentByUserID,
			mailSentDateTime,
			mailToAddress,
			mailFromAddress,
			mailSubject,
			mailMessage
		) VALUES (
			'$channelID',
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

class Theme {

}

class User {

	public $userID;
	public $username;
	public $userEmail;
	
	public function __construct($userID = 0) {
	
		$this->userID = $userID;
		
		$query = "SELECT userName, email FROM jaga_user WHERE id = '$userID' LIMIT 1";
		$core = Core::getInstance();
		$statement = $core->database->query($query);
		$row = $statement->fetch();
		
		$this->username = $row['userName'];
		$this->userEmail = $row['email'];

	}
	
	public function getUserIDwithUserNameOrEmail($username) {
	
		$core = Core::getInstance();
		$query = "SELECT id FROM jaga_user WHERE username = :username OR email = :username LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':username' => $username));
		$row = $statement->fetch();
		return $row['id'];
	
	}
	
	public function usernameExists($username) {
	
		$core = Core::getInstance();
		$query = "SELECT id FROM jaga_user WHERE username = :username LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':username' => $username));
		if ($row = $statement->fetch()) { return true; } else { return false; }
	
	}
	
}

?>