<?php

class CategoryView {
	
	public function displayChannelCategories($channelID) {
	
		$categoryArray = ChannelCategory::getChannelCategoryArray($channelID);

		$html = "\n\n";
		$html .= "\t\t<div class=\"container\"> <!-- START CONTAINER -->\n";
			$html .= "\t\t\t<div class=\"row\" id=\"list\"> <!-- START ROW -->\n";
				foreach ($categoryArray AS $contentCategoryKey => $postCount) {
				
					$category = new Category($contentCategoryKey);
					if ($_SESSION['lang'] == 'ja') { $categoryName = $category->contentCategoryJapanese; } else { $categoryName = $category->contentCategoryEnglish; }
				
					$contentArray = Category::getCategoryContent($channelID, $contentCategoryKey);

					$html .= "\t\t\t\t<div class=\"item col-xs-12 col-sm-6 col-md-4 col-lg-3\">\n";
						$html .= "\t\t\t\t\t<div class=\"panel panel-default\">\n";
							$html .= "\t\t\t\t\t\t<div class=\"panel-heading jagaContentPanelHeading\">\n";
								if ($_SESSION['channelID'] != 2006) {
									$html .= "\t\t\t\t\t\t\t<a href=\"/k/create/" . $contentCategoryKey . "/\">";
										$html .= "<span style=\"float:right;\" class=\"glyphicon glyphicon-plus\"></span>";
									$html .= "</a>\n";
								}
								$html .= "\t\t\t\t\t\t\t<h4>" . strtoupper($categoryName) . "</h4>\n";
							$html .= "\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t<ul class=\"list-group\">\n";
							
								$i = 0;
								foreach ($contentArray AS $contentID) {
									if ($i < 5) {
									
										$content = new Content($contentID);
										$contentURL = $content->contentURL;
										$contentSubmittedByUserID = $content->contentSubmittedByUserID;
										$contentSubmissionDateTime = $content->contentSubmissionDateTime;
										
										$thisChannelID = $content->channelID;
										$channel = new Channel($thisChannelID);
										$thisContentChannelKey = $channel->channelKey;
										
										if ($_SESSION['lang'] == 'ja') {
											$contentTitle = $content->contentTitleJapanese;
											$channelTitle = $channel->channelTitleJapanese;
										} else {
											$contentTitle = $content->contentTitleEnglish;
											$channelTitle = $channel->channelTitleEnglish;
										}
										
										$contentViews = $content->contentViews;
										$user = new User($contentSubmittedByUserID);
										$username = $user->username;
										
										$html .= "\t\t\t\t\t\t\t<a href=\"http://" . $thisContentChannelKey . ".jaga.io/k/" . $contentCategoryKey . "/" . $contentURL . "/\" class=\"list-group-item jagaListGroupItem\">";
											
											
											
											
											$html .= "<span class=\"jagaListGroup\">";
												
												$html .= "<span class=\"jagaListGroupBadge\">" . $contentViews . "</span>";
												
												if ($_SESSION['channelID'] == 2006) { $html .=  '<strong><small>' . strtoupper($channelTitle) . '</small></strong><br />'; }
												
												if (Image::objectHasImage('Content',$contentID)) {
													$imagePath = Image::getLegacyObjectMainImagePath('Content',$contentID);
													if ($imagePath == "") { $imagePath = Image::getObjectMainImagePath('Content',$contentID); }
													if ($imagePath != "") { $html .= "<br /><img class=\"img-responsive\" src=\"" . $imagePath . "\"><br />"; }
												}
												
												$html .=  $contentTitle;
												
												
											$html .= "</span>";
											
											
											
											
										$html .= "</a>\n";
									}
									$i++;
								}
								
								if ($_SESSION['channelID'] != 2006) {
									$html .= "\t\t\t\t\t\t\t<a href=\"/k/" . $contentCategoryKey . "/\" class=\"list-group-item jagaListGroupItemMore\">";
										$html .= Lang::getLang('more') . " <span class=\"glyphicon glyphicon-arrow-right\"></span>";
									$html .= "</a>\n";
								}
								
							$html .= "\t\t\t\t\t\t</ul>\n";
						$html .= "\t\t\t\t\t</div>\n";
					$html .= "\t\t\t\t</div>\n";
				}
			$html .= "\t\t\t</div> <!-- END ROW -->\n";
		$html .= "\t\t</div> <!-- END CONTAINER -->\n\n";
		return $html;	
	}
	
	public function displayChannelCategoryList($channelID) {
		
		$categoryArray = ChannelCategory::getChannelCategoryArray($channelID);

		$html = "\n\n\t<!-- START CATEGORY LIST -->\n";
		$html .= "\t<div class=\"container\">\n";
			
			$html .= "\t\t<!-- START PANEL -->\n";
			$html .= "\t\t<div class=\"panel panel-default\">\n\n";
				$html .= "\t\t\t<div class=\"panel-heading jagaContentPanelHeading\"><h4>" . strtoupper(Lang::getLang('thisChannelsCategories')) . "</h4></div>\n";
				$html .= "\t\t\t<div class=\"table-responsive\">\n";
					$html .= "\t\t\t\t<table class=\"table table-hover\">\n";
						$html .= "<tr>";
							$html .= "<th>" . Lang::getLang('contentCategoryKey') . "</th>\n";
							$html .= "<th>" . Lang::getLang('postCount') . "</th>\n";
						$html .= "</tr>";
						foreach ($categoryArray AS $contentCategoryKey => $postCount) {
							$html .= "\t\t\t\t<tr class=\"jagaClickableRow\" data-url=\"/k/" . $contentCategoryKey . "/\">\n";
								$html .= "\t\t\t\t\t<td>" . $contentCategoryKey . "</td>\n";
								$html .= "\t\t\t\t\t<td>" . $postCount . "</td>\n";
							$html .= "\t\t\t\t</tr>\n";
						}
					$html .= "\t\t\t\t</table>\n";
				$html .= "\t\t</div>\n\n";
			$html .= "\t\t</div>\n";
			$html .= "\t\t<!-- END PANEL -->\n\n";
		$html .= "\t</div>\n";
		$html .= "\t<!-- END CATEGROY LIST -->\n\n";

		return $html;
		
	}
	
	public function categoryDropdown($selectedContentCategoryKey) {
	
		$categoryArray = array_keys(ChannelCategory::getChannelCategoryArray($_SESSION['channelID']));
		
		$html = "\n\t<select id=\"contentCategoryKey\" name=\"contentCategoryKey\" class=\"form-control\">\n";
			foreach ($categoryArray AS $contentCategoryKey) {
				
				$category = new Category($contentCategoryKey);
				if ($_SESSION['lang'] == 'ja') {
					$contentCategory = $category->contentCategoryJapanese;
				} else {
					$contentCategory = $category->contentCategoryEnglish;
				}
				$html .= "\t\t<option value=\"" . $contentCategoryKey . "\"";
					if ($contentCategoryKey == $selectedContentCategoryKey) { $html .= " selected"; }
				$html .= ">" . strtoupper($contentCategory) . "</option>\n";
				
			}
		$html .= "\t</select>\n\n";

		return $html;
	
	}
	
}

?>