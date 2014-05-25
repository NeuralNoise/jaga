<?php

function agileMail($toAddress, $fromAddress, $mailSubject, $mailMessage, $siteID = 0, $userID = 0, $mailType = 'plaintext') {

	if ($siteID == 0) { if (isset($_SESSION['siteID'])) { $siteID = $_SESSION['siteID']; } }
	if ($userID == 0) { if (isset($_SESSION['userID'])) { $userID = $_SESSION['userID']; } }

	if ($mailType == 'plaintext') {
		$mailHeader = "From: $fromAddress";
	} elseif ($mailType == 'html') {
		$mailHeader = "From: $fromAddress\n";
		$mailHeader .= "Reply-To: $fromAddress\n";
		$mailHeader .= "MIME-Version: 1.0\n";
		$mailHeader .= "Content-Type: text/html; charset=UTF-8\n";
	}
	
	mail("$toAddress","$mailSubject","$mailMessage","$mailHeader");
	
	// $auditTrailAction = 'mail to ' . $toAddress . ' from ' . $fromAddress;
	// $auditTrailMailMessage = substr(strip_tags($mailMessage), 0, 200);
	
	$auditTrailAction = 'sendMail';
	$auditTrailMailMessage = 'to ' . $toAddress . ' from ' . $fromAddress;

	
	$mailSentByUserID = $userID;
	$mailSentDateTime = date('Y-m-d H:i:s');
	$mailToAddress = mysql_real_escape_string($toAddress);
	$mailFromAddress = mysql_real_escape_string($fromAddress);
	$mailSubject = mysql_real_escape_string($mailSubject);
	$mailMessage = mysql_real_escape_string($mailMessage);
		
	$querySaveMessage = "INSERT INTO nisekocms_mail (
		siteID,
		mailSentByUserID,
		mailSentDateTime,
		mailToAddress,
		mailFromAddress,
		mailSubject,
		mailMessage
	) VALUES (
		$siteID,
		$mailSentByUserID,
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

}

?>