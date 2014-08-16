<?php
class CommentView {
	
	public function displayContentCommentsView($contentID) {

		$comments = Comment::getComments($contentID);

		$html = '';
		foreach ($comments AS $comment) {
		
			$username = User::getUsername($comment['userID']);
			
			$html .= "\n\t<!-- START COMMENT -->\n";
			$html .= "\t<div class=\"container\">\n\n";
				$html .= "\t\t<div class=\"panel panel-info\">\n";
					$html .= "\t\t\t<div class=\"panel-heading jagaCommentPanelHeading\">";
						$html .= "<h5 style=\"text-align:right;\">" . $username . " - " . $comment['commentDateTime'] .= "</h5>";
					$html .= "</div>\n";
					$html .= "\t\t\t<div class=\"panel-body\">\n";
						$html .= $comment['commentContent'];
					$html .= "\n\t\t\t</div>\n";
				$html .= "\t\t</div>\n";
			$html .= "\n\t</div>\n";
			$html .= "\t<!-- END COMMENT -->\n\n";
		}
		return $html;
	
	}

	public function displayContentCommentForm($contentID) {

		$html = "\n\t<!-- START CONTENT COMMENT FORM CONTAINER -->\n";
		$html .= "\t<div class=\"container\">\n\n";
		
			$html .= "\t\t\t<!-- START PANEL -->\n";
			$html .= "\t\t\t<div class=\"panel panel-default\" >\n\n";
				
				$html .= "\t\t\t\t<!-- START PANEL-HEADING -->\n";
				$html .= "\t\t\t\t<div class=\"panel-heading jagaContentPanelHeading\">\n\n";
					$html .= "\t\t\t\t\t<div class=\"panel-title\">COMMENT</div>\n";
				$html .= "\t\t\t\t</div>\n";
				$html .= "\t\t\t\t<!-- END PANEL-HEADING -->\n\n";
				
				$html .= "\t\t\t\t<!-- START PANEL-BODY -->\n";
				$html .= "\t\t\t\t<div class=\"panel-body\">\n\n";

					$html .= "\t\t\t\t\t<!-- START jagaContentCommentForm -->\n";
					
					$html .= "\t\t\t\t\t<form role=\"form\" id=\"jagaContentCommentForm\" name=\"jagaContentCommentForm\" class=\"form-horizontal\"  method=\"post\" action=\"/k/comment/" . $contentID . "/\">\n\n";
				
						$html .= "<input type=\"hidden\" name=\"contentID\" value=\"" . $contentID . "\">\n";

						$html .= "\t\t\t\t\t\t<div class=\"row\">\n";
							$html .= "<div class=\"col-sm-12\">";
									$html .= "\t\t\t\t\t\t\t\t<textarea id=\"contentComment\" name=\"contentComment\" class=\"form-control\" placeholder=\"contentComment\"></textarea>\n";
							$html .= "</div>";
						$html .= "</div>";

						// START SUBMIT BUTTON
						$html .= "\t\t\t\t\t\t<div class=\"row\">\n";
							$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-12\" style=\"margin-top:5px;\">\n";
								$html .= "\t\t\t\t\t\t\t\t<input type=\"submit\" name=\"jagaContentCommentSubmit\" id=\"jagaContentCommentSubmit\" class=\"btn btn-default jagaFormButton col-xs-8 col-sm-6 col-md-4 pull-right\" value=\"Submit Comment\">\n";
							$html .= "\t\t\t\t\t\t\t</div>\n";
						$html .= "</div>";
						// START SUBMIT BUTTON

					$html .= "\t\t\t\t\t</form>\n";
					$html .= "\t\t\t\t\t<!-- END jagaContentCommentForm -->\n\n";
		
				$html .= "\t\t\t\t</div>\n";
				$html .= "\t\t\t\t<!-- END PANEL-BODY -->\n\n";
		
			$html .= "\t\t\t</div>\n";
			$html .= "\t\t\t<!-- END PANEL -->\n\n";
			
		$html .= "\t</div>\n";
		$html .= "\t<!-- END CONTENT COMMENT CONTAINER -->\n\n";
			
		return $html;
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	}
	
}

?>