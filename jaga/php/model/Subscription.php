<?php

class Subscription extends ORM {

	var $userID;
	var $channelID;
	
	public function userIsSubscribed($userID, $channelID) {
		$core = Core::getInstance();
		$query = "SELECT * FROM jaga_Subscription WHERE userID = :userID AND channelID = :channelID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID, ':channelID' => $channelID));
		if ($row = $statement->fetch()) { return true; } else { return false; }	
	}
}

?>