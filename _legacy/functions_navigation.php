<?php

function displayMenu($menuType = 'site') {

	$currentURL = urldecode(preg_replace('/^%2F(en%2F|ja%2F)?/', '', urlencode($_SERVER['REQUEST_URI']), 1));

	$startDate = date('Y-m-01');
	$endDate = date('Y-m-t');

	if ($menuType == 'site') {

		if ($_SESSION['siteID'] == 1) { // NisekoPass.com

			displayNewKutchannelMenu();
			
		} elseif ($_SESSION['siteID'] == 2) { // NisekoHokkaido.com

			displayNewKutchannelMenu();

		} elseif ($_SESSION['siteID'] == 3) { // niseko.us

			/*
			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
					echo '<ul>';
						echo '<li><a href="/' . languageUrlPrefix() . '">' . agileResource('home') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'shorten-a-url/">' . agileResource('shortenAUrl') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'urls/">' . agileResource('browseLinks') . '</a></li>';
						if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') { getManagerMenu(); }
						echo '<li><a href="' . languageUrlPrefix() . 'contact/">' . agileResource('contact') . '</a></li>';
						if (is_authed()) { echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>'; }
					echo '</ul>';
					if (!is_authed()) { echo '<div style="float:left;margin:3px;"><g:plusone></g:plusone></div>'; }
					echo '<br style="clear: left" />';
			echo '</div>';
			*/
			displayNewKutchannelMenu();

		} elseif ($_SESSION['siteID'] == 4) { // nisekonews.net

			displayNewKutchannelMenu();

		} elseif ($_SESSION['siteID'] == 5) { // nisekoproperty.net

			displayNewKutchannelMenu();

		} elseif ($_SESSION['siteID'] == 6) { // nisekorestaurants.com

			displayNewKutchannelMenu();

		} elseif ($_SESSION['siteID'] == 7) { // NisekoBars.com

			displayNewKutchannelMenu();

		} elseif ($_SESSION['siteID'] == 8) { // NisekoAccommodation.net

			displayNewKutchannelMenu();

		} elseif ($_SESSION['siteID'] == 9) { // NisekoShopping.com

			displayNewKutchannelMenu();

		} elseif ($_SESSION['siteID'] == 10) { // NisekoCalendar.com

			displayNewKutchannelMenu();

		} elseif ($_SESSION['siteID'] == 11) { // NisekoSnowForecast.com

			displayNewKutchannelMenu();
			
		} elseif ($_SESSION['siteID'] == 12) { // NisekoSnowReport.com

			displayNewKutchannelMenu();

		} elseif ($_SESSION['siteID'] == 13) { // nisekoweb.com

			displayNewKutchannelMenu();

		} elseif ($_SESSION['siteID'] == 14) { // niseko.kutchannel.net

			displayNewKutchannelMenu();

		} elseif ($_SESSION['siteID'] == 15) { // NisekoGolf.info

			displayNewKutchannelMenu();

		} elseif ($_SESSION['siteID'] == 16) { // nisekofirstsnow.com

			displayNewKutchannelMenu();
			
			/*
			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
					
					echo '<ul>';
						echo '<li><a href="/' . languageUrlPrefix() . '">' . agileResource('home') . '</a></li>';
						
						echo '<li><a href="http://nisekopass.com/' . languageUrlPrefix() . '" target="_blank">' . agileResource('nisekoPass') . '</a></li>';
						echo '<li><a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . '" target="_blank">' . agileResource('theKutchannel') . '</a></li>';
						echo '<li><a href="http://agilehokkaido.com/' . languageUrlPrefix() . '" target="_blank">' . agileResource('agileHokkaido') . '</a></li>';
						echo '<li><a href="http://niseko.us/be" target="_blank">' . agileResource('theBarn') . '</a></li>';
						
						if (is_authed()) {
							echo '<li><a href="' . languageUrlPrefix() . 'user/update/' . $_SESSION['userID'] . '/">' . agileResource('profile') . '</a></li>';
						}
						
						if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') { getManagerMenu(); }
						echo '<li>';
						if ($_SESSION['lang'] == 'en') { echo '<a href="ja/' . $currentURL . '">日本語</a>'; } else { echo '<a href="' . $currentURL . '">English</a>'; }
						echo '</li>';
						
						if (is_authed()) {
							echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>';
						}
						
					echo '</ul>';
					
					
					echo '<div style="float:left;margin:3px;">';
						echo '<a href="' . getSiteUrl() . '/rss/"><img src="agileImages/rss-24x24y.png"></a> ';
						echo '<a href="http://twitter.com/kutchannel"><img src="agileImages/twitter-24x24y.png"></a> ';
						echo '<a href="http://facebook.com/kutchannel"><img src="agileImages/facebook.png"></a> ';
						echo '<g:plusone></g:plusone>';
					echo '</div>';
					
					
					echo '<br style="clear:left;" />';
					echo '</div>';
					
				*/

























		} elseif ($_SESSION['siteID'] == 17) { // nisekoavalanche.info

			displayNewKutchannelMenu();

		} elseif ($_SESSION['siteID'] == 18) { // nisekojobs.com

			displayNewKutchannelMenu();

		} elseif ($_SESSION['siteID'] == 19) { // NisekoMagazine.com

			displayNewKutchannelMenu();
			
		} elseif ($_SESSION['siteID'] == 20) { // NisekoDelivery.com

			displayNewKutchannelMenu();

		} elseif ($_SESSION['siteID'] == 21) { // hakodateguide.com

				echo '<div id="smoothmenu1" class="ddsmoothmenu">';
					echo '<ul>';
					
						echo '<li><a href="/' . languageUrlPrefix() . '">' . agileResource('hakodate') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'experience/history/">' . agileResource('history') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'experience/geography-and-climate/">' . agileResource('geography') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'experience/sightseeing-and-tourism/">' . agileResource('sightseeing') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'experience/accommodation/">' . agileResource('accommodation') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'experience/food-and-drink/">' . agileResource('food-and-drink') . '</a></li>';
						
						echo '<li>';
							echo '<a href="';
								if (getSiteURL() != 'http://HakodateGuide.com/') { echo 'http://HakodateGuide.com/'; } else { echo '/'; }
								echo languageUrlPrefix();
							echo 'experience/shopping/">';
								echo agileResource('shopping');
							echo '</a>';
						echo '</li>';
						
						echo '<li>';
							echo '<a href="';
								if (getSiteURL() != 'http://HakodateGuide.com/') { echo 'http://HakodateGuide.com/'; } else { echo '/'; }
								echo languageUrlPrefix();
							echo 'experience/living/">';
								echo agileResource('living');
							echo '</a>';
						echo '</li>';
						
						echo '<li>';
							echo '<a href="';
								if (getSiteURL() != 'http://HakodateGuide.com/') { echo 'http://HakodateGuide.com/'; } else { echo '/'; }
								echo languageUrlPrefix();
							echo 'experience/notes/">';
								echo agileResource('supplementalNotes');
							echo '</a>';
						echo '</li>';
						/*
						echo '<li>';
							echo '<a href="';
								if (getSiteURL() != 'http://HakodateGuide.com/') { echo 'http://HakodateGuide.com/'; } else { echo '/'; }
								echo languageUrlPrefix();
							echo 'experience/author/">';
								echo agileResource('author');
							echo '</a>';
						echo '</li>';
						*/
						if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') { getManagerMenu(); }
					echo '</ul>';
					
					
					echo '<div style="float:left;margin:3px;">';
						echo '<a href="' . getSiteUrl() . '/rss/"><img src="agileImages/rss-24x24y.png"></a> ';
						echo '<a href="http://twitter.com/hakodateguide"><img src="agileImages/twitter-24x24y.png"></a> ';
						echo '<a href="http://facebook.com/hakodate"><img src="agileImages/facebook.png"></a> ';
						echo '<g:plusone></g:plusone>';
					echo '</div>';
					
					
					echo '<br style="clear:left;" />';
					echo '</div>';

		} elseif ($_SESSION['siteID'] == 22) { // agilehokkaido.com

			echo '<div id="smoothmenu1" class="ddsmoothmenu">';

			echo '<ul>';
				
				echo '<li><a href="/">' . agileResource('home') . '</a></li>';
				
				echo '<li><a href="http://nisekopass.com/' . languageUrlPrefix() . '">' . agileResource('projects') . '</a>';
					echo '<ul>';
						echo '<li><a href="http://nisekopass.com/' . languageUrlPrefix() . '">' . agileResource('nisekoPass') . '</a></li>';
						echo '<li><a href="http://nisekocms.com/' . languageUrlPrefix() . '">' . agileResource('nisekocms') . '</a></li>';
						echo '<li><a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . '">' . agileResource('theKutchannel') . '</a></li>';
					echo '</ul>';
				echo '</li>';
				
				echo '<li><a href="http://seattledatahosting.com/' . languageUrlPrefix() . '">' . agileResource('partners') . '</a>';
					echo '<ul>';
						echo '<li><a href="http://seattledatahosting.com/' . languageUrlPrefix() . '">' . agileResource('SeattleDataHosting') . '</a></li>';
						echo '<li><a href="http://zenidev.com/' . languageUrlPrefix() . '">' . agileResource('zenidev') . '</a></li>';
						echo '<li><a href="http://solanasystems.com/solana/partners.vm">' . agileResource('solanaSystems') . '</a></li>';
					echo '</ul>';
				echo '</li>';
				if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') { getManagerMenu(); }
				echo '<li><a href="' . languageUrlPrefix() . 'contact/">' . agileResource('contact') . '</a></li>';
				
				if (is_authed()) { echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>'; }
			
			echo '</ul>';
			
			echo '<div style="float:left;margin:3px;">';
				echo '<a href="' . getSiteUrl() . '/rss/"><img src="agileImages/rss-24x24y.png"></a> ';
				echo '<a href="http://twitter.com/agilehokkaido"><img src="agileImages/twitter-24x24y.png"></a> ';
				echo '<a href="http://facebook.com/agilehokkaido"><img src="agileImages/facebook.png"></a> ';
				echo '<a href="http://www.linkedin.com/company/agile-hokkaido/"><img src="agileImages/linkedin.png"></a> ';
				echo '<g:plusone></g:plusone>';
			echo '</div>';
			
			echo '<br style="clear: left" />';
			echo '</div>';

		} elseif ($_SESSION['siteID'] == 23) { // nisekocms.com

			displayNewKutchannelMenu();
			/*
			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
				echo '<ul>';
						echo '<li><a href="/' . languageUrlPrefix() . '">' . agileResource('home') . '</a></li>';
						// if (!is_authed()) { echo '<li><a href="' . languageUrlPrefix() . 'register/">' . agileResource('freeRegistration') . '</a></li>'; }
						echo '<li><a href="' . languageUrlPrefix() . 'advertise/">' . agileResource('nisekoCmsDeployments') . '</a>';
							echo '<ul>';
								$result = mysql_query("SELECT * FROM nisekocms_site WHERE siteIsReadyToRoll = 1 AND siteIsPublic = 1 AND siteNetwork = 'nisekopass' AND siteID != '$_SESSION[siteID]' ORDER BY pagesServed DESC LIMIT 12");
								while($row = mysql_fetch_array($result)) {
									echo '<li><a href="' . getSiteURLWithID($row['siteID']) . '/' . languageUrlPrefix() . '">' . getSiteTitleWithID($row['siteID']) . '</a></li>';
								}
								echo '<li><a href="' . languageUrlPrefix() . 'advertise/">' . agileResource('andMore') . '</a></li>';
							echo '</ul>';
						echo '</li>';
						echo '<li><a href="' . languageUrlPrefix() . 'contact/">' . agileResource('tryNisekoCMS') . '</a></li>';
						echo '<li>';
								if ($_SESSION['lang'] == 'en') {
									echo '<a href="ja/' . $currentURL . '">日本語</a>';
								} else {
									echo '<a href="' . $currentURL . '">English</a>';
								}
						echo '</li>';
						if (is_authed()) { echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>'; }
				echo '</ul>';

				echo '<div style="float:left;margin:3px;">';
					echo '<a href="' . getSiteUrl() . '/rss/"><img src="agileImages/rss-24x24y.png"></a> ';
					echo '<a href="http://twitter.com/nisekocms"><img src="agileImages/twitter-24x24y.png"></a> ';
					echo '<a href="http://facebook.com/nisekocms"><img src="agileImages/facebook.png"></a> ';
					echo '<a href="http://www.linkedin.com/company/nisekocms/"><img src="agileImages/linkedin.png"></a> ';
					echo '<g:plusone></g:plusone>';
				echo '</div>';
						
				echo '<br style="clear: left" />';
			echo '</div>';
			
			*/
			
		} elseif ($_SESSION['siteID'] == 24) { // nightlife.nisekobars.com

			displayNewKutchannelMenu();
			
		} elseif ($_SESSION['siteID'] == 25) { // agilekarada.com

			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
			echo '<ul>';
			
				echo '<li><a href="/' . languageUrlPrefix() . '">' . agileResource('home') . '</a></li>';
				echo '<li><a href="' . languageUrlPrefix() . 'run/">' . agileResource('run') . '</a></li>';
				echo '<li><a href="' . languageUrlPrefix() . 'workout/">' . agileResource('workout') . '</a></li>';
				echo '<li><a href="' . languageUrlPrefix() . 'intake/">' . agileResource('intake') . '</a></li>';
				echo '<li><a href="' . languageUrlPrefix() . 'weight/">' . agileResource('weight') . '</a></li>';
				if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') { getManagerMenu(); }
				echo '<li><a href="' . languageUrlPrefix() . 'contact/">' . agileResource('contact') . '</a></li>';		
			echo '</ul>';
			
			
				echo '<div style="float:left;margin:3px;">';
					echo '<a href="' . getSiteUrl() . '/rss/"><img src="agileImages/rss-24x24y.png"></a> ';
					echo '<a href="http://twitter.com/agilehokkaido"><img src="agileImages/twitter-24x24y.png"></a> ';
					echo '<a href="http://facebook.com/agilehokkaido"><img src="agileImages/facebook.png"></a> ';
					echo '<g:plusone></g:plusone>';
				echo '</div>';
			echo '<br style="clear:left;" />';
			echo '</div>';

		} elseif ($_SESSION['siteID'] == 26) { // preciousbox.agilehokkaido.com

			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
				echo '<ul>';
						echo '<li><a href="/' . languageUrlPrefix() . '">' . agileResource('home') . '</a></li>';
						if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') {
							echo '<li><a href="' . languageUrlPrefix() . 'store/">' . agileResource('shop') . '</a></li>';
						}
						echo '<li><a href="' . languageUrlPrefix() . 'blog/">' . agileResource('blog') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'recipes/">' . agileResource('recipes') . '</a></li>';
						if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') { getManagerMenu(); }
						if (is_authed()) { echo '<li><a href="' . languageUrlPrefix() . 'profile/' . $_SESSION['userID'] . '/">' . agileResource('profile') . '</a></li>'; }
						if (is_authed()) { echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>'; }
					echo '</ul>';
					echo '<br style="clear:left;" />';
				echo '</div>';

		} elseif ($_SESSION['siteID'] == 27) { // wine.nisekoshopping.com

			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
						
				echo '<ul>';
					echo '<li><a href="/' . languageUrlPrefix() . '">' . agileResource('home') . '</a></li>';
					echo '<li><a href="' . languageUrlPrefix() . 'store/">' . agileResource('store') . '</a></li>';
					if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') { getManagerMenu(); }
				echo '</ul>';
						
				echo '<br style="clear:left;" />';
						
			echo '</div>';

		} elseif ($_SESSION['siteID'] == 28) { // agileeikaiwa.com

			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
					echo '<ul>';
					
							echo '<li>';
								echo '<a href="';
									echo '/' . languageUrlPrefix();
								echo '">';
									echo agileResource('home');
								echo '</a>';
							echo '</li>';
							
							/*
							echo '<li><a href="';
									echo languageUrlPrefix() . 'forum/">' . agileResource('conversation') . '</a>';
							echo '</li>';
							*/
							
							
							
							echo '<li><a href="';
									echo languageUrlPrefix() . 'blog/">' . agileResource('blog') . '</a>';
							echo '</li>';
							
							if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') {
								echo '<li><a href="';
									echo languageUrlPrefix() . 'courses/">' . agileResource('courses') . '</a>';
										if (isSiteManager()) {
											echo '<ul>';
												echo '<li><a href="' . languageUrlPrefix() . 'courses/enrollment/">' . agileResource('courseEnrollment') . '</a></li>';
												echo '<li><a href="' . languageUrlPrefix() . 'courses/attendance/">' . agileResource('courseAttendance') . '</a></li>';
											echo '</ul>';
										}
								echo '</li>';
								echo '<li><a href="';
									echo languageUrlPrefix() . 'assignments/">' . agileResource('assignments') . '</a>';
								echo '</li>';
								echo '<li><a href="';
									echo languageUrlPrefix() . 'tests/">' . agileResource('tests') . '</a>';
								echo '</li>';
								echo '<li><a href="';
									echo languageUrlPrefix() . 'grades/">' . agileResource('grades') . '</a>';
								echo '</li>';
								echo '<li><a href="';
									echo languageUrlPrefix() . 'reference/">' . agileResource('reference') . '</a>';
								echo '</li>';
								
								echo '<li><a href="';
									echo languageUrlPrefix() . 'classes/">' . agileResource('classes') . '</a>';
								echo '</li>';
								
							}
							
							if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') { getManagerMenu(); }
							echo '<li><a href="' . languageUrlPrefix() . 'contact/">' . agileResource('contact') . '</a></li>';
						
						if (is_authed()) { echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>'; }
						
					echo '</ul>';
					echo '<div style="float:left;margin:3px;">';
							echo '<a href="' . getSiteUrl() . '/rss/"><img src="agileImages/rss-24x24y.png"></a> ';
							echo '<a href="http://twitter.com/agileeikaiwa"><img src="agileImages/twitter-24x24y.png"></a> ';
							echo '<g:plusone></g:plusone>';
						echo '</div>';
					echo '<br style="clear: left" />';
					echo '</div>';

		} elseif ($_SESSION['siteID'] == 29) { // beatbox.jp

			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
					echo '<ul>';
					
							echo '<li>';
								echo '<a href="';
									echo '/' . languageUrlPrefix();
								echo '">';
									echo agileResource('cafe');
								echo '</a>';
							echo '</li>';
							
							echo '<li><a href="' . languageUrlPrefix() . 'menu/">' . agileResource('menu') . '</a></li>';
							// echo '<li><a href="' . languageUrlPrefix() . 'classes/">' . agileResource('eikaiwaCafe') . '</a></li>';
							echo '<li><a href="' . languageUrlPrefix() . 'location/">' . agileResource('location') . '</a></li>';
							if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') { getManagerMenu(); }
							echo '<li><a href="' . languageUrlPrefix() . 'contact/">' . agileResource('contact') . '</a></li>';
						
							if ($_SESSION['roleID'] == "Super Administrator") {
								
								echo '<li><a href="' . languageUrlPrefix() . 'blog/">' . agileResource('blog') . '</a></li>';
								echo '<li><a href="' . languageUrlPrefix() . 'calender/">' . agileResource('calendar') . '</a></li>';
							}
							
							echo '<li>';
								if ($_SESSION['lang'] == 'en') {
									echo '<a href="ja/' . $currentURL . '">日本語</a>';
								} else {
									echo '<a href="' . $currentURL . '">English</a>';
								}
							echo '</li>';
							
							if (is_authed()) { echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>'; }
						
					echo '</ul>';
					
					if (!is_authed()) { echo '<div style="float:left;margin:3px;"><g:plusone></g:plusone></div>'; }
					
					echo '<br style="clear: left" />';
					
					echo '</div>';

		} elseif ($_SESSION['siteID'] == 30) { // agileshigoto.com

			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
					echo '<ul>';
					
							echo '<li><a href="/' . languageUrlPrefix() . '">' . agileResource('home') . '</a>';
							echo '</li>';
							if (
								$_SESSION['userRoleForCurrentSite'] == "siteManager" || 
								$_SESSION['userRoleForCurrentSite'] == "siteAccountant" || 
								$_SESSION['userRoleForCurrentSite'] == "siteStaff"
							) {
						
								echo '<li><a href="' . languageUrlPrefix() . 'tasks/">' . agileResource('taskList') . '</a></li>';
								echo '<li><a href="' . languageUrlPrefix() . 'timelog/">' . agileResource('timeLog') . '</a></li>';
								echo '<li><a href="' . languageUrlPrefix() . 'shigoto-reports/">' . agileResource('reports') . '</a></li>';
								echo '<li><a href="' . languageUrlPrefix() . 'user/update/' . $_SESSION['userID'] . '/">' . agileResource('profile') . '</a></li>';
			
								if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') { getManagerMenu(); }
						
							}	
						
							// echo '<li><a href="' . languageUrlPrefix() . 'contact/">' . agileResource('contact') . '</a></li>';
						
							if (is_authed()) { echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>'; }
						
					echo '</ul>';
					
					if (!is_authed()) { echo '<div style="float:left;margin:3px;"><g:plusone></g:plusone></div>'; }
					
					echo '<br style="clear: left" />';
					
					echo '</div>';

		} elseif ($_SESSION['siteID'] == 31) { // no.realtycms.com

			if (is_authed()) {
				echo '<div id="smoothmenu1" class="ddsmoothmenu">';
					echo '<ul>';
					
									echo '<li><a href="' . languageUrlPrefix() . '/">' . agileResource('public') . '</a>';
										echo '<ul>';
											echo '<li><a href="/' . languageUrlPrefix() . '">' . agileResource('home') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'property/">' . agileResource('properties') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'about/">' . agileResource('learnMore') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'contact-us/">' . agileResource('contactUs') . '</a></li>';
										echo '</ul>';
									echo '</li>';
					
								if (!empty($_SESSION['userClientArray'])) {
									echo '<li><a href="' . languageUrlPrefix() . 'invoices/">' . agileResource('owners') . '</a>';
										echo '<ul>';
											echo '<li><a href="' . languageUrlPrefix() . 'invoices/">' . agileResource('invoices') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'trust-cashflow/">' . agileResource('cashflow') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'contracts/">' . agileResource('agreements') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'bank-information/">' . agileResource('bankInformation') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'property-details/">' . agileResource('propertyDetails') . '</a></li>';
										echo '</ul>';
									echo '</li>';
								}
								
								if (
									$_SESSION['userRoleForCurrentSite'] == 'siteStaff' || 
									$_SESSION['userRoleForCurrentSite'] == 'siteAccountant' || 
									$_SESSION['userRoleForCurrentSite'] == 'siteManager' || 
									$_SESSION['userRoleForCurrentSite'] == 'siteAdmin'
								) {
								
									echo '<li><a href="' . languageUrlPrefix() . 'manage-properties/">' . agileResource('staff') . '</a>';
										echo '<ul>';
											echo '<li><a href="' . languageUrlPrefix() . 'manage-properties/">' . agileResource('property') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'clients/">' . agileResource('clients') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'tasks/">' . agileResource('taskList') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'timelog/">' . agileResource('timeLog') . '</a></li>';
										echo '</ul>';
									echo '</li>';
									
								}
								
								if ($_SESSION['userRoleForCurrentSite'] == 'siteAccountant' || $_SESSION['userRoleForCurrentSite'] == 'siteManager' || $_SESSION['userRoleForCurrentSite'] == 'siteAdmin') {
								
									
									echo '<li><a href="' . languageUrlPrefix() . 'transactions/">' . agileResource('accounting') . '</a>';
									
										echo '<ul>';
										
											echo '<li><a href="' . languageUrlPrefix() . 'transactions/">' . agileResource('internal') . '</a>';
												echo '<ul>';
													echo '<li><a href="' . languageUrlPrefix() . 'transactions/">' . agileResource('transactions') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'expense/">' . agileResource('expenses') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'payments/">' . agileResource('payments') . '</a></li>';
												echo '</ul>';
											echo '</li>';
											
											echo '<li><a href="' . languageUrlPrefix() . 'trust-accounts/">' . agileResource('trust') . '</a>';
												echo '<ul>';
													echo '<li><a href="' . languageUrlPrefix() . 'trust-accounts/">' . agileResource('trustAccounts') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'trust-expenses/">' . agileResource('trustExpenses') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'trust-deposits/">' . agileResource('trustDeposits') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'trust-withdrawals/">' . agileResource('trustWithdrawals') . '</a></li>';
												echo '</ul>';
											echo '</li>';
											
										echo '</ul>';
										
									echo '</li>';
									
								}
								
								if ($_SESSION['userRoleForCurrentSite'] == 'siteManager' || $_SESSION['userRoleForCurrentSite'] == 'siteAdmin') {
									echo '<li><a href="' . languageUrlPrefix() . 'settings/">' . agileResource('siteManager') . '</a>';
										echo '<ul>';

											echo '<li><a href="' . languageUrlPrefix() . 'users/">' . agileResource('users') . '</a></li>';
											
											echo '<li><a href="' . languageUrlPrefix() . 'settings/">' . agileResource('siteSettings') . '</a>';
												echo '<ul>';
													echo '<li><a href="' . languageUrlPrefix() . 'menus/">' . agileResource('menus') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'manage-content/">' . agileResource('content') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'manage-images/">' . agileResource('images') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'themes/">' . agileResource('themes') . '</a></li>';
												echo '</ul>';
											echo '</li>';
											
											echo '<li><a href="' . languageUrlPrefix() . 'manage-properties/">' . agileResource('property') . '</a>';
												echo '<ul>';
													echo '<li><a href="' . languageUrlPrefix() . 'manage-property-areas/">' . agileResource('areas') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'manage-property-classifications/">' . agileResource('classifications') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'manage-property-features/">' . agileResource('features') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'manage-property-statuses/">' . agileResource('statuses') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'manage-property-types/">' . agileResource('types') . '</a></li>';
												echo '</ul>';
											echo '</li>';
											
											if ($_SESSION['testMode'] == 'on') { 
												echo '<li><a href="' . languageUrlPrefix() . 'manage-accommodation/">&beta; ' . agileResource('accommodation') . '</a></li>';
											}
											
											echo '<li><a href="' . languageUrlPrefix() . 'products-and-services/">' . agileResource('accounting') . '</a>';
												echo '<ul>';
												
													echo '<li><a href="' . languageUrlPrefix() . 'products-and-services/">' . agileResource('internal') . '</a>';
														echo '<ul>';
															echo '<li><a href="' . languageUrlPrefix() . 'products-and-services/">' . agileResource('productsAndServices') . '</a></li>';
															echo '<li><a href="' . languageUrlPrefix() . 'expense/">' . agileResource('expenses') . '</a>';
																echo '<ul>';
																	echo '<li><a href="' . languageUrlPrefix() . 'vendor/">' . agileResource('Vendors & Payees') . '</a></li>';
																	echo '<li><a href="' . languageUrlPrefix() . 'expense-classification/">' . agileResource('Expense Classification') . '</a></li>';
																	echo '<li><a href="' . languageUrlPrefix() . 'expense-classification-category/">' . agileResource('Expense Classification Category') . '</a></li>';
																echo '</ul>';
															echo '</li>';
															echo '<li><a href="' . languageUrlPrefix() . 'payments/">' . agileResource('payments') . '</a>';
																echo '<ul>';
																	echo '<li><a href="' . languageUrlPrefix() . 'payment-methods/">' . agileResource('paymentMethods') . '</a></li>';
																echo '</ul>';
															echo '</li>';
														echo '</ul>';
													echo '</li>';
													
													echo '<li><a href="' . languageUrlPrefix() . '#">' . agileResource('trust') . '</a>';
														echo '<ul>';
															echo '<li><a href="' . languageUrlPrefix() . 'banks/">' . agileResource('banks') . '</a></li>';
															echo '<li><a href="' . languageUrlPrefix() . 'trust-account-types/">' . agileResource('accountTypes') . '</a></li>';
															echo '<li><a href="' . languageUrlPrefix() . 'trust-expense-classifications/">' . agileResource('Expense Classification') . '</a></li>';
															echo '<li><a href="' . languageUrlPrefix() . 'trust-expense-classification-categories/">' . agileResource('Expense Classification Category') . '</a></li>';
														echo '</ul>';
													echo '</li>';
													
												echo '</ul>';
											echo '</li>';
											
											
											echo '<li><a href="' . languageUrlPrefix() . 'manage-contracts/">' . agileResource('contracts') . '</a></li>';
											
											echo '<li><a href="' . languageUrlPrefix() . 'groups/">' . agileResource('shigoto') . '</a>';
												echo '<ul>';
													echo '<li><a href="' . languageUrlPrefix() . 'groups/">' . agileResource('groups') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'projects/">' . agileResource('projects') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'shigoto-classifications/">' . agileResource('classifications') . '</a></li>';
												echo '</ul>';
											echo '</li>';
											
											echo '<li><a href="' . languageUrlPrefix() . 'resource/">' . agileResource('resource') . '</a>';
												echo '<ul>';
													echo '<li><a href="' . languageUrlPrefix() . 'resource/">' . agileResource('language') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'geography/">' . agileResource('geography') . '</a>';
														echo '<ul>';
															echo '<li><a href="' . languageUrlPrefix() . 'add-city/">' . agileResource('addCity') . '</a></li>';
															echo '<li><a href="' . languageUrlPrefix() . 'add-state/">' . agileResource('addState') . '</a></li>';
														echo '</ul>';
													echo '</li>';
												echo '</ul>';
											echo '</li>';
											
											echo '<li><a href="' . languageUrlPrefix() . 'audit-trail/">' . agileResource('auditingTools') . '</a>';
												echo '<ul>';
													echo '<li><a href="' . languageUrlPrefix() . 'audit-trail/">' . agileResource('auditTrail') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . '404-audit/">' . agileResource('404audit') . '</a></li>';
												echo '</ul>';
											echo '</li>';
											
											echo '<li><a href="' . languageUrlPrefix() . 'contact/">' . agileResource('support') . '</a>';
												echo '<ul>';
													echo '<li><a href="' . languageUrlPrefix() . 'contact/">' . agileResource('contact') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'documentation/">' . agileResource('documentation') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'faq/">' . agileResource('faq') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'server-configuration/">' . agileResource('serverConfiguration') . '</a></li>';
												echo '</ul>';
											echo '</li>';
											
										echo '</ul>';
									echo '</li>';
								}

							if (is_authed()) { echo '<li><a href="' . languageUrlPrefix() . 'profile/' . $_SESSION['userID'] . '/">' . agileResource('profile') . '</a></li>'; }
							if (is_authed()) { echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>'; }
						
					echo '</ul>';

					getLanguageFlagLinks();
					
					echo '<br style="clear: left" />';
					
					echo '</div>';
			}

		} elseif ($_SESSION['siteID'] == 32) { // hkd48.hakodateguide.com

			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
					echo '<ul>';
					
							echo '<li>';
								echo '<a href="';
									echo '/' . languageUrlPrefix();
								echo '">';
									echo agileResource('hkd48');
								echo '</a>';
							echo '</li>';

							echo '<li><a href="' . languageUrlPrefix() . '#">' . agileResource('profiles') . '</a></li>';
							echo '<li><a href="' . languageUrlPrefix() . '#">' . agileResource('vote') . '</a></li>';
							// echo '<li><a href="' . languageUrlPrefix() . 'timelog/">' . agileResource('timeLog') . '</a></li>';

							echo '<li><a href="' . languageUrlPrefix() . 'contact/">' . agileResource('contact') . '</a></li>';
						
							if (is_authed()) { echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>'; }
						
					echo '</ul>';
					
					if (!is_authed()) { echo '<div style="float:left;margin:3px;"><g:plusone></g:plusone></div>'; }
					
					echo '<br style="clear: left" />';
					
				echo '</div>';

		} elseif ($_SESSION['siteID'] == 33) { // nc.realtycms.com

			
			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
					echo '<ul>';
					
								echo '<li>';
									echo '<a href="';
										echo '/' . languageUrlPrefix();
									echo '">';
										if (is_authed()) { echo agileResource('publicSite'); } else { echo agileResource('home'); }
									echo '</a>';
								
									if (is_authed()) { echo '<ul>'; } else { echo '</li>'; }
										
										echo '<li><a href="' . languageUrlPrefix() . 'niseko-real-estate/">' . agileResource('realEstate') . '</a></li>';
										echo '<li><a href="' . languageUrlPrefix() . 'niseko-area-guide/">' . agileResource('nisekoAreaGuide') . '</a></li>';
										echo '<li><a href="' . languageUrlPrefix() . 'niseko-accommodation/">' . agileResource('propertyRentals') . '</a></li>';
										echo '<li><a href="' . languageUrlPrefix() . 'niseko-consulting/">' . agileResource('consulting') . '</a></li>';
										echo '<li><a href="' . languageUrlPrefix() . 'contact-us/">' . agileResource('contactUs') . '</a></li>';
							
									if (is_authed()) { echo '</ul></li>'; }
							
							if (is_authed()) {
							
								if ($_SESSION['roleID'] == "Super Administrator" || isSiteManager()) {

									echo '<li><a href="#">' . agileResource('clients') . '</a>';
										echo '<ul>';
											echo '<li><a href="' . languageUrlPrefix() . 'property/">' . agileResource('property') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'invoices/">' . agileResource('invoices') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'payments/">' . agileResource('payments') . '</a></li>';
										echo '</ul>';
									echo '</li>';

									echo '<li><a href="' . languageUrlPrefix() . 'projects/">' . agileResource('staff') . '</a>';
										echo '<ul>';
											echo '<li><a href="' . languageUrlPrefix() . 'projects/">' . agileResource('projects') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'tasks/">' . agileResource('taskList') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'timelog/">' . agileResource('timeLog') . '</a></li>';
										echo '</ul>';
									echo '</li>';
									
									echo '<li><a href="' . languageUrlPrefix() . 'transactions/">' . agileResource('accounting') . '</a>';
										echo '<ul>';
											echo '<li><a href="' . languageUrlPrefix() . 'transactions/">' . agileResource('transactions') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'products-and-services/">' . agileResource('productsAndServices') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'clients/">' . agileResource('clients') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'payments/">' . agileResource('payments') . '</a></li>';
										echo '</ul>';
									echo '</li>';
									
									echo '<li><a href="' . languageUrlPrefix() . 'audit-trail/">' . agileResource('siteManager') . '</a>';
										echo '<ul>';
											echo '<li><a href="' . languageUrlPrefix() . 'users/">' . agileResource('users') . '</a></li>';
											if ($_SESSION['roleID'] == 'Super Administrator') { echo '<li><a href="' . languageUrlPrefix() . 'groups/">' . agileResource('groups') . '</a></li>'; }
											echo '<li><a href="' . languageUrlPrefix() . 'audit-trail/">' . agileResource('auditTrail') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'resource/">' . agileResource('resource') . '</a></li>';
										echo '</ul>';
									echo '</li>';
									
								}
								echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>';
							}
						
					echo '</ul>';
					
					echo '<br style="clear: left" />';
					
					echo '</div>';
		} elseif ($_SESSION['siteID'] == 34) { // realtycms.com

			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
					echo '<ul>';
						echo '<li><a href="/' . languageUrlPrefix() . '">' . agileResource('home') . '</a></li>';
						if (is_authed()) { echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>'; }
					echo '</ul>';
					if (!is_authed()) { echo '<div style="float:left;margin:3px;"><g:plusone></g:plusone></div>'; }
					echo '<br style="clear: left" />';
			echo '</div>';

		} elseif ($_SESSION['siteID'] == 35) { // agilesolana.com

			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
					echo '<ul>';
						echo '<li><a href="/' . languageUrlPrefix() . '">' . agileResource('home') . '</a></li>';
						if (is_authed()) { echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>'; }
					echo '</ul>';
					if (!is_authed()) { echo '<div style="float:left;margin:3px;"><g:plusone></g:plusone></div>'; }
					echo '<br style="clear: left" />';
			echo '</div>';

		} elseif ($_SESSION['siteID'] == 36) { // tw1t.net

			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
					echo '<ul>';
						echo '<li><a href="/' . languageUrlPrefix() . '">' . agileResource('home') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'shorten-a-url/">' . agileResource('shortenAUrl') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'urls/">' . agileResource('browseLinks') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'contact/">' . agileResource('contact') . '</a></li>';
						if (is_authed()) { echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>'; }
					echo '</ul>';
					if (!is_authed()) { echo '<div style="float:left;margin:3px;"><g:plusone></g:plusone></div>'; }
					echo '<br style="clear: left" />';
			echo '</div>';

			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
		} elseif ($_SESSION['siteID'] == 63) { // nt.agilehokkaido.com (NisekoTours.com)




























			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
				
					echo '<ul>';
					if (!is_authed()) {
						echo '<li><a href="/' . languageUrlPrefix() . '">' . agileResource('home') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'blog/">' . agileResource('blog') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'news/">' . agileResource('news') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'login/">' . agileResource('login') . '</a></li>';
					} else {
						echo '<li><a href="#">' . agileResource('public') . '</a>';
							echo '<ul>';
								echo '<li><a href="' . languageUrlPrefix() . 'blog/">' . agileResource('blog') . '</a></li>';
								echo '<li><a href="' . languageUrlPrefix() . 'news/">' . agileResource('news') . '</a></li>';
							echo '</ul>';
						echo '</li>';
						echo '<li><a href="#">' . agileResource('clients') . '</a></li>';
						echo '<li><a href="#">' . agileResource('staff') . '</a>';
							echo '<ul>';
								echo '<li><a href="' . languageUrlPrefix() . 'clients/">' . agileResource('clients') . '</a></li>';
								echo '<li><a href="' . languageUrlPrefix() . 'tasks/">' . agileResource('taskList') . '</a></li>';
							echo '</ul>';
						echo '</li>';
						echo '<li><a href="#">' . agileResource('providers') . '</a></li>';
						echo '<li><a href="#">' . agileResource('agents') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'transactions/">' . agileResource('accounting') . '</a>';
							echo '<ul>';
								echo '<li><a href="' . languageUrlPrefix() . 'transactions/">' . agileResource('transactions') . '</a></li>';
								echo '<li><a href="' . languageUrlPrefix() . 'expense/">' . agileResource('expenses') . '</a></li>';
								echo '<li><a href="' . languageUrlPrefix() . 'payments/">' . agileResource('payments') . '</a></li>';
								echo '<li><a href="' . languageUrlPrefix() . 'timelog/">' . agileResource('timeLog') . '</a></li>';
							echo '</ul>';
						echo '</li>';
						
						if ($_SESSION['userRoleForCurrentSite'] == 'siteManager' || $_SESSION['userRoleForCurrentSite'] == 'siteAdmin') {
									echo '<li><a href="' . languageUrlPrefix() . 'settings/">' . agileResource('siteManager') . '</a>';
										echo '<ul>';

											echo '<li><a href="' . languageUrlPrefix() . 'users/">' . agileResource('users') . '</a></li>';
											
											echo '<li><a href="' . languageUrlPrefix() . 'settings/">' . agileResource('siteSettings') . '</a>';
												echo '<ul>';
													echo '<li><a href="' . languageUrlPrefix() . 'menus/">' . agileResource('menus') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'manage-content/">' . agileResource('content') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'manage-images/">' . agileResource('images') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'themes/">' . agileResource('themes') . '</a></li>';
												echo '</ul>';
											echo '</li>';

											echo '<li><a href="' . languageUrlPrefix() . 'products-and-services/">' . agileResource('accounting') . '</a>';
														echo '<ul>';
															echo '<li><a href="' . languageUrlPrefix() . 'products-and-services/">' . agileResource('productsAndServices') . '</a></li>';
															echo '<li><a href="' . languageUrlPrefix() . 'expense/">' . agileResource('expenses') . '</a>';
																echo '<ul>';
																	echo '<li><a href="' . languageUrlPrefix() . 'vendor/">' . agileResource('Vendors & Payees') . '</a></li>';
																	echo '<li><a href="' . languageUrlPrefix() . 'expense-classification/">' . agileResource('Expense Classification') . '</a></li>';
																	echo '<li><a href="' . languageUrlPrefix() . 'expense-classification-category/">' . agileResource('Expense Classification Category') . '</a></li>';
																echo '</ul>';
															echo '</li>';
															echo '<li><a href="' . languageUrlPrefix() . 'payments/">' . agileResource('payments') . '</a>';
																echo '<ul>';
																	echo '<li><a href="' . languageUrlPrefix() . 'payment-methods/">' . agileResource('paymentMethods') . '</a></li>';
																echo '</ul>';
															echo '</li>';
														echo '</ul>';
											echo '</li>';
											
											echo '<li><a href="' . languageUrlPrefix() . 'contracts/">' . agileResource('contracts') . '</a></li>';
											
											echo '<li><a href="' . languageUrlPrefix() . 'groups/">' . agileResource('shigoto') . '</a>';
												echo '<ul>';
													echo '<li><a href="' . languageUrlPrefix() . 'groups/">' . agileResource('groups') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'projects/">' . agileResource('projects') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'shigoto-classifications/">' . agileResource('classifications') . '</a></li>';
												echo '</ul>';
											echo '</li>';
											
											echo '<li><a href="' . languageUrlPrefix() . 'resource/">' . agileResource('resource') . '</a>';
												echo '<ul>';
													echo '<li><a href="' . languageUrlPrefix() . 'resource/">' . agileResource('language') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . 'geography/">' . agileResource('geography') . '</a>';
														echo '<ul>';
															echo '<li><a href="' . languageUrlPrefix() . 'add-city/">' . agileResource('addCity') . '</a></li>';
															echo '<li><a href="' . languageUrlPrefix() . 'add-state/">' . agileResource('addState') . '</a></li>';
														echo '</ul>';
													echo '</li>';
												echo '</ul>';
											echo '</li>';
											
											echo '<li><a href="' . languageUrlPrefix() . 'audit-trail/">' . agileResource('auditingTools') . '</a>';
												/*
												echo '<ul>';
													echo '<li><a href="' . languageUrlPrefix() . 'audit-trail/">' . agileResource('auditTrail') . '</a></li>';
													echo '<li><a href="' . languageUrlPrefix() . '404-audit/">' . agileResource('404audit') . '</a></li>';
												echo '</ul>';
												*/
											echo '</li>';
											
											echo '<li><a href="' . languageUrlPrefix() . 'contact/">' . agileResource('support') . '</a></li>';
											
										echo '</ul>';
									echo '</li>';
								}
						echo '<li><a href="' . languageUrlPrefix() . 'profile/' . $_SESSION['userID'] . '/">' . agileResource('profile') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>';
					}
					echo '</ul>';
					
					
					
					
					
					
					
					$currentURL = urldecode(preg_replace('/^%2F(en%2F|ja%2F)?/', '', urlencode($_SERVER['REQUEST_URI']), 1));
					echo '<div style="float:right;text-align:right;height:20px;margin:6px 5px 0px 0px;">';
					echo '<a href="/' . $currentURL . '"><img src="agileThemes/' . getSiteTheme() . '/images/en.gif" alt="English" style="margin:1px;border:1px solid #0971a1;" /></a>';
					echo '<a href="ja/' . $currentURL . '"><img src="agileThemes/' . getSiteTheme() . '/images/ja.gif" alt="Japanese" style="margin:1px;border:1px solid #0971a1;" /></a>';
					echo '</div>';
					echo '<br style="clear: left" />';
			echo '</div>';

			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
		} elseif ($_SESSION['siteID'] == 37) { // cswebb.com

			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
					echo '<ul>';
						echo '<li><a href="/' . languageUrlPrefix() . '">' . agileResource('home') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'blog/">' . agileResource('blog') . '</a></li>';
						// echo '<li><a href="' . languageUrlPrefix() . 'resume/">' . agileResource('resume') . '</a></li>';
						// echo '<li><a href="' . languageUrlPrefix() . 'recipes/">' . agileResource('recipes') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'genealogy/">' . agileResource('genealogy') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'contact/">' . agileResource('contact') . '</a></li>';
						if (is_authed()) { echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>'; }
					echo '</ul>';

					echo '<div style="float:left;margin:3px;">';
						echo '<a href="' . getSiteUrl() . '/rss/"><img src="agileImages/rss-24x24y.png"></a> ';
						echo '<a href="http://www.linkedin.com/in/chishiki"><img src="agileImages/linkedin.png"></a> ';
						echo '<a href="http://twitter.com/chishiki"><img src="agileImages/twitter-24x24y.png"></a> ';
						echo '<a href="http://facebook.com/chishiki"><img src="agileImages/facebook.png"></a> ';
						echo '<g:plusone></g:plusone>';
					echo '</div>';
					
					echo '<br style="clear: left" />';
			echo '</div>';

		} elseif ($_SESSION['siteID'] == 67) { // SeattleDataHosting.com

			echo '<div id="smoothmenu1" class="ddsmoothmenu">';

				echo '<ul>';
					
						echo '<li><a href="/">';
							if (is_authed()) { echo agileResource('publicSite'); } else { echo agileResource('home'); }
						echo '</a>';

						if (!is_authed()) { echo '</li>'; } else { echo '<ul>'; } // convert this group to a submenu if user is logged in
						
							echo '<li><a href="' . languageUrlPrefix() . 'agile/hosting/">' . agileResource('hosting') . '</a></li>';
							
							if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') {
								echo '<li><a href="' . languageUrlPrefix() . 'store/">' . agileResource('browse') . '</a></li>';
							}
							
							echo '<li><a href="' . languageUrlPrefix() . 'agile/websites/">' . agileResource('websites') . '</a></li>';
						
							echo '<li><a href="' . languageUrlPrefix() . 'agile/systems/">' . agileResource('systems') . '</a>';
								echo '<ul>';
									echo '<li><a href="' . languageUrlPrefix() . 'agile/systems/">' . agileResource('whySystems') . '</a></li>';
									echo '<li><a href="' . languageUrlPrefix() . 'agile/methodology/">' . agileResource('methodology') . '</a></li>';
									echo '<li><a href="' . languageUrlPrefix() . 'agile/technologies/">' . agileResource('technologies') . '</a></li>';
									echo '<li><a href="' . languageUrlPrefix() . 'agile/mission-statement/">' . agileResource('mission-statement') . '</a></li>';
									echo '<li><a href="' . languageUrlPrefix() . 'agile/maintenance-and-support/">' . agileResource('maintenance-and-support') . '</a></li>';
								echo '</ul>';
							echo '</li>';
							
							echo '<li><a href="' . languageUrlPrefix() . 'agile/uptime/">' . agileResource('support') . '</a>';
								echo '<ul>';
								
									echo '<li><a href="' . languageUrlPrefix() . 'agile/jpanel/">' . agileResource('email') . '</a>';
										echo '<ul>';
											echo '<li><a href="' . languageUrlPrefix() . 'agile/jpanel/">' . agileResource('manage') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'agile/thunderbird/">' . agileResource('desktop') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'agile/gmail/">' . agileResource('webmail') . '</a></li>';
										echo '</ul>';
									echo '</li>';
									
									echo '<li><a href="' . languageUrlPrefix() . 'agile/ftp/">' . agileResource('fileTransfer') . '</a>';
										echo '<ul>';
											echo '<li><a href="' . languageUrlPrefix() . 'agile/ftp/">' . agileResource('WinSCP') . '</a></li>';
											echo '<li><a href="' . languageUrlPrefix() . 'agile/ftp/">' . agileResource('FileZilla') . '</a></li>';
										echo '</ul>';
									echo '</li>';
									
									echo '<li><a href="' . languageUrlPrefix() . 'agile/mysql/">' . agileResource('databases') . '</a>';
										echo '<ul>';
											echo '<li><a href="' . languageUrlPrefix() . 'agile/mysql/">' . agileResource('mysql') . '</a></li>';
										echo '</ul>';
									echo '</li>';
									
									echo '<li><a href="' . languageUrlPrefix() . 'forum/">' . agileResource('forum') . '</a></li>';
									echo '<li><a href="' . languageUrlPrefix() . 'agile/uptime/">' . agileResource('uptime') . '</a></li>';
									echo '<li><a href="' . languageUrlPrefix() . 'contact/">' . agileResource('contact') . '</a></li>';
									
								echo '</ul>';
							echo '</li>';
						
						if (is_authed()) { echo '</ul></li>'; }

						if (
							$_SESSION['userRoleForCurrentSite'] == 'siteClient' ||
							$_SESSION['userRoleForCurrentSite'] == 'siteStaff' ||
							$_SESSION['userRoleForCurrentSite'] == 'siteAccountant' || 
							$_SESSION['userRoleForCurrentSite'] == 'siteManager'
						
						) {
						
							echo '<li><a href="' . languageUrlPrefix() . 'invoices/">' . agileResource('clients') . '</a>';
								echo '<ul>';
									echo '<li><a href="' . languageUrlPrefix() . 'invoices/">' . agileResource('invoices') . '</a></li>';
									echo '<li><a href="' . languageUrlPrefix() . 'payments/">' . agileResource('payments') . '</a></li>';
								echo '</ul>';
							echo '</li>';
							
						}

						if (
							$_SESSION['userRoleForCurrentSite'] == 'siteAccountant' || 
							$_SESSION['userRoleForCurrentSite'] == 'siteManager'
						) {
							echo '<li><a href="' . languageUrlPrefix() . 'clients/">' . agileResource('accounting') . '</a>';
								echo '<ul>';
									echo '<li><a href="' . languageUrlPrefix() . 'clients/">' . agileResource('clients') . '</a>';
									echo '<li><a href="' . languageUrlPrefix() . 'transactions/">' . agileResource('transactions') . '</a></li>';
									echo '<li><a href="' . languageUrlPrefix() . 'expense/">' . agileResource('expenses') . '</a></li>';
									echo '<li><a href="' . languageUrlPrefix() . 'reports/">' . agileResource('reports') . '</a></li>';
								echo '</ul>';
							echo '</li>';
						}
							
						if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') { getManagerMenu(); }

						if (is_authed()) {
							echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>';
						} else {
							echo '<li><a href="' . languageUrlPrefix() . 'contact/">' . agileResource('contact') . '</a></li>';
						}
						
					echo '</ul>';
					
						echo '<div style="float:left;margin:3px;">';
							echo '<a href="' . getSiteUrl() . '/rss/"><img src="agileImages/rss-24x24y.png"></a> ';
							echo '<a href="http://twitter.com/seattledata"><img src="agileImages/twitter-24x24y.png"></a> ';
							echo '<a href="http://facebook.com/seattledatahosting"><img src="agileImages/facebook.png"></a> ';
							echo '<a href="http://www.linkedin.com/company/seattle-data-hosting/"><img src="agileImages/linkedin.png"></a> ';
							echo '<g:plusone></g:plusone>';
						echo '</div>';
						
						getNewLanguageFlagLinks();
						
					echo '<br style="clear: left" />';
					echo '</div>';



		} elseif (
				$_SESSION['siteID'] == 68 ||
				$_SESSION['siteID'] == 69 ||
				$_SESSION['siteID'] == 72 ||
				$_SESSION['siteID'] == 73 ||
				$_SESSION['siteID'] == 74
			) { // myokopass.com

			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
					echo '<ul>';
						
						echo '<li><a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . '">' . agileResource('niseko') . '</a></li>';
						
						echo '<li><a href="http://nisekonews.net/' . languageUrlPrefix() . 'news/">' . agileResource('news') . '</a>';
							echo '<ul>';
								echo '<li><a href="http://nisekonews.net/' . languageUrlPrefix() . 'news/">' . agileResource('news') . '</a></li>';
								echo '<li><a href="http://nisekosnowreport.com/' . languageUrlPrefix() . 'snow-report/">' . agileResource('snowReport') . '</a></li>';
								echo '<li><a href="http://nisekosnowforecast.com/' . languageUrlPrefix() . 'snow-forecast/">' . agileResource('snowForecast') . '</a></li>';
								echo '<li><a href="http://nisekoavalanche.info/' . languageUrlPrefix() . 'nadare/">' . agileResource('avalancheInfo') . '</a></li>';
							echo '</ul>';
						echo '</li>';
						
						echo '<li><a href="http://nisekohokkaido.com/' . languageUrlPrefix() . '">' . agileResource('areaGuide') . '</a>';
							echo '<ul>';
								echo '<li><a href="http://nisekorestaurants.com/' . languageUrlPrefix() . 'restaurants/">' . agileResource('restaurants') . '</a></li>';
								echo '<li><a href="http://nightlife.nisekobars.com/' . languageUrlPrefix() . 'bars-and-nightlife/">' . agileResource('barsAndNightlife') . '</a></li>';
								echo '<li><a href="http://nisekorestaurants.com/' . languageUrlPrefix() . 'shops/">' . agileResource('shopping') . '</a></li>';
								echo '<li><a href="http://nisekoproperty.net/' . languageUrlPrefix() . 'real-estate/">' . agileResource('propertyAndRealEstate') . '</a></li>';
								echo '<li><a href="http://nisekoaccommodation.net/' . languageUrlPrefix() . 'stay/">' . agileResource('accommodation') . '</a></li>';
								echo '<li><a href="http://nisekojobs.com/' . languageUrlPrefix() . 'employment/">' . agileResource('employment') . '</a>';
							echo '</ul>';
						echo '</li>';
						
						echo '<li><a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . 'for-sale/">' . agileResource('classifieds') . '</a>';
							echo '<ul>';
								echo '<li><a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . 'for-sale/">' . agileResource('forSale') . '</a></li>';
								echo '<li><a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . 'wanted/">' . agileResource('wanted') . '</a></li>';
								echo '<li><a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . 'services/">' . agileResource('services') . '</a></li>';
								echo '<li><a href="http://nisekoaccommodation.net/' . languageUrlPrefix() . 'looking-for-accommodation/">' . agileResource('lookingForAccommodation') . '</a></li>';
								echo '<li><a href="http://nisekojobs.com/' . languageUrlPrefix() . 'looking-for-work/">' . agileResource('lookingForWork') . '</a></li>';
							echo '</ul>';
						echo '</li>';
						echo '<li><a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . 'forum/">' . agileResource('forum') . '</a>';
						echo '<li><a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . 'contact/">' . agileResource('contact') . '</a></li>';
						if (is_authed()) { 
							echo '<li><a href="http://hirafuhighrollers.com/' . languageUrlPrefix() . 'user/update/' . $_SESSION['userID'] . '/">' . agileResource('profile') . '</a></li>';
							echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>';
						}
					echo '</ul>';
					echo '<div style="float:left;margin:3px;">';
						echo '<a href="' . getSiteUrl() . '/rss/"><img src="agileImages/rss-24x24y.png"></a> ';
						echo '<a href="http://twitter.com/kutchannel"><img src="agileImages/twitter-24x24y.png"></a> ';
						echo '<a href="http://facebook.com/kutchannel"><img src="agileImages/facebook.png"></a> ';
						echo '<g:plusone></g:plusone>';
					echo '</div>';
					echo '<br style="clear: left" />';
			echo '</div>';
					
		} elseif ($_SESSION['siteID'] == 55) { // RedPillJapan.com
		
			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
					echo '<ul>';
						echo '<li><a href="/' . languageUrlPrefix() . '">' . agileResource('home') . '</a></li>';
						echo '<li><a href="/' . languageUrlPrefix() . 'music/">' . agileResource('music') . '</a></li>';
						echo '<li><a href="/' . languageUrlPrefix() . 'movies/">' . agileResource('movies') . '</a></li>';
						echo '<li><a href="/' . languageUrlPrefix() . 'tv/">' . agileResource('tv') . '</a></li>';
						echo '<li><a href="/' . languageUrlPrefix() . 'games/">' . agileResource('games') . '</a></li>';
						// echo '<li><a href="/' . languageUrlPrefix() . 'places/">' . agileResource('places') . '</a></li>';
						
						getManagerMenu();
						if (is_authed()) {
							echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>';
						} else {
							echo '<li><a href="/' . languageUrlPrefix() . 'contact/">' . agileResource('contact') . '</a></li>';
						}
						
					echo '</ul>';
					echo '<div style="float:left;margin:3px;">';
						echo '<a href="' . getSiteUrl() . '/rss/"><img src="agileImages/rss-24x24y.png"></a> ';
						echo '<a href="http://twitter.com/' . getSiteTwitter() . '"><img src="agileImages/twitter-24x24y.png"></a> ';
						echo '<a href="http://facebook.com/redpilljapan"><img src="agileImages/facebook.png"></a> ';
						echo '<g:plusone></g:plusone>';
					echo '</div>';
					displayLanguageFlagLinks('float:right;margin:3px;border-style:none;', 'margin:3px 1px 1px 1px;padding:1px;border:1px solid #999;');
					echo '<br style="clear: left" />';
			echo '</div>';
		
		} elseif ($_SESSION['siteID'] == 48) { // HirafuHighRollers.com
			displayNewKutchannelMenu();
		} elseif ($_SESSION['siteID'] == 52) { // NisekoSki.net
			displayNewKutchannelMenu();
		} elseif ($_SESSION['siteID'] == 53) { // NisekoSnowboarding.com
			displayNewKutchannelMenu();
		
		
		} else {

			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
					echo '<ul>';
						echo '<li><a href="/' . languageUrlPrefix() . '">' . agileResource('home') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'contact/">' . agileResource('contact') . '</a></li>';
						if (is_authed()) { echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>'; }
					echo '</ul>';
					if (!is_authed()) { echo '<div style="float:left;margin:3px;"><g:plusone></g:plusone></div>'; }
					echo '<br style="clear: left" />';
			echo '</div>';

		}


	} elseif ($menuType = 'network') {

			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
				echo '<ul>';
					echo '<li><a href="http://nisekopass.com/' . languageUrlPrefix() . '">' . agileResource('nisekoPass') . '</a></li>';
					echo '<li><a href="' . languageUrlPrefix() . 'real-estate/">' . agileResource('propertyListings') . '</a></li>';
					echo '<li><a href="' . languageUrlPrefix() . 'property-management/">' . agileResource('propertyManagement') . '</a></li>';
					echo '<li><a href="' . languageUrlPrefix() . 'construction/">' . agileResource('construction') . '</a></li>';
					echo '<li><a href="http://agilehokkaido.com/' . languageUrlPrefix() . 'contact/">' . agileResource('contact') . '</a></li>';
					echo '<li>';
							if ($_SESSION['lang'] == 'en') {
								echo '<a href="ja/' . $currentURL . '">日本語</a>';
							} else {
								echo '<a href="' . $currentURL . '">English</a>';
							}
					echo '</li>';
					if (is_authed()) { echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>'; }
				echo '</ul>';
				echo '<div style="float:left;margin:3px;">';
					echo '<a href="' . getSiteUrl() . '/rss/"><img src="agileImages/rss-24x24y.png"></a> ';
					echo '<a href="http://twitter.com/nisekoproperty"><img src="agileImages/twitter-24x24y.png"></a> ';
					echo '<a href="http://facebook.com/nisekoproperty"><img src="agileImages/facebook.png"></a> ';
					echo '<g:plusone></g:plusone>';
				echo '</div>';
				echo '<br style="clear: left" />';
			echo '</div>';
	}

}

function returnTemporaryNisekoDefaultMenu() {

			echo '<div id="smoothmenu1" class="ddsmoothmenu">';
			echo '<ul>';
				echo '<li>';
					echo '<a href="';
						if (getSiteURL() != 'http://NisekoPass.com/') { echo 'http://NisekoPass.com/'; } else { echo '/'; }
						echo languageUrlPrefix();
					echo '">';
						echo agileResource('nisekoPass');
					echo '</a>';
				echo '</li>';
					
				echo '<li>';
				
						echo '<a href="';
						
						if (getSiteURL() != 'http://NisekoHokkaido.com/') {
							echo 'http://NisekoHokkaido.com/';
						}
						
						echo languageUrlPrefix();
						
						// if (getSiteURL() != 'http://NisekoHokkaido.com/') {
							echo '">';
						// }
						
						echo agileResource('areaGuide');
						echo '</a>';
				
				echo '<ul>';
					echo '<li>';
					
						echo '<a href="';
						
							if (getSiteURL() != 'http://NisekoHokkaido.com/') {
								echo 'http://NisekoHokkaido.com/';
							} else { 
								echo '/';
							
							}
							echo languageUrlPrefix();
							
						
						echo 'resorts/">' . agileResource('resorts') . '</a>';
						
						echo '<ul>';
						
							echo '<li>';
								echo '<a href="';
									if (getSiteURL() != 'http://NisekoHokkaido.com/') { echo 'http://NisekoHokkaido.com/'; }
									echo languageUrlPrefix();
								echo 'annupuri/">' . agileResource('annupuri') . '</a>';
							echo '</li>';
						
							echo '<li>';
								echo '<a href="';
									if (getSiteURL() != 'http://NisekoHokkaido.com/') { echo 'http://NisekoHokkaido.com/'; }
									echo languageUrlPrefix();
								echo 'hanazono/">' . agileResource('hanazono') . '</a>';
							echo '</li>';
							
							echo '<li>';
								echo '<a href="';
									if (getSiteURL() != 'http://NisekoHokkaido.com/') { echo 'http://NisekoHokkaido.com/'; }
									echo languageUrlPrefix();
								echo 'higashiyama/">' . agileResource('higashiyama') . '</a>';
							echo '</li>';
							
							
							echo '<li><a href="';
							if (getSiteURL() != 'http://NisekoHokkaido.com/') { echo 'http://NisekoHokkaido.com/'; }
							echo languageUrlPrefix();
						echo 'hirafu/">' . agileResource('hirafu') . '</a></li>';
							
							
							echo '<li><a href="';
							if (getSiteURL() != 'http://NisekoHokkaido.com/') { echo 'http://NisekoHokkaido.com/'; }
							echo languageUrlPrefix();
						echo 'moiwa/">' . agileResource('moiwa') . '</a></li>';
							
							
						echo '</ul>';
					echo '</li>';
					
					echo '<li><a href="';
						if (getSiteURL() != 'http://NisekoAccommodation.net/') { echo 'http://NisekoAccommodation.net/'; }
						echo languageUrlPrefix() . 'stay/">' . agileResource('accommodation') . '</a></li>';
						
					echo '<li><a href="';
						if (getSiteURL() != 'http://NisekoProperty.net/') { echo 'http://NisekoProperty.net/'; }
						echo languageUrlPrefix() . 'listings/">' . agileResource('property') . '</a></li>';
						
					echo '<li><a href="';
						if (getSiteURL() != 'http://NisekoRestaurants.com/') { echo 'http://NisekoRestaurants.com/'; }
						echo languageUrlPrefix() . 'restaurants/">' . agileResource('restaurants') . '</a></li>';
						
					echo '<li><a href="';
						if (getSiteURL() != 'http://NisekoBars.com/') { echo 'http://NisekoBars.com/'; }
						echo languageUrlPrefix() . 'bars/">' . agileResource('bars') . '</a></li>';
					
					
					
					echo '<li><a href="';
						if (getSiteURL() != 'http://NisekoShopping.com/') { echo 'http://NisekoShopping.com/'; }
						echo languageUrlPrefix();
						echo '">' . agileResource('shopping') . '</a></li>';
					
						
				echo '</ul>';
				
				echo '</li>';
				echo '<li><a href="';
						if (getSiteURL() != 'http://NisekoPass.com/') { echo 'http://NisekoPass.com/'; }
						echo languageUrlPrefix() . 'now/">' . agileResource('nisekoNow') . '</a>';
					echo '<ul>';
					
						echo '<li><a href="';
								if (getSiteURL() != 'http://NisekoNews.net/') { echo 'http://NisekoNews.net/'; }
								echo languageUrlPrefix() . 'news/">' . agileResource('news') . '</a></li>';
								
						echo '<li><a href="';
								if (getSiteURL() != 'http://NisekoCalendar.com/') { echo 'http://NisekoCalendar.com/'; }
								echo languageUrlPrefix() . 'events/">' . agileResource('events') . '</a></li>';
								
						echo '<li><a href="';
						if (getSiteURL() != 'http://NisekoSnowForecast.com/') { echo 'http://NisekoSnowForecast.com/'; }
						echo languageUrlPrefix() . 'weather/">' . agileResource('weather') . '</a>';
							echo '<ul>';
								echo '<li><a href="';
							if (getSiteURL() != 'http://NisekoSnowForecast.com/') { echo 'http://NisekoSnowForecast.com/'; }
							echo languageUrlPrefix() . 'snowforecast/">' . agileResource('snowForecast') . '</a></li>';
								echo '<li><a href="';
							if (getSiteURL() != 'http://NisekoSnowReport.com/') { echo 'http://NisekoSnowReport.com/'; }
							echo languageUrlPrefix() . 'snowreport/">' . agileResource('snowReport') . '</a></li>';
							echo '</ul>';
						echo '</li>';
					echo '</ul>';
				echo '</li>';
				echo '<li><a href="';
							if (getSiteURL() != 'http://NisekoWeb.com/') { echo 'http://NisekoWeb.com/'; }
							echo languageUrlPrefix() . 'directory/">' . agileResource('directory') . '</a></li>';
							
				// KUTCHANNEL MENU ITEMS
				echo '<li><a href="';
							if (getSiteURL() != 'http://Kutchan.net/') { echo 'http://Kutchan.net/'; }
							echo languageUrlPrefix() . 'classifieds/">' . agileResource('classifieds') . '</a>';
							
					echo '<ul>';
					
						echo '<li><a href="';
							if (getSiteURL() != 'http://Kutchan.net/') { echo 'http://Kutchan.net/'; }
							echo languageUrlPrefix() . 'forsale/">' . agileResource('forSale') . '</a></li>';
						echo '<li><a href="';
							if (getSiteURL() != 'http://Kutchan.net/') { echo 'http://Kutchan.net/'; }
							echo languageUrlPrefix() . 'wanted/">' . agileResource('wanted') . '</a></li>';
						
						echo '<li><a href="';
							if (getSiteURL() != 'http://NisekoJobs.com/') { echo 'http://NisekoJobs.com/'; }
							echo languageUrlPrefix() . 'employment/">' . agileResource('employment') . '</a></li>';
						echo '<li><a href="';
							if (getSiteURL() != 'http://NisekoAccommodation.net/') { echo 'http://NisekoAccommodation.net/'; }
							echo languageUrlPrefix() . 'accommodation/">' . agileResource('accommodation') . '</a></li>';
						echo '<li><a href="';
							if (getSiteURL() != 'http://NisekoProperty.net/') { echo 'http://NisekoProperty.net/'; }
							echo languageUrlPrefix() . 'realestate/">' . agileResource('realEstateAndProperty') . '</a></li>';
							
						echo '<li><a href="';
							if (getSiteURL() != 'http://Kutchan.net/') { echo 'http://Kutchan.net/'; }
							echo languageUrlPrefix() . 'services/">' . agileResource('services') . '</a></li>';
						echo '<li><a href="';
							if (getSiteURL() != 'http://Kutchan.net/') { echo 'http://Kutchan.net/'; }
							echo languageUrlPrefix() . 'personals/">' . agileResource('personals') . '</a></li>';
					echo '</ul>';
				echo '</li>';
				
				echo '<li><a href="';
							if (getSiteURL() != 'http://Kutchan.net/') { echo 'http://Kutchan.net/'; }
							echo languageUrlPrefix() . 'forum/">' . agileResource('forum') . '</a></li>';
							
				echo '<li><a href="';
							if (getSiteURL() != 'http://NisekoWeb.com/') { echo 'http://NisekoWeb.com/'; }
							echo languageUrlPrefix() . 'search/">' . agileResource('search') . '</a></li>';
				
				// END KUTCHANNEL ITEMS

				if (is_authed()) {
					echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>';
				}
				
			echo '</ul>';
			echo '<br style="clear: left" />';
			echo '</div>';
}

function displayDropdownPageForward() {

	echo'<script language="JavaScript">
		function goto(form) { var index=form.select.selectedIndex
		if (form.select.options[index].value != "0") {
		location=form.select.options[index].value;}}
	</script>';

	echo '<form name="form1">';
		echo '<select name="select" onchange="goto(this.form)" size="1">';
		echo '<option value="">' . agileResource('navigateTheNetwork') . '</option>';
		$resultGetSiteList = mysql_query("SELECT * FROM nisekocms_site");
		while($rowGetSite = mysql_fetch_array($resultGetSiteList)) {
			echo '<option value="' . $rowGetSite['siteUrlEnglish'] . languageUrlPrefix() . '">';
			if ($_SESSION['lang'] == 'ja') { echo $rowGetSite['siteTitleJapanese']; } else { echo $rowGetSite['siteTitleEnglish']; }
			echo '</option>';
		}
		echo '</select>';
	echo '</form>';
	
}

function getManagerMenu() {
	if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') {
		echo '<li><a href="' . languageUrlPrefix() . 'settings/">' . agileResource('siteManager') . '</a>';
			echo '<ul>';

				echo '<li><a href="' . languageUrlPrefix() . 'users/">' . agileResource('users') . '</a></li>';
				
				echo '<li><a href="' . languageUrlPrefix() . 'settings/">' . agileResource('siteSettings') . '</a>';
					echo '<ul>';
						echo '<li><a href="' . languageUrlPrefix() . 'menus/">' . agileResource('menus') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'manage-content/">' . agileResource('content') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'manage-images/">' . agileResource('images') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'themes/">' . agileResource('themes') . '</a></li>';
					echo '</ul>';
				echo '</li>';
				
				echo '<li><a href="' . languageUrlPrefix() . 'store/product/">' . agileResource('shop') . '</a>';
					echo '<ul>';
						echo '<li><a href="' . languageUrlPrefix() . 'store/product/">' . agileResource('products') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'store/product/category/">' . agileResource('categories') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'store/product/manufacturer/">' . agileResource('manufacturers') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'store/order/">' . agileResource('order') . '</a></li>';
					echo '</ul>';
				echo '</li>';
				
				echo '<li><a href="' . languageUrlPrefix() . 'products-and-services/">' . agileResource('accounting') . '</a>';
					echo '<ul>';
						echo '<li><a href="' . languageUrlPrefix() . 'products-and-services/">' . agileResource('productsAndServices') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'expense/">' . agileResource('expenses') . '</a>';
							echo '<ul>';
								echo '<li><a href="' . languageUrlPrefix() . 'vendor/">' . agileResource('Vendors & Payees') . '</a></li>';
								echo '<li><a href="' . languageUrlPrefix() . 'expense-classification/">' . agileResource('Expense Classification') . '</a></li>';
								echo '<li><a href="' . languageUrlPrefix() . 'expense-classification-category/">' . agileResource('Expense Classification Category') . '</a></li>';
							echo '</ul>';
						echo '</li>';
						echo '<li><a href="' . languageUrlPrefix() . 'payments/">' . agileResource('payments') . '</a>';
							echo '<ul>';
								echo '<li><a href="' . languageUrlPrefix() . 'payment-methods/">' . agileResource('paymentMethods') . '</a></li>';
							echo '</ul>';
						echo '</li>';
					echo '</ul>';
				echo '</li>';
				
				echo '<li><a href="' . languageUrlPrefix() . 'manage-contracts/">' . agileResource('contracts') . '</a></li>';
				
				echo '<li><a href="' . languageUrlPrefix() . 'groups/">' . agileResource('shigoto') . '</a>';
					echo '<ul>';
						echo '<li><a href="' . languageUrlPrefix() . 'groups/">' . agileResource('groups') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'projects/">' . agileResource('projects') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'shigoto-classifications/">' . agileResource('classifications') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'skill/">' . agileResource('skillDB') . '</a></li>';
					echo '</ul>';
				echo '</li>';

				echo '<li><a href="' . languageUrlPrefix() . 'resource/">' . agileResource('resource') . '</a>';
					echo '<ul>';
						echo '<li><a href="' . languageUrlPrefix() . 'resource/">' . agileResource('language') . '</a>';
							if ($_SESSION['userID'] == 2) {
								echo '<ul><li><a href="' . languageUrlPrefix() . 'language-resource/create/">' . agileResource('createLanguageResource') . '</a><li></ul>';
							}
						
						echo '</li>';
						echo '<li><a href="' . languageUrlPrefix() . 'geography/">' . agileResource('geography') . '</a>';
							echo '<ul>';
								echo '<li><a href="' . languageUrlPrefix() . 'add-city/">' . agileResource('addCity') . '</a></li>';
								echo '<li><a href="' . languageUrlPrefix() . 'add-state/">' . agileResource('addState') . '</a></li>';
							echo '</ul>';
						echo '</li>';
					echo '</ul>';
				echo '</li>';
				
				echo '<li><a href="' . languageUrlPrefix() . 'audit-trail/">' . agileResource('auditingTools') . '</a>';
					echo '<ul>';
						echo '<li><a href="' . languageUrlPrefix() . 'audit-trail/">' . agileResource('auditTrail') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . '404-audit/">' . agileResource('404audit') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'uptime/">' . agileResource('uptime') . '</a></li>';
					echo '</ul>';
				echo '</li>';
				
				echo '<li><a href="' . languageUrlPrefix() . 'contact/">' . agileResource('support') . '</a>';
					echo '<ul>';
						echo '<li><a href="' . languageUrlPrefix() . 'contact/">' . agileResource('contact') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'documentation/">' . agileResource('documentation') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'faq/">' . agileResource('faq') . '</a></li>';
						echo '<li><a href="' . languageUrlPrefix() . 'server-configuration/">' . agileResource('serverConfiguration') . '</a></li>';
					echo '</ul>';
				echo '</li>';
			echo '</ul>';
		echo '</li>';
	}
}

function getKutchannelSponsorMenu() {
	if ($_SESSION['userRoleForCurrentSite'] == 'siteClient') {
		echo '<li><a href="' . languageUrlPrefix() . 'invoices/">' . agileResource('sponsor') . '</a></li>';
	}
}

function displayNewKutchannelMenu() {

	echo '<div id="smoothmenu1" class="ddsmoothmenu"">';
					
					echo '<ul>';
						
						echo '<li>';
							echo '<a href="http://niseko.kutchannel.net/' . languageUrlPrefix();
									if (is_authed()) {
										// if (isset($_GET['lang'])) { echo '&'; } else { echo '?'; }
										echo 'token=' . $_SESSION['userToken'];
									}
								echo '">';
								if (is_authed()) { echo agileResource('home'); } else { echo agileResource('niseko'); }
							echo '</a>';
						echo '</li>';
						
						echo '<li><a href="http://nisekonews.net/' . languageUrlPrefix();
							if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
						echo '">' . agileResource('hotPotato') . '</a>';
						
							echo '<ul>';
							
								echo '<li><a href="http://nisekonews.net/' . languageUrlPrefix();
									if (is_authed()) {
										// if (isset($_GET['lang'])) { echo '&'; } else { echo '?'; }
										echo 'token=' . $_SESSION['userToken'];
									}
								echo '">' . agileResource('news') . '</a></li>';
									
								echo '<li><a href="http://nisekocalendar.com/' . languageUrlPrefix();
									if (is_authed()) {
										// if (isset($_GET['lang'])) { echo '&'; } else { echo '?'; }
										echo 'token=' . $_SESSION['userToken'];
									}
								echo '">' . agileResource('events') . '</a></li>';
								echo '<li><a href="http://nisekosnowforecast.com/' . languageUrlPrefix();
									if (is_authed()) {
										// if (isset($_GET['lang'])) { echo '&'; } else { echo '?'; }
										echo 'token=' . $_SESSION['userToken'];
									}
								echo '">' . agileResource('snowForecast') . '</a></li>';
								echo '<li><a href="http://nisekosnowreport.com/' . languageUrlPrefix();
									if (is_authed()) {
										// if (isset($_GET['lang'])) { echo '&'; } else { echo '?'; }
										echo 'token=' . $_SESSION['userToken'];
									}
								echo '">' . agileResource('snowReport') . '</a></li>';
								echo '<li><a href="http://nisekoavalanche.info/' . languageUrlPrefix();
									if (is_authed()) {
										// if (isset($_GET['lang'])) { echo '&'; } else { echo '?'; }
										echo 'token=' . $_SESSION['userToken'];
									}
								echo '">' . agileResource('avalancheInfo') . '</a></li>';
								echo '<li><a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . 'forum/';
									if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
								echo '">' . agileResource('forum') . '</a>';
							echo '</ul>';
							
						echo '</li>';
						
						echo '<li><a href="http://nisekohokkaido.com/' . languageUrlPrefix();
							if (is_authed()) {
								// if (isset($_GET['lang'])) { echo '&'; } else { echo '?'; }
								echo 'token=' . $_SESSION['userToken'];
							}
						echo '">' . agileResource('areaGuide') . '</a>';
						
							echo '<ul>';
							
								echo '<li><a href="http://nisekohokkaido.com/' . languageUrlPrefix();
									if (is_authed()) {
										// if (isset($_GET['lang'])) { echo '&'; } else { echo '?'; }
										echo 'token=' . $_SESSION['userToken'];
									}
								echo '">' . agileResource('resorts') . '</a>';
								
									echo '<ul>';
									
										echo '<li><a href="http://nisekohokkaido.com/' . languageUrlPrefix() . 'hirafu/';
											if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
										echo '">' . agileResource('hirafu') . '</a></li>';
								
										echo '<li><a href="http://nisekohokkaido.com/' . languageUrlPrefix() . 'hanazono/';
											if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
										echo '">' . agileResource('hanazono') . '</a></li>';
										
										echo '<li><a href="http://nisekohokkaido.com/' . languageUrlPrefix() . 'higashiyama/';
											if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
										echo '">' . agileResource('higashiyama') . '</a></li>';
								
										echo '<li><a href="http://nisekohokkaido.com/' . languageUrlPrefix() . 'annupuri/';
											if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
										echo '">' . agileResource('annupuri') . '</a></li>';
								
										echo '<li><a href="http://nisekohokkaido.com/' . languageUrlPrefix() . 'moiwa/';
											if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
										echo '">' . agileResource('moiwa') . '</a></li>';
								
										echo '<li><a href="http://nisekohokkaido.com/' . languageUrlPrefix() . 'rusutsu/';
											if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
										echo '">' . agileResource('rusutsu') . '</a></li>';
									echo '</ul>';
								echo '</li>';
								
								echo '<li><a href="http://nisekorestaurants.com/' . languageUrlPrefix();
									if (is_authed()) {
										// if (isset($_GET['lang'])) { echo '&'; } else { echo '?'; }
										echo 'token=' . $_SESSION['userToken'];
									}
								echo '">' . agileResource('restaurants') . '</a></li>';
								echo '<li><a href="http://nightlife.nisekobars.com/' . languageUrlPrefix();
									if (is_authed()) {
										// if (isset($_GET['lang'])) { echo '&'; } else { echo '?'; }
										echo 'token=' . $_SESSION['userToken'];
									}
								echo '">' . agileResource('barsAndNightlife') . '</a></li>';
								echo '<li><a href="http://nisekoshopping.com/' . languageUrlPrefix();
									if (is_authed()) {
										// if (isset($_GET['lang'])) { echo '&'; } else { echo '?'; }
										echo 'token=' . $_SESSION['userToken'];
									}
								echo '">' . agileResource('shopping') . '</a></li>';
								echo '<li><a href="http://nisekodelivery.com/' . languageUrlPrefix();
									if (is_authed()) {
										// if (isset($_GET['lang'])) { echo '&'; } else { echo '?'; }
										echo 'token=' . $_SESSION['userToken'];
									}
								echo '">' . agileResource('delivery') . '</a></li>';

								
							echo '</ul>';
						echo '</li>';
						
						echo '<li><a href="http://nisekoproperty.net/' . languageUrlPrefix();
									if (is_authed()) {
										// if (isset($_GET['lang'])) { echo '&'; } else { echo '?'; }
										echo 'token=' . $_SESSION['userToken'];
									}
								echo '">' . agileResource('property') . '</a></li>';
						
						echo '<li><a href="http://nisekoaccommodation.net/' . languageUrlPrefix();
									if (is_authed()) {
										// if (isset($_GET['lang'])) { echo '&'; } else { echo '?'; }
										echo 'token=' . $_SESSION['userToken'];
									}
								echo '">' . agileResource('accommodation') . '</a></li>';
						
						echo '<li><a href="http://nisekojobs.com/' . languageUrlPrefix();
									if (is_authed()) {
										// if (isset($_GET['lang'])) { echo '&'; } else { echo '?'; }
										echo 'token=' . $_SESSION['userToken'];
									}
								echo '">' . agileResource('jobs') . '</a></li>';
								
						echo '<li><a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . 'for-sale/';
									if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
								echo '">' . agileResource('ads') . '</a>';
							echo '<ul>';
								echo '<li><a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . 'for-sale/';
									if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
								echo '">' . agileResource('forSale') . '</a></li>';
								echo '<li><a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . 'wanted/';
									if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
								echo '">' . agileResource('wanted') . '</a></li>';
								echo '<li><a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . 'services/';
									if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
								echo '">' . agileResource('services') . '</a></li>';
								echo '<li><a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . 'personals/';
									if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
								echo '">' . agileResource('personals') . '</a></li>';
							echo '</ul>';
						echo '</li>';
						
						// echo '<li><a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . 'contact/">' . agileResource('contact') . '</a></li>';
						
						// if (is_authed()) { 
							// echo '<li><a href="' . languageUrlPrefix() . 'user/update/' . $_SESSION['userID'] . '/">' . agileResource('profile') . '</a></li>';
							// echo '<li><a href="' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a></li>';
						// }
						
						if ($_SESSION['userRoleForCurrentSite'] == 'siteClient') { getKutchannelSponsorMenu(); }
						
						if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') { getManagerMenu(); }
						
					echo '</ul>';
					
					if ($_SESSION['userRoleForCurrentSite'] != 'siteManager' && $_SESSION['userRoleForCurrentSite'] != 'siteClient') { // too crowded...
						echo '<div style="float:left;margin:3px;">';
							echo '<a href="' . getSiteUrl() . '/rss/"><img src="agileImages/rss-24x24y.png"></a> ';
							echo '<a href="http://twitter.com/' . getSiteTwitter() . '"><img src="agileImages/twitter-24x24y.png"></a> ';
							echo '<a href="http://facebook.com/kutchannel"><img src="agileImages/facebook.png"></a> ';
							echo '<g:plusone></g:plusone>';
						echo '</div>';
					}
				
					displayLanguageFlagLinks('float:right;margin:3px;border-style:none;', 'margin:3px 1px 1px 1px;padding:1px;border:1px solid #999;');
					
					
					echo '<br style="clear:left;" />';
					
			echo '</div>';
}

?>