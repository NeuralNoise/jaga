<?php

class Mail {

	public $mailRecipient;
	public $mailSender;
	public $mailSubject;
	public $mailMessage;
	public $channelKey;
	public $userID;
	public $mailType;

	/*
		CREATE TABLE IF NOT EXISTS `nisekocms_mail` (
		  `mailID` int(8) NOT NULL AUTO_INCREMENT,
		  `channelID` int(8) NOT NULL,
		  `mailSentByUserID` int(8) NOT NULL,
		  `mailSentDateTime` datetime NOT NULL,
		  `mailToAddress` varchar(255) NOT NULL,
		  `mailFromAddress` varchar(255) NOT NULL,
		  `mailSubject` varchar(255) NOT NULL,
		  `mailMessage` text NOT NULL,
		  PRIMARY KEY (`mailID`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000001 ;
	*/

	public function sendMail($mailRecipient, $mailSender, $mailSubject, $mailMessage, $channelKey = 0, $userID = 0, $mailType = 'plaintext') {

		// if ($channelKey == 0) { if (isset($_SESSION['channelID'])) { $channelKey = $_SESSION['channelID']; } }
		// if ($userID == 0) { if (isset($_SESSION['userID'])) { $userID = $_SESSION['userID']; } }

		$mailHeader = "From: $mailSender\n";
		$mailHeader .= "Reply-To: $mailSender\n";
			
		if ($mailType == 'html') {
			$mailHeader .= "MIME-Version: 1.0\n";
			$mailHeader .= "Content-Type: text/html; charset=UTF-8\n";
		}
		
		mail("$toAddress","$mailSubject","$mailMessage","$mailHeader");
		
		// $auditTrailAction = 'mail to ' . $mailRecipient . ' from ' . $mailSender;
		// $auditTrailMailMessage = substr(strip_tags($mailMessage), 0, 200);
		
		$auditTrailAction = 'sendMail';
		$auditTrailMailMessage = 'to ' . $mailRecipient . ' from ' . $mailSender;

		/*
		
		$mailSentByUserID = $userID;
		$mailSentDateTime = date('Y-m-d H:i:s');
		$mailToAddress = mysql_real_escape_string($mailRecipient);
		$mailFromAddress = mysql_real_escape_string($mailSender);
		$mailSubject = mysql_real_escape_string($mailSubject);
		$mailMessage = mysql_real_escape_string($mailMessage);
		
		$querySaveMessage = "INSERT INTO nisekocms_mail (
			channelID,
			mailSentByUserID,
			mailSentDateTime,
			mailToAddress,
			mailFromAddress,
			mailSubject,
			mailMessage
		) VALUES (
			'$channelID',
			'$mailSentByUserID',
			'$mailSentDateTime',
			'$mailToAddress',
			'$mailFromAddress',
			'$mailSubject',
			'$mailMessage'
		)";

		// echo '<pre>' . $querySaveMessage . '</pre>';
		
		mysql_query ($querySaveMessage) or die ('error saving mail to DB');
		
		$mailID = mysql_insert_id();
		
		postToAuditTrail(
			$userID, 
			$auditTrailAction, 
			'successful', 
			'',
			$auditTrailMailMessage,
			'mail',
			$mailID
		);
	*/
	
	}

}

?>