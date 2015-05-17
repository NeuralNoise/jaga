<?php

class ChannelView {

	public static function getChannelForm($type, $channelID = 0, $inputArray = array(), $errorArray = array(), $initialKey = '') {
	
		if (!Authentication::isLoggedIn()) { die("getChannelForm::notLoggedIn"); };
	
		if (empty($inputArray)) {
		
			if ($type == 'create') {
			
				$channelKey = '';
				if ($initialKey != '') { $channelKey = $initialKey; }
				$channelTitleEnglish = '';
				$channelTitleJapanese = '';
				$channelTagLineEnglish = '';
				$channelTagLineJapanese = '';
				$channelKeywordsEnglish = '';
				$channelKeywordsJapanese = '';
				$channelDescriptionEnglish = '';
				$channelDescriptionJapanese = '';
				$themeKey = 'kutchannel';
				$siteTwitter = '';
				$pagesServed = 0;
				$siteManagerUserID = $_SESSION['userID'];
				$isPublic = 1;
				$isCloaked = 0;
				$isNSFW = 0;
				$contentCategoryKeyArray = array();
			
			} elseif ($type == 'update') {

				$channel = new Channel($channelID);
				$channelKey = $channel->channelKey;
				$channelTitleEnglish = $channel->channelTitleEnglish;
				$channelTitleJapanese = $channel->channelTitleJapanese;
				$channelTagLineEnglish = $channel->channelTagLineEnglish;
				$channelTagLineJapanese = $channel->channelTagLineJapanese;
				$channelKeywordsEnglish = $channel->channelKeywordsEnglish;
				$channelKeywordsJapanese = $channel->channelKeywordsJapanese;
				$channelDescriptionEnglish = $channel->channelDescriptionEnglish;
				$channelDescriptionJapanese = $channel->channelDescriptionJapanese;
				$themeKey = $channel->themeKey;
				$siteTwitter = $channel->siteTwitter;
				$pagesServed = $channel->pagesServed;
				$siteManagerUserID = $channel->siteManagerUserID;
				$isPublic = $channel->isPublic;
				$isCloaked = $channel->isCloaked;
				$isNSFW = $channel->isNSFW;
				$contentCategoryKeyArray = array_keys(ChannelCategory::getChannelCategoryArray($channelID));

			}
			
		} else {
		
			$channelKey = $inputArray['channelKey'];
			$channelTitleEnglish = $inputArray['channelTitleEnglish'];
			$channelTitleJapanese = $inputArray['channelTitleJapanese'];
			$channelTagLineEnglish = $inputArray['channelTagLineEnglish'];
			$channelTagLineJapanese = $inputArray['channelTagLineJapanese'];
			$channelKeywordsEnglish = $inputArray['channelKeywordsEnglish'];
			$channelKeywordsJapanese = $inputArray['channelKeywordsJapanese'];
			$channelDescriptionEnglish = $inputArray['channelDescriptionEnglish'];
			$channelDescriptionJapanese = $inputArray['channelDescriptionJapanese'];
			$themeKey = $inputArray['themeKey'];
			if (isset($inputArray['siteTwitter'])) { $siteTwitter = $inputArray['siteTwitter']; } else { $siteTwitter = 0; }
			// $pagesServed = $inputArray['pagesServed'];
			// $siteManagerUserID = $inputArray['siteManagerUserID'];
			
			if (isset($inputArray['isPublic'])) { $isPublic = $inputArray['isPublic']; } else { $isPublic = 0; }
			if (isset($inputArray['isCloaked'])) { $isCloaked = $inputArray['isCloaked']; } else { $isCloaked = 0; }
			if (isset($inputArray['isNSFW'])) { $isNSFW = $inputArray['isNSFW']; } else { $isNSFW = 0; }
			$contentCategoryKeyArray = array();
			
			if (isset($inputArray['contentCategoryKey'])) { $contentCategoryKeyArray = $inputArray['contentCategoryKey']; }

		}

		$html = "
		
		<!-- START CHANNEL CONTAINER -->
		<div class=\"container\">
		
			<!-- START CHANNEL ROW -->
			<div class=\"row\">
			
				<!-- START CHANNEL DIV -->
				<div class=\"col-md-12\">
				
					<!-- START PANEL -->
					<div class=\"panel panel-default\" >
					
						<!-- START PANEL-HEADING -->
						<div class=\"panel-heading jagaContentPanelHeading\">
							<div class=\"panel-title\">CHANNEL " . strtoupper($type) . "</div>
						</div>
						<!-- END PANEL-HEADING -->
					
						<!-- START PANEL-BODY -->
						<div class=\"panel-body\">
						
							<!-- START jagaChannelForm -->
							<form role=\"form\" id=\"jagaChannelForm\" name=\"jagaChannelForm\" class=\"form\"  method=\"post\" action=\"/settings/channels/" . $type . "/" . ($type == 'update' ? $channelKey . "/" : "") . "\">

									<div class=\"form-group\">
										<label for=\"channelKey\" class=\"control-label\">" . Lang::getLang('channel') . "</label>
										" . (
											$type == 'create' ? "<input type=\"text\" id=\"channelKey\" name=\"channelKey\" class=\"form-control\" placeholder=\"channelKey\" value=\"" . strtoupper($channelKey) . "\">" : (
											$type == 'update' ? "<p class=\"form-control-static\">" . $channelKey . "</p><input type=\"hidden\" name=\"channelKey\" value=\"" . $channelKey . "\">" : ""
											)
										) . "
									</div>

								<hr />

									<div class=\"row\">
										<div class=\"form-group col-sm-4\">
											<label for=\"channelTitleEnglish\" class=\"control-label\">" . Lang::getLang('titleEnglish') . "</label>
											<input type=\"text\" id=\"channelTitleEnglish\" name=\"channelTitleEnglish\" class=\"form-control\" placeholder=\"channelTitleEnglish\" value=\"" . $channelTitleEnglish . "\">
										</div>
										<div class=\"form-group col-sm-4\">
											<label for=\"channelTagLineEnglish\" class=\"control-label\">" . Lang::getLang('tagLineEnglish') . "</label>
											<input type=\"text\" id=\"channelTagLineEnglish\" name=\"channelTagLineEnglish\" class=\"form-control\" placeholder=\"channelTagLineEnglish\" value=\"" . $channelTagLineEnglish . "\">
										</div>
										<div class=\"form-group col-sm-4\">
											<label for=\"channelKeywordsEnglish\" class=\"control-label\">" . Lang::getLang('keywordsEnglish') . "</label>
											<input type=\"text\" id=\"channelKeywordsEnglish\" name=\"channelKeywordsEnglish\" class=\"form-control\" placeholder=\"channelKeywordsEnglish\" value=\"" . $channelKeywordsEnglish . "\">
										</div>
									</div>
									
									<div class=\"row\">
										<div class=\"form-group col-sm-12\">
											<label for=\"channelDescriptionEnglish\" class=\"control-label col-xs-12\">" . Lang::getLang('descriptionEnglish') . "</label>
											<input type=\"text\" id=\"channelDescriptionEnglish\" name=\"channelDescriptionEnglish\" class=\"form-control col-xs-12\" placeholder=\"channelDescriptionEnglish\" value=\"" . $channelDescriptionEnglish . "\">
										</div>
									</div>

								<hr />

									<div class=\"row\">
										<div class=\"form-group col-sm-4\">
											<label for=\"channelTitleJapanese\" class=\"control-label\">" . Lang::getLang('titleJapanese') . "</label>
											<input type=\"text\" id=\"channelTitleJapanese\" name=\"channelTitleJapanese\" class=\"form-control\" placeholder=\"channelTitleJapanese\" value=\"" . $channelTitleJapanese . "\">
										</div>
										<div class=\"form-group col-sm-4\">
											<label for=\"channelTagLineJapanese\" class=\"control-label\">" . Lang::getLang('tagLineJapanese') . "</label>
											<input type=\"text\" id=\"channelTagLineJapanese\" name=\"channelTagLineJapanese\" class=\"form-control\" placeholder=\"channelTagLineJapanese\" value=\"" . $channelTagLineJapanese . "\">
										</div>
										<div class=\"form-group col-sm-4\">
											<label for=\"channelKeywordsJapanese\" class=\"control-label\">" . Lang::getLang('keywordsJapanese') . "</label>
											<input type=\"text\" id=\"channelKeywordsJapanese\" name=\"channelKeywordsJapanese\" class=\"form-control\" placeholder=\"channelKeywordsJapanese\" value=\"" . $channelKeywordsJapanese . "\">
										</div>
									</div>
									
									<br />
									
									<div class=\"row\">
										<div class=\"form-group col-sm-12\">
											<label for=\"channelDescriptionJapanese\" class=\"control-label\">" . Lang::getLang('descriptionJapanese') . "</label>
											<input type=\"text\" id=\"channelDescriptionJapanese\" name=\"channelDescriptionJapanese\" class=\"form-control\" placeholder=\"channelDescriptionJapanese\" value=\"" . $channelDescriptionJapanese . "\">
										</div>
									</div>

								<hr />

									<div class=\"form-group\">
										<label for=\"themeKey\" class=\"control-label\">" . Lang::getLang('theme') . "</label>
										<div class=\"\">" . ThemeView::getThemeDropdown($themeKey) . "</div>
									</div>
									
									<hr />

									<label for=\"contentCategoryKey[]\" class=\"control-label\">" . Lang::getLang('categories') . "</label>
									
									<div class=\"row\">
										<div class=\"form-group col-sm-4\">
											<input type=\"text\" name=\"newCategory[]\" class=\"form-control\" placeholder=\"" . Lang::getLang('newCategory') . "\" value=\"\">
										</div>
										<div class=\"form-group col-sm-4\">
											<input type=\"text\" name=\"newCategory[]\" class=\"form-control\" placeholder=\"" . Lang::getLang('newCategory') . "\" value=\"\">
										</div>
										<div class=\"form-group col-sm-4\">
											<input type=\"text\" name=\"newCategory[]\" class=\"form-control\" placeholder=\"" . Lang::getLang('newCategory') . "\" value=\"\">
										</div>
									</div>
									
									<div class=\"form-group\">" . self::channelContentCategoryFormPartial($contentCategoryKeyArray) . "</div>

								<hr />

									<div class=\"form-group\">
										<input type=\"submit\" name=\"jagaChannelSubmit\" id=\"jagaChannelSubmit\" class=\"btn btn-default jagaFormButton pull-right\" value=\"" . Lang::getLang($type) . "\">
									</div>

							</form>
							<!-- END jagaChannelForm -->
						
						</div>
						<!-- END PANEL-BODY -->
					
					</div>
					<!-- END PANEL -->
				
				</div>
				<!-- END CHANNEL DIV -->
				
			</div>
			<!-- END CHANNEL ROW -->
			
		</div>
		<!-- END CHANNEL CONTAINER -->
		
		";

		return $html;
	
	}

	public static function displayUserChannelList() {
	
		$channelArray = Channel::getUserOwnChannelArray($_SESSION['userID']);
		ksort($channelArray);
		
		$html = '';
		
		$html .= "<!-- START CHANNEL LIST -->\n";
		$html .= "<div class=\"container\">\n\n";
		
			$html .= "<div class=\"row\">\n\n";
		
			$html .= "<div class=\"col-md-12\">\n\n";
		
			$html .= "<div class=\"panel panel-default\">\n";
				
				$html .= "<div class=\"panel-heading jagaContentPanelHeading\"><h4>" . Lang::getLang('channels') . " <a href=\"/settings/channels/create/\" style=\"float:right;\"><span class=\"glyphicon glyphicon-plus\"></span></a></h4></div>\n";
				
				$html .= "<div class=\"table-responsive\">\n";
					$html .= "<table class=\"table table-hover table-striped\">\n";
					
						$html .= "<tr>";
							$html .= "<th>" . Lang::getLang('channel') . "</th>\n";
							$html .= "<th>" . Lang::getLang('theme') . "</th>\n";
							$html .= "<th class=\"text-right\">" . Lang::getLang('totalPosts') . "</th>\n";
							$html .= "<th class=\"text-right\">" . Lang::getLang('pagesServed') . "</th>\n";
						$html .= "</tr>";
						
						foreach ($channelArray AS $channelKey => $totalPosts) {
							
							$channelID = Channel::getChannelID($channelKey);
							$channel = new Channel($channelID);
							$channelEnabled = $channel->channelEnabled;
							
							$channelTitle = $channel->getTitle();
							$channelKeywords = $channel->getKeywords();
							$channelDescription = $channel->getDescription();
							
							$themeKey = $channel->themeKey;
							$pagesServed = $channel->pagesServed;
							$siteManagerUserID = $channel->siteManagerUserID;
							
							$html .= "<tr class=\"jagaClickableRow\" data-url=\"http://" . $channelKey . "." . Config::read('site.url') . "/settings/channels/update/" . $channelKey . "/\">";
								$html .= "<td>" . $channelTitle . " (" . strtolower($channelKey) . "." . Config::read('site.url') . ")</td>\n";
								$html .= "<td>" . $themeKey . "</td>\n";
								$html .= "<td class=\"text-right\">" . $totalPosts . "</td>\n";
								$html .= "<td class=\"text-right\">" . $pagesServed . "</td>\n";
							$html .= "</tr>";
							
						}
						
					$html .= "</table>\n";
				$html .= "</div>\n";

			$html .= "</div>\n";
			$html .= "</div>\n";
			$html .= "</div>\n\n";
			
		$html .= "</div>\n";
		$html .= "<!-- END CHANNEL LIST -->\n\n";
		
		return $html;	

	}
	
	public static function displayChannelList() {
	
		$channelArray = Channel::getChannelArray();
	
		$html = '';
		
		$html .= "<!-- START CHANNEL LIST -->\n";
		$html .= "<div class=\"container\">\n\n";
		
			$html .= "<div class=\"row\">\n\n";
		
			$html .= "<div class=\"col-md-12\">\n\n";
			
			$html .= "<div class=\"panel panel-default\">\n";
				
				$html .= "<div class=\"panel-heading jagaContentPanelHeading\"><h4>" . Lang::getLang('allChannels') . "</h4></div>\n";

				$html .= "<div class=\"table-responsive\">\n";
					$html .= "<table class=\"table table-striped table-hover table-condensed\">\n";
					
						$html .= "<tr>";
							$html .= "<th>" . Lang::getLang('channel') . "</th>\n";
							$html .= "<th>" . Lang::getLang('manager') . "</th>\n";
							$html .= "<th class=\"text-right\">" . Lang::getLang('totalPosts') . "</th>\n";
						$html .= "</tr>";
						
						foreach ($channelArray AS $channelKey => $totalPosts) {
							
							$channelID = Channel::getChannelID($channelKey);
							$channel = new Channel($channelID);
							$channelTitle = $channel->getTitle();
							$pagesServed = $channel->pagesServed;
							$isPublic = $channel->isPublic;
							$isCloaked = $channel->isCloaked;
							$isNSFW = $channel->isNSFW;
							$siteManagerUserName = User::getUserName($channel->siteManagerUserID);
							
							if ($isPublic && !$isCloaked && !$isNSFW) {
							
								$html .= "<tr class=\"jagaClickableRow\" data-url=\"http://" . $channelKey . "." . Config::read('site.url') . "/\">";
									$html .= "<td>" . $channelTitle . " (" . strtolower($channelKey) . "." . Config::read('site.url') . ")</td>\n";
									$html .= "<td>" . $siteManagerUserName . "</td>\n";
									$html .= "<td class=\"text-right\">" . $totalPosts . "</td>\n";
								$html .= "</tr>";
							
							}

						}
						
					$html .= "</table>\n";
				$html .= "</div>\n";
				
			$html .= "</div>\n";
			
			$html .= "</div>\n";

			$html .= "</div>\n\n";
			
		$html .= "</div>\n";
		$html .= "<!-- END CHANNEL LIST -->\n\n";
		
		return $html;	

	}
	
	public static function channelContentCategoryFormPartial($contentCategoryKeyArray) {
										
		$categoryArray = Category::getAllCategories();	
		$categoryCount = count($categoryArray);
		$checkboxColumnCount = ceil($categoryCount/2) - 1;

		$html = '';
			foreach ($categoryArray AS $contentCategoryKey => $postCount) {
				$html .= "<span style=\"white-space:nowrap;\">";
					$html .= "<input type=\"checkbox\" id=\"contentCategoryKey\" name=\"contentCategoryKey[]\" value=\"" . $contentCategoryKey . "\"";
						if (in_array($contentCategoryKey, $contentCategoryKeyArray)) { $html .= " checked"; }
					$html .= "> " . $contentCategoryKey . ($postCount > 0 ? " (" . $postCount . ")" : "");
				$html .= "</span> ";
			}
		return $html;
					
	}
	
}

?>