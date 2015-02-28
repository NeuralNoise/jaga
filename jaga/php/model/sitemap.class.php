<?php

class Sitemap {

	private $xml;
	
	public function __construct($urlArray = array()) {
		
		$channelID = $_SESSION['channelID'];
		$currentDate = date('Y-m-d H:i:s');
		
		$channel = new Channel($channelID);

		$whereClause = array();
		$whereClause[] = "contentPublished = 1";
		$whereClause[] = "contentPublishStartDate <= :currentDate";
		$whereClause[] = "(contentPublishEndDate >= :currentDate OR contentPublishEndDate = '0000-00-00')";
		if ($channelID != 2006) { $whereClause[] = "channelID = :channelID"; }
		$whereClauseString = join(" AND ", $whereClause);

		$query = "SELECT * FROM jaga_Content WHERE $whereClauseString ORDER BY contentSubmissionDateTime DESC";
		
		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		if ($channelID != 2006) { $statement->bindParam(':channelID', $channelID); }
		$statement->bindParam(':currentDate', $currentDate);
		$statement->execute();

		$this->xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$this->xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		
		while ($row = $statement->fetch()) {

			$channelKey = Channel::getChannelKey($row['channelID']);
			$contentCategoryKey = $row['contentCategoryKey'];
			$contentURL = $row['contentURL'];
			$this->xml .= "\t<url><loc>http://" . $channelKey . ".jaga.io/k/" . $contentCategoryKey . "/" . htmlspecialchars($contentURL) . "/</loc></url>\n";
			
		}

		$this->xml .= "</urlset>";
		
	}
	
	public function getSitemap() {
		return $this->xml;
	}
	
}

?>