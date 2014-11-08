<?php

	class UserView {

		public function displayUserProfileContentList($username) {

			$html = "<div class=\"container\">\n";
				$html .= "<div class=\"row\">\n";
				
				$html = "</div>\n";
			$html .= "</div>\n";
			
			return $html;
			
		}
		
		public function displayUserProfileCommentList($username) {
			$html = "<div class=\"container\">\n";
				$html .= "<div class=\"row\">\n";
				
				$html = "</div>\n";
			$html .= "</div>\n";
			
			return $html;
		}
		
		public function displayUserProfileChannelList($username) {
			$html = "<div class=\"container\">\n";
				$html .= "<div class=\"row\">\n";
				
				$html = "</div>\n";
			$html .= "</div>\n";
			
			return $html;
		}
		
		public function displayUserProfileSubscriptionList($username) {
			$html = "<div class=\"container\">\n";
				$html .= "<div class=\"row\">\n";
				
				$html = "</div>\n";
			$html .= "</div>\n";
			
			return $html;
		}

		public function displayUserForm($userID, $inputArray = array(), $errorArray = array()) {
		
			$user = new User($userID);
			
			$username = $user->username;
			$userDisplayName = $user->userDisplayName;
			$userEmail = $user->userEmail;
		
			$profileImageURL = Image::getObjectMainImagePath('User', $userID);
		
			$html = "\n\n<!-- START container -->\n";
			$html .= "<div class=\"container\">\n\n";
			
			$html .= "\n\n<!-- START row -->\n";
			$html .= "<div class=\"row\">\n\n";
			
			$html .= "<!-- START jagaUser -->\n";
			$html .= "<div id=\"jagaUser\">\n\n";
			
				$html .= "<!-- START PANEL -->\n";
				$html .= "<div class=\"panel panel-default\" >\n\n";
					
					
					$html .= "<!-- START PANEL-HEADING -->\n";
					$html .= "<div class=\"panel-heading jagaContentPanelHeading\">";
						$html .= "<div class=\"panel-title\"><h4>" . $username . "</h4></div>";
					$html .= "</div>\n";
					$html .= "<!-- END PANEL-HEADING -->\n\n";
					
					
					$html .= "<!-- START PANEL-BODY -->\n";
					$html .= "<div class=\"panel-body\">\n\n";
				
						$html .= "<!-- START jagaUserForm -->\n";
						$html .= "<form role=\"form\" id=\"jagaUserForm\" name=\"jagaContentForm\" class=\"form-horizontal\"  method=\"post\" action=\"/settings/profile/\"  enctype=\"multipart/form-data\">\n\n";

							$html .= "<div class=\"col-md-3\">";
								$html .= "<img src=\"" . $profileImageURL . "\" class=\"img-responsive\"><br />";
								$html .= "<input type=\"file\" name=\"profileImage\" id=\"profileImage\">";
							$html .= "</div>\n\n";
							
							$html .= "<div class=\"col-md-9\">\n\n";
							
								$html .= "<div style=\"margin-bottom:25px;\" class=\"input-group\">\n";
									$html .= "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>\n";
									$html .= "<input id=\"register-email\" type=\"text\" class=\"form-control";
										if (isset($errorArray['userDisplayName'])) { $html .= " jagaFormValidationError"; }
									$html .= "\" name=\"userDisplayName\" value=\"";
										if (isset($inputArray['userDisplayName'])) { $html .= $inputArray['userDisplayName']; } else { $html .= $userDisplayName; }
									$html .= "\" placeholder=\"Display Name\" required>\n";
								$html .= "</div>\n\n";
								
								$html .= "<div style=\"margin-bottom:25px;\" class=\"input-group\">\n";
									$html .= "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-envelope\"></i></span>\n";
									$html .= "<input id=\"register-email\" type=\"email\" class=\"form-control";
										if (isset($errorArray['userEmail'])) { $html .= " jagaFormValidationError"; }
									$html .= "\" name=\"userEmail\" value=\"";
										if (isset($inputArray['userEmail'])) { $html .= $inputArray['userEmail']; } else { $html .= $userEmail; }
									$html .= "\" placeholder=\"email\" required>\n";
								$html .= "</div>\n\n";
								
								$html .= "<div class=\"row\">";
									
									$html .= "<div class=\"col-md-6\">";
										$html .= "<div class=\"input-group\">\n";
											$html .= "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>\n";
											$html .= "<input id=\"register-password\" type=\"password\" class=\"form-control";
												if (isset($errorArray['password'])) { $html .= " jagaFormValidationError"; }
											$html .= "\" name=\"userPassword\" placeholder=\"new password\" value=\"\">\n";
										$html .= "</div>\n\n";
									$html .= "</div>";
									
									$html .= "<div class=\"col-md-6\">";
										$html .= "<div class=\"input-group\">\n";
											$html .= "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>\n";
											$html .= "<input id=\"register-confirm-password\" type=\"password\" class=\"form-control";
												if (isset($errorArray['confirmPassword'])) { $html .= " jagaFormValidationError"; }
											$html .= "\" name=\"confirmPassword\" placeholder=\"confirm new password\" value=\"\">\n";
										$html .= "</div>\n\n";
									$html .= "</div>";
									
								$html .= "</div>";
								
					
								$html .= "<div style=\"margin-top:10px\" class=\"form-group\">\n";
									$html .= "<div class=\"col-sm-12 controls\">\n";
										$html .= "<input type=\"submit\" name=\"jagaUserUpdate\" id=\"jagaUserUpdate\" class=\"btn btn-default pull-right\" value=\"Update\">\n";
									$html .= "</div>\n";
								$html .= "</div>\n\n";
								
								
								
							$html .= "</div>\n\n";
						
					
						$html .= "</form>\n\n";
				
				
						$html .= "</div>\n";
						$html .= "<!-- END PANEL-BODY -->\n\n";
						
					$html .= "</div>\n";
					$html .= "<!-- END PANEL -->\n\n";
				
				$html .= "</div>\n";
				$html .= "<!-- END jagaUser -->\n\n";
			
			$html .= "</div>\n";
			$html .= "<!-- END row -->\n\n";
			
			$html .= "</div>\n";
			$html .= "<!-- END container -->\n\n";
				
			return $html;
		}
		
		public function displayUserProfile($userID) {
			$html = "<div class=\"container\">\n";
				$html .= "<div class=\"row\">\n";
				
				$html = "</div>\n";
			$html .= "</div>\n";
			
			return $html;
		}

	}

?>