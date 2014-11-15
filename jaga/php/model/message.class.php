<?php

class Message extends ORM {

	public $messageID;
	public $messageSenderUserID;
	public $messageRecipientUserID;
	public $messageContent;
	public $messageDateTimeSent;
	public $messageSenderIP;
	public $messageReadByRecipient;

	public function __construct($contentID) {
	
		
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

	public function getInboxMessageArray() {
	
		$userID = $_SESSION['userID'];
		
		$core = Core::getInstance();
		
		$query = "
			SELECT messageID, messageSenderUserID, messageContent, messageDateTimeSent
			FROM jaga_Message 
			WHERE messageRecipientUserID = :userID 
			ORDER BY messageDateTimeSent DESC
		";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID));

		$inboxMessageArray = array();
		while ($row = $statement->fetch()) {
			$messageID = $row['messageID'];
			$inboxMessageArray[$messageID]['messageSenderUserID'] = $row['messageSenderUserID'];
			$inboxMessageArray[$messageID]['messageContent'] = $row['messageContent'];
			$inboxMessageArray[$messageID]['messageDateTimeSent'] = $row['messageDateTimeSent'];
		}
		return $inboxMessageArray;
	}
	
}

?>