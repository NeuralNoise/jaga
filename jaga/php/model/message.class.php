<?php

class Message extends ORM {

	public $messageID;
	public $messageSenderUserID;
	public $messageRecipientUserID;
	public $messageContent;
	public $messageDateTimeSent;
	public $messageSenderIP;
	public $messageReadByRecipient;

	public function __construct($messageID) {
	
		
		if ($messageID != 0) {
		
			$core = Core::getInstance();
			$query = "SELECT * FROM jaga_Message WHERE messageID = :messageID LIMIT 1";
			$statement = $core->database->prepare($query);
			$statement->execute(array(':messageID' => $messageID));
			if (!$row = $statement->fetch()) { die('Message does not exist.'); }
			foreach ($row AS $key => $value) { if (!is_int($key)) { $this->$key = $value; } }
			
		} else {

			$this->messageID = 0;
			$this->messageSenderUserID = 0;
			$this->messageRecipientUserID = 0;
			$this->messageContent = '';
			$this->messageDateTimeSent = '0000-00-00 00:00:00';
			$this->messageSenderIP = '';
			$this->messageReadByRecipient = 0;

		}
		
	}

	public static function getConversationArray() {
	
		$userID = $_SESSION['userID'];
		
		$core = Core::getInstance();
		$query = "
			SELECT messageSenderUserID AS userID, messageDateTimeSent FROM jaga_Message WHERE messageSenderUserID = :userID OR messageRecipientUserID = :userID 
			UNION
			SELECT messageRecipientUserID AS userID, messageDateTimeSent FROM jaga_Message WHERE messageSenderUserID = :userID OR messageRecipientUserID = :userID
		";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID));

		$conversationArray = array();
		while ($row = $statement->fetch()) {
			$thisUserID = $row['userID'];
			$thisMessageDateTimeSent = $row['messageDateTimeSent'];
			if ($thisUserID != $_SESSION['userID']) {
				if (
					!isset($conversationArray[$thisUserID]) || 
					(isset($conversationArray[$thisUserID]) && $conversationArray[$thisUserID] < $thisMessageDateTimeSent)
				) {
					$conversationArray[$thisUserID] = $thisMessageDateTimeSent;
				}
			}
		}
		arsort($conversationArray);
		return $conversationArray;
		
	}
	
	public static function getConversationMessageArray($otherUserID) {
	
		$currentUserID = $_SESSION['userID'];
		if ($otherUserID == $currentUserID) { die('dafug?'); }
		
		$core = Core::getInstance();
		$query = "
			SELECT messageID, messageDateTimeSent FROM jaga_Message WHERE messageSenderUserID = :currentUserID AND messageRecipientUserID = :otherUserID 
			UNION
			SELECT messageID, messageDateTimeSent FROM jaga_Message WHERE messageSenderUserID = :otherUserID AND messageRecipientUserID = :currentUserID
		";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':currentUserID' => $currentUserID, ':otherUserID' => $otherUserID));

		$conversationMessageArray = array();
		while ($row = $statement->fetch()) {
			$thisMessageID = $row['messageID'];
			$thisMessageDateTimeSent = $row['messageDateTimeSent'];
			$conversationMessageArray[$thisMessageID] = $thisMessageDateTimeSent;
		}
		arsort($conversationMessageArray);
		return $conversationMessageArray;
		
	}

	public static function markMessageAsRead($messageID) {
		$core = Core::getInstance();
		$query = "UPDATE jaga_Message SET messageReadByRecipient = 1 WHERE messageID = :messageID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':messageID' => $messageID));
	}
	
}

?>