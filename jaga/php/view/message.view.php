<?php

class MessageView {
	
	public $html;
	
	public function imo() {

		$conversations = Message::getConversationArray();

		// print_r($conversations); die();
		
		$h = "<div class=\"container\">";
			
		if (!empty($conversations)) {

			foreach ($conversations AS $userID => $lastMessageDateTime) {
			
				$user = new User($userID);
				$username = $user->username;
				
				$h .= "<div class=\"panel panel-default jagaMessagePanel\" style=\"margin-bottom:20px;\">";
				
				
					$h .= "<div class=\"panel-heading jagaMessagePanelHeading\">";
					
						$h .= "<div style=\"float:left;\"><strong>$username</strong><br /><img src=\"" . $user->profileImage() . "\" class=\"img-responsive\"></div>";
						$h .= "<div style=\"float:right;\">";
							$h .= "<a role=\"button\" href=\"/u/$username/\" class=\"btn btn-default btn-sm\"><span class=\"glyphicon glyphicon-user\"></span></a>";
							$h .= "<button type=\"button\" class=\"btn btn-default btn-sm\" data-toggle=\"modal\" data-target=\".modal-$username\"><span class=\"glyphicon glyphicon-envelope\"></span></button>";
						$h .= "</div>";
						$h .= "<div style=\"clear:both;\"></div>";
						
					$h .= "</div>";
					
					$h .= "<div class=\"modal fade modal-$username\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"modalLabel$username\" aria-hidden=\"true\">";
						$h .= "<div class=\"modal-dialog\">";
							$h .= "<div class=\"modal-content\">";
								$h .= "
													
									<div class=\"modal-header\">
										<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
										<h4 class=\"modal-title\">Send a message to $username...</h4>
									</div>

									<form method=\"post\" action=\"/imo/send/$userID/\">
										<input type=\"hidden\" name=\"messageRecipientUserID\" value=\"" . $userID . "\">
										<div class=\"modal-body\">
											  <div class=\"form-group\">
												<textarea class=\"form-control\" name=\"messageContent\" id=\"messageContent\" placeholder=\"Enter your message...\"></textarea>
											  </div>
										</div>
										<div class=\"modal-footer\">
											  <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">" . Lang::getLang('cancel') . "</button>
											  <button type=\"submit\" class=\"btn btn-default\">" . Lang::getLang('send') . "</button>
										</div>
									</form>									

								";
							$h .= "</div>";
						$h .= "</div>";
					$h .= "</div>";
					
					$h .= "<div class=\"panel-body jagaMessagePanelBody\">";
						$h .= "<div class=\"panel-group jagaMessagePanelGroup\" id=\"accordion$userID\" role=\"tablist\" aria-multiselectable=\"true\">";
							$h .= $this->messages($userID);
						$h .= "</div>";
					$h .= "</div>";
				$h .= "</div>";
				
				
				
			}

		} else { 
			if ($_SESSION['lang'] == 'ja') {
				$h .= 'JAGAのメッセージサービス「IMO」へようこそ。今現在、メッセージがありません。';
			} else {
				$h .= 'Welcome to JAGA\'s private message service, IMO. You do not yet have any ongoing conversations.';
			}
		}
		
		$h .= "</div>";
		$h .= "<!-- END CONVERSATION -->";

		$this->html = $h;

	}
	
	private function messages($userID) {

		$h = "";
		$conversationMessageArray = Message::getConversationMessageArray($userID);
		$messagesToMarkAsRead = array();
							
		foreach ($conversationMessageArray AS $messageID => $messageDateTimeSent) {
			
			$message = new Message($messageID);
			$messageSenderUserID = $message->messageSenderUserID;
			$messageReadByRecipient = $message->messageReadByRecipient;

			if ($messageReadByRecipient == 0) { $in = "in"; $expand = "true"; } else { $in = ""; $expand = "false"; }
			if ($messageSenderUserID == $_SESSION['userID']) {
				$classy = "col-xs-11 col-sm-10 col-md-8";
			} else {
				$classy = "col-xs-11 col-xs-offset-1 col-sm-10 col-sm-offset-2 col-md-9 col-md-offset-3";
			}
			
			$h .= "<div class=\"row\">";
				$h .= "<div class=\"" . $classy . "\" style=\"margin-bottom:10px;\">";
				
				
					$h .= "<div class=\"panel panel-default\">";
						$h .= "<div class=\"panel-heading\" role=\"tab\" id=\"heading$messageID\">";
							$h .= "<h4 class=\"panel-title\">";
								$h .= "<a class=\"";
									if ($messageReadByRecipient == 1) { $h .= "collapsed"; }
								$h .= "\" data-toggle=\"collapse\" data-parent=\"#accordion$userID\" href=\"#collapse$messageID\" aria-expanded=\"$expand\" aria-controls=\"collapse$messageID\">";
									if ($messageSenderUserID != $_SESSION['userID']) { $h .= "<span class=\"glyphicon glyphicon-arrow-left\"></span> "; }
									$h .= User::getUsername($messageSenderUserID) . " <small>" . $messageDateTimeSent . "</small>";
									if ($messageSenderUserID == $_SESSION['userID']) { $h .= " <span class=\"glyphicon glyphicon-arrow-right\"></span>"; }
								$h .= "</a>";
							$h .= "</h4>";
						$h .= "</div>";
						$h .= "<div id=\"collapse$messageID\" class=\"panel-collapse collapse $in\" role=\"tabpanel\" aria-labelledby=\"heading$messageID\">";
							$h .= "<div class=\"panel-body\">";
								$h .= "" . strip_tags($message->messageContent) . "";
								if ($messageSenderUserID == $_SESSION['userID']) { 
									$h .= "<hr />";
									$h .= "<div class=\"text-right\">";
										$h .= "<a href=\"/imo/delete/$messageID/\" class=\"btn btn-default btn-xs\">";
											$h .= "<span class=\"glyphicon glyphicon-remove\" style=\"color:#f00;\"></span>";
											$h .= "DELETE";
										$h .= "</a>";
									$h .= "</div>";
								}
							$h .= "</div>";
						$h .= "</div>";
					$h .= "</div>";
					
					
				$h .= "</div>";
			$h .= "</div>";
			
			$messagesToMarkAsRead[] = $messageID;
			
		}
		
		foreach ($messagesToMarkAsRead AS $thisMessageID) { Message::markMessageAsRead($thisMessageID); }
		
		return $h;
							
	}
}

?>