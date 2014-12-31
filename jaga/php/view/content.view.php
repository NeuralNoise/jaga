<?php

class ContentView {

	public function displayContentView($contentID) {
	
		
	
		$core = Core::getInstance();
		$query = "
			SELECT contentEnglish AS content, contentTitleEnglish AS title
			FROM jaga_Content 
			WHERE contentID = :contentID 
			LIMIT 1
		";
		
		$statement = $core->database->prepare($query);
		$statement->execute(array(':contentID' => $contentID));
		if ($row = $statement->fetch()) {
		
			Content::contentViewsPlusOne($contentID);
		
			$html = "\n\t<!-- START CONTENT -->\n";
			$html .= "\t<div class=\"container\">\n\n";
				$html .= "\t<div class=\"panel panel-default\">\n";
					$html .= "\t\t<div class=\"panel-heading jagaContentPanelHeading\"><h4>" . $row['title'] . "</h4></div>\n";
					$html .= "\t\t<div class=\"panel-body\">";
						
						$html .= "<div class=\"well\">" . $row['content'] . "</div>";
						
						$html .= "<div id=\"list\" class=\"row\">";
							$imageArray = Image::getObjectImageUrlArray('Content', $contentID);
							foreach ($imageArray AS $imageID => $imageURL) {
								
								// IMAGE
								$html .= "<div class=\"item col-xs-12 col-sm-6 col-md-4 col-lg-3\" data-toggle=\"modal\" data-target=\"#" . $imageID . "\" style=\"margin-bottom:10px;\">";
									$html .= "<img src=\"" . $imageURL . "\" class=\"img-responsive\">";
								$html .= "</div>\n";
								
								// MODAL
								$html .= "
								<div class=\"modal fade\" id=\"" . $imageID . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"deluxeNobileFirLabel\" aria-hidden=\"true\">
								<div class=\"modal-dialog\">
									<div class=\"modal-content\">
										<div class=\"modal-header\">
											<button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
											<h4 class=\"modal-title\" id=\"" . $imageID . "\">" . $row['title'] ."</h4>
										</div>
										<div class=\"modal-body text-center\"><img src=\"" . $imageURL . "\" class=\"img-responsive\" style=\"margin:0px auto 0px auto;\"></div>
										<div class=\"modal-footer\"><button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button></div>
									</div>
								</div>
								</div>
								";
								
							}
						$html .= "</div>\n";
						
					$html .= "</div>\n";
				$html .= "\t</div>\n";
			$html .= "\t</div>\n";
			$html .= "\t<!-- END CONTENT -->\n\n";
		
			return $html;

		} else {
		
			die ("ContentView::displayContentView(\$contentURL) cannot find your content.");
			
		}
	
	}

	public function displayChannelContentList($channelID, $contentCategoryKey) {

		$contentArray = Content::getContentListArray($channelID, $contentCategoryKey, 1);

		$html = "\t<!-- START CONTENT LIST -->\n";
		$html .= "\t<div class=\"container\">\n\n";
		
			$html .= "\t\t<div class=\"panel panel-default\">\n\n";
		
				$html .= "\t\t\t<div class=\"panel-heading jagaContentPanelHeading\">\n";
					$html .= "\t\t\t\t<a href=\"/k/create/" . $contentCategoryKey . "/\"><span style=\"float:right;\" class=\"glyphicon glyphicon-plus\"></span></a>\n";
					$html .= "\t\t\t\t<h4>" . strtoupper($contentCategoryKey) . "</h4>\n";
				$html .= "\t\t\t</div>\n";
				$html .= "\t\t\t<ul class=\"list-group\">\n";

				
					foreach ($contentArray as $contentID => $contentURL) {
					
						$content = new Content($contentID);
						$contentTitle = $content->contentTitleEnglish;
						$contentViews = $content->contentViews;

						$html .= "\t\t\t\t<a href=\"/k/" . $contentCategoryKey . "/" . $contentURL . "/\" class=\"list-group-item jagaListGroupItem\">";
							$html .= "<span class=\"jagaListGroup\">";
								$html .= "<span class=\"jagaListGroupBadge\">" . $contentViews . "</span>";
								$html .=  $contentTitle;
							$html .= "</span>";
						$html .= "</a>\n";
						
					}
					
					
					
					

					$html .= "\t\t\t\t<a href=\"/k/" . $contentCategoryKey . "/\" class=\"list-group-item jagaListGroupItemMore\">";
						$html .= "MORE <span class=\"glyphicon glyphicon-arrow-right\"></span>";
					$html .= "</a>\n";
					
				$html .= "\t\t\t</ul>\n";
				
			$html .= "\t\t</div>\n\n";
			
		$html .= "\t</div>\n";
		$html .= "\t<!-- END CONTENT LIST -->\n\n";
		
		return $html;	

	
	}
	
	public static function getContentForm(
		$type, 
		$contentID = 0, 
		$contentCategoryKey = '', 
		$inputArray = array(), 
		$errorArray = array()
	) {
	
		// print_r($contentCategoryKey);
	
		if (empty($inputArray)) {

			$content = new Content($contentID);
			
			$channelID = $_SESSION['channelID'];
			$contentURL = $content->contentURL;
			if ($contentID != 0) { $contentCategoryKey = $content->contentCategoryKey; }
			$contentSubmittedByUserID = $content->contentSubmittedByUserID;
			$contentSubmissionDateTime = $content->contentSubmissionDateTime;
			$contentPublishStartDate = $content->contentPublishStartDate;
			$contentPublishEndDate = $content->contentPublishEndDate;
			$contentLastModified = $content->contentLastModified;
			$contentTitleEnglish = $content->contentTitleEnglish;
			$contentTitleJapanese = $content->contentTitleJapanese;
			$contentEnglish = $content->contentEnglish;
			$contentJapanese = $content->contentJapanese;
			$contentLinkURL = $content->contentLinkURL;
			$contentPublished = $content->contentPublished;
			$contentViews = $content->contentViews;
			$contentIsEvent = $content->contentIsEvent;
			$contentEventDate = $content->contentEventDate;
			$contentEventStartTime = $content->contentEventStartTime;
			$contentEventEndTime = $content->contentEventEndTime;
			$contentHasLocation = $content->contentHasLocation;
			$contentLatitude = $content->contentLatitude;
			$contentLongitude = $content->contentLongitude;

		} else {

			$channelID = $_SESSION['channelID'];
			if (isset($inputArray['contentURL'])) { $contentURL = $inputArray['contentURL']; }
			if (isset($inputArray['contentCategoryKey'])) { $contentCategoryKey = $inputArray['contentCategoryKey']; }
			if (isset($inputArray['contentSubmittedByUserID'])) { $contentSubmittedByUserID = $inputArray['contentSubmittedByUserID']; }
			if (isset($inputArray['contentSubmissionDateTime'])) { $contentSubmissionDateTime = $inputArray['contentSubmissionDateTime']; }
			if (isset($inputArray['contentPublishStartDate'])) { $contentPublishStartDate = $inputArray['contentPublishStartDate']; }
			if (isset($inputArray['contentPublishEndDate'])) { $contentPublishEndDate = $inputArray['contentPublishEndDate']; }
			if (isset($inputArray['contentLastModified'])) { $contentLastModified = $inputArray['contentLastModified']; }
			if (isset($inputArray['contentTitleEnglish'])) { $contentTitleEnglish = $inputArray['contentTitleEnglish']; }
			if (isset($inputArray['contentTitleJapanese'])) { $contentTitleJapanese = $inputArray['contentTitleJapanese']; }
			if (isset($inputArray['contentEnglish'])) { $contentEnglish = $inputArray['contentEnglish']; }
			if (isset($inputArray['contentJapanese'])) { $contentJapanese = $inputArray['contentJapanese']; }
			if (isset($inputArray['contentLinkURL'])) { $contentLinkURL = $inputArray['contentLinkURL']; }
			if (isset($inputArray['contentPublished']) && $inputArray['contentPublished'] == 1) { $contentPublished = 1; } else { $contentPublished = 0; }
			if (isset($inputArray['contentViews'])) { $contentViews = $inputArray['contentViews']; }
			if (isset($inputArray['contentIsEvent'])) { $contentIsEvent = $inputArray['contentIsEvent']; } else { $contentIsEvent = 0; }
			if (isset($inputArray['contentEventDate'])) { $contentEventDate = $inputArray['contentEventDate']; }
			if (isset($inputArray['contentEventStartTime'])) { $contentEventStartTime = $inputArray['contentEventStartTime']; }
			if (isset($inputArray['contentEventEndTime'])) { $contentEventEndTime = $inputArray['contentEventEndTime']; }
			if (isset($inputArray['contentHasLocation'])) { $contentHasLocation = $inputArray['contentHasLocation']; } else { $contentHasLocation = 0; }
			if (isset($inputArray['contentLatitude'])) { $contentLatitude = $inputArray['contentLatitude']; }
			if (isset($inputArray['contentLongitude'])) { $contentLongitude = $inputArray['contentLongitude']; }

		}

		

/*
CREATE TABLE IF NOT EXISTS `jaga_Content` (
  `contentID` int(8) NOT NULL AUTO_INCREMENT,
  `channelID` int(8) NOT NULL,
  `contentURL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contentCategoryKey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contentSubmittedByUserID` int(8) NOT NULL,
  `contentSubmissionDateTime` datetime NOT NULL,
  `contentPublishStartDate` date NOT NULL,
  `contentPublishEndDate` date NOT NULL,
  `contentLastModified` datetime NOT NULL,
  `contentTitleEnglish` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contentTitleJapanese` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contentEnglish` text COLLATE utf8_unicode_ci NOT NULL,
  `contentJapanese` text COLLATE utf8_unicode_ci NOT NULL,
  `contentLinkURL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contentPublished` int(1) NOT NULL,
  `contentViews` int(12) NOT NULL,
  `contentIsEvent` int(1) NOT NULL,
  `contentEventDate` date NOT NULL,
  `contentEventStartTime` time NOT NULL,
  `contentEventEndTime` time NOT NULL,
  `contentHasLocation` int(1) NOT NULL,
  `contentLatitude` decimal(9,6) NOT NULL,
  `contentLongitude` decimal(9,6) NOT NULL,
  PRIMARY KEY (`contentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9999910 ;

*/

		if ($type == 'create') { $formURL = "/k/create/"; } elseif ($type == 'update') { $formURL = "/k/update/" . $contentID . "/"; }
		
		$html = "\n\t<!-- START CONTENT CONTAINER -->\n";
		$html .= "\t<div class=\"container\">\n\n";
		
			$html .= "\t\t<!-- START jagaContent -->\n";
			$html .= "\t\t<div id=\"jagaContent\" class=\"\">\n\n";

				$html .= "\t\t\t<!-- START PANEL -->\n";
				$html .= "\t\t\t<div class=\"panel panel-default\" >\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-HEADING -->\n";
					$html .= "\t\t\t\t<div class=\"panel-heading jagaContentPanelHeading\">\n\n";
						
						$html .= "\t\t\t\t\t<div class=\"panel-title\">" . strtoupper($type) . " POST</div>\n";
					
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-HEADING -->\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-BODY -->\n";
					$html .= "\t\t\t\t<div class=\"panel-body\">\n\n";
					
						
						$html .= "\t\t\t\t\t<!-- START jagaContentForm -->\n";
						
						$html .= "\t\t\t\t\t<form role=\"form\" id=\"jagaContentForm\" name=\"jagaContentForm\" class=\"form-horizontal\"  method=\"post\" action=\"" . $formURL . "\"  enctype=\"multipart/form-data\">\n\n";
					
							if ($type == 'update') { $html .= "<input type=\"hidden\" name=\"contentID\" value=\"" . $contentID . "\">\n"; }

							$html .= "\t\t\t\t\t\t<div class=\"row\">\n";
								$html .= "\t\t\t\t\t\t\t<label class=\"col-sm-2 pull-right\">";
									
									$html .= "\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"contentPublished\" value=\"1\"";
										if ($contentPublished == 1) { $html .= " checked"; }
									$html .= "> Published\n";
									
								$html .= "\t\t\t\t\t\t\t</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-4 pull-right\">\n";
									$html .= CategoryView::categoryDropdown($contentCategoryKey);
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "<hr />\n\n";

							$html .= "\t\t\t\t\t\t<div class=\"row\">\n";
									
									$html .= "<div class=\"col-sm-6\">";
								
										$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
											$html .= "\t\t\t\t\t\t\t<label for=\"contentTitleEnglish\" class=\"col-sm-4 control-label\">contentTitleEnglish</label>\n";
											$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-8\">\n";
												$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"contentTitleEnglish\" name=\"contentTitleEnglish\" class=\"form-control\" placeholder=\"contentTitleEnglish\" value=\"" . $contentTitleEnglish . "\">\n";
											$html .= "\t\t\t\t\t\t\t</div>\n";
										$html .= "\t\t\t\t\t\t</div>\n\n";
										
										$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
											$html .= "\t\t\t\t\t\t\t<label for=\"contentEnglish\" class=\"col-sm-4 control-label\">contentEnglish</label>\n";
											$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-8\">\n";
												$html .= "\t\t\t\t\t\t\t\t<textarea rows=\"7\" id=\"contentEnglish\" name=\"contentEnglish\" class=\"form-control\" placeholder=\"contentEnglish\">" . $contentEnglish . "</textarea>\n";
											$html .= "\t\t\t\t\t\t\t</div>\n";
										$html .= "\t\t\t\t\t\t</div>\n\n";
										
									$html .= "</div>";
									

									$html .= "<div class=\"col-sm-6\">";
										
										$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";	
											$html .= "\t\t\t\t\t\t\t<label for=\"contentTitleJapanese\" class=\"col-sm-4 control-label\">contentTitleJapanese</label>\n";
											$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-8\">\n";
												$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"contentTitleJapanese\" name=\"contentTitleJapanese\" class=\"form-control\" placeholder=\"contentTitleJapanese\" value=\"" . $contentTitleJapanese . "\">\n";
											$html .= "\t\t\t\t\t\t\t</div>\n";
										$html .= "\t\t\t\t\t\t</div>\n\n";
										
										$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";	
											$html .= "\t\t\t\t\t\t\t<label for=\"contentJapanese\" class=\"col-sm-4 control-label\">contentJapanese</label>\n";
											$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-8\">\n";
												$html .= "\t\t\t\t\t\t\t\t<textarea rows=\"7\" id=\"contentJapanese\" name=\"contentJapanese\" class=\"form-control\" placeholder=\"contentJapanese\">" . $contentJapanese . "</textarea>\n";
											$html .= "\t\t\t\t\t\t\t</div>\n";
										$html .= "\t\t\t\t\t\t</div>\n\n";

									$html .= "</div>";
									
								$html .= "</div>";

								$html .= "<hr />";
									
										$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
										
											$html .= "\t\t\t\t\t\t\t<label for=\"contentImages\" class=\"col-sm-2 control-label\">IMAGES</label>\n";
										
											$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-6\">\n";
												$html .= "<div class=\"input-group\">";
													$html .= "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-picture\"></i></span>";
													$html .= "<input type=\"file\" name=\"contentImages[]\" accept=\"image/jpeg\" class=\"form-control\"  multiple=\"multiple\">";
												$html .= "</div>";
											$html .= "</div>";
											
											
											
										$html .= "</div>";
									
									$html .= "<hr />";
									
										$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
											$html .= "\t\t\t\t\t\t\t<label for=\"contentLinkURL\" class=\"col-sm-2 control-label\">LINK</label>\n";
											$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-6\">\n";

												$html .= "<div class=\"input-group\">";
													$html .= "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-link\"></i></span>";
													$html .= "<input type=\"url\" name=\"contentLinkURL\" class=\"form-control\" placeholder=\"http://example.com/\" value=\"" . $contentLinkURL . "\">";
												$html .= "</div>";
											$html .= "</div>";
										$html .= "</div>";
								
									$html .= "<hr />";

										$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
											$html .= "<label for=\"contentHasLocation\" class=\"col-sm-2 control-label\"><input type=\"checkbox\" name=\"contentHasLocation\" value=\"1\"";
												if ($contentHasLocation == 1) { $html .= " checked=\"true\""; }
											$html .= "> LOCATION</label>";
											$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-10\">\n";
												$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"contentLocationNameInput\" name=\"contentLocationNameInput\" class=\"form-control\">\n";
											$html .= "\t\t\t\t\t\t\t</div>\n";
										$html .= "\t\t\t\t\t\t</div>\n\n";
										
										$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";

											$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-10 col-sm-offset-2\">\n";
												$html .= "\t\t<div id=\"contentCoordinatesMap\"></div>\n";
											$html .= "\t\t\t\t\t\t\t</div>\n";
											
										$html .= "\t\t\t\t\t\t</div>\n\n";
										
										$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
										
											$html .= "\t\t\t\t\t\t\t<label for=\"contentLatitude\" class=\"col-sm-1 col-sm-offset-2\">LATITUDE</label>\n";
											$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-2\">\n";
												$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"contentLatitude\" name=\"contentLatitude\" class=\"form-control\" placeholder=\"0.000000\" value=\"" . $contentLatitude . "\">\n";
											$html .= "\t\t\t\t\t\t\t</div>\n";
											
											$html .= "\t\t\t\t\t\t\t<label for=\"contentLongitude\" class=\"col-sm-1\">LONGITUDE</label>\n";
											$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-2\">\n";
												$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"contentLongitude\" name=\"contentLongitude\" class=\"form-control\" placeholder=\"0.000000\" value=\"" . $contentLongitude . "\">\n";
											$html .= "\t\t\t\t\t\t\t</div>\n";
											
										$html .= "\t\t\t\t\t\t</div>\n\n";
							
										$html .= "
										
											<script>
												$('#contentCoordinatesMap').locationpicker({
													location: {
														latitude: " . $contentLatitude . ",
														longitude: " . $contentLongitude . "
													},
													radius: 100,
													inputBinding: {
														latitudeInput: $('#contentLatitude'),
														longitudeInput: $('#contentLongitude'),
														locationNameInput: $('#contentLocationNameInput')
													},
													enableAutocomplete: true
												});
											</script>
											
										";
	
									$html .= "<hr />";		

										$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";

											$html .= "<label for=\"contentIsEvent\" class=\"col-sm-2 control-label\"><input type=\"checkbox\" name=\"contentIsEvent\" value=\"1\"";
												if ($contentIsEvent == 1) { $html .= " checked=\"true\""; }
											$html .= "> EVENT</label>";

											$html .= "<div class=\"col-sm-3\">";
												$html .= "<div class=\"input-group\">";
													$html .= "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span>";
													$html .= "<input type=\"date\" name=\"contentEventDate\" class=\"form-control\" value=\"" . $contentEventDate . "\">";
												$html .= "</div>";
											$html .= "</div>";

											$html .= "<div class=\"col-sm-1\">";
												$html .= "<label for=\"contentEventStartTime\">START TIME</label>";
											$html .= "</div>";
											
											$html .= "<div class=\"col-sm-2\">";
												$html .= "<div class=\"input-group\">";
													$html .= "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-time\"></i></span>";
													$html .= "<input type=\"time\" name=\"contentEventStartTime\" class=\"form-control\" value=\"" . $contentEventStartTime . "\">";
												$html .= "</div>";
											$html .= "</div>";		
											
											$html .= "<div class=\"col-sm-1\">";
												$html .= "<label for=\"contentEventEndTime\">END TIME</label>";
											$html .= "</div>";
											
											$html .= "<div class=\"col-sm-2\">";
												$html .= "<div class=\"input-group\">";
													$html .= "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-time\"></i></span>";
													$html .= "<input type=\"time\" name=\"contentEventEndTime\" class=\"form-control\" value=\"" . $contentEventEndTime . "\">";
												$html .= "</div>";
											$html .= "</div>";
											
										$html .= "</div>";
		
							$html .= "<hr />\n\n";

							// START SUBMIT BUTTON
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-12\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"submit\" name=\"jagaContentSubmit\" id=\"jagaContentSubmit\" class=\"btn btn-default jagaFormButton col-xs-8 col-sm-6 col-md-4 pull-right\" value=\"" . $type . "\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							// START SUBMIT BUTTON
							
							
							
							
							
						$html .= "\t\t\t\t\t</form>\n";
						$html .= "\t\t\t\t\t<!-- END jagaContentForm -->\n\n";
			
			
			
			
			
			
			
			
			
			
			
			
			
			
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-BODY -->\n\n";
			
				$html .= "\t\t\t</div>\n";
				$html .= "\t\t\t<!-- END PANEL -->\n\n";
			
			$html .= "\t\t</div>\n";
			$html .= "\t\t<!-- END jagaContent -->\n\n";

		$html .= "\t</div>\n";
		$html .= "\t<!-- END CONTENT CONTAINER -->\n\n";
			
		return $html;

	}

	
	public function displayUserContentList($username) {

		$userID = User::getUserIDwithUserNameOrEmail($username);
		$userContentArray = Content::getUserContent($userID);
				
		$html = "\t<!-- START CONTENT LIST -->\n";
		$html .= "\t<div class=\"container\">\n\n";
		
			$html .= "\t\t<div class=\"panel panel-default\">\n\n";
		
				$html .= "\t\t\t<div class=\"panel-heading jagaContentPanelHeading\"><h4>" . strtoupper($username) . "</h4></div>\n\n";
				
				$html .= "\t\t\t<ul class=\"list-group\">\n";

				
					foreach ($userContentArray as $contentID => $contentURL) {
					
						$content = new Content($contentID);
						$contentTitle = $content->contentTitleEnglish;
						$contentViews = $content->contentViews;
						$contentCategoryKey = $content->contentCategoryKey;

						$html .= "\t\t\t\t<a href=\"/k/" . $contentCategoryKey . "/" . $contentURL . "/\" class=\"list-group-item jagaListGroupItem\">";
							$html .= "<span class=\"jagaListGroup\">";
								$html .= "<span class=\"jagaListGroupBadge\">" . $contentViews . "</span>";
								$html .=  $contentTitle;
							$html .= "</span>";
						$html .= "</a>\n";
						
					}

					// $html .= "\t\t\t\t<a href=\"/k/" . $contentCategoryKey . "/\" class=\"list-group-item jagaListGroupItemMore\">";
						// $html .= "MORE <span class=\"glyphicon glyphicon-arrow-right\"></span>";
					// $html .= "</a>\n";
					
				$html .= "\t\t\t</ul>\n";
				
			$html .= "\t\t</div>\n\n";
			
		$html .= "\t</div>\n";
		$html .= "\t<!-- END CONTENT LIST -->\n\n";
		
		return $html;	

	
	}
	
	public function displayRecentContentItems($channelID = 0, $contentCategoryKey = '', $numberOfItems = 50) {
		
		$recentContentArray = Content::getRecentContentArray($channelID, $contentCategoryKey, $numberOfItems);

		$html = "\n\n";
		$html .= "\t\t<div class=\"container\"> <!-- START CONTAINER -->\n";
			$html .= "\t\t\t<div class=\"row\" id=\"list\"> <!-- START ROW -->\n";

				foreach ($recentContentArray AS $contentID) {
				
					$content = new Content($contentID);
					$contentURL = $content->contentURL;
					$thisContentCategoryKey = $content->contentCategoryKey;
					$contentTitle = $content->contentTitleEnglish;
					$contentSubmittedByUserID = $content->contentSubmittedByUserID;
					$contentSubmissionDateTime = $content->contentSubmissionDateTime;
					$contentEnglish = $content->contentEnglish;
					
					$thisChannelID = $content->channelID;
					$channel = new Channel($thisChannelID);
					$thisContentChannelKey = $channel->channelKey;
					$channelTitle = $channel->channelTitleEnglish;
					
					$contentViews = $content->contentViews;
					$user = new User($contentSubmittedByUserID);
					$username = $user->username;

					$html .= "\t\t\t\t<div class=\"item col-xs-12 col-sm-6 col-md-4 col-lg-3\">\n";
						$html .= "\t\t\t\t\t<div class=\"panel panel-default\">\n";
							
							$html .= "\t\t\t\t\t\t<div class=\"panel-heading jagaContentPanelHeading\">\n";
								$html .= "\t\t\t\t\t\t\t<h4>" . strtoupper($contentTitle) . "</h4>\n";
							$html .= "\t\t\t\t\t\t</div>\n";

							$html .= "\t\t\t\t\t\t\t<a href=\"http://" . $thisContentChannelKey . ".kutchannel.net/k/" . $thisContentCategoryKey . "/" . $contentURL . "/\" class=\"list-group-item jagaListGroupItem\">";
								$html .= "<span class=\"jagaListGroup\">";
									// $html .= "<span class=\"jagaListGroupBadge\">" . $contentViews . "</span>";
									if (Image::objectHasImage('Content',$contentID)) {
										$imagePath = Image::getLegacyObjectMainImagePath('Content',$contentID);
										if ($imagePath == "") { $imagePath = Image::getObjectMainImagePath('Content',$contentID); }
										if ($imagePath != "") { $html .= "<br /><img class=\"img-responsive\" src=\"" . $imagePath . "\"><br />"; }
									}			
									$html .=  $contentEnglish;	
								$html .= "</span>";
							$html .= "</a>\n";
							
						$html .= "\t\t\t\t\t</div>\n";
					$html .= "\t\t\t\t</div>\n";

				}
				
			$html .= "\t\t\t</div> <!-- END ROW -->\n";
		$html .= "\t\t</div> <!-- END CONTAINER -->\n\n";
		
		return $html;
	
	}

}

?>