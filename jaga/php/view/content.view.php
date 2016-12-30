<?php

class ContentView {

	public function displayContentView($contentID) {
	
		$content = new Content($contentID);
		$contentTitle = $content->getTitle();
		$contentContent = $content->getContent();
		$contentSubmissionDateTime = $content->contentSubmissionDateTime;
		$contentPublished = $content->contentPublished;
		$contentLinkURL = $content->contentLinkURL;
		$contentIsEvent = $content->contentIsEvent;
		$contentEventDate = $content->contentEventDate;
		$contentEventStartTime = $content->contentEventStartTime;
		$contentEventEndTime = $content->contentEventEndTime;
		$contentHasLocation = $content->contentHasLocation;
		$contentLatitude = $content->contentLatitude;
		$contentLongitude = $content->contentLongitude;
 
		$opID = $content->contentSubmittedByUserID;
		$op = new User($opID);
		$opUserName = $op->username;
		if ($op->userDisplayName != '') { $opUserDisplayName = $op->userDisplayName; } else { $opUserDisplayName = $opUserName; }

		Content::contentViewsPlusOne($contentID);
		$imageArray = Image::getObjectImageUrlArray('Content', $contentID);
		
		// $contentHtml
		if ($contentContent != '') {
			$contentHtml = "<div id=\"panelBodyContent\" class=\"row\">";
				$contentHtml .= "<div class=\"col-xs-12\">" . $contentContent . "</div>";
			$contentHtml .= "</div>";
		}
		
		// $alertHtml
		if (!$contentPublished) {
			$alertHtml = "\n\t<div class=\"container\">";
				$alertHtml .= "<div class=\"alert alert-danger\">";
					if ($_SESSION['lang'] == 'ja') { $alertHtml .= "今現在、当ページは公表していません。"; } else { $alertHtml .= "This post is not currently published."; }
				$alertHtml .= "</div>";
			$alertHtml .= "</div>\n\n";
		}
		
		// $linkHtml
		if ($contentLinkURL != '') {
			
			$linkHtml = "";
			$videoID = Video::isYouTubeVideo($contentLinkURL);
			
			if ($videoID) {
				$linkHtml .= "<div style=\"word-wrap:break-word;overflow:hidden;margin-bottom:10px;\">";
					$linkHtml .= "<a href=\"" . $contentLinkURL . "\" class=\"btn btn-default btn-block\"><img class=\"img-responsive\" src=\"http://img.youtube.com/vi/" . $videoID . "/hqdefault.jpg\"></a>";
				$linkHtml .= "</div>";
			}
			
			$contentLinkAnchor = preg_replace('#^https?://#', '', $contentLinkURL);
			$contentLinkAnchor = preg_replace('#^www\.#', '', $contentLinkAnchor);
			
			$linkHtml .= "<div style=\"word-wrap:break-word;overflow:hidden;margin-bottom:10px;\">";
				$linkHtml .= "<a href=\"" . $contentLinkURL . "\" class=\"btn btn-default btn-block\"><span class=\"glyphicon glyphicon-link\"></span> " . $contentLinkAnchor . "</a>";
			$linkHtml .= "</div>";
		}
		
		// $imageHtml
		if (!empty($imageArray)) {
			
			$imageCount = count($imageArray);
			switch ($imageCount) {
				case 1:
					$imageClasses = "col-xs-12 col-sm-12 col-md-12 col-lg-12";
					break;
				case 2:
					$imageClasses = "col-xs-12 col-sm-12 col-md-6 col-lg-6";
					break;
				case ($imageCount >= 3):
					$imageClasses = "col-xs-12 col-sm-12 col-md-6 col-lg-4";
					break;
			}
			
			$imageHtml = "<div class=\"row\" id=\"list\">";
				foreach ($imageArray AS $imageID => $imageURL) {
					if (!isset($imageHtml)) { $imageHtml = ''; }
					$imageHtml .= "<div class=\"" . $imageClasses . " item\">";
						$imageHtml .= "<img src=\"" . $imageURL . "\" class=\"img-responsive img-thumbnail jagaContentViewImage\">";
					$imageHtml .= "</div>";
				}
			$imageHtml .= "</div>";
			
		}

		// $mapHtml
		if ($contentHasLocation) {
			$mapHtml = "<div id=\"map-canvas\" style=\"margin-bottom:10px;\">";
				$mapHtml .= "<iframe frameborder=\"0\" style=\"border:0;\" src=\"https://www.google.com/maps/embed/v1/place?key=" . Config::read('googlemaps.embed-api-key') . "&maptype=satellite&q=" . $contentLatitude . "," . $contentLongitude . "\"></iframe>";
			$mapHtml .= "</div>";
		}
		
		// $eventHtml
		if ($contentIsEvent) {
			$eventHtml = "<div style=\"margin-bottom:10px;\">";
				$eventHtml .= "<div class=\"panel panel-default\">";
					$eventHtml .= "<div class=\"panel-heading jagaContentPanelHeading\">";
						$eventHtml .= Lang::getLang('event') . "<span class=\"glyphicon glyphicon-calendar pull-right\"></span>";
					$eventHtml .= "</div>";
					$eventHtml .= "\t\t<div class=\"panel-body\">";
						$eventHtml .= 'Date: ' . $contentEventDate;
						if ($contentEventStartTime && $contentEventStartTime != '00:00:00') { $eventHtml .= '<br />Start Time: ' . $contentEventStartTime; }
						if ($contentEventEndTime && $contentEventEndTime != '00:00:00') { $eventHtml .= '<br />End Time: ' . $contentEventEndTime; }
					$eventHtml .= "</div>";
				$eventHtml .= "</div>";
			$eventHtml .= "</div>";
		}
		
		$html = '';
		
		if (!$contentPublished) { $html .= $alertHtml; }
		
		if ($contentPublished || $opID == $_SESSION['userID'] || Authentication::isAdmin()) {
		
			$html .= "\n\t<!-- START CONTENT -->\n";
			$html .= "\t<div class=\"container\">\n\n";

				$html .= "\t<div class=\"panel panel-default\">\n";
				
					$html .= "\t\t<div class=\"panel-heading jagaContentPanelHeading\">";
						$html .= "<div>";
							$html .= "<strong><a href=\"http://jaga.io/u/" . urlencode($opUserName) . "/\">" . $opUserDisplayName . "</a></strong> <i>" . $contentSubmissionDateTime . "</i>";
							if ($opID == $_SESSION['userID'] || Authentication::isAdmin()) {
								$html .= "<a href=\"/k/update/" . $contentID . "/\" class=\"btn btn-default btn-sm pull-right\"><span class=\"glyphicon glyphicon-pencil\"></span></a>";
							}
						$html .= "</div>";
					$html .= "</div>\n";
					
					$html .= "\t\t<div class=\"panel-body\">\n";
						
						$html .= "\t\t\t<div class=\"row\">\n";

							$html .= "<div class=\"col-xs-12 col-sm-6 col-md-8 col-lg-9\">";
								if (isset($contentHtml)) { $html .= $contentHtml; }
								if (isset($imageHtml)) { $html .= $imageHtml; }
							$html .= "</div>";

							$html .= "<aside class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3\">";
								if (isset($eventHtml)) { $html .= $eventHtml; }
								if (isset($mapHtml)) { $html .= $mapHtml; }
								if (isset($linkHtml)) { $html .= $linkHtml; }

								$html .= "
									<script async src=\"//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></script>
									<!-- jaga.io -->
									<ins class=\"adsbygoogle\"
										 style=\"display:block\"
										 data-ad-client=\"" . Config::read('adsense.data-ad-client') . "\"
										 data-ad-slot=\"" . Config::read('adsense.data-ad-slot') . "\"
										 data-ad-format=\"auto\"></ins>
									<script>
									(adsbygoogle = window.adsbygoogle || []).push({});
									</script>
								";
								
							$html .= "</aside>";

						$html .= "</div>";

					$html .= "</div>\n";

				$html .= "\t</div>\n";

			$html .= "\t</div>\n";
			$html .= "\t<!-- END CONTENT -->\n\n";

		}
		
		return $html;
			
	}

	public function displayEasyContentView($contentID) {
	
		$content = new Content($contentID);
		$contentContent = $content->getContent();
		Content::contentViewsPlusOne($contentID);
		return $contentContent;
			
	}
	
	public static function displayChannelContentList($channelID, $contentCategoryKey) {

		$contentArray = Content::getContentListArray($channelID, $contentCategoryKey, 1);

		$category = new Category($contentCategoryKey);
		if ($_SESSION['lang'] == 'ja') { $contentCategoryTitle = $category->contentCategoryJapanese; } else { $contentCategoryTitle = $category->contentCategoryEnglish; }
		
		$html = "\t<!-- START CONTENT LIST -->\n";
		$html .= "\t<div class=\"container\">\n\n";
		
			$html .= "\t\t<div class=\"panel panel-default\">\n\n";
		
				$html .= "\t\t\t<div class=\"panel-heading jagaContentPanelHeading\">\n";
					$html .= "\t\t\t\t<a href=\"/k/create/" . $contentCategoryKey . "/\"><span style=\"float:right;\" class=\"glyphicon glyphicon-plus\"></span></a>\n";
					$html .= "\t\t\t\t<h4>" . strtoupper($contentCategoryTitle) . "</h4>\n";
				$html .= "\t\t\t</div>\n";
				
				$html .= "\t\t\t<ul class=\"list-group\">\n";

					foreach ($contentArray as $contentID => $contentURL) {
					
						$content = new Content($contentID);
						$contentTitle = $content->getTitle();
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
	
	public function getContentForm(
		$type, 
		$contentID = 0, 
		$contentCategoryKey = '', 
		$inputArray = array(), 
		$errorArray = array()
	) {
	
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
		
		$html = '';
		
		if ($type == 'create') { $formURL = "/k/create/"; } elseif ($type == 'update') { $formURL = "/k/update/" . $contentID . "/"; }
		
		if ($type == 'update' && $contentPublished == 0) {
			$html .= "\n\t<div class=\"container\">";
					$html .= "<div class=\"alert alert-danger\">";
						if ($_SESSION['lang'] == 'ja') { $html .= "今現在、当ページは公表していません。"; } else { $html .= "This post is not currently published."; }
					 $html .= "</div>";
			$html .= "</div>\n\n";
		}
		
		$html .= "\n\t<!-- START CONTENT CONTAINER -->\n";
		$html .= "\t<div class=\"container\">\n\n";

			$html .= "\t\t<!-- START jagaContent -->\n";
			$html .= "\t\t<div id=\"jagaContent\" class=\"\">\n\n";

				$html .= "\t\t\t<!-- START PANEL -->\n";
				$html .= "\t\t\t<div class=\"panel panel-default\" >\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-HEADING -->\n";
					$html .= "\t\t\t\t<div class=\"panel-heading jagaContentPanelHeading\">\n\n";
						
						$html .= "\t\t\t\t\t<div class=\"panel-title\">";
							
							if ($type == 'create') {
								$html .= strtoupper(Lang::getLang('createPost'));
							} elseif ($type == 'update') {
								$html .= strtoupper(Lang::getLang('updatePost'));
							}
							
							
						$html .= "</div>\n";
					
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-HEADING -->\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-BODY -->\n";
					$html .= "\t\t\t\t<div class=\"panel-body\">\n\n";

						$html .= "\t\t\t\t\t<!-- START jagaContentForm -->\n";
						
						$html .= "\t\t\t\t\t<form role=\"form\" id=\"jagaContentForm\" name=\"jagaContentForm\" class=\"form-horizontal\"  method=\"post\" action=\"" . $formURL . "\"  enctype=\"multipart/form-data\">\n\n";
					
							if ($type == 'update') { $html .= "<input type=\"hidden\" name=\"contentID\" value=\"" . $contentID . "\">\n"; }

							$html .= "\t\t\t\t\t\t<div class=\"row\">\n";
								
								$html .= "\t\t\t\t\t\t\t<div>\n";
								
									$html .= "\t\t\t\t\t\t\t<label class=\"col-sm-2 pull-right\">";
										$html .= "\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"contentPublished\" value=\"1\"";
											if ($contentPublished == 1) { $html .= " checked"; }
										$html .= "> " . Lang::getLang('publish') . "\n";
									$html .= "\t\t\t\t\t\t\t</label>\n";
									
									$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-4 pull-right\">\n";
										$html .= CategoryView::categoryDropdown($contentCategoryKey);
									$html .= "\t\t\t\t\t\t\t</div>\n";
									
								$html .= "\t\t\t\t\t\t\t</div>\n\n";
								
								
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "<hr />\n\n";

							$html .= "\t\t\t\t\t\t<div class=\"row\">\n";
									
									$html .= "<div class=\"col-sm-6\">";
								
										$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
											$html .= "\t\t\t\t\t\t\t<label for=\"contentTitleEnglish\" class=\"col-sm-4 control-label\">" . Lang::getLang('contentTitleEnglish') . "</label>\n";
											$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-8\">\n";
												$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"contentTitleEnglish\" name=\"contentTitleEnglish\" class=\"form-control\" placeholder=\"contentTitleEnglish\" value=\"" . $contentTitleEnglish . "\">\n";
											$html .= "\t\t\t\t\t\t\t</div>\n";
										$html .= "\t\t\t\t\t\t</div>\n\n";
										
										$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
											$html .= "\t\t\t\t\t\t\t<label for=\"contentEnglish\" class=\"col-sm-4 control-label\">" . Lang::getLang('contentEnglish') . "</label>\n";
											$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-8\">\n";
												$html .= "\t\t\t\t\t\t\t\t<textarea rows=\"7\" id=\"contentEnglish\" name=\"contentEnglish\" class=\"form-control\" placeholder=\"contentEnglish\">" . $contentEnglish . "</textarea>\n";
											$html .= "\t\t\t\t\t\t\t</div>\n";
										$html .= "\t\t\t\t\t\t</div>\n\n";
										
									$html .= "</div>";
									

									$html .= "<div class=\"col-sm-6\">";
										
										$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";	
											$html .= "\t\t\t\t\t\t\t<label for=\"contentTitleJapanese\" class=\"col-sm-4 control-label\">" . Lang::getLang('contentTitleJapanese') . "</label>\n";
											$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-8\">\n";
												$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"contentTitleJapanese\" name=\"contentTitleJapanese\" class=\"form-control\" placeholder=\"contentTitleJapanese\" value=\"" . $contentTitleJapanese . "\">\n";
											$html .= "\t\t\t\t\t\t\t</div>\n";
										$html .= "\t\t\t\t\t\t</div>\n\n";
										
										$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";	
											$html .= "\t\t\t\t\t\t\t<label for=\"contentJapanese\" class=\"col-sm-4 control-label\">" . Lang::getLang('contentJapanese') . "</label>\n";
											$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-8\">\n";
												$html .= "\t\t\t\t\t\t\t\t<textarea rows=\"7\" id=\"contentJapanese\" name=\"contentJapanese\" class=\"form-control\" placeholder=\"contentJapanese\">" . $contentJapanese . "</textarea>\n";
											$html .= "\t\t\t\t\t\t\t</div>\n";
										$html .= "\t\t\t\t\t\t</div>\n\n";

									$html .= "</div>";
									
								$html .= "</div>";

								$html .= "<hr />";
									
										$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
										
											$html .= "\t\t\t\t\t\t\t<label for=\"contentImages\" class=\"col-sm-2 control-label\">" . Lang::getLang('images') . "</label>\n";
										
											$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-6\">\n";
												$html .= "<div class=\"input-group\">";
													$html .= "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-picture\"></i></span>";
													$html .= "<input type=\"file\" name=\"contentImages[]\" accept=\"image/*\" class=\"form-control\"  multiple=\"multiple\">";
												$html .= "</div>";
											$html .= "</div>";
											
											
											
										$html .= "</div>";
									
									$html .= "<hr />";
									
										$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
											$html .= "\t\t\t\t\t\t\t<label for=\"contentLinkURL\" class=\"col-sm-2 control-label\">" . Lang::getLang('link') . "</label>\n";
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
											$html .= "> " . Lang::getLang('location') . "</label>";
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
										
											$html .= "\t\t\t\t\t\t\t<label for=\"contentLatitude\" class=\"col-sm-1 col-sm-offset-2\">" . Lang::getLang('latitude') . "</label>\n";
											$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-2\">\n";
												$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"contentLatitude\" name=\"contentLatitude\" class=\"form-control\" placeholder=\"0.000000\" value=\"" . $contentLatitude . "\">\n";
											$html .= "\t\t\t\t\t\t\t</div>\n";
											
											$html .= "\t\t\t\t\t\t\t<label for=\"contentLongitude\" class=\"col-sm-1\">" . Lang::getLang('longitude') . "</label>\n";
											$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-2\">\n";
												$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"contentLongitude\" name=\"contentLongitude\" class=\"form-control\" placeholder=\"0.000000\" value=\"" . $contentLongitude . "\">\n";
											$html .= "\t\t\t\t\t\t\t</div>\n";
											
										$html .= "\t\t\t\t\t\t</div>\n\n";
							
										$html .= "
										
											<script>
												j('#contentCoordinatesMap').locationpicker({
													location: {
														latitude: " . $contentLatitude . ",
														longitude: " . $contentLongitude . "
													},
													radius: 100,
													inputBinding: {
														latitudeInput: j('#contentLatitude'),
														longitudeInput: j('#contentLongitude'),
														locationNameInput: j('#contentLocationNameInput')
													},
													enableAutocomplete: true
												});
											</script>
											
										";
	
									$html .= "<hr />";		

										$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";

											$html .= "<label for=\"contentIsEvent\" class=\"col-sm-2 control-label\"><input type=\"checkbox\" name=\"contentIsEvent\" value=\"1\"";
												if ($contentIsEvent == 1) { $html .= " checked=\"true\""; }
											$html .= "> " . Lang::getLang('event') . "</label>";

											$html .= "<div class=\"col-sm-3\">";
												$html .= "<div class=\"input-group\">";
													$html .= "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span>";
													$html .= "<input type=\"date\" name=\"contentEventDate\" class=\"form-control\" value=\"" . $contentEventDate . "\">";
												$html .= "</div>";
											$html .= "</div>";

											$html .= "<div class=\"col-sm-1\">";
												$html .= "<label for=\"contentEventStartTime\">" . Lang::getLang('startTime') . "</label>";
											$html .= "</div>";
											
											$html .= "<div class=\"col-sm-2\">";
												$html .= "<div class=\"input-group\">";
													$html .= "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-time\"></i></span>";
													$html .= "<input type=\"time\" name=\"contentEventStartTime\" class=\"form-control\" value=\"" . $contentEventStartTime . "\">";
												$html .= "</div>";
											$html .= "</div>";		
											
											$html .= "<div class=\"col-sm-1\">";
												$html .= "<label for=\"contentEventEndTime\">" . Lang::getLang('endTime') . "</label>";
											$html .= "</div>";
											
											$html .= "<div class=\"col-sm-2\">";
												$html .= "<div class=\"input-group\">";
													$html .= "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-time\"></i></span>";
													$html .= "<input type=\"time\" name=\"contentEventEndTime\" class=\"form-control\" value=\"" . $contentEventEndTime . "\">";
												$html .= "</div>";
											$html .= "</div>";
											
										$html .= "</div>";
		
							$html .= "<hr />\n\n";

							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-12\">\n";
									if ($type == 'update') {
										$html .= "\t\t\t\t\t\t\t\t<a href=\"/k/delete/" . $contentID . "/\" class=\"btn btn-danger col-xs-2 col-sm-3 col-md-2\" style=\"color:#fff;\"><span class=\"glyphicon glyphicon-trash\"></span> <span class=\"hidden-xs\">" . strtoupper(Lang::getLang('delete')) . "</span></a>\n";
									}
									$html .= "\t\t\t\t\t\t\t\t<button type=\"submit\" name=\"jagaContentSubmit\" id=\"jagaContentSubmit\" ";
									if ($type == 'update') {
										$html .= "class=\"btn btn-primary col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-6\">";
									} elseif ($type == 'create') {
										$html .= "class=\"btn btn-primary col-xs-8 col-xs-offset-4 col-sm-6 col-sm-offset-6 col-md-4 col-md-offset-8\">";
									}
									$html .= "<span class=\"glyphicon glyphicon-ok\"></span> " . strtoupper(Lang::getLang($type)) . "</button>\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
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

	public static function displayUserContentList($username) {

		$userID = User::getUserIDwithUserNameOrEmail($username);
		$userContentArray = Content::getUserContent($userID);
				
		$html = "\t<!-- START CONTENT LIST -->\n";
		$html .= "\t<div class=\"container\">\n\n";
		
			$html .= "\t\t<div class=\"panel panel-default\">\n\n";
		
				$html .= "\t\t\t<div class=\"panel-heading jagaContentPanelHeading\"><h4>" . strtoupper($username) . "</h4></div>\n\n";
				
				$html .= "\t\t\t<ul class=\"list-group\">\n";

				
					foreach ($userContentArray as $contentID => $contentURL) {
					
						$content = new Content($contentID);
						$contentTitle = $content->getTitle();
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
	
	public static function displayRecentContentItems($channelID = 0, $contentCategoryKey = '', $numberOfItems = 50, $subscriptionUserID = 0) {
		
		if ($subscriptionUserID == 0) {
			$recentContentArray = Content::getRecentContentArray($channelID, $contentCategoryKey, $numberOfItems);
		} else {
			$recentContentArray = Subscription::getRecentSubscribedContentArray($subscriptionUserID);
		}

		$html = "\n\n";
		$html .= "\t\t<div class=\"container\"> <!-- START CONTAINER -->\n";
			$html .= "\t\t\t<div class=\"row\" id=\"list\"> <!-- START ROW -->\n";

				
				$i = 0;
				// if ($_SESSION['channelKey'] == 'niseko') { $html .= PredictionView::predictionContentWidget(); $i++; }

				foreach ($recentContentArray AS $contentID) {
				
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

					if ($_SESSION['userID'] == $contentSubmittedByUserID || !$user->userShadowBan) {
						
						$html .= "\t\t\t\t<div class=\"item col-xs-12 col-sm-6 col-md-4 col-lg-3\">\n";
							$html .= "\t\t\t\t\t<div class=\"panel panel-default\">\n";
								
								$html .= "\t\t\t\t\t\t<div class=\"panel-heading jagaContentPanelHeading\">\n";
									$html .= "<h4><a href=\"http://" . $thisContentChannelKey . ".jaga.io/k/" . $thisContentCategoryKey . "/" . $contentURL . "/\">" . strtoupper($contentTitle) . "</a></h4>";
									$html .= "<a href=\"http://jaga.io/u/" . urlencode($username) . "/\">" . $userDisplayName . "</a> ";
									
									if ($thisContentChannelKey == $_SESSION['channelKey']) {
										$html .= "<a href=\"http://" . $thisContentChannelKey . ".jaga.io/k/" . $thisContentCategoryKey . "/\" class=\"pull-right\">" . $categoryTitle . "</a>";
									} else {
										$html .= "<a href=\"http://" . $thisContentChannelKey . ".jaga.io/\" class=\"pull-right\">" . $channelTitle . "</a>";
									}
									
									
								$html .= "\t\t\t\t\t\t</div>\n";

								$html .= "\t\t\t\t\t\t\t<a href=\"http://" . $thisContentChannelKey . ".jaga.io/k/" . $thisContentCategoryKey . "/" . $contentURL . "/\" class=\"list-group-item jagaListGroupItem\">";
									$html .= "<span class=\"jagaListGroup\">";
										// $html .= "<span class=\"jagaListGroupBadge\">" . $contentViews . "</span>";
										
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
								$html .= "</a>\n";

							$html .= "\t\t\t\t\t</div>\n";
						$html .= "\t\t\t\t</div>\n";

						$i++;
						
					}
					
					if ($i == 3) {
						$html .= "\t\t\t\t<aside class=\"item col-xs-12 col-sm-6 col-md-4 col-lg-3\">\n";
							$html .= "\t\t\t\t\t<div class=\"panel panel-default\" style=\"padding:3px;\">\n";
								$html .= "
								<script async src=\"//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></script>
								<!-- jaga.io -->
								<ins class=\"adsbygoogle\"
									 style=\"display:block\"
									 data-ad-client=\"" . Config::read('adsense.data-ad-client') . "\"
									 data-ad-slot=\"" . Config::read('adsense.data-ad-slot') . "\"
									 data-ad-format=\"auto\"></ins>
								<script>
								(adsbygoogle = window.adsbygoogle || []).push({});
								</script>
								";
							$html .= "\t\t\t\t\t</div>\n";
						$html .= "\t\t\t\t</aside>\n";
					}
					
					if ($i == 10) {
						
						$fbpagename = 'jagadotio';
						$fbpagetitle = 'jaga.io';
						
						if ($_SESSION['channelKey'] == 'niseko') {
							switch($contentCategoryKey) {
								case('jobs'):
									$fbpagename = 'nisekojobs';
									$fbpagetitle = 'Niseko Jobs';
									break;
								case('accommodation'):
									$fbpagename = 'nisekoaccomm';
									$fbpagetitle = 'Nisko Accommodation';
									break;
								case('property'):
									$fbpagename = 'nisekorealestate';
									$fbpagetitle = 'Niseko Real Estate';
									break;
								default:
									$fbpagename = 'kutchannel';
									$fbpagetitle = 'The Kutchannel';
							}
						} elseif ($_SESSION['channelKey'] == 'hakodate') {
							$fbpagename = 'hakodate';
							$fbpagetitle = 'Hakodate Guide';
						}
					
						$html .= "\t\t\t\t<aside class=\"item col-xs-12 col-sm-6 col-md-4 col-lg-3\">\n";
							$html .= "\t\t\t\t\t<div class=\"panel panel-default\" style=\"padding:3px;height:510px;text-align:center;\">\n";
								
								$html .= "\n
							
								<div class=\"fb-page\" data-href=\"https://www.facebook.com/" . $fbpagename . "/\" data-tabs=\"timeline\" data-height=\"500\" data-small-header=\"false\" data-adapt-container-width=\"true\" data-hide-cover=\"false\" data-show-facepile=\"true\">
								<blockquote cite=\"https://www.facebook.com/" . $fbpagename . "/\" class=\"fb-xfbml-parse-ignore\">
								<a href=\"https://www.facebook.com/" . $fbpagename . "/\">" . $fbpagetitle . "</a>
								</blockquote>
								</div>
							
							\n";
							
							$html .= "\t\t\t\t\t</div>\n";
						$html .= "\t\t\t\t</aside>\n";
						
					}
					
				}
				
			$html .= "\t\t\t</div> <!-- END ROW -->\n";
		$html .= "\t\t</div> <!-- END CONTAINER -->\n\n";
		
		return $html;
	
	}

	public function displayContentDeleteConfirmationForm($contentID) {
		
		$content = new Content($contentID);
		$contentTitle = $content->getTitle();
		$contentContent = $content->getContent();
		$authorUserID = $content->contentSubmittedByUserID;
		
		if ($authorUserID != $_SESSION['userID']) { die('You cannot delete posts that do not belong to you.'); }
		
		$html = "\n\n\t<!-- CONTENT DELTE CONFIRMATION FORM -->\n";
		$html .= "\t<div class=\"container\">\n\n";
			$html .= "\t\t<div class=\"panel panel-default\">\n";
				$html .= "\t\t<div class=\"panel-heading\">Permanently delete <u>" . $contentTitle . "</u>?</div>\n";
				$html .= "\t\t<div class=\"panel-body\">";
					$html .= $contentContent;
				$html .= "</div>\n";
				$html .= "\t\t<div class=\"panel-footer text-right\">\n";
					$html .= "\t\t\t<div>\n";
						$html .= "\t\t\t<form method=\"post\" action=\"/k/delete/" . $contentID . "/\">\n";
							$html .= "\t\t\t\t<input type=\"hidden\" name=\"contentID\" value =\"" . $contentID . "\">\n";
							$html .= "<button type=\"submit\" name=\"jagaDeleteContentConfirmation\" id=\"jagaDeleteContentConfirmation\" ";
							$html .= "class=\"btn btn-danger\" style=\"color:#fff;\">Yes. Delete this post. <span class=\"glyphicon glyphicon-remove\"></span></button>\n";
						$html .= "</form>\n";
					$html .= "\t\t\t</div>\n";
				$html .= "\t\t</div>\n";
			$html .= "\t\t<div>\n";
		$html .= "\t<div>\n\n";
		
		return $html;
	}

}

?>