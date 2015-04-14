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
		
			$core = Core::getInstance();
			$query = "SELECT * FROM jaga_Channel WHERE channelID = :channelID LIMIT 1";
			$statement = $core->database->prepare($query);
			$statement->execute(array(':channelID' => $channelID));
			// before uncommenting this => existing channelIDs must be in all content
			// if (!$row = $statement->fetch()) { die('Channel does not exist.'); } 
			if ($row = $statement->fetch()) {
				foreach ($row AS $key => $value) { if (!is_int($key)) { $this->$key = $value; } }
			} else {
				// this should never happen
			}
			
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
	
	public function getTitle() {
		if ($_SESSION['lang'] == 'ja') {
			if ($this->channelTitleJapanese != '') { $channelTitle = $this->channelTitleJapanese; } else { $channelTitle = $this->channelTitleEnglish; }
		} else {
			if ($this->channelTitleEnglish != '') { $channelTitle = $this->channelTitleEnglish; } else { $channelTitle = $this->channelTitleJapanese; }
		}
		return $channelTitle;
	}
	
	public function getKeywords() {
		if ($_SESSION['lang'] == 'ja') {
			if ($this->channelKeywordsJapanese != '') { $keywords = $this->channelKeywordsJapanese; } else { $keywords = $this->channelKeywordsEnglish; }
		} else {
			if ($this->channelKeywordsEnglish != '') { $keywords = $this->channelKeywordsEnglish; } else { $keywords = $this->channelKeywordsJapanese; }
		}
		return $keywords;
	}
	
	public function getDescription() {
		if ($_SESSION['lang'] == 'ja') {
			if ($this->channelDescriptionJapanese != '') { $description = $this->channelDescriptionJapanese; } else { $description = $this->channelDescriptionEnglish; }
		} else {
			if ($this->channelDescriptionEnglish != '') { $description = $this->channelDescriptionEnglish; } else { $description = $this->channelDescriptionJapanese; }
		}
		return $description;
	}
	
	public function getChannelArray() {

		$core = Core::getInstance();
		$query = "
			SELECT jaga_Channel.channelKey AS channelKey, COUNT(jaga_Content.contentID) AS postCount
			FROM jaga_Channel LEFT JOIN jaga_Content
			ON jaga_Channel.channelID = jaga_Content.channelID
			WHERE jaga_Channel.channelEnabled = 1 AND jaga_Channel.channelID != 2006
			GROUP BY jaga_Channel.channelKey
			ORDER BY COUNT(jaga_Content.contentID) DESC
		";
		
		$statement = $core->database->prepare($query);
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
			SELECT jaga_Subscription.channelID as channelID, COUNT(jaga_Content.contentID) as postCount 
			FROM jaga_Subscription, jaga_Content 
			WHERE jaga_Subscription.channelID = jaga_Content.channelID 
			AND jaga_Subscription.userID = :userID
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
		if ($tmp[0] == 'jaga' && $tmp[1] == 'io') { array_unshift($tmp, "www"); }
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