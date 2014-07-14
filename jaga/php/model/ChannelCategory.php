<?php

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

?>