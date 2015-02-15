<?php

class MessageView {
	
	public function imo() {

		$conversations = Message::getConversationArray();

		$html = "\n\t<!-- START CONVERSATION -->\n";
		$html .= "\t<div class=\"container\">\n";
			
		if (empty($conversations)) {
		
			$html .= 'Welcome to IMO, The Kutchannel\'s private message service. You do not yet have any ongoing conversations.';
		
		} else {

			foreach ($conversations AS $userID => $lastMessageDateTime) {
			
				$username = User::getUsername($userID);
				$conversationMessageArray = Message::getConversationMessageArray($userID);
				
				$html .= "\t\t<div class=\"panel panel-info jagaMessagePanel\">\n";
					$html .= "\t\t\t<div class=\"panel-heading jagaMessagePanelHeading\">";
					
						$html .= "<div style=\"float:left;\"><h3 style=\"text-align:right;\">$username</h3></div>";
						$html .= "<div style=\"float:right;\">";
							$html .= "<a role=\"button\" href=\"/u/$username/\" class=\"btn btn-default btn-lg\"><span class=\"glyphicon glyphicon-user\"></span></a>";
							$html .= "<button type=\"button\" class=\"btn btn-default btn-lg\" data-toggle=\"modal\" data-target=\".modal-$username\"><span class=\"glyphicon glyphicon-envelope\"></span></button>";
						$html .= "</div>";
						$html .= "<div style=\"clear:both;\"></div>";
						
					$html .= "</div>\n\n";
					
					$html .= "\t\t\t<div class=\"modal fade modal-$username\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"modalLabel$username\" aria-hidden=\"true\">\n";
						$html .= "\t\t\t\t<div class=\"modal-dialog\">\n";
							$html .= "\t\t\t\t\t<div class=\"modal-content\">\n";
								$html .= "
								
				<div class=\"modal-header\">
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
					<h4 class=\"modal-title\">Send a message to $username...</h4>
				</div>

				<form method=\"post\" action=\"/imo/send/$userID/\">
					<div class=\"modal-body\">
						  <div class=\"form-group\">
							<textarea class=\"form-control\" name=\"messageContent\" id=\"messageContent\" placeholder=\"Enter your message...\"></textarea>
						  </div>
					</div>
					<div class=\"modal-footer\">
						  <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Cancel</button>
						  <button type=\"submit\" class=\"btn btn-default\">Send</button>
					</div>
				</form>									

								";
							$html .= "\t\t\t\t\t</div>\n";
						$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t</div>\n\n";
					
					$html .= "\t\t\t<div class=\"panel-body jagaMessagePanelBody\">\n";
						$html .= "\t\t\t\t<div class=\"panel-group jagaMessagePanelGroup\" id=\"accordion$userID\" role=\"tablist\" aria-multiselectable=\"true\">";
							
							$messagesToMarkAsRead = array();
							
							foreach ($conversationMessageArray AS $messageID => $messageDateTimeSent) {
								
								$message = new Message($messageID);
								$messageSenderUserID = $message->messageSenderUserID;
								$messageReadByRecipient = $message->messageReadByRecipient;

								if ($messageReadByRecipient == 0) { $in = "in"; $expand = "true"; } else { $in = ""; $expand = "false"; }
								if ($messageSenderUserID == $_SESSION['userID']) { $classy = "col-xs-11"; } else { $classy = "col-xs-11 col-xs-offset-1"; }
								
								$html .= "\t\t\t<div class=\"row\">\n";
									$html .= "\t\t\t\t<div class=\"$classy\" style=\"margin-bottom:10px;\">\n";
									
									
										$html .= "\t\t\t\t\t<div class=\"panel panel-default\">\n";
											$html .= "\t\t\t\t\t\t<div class=\"panel-heading\" role=\"tab\" id=\"heading$messageID\">\n";
												$html .= "\t\t\t\t\t\t\t<h4 class=\"panel-title\">\n";
													$html .= "\t\t\t\t\t\t\t\t<a ";
														if ($messageReadByRecipient == 1) { $html .= "class=\"collapsed\" "; }
													$html .= "data-toggle=\"collapse\" data-parent=\"#accordion$userID\" href=\"#collapse$messageID\" aria-expanded=\"$expand\" aria-controls=\"collapse$messageID\">\n";
														if ($messageSenderUserID != $_SESSION['userID']) { $html .= "\t\t\t\t\t\t\t\t<span class=\"glyphicon glyphicon-arrow-left\"></span>\n"; }
														$html .= "\t\t\t\t\t\t\t\t" . User::getUsername($messageSenderUserID) . "\n";
														$html .= "\t\t\t\t\t\t\t\t<small>" . $messageDateTimeSent . "</small>\n";
														if ($messageSenderUserID == $_SESSION['userID']) { $html .= "\t\t\t\t\t\t\t\t<span class=\"glyphicon glyphicon-arrow-right\"></span>\n"; }
													$html .= "\t\t\t\t\t\t\t\t</a>\n";
												$html .= "\t\t\t\t\t\t\t</h4>\n";
											$html .= "\t\t\t\t\t\t</div>\n";
											$html .= "\t\t\t\t\t\t<div id=\"collapse$messageID\" class=\"panel-collapse collapse $in\" role=\"tabpanel\" aria-labelledby=\"heading$messageID\">\n";
												$html .= "\t\t\t\t\t\t\t<div class=\"panel-body\">\n";
													$html .= "\t\t\t\t\t\t\t\t" . strip_tags($message->messageContent) . "\n";
													if ($messageSenderUserID == $_SESSION['userID']) { 
														$html .= "\t\t\t\t\t\t\t\t<hr />\n";
														$html .= "\t\t\t\t\t\t\t\t<div class=\"text-right\">\n";
															$html .= "\t\t\t\t\t\t\t\t\t<a href=\"/imo/delete/$messageID/\" class=\"btn btn-default btn-xs\">\n";
																$html .= "\t\t\t\t\t\t\t\t\t\t<span class=\"glyphicon glyphicon-remove\" style=\"color:#f00;\"></span>\n";
																$html .= "\t\t\t\t\t\t\t\t\t\tDELETE\n";
															$html .= "\t\t\t\t\t\t\t\t\t</a>\n";
														$html .= "\t\t\t\t\t\t\t\t</div>\n";
													}
												$html .= "\t\t\t\t\t\t\t</div>\n";
											$html .= "\t\t\t\t\t\t</div>\n";
										$html .= "\t\t\t\t\t</div>\n";
										
										
									$html .= "\t\t\t\t</div>\n";
								$html .= "\t\t\t</div>\n";
								
								$messagesToMarkAsRead[] = $messageID;
								
							}
							
						$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t</div>\n";
				$html .= "\t\t</div>\n";
				
				foreach ($messagesToMarkAsRead AS $thisMessageID) { Message::markMessageAsRead($thisMessageID); }
				
			}

		}
		
		$html .= "\t</div>\n";
		$html .= "\t<!-- END CONVERSATION -->\n\n";
			
		
		
		return $html;

	}
	
}

?>