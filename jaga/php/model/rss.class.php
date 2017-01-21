<?php

class RSS {

	public function getFeed($urlArray) {

		$channelID = $_SESSION['channelID'];
		$currentDate = date('Y-m-d H:i:s');
		$channel = new Channel($channelID);
		if ($channel->channelKey != 'www') { $channelKey = $channel->channelKey . '.'; } else { $channelKey = ''; }		
		$channelTitle = $channel->getTitle();
		$channelDescription = $channel->getDescription();
		$atomLink = 'http://' . $channelKey . 'jaga.io/rss/';
		
		if ($channel->channelKey != 'www' && $urlArray[1] == 'first-snow-contest') {
			
			$atomLink = $atomLink . 'first-snow-contest/';

			$query = "SELECT * FROM jaga_Prediction ";
			$query .= "WHERE channelID = :channelID ";
			$query .= "ORDER BY dateTimeSubmitted DESC ";
			$query .= "LIMIT 25";
			
			$core = Core::getInstance();
			$statement = $core->database->prepare($query);
			$statement->bindParam(':channelID', $channelID);
			$statement->execute();
			
			// BUILD RSS
			$rss = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
			$rss .= "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n";
				$rss .= "\t<channel>\n";
					$rss .= "\t\t<atom:link href=\"" . $atomLink . "\" rel=\"self\" type=\"application/rss+xml\" />\n";
					$rss .= "\t\t<title>". $channelTitle . "</title>\n";
					$rss .= "\t\t<link>http://" . $channelKey . "jaga.io/</link>\n";
					$rss .= "\t\t<description>This feed publishes entries to the First Snow COntest </description>\n";
					$rss .= "\t\t<language>en</language>\n";

					while ($row = $statement->fetch()) {

						$user = new User($row['userID']);
						$pubDate = date('r', strtotime($row['dateTimeSubmitted']));
						$description = $user->getUserDisplayName() . " has predicted that " . strtoupper($channel->channelKey) . "'s first measurable snowfall will be on ";
						$description .= date("l, F jS",strtotime($row['dateTimePredicted'])) . " at " . date("g:ia",strtotime($row['dateTimePredicted']));
						$description .= " => #" . ucwords($channel->channelKey) . " #FirstSnowContest";
						
						if (!$user->userShadowBan) {
							$thisUrl = 'http://' . $channelKey . 'jaga.io/first-snow-contest/';
							$rss .= "\t\t<item>\n";
								$rss .= "\t\t\t<title>A prediction has been made!</title>\n";
								$rss .= "\t\t\t<link>" . $thisUrl . "</link>\n";
								$rss .= "\t\t\t<guid>" . $thisUrl . "</guid>\n";
								$rss .= "\t\t\t<pubDate>" . $pubDate . "</pubDate>\n";
								$rss .= "\t\t\t<category>" . strtoupper($channel->channelKey) . " First Snow Contest</category>\n";
								$rss .= "\t\t\t<description><![CDATA[" . $description . "]]></description>\n";
							$rss .= "\t\t</item>\n";
						}
					}
					
				$rss .= "\t</channel>\n";
			$rss .= "</rss>";
			
			
		} else {

			if ($urlArray[1] == 'k' && $urlArray[2] != '') { $contentCategoryKey = $urlArray[2]; }
			if ($urlArray[1] == 'u' && $urlArray[2] != '') { $contentSubmittedByUserID = User::getUserID($urlArray[2]); }
			if ($urlArray[1] == 'k' && $urlArray[2] != '') { $atomLink .= 'k/' . $urlArray[2] . '/'; }
			if ($urlArray[1] == 'u' && $urlArray[2] != '') { $atomLink .= 'u/' . $urlArray[2] . '/'; }

			$releaseDateTime = date('Y-m-d H:i:s',strtotime($currentDate . " - 12 hours"));
			// publish delay to allow content review before social distribution
			// content must have been created BEFORE this datetime in order to be published to RSS
			
			// QUERY
			$whereClause = array();
			if (isset($contentCategoryKey)) { $whereClause[] = "contentCategoryKey = :contentCategoryKey"; }
			if (isset($contentSubmittedByUserID)) { $whereClause[] = "contentSubmittedByUserID = :contentSubmittedByUserID"; }
			$whereClause[] = "contentPublished = 1";
			$whereClause[] = "contentPublishStartDate <= :currentDate";
			$whereClause[] = "contentSubmissionDateTime <= :releaseDateTime";
			$whereClause[] = "(contentPublishEndDate >= :currentDate OR contentPublishEndDate = '0000-00-00')";
			if ($channelKey) { $whereClause[] = "channelID = :channelID"; }
			$whereClauseString = join(" AND ", $whereClause);
			$query = "SELECT * FROM jaga_Content WHERE $whereClauseString ORDER BY contentSubmissionDateTime DESC LIMIT 25";
			
			// EXECUTE
			$core = Core::getInstance();
			$statement = $core->database->prepare($query);
			if ($channelID != 2006) { $statement->bindParam(':channelID', $channelID); }
			$statement->bindParam(':currentDate', $currentDate);
			$statement->bindParam(':releaseDateTime', $releaseDateTime);
			if (isset($contentCategoryKey)) { $statement->bindParam(':contentCategoryKey', $contentCategoryKey); }
			if (isset($contentSubmittedByUserID)) { $statement->bindParam(':contentSubmittedByUserID', $contentSubmittedByUserID); }
			$statement->execute();

			// BUILD RSS
			$rss = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
			$rss .= "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n";
				$rss .= "\t<channel>\n";
					$rss .= "\t\t<atom:link href=\"" . $atomLink . "\" rel=\"self\" type=\"application/rss+xml\" />\n";
					$rss .= "\t\t<title>". $channelTitle . "</title>\n";
					$rss .= "\t\t<link>http://" . $channelKey . "jaga.io/</link>\n";
					$rss .= "\t\t<description>". $channelDescription . "</description>\n";
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
						$thisUser = new User($thisContent->contentSubmittedByUserID);
						$thisCategory = new Category($thisContentCategoryKey);
						$thisContentCategory = Utilities::feedificate($thisCategory->getTitle());
						$thisChannel = new Channel($thisChannelID);
						$thisChannelKey = $thisChannel->channelKey;
						if ($thisChannelKey && $thisContentCategoryKey && $thisContentURL && !$thisUser->userShadowBan) {
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
		
		}
		
		return $rss;

	}

}

?>