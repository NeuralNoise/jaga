<?php
class CommentView {
	
	function displayContentCommentsView($contentID) {
	
		$comments = Comment::getComments($contentID);
	
		$html = '';
		foreach ($comments AS $comment) {
			$html .= "\n\t<!-- START COMMENT -->\n";
			$html .= "\t<div class=\"container\">\n\n";
				$html .= "\t\t<div class=\"panel panel-info\">\n";
					$html .= "\t\t\t<div class=\"panel-heading jagaCommentPanelHeading\">";
						$html .= "<h5 style=\"text-align:right;\">" . $comment['userID'] . " - " . $comment['commentDateTime'] .= "</h5>";
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

}

?>