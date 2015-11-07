<?php
	
	class Map {
		
		public function getContentMapArray($channelID, $contentCategoryKey = '', $queryLimit = 25) {

				$currentDate = date('Y-m-d');
				
				$queryWhereArray[] = "contentPublished = 1";
				if ($contentCategoryKey) { $queryWhereArray[] = "contentCategoryKey = :contentCategoryKey"; }
				$queryWhereArray[] = "contentPublishStartDate <= '$currentDate'";
				$queryWhereArray[] = "(contentPublishEndDate >= '$currentDate' OR contentPublishEndDate = '0000-00-00')";
				$queryWhereArray[] = "channelID = :channelID";
				$queryWhereArray[] = "contentHasLocation = 1";
				$whereClause = join(' AND ',$queryWhereArray);
				
				$limitClause = "LIMIT $queryLimit";
				
				$query = "SELECT contentID FROM jaga_Content WHERE $whereClause ORDER BY contentLastModified DESC $limitClause";
				
				$core = Core::getInstance();
				$statement = $core->database->prepare($query);
				$statement->bindParam(':channelID', $channelID);
				if ($contentCategoryKey) { $statement->bindParam(':contentCategoryKey', $contentCategoryKey); }
				$statement->execute();
				
				$contentMapArray = array();
				while ($row = $statement->fetch()) { $contentMapArray[] = $row['contentID']; }
				return $contentMapArray;

		}
	
	}
?>