<?php

class Category extends ORM {


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
	
}

?>