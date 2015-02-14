<?php
class MessageView {
	
	public function conversationList() {

		$conversations = Message::getConversationArray();

		$html = '';

		if (empty($conversations)) {
		
			$html .= '<div class="container">Welcome to IMO, The Kutchannel\'s private message service. You do not yet have any ongoing conversations.</div>';
		
		} else {
		
			foreach ($conversations AS $userID => $lastMessageDateTime) {
			
				$username = User::getUsername($userID);
				$conversationMessageArray = Message::getConversationMessageArray($userID);

				$html .= "\n\t<!-- START CONVERSATION -->\n";
				$html .= "\t<div class=\"container\">\n";
					$html .= "\t\t<div class=\"panel panel-info\">\n";
						$html .= "\t\t\t<div class=\"panel-heading jagaMessagePanelHeading\"><h5 style=\"text-align:right;\">" . $username . "</h5></div>\n";
						$html .= "\t\t\t<div class=\"panel-body\">\n";
							$html .= "\t\t\t\t<div class=\"panel-group\" id=\"accordion$userID\" role=\"tablist\" aria-multiselectable=\"true\">";
								$x = 0;
								foreach ($conversationMessageArray AS $messageID => $messageDateTimeSent) {
									
									$message = new Message($messageID);
									
									if ($x == 0) { $expand = "true"; $in = "in"; } else { $expand = "false"; $in = ""; }
									if ($message->messageSenderUserID == $_SESSION['userID']) { $classy = "col-xs-10"; } else { $classy = "col-xs-10 col-xs-offset-2"; }
									
									$html .= "\t\t\t\t\t<div class=\"panel panel-default\">\n";
										$html .= "\t\t\t\t\t\t<div class=\"panel-heading\" role=\"tab\" id=\"heading$messageID\">";
											$html .= "<h4 class=\"panel-title\">";
												$html .= "<a ";
													if ($x != 0) { $html .= "class=\"collapsed\" ";}
												$html .= "data-toggle=\"collapse\" data-parent=\"#accordion$userID\" href=\"#collapse$messageID\" aria-expanded=\"$expand\" aria-controls=\"collapse$messageID\">" . $message->messageDateTimeSent . "</a>";
											$html .= "</h4>";
										$html .= "</div>\n";
										$html .= "\t\t\t\t\t\t<div id=\"collapse$messageID\" class=\"panel-collapse collapse $in\" role=\"tabpanel\" aria-labelledby=\"heading$messageID\">\n";
											$html .= "\t\t\t\t\t\t\t<div class=\"panel-body\">";
												$html .= $message->messageContent;
											$html .= "</div>\n";
										$html .= "\t\t\t\t\t\t</div>\n";
									$html .= "\t\t\t\t\t</div>\n";
									$x++;
								}
							$html .= "\t\t\t\t</div>\n";
						$html .= "\n\t\t\t</div>\n";
					$html .= "\t\t</div>\n";
				$html .= "\t</div>\n";
				$html .= "\t<!-- END CONVERSATION -->\n\n";
			}
			
		}
		
		return $html;
	
	}

	
	public function displayInbox() {

		$messages = Message::getInboxArray();
		
		// print_r($messages);
		// die();
		
		$html = '';
		
		
		if (empty($messages)) {
		
			$html .= '<div class="container">You do not currently have any messages in your inbox.</div>';
		
		} else {
		
			foreach ($messages AS $message) {
			
				$sender = User::getUsername($message['messageSenderUserID']);
				
				$html .= "\n\t<!-- START MESSAGE -->\n";
				$html .= "\t<div class=\"container\">\n\n";
					$html .= "\t\t<div class=\"panel panel-info\">\n";
					
						$html .= "\t\t\t<div class=\"panel-heading jagaMessagePanelHeading\">";
							$html .= "<h5 style=\"text-align:right;\">" . $sender . " - " . $message['messageDateTimeSent'] .= "</h5>";
						$html .= "</div>\n";
						$html .= "\t\t\t<div class=\"panel-body\">\n";
							$html .= $message['messageContent'];
						$html .= "\n\t\t\t</div>\n";
						
					$html .= "\t\t</div>\n";
				$html .= "\n\t</div>\n";
				$html .= "\t<!-- END MESSAGE -->\n\n";
			}
		
		}
		
		return $html;
	
	}

	public function displayMessageForm($messageID) {

		/*
		$html = "\n\t<!-- START MESSAGE FORM CONTAINER -->\n";
		$html .= "\t<div class=\"container\">\n\n";
		
			$html .= "\t\t\t<!-- START PANEL -->\n";
			$html .= "\t\t\t<div class=\"panel panel-default\" >\n\n";
				
				$html .= "\t\t\t\t<!-- START PANEL-HEADING -->\n";
				$html .= "\t\t\t\t<div class=\"panel-heading jagaMessagePanelHeading\">\n\n";
					$html .= "\t\t\t\t\t<div class=\"panel-title\">MESSAGE</div>\n";
				$html .= "\t\t\t\t</div>\n";
				$html .= "\t\t\t\t<!-- END PANEL-HEADING -->\n\n";
				
				$html .= "\t\t\t\t<!-- START PANEL-BODY -->\n";
				$html .= "\t\t\t\t<div class=\"panel-body\">\n\n";

					$html .= "\t\t\t\t\t<!-- START jagaMessageForm -->\n";
					
					$html .= "\t\t\t\t\t<form role=\"form\" id=\"jagaMessageForm\" name=\"jagaMessageForm\" class=\"form-horizontal\"  method=\"post\" action=\"/imo/" . $messageID . "/\">\n\n";
				
						$html .= "<input type=\"hidden\" name=\"messageID\" value=\"" . $messageID . "\">\n";

						$html .= "\t\t\t\t\t\t<div class=\"row\">\n";
							$html .= "<div class=\"col-sm-12\">";
									$html .= "\t\t\t\t\t\t\t\t<textarea id=\"messageContent\" name=\"messageContent\" class=\"form-control\" placeholder=\"messageContent\"></textarea>\n";
							$html .= "</div>";
						$html .= "</div>";

						// START SUBMIT BUTTON
						$html .= "\t\t\t\t\t\t<div class=\"row\">\n";
							$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-12\" style=\"margin-top:5px;\">\n";
								$html .= "\t\t\t\t\t\t\t\t<input type=\"submit\" name=\"jagaMessageSubmit\" id=\"jagaMessageSubmit\" class=\"btn btn-default jagaFormButton col-xs-8 col-sm-6 col-md-4 pull-right\" value=\"Send Message\">\n";
							$html .= "\t\t\t\t\t\t\t</div>\n";
						$html .= "</div>";
						// START SUBMIT BUTTON

					$html .= "\t\t\t\t\t</form>\n";
					$html .= "\t\t\t\t\t<!-- END jagaMessageForm -->\n\n";
		
				$html .= "\t\t\t\t</div>\n";
				$html .= "\t\t\t\t<!-- END PANEL-BODY -->\n\n";
		
			$html .= "\t\t\t</div>\n";
			$html .= "\t\t\t<!-- END PANEL -->\n\n";
			
		$html .= "\t</div>\n";
		$html .= "\t<!-- END MESSAGE FORM CONTAINER -->\n\n";
			
		return $html;

		*/
	}
	
}

?>