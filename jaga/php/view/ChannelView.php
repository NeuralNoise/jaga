<?php
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

?>