<?php
class MessageView {
	
	public function displayInbox() {

		$messages = Message::getInboxMessageArray();
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