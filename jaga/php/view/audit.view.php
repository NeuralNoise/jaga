<?php

class AuditView {

	public static function auditTrailList() {

		if (!in_array($_SESSION['userID'],Config::read('admin.userIdArray'))) { die('y u no admin?!'); }
	
		$auditTrailArray = Audit::getAuditTrailArray();
	
		$html = "\n\n\t<!-- START AUTH CONTAINER -->\n";
		$html .= "\t<div class=\"container\">\n\n";
		
			$html .= "\t<!-- START ROW -->\n";
			$html .= "\t<div class=\"row\">\n\n";

				$html .= "\t\t<!-- START jagaAuditTrail -->\n";
				$html .= "\t\t<div id=\"jagaAuditTrail\" class=\"col-xs-12\">\n\n";

					$html .= "\t\t\t<!-- START PANEL -->\n";
					$html .= "\t\t\t<div class=\"panel panel-default\" >\n\n";
						
						$html .= "\t\t\t\t<!-- START PANEL-HEADING -->\n";
						$html .= "\t\t\t\t<div class=\"panel-heading\">\n\n";
							
							$html .= "\t\t\t\t\t<div class=\"panel-title\">" . strtoupper(Lang::getLang('auditTrail')) . "</div>\n";
						
						$html .= "\t\t\t\t</div>\n";
						$html .= "\t\t\t\t<!-- END PANEL-HEADING -->\n\n";
						
						$html .= "\t\t\t\t<!-- START PANEL-BODY -->\n";
						$html .= "\t\t\t\t<div class=\"panel-body\">\n\n";
							
							$html .= "<div class=\"table-responsive\">";
							
								$html .= "<table class=\"table table-striped table-condensed\">";
								
									$html .= "<tr>";
										$html .= "<th>User</th>";
										
										$html .= "<th>IP</th>";
										$html .= "<th>Action</th>";
										$html .= "<th>Object</th>";
										$html .= "<th>Timestamp</th>";
									$html .= "</tr>";
									
									foreach ($auditTrailArray AS $entry) {
										
										$auditID = $entry['auditID'];
										$auditUserID = $entry['auditUserID'];
										$auditDateTime = date('M jS g:i',strtotime($entry['auditDateTime']));
										$auditIP = $entry['auditIP'];
										$auditObject = $entry['auditObject'];
										$auditObjectID = $entry['auditObjectID'];
										$auditAction =  $entry['auditAction'];
										
										if ($auditUserID != 0) {
											$user = new User($auditUserID);
											$username = $user->getUserDisplayName();
											$iUser = "<a href=\"/u/" . urlencode($username) . "/\">" . $username . "</a> (" . $auditUserID . ")";
											if ($user->userBlackList) { $iUser = "<del>" . $iUser . "</del>"; }
											if ($user->userShadowBan) { $iUser = $iUser . " <span class=\"glyphicon glyphicon-ban-circle\"></span>"; }
										} else {
											$iUser = 'System';
										}

										if ($auditObject == 'Content' && Content::contentExists($auditObjectID)) {
											$content = new Content($auditObjectID);
											$contentURL = $content->getURL();
											$contentTitle = $content->getTitle();
											$channelID = $content->channelID;
											$channel = new Channel($channelID);
											$channelKey = $channel->channelKey;
											$iObject = "<a href=\"http://" . $channelKey . ".jaga.io" . $contentURL . "\">" . $contentTitle . "</a>";
										} else {
											$iObject = $auditObject . " (" . $auditObjectID . ")";
										}
										
										$html .= "<tr>";
											$html .= "<td>" . $iUser . "</td>";
											$html .= "<td><a href=\"https://freegeoip.net/xml/" . $auditIP . "\" target=\"freegeoip\">" . $auditIP . "</a><span id=\"audit" . $auditID . "\" class=\"auditCountry\"></span></td>";
											$html .= "<td>" . $auditAction . "</td>";
											$html .= "<td>" . $iObject . "</td>";
											$html .= "<td><span style=\"white-space:nowrap;\">" . $auditDateTime . "</span></td>";
										$html .= "</tr>";
										
									}
								
								$html .= "</table>";
							
							$html .= "</div>";

						$html .= "\t\t\t\t</div>\n";
						$html .= "\t\t\t\t<!-- END PANEL-BODY -->\n\n";
						
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL -->\n\n";
				
				$html .= "\t\t</div>\n";
				$html .= "\t\t<!-- END jagaAuditTrail -->\n\n";

			$html .= "\t</div>\n";
			$html .= "\t<!-- END ROW -->\n\n";
		
		$html .= "\t</div>\n";
		$html .= "\t<!-- END AUTH CONTAINER -->\n\n";
			
		return $html;
	
	}

}

?>