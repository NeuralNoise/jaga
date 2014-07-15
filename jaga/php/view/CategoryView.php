<?php

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
						$html .= "<div class=\"panel-heading jagaContentPanelHeading\">
							<a href=\"/k/create/" . $contentCategoryKey . "/\"><span style=\"float:right;\" class=\"glyphicon glyphicon-plus\"></span></a>
							<h4>" . strtoupper($contentCategoryKey) . "</h4>
							
							
						</div>\n";
							$html .= "<ul class=\"list-group\">\n";
								$contentArray = Category::getCategoryContent($channelID, $contentCategoryKey);
								// print_r($contentArray);
								$i = 0;
								foreach ($contentArray AS $contentID) {
									if ($i < 5) {
										$content = new Content($contentID);
										$thisContentChannelID = $content->channelID;
										$thisContentChannelKey = Channel::getChannelKey($thisContentChannelID);
										$contentURL = $content->contentURL;
										$contentTitle = $content->contentTitleEnglish;
										$contentSubmittedByUserID = $content->contentSubmittedByUserID;
										$contentSubmissionDateTime = $content->contentSubmissionDateTime;
										$contentViews = $content->contentViews;
										$user = new User($contentSubmittedByUserID);
										$username = $user->username;
										$html .= "<a href=\"http://" . $thisContentChannelKey . ".kutchannel.net/k/" . $contentCategoryKey . "/" . $contentURL . "/\" class=\"list-group-item jagaListGroupItem\">";
											$html .= "<span class=\"jagaListGroup\">";
												$html .= "<span class=\"jagaListGroupBadge\">" . $contentViews . "</span>";
												if ($_SESSION['channelID'] == 2006) { $html .=  '<strong><small>' . strtoupper($thisContentChannelKey) . '</small></strong><br />'; }
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
	
	public function displayChannelCategoryList($channelID) {
		
		$categoryArray = ChannelCategory::getChannelCategoryArray($channelID);

		$html = "\n\n\t<!-- START CATEGORY LIST -->\n";
		$html .= "\t<div class=\"container\">\n";
			
			$html .= "\t\t<!-- START PANEL -->\n";
			$html .= "\t\t<div class=\"panel panel-default\">\n\n";
				$html .= "\t\t\t<div class=\"panel-heading jagaContentPanelHeading\"><h4>THIS CHANNEL'S CATEGORIES</h4></div>\n";
				$html .= "\t\t\t<div class=\"table-responsive\">\n";
					$html .= "\t\t\t\t<table class=\"table table-hover\">\n";
						$html .= "<thead>\n";
							$html .= "<tr>";
								$html .= "<th>contentCategoryKey</th>\n";
								$html .= "<th>postCount</th>\n";
							$html .= "</tr>";
						$html .= "</thead>\n";
						$html .= "<tbody>\n";
						
							foreach ($categoryArray AS $contentCategoryKey => $postCount) {
								$html .= "\t\t\t\t<tr class=\"jagaClickableRow\" data-url=\"/k/" . $contentCategoryKey . "/\">\n";
									$html .= "\t\t\t\t\t<td>" . $contentCategoryKey . "</td>\n";
									$html .= "\t\t\t\t\t<td>" . $postCount . "</td>\n";
								$html .= "\t\t\t\t</tr>\n";
							}
							
						$html .= "</tbody>\n";
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
				$html .= "\t\t<option value=\"" . $contentCategoryKey . "\"";
					if ($contentCategoryKey == $selectedContentCategoryKey) { $html .= " selected"; }
				$html .= ">" . strtoupper($contentCategoryKey) . "</option>\n";
			}
		$html .= "\t</select>\n\n";

		return $html;
	
	}
	
}

?>