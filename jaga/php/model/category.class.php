<?php

class Category extends ORM {

	public $contentCategoryKey;
	public $contentCategoryEnglish;
	public $contentCategoryJapanese;
	public $contentCategoryjapaneseReading;
	
	public function __construct($contentCategoryKey = '') {
		
		if ($contentCategoryKey != '') {
		
			$core = Core::getInstance();
			$query = "SELECT * FROM jaga_Category WHERE contentCategoryKey = :contentCategoryKey LIMIT 1";
			$statement = $core->database->prepare($query);
			$statement->execute(array(':contentCategoryKey' => $contentCategoryKey));
			if (!$row = $statement->fetch()) { die('Category does not exist.'); }
			foreach ($row AS $key => $value) { if (!is_int($key)) { $this->$key = $value; } }
			
		} else {

			$this->contentCategoryKey = '';
			$this->contentCategoryEnglish = '';
			$this->contentCategoryJapanese = '';
			$this->contentCategoryjapaneseReading = '';
			
		}
	}
	
	public function getTitle() {
		if ($_SESSION['lang'] == 'ja') {
			if ($this->contentCategoryJapanese != '') { $title = $this->contentCategoryJapanese; } else { $title = $this->contentCategoryEnglish; }
		} else {
			if ($this->contentCategoryEnglish != '') { $title = $this->contentCategoryEnglish; } else { $title = $this->contentCategoryJapanese; }
		}
		return $title;
	}

	public function getCategoryContent($channelID, $contentCategoryKey) {
	
		$currentDate = date('Y-m-d');
		
		if ($channelID != 2006) { $channelFilter = "AND channelID = :channelID"; } else { $channelFilter = ''; }
		
		$query = "
			SELECT `contentID`, `contentViews`
			FROM `jaga_Content`
			WHERE contentPublished = 1
			$channelFilter
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
		if ($channelID != 2006) { $statement->bindValue(':channelID', $channelID); }
		$statement->bindValue(':contentCategoryKey', $contentCategoryKey);
		$statement->execute();
		
		$categoryContentArray = array();
		while ($row = $statement->fetch()) { $categoryContentArray[] = $row['contentID']; }
		return $categoryContentArray;
		
	}

	public function getAllCategories() {
	

	
		$core = Core::getInstance();
		
		$query = "
			SELECT jaga_Category.contentCategoryKey as contentCategoryKey, COUNT(jaga_Content.contentID) as postCount
			FROM jaga_Category LEFT JOIN jaga_Content
			ON jaga_Category.contentCategoryKey = jaga_Content.contentCategoryKey
			GROUP BY jaga_Category.contentCategoryKey
			ORDER BY jaga_Category.contentCategoryKey ASC
		";
		
		$statement = $core->database->prepare($query);
		$statement->execute();
		
		$categoryArray = array();
		while ($row = $statement->fetch()) { $categoryArray[$row['contentCategoryKey']] = $row['postCount']; }
		return $categoryArray;
		
	}

	public function getCategoryTitle($contentCategoryKey) {
		$core = Core::getInstance();
		$query = "SELECT contentCategoryJapanese, contentCategoryEnglish FROM jaga_Category WHERE contentCategoryKey = :contentCategoryKey LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':contentCategoryKey' => $contentCategoryKey));
		if ($row = $statement->fetch()) {
			if ($_SESSION['lang'] == 'ja') { return $row['contentCategoryJapanese']; } else { return $row['contentCategoryEnglish']; }
		} else {
			die($contentCategoryKey);
		}
	}
	
}

?>