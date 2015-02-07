<?php

class Comment extends ORM {

	public $commentID;
	public $channelID;
	public $userID;
	public $commentDateTime;
	public $commentObject;
	public $commentObjectID;
	public $commentContent;

	public function __construct($commentID = 0) {
		if ($commentID != 0) {
			$core = Core::getInstance();
			$query = "SELECT * FROM jaga_Comment WHERE commentID = :commentID LIMIT 1";
			$statement = $core->database->prepare($query);
			$statement->execute(array(':commentID' => $commentID));
			if (!$row = $statement->fetch()) { die('This comment does not exist.'); }
			foreach ($row AS $key => $value) { if (!is_int($key)) { $this->$key = $value; } }
		} else {
			$this->commentID = 0;
			if (isset($_SESSION['channelID'])) { $this->channelID = $_SESSION['channelID']; } else { $this->channelID = 0; }
			if (isset($_SESSION['userID'])) { $this->userID = $_SESSION['userID']; } else { $this->userID = 0; }
			$this->commentDateTime = date('Y-m-d H:i:s');
			$this->commentObject = '';
			$this->commentObjectID = 0;
			$this->commentContent = '';
		}
	}

	public function getComments($object, $objectID) {
		$core = Core::getInstance();
		$query = "SELECT commentID FROM jaga_Comment WHERE object = :object AND objectID = :objectID ORDER BY commentDateTime DESC";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':object' => $object, ':objectID' => $objectID));
		$commentArray = array();
		while ($row = $statement->fetch()) { $commentArray[$row['contentID']] = $row['contentURL']; }
		return $commentArray;
	}

}

?>