<?php

	class UserView {

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
			if ($userDisplayName == '') { $userDisplayName = $username; }
			$userEmail = $user->userEmail;
		
			$profileImageURL = Image::getObjectMainImagePath('User', $userID);
			if (!$profileImageURL) {
				if ($user->userRegistrationChannelID == 14) {
					$profileImageURL = "/jaga/images/101704-768px.jpg";
				} else {
					$profileImageURL = "/jaga/images/101703-768px.jpg";
				}
			}

			$html = "<div class=\"container\">\n";
				$html .= "<div class=\"row\">\n";
				
					$html .= "<div class=\"col-sm-5 col-md-3\">";
						$html .= "<img src=\"" . $profileImageURL . "\" class=\"img-responsive\" style=\"margin-bottom:10px;\">";
						$html .= "<h3 style=\"text-align:left;margin:0px;\">" . $userDisplayName . "</h3>";
						
						if ($_SESSION['userID'] == $userID) {
							$html .= "<div style=\"margin:10px 0px;\">";
								$html .= "<a class=\"btn btn-primary btn-block\" href=\"/settings/profile/\">";
									$html .= "<span class=\"glyphicon glyphicon-cog\"></span> ";
									$html .= Lang::getLang('manageAccount');
								$html .= "</a>";
							$html .= "</div>";
						}
						
						// Twitter
						// FB
						// LinkedIn
						// Instagram
						// Pinterest
						// angel.co
						// about.me
						
						
						$userCommentArray = Comment::getUserComments($userID);
						if (!empty($userCommentArray) && $userID == $_SESSION['userID']) {
							
							$html .= "<div class=\"row\">";
							
								$html .= "<div class=\"col-xs-12\">";
								
									$html .= "<div class=\"panel panel-default\" >";

										$html .= "<div class=\"panel-heading jagaContentPanelHeading\">";
											$html .= "<div class=\"panel-title\"><h4>" . Lang::getLang('comments') . "</h4></div>";
										$html .= "</div>";

										$html .= "<div class=\"panel-body\">";

											$html .= "<div class=\"list-group\">";

												foreach ($userCommentArray AS $commentID) {
													
													$comment = new Comment($commentID);
													
													$commentContent = strip_tags($comment->commentContent);
													$commentContent = Utilities::remove_bbcode($commentContent);
													$commentContent = Utilities::remove_urls($commentContent);
													$commentContent = Utilities::truncate($commentContent, 50, " ");
													
													$commentDateTime = date('Y-m-d', strtotime($comment->commentDateTime));
													
													$channel = new Channel($comment->channelID);
													$channelKey = $channel->channelKey;
													
													if ($comment->commentObject == 'Content' && Content::contentExists($comment->commentObjectID)) {
														
														$content = new Content($comment->commentObjectID);
														$contentCategoryKey = $content->contentCategoryKey;
														$contentURL = $content->contentURL;
														$contentViewURL = "http://" . $channelKey . ".jaga.io/k/" . $contentCategoryKey . "/" . $contentURL . "/";

														$html .= "<a href=\"" . $contentViewURL . "\" class=\"list-group-item\">" . $commentContent . "</a>";

													}

												}
											
											$html .= "</div>\n";

										$html .= "</div>\n";
										
									$html .= "</div>\n";
									
								$html .= "</div>\n\n";
								
							$html .= "</div>\n\n";
						
						}

					
					$html .= "</div>\n\n";
					
					$html .= "<div class=\"col-sm-7 col-md-9\">\n\n";
					
						$html .= self::displayRecentPosts($userID);

					$html .= "</div>\n\n";
				$html .= "</div>\n";
			$html .= "</div>\n";
				
			return $html;
		
		}

		public static function displayRecentPosts($userID) {
		
			$user = new User($userID);
			$recentPosts = $user->recentPosts();

			$html = "<div class=\"row\" id=\"list\">"; // start ROW and LIST

				foreach ($recentPosts AS $contentID) {
				
					$content = new Content($contentID);
					$contentTitle = $content->getTitle();
					$contentURL = $content->contentURL;
					$thisContentCategoryKey = $content->contentCategoryKey;
					$contentSubmittedByUserID = $content->contentSubmittedByUserID;
					$contentSubmissionDateTime = $content->contentSubmissionDateTime;
					$contentViews = $content->contentViews;
					$thisChannelID = $content->channelID;
					$contentLinkURL = $content->contentLinkURL;
					
					$channel = new Channel($thisChannelID);
					$thisContentChannelKey = $channel->channelKey;
					$channelTitle = $channel->getTitle();
					
					$contentContent = $content->getContent();
					$contentContent = strip_tags($contentContent);
					$contentContent = preg_replace('/\s+/', ' ', $contentContent);
					$contentContent = Utilities::truncate($contentContent, 100, ' ', '...');
					
					$category = new Category($thisContentCategoryKey);
					$categoryTitle = $category->getTitle();
					
					$user = new User($contentSubmittedByUserID);
					$username = $user->username;
					$userDisplayName = $user->userDisplayName;
					if ($userDisplayName == '') { $userDisplayName = $username;}

					$html .= "<div class=\"item col-xs-12 col-sm-6 col-md-4 col-lg-4\">"; // start ITEM
						$html .= "<div class=\"panel panel-default\">"; // start PANEL
							
							$html .= "<div class=\"panel-heading jagaContentPanelHeading\">";
								$html .= "<h4><a href=\"http://" . $thisContentChannelKey . ".jaga.io/k/" . $thisContentCategoryKey . "/" . $contentURL . "/\">" . strtoupper($contentTitle) . "</a></h4>";
								

								// $html .= "<a href=\"http://jaga.io/u/" . urlencode($username) . "/\">" . $userDisplayName . "</a> ";
								$html .= date('Y-m-d',strtotime($contentSubmissionDateTime));
								
								if ($thisContentChannelKey == $_SESSION['channelKey']) {
									$html .= "<a href=\"http://" . $thisContentChannelKey . ".jaga.io/k/" . $thisContentCategoryKey . "/\" class=\"pull-right\">" . $categoryTitle . "</a>";
								} else {
									$html .= "<a href=\"http://" . $thisContentChannelKey . ".jaga.io/\" class=\"pull-right\">" . $channelTitle . "</a>";
								}
							$html .= "</div>"; // end jagaContentPanelHeading

							$html .= "<a href=\"http://" . $thisContentChannelKey . ".jaga.io/k/" . $thisContentCategoryKey . "/" . $contentURL . "/\" class=\"list-group-item jagaListGroupItem\">";
								$html .= "<span class=\"jagaListGroup\">";

									$videoID = Video::isYouTubeVideo($contentLinkURL);
									if (!$videoID) { $videoID = Video::isYouTubeVideo($content->getContent()); }
									
									if (Image::objectHasImage('Content',$contentID)) {
										$imagePath = Image::getLegacyObjectMainImagePath('Content',$contentID);
										if ($imagePath == "") { $imagePath = Image::getObjectMainImagePath('Content',$contentID,600); }
										if ($imagePath != "") { $html .= "<img class=\"img-responsive\" src=\"" . $imagePath . "\"><br />"; }
									} elseif ($videoID) {
										$html .= "<img class=\"img-responsive\" src=\"http://img.youtube.com/vi/" . $videoID . "/hqdefault.jpg\"><br />";
									}
									
									$html .=  "<div style=\"white-space:pre-line;overflow-y:hidden;\">" . $contentContent . "</div>";
								$html .= "</span>";
							$html .= "</a>";

						$html .= "</div>"; // end PANEL
					$html .= "</div>"; // end ITEM

				}

			$html .= "</div>"; // end ROW
		
			return $html;
		
		}
		
	}

?>