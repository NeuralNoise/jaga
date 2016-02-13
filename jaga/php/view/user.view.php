<?php

	class UserView {

		public $html;
	
		public function displayUserForm($userID, $inputArray = array(), $errorArray = array()) {
		
			$user = new User($userID);
			
			$username = $user->username;
			$userDisplayName = $user->userDisplayName;
			$userEmail = $user->userEmail;
		
			$profileImageURL = Image::getObjectMainImagePath('User', $userID);
		
			$h = "\n\n<!-- START container -->\n";
			$h .= "<div class=\"container\">\n\n";
			
			$h .= "\n\n<!-- START row -->\n";
			$h .= "<div class=\"row\">\n\n";
			
			$h .= "\n\n<!-- START row -->\n";
			$h .= "<div class=\"col-md-12\">\n\n";
			
			$h .= "<!-- START jagaUser -->\n";
			$h .= "<div id=\"jagaUser\">\n\n";
			
				$h .= "<!-- START PANEL -->\n";
				$h .= "<div class=\"panel panel-default\" >\n\n";
					
					
					$h .= "<!-- START PANEL-HEADING -->\n";
					$h .= "<div class=\"panel-heading jagaContentPanelHeading\">";
						$h .= "<div class=\"panel-title\"><h4>" . strtoupper($username) . "</h4></div>";
					$h .= "</div>\n";
					$h .= "<!-- END PANEL-HEADING -->\n\n";
					
					
					$h .= "<!-- START PANEL-BODY -->\n";
					$h .= "<div class=\"panel-body\">\n\n";
				
						$h .= "<!-- START jagaUserForm -->\n";
						$h .= "<form role=\"form\" id=\"jagaUserForm\" name=\"jagaContentForm\" class=\"form-horizontal\"  method=\"post\" action=\"/settings/profile/\"  enctype=\"multipart/form-data\">\n\n";

							$h .= "<div class=\"col-md-3\">";
								$h .= "<img src=\"" . $profileImageURL . "\" class=\"img-responsive\"><br />";
								$h .= "<input type=\"file\" name=\"profileImage\" id=\"profileImage\">";
							$h .= "</div>\n\n";
							
							$h .= "<div class=\"col-md-9\">\n\n";
							
								$h .= "<div style=\"margin-bottom:25px;\" class=\"input-group\">\n";
									$h .= "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>\n";
									$h .= "<input id=\"register-email\" type=\"text\" class=\"form-control";
										if (isset($errorArray['userDisplayName'])) { $h .= " jagaFormValidationError"; }
									$h .= "\" name=\"userDisplayName\" value=\"";
										if (isset($inputArray['userDisplayName'])) { $h .= $inputArray['userDisplayName']; } else { $h .= $userDisplayName; }
									$h .= "\" placeholder=\"Display Name\" required>\n";
								$h .= "</div>\n\n";
								
								$h .= "<div style=\"margin-bottom:25px;\" class=\"input-group\">\n";
									$h .= "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-envelope\"></i></span>\n";
									$h .= "<input id=\"register-email\" type=\"email\" class=\"form-control";
										if (isset($errorArray['userEmail'])) { $h .= " jagaFormValidationError"; }
									$h .= "\" name=\"userEmail\" value=\"";
										if (isset($inputArray['userEmail'])) { $h .= $inputArray['userEmail']; } else { $h .= $userEmail; }
									$h .= "\" placeholder=\"email\" required>\n";
								$h .= "</div>\n\n";
								
								$h .= "<div class=\"row\">";
									
									$h .= "<div class=\"col-md-6\">";
										$h .= "<div class=\"input-group\">\n";
											$h .= "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>\n";
											$h .= "<input id=\"register-password\" type=\"password\" class=\"form-control";
												if (isset($errorArray['password'])) { $h .= " jagaFormValidationError"; }
											$h .= "\" name=\"userPassword\" placeholder=\"new password\" value=\"\">\n";
										$h .= "</div>\n\n";
									$h .= "</div>";
									
									$h .= "<div class=\"col-md-6\">";
										$h .= "<div class=\"input-group\">\n";
											$h .= "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>\n";
											$h .= "<input id=\"register-confirm-password\" type=\"password\" class=\"form-control";
												if (isset($errorArray['confirmPassword'])) { $h .= " jagaFormValidationError"; }
											$h .= "\" name=\"confirmPassword\" placeholder=\"confirm new password\" value=\"\">\n";
										$h .= "</div>\n\n";
									$h .= "</div>";
									
								$h .= "</div>";
								
					
								$h .= "<div style=\"margin-top:10px\" class=\"form-group\">\n";
									$h .= "<div class=\"col-sm-12 controls\">\n";
										$h .= "<input type=\"submit\" name=\"jagaUserUpdate\" id=\"jagaUserUpdate\" class=\"btn btn-default pull-right\" value=\"" . Lang::getLang('update') . "\">\n";
									$h .= "</div>\n";
								$h .= "</div>\n\n";
								
								
								
							$h .= "</div>\n\n";
						
					
						$h .= "</form>\n\n";
				
				
						$h .= "</div>\n";
						$h .= "<!-- END PANEL-BODY -->\n\n";
						
					$h .= "</div>\n";
					$h .= "<!-- END PANEL -->\n\n";
				
				$h .= "</div>\n";
				$h .= "<!-- END jagaUser -->\n\n";
			
			$h .= "</div>\n";
			$h .= "<!-- END col-md-12 -->\n\n";
			
			$h .= "</div>\n";
			$h .= "<!-- END row -->\n\n";
			
			$h .= "</div>\n";
			$h .= "<!-- END container -->\n\n";
				
			$this->html = $h;
			
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

			$h = "<div class=\"container\">\n";
				$h .= "<div class=\"row\">\n";
				
					$h .= "<div class=\"col-sm-5 col-md-3\">";
						$h .= "<img src=\"" . $profileImageURL . "\" class=\"img-responsive\" style=\"margin-bottom:10px;\">";
						$h .= "<h3 style=\"text-align:left;margin:0px;\">" . $userDisplayName . "</h3>";
						
						if ($_SESSION['userID'] == $userID) {
							$h .= "<div style=\"margin:10px 0px;\">";
								$h .= "<a class=\"btn btn-primary btn-block\" href=\"/settings/profile/\">";
									$h .= "<span class=\"glyphicon glyphicon-cog\"></span> ";
									$h .= Lang::getLang('manageAccount');
								$h .= "</a>";
							$h .= "</div>";
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
							
							$h .= "<div class=\"row\">";
							
								$h .= "<div class=\"col-xs-12\">";
								
									$h .= "<div class=\"panel panel-default\" >";

										$h .= "<div class=\"panel-heading jagaContentPanelHeading\">";
											$h .= "<div class=\"panel-title\"><h4>" . Lang::getLang('comments') . "</h4></div>";
										$h .= "</div>";

										$h .= "<div class=\"panel-body\">";

											$h .= "<div class=\"list-group\">";

												foreach ($userCommentArray AS $commentID) {
													
													$comment = new Comment($commentID);
													$commentContent = $comment->blurb(50);
													$commentDateTime = date('Y-m-d', strtotime($comment->commentDateTime));
												
													$channel = new Channel($comment->channelID);
													$channelKey = $channel->channelKey;
													
													if ($comment->commentObject == 'Content' && Content::contentExists($comment->commentObjectID)) {
														
														$content = new Content($comment->commentObjectID);
														$contentCategoryKey = $content->contentCategoryKey;
														$contentURL = $content->contentURL;
														$contentViewURL = "http://" . $channelKey . ".jaga.io/k/" . $contentCategoryKey . "/" . $contentURL . "/";

														$h .= "<a href=\"" . $contentViewURL . "\" class=\"list-group-item\">" . $commentContent . "</a>";

													}

												}
											
											$h .= "</div>\n";

										$h .= "</div>\n";
										
									$h .= "</div>\n";
									
								$h .= "</div>\n\n";
								
							$h .= "</div>\n\n";
						
						}

					
					$h .= "</div>\n\n";
					
					$h .= "<div class=\"col-sm-7 col-md-9\">\n\n";
						
						$this->displayRecentPosts($userID);
						$h .= $this->html;

					$h .= "</div>\n\n";
				$h .= "</div>\n";
			$h .= "</div>\n";
				
			$this->html = $h;
		
		}

		public function displayRecentPosts($userID) {
		
			$user = new User($userID);
			$recentPosts = $user->recentPosts();

			$h = "<div class=\"row\" id=\"list\">"; // start ROW and LIST

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

					if ($content->contentPublished || $userID == $_SESSION['userID'] || Authentication::isAdmin()) {
						$h .= "<div class=\"item col-xs-12 col-sm-6 col-md-4 col-lg-4\">";
							$h .= "<div class=\"panel panel-default\">";
								$h .= "<div class=\"panel-heading jagaContentPanelHeading\">";
									$h .= "<h4><a href=\"http://" . $thisContentChannelKey . ".jaga.io/k/" . $thisContentCategoryKey . "/" . $contentURL . "/\">" . strtoupper($contentTitle) . "</a></h4>";
									$h .= date('Y-m-d',strtotime($contentSubmissionDateTime));
									if ($thisContentChannelKey == $_SESSION['channelKey']) {
										$h .= "<a href=\"http://" . $thisContentChannelKey . ".jaga.io/k/" . $thisContentCategoryKey . "/\" class=\"pull-right\">" . $categoryTitle . "</a>";
									} else {
										$h .= "<a href=\"http://" . $thisContentChannelKey . ".jaga.io/\" class=\"pull-right\">" . $channelTitle . "</a>";
									}
								$h .= "</div>";
								$h .= "<div class=\"panel-body" . (!$content->contentPublished?" bg-danger":"") . "\">";
									$h .= "<a href=\"http://" . $thisContentChannelKey . ".jaga.io/k/" . $thisContentCategoryKey . "/" . $contentURL . "/\" class=\"list-group-item jagaListGroupItem\">";
										$h .= "<span class=\"jagaListGroup\">";
											$videoID = Video::isYouTubeVideo($contentLinkURL);
											if (!$videoID) { $videoID = Video::isYouTubeVideo($content->getContent()); }
											if (Image::objectHasImage('Content',$contentID)) {
												$imagePath = Image::getLegacyObjectMainImagePath('Content',$contentID);
												if ($imagePath == "") { $imagePath = Image::getObjectMainImagePath('Content',$contentID,600); }
												if ($imagePath != "") { $h .= "<img class=\"img-responsive\" src=\"" . $imagePath . "\"><br />"; }
											} elseif ($videoID) {
												$h .= "<img class=\"img-responsive\" src=\"http://img.youtube.com/vi/" . $videoID . "/hqdefault.jpg\"><br />";
											}
											$h .=  "<div style=\"white-space:pre-line;overflow-y:hidden;\">" . $contentContent . "</div>";
										$h .= "</span>";
									$h .= "</a>";
								$h .= "</div>";
							$h .= "</div>";
						$h .= "</div>";
					}
				
				}

			$h .= "</div>";
		
			$this->html = $h;
		
		}
		
	}

?>