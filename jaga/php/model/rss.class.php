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

		$query = "SELECT * FROM jaga_Content WHERE $whereClauseString ORDER BY contentSubmissionDateTime DESC LIMIT 25";
		
		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		if ($channelID != 2006) { $statement->bindParam(':channelID', $channelID); }
		$statement->bindParam(':currentDate', $currentDate);
		if ($contentCategoryKey != '') { $statement->bindParam(':contentCategoryKey', $contentCategoryKey); }
		$statement->execute();

		$rss = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
		
		$rss .= "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n";
		
			$rss .= "\t<channel>\n";
				
				if ($channel->channelKey != 'www') { $channelKey = $channel->channelKey . '.'; } else { $channelKey = ''; }
				
				$rss .= "\t\t<atom:link href=\"http://" . $channelKey . "jaga.io/rss/\" rel=\"self\" type=\"application/rss+xml\" />\n";
				$rss .= "\t\t<title>". $channel->channelTitleEnglish . "</title>\n";
				$rss .= "\t\t<link>http://" . $channelKey . "jaga.io/</link>\n";
				$rss .= "\t\t<description>". $channel->channelDescriptionEnglish . "</description>\n";
				$rss .= "\t\t<language>en</language>\n";
				
				// $rss .= "\t<image>\n";
					// $rss .= "\t<title>". $row['image_title'] . "</title>\n";
					// $rss .= "\t<url>". $row['image_url'] . "</url>\n";
					// $rss .= "\t<link>". $row['image_link'] . "</link>\n";
					// $rss .= "\t<width>". $row['image_width'] . "</width>\n";
					// $rss .= "\t<height>". $row['image_height'] . "</height>\n";
				// $rss .= "\t</image>\n";
				
				while ($row = $statement->fetch()) {
					
					$thisContent = new Content($row['contentID']);
					$thisContentTitle = htmlspecialchars($thisContent->getTitle());
					$thisPubDate = date('r', strtotime($thisContent->contentSubmissionDateTime));
					$thisContentCategoryKey = $thisContent->contentCategoryKey;
					$thisContentURL = $thisContent->contentURL;
					$thisContentDescription = Utilities::feedificate($thisContent->getContent());
					$thisChannelID = $thisContent->channelID;
					
					$thisCategory = new Category($thisContentCategoryKey);
					$thisContentCategory = $thisCategory->getTitle();
					
					$thisChannel = new Channel($thisChannelID);
					$thisChannelKey = $thisChannel->channelKey;

					if ($thisChannelKey && $thisContentCategoryKey && $thisContentURL) {
						$thisUrl = 'http://' . $thisChannelKey . '.jaga.io/k/' . $thisContentCategoryKey . '/' . $thisContentURL . '/';
						$rss .= "\t\t<item>\n";
							$rss .= "\t\t\t<title>" . $thisContentTitle . "</title>\n";
							$rss .= "\t\t\t<link>" . $thisUrl . "</link>\n";
							$rss .= "\t\t\t<guid>" . $thisUrl . "</guid>\n";
							$rss .= "\t\t\t<pubDate>" . $thisPubDate . "</pubDate>\n";
							$rss .= "\t\t\t<category>" . $thisContentCategory . "</category>\n";
							$rss .= "\t\t\t<description><![CDATA[" . $thisContentDescription . "]]></description>\n";
						$rss .= "\t\t</item>\n";
					}
					
				}
		
			$rss .= "\t</channel>\n";
			
		$rss .= "</rss>";
		
		return $rss;

	}

}

?>