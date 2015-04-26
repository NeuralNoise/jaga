<?php
class CommentView {
	
	public function displayCommentsView($object, $objectID) {

		$html = '';
		$commentArray = Comment::getComments($object, $objectID);
		
		foreach ($commentArray AS $commentKey => $commentID) {
			
			$comment = new Comment($commentID);
			$userID = $comment->userID;

			$user = new User($userID);
			$username = $user->username;
			$userDisplayName = urlencode($user->getUserDisplayName());
			
			$html .= "\n\t<!-- START COMMENT -->\n";
			$html .= "\t<div class=\"container\">\n\n";
				$html .= "\t\t<div class=\"panel panel-default\">\n";
					
					$html .= "\t\t\t<div class=\"panel-heading jagaCommentPanelHeading\">\n";
					
						$html.= "\t\t\t\t<div class=\"row\">\n";
						
							$html .= "\t\t\t\t\t<div class=\"col-md-6\">";
								$html .= "<b><a href=\"/u/" . $username . "/\">" . $userDisplayName . "</a></b> (<i>" . $comment->commentDateTime .= "</i>)";
							$html .= "</div>\n";
							
							$html .= "\t\t\t\t\t<div class=\"col-md-6\">";						
								if ($userID == $_SESSION['userID']) {
									$html .= "<a href=\"/k/comment/delete/" . $commentID . "/\" class=\"btn btn-default btn-xs pull-right\"><span class=\"glyphicon glyphicon-remove\" style=\"color:#f00;\"></span> DELETE</a>";
								}
							$html .= "</div>\n";
							
						$html .= "\t\t\t\t</div>\n";
						
					$html .= "\t\t\t</div>\n";
					
					$html .= "\t\t\t<div class=\"panel-body\">" . $comment->commentContent . "</div>\n";
					
				$html .= "\t\t</div>\n";
			$html .= "\n\t</div>\n";
			$html .= "\t<!-- END COMMENT -->\n\n";
			
		}
		
		return $html;
	
	}

	public function displayCommentForm($object, $objectID) {

		$html = "\n\n\t<!-- START CONTENT COMMENT FORM CONTAINER -->\n";
		$html .= "\t<div class=\"container\">\n\n";
		
			$html .= "\t\t<!-- START PANEL -->\n";
			$html .= "\t\t<div class=\"panel panel-default\" >\n\n";
				
				$html .= "\t\t\t<!-- START PANEL-HEADING -->\n";
				$html .= "\t\t\t<div class=\"panel-heading jagaContentPanelHeading\">\n\n";
					$html .= "\t\t\t\t<div class=\"panel-title\">" . strtoupper(Lang::getLang('comment')) . "</div>\n";
				$html .= "\t\t\t</div>\n";
				$html .= "\t\t\t<!-- END PANEL-HEADING -->\n\n";
					
				$html .= "\t\t\t<!-- START PANEL-BODY -->\n";
				$html .= "\t\t\t<div class=\"panel-body\">\n\n";
		
					if ($_SESSION['userID'] == 0) { 
					
						$html .= "\t\t\t\t\t\t<div class=\"row\">\n";
							$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-12\" style=\"margin-top:5px;\">\n";
								$html .= "\t\t\t\t\t\t\t\t<a href=\"/login/\" name=\"jagaLogin\" id=\"jagaLogin\" class=\"btn btn-default jagaFormButton col-xs-6 col-sm-4 col-md-3 col-lg-2 pull-right\">" . Lang::getLang('login') . "</a>\n";
								$html .= "\t\t\t\t\t\t\t\t<a href=\"/register/\" name=\"jagaRegister\" id=\"jagaRegister\" class=\"btn btn-default jagaFormButton col-xs-6 col-sm-4 col-md-3 col-lg-2 pull-right\">" . Lang::getLang('register') . "</a>\n";
							$html .= "\t\t\t\t\t\t\t</div>\n";
						$html .= "\t\t\t\t\t\t</div>";
						
					} else {

						$html .= "\t\t\t\t\t<!-- START jagaContentCommentForm -->\n";
						$html .= "\t\t\t\t\t<form role=\"form\" id=\"jagaContentCommentForm\" name=\"jagaContentCommentForm\" class=\"form-horizontal\"  method=\"post\" action=\"/k/comment/" . $objectID . "/\">\n\n";
					
							$html .= "<input type=\"hidden\" name=\"contentID\" value=\"" . $objectID . "\">\n";

							$html .= "\t\t\t\t\t\t<div class=\"row\">\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-12\">";
										$html .= "<textarea id=\"commentContent\" name=\"commentContent\" class=\"form-control\" placeholder=\"commentContent\"></textarea>";
								$html .= "</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n";

							$html .= "\t\t\t\t\t\t<div class=\"row\">\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-12\" style=\"margin-top:5px;\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"submit\" name=\"jagaContentCommentSubmit\" id=\"jagaContentCommentSubmit\" class=\"btn btn-default jagaFormButton col-xs-8 col-sm-6 col-md-4 pull-right\" value=\"" . Lang::getLang('submitComment') . "\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>";

						$html .= "\t\t\t\t\t</form>\n";
						$html .= "\t\t\t\t\t<!-- END jagaContentCommentForm -->\n\n";
		
					}

				$html .= "\t\t\t</div>\n";
				$html .= "\t\t\t<!-- END PANEL-BODY -->\n\n";
		
			$html .= "\t\t</div>\n";
			$html .= "\t\t<!-- END PANEL -->\n\n";

		$html .= "\t</div>\n";
		$html .= "\t<!-- END CONTENT COMMENT CONTAINER -->\n\n";
			
		return $html;

	}
	
}

?>