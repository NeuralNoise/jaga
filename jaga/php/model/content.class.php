<?php

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
	public $contentHasLocation;
	public $contentLatitude;
	public $contentLongitude;
	
	public function __construct($contentID) {
	
		
		if ($contentID != 0) {
		
			$core = Core::getInstance();
			$query = "SELECT * FROM jaga_Content WHERE contentID = :contentID LIMIT 1";
			$statement = $core->database->prepare($query);
			$statement->execute(array(':contentID' => $contentID));
			if (!$row = $statement->fetch()) { die("Content [$contentID] does not exist."); }
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
			$this->contentHasLocation = 0;
			if ($_SESSION['channelID'] == 14) {
				$this->contentLatitude = '42.858659';
				$this->contentLongitude = '140.704899';
			} else {
				$this->contentLatitude = '0.000000';
				$this->contentLongitude = '0.000000';
			}
		}
		
	}
	
	public function getTitle() {
		if ($_SESSION['lang'] == 'ja') {
			if ($this->contentTitleJapanese != '') { $contentTitle = $this->contentTitleJapanese; } else { $contentTitle = $this->contentTitleEnglish; }
		} else {
			if ($this->contentTitleEnglish != '') { $contentTitle = $this->contentTitleEnglish; } else { $contentTitle = $this->contentTitleJapanese; }
		}
		return $contentTitle;
	}
	
	public function getContent($truncate = false) {
		
		if ($_SESSION['lang'] == 'ja') {
			if ($this->contentJapanese != '') { $contentContent = $this->contentJapanese; } else { $contentContent = $this->contentEnglish; }
		} else {
			if ($this->contentEnglish != '') { $contentContent = $this->contentEnglish; } else { $contentContent = $this->contentJapanese; }
		}
		
		if ($truncate) {
			$contentContent = strip_tags($contentContent);
			$contentContent = preg_replace('/\s+/', ' ', $contentContent);
			$contentContent = Utilities::truncate($contentContent, 100, ' ', '...');
		}
		
		
		return $contentContent;
	}
	
	public function getDescription() {
		
		$contentDescription = $this->getContent();
		$contentDescription = strip_tags($contentDescription);
		$contentDescription = preg_replace('/"/', '\'', $contentDescription);
		$contentDescription = htmlspecialchars($contentDescription);
		$contentDescription = Utilities::truncate($contentDescription, 100);
		return $contentDescription;
		
	}
	
	public function getURL($lang = null) {
		$contentURL = "/k/" . $this->contentCategoryKey . "/" . $this->contentURL . "/";
		return $contentURL;
	}
	
	public function usersToNotifyOfComments() {
		
		$query = "
			SELECT contentSubmittedByUserID AS userID FROM jaga_Content WHERE contentID = :contentID
			UNION DISTINCT
			SELECT userID FROM jaga_Comment WHERE commentObject = 'Content' AND commentObjectID = :contentID;
		";

		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		$statement->execute(array(':contentID' => $this->contentID));
		
		$usersToNotify = array();
		while ($row = $statement->fetch()) {
			if ($_SESSION['userID'] != $row['userID']) {
				$user = new User($row['userID']);	
				if ($user->userAcceptsEmail) { $usersToNotify[] = $user->userID; }
			}
		}
		
		return $usersToNotify;
		
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
	
	public function getContentURL($contentID) {
	
		$core = Core::getInstance();
		$query = "SELECT contentURL, contentCategoryKey FROM jaga_Content WHERE contentID = :contentID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':contentID' => $contentID));
		if ($row = $statement->fetch()) { $contentURL = "/k/" . $row['contentCategoryKey'] . "/" . $row['contentURL'] . "/"; } else $contentURL = "/";
		return $contentURL;
		
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

	public function getUserContent($userID) {
			
			$currentDate = date('Y-m-d');

			if ($userID != $_SESSION['userID']) {
				$whereClause = "
					AND contentPublished = 1
					AND contentPublishStartDate <= '$currentDate' 
					AND (contentPublishEndDate >= '$currentDate' OR contentPublishEndDate = '0000-00-00')
				";
			} else { $whereClause = ""; }
			
			$query = "
				SELECT contentID, contentURL FROM jaga_Content 
				WHERE contentSubmittedByUserID = :userID $whereClause
				ORDER BY contentSubmissionDateTime DESC
			";

			$core = Core::getInstance();
			$statement = $core->database->prepare($query);
			$statement->execute(array(':userID' => $userID));
			
			$userContentArray = array();
			while ($row = $statement->fetch()) { $userContentArray[$row['contentID']] = $row['contentURL']; }
			return $userContentArray;
	}
	
	public function getContentTitle($contentURL) {
		
		$core = Core::getInstance();
		$query = "SELECT contentTitleEnglish FROM jaga_Content WHERE contentURL = :contentURL LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':contentURL' => $contentURL));
		if ($row = $statement->fetch()) {
			return $row['contentTitleEnglish'];
		} else {
			die($contentURL);
		}
		
	}
	
	public function getRecentContentArray($channelID, $contentCategoryKey, $numberOfItems) {

		$currentDate = date('Y-m-d');
		if ($channelID != 0) { $whereClauseChannelID = "AND channelID = :channelID"; } else { $whereClauseChannelID = ''; }
		if ($contentCategoryKey != '') { $whereClauseContentCategoryKey = "AND contentCategoryKey = :contentCategoryKey"; } else { $whereClauseContentCategoryKey = ''; }
		$limitClause = "LIMIT $numberOfItems";

		$query = "
			SELECT * FROM jaga_Content 
			WHERE contentPublished = 1 
			AND contentPublishStartDate <= '$currentDate' 
			AND (contentPublishEndDate >= '$currentDate' OR contentPublishEndDate = '0000-00-00')
			$whereClauseChannelID
			$whereClauseContentCategoryKey
			ORDER BY contentLastModified DESC
			$limitClause
		";

		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		
		if ($channelID != 0) { $statement->bindParam(':channelID', $channelID, PDO::PARAM_INT, 12); }
		if ($contentCategoryKey != '') { $statement->bindParam(':contentCategoryKey', $contentCategoryKey, PDO::PARAM_STR, 255); }
		
		$statement->execute();
		
		$recentContentArray = array();
		while ($row = $statement->fetch()) { $recentContentArray[] = $row['contentID']; }
		return $recentContentArray;
		
	}

	public function contentURLExists($contentURL) {
		$core = Core::getInstance();
		$query = "SELECT contentURL FROM jaga_Content WHERE contentURL = :contentURL LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':contentURL' => $contentURL));
		if ($row = $statement->fetch()) { return true; } else { return false; }
	}
	
	public static function contentExists($contentID) {
		$core = Core::getInstance();
		$query = "SELECT contentID FROM jaga_Content WHERE contentID = :contentID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':contentID' => $contentID));
		if ($row = $statement->fetch()) { return true; } else { return false; }
	}
	
	public function generateNonDuplicateContentURL($contentURL) {
		$contentURL = $contentURL . '-' . date('Ymd-His');
		return $contentURL;
	}
	
	public function contentViewsPlusOne($contentID) {
		$core = Core::getInstance();
		$query = "UPDATE jaga_Content SET contentViews = contentViews + 1 WHERE contentID = :contentID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':contentID' => $contentID));
	}

	public function createContentURL($contentTitleEnglish) {

		$contentURL = preg_replace('/ +/', '-', $contentTitleEnglish);
		$contentURL = preg_replace("/[^A-Za-z0-9-]/", '', $contentURL);
		$contentURL = preg_replace('/-{2,}/', '', $contentURL);
		$contentURL = trim($contentURL, "-");
		$contentURL = strtolower($contentURL);
		return $contentURL;
		
	}
	
	public static function api($request) {

		$query = "SELECT contentID FROM jaga_Content WHERE contentPublished = 1 ";
		if ($request['channelID'] != 2006) { $query .= "AND channelID = :channelID "; }
		if ($request['contentCategoryKey'] != '') { $query .= "AND contentCategoryKey = :contentCategoryKey "; }
		$query .= "ORDER BY contentLastModified DESC ";
		$query .= "LIMIT " . $request['first'] . ", " . $request['number'];

		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		if ($request['channelID'] != 2006) { $statement->bindParam(':channelID', $request['channelID']); }
		if ($request['contentCategoryKey'] != '') { $statement->bindParam(':contentCategoryKey', $request['contentCategoryKey']); }
		$statement->execute();

		$response = array();

		while ($row = $statement->fetch()) {
			
			$content = new Content($row['contentID']);
			$user = new User($content->contentSubmittedByUserID);
			$channel = new Channel($content->channelID);
			
			if (!$user->userBlackList && !$user->userShadowBan) {
				
				$response[$row['contentID']]['content_id'] = $row['contentID'];
				$response[$row['contentID']]['channel_title'] = $channel->getTitle();
				$response[$row['contentID']]['channel_key'] = $channel->channelKey;
				$response[$row['contentID']]['content_title'] = $content->getTitle($_SESSION['lang']);
				$response[$row['contentID']]['content_url'] = $content->getURL($_SESSION['lang']);
				$response[$row['contentID']]['content_lead_text'] = $content->getContent(true,$_SESSION['lang']);
				$response[$row['contentID']]['user_name'] = urlencode($user->username);
				$response[$row['contentID']]['user_display_name'] = $user->getUserDisplayName();

				if (Image::objectHasImage('Content',$row['contentID'])) {
					$response[$row['contentID']]['content_main_image'] = Image::getObjectMainImagePath('Content',$row['contentID'],600);
				}
			
			}
			
		}
		
		return json_encode($response);

	}
	
}

?>