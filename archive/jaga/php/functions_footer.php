<?php
	
function displayFooter() {

	if ($_SESSION['siteID'] == 63) {
	
		echo '</div>';
		echo '<hr />';
		echo '<div>';
				echo '<div style="float:left;text-align:left;margin:2px;">';
					if (!is_authed()) {
						echo'<form action="' . languageUrlPrefix() . 'login/" method="post" style="margin-bottom:0px;">';
							echo '<input type="text" size="20" maxlength="255" style="margin:1px;padding:1px;" name="userName" value="username" onfocus="if(this.value==\'username\')this.value=\'\'" />';
							echo '<input type="password" size="20" maxlength="255" style="margin:1px;padding:1px;" name="userPassword" value="password" onfocus="if(this.value==\'password\')this.value=\'\'" />';
							echo '<input type="submit" name="submit" value="' . agileResource('login') . '" />';
							// if (siteIsPublic()) {
								echo '<input type="button" value="' . agileResource('register') . '" onclick="window.location.href=\'' . languageUrlPrefix() . 'register/\'">';
							// }
						echo '</form>';
					}
				echo '</div>';
				echo '<div style="float:right;text-align:right;padding:1px 10px 3px 0px;">';
					echo getDateAndTimeThisLanguage();
					if (is_authed()) {
						echo '&nbsp;|&nbsp;';
						if ($_SESSION['testMode'] == 'on') {
							echo '<a href="/message.php?action=list" class="';			
								if (userHasMail($_SESSION['userID']) == 'yes') { echo 'agilePosRed'; } else { echo 'agilePosBlue'; }				
							echo '">' . agileResource('messages') . '</a>';
							echo '&nbsp;|&nbsp;';
						}
						echo getUserActualNameThisLanguage();
					}
				echo '</div>';
				echo '<div style="clear:both;"></div>';
			echo '</div>';
		echo '</div>'; // end nisekoContainer
		echo '<div id="nisekoFooter">';
		echo '<div style="padding:5px 10px 0px 0px;">';
			echo 'Powered by <a class="agileLinkage" href="http://NisekoCMS.com/' . languageUrlPrefix() . '">' . agileResource('nisekoCMS') . '</a> | &#169;&#160;' . date(Y)  . '&nbsp;';
			echo '<a class="agileLinkage" href="http://AgileHokkaido.com/' . languageUrlPrefix() . '">' . agileResource('Agile Hokkaido') . '</a>';
		echo '</div>';
		echo '</div>';
		
	} elseif ($_SESSION['siteID'] == 67) { // SeattleDataHosting.com
	
			echo '</div>'; // necessary?
			
			echo '<div>';
				echo '<div style="float:left;text-align:left;margin:2px;">';
				
				echo '</div>';
				echo '<div style="float:right;text-align:right;padding:1px 10px 3px 0px;">';
					echo getDateAndTimeThisLanguage();
					echo '&nbsp;|&nbsp;';
					if (is_authed()) {
						if ($_SESSION['testMode'] == 'on') {
							echo '<a href="/message.php?action=list" class="';			
								if (userHasMail($_SESSION['userID']) == 'yes') { echo 'agilePosRed'; } else { echo 'agilePosBlue'; }				
							echo '">' . agileResource('messages') . '</a>';
							echo '&nbsp;|&nbsp;';
						}
						echo getUserActualNameThisLanguage();
					} else {
						echo '<a class="agileLinkage" href="' . languageUrlPrefix() . 'login/">' . agileResource('Login') . '</a>';
					}
				echo '</div>';
				echo '<div style="clear:both;"></div>';
			echo '</div>';
			
		echo '</div>'; // end nisekoContainer
		
		echo '<div id="nisekoFooter">';
			echo '<div style="padding:5px 10px 0px 0px;">';
				echo '<a class="agileLinkage" href="' . languageUrlPrefix() . 'about/">'. agileResource('about') . '</a>';
					echo ' | ';
				echo '<a class="agileLinkage" href="' . languageUrlPrefix() . 'tos/">'. agileResource('termsOfService') . '</a>';
					echo ' | ';
				echo '<a class="agileLinkage" href="' . languageUrlPrefix() . 'privacy/">'. agileResource('privacyPolicy') . '</a>';
					echo ' | ';
				echo '<a class="agileLinkage" href="' . languageUrlPrefix() . 'sitemap/">'. agileResource('sitemap') . '</a>';
					echo ' | ';
				echo '<a class="agileLinkage" href="' . languageUrlPrefix() . 'contact/">'. agileResource('contact') . '</a>';
					echo ' | ';
				echo '&#169;&#160;' . date(Y)  . '&nbsp;<a class="agileLinkage" href="http://seattledatahosting.com/' . languageUrlPrefix() . '">' . agileResource('SeattleDataHosting') . '</a>';
			echo '</div>';
			
		echo '</div>';
		
	} else {
	
		echo '</div>'; // necessary?

		echo '<div>';
				echo '<div style="float:left;text-align:left;margin:2px;">';
				
				
				if ($_SESSION['siteID'] == 26) {
				
					if (!is_authed()) {
						echo'<form action="' . languageUrlPrefix() . 'login/" method="post" style="margin-bottom:0px;">';
							echo '<input type="text" size="20" maxlength="255" style="margin:1px;padding:1px;" name="userName" value="username" onfocus="if(this.value==\'username\')this.value=\'\'" />';
							echo '<input type="password" size="20" maxlength="255" style="margin:1px;padding:1px;" name="userPassword" value="password" onfocus="if(this.value==\'password\')this.value=\'\'" />';
							echo '<input type="submit" name="submit" value="' . agileResource('login') . '" />';
							if (siteIsPublic()) {
								echo '<input type="button" value="' . agileResource('register') . '" onclick="window.location.href=\'' . languageUrlPrefix() . 'register/\'">';
							}
						echo '</form>';
					}
		
				}
		
		
				echo '</div>';
				echo '<div style="float:right;text-align:right;padding:1px 10px 3px 0px;">';
					echo getDateAndTimeThisLanguage();
					if (is_authed()) {
						echo '&nbsp;|&nbsp;';
						
						if ($_SESSION['testMode'] == 'on') {
							echo '<a href="/message.php?action=list" class="';			
								if (userHasMail($_SESSION['userID']) == 'yes') { echo 'agilePosRed'; } else { echo 'agilePosBlue'; }				
							echo '">' . agileResource('messages') . '</a>';
							echo '&nbsp;|&nbsp;';
						}
						
						echo getUserActualNameThisLanguage();
					}
				echo '</div>';
				echo '<div style="clear:both;"></div>';
			echo '</div>';
		echo '</div>'; // end nisekoContainer
		
		echo '<div id="nisekoFooter">';
		echo '<div style="padding:10px 10px 0px 0px;">';
		
			// echo $_SESSION['forwardUponLogin'];
				// echo ' | ';
			echo '<a class="agileLinkage" href="' . languageUrlPrefix() . 'about/">'. agileResource('about') . '</a>';
				echo ' | ';
			echo '<a class="agileLinkage" href="' . languageUrlPrefix() . 'tos/">'. agileResource('termsOfService') . '</a>';
				echo ' | ';
			echo '<a class="agileLinkage" href="' . languageUrlPrefix() . 'privacy/">'. agileResource('privacyPolicy') . '</a>';
				echo ' | ';
			echo '<a class="agileLinkage" href="' . languageUrlPrefix() . 'advertise/">'. agileResource('advertise') . '</a>';
				echo ' | ';
			echo '<a class="agileLinkage" href="' . languageUrlPrefix() . 'sitemap/">'. agileResource('sitemap') . '</a>';
				echo ' | ';
			echo '<a class="agileLinkage" href="' . languageUrlPrefix() . 'contact/">'. agileResource('contact') . '</a>';
				echo ' | ';
			echo 'Powered by <a class="agileLinkage" href="http://NisekoCMS.com/' . languageUrlPrefix() . '">' . agileResource('nisekoCMS') . '</a>';
		echo '</div>';
		echo '</div>';
	}

			
	
	
	if ($_SESSION['testMode'] == 'on') {
		echo '<div style="clear:both;"></div>';
		echo '<div style="width:100%;border:1px solid #ccc;text-align:left;background-color:#ffffff;margin:10px;">';
			echo '<b>POST</b> <pre>';
				print_r($_POST);
			echo '</pre>';
			echo '<b>GET</b> <pre>';
				print_r($_GET);
			echo '</pre>';
			echo '<b>SESSION</b> <pre>';
				print_r($_SESSION);
			echo '</pre>';
		echo '</div>';
	}

	echo '</body>';
	echo '</html>';

}

?>