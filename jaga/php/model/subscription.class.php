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
	
	public function getRecentSubscribedContentArray($subscriberUserID) {

		$currentDate = date('Y-m-d');

		$query = "
			SELECT jaga_Content.contentID, jaga_Content.contentTitleEnglish, jaga_Content.channelID
			FROM jaga_Subscription
			INNER JOIN jaga_Content ON jaga_Content.channelID = jaga_Subscription.channelID
			WHERE jaga_Content.contentPublished = 1 
			AND jaga_Content.contentPublishStartDate <= '$currentDate' 
			AND (jaga_Content.contentPublishEndDate >= '$currentDate' OR jaga_Content.contentPublishEndDate = '0000-00-00')
			AND jaga_Subscription.userID = :subscriberUserID
			ORDER BY jaga_Content.contentSubmissionDateTime DESC
			LIMIT 50
	";

		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		
		if ($subscriberUserID != 0) { $statement->bindParam(':subscriberUserID', $subscriberUserID, PDO::PARAM_INT, 12); }
		$statement->execute();
		
		$recentSubscribedContentArray = array();
		while ($row = $statement->fetch()) { $recentSubscribedContentArray[] = $row['contentID']; }
		return $recentSubscribedContentArray;
		
	}
	
}

?>