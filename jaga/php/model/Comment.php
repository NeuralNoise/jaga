<?php

class Comment extends ORM {

	public function getComments($contentID) {
		
		$channelID = $_SESSION['channelID'];
	
		$core = Core::getInstance();
		$query = "
			SELECT userID, commentDateTime, commentContent
			FROM jaga_Comment 
			WHERE contentID = :contentID
			AND channelID = :channelID
			ORDER BY commentDateTime ASC
		";

		$statement = $core->database->prepare($query);
		$statement->execute(array(':contentID' => $contentID, ':channelID' => $channelID));
		$comments = $statement->fetchAll();
		
		return $comments;
	}
	
}

?>