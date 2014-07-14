<?php

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

?>