<?php

class Mail extends ORM {

	public $mailID;
	public $channelID;
	public $mailSentByUserID;
	public $mailSentDateTime;
	public $mailToAddress;
	public $mailFromAddress;
	public $mailSubject;
	public $mailMessage;

	public function __construct($mailID) {
	
		if ($mailID != 0) {
		
			$core = Core::getInstance();
			$query = "SELECT * FROM jaga_Mail WHERE mailID = :mailID LIMIT 1";
			$statement = $core->database->prepare($query);
			$statement->execute(array(':mailID' => $mailID));
			if (!$row = $statement->fetch()) { die('Mail does not exist.'); }
			foreach ($row AS $key => $value) { if (!is_int($key)) { $this->$key = $value; } }
			
		} else {

			$this->mailID = 0;
			$this->channelID = 0;
			$this->mailSentByUserID = 0;
			$this->mailSentDateTime = '0000-00-00 00:00:00';
			$this->mailToAddress = '';
			$this->mailFromAddress = '';
			$this->mailSubject = '';
			$this->mailMessage = '';

		}
	}

	public function sendEmail($mailRecipient, $mailSender, $mailSubject, $mailMessage, $channelKey = 0, $userID = 0, $mailType = 'plaintext') {

		$mailHeader = "From: $mailSender\n";
		$mailHeader .= "Reply-To: $mailSender\n";
			
		if ($mailType == 'html') {
			$mailHeader .= "MIME-Version: 1.0\n";
			$mailHeader .= "Content-Type: text/html; charset=UTF-8\n";
		}
		
		// mail("$mailRecipient","$mailSubject","$mailMessage","$mailHeader");
		mail("chishiki@gmail.com","$mailSubject","$mailMessage","$mailHeader");
		
		// $auditTrailAction = 'mail to ' . $mailRecipient . ' from ' . $mailSender;
		// $auditTrailMailMessage = substr(strip_tags($mailMessage), 0, 200);
		
		// $auditTrailAction = 'sendEmail';
		// $auditTrailMailMessage = 'to ' . $mailRecipient . ' from ' . $mailSender;
	
	}

}

?>