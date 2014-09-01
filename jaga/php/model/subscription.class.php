<?php

class Subscription {

	var $userID;
	var $channelID;
	
	public function userIsSubscribed($userID, $channelID) {
		$core = Core::getInstance();
		$query = "SELECT * FROM jaga_Subscription WHERE userID = :userID AND channelID = :channelID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID, ':channelID' => $channelID));
		if ($row = $statement->fetch()) { return true; } else { return false; }	
	}

	public function subscribeUser($userID, $channelID) {
		
		if (!self::userIsSubscribed($userID, $channelID)) {
			$core = Core::getInstance();
			$query = "INSERT INTO jaga_Subscription (userID, channelID) VALUES (:userID,:channelID)";
			$statement = $core->database->prepare($query);
			$statement->execute(array(':userID' => $userID, ':channelID' => $channelID));
		}
	}
	
	public function unsubscribeUser($userID, $channelID) {
		
		if (self::userIsSubscribed($userID, $channelID)) {
			$core = Core::getInstance();
			$query = "DELETE FROM jaga_Subscription WHERE userID = :userID AND channelID = :channelID LIMIT 1";
			$statement = $core->database->prepare($query);
			$statement->execute(array(':userID' => $userID, ':channelID' => $channelID));
		}	
	}

	public function getUserSubscriptionArray($userID) {
		$core = Core::getInstance();
		$query = "SELECT channelID FROM jaga_Subscription WHERE userID = :userID";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID));
		
		$userSubscriptionArray = array();
		while ($row = $statement->fetch()) {
			$userSubscriptionArray[] = $row['channelID'];
		}
		return $userSubscriptionArray;
	}
	
}

?>