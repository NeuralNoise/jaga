<?php

class Comment extends ORM {

	public function getComments($contentID) {
		
		$channelID = $_SESSION['channelID'];
	
		$core = Core::getInstance();
		$query = "
			SELECT userID, commentDateTime, commentContent
			FROM jaga_comment 
			WHERE contentID = :contentID
			AND siteID = :channelID
		";

		$statement = $core->database->prepare($query);
		$statement->execute(array(':contentID' => $contentID, ':channelID' => $channelID));
		$comments = $statement->fetchAll();
		
		return $comments;
	}
	
}

?>