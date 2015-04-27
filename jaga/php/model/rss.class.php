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
			
				$rss .= "\t\t<title>". $channel->channelTitleEnglish . "</title>\n";
				$rss .= "\t\t<link>http://" . $channel->channelKey . ".jaga.io/</link>\n";
				$rss .= "\t\t<description>". $channel->channelDescriptionEnglish . "</description>\n";
				
				// $rss .= "\t<language>". $row['language'] . "</language>\n";
				// $rss .= "\t<image>\n";
					// $rss .= "\t<title>". $row['image_title'] . "</title>\n";
					// $rss .= "\t<url>". $row['image_url'] . "</url>\n";
					// $rss .= "\t<link>". $row['image_link'] . "</link>\n";
					// $rss .= "\t<width>". $row['image_width'] . "</width>\n";
					// $rss .= "\t<height>". $row['image_height'] . "</height>\n";
				// $rss .= "\t</image>\n";
				
				while ($row = $statement->fetch()) {
					
					$title = htmlspecialchars($row['contentTitleEnglish']);
					$pubDate = date('r', strtotime($row['contentSubmissionDateTime']));
					$category = new Category($row['contentCategoryKey']);
					$contentCategory = $category->contentCategoryEnglish;
					
					$contentDescription = strip_tags($row['contentEnglish']);
					$contentDescription = Utilities::remove_urls($contentDescription);
					$contentDescription = Utilities::remove_linebreaks($contentDescription);
					$contentDescription = Utilities::truncate($contentDescription, 100, $break = ' ');
					$contentDescription = htmlspecialchars($contentDescription);
					
					$thisChannelKey = Channel::getChannelKey($row['channelID']);
					$contentURL = 'http://' . $thisChannelKey . '.jaga.io/k/' . $row['contentCategoryKey'] . '/' . $row['contentURL'] . '/';
					
					$rss .= "\t\t<item>\n";
						$rss .= "\t\t\t<title>" . $title . "</title>\n";
						$rss .= "\t\t\t<link>" . $contentURL . "</link>\n";
						$rss .= "\t\t\t<pubDate>" . $pubDate . "</pubDate>\n";
						$rss .= "\t\t\t<category>" . $contentCategory . "</category>\n";
						$rss .= "\t\t\t<description><![CDATA[" . $contentDescription . "]]></description>\n";
					$rss .= "\t\t</item>\n";
					
				}
		
			$rss .= "\t</channel>\n";
			
		$rss .= "</rss>";
		
		return $rss;

	}

}

?>