<?php

class ChannelCategory extends ORM {

	public $channelID;
	public $contentCategoryKey;
	
	public function __construct() {
		$this->channelID = 0;
		$this->contentCategoryKey = '';
	}
	
	public function getChannelCategoryArray($channelID, $orderBy = 'postCount') {
		
		// returns $array[contentCategoryKey][contentCategoryPostCount]
		
		if ($channelID != 2006) { $channelFilter = 'WHERE jaga_ChannelCategory.channelID = :channelID'; } else { $channelFilter = ''; }
		
		$core = Core::getInstance();
		$query = "
			SELECT jaga_ChannelCategory.contentCategoryKey AS contentCategoryKey, COUNT( jaga_Content.contentID ) AS postCount
			FROM jaga_ChannelCategory
			LEFT JOIN jaga_Content ON jaga_ChannelCategory.channelID = jaga_Content.channelID
			AND jaga_ChannelCategory.contentCategoryKey = jaga_Content.contentCategoryKey
			$channelFilter
			GROUP BY contentCategoryKey
			ORDER BY :orderBy DESC 
		";
		
		$statement = $core->database->prepare($query);
		$statement->execute(array(':channelID' => $channelID, ':orderBy' => $orderBy));
		
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