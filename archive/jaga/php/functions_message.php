<?php

function displayMessageList() {

	echo '<div style="text-align:left;">';
		echo '<input type="button" value="' . agileResource('sendMessage') . '" onclick="window.location.href=\'message.php?action=create\'">';
	echo '</div>';
	
	echo '<div style="text-align:center;">';
	echo '<table style="margin:5px auto 5px auto;background-color:#fff;">';
	
		echo '<tr>';
			echo '<td class="borderAlignCenter">' . agileResource('messageSentByUserID') . '</td>';
			echo '<td class="borderAlignCenter">' . agileResource('messageSentDateTime') . '</td>';
			echo '<td class="borderAlignCenter">' . agileResource('messageSubject') . '</td>';
			echo '<td class="borderAlignCenter">' . agileResource('action') . '</td>';
		echo '</tr>';
	
	$resultGetMessages = mysql_query("SELECT * FROM message WHERE messageParentID = 0 ORDER BY messageSentDateTime DESC");
	while($rowGetMessages = mysql_fetch_array($resultGetMessages)) {
		
		echo '<tr>';
			echo '<td class="borderAlignLeft">' . getUserName($rowGetMessages['messageSentByUserID']) . '</td>';
			echo '<td class="borderAlignLeft">' . $rowGetMessages['messageSentDateTime'] . '</td>';
			echo '<td class="borderAlignLeft">' . $rowGetMessages['messageSubject'] . '</td>';
			echo '<td class="borderAlignCenter">';
				echo '<input type="button" value="' . agileResource('read') . '" onclick="window.location.href=\'message.php?action=view&messageID=' . $rowGetMessages['messageID'] . '\'">';
			echo '</td>';
		echo '</tr>';
		
	}
	
	echo '</table>';
	echo '</div>';
	
}

function displayMessageCrud() {

	echo '<div style="text-align:center;">';
	
		if ($_SESSION['roleID'] == 'Super Administrator') {
		echo '<table style="width:700px;margin:5px auto 5px auto;background-color:#fff;">';
		echo '<form name="createMessage" method="post" action="/message.php?action=send">';
			echo '<tr>';
				echo '<td class="borderAlignLeft">';
					echo agileResource('messageRecipient') . '<br />';
					$resultGetUserList = mysql_query("SELECT * FROM j00mla_ver4_users ORDER BY userName DESC");
					while($rowGetUserList = mysql_fetch_array($resultGetUserList)) {
						echo '<input type="checkbox" name="recipientUserID[]" value="' . $rowGetUserList['id'] . '"> ' . getUserName($rowGetUserList['id']) . '<br />';
					}
				echo '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td class="borderAlignLeft">';
					echo agileResource('messageSubject') . '<br />';
					echo '<input type="text" name="messageSubject" style="width:400px;">';
				echo '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td class="borderAlignLeft">';
					echo agileResource('messageContent') . '<br />';
					echo '<textarea name="messageContent" style="width:600px;height:200px;"></textarea>';
				echo '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td class="borderAlignRight">';
					echo '<input type="submit" name="submit" value="' . agileResource('send') . '">';
				echo '</td>';
			echo '</tr>';
		echo '</form>';
		echo '</table>';
		
		} else {
		
			echo '開発中です';
		
		}
		
	echo '</div>';

}

function insertMessage($messageParentID, $messageSubject, $messageContent) {

	$messageSentByUserID = $_SESSION['userID'];
	$messageSentDateTime = date('Y-m-d H:i:s');
	
	$querySendMessage = "INSERT INTO message (
			messageParentID,
			messageSentByUserID,
			messageSentDateTime,
			messageSubject,
			messageContent
	) VALUES (
			'$messageParentID',
			'$messageSentByUserID',
			'$messageSentDateTime',
			'$messageSubject',
			'$messageContent'
	)";
	
	// echo '$querySendMessage = ' . $querySendMessage . '<br />';
	mysql_query ($querySendMessage) or die ('insertMessage() failed');
}

function insertMessageUserRead($messageID, $recipientUserID) {
	
	foreach ($recipientUserID as $thisRecipientUserID) {
	
		$queryInsertMessageUserRead = "INSERT INTO messageUserRead (
			messageID,
			userID,
			messageRead
		) VALUES (
			'$messageID',
			'$thisRecipientUserID',
			0
		)";
		
		// echo '$queryInsertMessageUserRead = ' . $queryInsertMessageUserRead . '<br />';
		mysql_query ($queryInsertMessageUserRead) or die ('insertMessageUserRead() failed');
	
	}
}

function insertReplyMessageUserRead($messageID, $messageParentID) {
	
	$resultGetThisMessageRecipients = mysql_query("SELECT * FROM messageUserRead WHERE messageID = $messageParentID");
	while($rowGetThisMessageRecipients = mysql_fetch_array($resultGetThisMessageRecipients)) {
	
		$userID = $rowGetThisMessageRecipients['userID'];
		
		$queryInsertReplyMessageUserRead = "INSERT INTO messageUserRead (
			messageID,
			userID,
			messageRead
		) VALUES (
			$messageID,
			$userID,
			0
		)";

		mysql_query ($queryInsertReplyMessageUserRead) or die ('insertReplyMessageUserRead() failed');
	
	}
}

function markMessageRead($messageID) {
	
	$queryMarkMessageRead = "UPDATE messageUserRead SET messageRead = 1 WHERE messageID = $messageID AND userID = '$_SESSION[userID]' LIMIT 1";
	mysql_query ($queryMarkMessageRead) or die ('markMessageRead() failed');

}

function viewMessage($messageID) {

	markMessageRead($messageID);

	/*
CREATE TABLE IF NOT EXISTS `message` (
  `messageID` int(8) NOT NULL auto_increment,
  `messageParentID` int(8) NOT NULL,
  `messageSentByUserID` int(8) NOT NULL,
  `messageSentDateTime` datetime NOT NULL,
  `messageSubject` varchar(255) NOT NULL,
  `messageContent` text NOT NULL,
  PRIMARY KEY  (`messageID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1003 ;
	*/
	
	$resultGetMessage = mysql_query("SELECT * FROM message WHERE messageID = $messageID LIMIT 1");
	while($rowGetMessages = mysql_fetch_array($resultGetMessage)) {
	
		echo '<div style="text-align:center;">';
		echo '<table style="width:700px;margin:5px auto 5px auto;background-color:#fff;">';
			echo '<tr>';
				echo '<td class="borderAlignLeft">';
				echo '<b>' . agileResource('recipient') . '</b><br />';
					$resultGetMessageUserRead = mysql_query("SELECT * FROM messageUserRead WHERE messageID = $messageID");
					while($rowGetMessageUserRead = mysql_fetch_array($resultGetMessageUserRead)) {
						echo getUserName($rowGetMessageUserRead['userID']) . '<br />';
					}
				echo '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td class="borderAlignLeft">';
					echo '<b>' . agileResource('messageSubject') . '</b><br />';
					echo $rowGetMessages['messageSubject'];
				echo '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td class="borderAlignLeft">';
					echo '<b>' . agileResource('messageContent') . '</b><br />';
					echo $rowGetMessages['messageContent'];
				echo '</td>';
			echo '</tr>';
		echo '</table>';
		echo '</div>';
	
	
	}
	
	$resultGetMessageReplies = mysql_query("SELECT * FROM message WHERE messageParentID = $messageID ORDER BY messageSentDateTime ASC");
	while($rowGetMessagesReplies = mysql_fetch_array($resultGetMessageReplies)) {
	
		echo '<div style="text-align:center;">';
		echo '<table style="width:700px;margin:5px auto 5px auto;background-color:#fff;">';
			echo '<tr>';
				echo '<td class="borderAlignRight">';
					echo '<b>' . getUserName($rowGetMessagesReplies['messageSentByUserID']) . '</b>';
					echo '&nbsp;|&nbsp;';
					echo '<i>' . $rowGetMessagesReplies['messageSentDateTime'] . '</i>';
				echo '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td class="borderAlignLeft">';
					echo '<b>' . agileResource('messageContent') . '</b><br />';
					echo $rowGetMessagesReplies['messageContent'];
				echo '</td>';
			echo '</tr>';
		echo '</table>';
		echo '</div>';
		
		markMessageRead($rowGetMessagesReplies['messageID']);

	}
	
	echo '<div style="text-align:center;">';
		echo '<table style="width:700px;margin:5px auto 5px auto;background-color:#fff;">';
		echo '<form name="replyToMessage" method="post" action="/message.php?action=reply">';
			echo '<input type="hidden" name="messageParentID" value="' . $messageID . '">';
			echo '<input type="hidden" name="messageSubject" value="' . getMessageSubject($messageID) . '">';
			echo '<tr>';
				echo '<td class="borderAlignCenter">';
					echo '<textarea name="replyToMessage" style="width:680px;margin:5px auto 5px auto;"></textarea>';
				echo '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td class="borderAlignRight"style="background-color:#eee;">';
					echo '<input type="submit" name="submit" value="' . agileResource('reply') . '">';
				echo '</td>';
			echo '</tr>';
		echo '</table>';
	echo '</div>';

}

function getMessageSubject($messageID) {
	$resultGetMessageSubject = mysql_query("SELECT * FROM message WHERE messageID = $messageID LIMIT 1");
	while($rowGetMessageSubject = mysql_fetch_array($resultGetMessageSubject)) {
		$messageSubject = $rowGetMessageSubject['messageSubject'];
	}
	return $messageSubject;
}

function userHasMail($userID) {
	$resultGetMessageUserRead = mysql_query("SELECT * FROM messageUserRead WHERE userID = $userID AND messageRead = 0");
	if (mysql_num_rows($resultGetMessageUserRead) > 0) {
		return 'yes';
	} else { return 'no'; }
}

?>