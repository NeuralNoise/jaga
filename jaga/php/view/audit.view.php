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
										$html .= "<th>Timestamp</th>";
										$html .= "<th>User</th>";
										$html .= "<th>Action</th>";
										$html .= "<th>Object</th>";
									$html .= "</tr>";
									
									foreach ($auditTrailArray AS $entry) {
										
										if ($entry['auditUserID'] != 0) {
											$user = new User($entry['auditUserID']);
											$username = $user->getUserDisplayName();
										} else { $username = 'System'; }
										
										$html .= "<tr>";
											$html .= "<td>" . $entry['auditDateTime'] . "</td>";
											$html .= "<td>" . $username . " (" . $entry['auditUserID'] . ")</td>";
											$html .= "<td>" . $entry['auditAction'] . "</td>";
											$html .= "<td>" . $entry['auditObject'] . " (" . $entry['auditObjectID'] . ")</td>";
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