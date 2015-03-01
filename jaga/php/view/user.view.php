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
			
			$html .= "\n\n<!-- START row -->\n";
			$html .= "<div class=\"col-md-12\">\n\n";
			
			$html .= "<!-- START jagaUser -->\n";
			$html .= "<div id=\"jagaUser\">\n\n";
			
				$html .= "<!-- START PANEL -->\n";
				$html .= "<div class=\"panel panel-default\" >\n\n";
					
					
					$html .= "<!-- START PANEL-HEADING -->\n";
					$html .= "<div class=\"panel-heading jagaContentPanelHeading\">";
						$html .= "<div class=\"panel-title\"><h4>" . strtoupper($username) . "</h4></div>";
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
										$html .= "<input type=\"submit\" name=\"jagaUserUpdate\" id=\"jagaUserUpdate\" class=\"btn btn-default pull-right\" value=\"" . Lang::getLang('update') . "\">\n";
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
			$html .= "<!-- END col-md-12 -->\n\n";
			
			$html .= "</div>\n";
			$html .= "<!-- END row -->\n\n";
			
			$html .= "</div>\n";
			$html .= "<!-- END container -->\n\n";
				
			return $html;
		}
		
		public function displayUserProfile($userID) {

			$user = new User($userID);
			$username = $user->username;
			$userDisplayName = $user->userDisplayName;
			$userEmail = $user->userEmail;
		
			$profileImageURL = Image::getObjectMainImagePath('User', $userID);
		
			$html = "\n\n<!-- START container -->\n";
			$html .= "<div class=\"container\">\n\n";
			
				$html .= "\n\n<!-- START row -->\n";
				$html .= "<div class=\"row\">\n\n";
				
					$html .= "<div class=\"col-sm-3\">";
						$html .= "<img src=\"" . $profileImageURL . "\" class=\"img-responsive\">";
						$html .= "<h3 style=\"text-align:center;\">" . $username . "</h3>";
					$html .= "</div>\n\n";
					
					$html .= "<div class=\"col-sm-9\">\n\n";

						$html .= "<!-- START PANEL -->\n";
						$html .= "<div class=\"panel panel-default\" >\n\n";
							
							$html .= "<!-- START PANEL-HEADING -->\n";
							$html .= "<div class=\"panel-heading jagaContentPanelHeading\">";
								$html .= "<div class=\"panel-title\"><h4>" . Lang::getLang('posts') . "</h4></div>";
							$html .= "</div>\n";
							$html .= "<!-- END PANEL-HEADING -->\n\n";
							
							$html .= "<!-- START PANEL-BODY -->\n";
							$html .= "<div class=\"panel-body\">\n\n";

								$userContentArray = Content::getUserContent($userID);
								
								$html .= "<div style=\"height:300px;overflow:auto;\">";
									$html .= "<div class=\"table-responsive\">";
										$html .= "<table class=\"table table-striped table-condensed table-bordered\">";
											
											$html .= "<tr>";
												$html .= "<th class=\"col-xs-6 col-sm-8\">" . Lang::getLang('post') . "</th>";
												$html .= "<th class=\"col-xs-3 col-sm-2\">" . Lang::getLang('channel') . "</th>";
												$html .= "<th class=\"col-xs-3 col-sm-2\">" . Lang::getLang('date') . "</th>";
											$html .= "</tr>";
											
											foreach ($userContentArray AS $contentID => $contentURL) {
												
												$content = new Content($contentID);
												$contentTitle = $content->contentTitleEnglish;
												$contentCategoryKey = $content->contentCategoryKey;
												$contentSubmissionDateTime = date('Y-m-d', strtotime($content->contentSubmissionDateTime));
												$channel = new Channel($content->channelID);
												$channelKey = $channel->channelKey;
												$channelTitle = $channel->channelTitleEnglish;
												$contentViewURL = "http://" . $channelKey . ".jaga.io/k/" . $contentCategoryKey . "/" . $contentURL . "/";

												$html .= "<tr>";
													$html .= "<td><a href=\"" . $contentViewURL . "\">" . $contentTitle . "</a></td>";
													$html .= "<td>" . $channelTitle . "</td>";
													$html .= "<td>" . $contentSubmissionDateTime . "</td>";
												$html .= "</tr>";

											}
											
										$html .= "</table>";
									$html .= "</div>";
								$html .= "</div>";

							$html .= "</div>\n";
							$html .= "<!-- END PANEL-BODY -->\n\n";
							
						$html .= "</div>\n";
						$html .= "<!-- END PANEL -->\n\n";

						$html .= "<!-- START PANEL -->\n";
							$html .= "<div class=\"panel panel-default\" >\n\n";
								
								$html .= "<!-- START PANEL-HEADING -->\n";
								$html .= "<div class=\"panel-heading jagaContentPanelHeading\">";
									$html .= "<div class=\"panel-title\"><h4>" . Lang::getLang('comments') . "</h4></div>";
								$html .= "</div>\n";
								$html .= "<!-- END PANEL-HEADING -->\n\n";
								
								$html .= "<!-- START PANEL-BODY -->\n";
								$html .= "<div class=\"panel-body\">\n\n";

									$userCommentArray = Comment::getUserComments($userID);
									
									$html .= "<div style=\"height:300px;overflow:auto;\">";
										$html .= "<div class=\"table-responsive\">";
											$html .= "<table class=\"table table-striped table-condensed table-bordered\">";
												
												$html .= "<tr>";
													$html .= "<th class=\"col-xs-8\">" . Lang::getLang('comment') . "</th>";
													$html .= "<th class=\"col-xs-2\">" . Lang::getLang('channel') . "</th>";
													$html .= "<th class=\"col-xs-2\">" . Lang::getLang('date') . "</th>";
												$html .= "</tr>";
												
												foreach ($userCommentArray AS $commentID) {
													
													$comment = new Comment($commentID);
													
													$commentContent = strip_tags($comment->commentContent);
													$commentContent = Utilities::remove_bbcode($commentContent);
													$commentContent = Utilities::remove_urls($commentContent);
													$commentContent = Utilities::truncate($commentContent, 50, " ");
													
													$commentDateTime = date('Y-m-d', strtotime($comment->commentDateTime));
													
													$channel = new Channel($comment->channelID);
													$channelKey = $channel->channelKey;
													$channelTitle = $channel->channelTitleEnglish;
													
													if ($comment->commentObject == 'Content') {
														$content = new Content($comment->commentObjectID);
														$contentCategoryKey = $content->contentCategoryKey;
														$contentURL = $content->contentURL;
														$contentViewURL = "http://" . $channelKey . ".jaga.io/k/" . $contentCategoryKey . "/" . $contentURL . "/";
													}
													
													$html .= "\t\t\t<tr>";
														if (isset($contentViewURL)) { $html .= "<td><a href=\"" . $contentViewURL . "\">" . $commentContent . "</a></td>";
														} else { $html .= "<td>" . $commentContent . "</td>"; }
														$html .= "<td>" . $channelTitle . "</td>";
														$html .= "<td>" . $commentDateTime . "</td>";
													$html .= "\t\t\t</tr>\n";

												}
												
											$html .= "</table>";
										$html .= "</div>";
									$html .= "</div>";
							
								$html .= "</div>\n";
								$html .= "<!-- END PANEL-BODY -->\n\n";
								
							$html .= "</div>\n";
							$html .= "<!-- END PANEL -->\n\n";
						
						$html .= "</div>\n\n";
						
					$html .= "</div>\n\n";

				$html .= "</div>\n";
				$html .= "<!-- END row -->\n\n";
			
			$html .= "</div>\n";
			$html .= "<!-- END container -->\n\n";
				
			return $html;
		
		}

	}

?>