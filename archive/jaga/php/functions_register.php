<?php

function displayRegistrationCrud(
	$userName = '', 
	$userEMail = '', 
	$userPassword = '', 
	$confirmUserPassword = '', 
	$clientPrimaryDomain = '', 
	$regError = array()
) {

	echo '<div style="text-align:center;">';
		
	foreach ($regError as $value) { echo agileResource($value) . '<br />'; }
	
	echo '<form action="' . languageUrlPrefix() . 'register/" method="post" />';
	
		if ($_SESSION['siteID'] != 67) { echo '<input type="hidden" name="clientPrimaryDomain" value="">'; }
	
		echo '<table style="background-color:#fff;border:1px solid #ccc;margin:5px auto 5px auto;">';
		
				echo '<tr>';
					if (in_array('nisekopass', $_SESSION['siteModuleArray'])) {
						echo '<td class="borderAlignCenter" rowspan="6">';
							echo '<a href="http://nisekopass.com/' . languageUrlPrefix() . '" target="_blank">';
								echo '<img src="/agileImages/NisekoPass-Card.png" style="height:150px;">';
							echo '</a>';
						echo '</td>';
					}
					echo '<td class="borderAlignLeft">' . agileResource('username') . '</td>';
					echo '<td class="borderAlignCenter">';
						echo '<input type="text" ';
							if (in_array('usernameContainsAnIllegalCharacter', $regError) || in_array('usernameIsAlreadyInUse', $regError)) { echo 'style="background-color:#F9CCCA;" '; }
						echo 'size="20" maxlength="20" name="userName" value="' . $userName . '" />';
					echo '</td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="borderAlignLeft">' . agileResource('email') . '</td>';
					echo '<td>';
						echo '<input type="text" ';
							if (in_array('emailIsNotFormattedCorrectly', $regError) || in_array('emailIsAlreadyInUse', $regError)) { echo 'style="background-color:#F9CCCA;" '; }
						echo 'size="20" maxlength="255" name="userEMail" value="' . $userEMail . '" />';
					echo '</td>';
				echo '</tr>';
	
				echo '<tr>';
					echo '<td class="borderAlignLeft">' . agileResource('password') . '</td>';
					echo '<td class="borderAlignCenter">';
						echo '<input type="password" ';
							if (in_array('passwordsDoNotMatch', $regError)) { echo 'style="background-color:#F9CCCA;" '; }
						echo 'size="20" maxlength="20" name="userPassword" />';
					echo '</td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="borderAlignLeft">' . agileResource('confirmPassword') . '</td>';
					echo '<td class="borderAlignCenter">';
						echo '<input type="password" ';
							if (in_array('passwordsDoNotMatch', $regError)) { echo 'style="background-color:#F9CCCA;" '; }
						echo 'size="20" maxlength="20" name="confirmUserPassword" />';
					echo '</td>';
				echo '</tr>';
				
				if ($_SESSION['siteID'] == 67) {
					echo '<tr>';
						echo '<td class="borderAlignLeft">' . agileResource('clientPrimaryDomain') . '</td>';
						echo '<td class="borderAlignCenter">';
							echo '<input type="text" ';
								
								// if (in_array('passwordsDoNotMatch', $regError)) { echo 'style="background-color:#F9CCCA;" '; }
							echo 'size="20" maxlength="255" name="clientPrimaryDomain" />';
						echo '</td>';
					echo '</tr>';
				}

				echo '<tr>';
					echo '<td class="borderAlignLeft"><img src="/agileModules/nisekocmsCore/view/nisekocms_captcha.php"></td>';
					echo '<td class="borderAlignCenter">';
						echo '<input type="text" ';
							if (in_array('codeWasEnteredIncorrectly', $regError)) { echo 'style="background-color:#F9CCCA;" '; }
						echo 'size="20" maxlength="20" name="agileCaptcha" />';
					echo '</td>';
				echo '</tr>';
	
				echo '<tr>';
					echo '<td class="borderAlignRight" colspan="2">';
						echo '<input type="submit" name="submit" value="' . agileResource('register') . '" />';
					echo '</td>';
				echo '</tr>';

			echo '</table>';
		echo '</form>';
	echo '</div>';

}









?>