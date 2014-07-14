<?php

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

?>