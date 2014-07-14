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
		
			$html = "\n\t<!-- START CONTENT -->\n";
			$html .= "\t<div class=\"container\">\n\n";
				$html .= "\t<div class=\"panel panel-default\">\n";
					$html .= "\t\t<div class=\"panel-heading jagaContentPanelHeading\"><h4>" . $row['title'] . "</h4></div>\n";
					$html .= "\t\t<div class=\"panel-body\">\n\n";
						$html .= $row['content'];
					$html .= "\n\t\t</div>\n";
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
	
	public static function getContentForm($type, $contentID = 0, $contentCategoryKey = '', $inputArray = array(), $errorArray = array()) {
	
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
			$contentPublished = $content->contentPublished;
			$contentViews = $content->contentViews;
			$contentIsEvent = $content->contentIsEvent;
			$contentEventDate = $content->contentEventDate;
			$contentEventStartTime = $content->contentEventStartTime;
			$contentEventEndTime = $content->contentEventEndTime;
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
			if (isset($inputArray['contentPublished'])) { $contentPublished = $inputArray['contentPublished']; }
			if (isset($inputArray['contentViews'])) { $contentViews = $inputArray['contentViews']; }
			if (isset($inputArray['contentIsEvent'])) { $contentIsEvent = $inputArray['contentIsEvent']; }
			if (isset($inputArray['contentEventDate'])) { $contentEventDate = $inputArray['contentEventDate']; }
			if (isset($inputArray['contentEventStartTime'])) { $contentEventStartTime = $inputArray['contentEventStartTime']; }
			if (isset($inputArray['contentEventEndTime'])) { $contentEventEndTime = $inputArray['contentEventEndTime']; }
			if (isset($inputArray['contentLatitude'])) { $contentLatitude = $inputArray['contentLatitude']; }
			if (isset($inputArray['contentLongitude'])) { $contentLongitude = $inputArray['contentLongitude']; }
			
		}
		

		if ($type == 'create') { $formURL = "/k/create/"; } elseif ($type == 'update') { $formURL = "/k/update/" . $contentID . "/"; }
		
		$html = "\n\t<!-- START CONTENT CONTAINER -->\n";
		$html .= "\t<div class=\"container\">\n\n";
		
			$html .= "\t\t<!-- START jagaContent -->\n";
			$html .= "\t\t<div id=\"jagaContent\" class=\"\">\n\n";

				$html .= "\t\t\t<!-- START PANEL -->\n";
				$html .= "\t\t\t<div class=\"panel panel-default\" >\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-HEADING -->\n";
					$html .= "\t\t\t\t<div class=\"panel-heading jagaContentPanelHeading\">\n\n";
						
						$html .= "\t\t\t\t\t<div class=\"panel-title\">" . strtoupper($type) . " CONTENT</div>\n";
					
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-HEADING -->\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-BODY -->\n";
					$html .= "\t\t\t\t<div class=\"panel-body\">\n\n";
						
						$html .= "\t\t\t\t\t<!-- START jagaContentForm -->\n";
						
						$html .= "\t\t\t\t\t<form role=\"form\" id=\"jagaContentForm\" name=\"jagaContentForm\" class=\"form-horizontal\"  method=\"post\" action=\"" . $formURL . "\">\n\n";
					
							if ($type == 'update') { $html .= "<input type=\"hidden\" name=\"contentID\" value=\"" . $contentID . "\">\n"; }

							
							
							
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<label for=\"contentCategoryKey\" class=\"col-sm-2 control-label\">contentCategoryKey</label>\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-10\">\n";
									$html .= CategoryView::categoryDropdown($contentCategoryKey);
									// $html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"contentCategoryKey\" name=\"contentCategoryKey\" class=\"form-control\" placeholder=\"contentCategoryKey\" value=\"" . $contentCategoryKey . "\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							
							
							
							
							
							
							$html .= "<hr />";
							
								// START ENGLISH
								
								$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
									$html .= "\t\t\t\t\t\t\t<label for=\"contentTitleEnglish\" class=\"col-sm-2 control-label\">contentTitleEnglish</label>\n";
									$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-10\">\n";
										$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"contentTitleEnglish\" name=\"contentTitleEnglish\" class=\"form-control\" placeholder=\"contentTitleEnglish\" value=\"" . $contentTitleEnglish . "\">\n";
									$html .= "\t\t\t\t\t\t\t</div>\n";
								$html .= "\t\t\t\t\t\t</div>\n\n";
								
								$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
									$html .= "\t\t\t\t\t\t\t<label for=\"contentEnglish\" class=\"col-sm-2 control-label\">contentEnglish</label>\n";
									$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-10\">\n";
										$html .= "\t\t\t\t\t\t\t\t<textarea rows=\"7\" id=\"contentEnglish\" name=\"contentEnglish\" class=\"form-control\" placeholder=\"contentEnglish\">" . $contentEnglish . "</textarea>\n";
									$html .= "\t\t\t\t\t\t\t</div>\n";
								$html .= "\t\t\t\t\t\t</div>\n\n";
								
								// END ENGLISH
							
							$html .= "<hr />";
							
								// START JAPANESE
								
								$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
									$html .= "\t\t\t\t\t\t\t<label for=\"contentTitleJapanese\" class=\"col-sm-2 control-label\">contentTitleJapanese</label>\n";
									$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-10\">\n";
										$html .= "\t\t\t\t\t\t\t\t<input type=\"text\" id=\"contentTitleJapanese\" name=\"contentTitleJapanese\" class=\"form-control\" placeholder=\"contentTitleJapanese\" value=\"" . $contentTitleJapanese . "\">\n";
									$html .= "\t\t\t\t\t\t\t</div>\n";
								$html .= "\t\t\t\t\t\t</div>\n\n";
								
								$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
									$html .= "\t\t\t\t\t\t\t<label for=\"contentJapanese\" class=\"col-sm-2 control-label\">contentJapanese</label>\n";
									$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-10\">\n";
										$html .= "\t\t\t\t\t\t\t\t<textarea rows=\"7\" id=\"contentJapanese\" name=\"contentJapanese\" class=\"form-control\" placeholder=\"contentJapanese\">" . $contentJapanese . "</textarea>\n";
									$html .= "\t\t\t\t\t\t\t</div>\n";
								$html .= "\t\t\t\t\t\t</div>\n\n";

								// END JAPANESE
							
							$html .= "<hr />";
							
							$html .= "\t\t\t\t\t\t<div class=\"form-group\">\n";
								
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-12\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"submit\" name=\"jagaContentSubmit\" id=\"jagaContentSubmit\" class=\"btn btn-default jagaFormButton col-xs-8 col-sm-6 col-md-4 pull-right\" value=\"" . $type . "\">\n";
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

}

?>