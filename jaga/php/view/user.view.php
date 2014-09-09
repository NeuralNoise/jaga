<?php

	class UserView {

		public function displayUserProfileContentList($username) {

			$html = "\t<div class=\"container\">\n";
				$html .= "\t\t<div class=\"row\">\n";
				
				$html = "\t\t</div>\n";
			$html .= "\t</div>\n";
			
			return $html;
			
		}
		
		public function displayUserProfileCommentList($username) {
			$html = "\t<div class=\"container\">\n";
				$html .= "\t\t<div class=\"row\">\n";
				
				$html = "\t\t</div>\n";
			$html .= "\t</div>\n";
			
			return $html;
		}
		
		public function displayUserProfileChannelList($username) {
			$html = "\t<div class=\"container\">\n";
				$html .= "\t\t<div class=\"row\">\n";
				
				$html = "\t\t</div>\n";
			$html .= "\t</div>\n";
			
			return $html;
		}
		
		public function displayUserProfileSubscriptionList($username) {
			$html = "\t<div class=\"container\">\n";
				$html .= "\t\t<div class=\"row\">\n";
				
				$html = "\t\t</div>\n";
			$html .= "\t</div>\n";
			
			return $html;
		}

		public function displayUserForm($userID, $inputArray = array(), $errorArray = array()) {
		
			$user = new User($userID);
			
			$username = $user->username;
			$userEmail = $user->userEmail;
		
		
			$html = "\n\n\t<!-- START container -->\n";
			$html .= "\t<div class=\"container\">\n\n";
			
			$html .= "\n\n\t<!-- START row -->\n";
			$html .= "\t<div class=\"row\">\n\n";
			
			$html .= "\t\t<!-- START jagaUser -->\n";
			$html .= "\t\t<div id=\"jagaUser\">\n\n";
			
				$html .= "\t\t\t<!-- START PANEL -->\n";
				$html .= "\t\t\t<div class=\"panel panel-default\" >\n\n";
					
					
					$html .= "\t\t\t\t<!-- START PANEL-HEADING -->\n";
					$html .= "\t\t\t\t<div class=\"panel-heading jagaContentPanelHeading\">";
						$html .= "<div class=\"panel-title\"><h4>" . $username . "</h4></div>";
					$html .= "</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-HEADING -->\n\n";
					
					
					$html .= "\t\t\t\t<!-- START PANEL-BODY -->\n";
					$html .= "\t\t\t\t<div class=\"panel-body\">\n\n";
				
						$html .= "\t\t\t\t\t<!-- START jagaUserForm -->\n";
						$html .= "\t\t\t\t\t<form role=\"form\" id=\"jagaUserForm\" name=\"jagaContentForm\" class=\"form-horizontal\"  method=\"post\" action=\"/settings/profile/\"  enctype=\"multipart/form-data\">\n\n";

							$html .= "\t\t\t\t\t\t<div class=\"col-md-3\">";
								$html .= "<img src=\"#\"><br />";
								$html .= "<input type=\"file\" name=\"file\" id=\"file\">";
							$html .= "</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div class=\"col-md-9\">\n\n";
							
								$html .= "\t\t\t\t\t\t\t<div style=\"margin-bottom:25px;\" class=\"input-group\">\n";
									$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-envelope\"></i></span>\n";
									$html .= "\t\t\t\t\t\t\t<input id=\"register-email\" type=\"email\" class=\"form-control";
										if (isset($errorArray['userEmail'])) { $html .= " jagaFormValidationError"; }
									$html .= "\" name=\"userEmail\" value=\"";
										if (isset($inputArray['userEmail'])) { $html .= $inputArray['userEmail']; } else { $html .= $userEmail; }
									$html .= "\" placeholder=\"email\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n\n";
								
								$html .= "\t\t\t\t\t\t\t<div style=\"margin-bottom: 25px\" class=\"input-group\">\n";
									$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>\n";
									$html .= "\t\t\t\t\t\t\t<input id=\"register-password\" type=\"password\" class=\"form-control";
										if (isset($errorArray['password'])) { $html .= " jagaFormValidationError"; }
									$html .= "\" name=\"password\" placeholder=\"password\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n\n";
								
								$html .= "\t\t\t\t\t\t\t<div style=\"margin-bottom: 25px\" class=\"input-group\">\n";
									$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>\n";
									$html .= "\t\t\t\t\t\t\t<input id=\"register-confirm-password\" type=\"password\" class=\"form-control";
										if (isset($errorArray['confirmPassword'])) { $html .= " jagaFormValidationError"; }
									$html .= "\" name=\"confirmPassword\" placeholder=\"confirm password\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n\n";
								
								$html .= "\t\t\t\t\t\t\t<div style=\"margin-top:10px\" class=\"form-group\">\n";
									$html .= "\t\t\t\t\t\t\t\t<div class=\"col-sm-12 controls\">\n";
										$html .= "\t\t\t\t\t\t\t\t\t<input type=\"submit\" name=\"jagaUserUpdate\" id=\"jagaUserUpdate\" class=\"btn btn-default pull-right\" value=\"Update\">\n";
									$html .= "\t\t\t\t\t\t\t\t</div>\n";
								$html .= "\t\t\t\t\t\t\t</div>\n\n";
								
								
							$html .= "\t\t\t\t\t\t</div>\n\n";
						
					
						$html .= "\t\t\t\t\t</form>\n\n";
				
				
						$html .= "\t\t\t\t</div>\n";
						$html .= "\t\t\t\t<!-- END PANEL-BODY -->\n\n";
						
					$html .= "\t\t\t</div>\n";
					$html .= "\t\t\t<!-- END PANEL -->\n\n";
				
				$html .= "\t\t</div>\n";
				$html .= "\t\t<!-- END jagaUser -->\n\n";
			
			$html .= "\t</div>\n";
			$html .= "\t<!-- END row -->\n\n";
			
			$html .= "\t</div>\n";
			$html .= "\t<!-- END container -->\n\n";
				
			return $html;
		}
		
		public function displayUserProfile($userID) {
			$html = "\t<div class=\"container\">\n";
				$html .= "\t\t<div class=\"row\">\n";
				
				$html = "\t\t</div>\n";
			$html .= "\t</div>\n";
			
			return $html;
		}

	}

?>