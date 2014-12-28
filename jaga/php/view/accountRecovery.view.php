<?php

class AccountRecoveryView {

	public static function accountRecoveryForm($inputArray = array(), $errorArray = array()) {
	
		$html = "\n\n\t<!-- START AUTH CONTAINER -->\n";
		$html .= "\t<div class=\"container\">\n\n";
			
			$html = "\t\t<!-- START jagaAccountRecovery -->\n";
			$html .= "\t\t<div id=\"jagaAccountRecovery\" class=\"mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2\">\n\n";

				$html .= "\t\t\t<!-- START PANEL -->\n";
				$html .= "\t\t\t<div class=\"panel panel-default\" >\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-HEADING -->\n";
					$html .= "\t\t\t\t<div class=\"panel-heading\">\n\n";
						$html .= "\t\t\t\t\t<div class=\"panel-title\">ACCOUNT RECOVERY</div>\n";
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-HEADING -->\n\n";
						
					$html .= "\t\t\t\t<!-- START PANEL-BODY -->\n";
					$html .= "\t\t\t\t<div style=\"padding-top:30px\" class=\"panel-body\">\n\n";

						$html .= "\t\t\t\t\t<!-- START jagaAccountRecoveryForm -->\n";
						$html .= "\t\t\t\t\t<form role=\"form\" id=\"jagaAccountRecoveryForm\" name=\"login\" class=\"form-horizontal\" method=\"post\" action=\"/account-recovery/\">\n\n";
					
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom:25px;\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-envelope\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"userEmail\" type=\"email\" class=\"form-control";
									if (isset($errorArray['loginFailed'])) { $html .= " jagaFormValidationError"; }
								$html .= "\" name=\"userEmail\" value=\"";
									if (isset($inputArray['userEmail'])) { $html .= $inputArray['userEmail']; }
								$html .= "\" placeholder=\"potato@example.com\" required>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";

							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom: 25px\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><img src=\"/jaga/library/raptcha.php\"></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"raptcha\" type=\"text\" class=\"form-control";
									if (isset($errorArray['raptcha'])) { $html .= " jagaFormValidationError"; }
								$html .= "\" name=\"raptcha\" placeholder=\"Enter Code\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-top:10px\" class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-12 controls\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"submit\" name=\"jagaAccountRecoverySubmit\" id=\"jagaAccountRecoverySubmit\" class=\"btn btn-default pull-right\" value=\"Get Recovery Email\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";

							$html .= "\t\t\t\t\t\t\t<div class=\"col-md-12 control\" style=\"border-top:1px solid #888;\">\n";
								$html .= "\t\t\t\t\t\t\t\t<div style=\"padding-top:15px; font-size:85%\" >Don't have a Kutchannel account? <a href=\"/register/\">Register (FREE)</a></div>\n";
							$html .= "\t\t\t\t\t\t\t</div>\n";
			
						$html .= "\t\t\t\t\t</form>\n";
						$html .= "\t\t\t\t\t<!-- END jagaAccountRecoveryForm -->\n\n";
			
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-BODY -->\n\n";
			
				$html .= "\t\t\t</div>\n";
				$html .= "\t\t\t<!-- END PANEL -->\n\n";
			
			$html .= "\t\t</div>\n";
			$html .= "\t\t<!-- END jagaAccountRecovery -->\n\n";
		
		$html .= "\t</div>\n";
		$html .= "\t<!-- END AUTH CONTAINER -->\n\n";
			
		return $html;
		
	}
	
	public static function accountRecoveryMailConfirmation($userEmail = 'potato@example.com') {
	
		$html = "\n\n\t<!-- START RECOVERY MAIL CONFIRMATION CONTAINER -->\n";
		$html .= "\t<div class=\"container\">\n\n";
			$html .= "Thank you. <b>An email has been sent to $userEmail</b> containing your <u>username</u> and <u>a link to reset your password</u>.";
			$html .= "<ul>";
				$html .= "<li>It can take a few minutes to recieve your acount recovery email.</li>";
				$html .= "<li>If you do not see the email in your inbox, please check your spam folder.</li>";
				$html .= "<li>If you submit this form multiple times, only the most recent password recovery email will work.</li>";
			$html .= "<ul>";
		$html .= "\n\n\t</div>\n";
		$html .= "\t<!-- END RECOVERY MAIL CONFIRMATION CONTAINER -->\n\n";
		
		return $html;
		
	}
	
}

?>