<?php

class RSS {

	public function getFeed($urlArray) {

		$channelID = $_SESSION['channelID'];
		$currentDate = date('Y-m-d H:i:s');
		$contentCategoryKey = '';
		
		$channel = new Channel($channelID);

		$whereClause = array();
		if ($contentCategoryKey != '') { $whereClause[] = "contentCategoryKey = :contentCategoryKey"; }
		$whereClause[] = "contentPublished = 1";
		$whereClause[] = "contentPublishStartDate <= :currentDate";
		$whereClause[] = "(contentPublishEndDate >= :currentDate OR contentPublishEndDate = '0000-00-00')";
		if ($channelID != 2006) { $whereClause[] = "channelID = :channelID"; }
		$whereClauseString = join(" AND ", $whereClause);

		$query = "SELECT * FROM jaga_Content WHERE $whereClauseString ORDER BY contentPublishStartDate DESC LIMIT 25";
		
		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		if ($channelID != 2006) { $statement->bindParam(':channelID', $channelID); }
		$statement->bindParam(':currentDate', $currentDate);
		if ($contentCategoryKey != '') { $statement->bindParam(':contentCategoryKey', $contentCategoryKey); }
		$statement->execute();

		$rss = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
		$rss .= "<rss version=\"2.0\">\n";
			$rss .= "\t<channel>\n";
				$rss .= "\t<title>". $channel->channelTitleEnglish . "</title>\n";
				$rss .= "\t<link>http://" . $channel->channelKey . ".kutchannel.net/</link>\n";
				$rss .= "\t<description>". $channel->channelDescriptionEnglish . "</description>\n";
				
				// $rss .= "\t<language>". $row['language'] . "</language>\n";
				// $rss .= "\t<image>\n";
					// $rss .= "\t<title>". $row['image_title'] . "</title>\n";
					// $rss .= "\t<url>". $row['image_url'] . "</url>\n";
					// $rss .= "\t<link>". $row['image_link'] . "</link>\n";
					// $rss .= "\t<width>". $row['image_width'] . "</width>\n";
					// $rss .= "\t<height>". $row['image_height'] . "</height>\n";
				// $rss .= "\t</image>\n";
				
				while ($row = $statement->fetch()) {
					
					$contentEnglish = strip_tags($row['contentEnglish']);
					$contentEnglish = Utilities::remove_urls($contentEnglish);
					$contentEnglish = Utilities::remove_linebreaks($contentEnglish);
					$contentEnglish = Utilities::truncate($contentEnglish, 100, $break = ' ');
					
					$rss .= "\t<item>\n";
						$rss .= "\t\t<title>" . $row['contentTitleEnglish'] . "</title>\n";
						$rss .= "\t\t<link>" . $row['contentURL'] . "</link>\n";
						$rss .= "\t\t<description><![CDATA[" . $contentEnglish . "]]></description>\n";
					$rss .= "\t</item>\n";
				}
		
			$rss .= "\t</channel>\n";
		$rss .= "</rss>";
		
		return $rss;

	}

}

?>