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
	
		$core = Core::getInstance();
		
		$query = "
			SELECT `entryID`, `entryViews`
			FROM `jaga_content`
			WHERE siteID = :channelID
			AND contentCategoryKey = :contentCategoryKey
			ORDER BY entrySubmissionDateTime DESC
		";
		
		$statement = $core->database->prepare($query);
		$statement->execute(array(':channelID' => $channelID, ':contentCategoryKey' => $contentCategoryKey));
		
		$categoryContentArray = array();
		while ($row = $statement->fetch()) { $categoryContentArray[] = $row['entryID']; }
		return $categoryContentArray;
		
	}

	public function getAllCategories() {
	

	
		$core = Core::getInstance();
		
		$query = "
			SELECT jaga_category.contentCategoryKey as contentCategoryKey, COUNT(jaga_content.entryID) as postCount
			FROM jaga_category LEFT JOIN jaga_content
			ON jaga_category.contentCategoryKey = jaga_content.contentCategoryKey
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
			SELECT jaga_Channel.channelKey AS channelKey, COUNT(jaga_content.entryID) AS postCount
			FROM jaga_Channel LEFT JOIN jaga_content
			ON jaga_Channel.channelID = jaga_content.siteID
			WHERE jaga_Channel.channelEnabled = 1
			GROUP BY jaga_Channel.channelKey
			ORDER BY COUNT(jaga_content.entryID) DESC
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
			SELECT jaga_Channel.channelKey as channelKey, COUNT(jaga_content.entryID) as postCount 
			FROM jaga_Channel LEFT JOIN jaga_content 
			ON jaga_Channel.channelID = jaga_content.siteID 
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
			SELECT jaga_subscription.channelID as channelID, COUNT(jaga_content.entryID) as postCount 
			FROM jaga_subscription, jaga_content 
			WHERE jaga_subscription.channelID = jaga_content.siteID 
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
	
	/* START STATIC */
	
	static function getSelectedChannelID() {
	
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

	static function getChannelID($channelKey) {
	
		$channelID = 0;
		$query = "SELECT channelID FROM jaga_Channel WHERE channelKey = '$channelKey' LIMIT 1";
		$core = Core::getInstance();
		$statement = $core->database->query($query);
		
		if ($row = $statement->fetch()) { $channelID = $row['channelID']; }
		
		return $channelID;
		
	}
	
	static function getChannelKey($channelID) {
	
		$channelKey = '';
		$query = "SELECT channelKey FROM jaga_Channel WHERE channelID = '$channelID' LIMIT 1";
		$core = Core::getInstance();
		$statement = $core->database->query($query);
		
		if ($row = $statement->fetch()) { $channelKey = $row['channelKey']; }
		
		return $channelKey;
		
	}

	static function getThemeKey($channelID) {
	
		$themeKey = '';
		
		$query = "SELECT themeKey FROM jaga_Channel WHERE channelID = '$channelID' LIMIT 1";
		$core = Core::getInstance();
		$statement = $core->database->query($query);
		
		if ($row = $statement->fetch()) { $themeKey = $row['themeKey']; }
		
		return $themeKey;
		
	}
	
	/* ==> EXTEND ORM */
	
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
			SELECT jaga_ChannelCategory.contentCategoryKey AS contentCategoryKey, COUNT( jaga_content.entryID ) AS postCount
			FROM jaga_ChannelCategory
			LEFT JOIN jaga_content ON jaga_ChannelCategory.channelID = jaga_content.siteID
			AND jaga_ChannelCategory.contentCategoryKey = jaga_content.contentCategoryKey
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

class Comment {

}

class Content {
	
	
	
	public $contentID;
	public $channelID;
	public $contentCategoryKey;
	public $entrySeoURL;
	public $contentSubmittedByUserID;
	public $contentSubmissionDateTime;
	public $contentURL;
	public $contentTitleEnglish;
	public $contentTitleJapanese;
	public $contentEnglish;
	public $contentJapanese;
	public $contentViews;

	/*
		CREATE TABLE IF NOT EXISTS `jaga_content` (
		  `entryID` int(8) NOT NULL AUTO_INCREMENT,
		  `channelID` int(8) NOT NULL,
		  `entrychannelID` int(8) NOT NULL,
		  `entryUrl` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
		  `entrySeoURL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `contentCategoryKey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `entryCategoryID` int(8) NOT NULL,
		  `entrySubmittedByUserID` int(8) NOT NULL,
		  `entrySubmissionDateTime` datetime NOT NULL,
		  `entryPublishStartDate` date NOT NULL,
		  `entryPublishEndDate` date NOT NULL,
		  `entryLastModified` datetime NOT NULL,
		  `entryTitleEnglish` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `entryTitleJapanese` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `entryContentEnglish` text COLLATE utf8_unicode_ci NOT NULL,
		  `entryContentJapanese` text COLLATE utf8_unicode_ci NOT NULL,
		  `entrySortOrder` int(8) NOT NULL,
		  `pageID` int(8) NOT NULL,
		  `entryPublished` int(1) NOT NULL,
		  `entryViews` int(12) NOT NULL,
		  `useLeftColumn` int(1) NOT NULL,
		  `useRightColumn` int(1) NOT NULL,
		  `entryKeywordMeta` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `entryDescriptionMeta` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `oldJoomlaID` int(11) NOT NULL,
		  `isEvent` int(1) NOT NULL,
		  `eventDate` date NOT NULL,
		  `eventStartTime` time NOT NULL,
		  `eventEndTime` time NOT NULL,
		  `contentCoordinates` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
		  PRIMARY KEY (`entryID`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9999900 ;
	*/
	
	public function __construct($contentID) {
	
		$core = Core::getInstance();
		$query = "SELECT * FROM jaga_content WHERE entryID = :contentID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':contentID' => $contentID));
		
		while ($row = $statement->fetch()) {
	
			$this->contentID = $row['entryID'];
			$this->channelID = $row['siteID'];
			$this->contentCategoryKey = $row['contentCategoryKey'];
			$this->contentURL = $row['entrySeoURL'];
			$this->contentSubmittedByUserID = $row['entrySubmittedByUserID'];
			$this->contentSubmissionDateTime = $row['entrySubmissionDateTime'];
			$this->contentTitleEnglish = $row['entryTitleEnglish'];
			$this->contentTitleJapanese = $row['entryTitleJapanese'];
			$this->contentEnglish = $row['entryContentEnglish'];
			$this->contentJapanese = $row['entryContentJapanese'];
			$this->contentViews = $row['entryViews'];
			
		}
	}
	
	public function getContent($contentID) {
	
	}
	
	public function getContentArray($contentCategoryKey) {
	
	}
	
	public function getContentList($contentCategoryKey = 'forum', $limitClausePage = 1) {

			$limitClausePageAdjusted = $limitClausePage - 1;
			$entriesPerPage = 25;
			$firstRecord = $limitClausePageAdjusted * $entriesPerPage;
			$limitClause = "LIMIT $firstRecord, $entriesPerPage";
			$currentDate = date('Y-m-d');
			$channelID = 14;


			$query = "
				SELECT * FROM jaga_content 
				WHERE contentCategoryKey = '$contentCategoryKey'
					AND entryPublished = 1 
					AND entryPublishStartDate <= '$currentDate' 
					AND (entryPublishEndDate >= '$currentDate' OR entryPublishEndDate = '0000-00-00')
					AND channelID = '$channelID'
				ORDER BY entryLastModified DESC
				$limitClause
			";

			$core = Core::getInstance();
			$statement = $core->database->query($query);
			$row = $statement->fetchAll();
			
			echo $query . '<hr />';
			print_r($row);
		
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