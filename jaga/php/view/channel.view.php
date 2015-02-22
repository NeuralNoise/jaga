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
		
			$html .= "\t\t<div class=\"row\">\n\n";

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
						$html .= "\t\t\t\t\t<form role=\"form\" id=\"jagaChannelForm\" name=\"jagaChannelForm\" class=\"form-horizontal\"  method=\"post\" action=\"/settings/channels/" . $type . "/";
							if ($type == 'update') { $html .= $channelKey . "/"; }
						$html .= "\">\n\n";
					
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<label for=\"channelKey\" class=\"col-sm-4 control-label\">Channel</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-8\">\n";
								
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
								$html .= "\t\t\t\t\t\t\t<label for=\"channelTitleEnglish\" class=\"col-sm-4 control-label\">Title (English)</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-8\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"channelTitleEnglish\" name=\"channelTitleEnglish\" class=\"form-control\" placeholder=\"channelTitleEnglish\" value=\"" . $channelTitleEnglish . "\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<label for=\"channelKeywordsEnglish\" class=\"col-sm-4 control-label\">Keywords (English)</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-8\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"channelKeywordsEnglish\" name=\"channelKeywordsEnglish\" class=\"form-control\" placeholder=\"channelKeywordsEnglish\" value=\"" . $channelKeywordsEnglish . "\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<label for=\"channelDescriptionEnglish\" class=\"col-sm-4 control-label\">Description (English)</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-8\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"channelDescriptionEnglish\" name=\"channelDescriptionEnglish\" class=\"form-control\" placeholder=\"channelDescriptionEnglish\" value=\"" . $channelDescriptionEnglish . "\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";

							$html .= "<hr />";
							
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<label for=\"channelTitleJapanese\" class=\"col-sm-4 control-label\">Title (Japanese)</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-8\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"channelTitleJapanese\" name=\"channelTitleJapanese\" class=\"form-control\" placeholder=\"channelTitleJapanese\" value=\"" . $channelTitleJapanese . "\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<label for=\"channelKeywordsJapanese\" class=\"col-sm-4 control-label\">Keywords (Japanese)</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-8\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"channelKeywordsJapanese\" name=\"channelKeywordsJapanese\" class=\"form-control\" placeholder=\"channelKeywordsJapanese\" value=\"" . $channelKeywordsJapanese . "\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<label for=\"channelDescriptionJapanese\" class=\"col-sm-4 control-label\">Description (Japanese)</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-8\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"channelDescriptionJapanese\" name=\"channelDescriptionJapanese\" class=\"form-control\" placeholder=\"channelDescriptionJapanese\" value=\"" . $channelDescriptionJapanese . "\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "<hr />";
							
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<label for=\"themeKey\" class=\"col-sm-4 control-label\">Theme</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-4\">\n";
									$html .= ThemeView::getThemeDropdown($themeKey);
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "<hr />";
							
							
							
							
							
							$categoryArray = Category::getAllCategories();	
							$categoryCount = count($categoryArray);
							$checkboxColumnCount = ceil($categoryCount/2);
							
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<label for=\"contentCategoryKey[]\" class=\"col-sm-4 control-label\">Categories</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-8\">\n";

									$html .= "<div class=\"row\">";
										$html .= "<div class=\"col-sm-6\">";
											$i = 0;
											foreach ($categoryArray AS $contentCategoryKey => $postCount) {
												$html .= "<div class=\"checkbox\">";
													$html .= "<input type=\"checkbox\" id=\"contentCategoryKey\" name=\"contentCategoryKey[]\" value=\"" . $contentCategoryKey . "\"";
														if (in_array($contentCategoryKey, $contentCategoryKeyArray)) {
															// if ($postCount > 0) { $html .= " onchange=\"this.checked=true\""; }
															$html .= " checked";
														}
													$html .= "> " . $contentCategoryKey;
													// if ($postCount > 0) { $html .= " (" . $postCount . ")"; }
												$html .= "</div>\n";
												if ($i == $checkboxColumnCount - 1) { $html .= "</div><div class=\"col-sm-6\">"; }
												$i++;
											}
										$html .= "</div>";
									$html .= "</div>";

								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";

							$html .= "<hr />";
							
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
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
			$html .= "\t\t<!-- END ROW -->\n\n";
			
		$html .= "\t</div>\n";
		$html .= "\t<!-- END CHANNEL CONTAINER -->\n\n";
			
		return $html;
	
	}

	public static function displayUserChannelList() {
	
		$channelArray = Channel::getUserOwnChannelArray($_SESSION['userID']);

		$html = '';
		
		$html .= "\t<!-- START CHANNEL LIST -->\n";
		$html .= "\t<div class=\"container\">\n\n";
		
			$html .= "\t<div class=\"row\">\n\n";
		
			$html .= "<div class=\"panel panel-default\">\n";
				
				$html .= "<div class=\"panel-heading jagaContentPanelHeading\"><h4>YOUR CHANNELS</h4></div>\n";
				
				$html .= "<div class=\"table-responsive\">\n";
					$html .= "<table class=\"table table-hover\">\n";
						$html .= "<thead>\n";
							$html .= "<tr>";
								$html .= "<th>Key</th>\n";
								$html .= "<th>Title</th>\n";
								$html .= "<th>Theme</th>\n";
								$html .= "<th>Total Posts</th>\n";
								$html .= "<th>Pages Served</th>\n";
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
								
								$html .= "<tr class=\"jagaClickableRow\" data-url=\"/settings/channels/update/" . $channelKey . "/\">";
								
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

			$html .= "\t\t</div>\n\n";
			
		$html .= "\t</div>\n";
		$html .= "\t<!-- END CHANNEL LIST -->\n\n";
		
		return $html;	

	}
	
	public static function displayChannelList() {
	
		$channelArray = Channel::getChannelArray();
	
		$html = '';
		
		$html .= "\t<!-- START CHANNEL LIST -->\n";
		$html .= "\t<div class=\"container\">\n\n";
		
			$html .= "\t<div class=\"row\">\n\n";
		
			$html .= "<div class=\"panel panel-default\">\n";
				
				$html .= "<div class=\"panel-heading jagaContentPanelHeading\"><h4>ALL CHANNELS</h4></div>\n";

				$html .= "<div class=\"table-responsive\">\n";
					$html .= "<table class=\"table table-striped table-hover table-condensed\">\n";
						$html .= "<tr>";
							$html .= "<th>Channel</th>\n";
							$html .= "<th>Title</th>\n";
							$html .= "<th>Manager</th>\n";
							$html .= "<th class=\"text-right\">Total Posts</th>\n";
							$html .= "<th class=\"text-right\">Pages Served</th>\n";
						$html .= "</tr>";
						foreach ($channelArray AS $channelKey => $totalPosts) {
							$channelID = Channel::getChannelID($channelKey);
							$channel = new Channel($channelID);
							$channelTitleEnglish = $channel->channelTitleEnglish;
							$siteManagerUserName = User::getUserName($channel->siteManagerUserID);
							$pagesServed = $channel->pagesServed;
							$html .= "<tr class=\"jagaClickableRow\" data-url=\"http://" . $channelKey . ".kutchannel.net/\">";
								$html .= "<td>" . strtoupper($channelKey) . "</td>\n";
								$html .= "<td>" . $channelTitleEnglish . "</td>\n";
								$html .= "<td>" . $siteManagerUserName . "</td>\n";
								$html .= "<td class=\"text-right\">" . $totalPosts . "</td>\n";
								$html .= "<td class=\"text-right\">" . $pagesServed . "</td>\n";
							$html .= "</tr>";
						}
					$html .= "</table>\n";
				$html .= "</div>\n";
				
			$html .= "</div>\n";

			$html .= "\t\t</div>\n\n";
			
		$html .= "\t</div>\n";
		$html .= "\t<!-- END CHANNEL LIST -->\n\n";
		
		return $html;	

	}
	
}

?>