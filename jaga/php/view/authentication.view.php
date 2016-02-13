<?php

class AuthenticationView {

	public static function getAuthForm($type, $inputArray, $errorArray = array()) {

		if ($_SESSION['channelKey'] == 'www') {
			$formBaseURL = 'http://jaga.io/';
		} else {
			$formBaseURL = 'http://' . Channel::getChannelKey($_SESSION['channelID']) . '.jaga.io/';
		}
	
		$html = "\n\n\t<!-- START AUTH CONTAINER -->\n";
		$html .= "\t<div class=\"container\">\n\n";
		
		if ($type == 'login') {
	
			$html .= "\t\t<!-- START jagaLogin -->\n";
			$html .= "\t\t<div id=\"jagaLogin\" class=\"mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2\">\n\n";

				$html .= "\t\t\t<!-- START PANEL -->\n";
				$html .= "\t\t\t<div class=\"panel panel-default\" >\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-HEADING -->\n";
					$html .= "\t\t\t\t<div class=\"panel-heading\">\n\n";
						
						$html .= "\t\t\t\t\t<div class=\"panel-title\">" . strtoupper(Lang::getLang('login')) . "</div>\n";
					
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-HEADING -->\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-BODY -->\n";
					$html .= "\t\t\t\t<div style=\"padding-top:30px\" class=\"panel-body\">\n\n";

						
						$html .= "\t\t\t\t\t<!-- START jagaLoginForm -->\n";
						$html .= "\t\t\t\t\t<form role=\"form\" id=\"jagaLoginForm\" name=\"login\" class=\"form-horizontal\" method=\"post\" action=\"" . $formBaseURL . "login/\">\n\n";
					
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom:25px;\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"login-username\" type=\"text\" class=\"form-control";
									if (isset($errorArray['loginFailed'])) { $html .= " jagaFormValidationError"; }
								$html .= "\" name=\"username\" value=\"";
									if (isset($inputArray['username'])) { $html .= $inputArray['username']; }
								$html .= "\" placeholder=\"username or email\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom: 25px\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"login-password\" type=\"password\" class=\"form-control";
									if (isset($errorArray['loginFailed'])) { $html .= " jagaFormValidationError"; }
								$html .= "\" name=\"password\" placeholder=\"password\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";

							$html .= "\t\t\t\t\t\t<div style=\"margin-top:10px\" class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-12 controls\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"submit\" name=\"jagaLoginSubmit\" id=\"jagaLoginSubmit\" class=\"btn btn-default pull-right\" value=\"" . Lang::getLang('login') . "\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
			
							$html .= "\t\t\t\t\t\t\t<div class=\"col-md-12 control\" style=\"border-top:1px solid #888;\">\n";
								$html .= "\t\t\t\t\t\t\t\t<div style=\"padding-top:15px;font-size:85%;\" >
									" . Lang::getLang('dontHaveAnAccount') . " <a href=\"/register/\">" . Lang::getLang('registerFree') . "</a><br />
									" . Lang::getLang('forgetYourUsernameOrPassword') . " <a href=\"/account-recovery/\">" . Lang::getLang('accountRecovery') . "</a>
								</div>\n";
							$html .= "\t\t\t\t\t\t\t</div>\n";
			
						$html .= "\t\t\t\t\t</form>\n";
						$html .= "\t\t\t\t\t<!-- END jagaLoginForm -->\n\n";
			
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-BODY -->\n\n";
			
				$html .= "\t\t\t</div>\n";
				$html .= "\t\t\t<!-- END PANEL -->\n\n";
			
			$html .= "\t\t</div>\n";
			$html .= "\t\t<!-- END jagaLogin -->\n\n";
	
		}
		
		if ($type == 'register') {
			
			$obFussyCat = substr(str_shuffle(MD5(microtime())), 0, 10);
			$_SESSION['obFussyCat'] = $obFussyCat;
		
			$html .= "\t\t<!-- START jagaRegister -->\n";
			$html .= "\t\t<div id=\"jagaRegister\" class=\"mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2\">\n\n";
			
				$html .= "\t\t\t<!-- START PANEL -->\n";
				$html .= "\t\t\t<div class=\"panel panel-default\" >\n\n";
					

					$html .= "\t\t\t\t<!-- START PANEL-HEADING -->\n";
					$html .= "\t\t\t\t<div class=\"panel-heading\">\n\n";

						$html .= "\t\t\t\t\t<div class=\"panel-title\">" . strtoupper(Lang::getLang('register')) . "</div>\n";
						
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-HEADING -->\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-BODY -->\n";
					$html .= "\t\t\t\t<div class=\"panel-body\">\n\n";
					
						$html .= "\t\t\t\t\t<!-- START jagaRegisterForm -->\n";
						$html .= "\t\t\t\t\t<form name=\"jagaRegisterForm\" id=\"signupform\" class=\"form-horizontal\" role=\"form\" method=\"post\" action=\"" . $formBaseURL . "register/\">\n\n";
							
							$html .= "\t\t\t\t\t\t<input type=\"hidden\" name=\"" . $obFussyCat . "\" value=\"KNOW the LEDGE\">\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom:25px;\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"register-username\" type=\"text\" class=\"form-control";
									if (isset($errorArray['username'])) { $html .= " jagaFormValidationError"; }
								$html .= "\" name=\"username\" value=\"";
									if (isset($inputArray['username'])) { $html .= $inputArray['username']; }
								$html .= "\" placeholder=\"username\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom:25px;\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-envelope\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"register-email\" type=\"email\" class=\"form-control";
									if (isset($errorArray['userEmail'])) { $html .= " jagaFormValidationError"; }
								$html .= "\" name=\"userEmail\" value=\"";
									if (isset($inputArray['userEmail'])) { $html .= $inputArray['userEmail']; }
								$html .= "\" placeholder=\"email\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom: 25px\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"register-password\" type=\"password\" class=\"form-control";
									if (isset($errorArray['password'])) { $html .= " jagaFormValidationError"; }
								$html .= "\" name=\"password\" placeholder=\"password\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom: 25px\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"register-confirm-password\" type=\"password\" class=\"form-control";
									if (isset($errorArray['confirmPassword'])) { $html .= " jagaFormValidationError"; }
								$html .= "\" name=\"confirmPassword\" placeholder=\"confirm password\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom: 25px\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><img src=\"/jaga/lib/raptcha.php\"></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"raptcha\" type=\"text\" class=\"form-control";
									if (isset($errorArray['raptcha'])) { $html .= " jagaFormValidationError"; }
								$html .= "\" name=\"raptcha\" placeholder=\"Enter Code\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-top:10px\" class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-12 controls\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"submit\" name=\"jagaRegisterSubmit\" id=\"jagaRegisterSubmit\" class=\"btn btn-default pull-right\" value=\"" . Lang::getLang('register') . "\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";

						$html .= "\t\t\t\t\t</form>\n";
						$html .= "\t\t\t\t\t<!-- END jagaRegisterForm -->\n\n";
					
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-BODY -->\n\n";
					
				$html .= "\t\t\t\t</div>\n";
				$html .= "\t\t\t\t<!-- END PANEL -->\n\n";
			
			$html .= "\t\t</div>\n";
			$html .= "\t\t<!-- END jagaRegister -->\n\n";
		}
			
		$html .= "\t</div>\n";
		$html .= "\t<!-- END AUTH CONTAINER -->\n\n";
			
		return $html;
	
	}

	public static function accountRecoveryForm($inputArray = array(), $errorArray = array()) {
	
		$html = "\n\n\t<!-- START ACCOUNT RECOVERY CONTAINER -->\n";
		$html .= "\t<div class=\"container\">\n\n";
			
			$html .= "\t\t<!-- START jagaAccountRecovery -->\n";
			$html .= "\t\t<div id=\"jagaAccountRecovery\" class=\"mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2\">\n\n";

				$html .= "\t\t\t<!-- START PANEL -->\n";
				$html .= "\t\t\t<div class=\"panel panel-default\" >\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-HEADING -->\n";
					$html .= "\t\t\t\t<div class=\"panel-heading\">\n\n";
						$html .= "\t\t\t\t\t<div class=\"panel-title\">" . strtoupper(Lang::getLang('accountRecovery')) . "</div>\n";
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-HEADING -->\n\n";
						
					$html .= "\t\t\t\t<!-- START PANEL-BODY -->\n";
					$html .= "\t\t\t\t<div style=\"padding-top:30px\" class=\"panel-body\">\n\n";

						$html .= "\t\t\t\t\t<!-- START jagaAccountRecoveryForm -->\n";
						$html .= "\t\t\t\t\t<form role=\"form\" id=\"jagaAccountRecoveryForm\" name=\"login\" class=\"form-horizontal\" method=\"post\" action=\"/account-recovery/\">\n\n";
					
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom:25px;\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-envelope\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"userEmail\" type=\"email\" class=\"form-control";
									if (isset($errorArray['userEmail'])) { $html .= " jagaFormValidationError"; }
								$html .= "\" name=\"userEmail\" value=\"";
									if (isset($inputArray['userEmail'])) { $html .= $inputArray['userEmail']; }
								$html .= "\" placeholder=\"potato@example.com\" required>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";

							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom: 25px\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><img src=\"/jaga/lib/raptcha.php\"></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"raptcha\" type=\"text\" class=\"form-control";
									if (isset($errorArray['raptcha'])) { $html .= " jagaFormValidationError"; }
								$html .= "\" name=\"raptcha\" placeholder=\"" . Lang::getLang('enterCode') . "\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-top:10px\" class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-12 controls\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"submit\" name=\"jagaAccountRecoverySubmit\" id=\"jagaAccountRecoverySubmit\" class=\"btn btn-default pull-right\" value=\"" . Lang::getLang('getRecoveryMail') . "\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";

							$html .= "\t\t\t\t\t\t\t<div class=\"col-md-12 control\" style=\"border-top:1px solid #888;\">\n";
								$html .= "\t\t\t\t\t\t\t\t<div style=\"padding-top:15px; font-size:85%\" >" . Lang::getLang('dontHaveAnAccount') . " <a href=\"/register/\">" . Lang::getLang('registerFree') . "</a></div>\n";
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
		$html .= "\t<!-- END ACCOUNT RECOVERY CONTAINER -->\n\n";
			
		return $html;
		
	}
	
	public static function accountRecoveryMailConfirmation($userEmail = 'potato@example.com') {
	
		$html = "\n\n\t<!-- START RECOVERY MAIL CONFIRMATION CONTAINER -->\n";
		$html .= "\t<div class=\"container alert alert-success\">\n\n";
			$html .= "<b>An email has been sent to you containing <u>your username</u> and <u>a link to reset your password</u>.</b>";
			$html .= "<ul>";
				$html .= "<li>It can take a few minutes to receive your account recovery email.</li>";
				$html .= "<li>Please check your spam folder if you do not see the email in your inbox.</li>";
				$html .= "<li>Only your most recent account recovery email will work.</li>";
			$html .= "<ul>";
		$html .= "\n\n\t</div>\n";
		$html .= "\t<!-- END RECOVERY MAIL CONFIRMATION CONTAINER -->\n\n";
		
		return $html;
		
	}
	
	public static function resetPasswordForm($urlArray, $inputArray = array(), $errorArray = array()) {
	
		$html = "\n\n\t<!-- START RESET PASSWORD CONTAINER -->\n";
		$html .= "\t<div class=\"container\">\n\n";
			
			$html .= "\t\t<!-- START jagaResetPassword -->\n";
			$html .= "\t\t<div id=\"jagaResetPassword\" class=\"mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2\">\n\n";

				$html .= "\t\t\t<!-- START PANEL -->\n";
				$html .= "\t\t\t<div class=\"panel panel-default\" >\n\n";
					
					$html .= "\t\t\t\t<!-- START PANEL-HEADING -->\n";
					$html .= "\t\t\t\t<div class=\"panel-heading\">\n\n";
						$html .= "\t\t\t\t\t<div class=\"panel-title\">RESET PASSWORD</div>\n";
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-HEADING -->\n\n";
						
					$html .= "\t\t\t\t<!-- START PANEL-BODY -->\n";
					$html .= "\t\t\t\t<div style=\"padding-top:30px\" class=\"panel-body\">\n\n";

						$html .= "\t\t\t\t\t<!-- START jagaResetPasswordForm -->\n";
						$html .= "\t\t\t\t\t<form role=\"form\" id=\"jagaResetPasswordForm\" name=\"resetPassword\" class=\"form-horizontal\" method=\"post\" action=\"/reset-password/" . $urlArray[1] . "/\">\n\n";
						
							$html .= "\t\t\t\t\t\t<input type=\"hidden\" name=\"accountRecoveryMash\" value=\"" . $urlArray[1] . "\">\n\n";

							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom:25px;\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"username\" type=\"text\" class=\"form-control";
									if (isset($errorArray['username'])) { $html .= " jagaFormValidationError"; }
								$html .= "\" name=\"username\" value=\"";
									if (isset($inputArray['username'])) { $html .= $inputArray['username']; }
								$html .= "\" placeholder=\"username\" required>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom: 25px\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"register-password\" type=\"password\" class=\"form-control";
									if (isset($errorArray['password'])) { $html .= " jagaFormValidationError"; }
								$html .= "\" name=\"password\" placeholder=\"new password\" required>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom: 25px\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"register-confirm-password\" type=\"password\" class=\"form-control";
									if (isset($errorArray['password'])) { $html .= " jagaFormValidationError"; }
								$html .= "\" name=\"confirmPassword\" placeholder=\"confirm new password\" required>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-bottom: 25px\" class=\"input-group\">\n";
								$html .= "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><img src=\"/jaga/lib/raptcha.php\"></span>\n";
								$html .= "\t\t\t\t\t\t\t<input id=\"raptcha\" type=\"text\" class=\"form-control";
									if (isset($errorArray['raptcha'])) { $html .= " jagaFormValidationError"; }
								$html .= "\" name=\"raptcha\" placeholder=\"Enter Code\">\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";
							
							$html .= "\t\t\t\t\t\t<div style=\"margin-top:10px\" class=\"form-group\">\n";
								$html .= "\t\t\t\t\t\t\t<div class=\"col-sm-12 controls\">\n";
									$html .= "\t\t\t\t\t\t\t\t<input type=\"submit\" name=\"jagaResetPasswordSubmit\" id=\"jagaResetPasswordSubmit\" class=\"btn btn-default pull-right\" value=\"Reset Password\">\n";
								$html .= "\t\t\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t\t\t</div>\n\n";

						$html .= "\t\t\t\t\t</form>\n";
						$html .= "\t\t\t\t\t<!-- END jagaResetPasswordForm -->\n\n";
			
					$html .= "\t\t\t\t</div>\n";
					$html .= "\t\t\t\t<!-- END PANEL-BODY -->\n\n";
			
				$html .= "\t\t\t</div>\n";
				$html .= "\t\t\t<!-- END PANEL -->\n\n";
			
			$html .= "\t\t</div>\n";
			$html .= "\t\t<!-- END jagaResetPassword -->\n\n";
		
		$html .= "\t</div>\n";
		$html .= "\t<!-- END RESET PASSWORD CONTAINER -->\n\n";
			
		return $html;
		
	}

	public static function passwordResetConfirmation() {
	
		$html = "\n\n\t<!-- START RESET PASSWORD CONFIRMATION CONTAINER -->\n";
		$html .= "\t<div class=\"container alert alert-success text-center\">\n\n";
			if ($_SESSION['lang'] == 'ja') {
				$html .= "パスワードのリセットが出来ました。";
			} else {
				$html .= "You have successfully reset your password.";
			}
		$html .= "\n\n\t</div>\n";
		$html .= "\t<!-- END RESET PASSWORD CONFIRMATION CONTAINER -->\n\n";
		
		return $html;
		
	}
	
}

?>