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

	public static function sendEmail($mailRecipient, $mailSender, $mailSubject, $mailMessage, $channelKey = 0, $userID = 0, $mailType = 'plaintext') {

		// print_r('YO!'); die();
	
		$mailHeader = "From: $mailSender\n";
		$mailHeader .= "Reply-To: $mailSender\n";
			
		if ($mailType == 'html') {
			$mailHeader .= "MIME-Version: 1.0\n";
			$mailHeader .= "Content-Type: text/html; charset=UTF-8\n";
		}
		
		
		
		// SAVE MAIL TO DB
		
		$mail = new Mail(0);
		unset($mail->mailID);
		$mail->channelID = $_SESSION['channelID'];
		$mail->mailSentByUserID = $_SESSION['userID'];
		$mail->mailSentDateTime = date('Y-m-d H:i:s');
		$mail->mailToAddress = $mailRecipient;
		$mail->mailFromAddress = $mailSender;
		$mail->mailSubject = $mailSubject;
		$mail->mailMessage = $mailMessage;
		$mailID = Mail::insert($mail);

	
		if (mail("chishiki@gmail.com","test","test",$mailHeader)) {
			die("Mail Sent Successfully: THANKS DAVID");
		} else {
			// print_r(error_get_last());
			die("
				Mail Not Sent<hr />
				<table style=\"border:1px solid #ddd;\">
					<tr><td>Header</td><td>$mailHeader</td></tr>
					<tr><td>To</td><td>$mailRecipient</td></tr>
					<tr><td>From</td><td>$mailSender</td></tr>
					<tr><td>Subject</td><td>$mailSubject</td></tr>
					<tr><td>Message</td><td>" . htmlspecialchars($mailMessage) . "</td></tr>
					<tr><td>ChannelID</td><td>$channelKey</td></tr>
					<tr><td>UserID</td><td>$userID</td></tr>
					<tr><td>Mail Format</td><td>$mailType</td></tr>
				</table>
			");
		}
					
		// SAVE TO AUDIT TRAIL
	
	}

}

?>