<?php

class AuthenticationView {

	public static function getAuthForm($type, $errorArray = array()) {
	
		$html = "\n\n\t<!-- START AUTH CONTAINER -->\n";
		$html .= "\t<div class=\"container\" style=\"margin-top:30px;\">\n\n";
		
		if ($type == 'login') {
	
			$html .= "\t\t<!-- START jagaLogin -->\n";
			$html .= "\t\t<div id=\"jagaLogin\" class=\"mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2\">\n\n";

				$html .= "\t\t\t<!-- START PANEL -->\n";
				$html .= "\t\t\t<div class=\"panel panel-default\" >\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-HEADING -->\n";
					$html .= "\t\t\t\t<div class=\"panel-heading\">\n\n";
						
						$html .= "\t\t\t\t\t<div class=\"panel-title\">BETA USERS ONLY</div>\n";
					
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-HEADING -->\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-BODY -->\n";
					$html .= "\t\t\t\t<div style=\"padding-top:30px\" class=\"panel-body\">\n\n";
					
						
						// if (!empty($errorArray)) {
							// foreach ($errorArray AS $value) { $html .= "\t\t\t\t\t<div id=\"login-alert\" class=\"alert alert-danger col-sm-12\">$value</div>\n"; }
						// }
						
						
						
						$html .= "\t\t\t\t\t<!-- START jagaLoginForm -->\n";
						$html .= "\t\t\t\t\t<form role=\"form\" id=\"jagaLoginForm\" name=\"login\" class=\"form-horizontal\" method=\"post\" action=\"/login/\">\n\n";
					
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom:25px;\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"login-username\" type=\"text\" class=\"form-control\" name=\"username\" value=\"\" placeholder=\"username or email\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom: 25px\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"login-password\" type=\"password\" class=\"form-control\" name=\"password\" placeholder=\"password\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-top:10px\" class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-12 controls\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"submit\" name=\"jagaLoginSubmit\" id=\"jagaLoginSubmit\" class=\"btn btn-default pull-right\" value=\"Login\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
			
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-md-12 control\">\n";
									$html .= "\t\t\t\t\t\t\t\t<div style=\"border-top: 1px solid#888; padding-top:15px; font-size:85%\" >Don\'t have a Kutchannel account? <a href=\"/register/\">Register</a></div>\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
			
						$html .= "\t\t\t\t\t</form>\n";
						$html .= "\t\t\t\t\t<!-- END jagaLoginForm -->\n\n";
			
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-BODY -->\n\n";
			
				$html .= "\t\t\t</div>\n";
				$html .= "\t\t\t<!-- END PANEL -->\n\n";
			
			$html .= "\t\t</div>\n";
			$html .= "\t\t<!-- END jagaLogin -->\n\n";
	
		}
		
		if ($type == 'register') {
		
			$html .= "\t\t<!-- START jagaRegister -->\n";
			$html .= "\t\t<div id=\"jagaRegister\" class=\"mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2\">\n\n";
			
				$html .= "\t\t\t<!-- START PANEL -->\n";
				$html .= "\t\t\t<div class=\"panel panel-default\" >\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-HEADING -->\n";
					$html .= "\t\t\t\t<div class=\"panel-heading\">\n\n";

						$html .= "\t\t\t\t\t<div class=\"panel-title\">TESTING ONLY</div>\n";
						// $html .= "\t\t\t\t\t<div style=\"float:right;font-size:85%;position:relative;top:-10px;\"><a href=\"/login/\">Login</a></div>\n";
						
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-HEADING -->\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-BODY -->\n";
					$html .= "\t\t\t\t<div class=\"panel-body\">\n\n";
					
					
						$html .= "\t\t\t\t\t<!-- START jagaRegisterForm -->\n";
						$html .= "\t\t\t\t\t<form name=\"jagaRegisterForm\" id=\"signupform\" class=\"form-horizontal\" role=\"form\" method=\"post\" action=\"/register/\">\n\n";
						
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom:25px;\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"register-username\" type=\"text\" class=\"form-control\" name=\"username\" value=\"\" placeholder=\"desired username\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom:25px;\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-envelope\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"register-email\" type=\"email\" class=\"form-control\" name=\"userEmail\" value=\"\" placeholder=\"email\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom: 25px\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"register-password\" type=\"password\" class=\"form-control\" name=\"password\" placeholder=\"password\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom: 25px\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"register-confirm-password\" type=\"password\" class=\"form-control\" name=\"confirmPassword\" placeholder=\"confirm password\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-top:10px\" class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-12 controls\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"submit\" name=\"jagaRegisterSubmit\" id=\"jagaRegisterSubmit\" class=\"btn btn-default pull-right\" value=\"Register\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";

						$html .= "\t\t\t\t\t</form>\n";
						$html .= "\t\t\t\t\t<!-- END jagaRegisterForm -->\n\n";
					
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-BODY -->\n\n";
					
				$html .= "\t\t\t\t</div>\n";
				$html .= "\t\t\t\t<!-- END PANEL -->\n\n";
			
			$html .= "\t\t</div>\n";
			$html .= "\t\t<!-- END jagaRegister -->\n\n";
		}
			
		$html .= "\t</div>\n";
		$html .= "\t<!-- END AUTH CONTAINER -->\n\n";
			
		return $html;
	
	}
}

class CarouselView {

	public function getCarousel() {
	
		$html = "
		<div class=\"container\">
			<div id=\"kutchannel-carousel\" class=\"carousel slide\" data-ride=\"carousel\">

				<!-- Indicators -->
				<ol class=\"carousel-indicators\">
					<li data-target=\"#kutchannel-carousel\" data-slide-to=\"0\" class=\"active\"></li>
					<li data-target=\"#kutchannel-carousel\" data-slide-to=\"1\"></li>
					<li data-target=\"#kutchannel-carousel\" data-slide-to=\"2\"></li>
				</ol>

				<!-- START SLIDES -->
				
				<div class=\"carousel-inner\">
					<div class=\"item active\">
						<img src=\"/jaga/images/test1.jpg\" alt=\"test1\" style=\"margin-left:auto;margin-right:auto;\">
					</div>
					<div class=\"item\">
						<img src=\"/jaga/images/test2.jpg\" alt=\"test2\" style=\"margin-left:auto;margin-right:auto;\">
					</div>
					<div class=\"item\">
						<img src=\"/jaga/images/test3.jpg\" alt=\"test3\" style=\"margin-left:auto;margin-right:auto;\">
					</div>
				</div>

				<!-- END SLIDES -->
				
				<!-- Controls -->
				<a class=\"left carousel-control\" href=\"#kutchannel-carousel\" data-slide=\"prev\"><span class=\"glyphicon glyphicon-chevron-left\"></span></a>
				<a class=\"right carousel-control\" href=\"#kutchannel-carousel\" data-slide=\"next\"><span class=\"glyphicon glyphicon-chevron-right\"></span></a>

			</div>
		</div>
		";
		return $html;
	}
}

class CategoryView {
	
	public function displayChannelCategories($channelID) {
		$categoryArray = ChannelCategory::getChannelCategoryArray($channelID);
		$html = '';
		$html .= "\t\t<div class=\"container\">\n";
		$k = 0;
		foreach ($categoryArray AS $contentCategoryKey => $postCount) {
			if ($k % 3 == 0) { $html .= "<div class=\"row\">"; }
				$html .= "<div class=\"col-md-4\">";
					$html .= "<div class=\"panel panel-default\">\n";
						$html .= "<div class=\"panel-heading jagaContentPanelHeading\"><h4>" . strtoupper($contentCategoryKey) . "</h4></div>\n";
							$html .= "<ul class=\"list-group\">\n";
								$contentArray = Category::getCategoryContent($channelID, $contentCategoryKey);
								// print_r($contentArray);
								$i = 0;
								foreach ($contentArray AS $contentID) {
									if ($i < 5) {
										$content = new Content($contentID);
										$contentURL = $content->contentURL;
										$contentTitle = $content->contentTitleEnglish;
										$contentSubmittedByUserID = $content->contentSubmittedByUserID;
										$contentSubmissionDateTime = $content->contentSubmissionDateTime;
										$contentViews = $content->contentViews;
										$user = new User($contentSubmittedByUserID);
										$username = $user->username;
										$html .= "<a href=\"/k/" . $contentCategoryKey . "/" . $contentURL . "/\" class=\"list-group-item jagaListGroupItem\">";
											$html .= "<span class=\"jagaListGroup\">";
												$html .= "<span class=\"jagaListGroupBadge\">" . $contentViews . "</span>";
												$html .=  $contentTitle;
											$html .= "</span>";
										$html .= "</a>\n"; 
									}
									$i++;
								}
								$html .= "<a href=\"/k/" . $contentCategoryKey . "/\" class=\"list-group-item jagaListGroupItemMore\">";
									$html .= "MORE <span class=\"glyphicon glyphicon-arrow-right\"></span>";
								$html .= "</a>\n"; 
							$html .= "</ul>\n";
					$html .= "</div>\n";
				$html .= "</div>";
			if ($k % 3 == 2) { $html .= "</div>"; }
			$k++;
		}
		if ($k % 3 != 0) { $html .= "</div> <!-- END ROW -->"; }
		$html .= "\t\t</div>\n";
		return $html;	
	}
	
}

class ChannelView {

	public static function getChannelForm($type, $channelID = 0, $inputArray = array(), $errorArray = array()) {
	
		if (empty($inputArray)) {
		
			if ($type == 'create') {
			
				$channelKey ='';
				$channelTitleEnglish = '';
				$channelTitleJapanese = '';
				$channelKeywordsEnglish = '';
				$channelKeywordsJapanese = '';
				$channelDescriptionEnglish = '';
				$channelDescriptionJapanese = '';
				$themeKey = '';
				$contentCategoryKeyArray = array('news', 'blog', 'forum');
			
			} elseif ($type == 'update') {

				$channel = new Channel($channelID);
				$channelKey = $channel->channelKey;
				$channelTitleEnglish = $channel->channelTitleEnglish;
				$channelTitleJapanese = $channel->channelTitleJapanese;
				$channelKeywordsEnglish = $channel->channelKeywordsEnglish;
				$channelKeywordsJapanese = $channel->channelKeywordsJapanese;
				$channelDescriptionEnglish = $channel->channelDescriptionEnglish;
				$channelDescriptionJapanese = $channel->channelDescriptionJapanese;
				$themeKey = $channel->themeKey;
				$contentCategoryKeyArray = array_keys(ChannelCategory::getChannelCategoryArray($channelID));

			}
			
		} else {
		
			$channelKey = $inputArray['channelKey'];
			$channelTitleEnglish = $inputArray['channelTitleEnglish'];
			$channelTitleJapanese = $inputArray['channelTitleJapanese'];
			$channelKeywordsEnglish = $inputArray['channelKeywordsEnglish'];
			$channelKeywordsJapanese = $inputArray['channelKeywordsJapanese'];
			$channelDescriptionEnglish = $inputArray['channelDescriptionEnglish'];
			$channelDescriptionJapanese = $inputArray['channelDescriptionJapanese'];
			$themeKey = $inputArray['themeKey'];
			
			$contentCategoryKeyArray = array();
			if (isset($inputArray['contentCategoryKey'])) { $contentCategoryKeyArray = $inputArray['contentCategoryKey']; }
			
		}
		
		
	


		
		
		
		
		
		
		
		
		
		
		$html = "\n\n";
		$html .= "\t<div class=\"container\">\n";
		$html .= "\t<!-- START CHANNEL CONTAINER -->\n\n";

			$html .= "\t\t<!-- START jagaChannel -->\n";
			$html .= "\t\t<div id=\"jagaChannel\" class=\"\">\n\n";

				$html .= "\t\t\t<!-- START PANEL -->\n";
				$html .= "\t\t\t<div class=\"panel panel-default\" >\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-HEADING -->\n";
					$html .= "\t\t\t\t<div class=\"panel-heading jagaContentPanelHeading\">\n\n";
						
						$html .= "\t\t\t\t\t<div class=\"panel-title\">CHANNEL " . strtoupper($type) . "</div>\n";
					
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-HEADING -->\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-BODY -->\n";
					$html .= "\t\t\t\t<div class=\"panel-body\">\n\n";
						
						$html .= "\t\t\t\t\t<!-- START jagaChannelForm -->\n";
						$html .= "\t\t\t\t\t<form role=\"form\" id=\"jagaChannelForm\" name=\"jagaChannelForm\" class=\"form-horizontal\"  method=\"post\" action=\"/manage-channels/" . $type . "/";
							if ($type == 'update') { $html .= $channelKey . "/"; }
						$html .= "\">\n\n";
					
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<label for=\"channelKey\" class=\"col-sm-2 control-label\">channelKey</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-10\">\n";
								
									if ($type == 'create') {
										$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"channelKey\" name=\"channelKey\" class=\"form-control\" placeholder=\"channelKey\" value=\"" . strtoupper($channelKey) . "\">\n";
									} elseif ($type == 'update') {
										$html .= "<p class=\"form-control-static\">" . $channelKey . "</p>";
										$html .= "<input type=\"hidden\" name=\"channelKey\" value=\"" . $channelKey . "\">\n";
									}

								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "<hr />";
							
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<label for=\"channelTitleEnglish\" class=\"col-sm-2 control-label\">channelTitleEnglish</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-10\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"channelTitleEnglish\" name=\"channelTitleEnglish\" class=\"form-control\" placeholder=\"channelTitleEnglish\" value=\"" . $channelTitleEnglish . "\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<label for=\"channelKeywordsEnglish\" class=\"col-sm-2 control-label\">channelKeywordsEnglish</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-10\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"channelKeywordsEnglish\" name=\"channelKeywordsEnglish\" class=\"form-control\" placeholder=\"channelKeywordsEnglish\" value=\"" . $channelKeywordsEnglish . "\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<label for=\"channelDescriptionEnglish\" class=\"col-sm-2 control-label\">channelDescriptionEnglish</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-10\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"channelDescriptionEnglish\" name=\"channelDescriptionEnglish\" class=\"form-control\" placeholder=\"channelDescriptionEnglish\" value=\"" . $channelDescriptionEnglish . "\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";

							$html .= "<hr />";
							
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<label for=\"channelTitleJapanese\" class=\"col-sm-2 control-label\">channelTitleJapanese</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-10\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"channelTitleJapanese\" name=\"channelTitleJapanese\" class=\"form-control\" placeholder=\"channelTitleJapanese\" value=\"" . $channelTitleJapanese . "\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<label for=\"channelKeywordsJapanese\" class=\"col-sm-2 control-label\">channelKeywordsJapanese</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-10\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"channelKeywordsJapanese\" name=\"channelKeywordsJapanese\" class=\"form-control\" placeholder=\"channelKeywordsJapanese\" value=\"" . $channelKeywordsJapanese . "\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<label for=\"channelDescriptionJapanese\" class=\"col-sm-2 control-label\">channelDescriptionJapanese</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-10\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"channelDescriptionJapanese\" name=\"channelDescriptionJapanese\" class=\"form-control\" placeholder=\"channelDescriptionJapanese\" value=\"" . $channelDescriptionJapanese . "\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "<hr />";
							
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<label for=\"themeKey\" class=\"col-sm-2 control-label\">themeKey</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-2\">\n";
									$html .= ThemeView::getThemeDropdown($themeKey);
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "<hr />";
							
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<label for=\"contentCategoryKey[]\" class=\"col-sm-2 control-label\">categories</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-10\">\n";
									$categoryArray = Category::getAllCategories();
									foreach ($categoryArray AS $contentCategoryKey => $postCount) {
										$html .= "<label class=\"checkbox-inline\">\n";
											$html .= "<input type=\"checkbox\" id=\"contentCategoryKey\" name=\"contentCategoryKey[]\" value=\"" . $contentCategoryKey . "\"";
												if (in_array($contentCategoryKey, $contentCategoryKeyArray)) {
													$html .= " checked";
												}
											$html .= "> " . $contentCategoryKey . " (" . $postCount . ")\n";
										$html .= "</label>\n";
									}
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
								
							
							$html .= "<hr />";
							
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								// $html .= "\t\t\t\t\t\t\t<label for=\"themeKey\" class=\"col-sm-2 control-label\">themeKey</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-12\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"submit\" name=\"jagaChannelSubmit\" id=\"jagaChannelSubmit\" class=\"btn btn-default jagaFormButton col-xs-8 col-sm-6 col-md-4 pull-right\" value=\"" . $type . "\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
								
							$html .= "\t\t\t\t\t\t</div>\n\n";

						$html .= "\t\t\t\t\t</form>\n";
						$html .= "\t\t\t\t\t<!-- END jagaChannelForm -->\n\n";
			
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-BODY -->\n\n";
			
				$html .= "\t\t\t</div>\n";
				$html .= "\t\t\t<!-- END PANEL -->\n\n";
			
			$html .= "\t\t</div>\n";
			$html .= "\t\t<!-- END jagaChannel -->\n\n";

		$html .= "\t</div>\n";
		$html .= "\t<!-- END CHANNEL CONTAINER -->\n\n";
			
		return $html;
	
	}

	public static function displayUserChannelList() {
	
		$channelArray = Channel::getUserOwnChannelArray($_SESSION['userID']);
		$html = '';
		
		$html .= "\t<!-- START CHANNEL LIST -->\n";
		$html .= "\t<div class=\"container\">\n\n";
		
			$html .= "<div class=\"panel panel-default\">\n";
				
				$html .= "<div class=\"panel-heading jagaContentPanelHeading\"><h4>YOUR CHANNELS</h4></div>\n";
				
				$html .= "<div class=\"table-responsive\">\n";
					$html .= "<table class=\"table table-hover\">\n";
						$html .= "<thead>\n";
							$html .= "<tr>";
								$html .= "<th>channelKey</th>\n";
								$html .= "<th>channelTitleEnglish</th>\n";
								$html .= "<th>themeKey</th>\n";
								$html .= "<th>totalPosts</th>\n";
								$html .= "<th>pagesServed</th>\n";
							$html .= "</tr>";
						$html .= "</thead>\n";
						$html .= "<tbody>\n";
						
							foreach ($channelArray AS $channelKey => $totalPosts) {
							
								$channelID = Channel::getChannelID($channelKey);
								
								$channel = new Channel($channelID);
								$channelEnabled = $channel->channelEnabled;
								$channelTitleEnglish = $channel->channelTitleEnglish;
								$channelTitleJapanese = $channel->channelTitleJapanese;
								$channelKeywordsEnglish = $channel->channelKeywordsEnglish;
								$channelKeywordsJapanese = $channel->channelKeywordsJapanese;
								$channelDescriptionEnglish = $channel->channelDescriptionEnglish;
								$channelDescriptionJapanese = $channel->channelDescriptionJapanese;
								$themeKey = $channel->themeKey;
								$pagesServed = $channel->pagesServed;
								$siteManagerUserID = $channel->siteManagerUserID;
								
								$html .= "<tr class=\"jagaClickableRow\" data-url=\"/manage-channels/update/" . $channelKey . "/\">";
								
									$html .= "<td>" . strtoupper($channelKey) . "</td>\n";
									$html .= "<td>" . $channelTitleEnglish . "</td>\n";
									$html .= "<td>" . $themeKey . "</td>\n";
									$html .= "<td>" . $totalPosts . "</td>\n";
									$html .= "<td>" . $pagesServed . "</td>\n";
								$html .= "</tr>";
								
							}
							
						$html .= "</tbody>\n";
					$html .= "</table>\n";
				$html .= "</div>\n";
				
			$html .= "</div>\n";

		$html .= "\t</div>\n";
		$html .= "\t<!-- END CHANNEL LIST -->\n\n";
		
		return $html;	

	}
	
}

class ContentView {

	function displayContentForm(
		$type = 'create', 
		$contentCategoryKey = '', 
		$entryID = 0, 
		$entryTitleEnglish = '', 
		$entryTitleJapanese = '',
		$entryPublished = 1, 
		$entryContentEnglish = '',
		$entryContentJapanese = '',
		$entryPublishStartDate = '',
		$entryPublishEndDate = '',
		$isEvent = 0,
		$eventDate = '',
		$eventStartTime = '',
		$eventEndTime = ''
	) {

	}

	function displayContentView($entryID) {
	
		$core = Core::getInstance();
		$query = "SELECT entryContentEnglish AS content FROM jaga_content WHERE entryID = :entryID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':entryID' => $entryID));
		if ($row = $statement->fetch()) {
			return $row['content'];
		} else {
			die ("ContentView::displayContentView(\$entryID) cannot find your content.");
		}
	
	}


}

class MenuView {

	public function getNavBar() {
	
		$channel = new Channel($_SESSION['channelID']);
		$channelTitle = $channel->getChannelTitle();
		
		$user = new User($_SESSION['userID']);
		$username = $user->username;
		
		// $categoryArray = ChannelCategory::getChannelCategoryArray($_SESSION['channelID']);
		// $userOwnChannelArray = Channel::getUserOwnChannelArray($_SESSION['userID']);
		// $userSubscribedChannelArray = Channel::getUserSubscribedChannelArray($_SESSION['userID']);
		
		
		// $channelArray = Channel::getChannelArray();

		$html = "\t<!-- START NAVIGATION DIV -->\n";
		$html .= "\t<div class=\"navbar-wrapper\">\n\n";
		
			$html .= "\t\t<!-- START NAV -->\n";
			$html .= "\t\t<nav class=\"navbar navbar-default navbar-fixed-top\" role=\"navigation\">\n\n";
			
				$html .= "\t\t\t<!-- START CONTAINER -->\n";
				$html .= "\t\t\t<div class=\"container\">\n\n";

					$html .= "\t\t\t\t<!-- START NAVBAR-HEADER -->\n";
					$html .= "\t\t\t\t<div class=\"navbar-header\">\n\n";
						
						$html .= "\t\t\t\t\t<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">\n";
							$html .= "\t\t\t\t\t\t<span class=\"sr-only\">Toggle navigation</span>\n";
							$html .= "\t\t\t\t\t\t<span class=\"icon-bar\"></span>\n";
							$html .= "\t\t\t\t\t\t<span class=\"icon-bar\"></span>\n";
							$html .= "\t\t\t\t\t\t<span class=\"icon-bar\"></span>\n";
						$html .= "\t\t\t\t\t</button>\n\n";
						
						if ($_SESSION['channelID'] == 2006) {
							$html .= "\t\t\t\t\t<a href=\"/\"><img id=\"kLogo\" src=\"/jaga/images/banner.png\"></a>\n\n";
						} else {
							$html .= "\t\t\t\t\t<a class=\"navbar-brand\" href=\"/\">" . strtoupper($channelTitle) . "</a>\n\n";
						}
						
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END NAVBAR-HEADER -->\n\n";

					$html .= "\t\t\t\t<!-- START NAVBAR-COLLAPSE -->\n";
					$html .= "\t\t\t\t<div class=\"collapse navbar-collapse\">\n\n";
						
						$html .= "\t\t\t\t\t<ul class=\"nav navbar-nav navbar-right\">\n";

							$html .= "\t\t\t\t\t\t<li><a href=\"http://the.kutchannel.net/\"><span class=\"glyphicon glyphicon-home\"></span><span class=\"visible-xs\">HOME</span></a></li>\n";
							
							if ($_SESSION['userID'] != 0) {
								$html .= "\t\t\t\t\t\t<li><a href=\"http://the.kutchannel.net/newsfeed/\"><span class=\"glyphicon glyphicon-list-alt\"></span><span class=\"visible-xs\">NEWSFEED</span></a></li>\n";
							}
							
							
							
							// START "THIS CHANNEL" DROPDOWN //
							if ($_SESSION['channelID'] != 2006) { // the.kutchannel.net categories are aggregate
								$html .= "\t\t\t\t\t\t<li class=\"dropdown\"><a href=\"/\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">THIS CHANNEL <b class=\"caret\"></b></a>\n";
									$html .= "\t\t\t\t\t\t\t<ul class=\"dropdown-menu\">\n";
										$html .= self::getNavBarCategoryListItems();
										$html .= "\t\t\t\t\t\t\t\t<li><a href=\"/k/\"><em>ALL CATEGORIES...</em></a></li>\n";
									$html .= "\t\t\t\t\t\t\t</ul>\n";
								$html .= "\t\t\t\t\t\t</li>\n";
							}
							// END "THIS CHANNEL" DROPDOWN //
							
							
							
							// START "YOUR CHANNELS" DROPDOWN //
							$html .= "\t\t\t\t\t\t<li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">YOUR CHANNELS <b class=\"caret\"></b></a>\n";
								if ($_SESSION['userID'] == 0) {
									$html .= "\t\t\t\t\t\t\t<ul class=\"dropdown-menu\">\n";
										$html .= "\t\t\t\t\t\t\t\t<li><a href=\"/login/\">LOGIN</a></li>\n";
										$html .= "\t\t\t\t\t\t\t\t<li><a href=\"/register/\">REGISTER</a></li>\n";
									$html .= "\t\t\t\t\t\t\t</ul>\n";	
								} else {
									$html .= "\t\t\t\t\t\t\t<ul class=\"dropdown-menu jagaDrop\">\n";
										$html .= self::getNavBarOwnChannelListItems();
										$html .= "\t\t\t\t\t\t\t\t<li class=\"divider\"></li>\n";
										$html .= "\t\t\t\t\t\t\t\t<li><a href=\"http://the.kutchannel.net/channels/\"><em>YOUR CHANNELS...</em></a></li>\n";
										$html .= "\t\t\t\t\t\t\t\t<li class=\"divider\"></li>\n";
										$html .= self::getNavBarSubscriptionListItems();
										$html .= "\t\t\t\t\t\t\t\t<li class=\"divider\"></li>\n";
										$html .= "\t\t\t\t\t\t\t\t<li><a href=\"http://the.kutchannel.net/subscriptions/\"><em>YOUR SUBSCRIPTIONS...</em></a></li>\n";
									$html .= "\t\t\t\t\t\t\t</ul>\n";
								}
							$html .= "\t\t\t\t\t\t</li>\n";
							// END "YOUR CHANNELS" DROPDOWN //
							
							
							
							// START "EXPLORE" DROPDOWN //
							$html .= "\t\t\t\t\t\t<li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">EXPLORE <b class=\"caret\"></b></a>\n";
								$html .= "\t\t\t\t\t\t\t<ul class=\"dropdown-menu jagaDrop\">\n";
									$html .= self::getNavBarExploreListItems();
									$html .= "\t\t\t\t\t\t\t\t<li class=\"divider\"></li>\n";
									$html .= "\t\t\t\t\t\t\t\t<li><a href=\"http://the.kutchannel.net/\">ALL CHANNELS...</a></li>\n";
								$html .= "\t\t\t\t\t\t\t</ul>\n";
							$html .= "\t\t\t\t\t\t</li>\n";
							// END "EXPLORE" DROPDOWN //
							
							if ($_SESSION['userID'] == 0) { // IF NOT LOGGED IN
								
								$html .= "\t\t\t\t\t\t<li><a href=\"/login/\"><span class=\"glyphicon glyphicon-log-in\"></span><span class=\"visible-xs\">LOGIN</span></a></li>\n";
				
							} else { // IF LOGGED IN
							
								$html .= "\t\t\t\t\t\t<li><a href=\"/u/" .  $username . "/\"><span class=\"glyphicon glyphicon glyphicon-user\"></span><span class=\"visible-xs\">PROFILE</span></a></li>\n";
								
								$html .= "\t\t\t\t\t\t<li><a href=\"/messages/\"><span class=\"glyphicon glyphicon-envelope\"></span><span class=\"visible-xs\">MESSAGES</span></a></li>\n";
								
								$html .= "\t\t\t\t\t\t<li><a href=\"/settings/\"><span class=\"glyphicon glyphicon-cog\"></span><span class=\"visible-xs\">SETTINGS</span></a></li>\n";
								
								$html .= "\t\t\t\t\t\t<li><a href=\"/logout/\"><span class=\"glyphicon glyphicon-log-out\"></span><span class=\"visible-xs\">LOGOUT</span></a></li>\n";
								
							}
								
						$html .= "\t\t\t\t\t</ul>\n";
					
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END NAVBAR-COLLAPSE -->\n\n";
					
				$html .= "\t\t\t</div>\n";
				$html .= "\t\t\t<!-- END CONTAINER -->\n\n";
				
			$html .= "\t\t</nav>\n";
			$html .= "\t\t<!-- END NAV -->\n\n";
			
		$html .= "\t</div>\n";
		$html .= "\t<!-- END NAVIGATION DIV -->\n\n";
		
		return $html;
		
	}
	
	private function getNavBarCategoryListItems() {
		
		$categoryArray = ChannelCategory::getChannelCategoryArray($_SESSION['channelID']);
		$html = '';
		$h = 0;
		foreach ($categoryArray AS $key => $value) {
			if ($key != '' && $h < 14) {
				$html .= "\t\t\t\t\t\t\t\t<li";
					if ($h >= 5) { $html .= " class=\"hidden-xs\""; }
				$html .= "><a href=\"/k/$key/\">" . strtoupper($key) . "<span class=\"jagaBadge\">$value</span></a></li>\n";
			}
			$h++;
		}
		
		return $html;
		
	}
	
	private function getNavBarOwnChannelListItems() {

		$userOwnChannelArray = Channel::getUserOwnChannelArray($_SESSION['userID']);
		$html = '';
		$i = 0;
		foreach ($userOwnChannelArray AS $channelKey => $postCount) {
			if ($i < 7) {
				$html .= "\t\t\t\t\t\t\t\t<li";
					if ($i >= 3) { $html .= " class=\"hidden-xs\""; }
				$html .= "><a href=\"http://$channelKey.kutchannel.net/\">" . strtoupper($channelKey);
					$html .= " <span class=\"jagaBadge\">$postCount</span>";
				$html .= "</a></li>\n";
				$i++;
			}
		}
		return $html;

		
	}
	
	private function getNavBarSubscriptionListItems() {
		
		$userOwnChannelArray = Channel::getUserOwnChannelArray($_SESSION['userID']);
		$userSubscribedChannelArray = Channel::getUserSubscribedChannelArray($_SESSION['userID']);
		$html = '';
		$j = 0;
		foreach ($userSubscribedChannelArray AS $channelKey => $postCount) {
			if (!isset($userOwnChannelArray[$channelKey]) && $j < 7) {
				$html .= "\t\t\t\t\t\t\t\t<li";
					if ($j >= 3) { $html .= " class=\"hidden-xs\""; }
				$html .= "><a href=\"http://$channelKey.kutchannel.net/\">" . strtoupper($channelKey);
					$html .= " <span class=\"jagaBadge\">$postCount</span>";
				$html .= "</a></li>\n";
				$j++;
			}
		}
		return $html;
		
	}

	private function getNavBarExploreListItems() {
		
		$userOwnChannelArray = Channel::getUserOwnChannelArray($_SESSION['userID']);
		$userSubscribedChannelArray = Channel::getUserSubscribedChannelArray($_SESSION['userID']);
		$channelArray = Channel::getChannelArray();
		$html = '';
		$k = 0;
		foreach ($channelArray AS $channelKey => $totalPosts) {
			if (
				!isset($userOwnChannelArray[$channelKey])
				&& !isset($userSubscribedChannelArray[$channelKey])
				&& $channelKey != ''
				&& $channelKey != 'the'
			) {
				if ($k < 14) {
					$html .= "\t\t\t\t\t\t\t\t<li";
						if ($k >= 3) { $html .= " class=\"hidden-xs\""; }
					$html .= "><a href=\"http://$channelKey.kutchannel.net/\">";
						$html .= strtoupper($channelKey);
						$html .= "<span class=\"jagaBadge\">$totalPosts</span>";
					$html .= "</a></li>\n";
				}
				$k++;
			}
		}
		return $html;
		
	}

}

class ProfileView {

}

class PageView {

	public $pageTitle;
	public $pageKeywords;
	public $pageDescription;
	
	public function __construct() {
	
		$channelID = Session::getSession('channelID');
		$channel = new Channel($channelID);
		$this->pageTitle = $channel->channelTitleEnglish;
		$this->pageKeywords = $channel->channelKeywordsEnglish;
		$this->pageDescription = $channel->channelDescriptionEnglish;
	}
	
	public function buildPage($urlArray, $inputArray = array(), $errorArray = array()) {

		$html = $this->getHeader();
		
			$navBar = new MenuView();
			$html .= $navBar->getNavBar();
		
			if (!empty($errorArray)) {
				$html .= "\t<!-- START ERROR ARRAY -->\n";
				$html .= "\t<div class=\"container\">\n";
					foreach ($errorArray AS $value) {
						$html .= "\t\t<div class=\"alert alert-danger col-sm-12 jagaErrorArray\">$value</div>\n";
					}
				$html .= "\t</div>\n";
				$html .= "\t<!-- END ERROR ARRAY -->\n\n";
			}
		
			if ($urlArray[0] == '' && $_SESSION['channelID'] == 2006 && $_SESSION['userID'] == 0) {
				$carousel = new CarouselView();
				$html .= $carousel->getCarousel();
			}
			

			

			if ($urlArray[0] == '') {
			
				$categoryView = new CategoryView();
				$html .= $categoryView->displayChannelCategories($_SESSION['channelID']);
				
			} elseif ($urlArray[0] == 'register') {
			
				$html .= AuthenticationView::getAuthForm('register', $errorArray);
				
			} elseif ($urlArray[0] == 'login') {
			
				$html .= AuthenticationView::getAuthForm('login', $errorArray);
				
			} elseif ($urlArray[0] == 'about') {
			
				$html .= "about";
				
			} elseif ($urlArray[0] == 'tos') {
			
				$html .= "tos";
				
			} elseif ($urlArray[0] == 'privacy') {
			
				$html .= "privacy";
				
			} elseif ($urlArray[0] == 'sponsor') {
			
				$html .= "sponsor";
				
			} elseif ($urlArray[0] == 'sitemap') {
			
				$html .= "sitemap";
				
			} elseif ($urlArray[0] == 'contact') {
			
				$html .= "contact";
				
			} elseif ($urlArray[0] == 'k') {
			
				$html .= "K is for Kontent (user posts: /k/&lt;category&gt;/&lt;post&gt;/)";
				
			} elseif ($urlArray[0] == 'u') {
			
				$username = $urlArray[1];
				if (!User::usernameExists($username)) { die ('That username does not exist.'); }
				$html .= "I fight for the Users (user profiles: /u/" . $username . "/)";
				
			} elseif ($urlArray[0] == 'manage-channels') {
			
				if ($urlArray[1] == 'create') {
					$html .= ChannelView::getChannelForm('create', 0, $inputArray, $errorArray);
				} elseif ($urlArray[1] == 'update') {
					$channelID = Channel::getChannelID($urlArray[2]);
					$html .= ChannelView::getChannelForm('update', $channelID, $inputArray, $errorArray);
				} else {
					$html .= ChannelView::displayUserChannelList();
				}
				
			} elseif ($urlArray[0] == 'subscriptions') {
			

				
			} else {
				$html .= "\n\n\t<!-- START 404 TEXT -->\n";
					$html .= "\t\t<div class=\"container\">404: " . $urlArray[0] . "</div>\n";
				$html .= "\t<!-- END 404 TEXT -->\n\n";
			}
		
			
			
			
			
			if ($_SESSION['userID'] == 2) {
			
				$html .= "\t<div class=\"container\">\n";

					$html .= "\t\t<div class=\"row\">\n";
					
						$html .= "\t\t\t<div class=\"col-md-3 bg-warning\">";
							$html .= '<h3>Session::sessionArray</h3>';
							$html .= '<pre>' . print_r(Session::sessionDump(), true) . '</pre>';
						$html .= "</div>\n";
						
						$html .= "\t\t\t<div class=\"col-md-3 bg-warning\">";
							$html .= '<h3>$_COOKIE</h3>';
							$html .= '<pre>' . print_r($_COOKIE, true) . '</pre>';
						$html .= "</div>\n";
						
						$html .= "\t\t\t<div class=\"col-md-3 bg-warning\">";
							$html .= '<h3>$_POST</h3>';
							$html .= '<pre>' . print_r($_POST, true) . '</pre>';
						$html .= "</div>\n";
						
						$html .= "\t\t\t<div class=\"col-md-3 bg-warning\">";
							$html .= '<h3>$urlArray</h3>';
							$html .= '<pre>' . print_r($urlArray, true) . '</pre>';
						$html .= "</div>\n";
						
					$html .= "\t\t</div>\n";
					
					$html .= "\t\t<div class=\"row\">\n";
					
						if (isset($_SESSION)) { 
							$html .= "\t\t\t\t<div class=\"col-md-12 bg-warning\">";
								$html .= '<h3>$_SESSION</h3>';
								$html .= '<pre>' . print_r($_SESSION, true) . '</pre>';
							$html .= "</div>\n";
						}

					$html .= "\t\t</div>\n";					
					
				$html .= "\t</div>\n";
			
			}
		
		$html .= $this->getFooter();
		
		return $html;
		
	}
	
	private function getHeader() {

		$html = "<!DOCTYPE html>\n";
		$html .= "<html lang=\"en\">\n\n";
		
			$html .= "\t<head>\n\n";
			
				$html .= "\t\t<title>" . $this->pageTitle . "</title>\n\n";
				
				$html .= "\t\t<meta charset=\"utf-8\">\n";
				$html .= "\t\t<meta name=\"robots\" content=\"NOINDEX, NOFOLLOW\">\n\n";
				
				$html .= "\t\t<meta name=\"keywords\" content=\"" . $this->pageKeywords . "\">\n";
				$html .= "\t\t<meta name=\"description\" content=\"" . $this->pageDescription . "\">\n\n";
				
				$html .= "\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">\n";
				$html .= "\t\t<meta name=\"apple-mobile-web-app-capable\" content=\"yes\">\n";
				$html .= "\t\t<meta name=\"apple-mobile-web-app-status-bar-style\" content=\"black-translucent\">\n\n";

				$html .= "\t\t<meta name=\"author\" content=\"Chishiki\">\n";
				$html .= "\t\t<meta name=\"generator\" content=\"The Kutchannel\">\n\n";
				
				$html .= "\t\t<link rel=\"icon\" type=\"image/x-icon\" href=\"/jaga/images/favicon.ico\"/>\n\n";

				$html .= "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"/jaga/bootstrap/3.1.1/css/bootstrap.min.css\">\n";
				$html .= "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"/jaga/css/kutchannel.css\" />\n";
				$html .= "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"/channel.css\" />\n\n";

				// $html .= "\t\t<script type=\"text/javascript\">";
					// $html .= "
					// $(document).ready(function () {
						// if ($(\"[rel=tooltip]\").length) {
						// $(\"[rel=tooltip]\").tooltip();
						// }
					// });
					// \n";
				// $html .= "\t\t</script>\n\n";

			$html .= "\t</head>\n\n";

			$html .= "\t<body>\n\n";
			
		return $html;
		
	}
	
	private function getFooter() {

				$html = "\n\n";
				$html .= "\t\t<div id=\"footer\">\n";
					$html .= "\t\t\t<div class=\"container\">\n";
					
					
					
						$html .= "\t\t\t\t<p class=\"text-muted\">";
							$html .= "<a href=\"http://the.kutchannel.net/about/\">About</a> | ";
							$html .= "<a href=\"http://the.kutchannel.net/tos/\">Terms of Service</a> | ";
							$html .= "<a href=\"http://the.kutchannel.net/privacy/\">Privacy Policy</a> | ";
							$html .= "<a href=\"http://the.kutchannel.net/advertise/\">Advertise</a> | ";
							$html .= "<a href=\"http://the.kutchannel.net/sitemap/\">Sitemap</a> | ";
							$html .= "<a href=\"http://the.kutchannel.net/contact/\">Contact</a> | ";
							$html .= "&copy; The Kutchannel 2006-" . date('Y');
						$html .= "</p>\n";
						
					$html .= "\t\t\t</div>\n";
				$html .= "\t\t</div>\n\n";
				
				$html .= "\t\t<script type=\"text/javascript\" src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js\"></script>\n";
				$html .= "\t\t<script type=\"text/javascript\" src=\"/jaga/bootstrap/3.1.1/js/bootstrap.min.js\"></script>\n";
				
				$html .= "
				<script>
				jQuery(document).ready(function($) {
					  $(\".jagaClickableRow\").click(function() {
							window.document.location = $(this).data('url');
					  });
				});
				</script>
				";
			
				// $html .= "\t\t<script type=\"text/javascript\" src=\"/jaga/js/tooltip.js\"></script>\n\n";
				
				// $html .= "\t\t<script type=\"text/javascript\">\n";
					// $html .= "\t\t\t$(function () {\n";
						// $html .= "\t\t\t\t$(\"[rel='tooltip']\").tooltip();\n";
					// $html .= "\t\t\t});\n";
				// $html .= "\t\t</script>\n\n";
				
			$html .= "\t</body>\n\n";
		$html .= "</html>";
		
		return $html;
		
	}

}

class SubscriptionView {

}

class ThemeView {

	public $themeKey;
	public $navbarBackgroundColor;
	public $navbarBackgroundColorActive;
	public $navbarBorderColor;
	public $navbarTextColor;
	public $navbarTextColorHover;
	public $navbarTextColorActive;
	public $contentPanelHeadingTextColor;
	public $contentPanelHeadingBackgroundColor;
	
	public function __construct() {
	

		$themeKey = Channel::getThemeKey($_SESSION['channelID']);

		$core = Core::getInstance();
		$query = "
			SELECT 
				navbarBackgroundColor, 
				navbarBackgroundColorActive, 
				navbarBorderColor, 
				navbarTextColor, 
				navbarTextColorHover, 
				navbarTextColorActive, 
				contentPanelHeadingTextColor, 
				contentPanelHeadingBackgroundColor
			FROM jaga_theme
			WHERE themeKey = :themeKey
			LIMIT 1
		";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':themeKey' => $themeKey));
		$row = $statement->fetch();

		$this->themeKey = $themeKey;
		$this->navbarBackgroundColor = $row['navbarBackgroundColor'];
		$this->navbarBackgroundColorActive = $row['navbarBackgroundColorActive'];
		$this->navbarBorderColor = $row['navbarBorderColor'];
		$this->navbarTextColor = $row['navbarTextColor'];
		$this->navbarTextColorHover = $row['navbarTextColorHover'];
		$this->navbarTextColorActive = $row['navbarTextColorActive'];
		$this->contentPanelHeadingTextColor = $row['contentPanelHeadingTextColor'];
		$this->contentPanelHeadingBackgroundColor = $row['contentPanelHeadingBackgroundColor'];
		
	}
	
	public function getTheme() {
	
		$themeKey = $this->themeKey;
		
		$navbarBackgroundColor = $this->navbarBackgroundColor;
		$navbarBackgroundColorActive = $this->navbarBackgroundColorActive;
		$navbarBorderColor = $this->navbarBorderColor;
		$navbarTextColor = $this->navbarTextColor;
		$navbarTextColorHover = $this->navbarTextColorHover;
		$navbarTextColorActive = $this->navbarTextColorActive; // #$navbarTextColorActive : active color
		
		$contentPanelHeadingTextColor = $this->contentPanelHeadingTextColor;
		$contentPanelHeadingBackgroundColor = $this->contentPanelHeadingBackgroundColor;
		
		$css = "/* WELCOME TO THE KUTCHANNEL */\n/* The " . strtoupper(Channel::getChannelKey($_SESSION['channelID'])) . " channel is using the " . strtoupper($themeKey) . " theme. */\n\n";
		
		$css .= "#footer {
			background-color:#$navbarBackgroundColor;
			a { color:#$navbarTextColor !important; }
		}\n\n";
		
		$css .= "div.jagaContentPanelHeading {
			color:#$contentPanelHeadingTextColor !important;
			background-color:#$contentPanelHeadingBackgroundColor !important;
		}\n\n";

		// $css .= "a.jagaListGroupItemMore {
			// color:#$contentPanelHeadingTextColor;
			// background-color:#$contentPanelHeadingBackgroundColor;
		// }\n\n";		
		

		$css .= ".jagaFormButton {
			color:#$navbarTextColor;
			background-color:#$navbarBackgroundColor;
		}\n\n";
		
		$css .= "
		
			.navbar-default {
				background-color: #$navbarBackgroundColor;
				border-color: #$navbarBorderColor;
			}
			/* title */
			.navbar-default .navbar-brand {
				color: #$navbarTextColor;
			}
			.navbar-default .navbar-brand:hover,
			.navbar-default .navbar-brand:focus {
				color: #5E5E5E;
			}
			/* link */
			.navbar-default .navbar-nav > li > a {
				color: #$navbarTextColor;
			}
			.navbar-default .navbar-nav > li > a:hover,
			.navbar-default .navbar-nav > li > a:focus {
				color: #$navbarTextColorHover;
			}
			.navbar-default .navbar-nav > .active > a, 
			.navbar-default .navbar-nav > .active > a:hover, 
			.navbar-default .navbar-nav > .active > a:focus {
				color: #$navbarTextColorActive;
				background-color: #$navbarBorderColor;
			}
			.navbar-default .navbar-nav > .open > a, 
			.navbar-default .navbar-nav > .open > a:hover, 
			.navbar-default .navbar-nav > .open > a:focus {
				color: #$navbarTextColorActive;
				background-color: #$navbarBackgroundColorActive;
			}
			/* caret */
			.navbar-default .navbar-nav > .dropdown > a .caret {
				border-top-color: #$navbarTextColor;
				border-bottom-color: #$navbarTextColor;
			}
			.navbar-default .navbar-nav > .dropdown > a:hover .caret,
			.navbar-default .navbar-nav > .dropdown > a:focus .caret {
				border-top-color: #$navbarTextColorHover;
				border-bottom-color: #$navbarTextColorHover;
			}
			.navbar-default .navbar-nav > .open > a .caret, 
			.navbar-default .navbar-nav > .open > a:hover .caret, 
			.navbar-default .navbar-nav > .open > a:focus .caret {
				border-top-color: #$navbarTextColorActive;
				border-bottom-color: #$navbarTextColorActive;
			}
			/* mobile version */
			.navbar-default .navbar-toggle {
				border-color: #DDD;
			}
			.navbar-default .navbar-toggle:hover,
			.navbar-default .navbar-toggle:focus {
				background-color: #DDD;
			}
			.navbar-default .navbar-toggle .icon-bar {
				background-color: #CCC;
			}
			@media (max-width: 767px) {
				.navbar-default .navbar-nav .open .dropdown-menu > li > a {
					color: #$navbarTextColor;
				}
				.navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
				.navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
					color: #$navbarTextColorHover;
				}
			}
			
		";
		
		return $css;
	
	}

	/* BEGIN STATIC */
	
	public static function getThemeDropdown($thisThemeKey) {
		
		$core = Core::getInstance();
		$query = "SELECT themeKey FROM jaga_theme ORDER BY themeKey";
		$statement = $core->database->prepare($query);
		$statement->execute();
		
		$html = "<select name=\"themeKey\" class=\"form-control\">\n";
			while ($row = $statement->fetch()) {
				$themeKey = $row['themeKey'];
				$html .= "<option value=\"$themeKey\"";
					if ($themeKey == $thisThemeKey) { $html .= " selected"; }
				$html .= ">$themeKey</option>\n";
			}
		$html .= "</select>\n";

		return $html;

	}
}

?>