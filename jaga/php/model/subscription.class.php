<?php

class Subscription {

	public $userID;
	public $channelID;
	public $subscriptionDate;
	
	public static function userIsSubscribed($userID, $channelID) {
		$core = Core::getInstance();
		$query = "SELECT * FROM jaga_Subscription WHERE userID = :userID AND channelID = :channelID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID, ':channelID' => $channelID));
		if ($row = $statement->fetch()) { return true; } else { return false; }	
	}

	public static function subscribeUser($userID, $channelID) {
		
		if (!self::userIsSubscribed($userID, $channelID)) {
			$core = Core::getInstance();
			$query = "INSERT INTO jaga_Subscription (userID, channelID) VALUES (:userID,:channelID)";
			$statement = $core->database->prepare($query);
			$statement->execute(array(':userID' => $userID, ':channelID' => $channelID));
		}
	}
	
	public static function unsubscribeUser($userID, $channelID) {
		
		if (self::userIsSubscribed($userID, $channelID)) {
			$core = Core::getInstance();
			$query = "DELETE FROM jaga_Subscription WHERE userID = :userID AND channelID = :channelID LIMIT 1";
			$statement = $core->database->prepare($query);
			$statement->execute(array(':userID' => $userID, ':channelID' => $channelID));
		}	
	}

	public static function getUserSubscriptionArray($userID) {
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