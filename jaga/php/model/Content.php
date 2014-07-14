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

?>