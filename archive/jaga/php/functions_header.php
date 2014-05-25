<?php

function displayHeader($titleTag = '', $descriptionMetaTag = '', $keywordsMetaTag = '', $contentID = 0) {

	totalPagePlusOne();
	// recordSiteStatistics();
	
	if (
		!is_authed() 
		&& $_SERVER['REQUEST_URI'] != '/login/' 
		&& $_SERVER['REQUEST_URI'] != '/ja/login/'
	) { $_SESSION['forwardUponLogin'] = $_SERVER['REQUEST_URI']; }

	if ($titleTag == '') { $titleTag = getSiteTitle(); }
	if ($descriptionMetaTag == '') { $descriptionMetaTag = getSiteDescription(); }
	if ($keywordsMetaTag == '') { $keywordsMetaTag = getSiteKeywords(); }
	
	if ($_SESSION['siteID'] == 61) { $baseUrl = 'http://niseko.kutchannel.net/'; } else { $baseUrl = getSiteURL(); }
	
	$contentPrimarySiteID = getContentSiteID($contentID);
	$canonicalDomainURL = getSiteURLWithID($contentPrimarySiteID);

	$currentURL = urldecode(preg_replace('/^%2F(en%2F|ja%2F)?/', '', urlencode($_SERVER['REQUEST_URI']), 1));
	
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
		echo '<html xmlns="http://www.w3.org/1999/xhtml">';
			echo '<head>';

				echo '<base href="' . $baseUrl . '" />';
				echo '<title>' . $titleTag . '</title>';
				echo '<meta http-equiv="Content-Language" content="' . $_SESSION['lang'] . '" />';
				echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
				echo '<meta name="description" content="' . $descriptionMetaTag . '" />';
				echo '<meta name="keywords" content="' . $keywordsMetaTag . '" />';
				
				// if (getSiteGoogleSiteVerification($_SESSION['siteID']) != '') {
				if (getSiteGoogleSiteVerification($_SESSION['siteID']) != '' && $_SESSION['siteID'] != 14) {
					echo '<meta name="google-site-verification" content="' . getSiteGoogleSiteVerification($_SESSION['siteID']) . '" />';
				}
				
				if ($_SESSION['siteID'] == 14) { echo '<meta name="alexaVerifyID" content="aOmLRdH3c5SENIuWF_VoQdxSUbo" />'; }
				
				if ($_SESSION['siteID'] == 55) {
					echo '<meta property="og:image" content="' . $baseUrl . '/agileThemes/' . getSiteTheme() . '/images/fb-thumb.png" />';
				} else {
					echo '<meta property="og:image" content="' . $baseUrl . '/agileThemes/' . getSiteTheme() . '/images/fb-logo.png" />';
				}
				
				
				
				echo '<meta name="generator" content="' . agileResource('nisekocms') . '" />';
				echo '<meta name="creator" content="' . agileResource('agileHokkaido') . '" />';
				echo '<link rel="stylesheet" type="text/css" href="/agileThemes/' . getSiteTheme() . '/css/theme.css" />';
				echo '<link rel="stylesheet" type="text/css" href="/agileJs/calendar/calendar-blue.css" />';
				
				echo '<link rel="stylesheet" type="text/css" href="/agileModules/agileCalendar/view/nisekocms_calendar.css" />';
				
				echo '<link rel="shortcut icon" href="/agileThemes/' . getSiteTheme() . '/images/favicon.ico" type="image/x-icon" />';
				echo '<link rel="alternate" type="application/rss+xml" title="RSS" href="/rss/">';
				echo '<link rel="sitemap" type="application/xml" title="sitemap" href="sitemap.xml" />';
		
				if ($_SESSION['siteID'] == 61) {
					echo '<link rel="canonical" href="http://niseko.kutchannel.net/' . languageUrlPrefix() . $currentURL . '"/>';
				} elseif ($contentID != 0) {
					echo '<link rel="canonical" href="' . $canonicalDomainURL . '/' . getContentListURL(getContentCategoryKey($contentID)) . $contentID . '/"/>';
				}
			
				echo '<!--[if lte IE 7]><style type="text/css">html .ddsmoothmenu{height: 1%;}</style><![endif]-->';
				echo '<script type="text/javascript" src="/agileAjax/geography.js"></script>';
				echo '<script type="text/javascript" src="/agileAjax/clientProperty.js"></script>';
				echo '<script type="text/javascript" src="/agileAjax/shigotoFilter.js"></script>';
				echo '<script type="text/javascript" src="/agileJs/ckeditor/ckeditor.js"></script>';
				echo '<script type="text/javascript" src="/agileJs/agileCoffee.js"></script>';
				
				
				
				echo '<script type="text/javascript" src="/agileJs/calendar/calendar.js"></script>';
				echo '<script type="text/javascript" src="/agileJs/calendar/lang/calendar-en.js"></script>';
				echo '<script type="text/javascript" src="/agileJs/calendar/calendar-setup.js"></script>';
				
				echo '<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>';
				// echo '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>';
				
				// echo '<script type="text/javascript" src="/agileJs/masonry/masonry.pkgd.min.js"></script>';
				
				echo '<script type="text/javascript" src="/agileThemes/' . getSiteTheme() . '/javascript/ddsmoothmenu.js"></script>';
				echo '<script type="text/javascript" src="/agileJs/transition/togglelayer.js"></script>';
				echo '<script type="text/javascript" src="/agileJs/transition/mootools.v1.11.js"></script>';
				echo '<script type="text/javascript" src="/agileJs/transition/jd.gallery.js"></script>';
				echo '<script type="text/javascript" src="/agileJs/transition/preload.js"></script>';

				
echo '

		<SCRIPT TYPE="text/javascript">
			<!--
				function agilePopUp(mylink, windowname) {
					if (! window.focus)return true;
						var href;
					if (typeof(mylink) == \'string\')
						href=mylink;
					else
						href=mylink.href;
					window.open(href, windowname, \'width=1000,height=600,location=yes,scrollbars=yes\');
					return false;
				}
			//-->
		</SCRIPT>
		
		<SCRIPT TYPE="text/javascript">
			function calculateTransactionTotal() {
			var transactionQuantity=document.getElementById("transactionQuantity").value;
			var transactionUnitPrice=document.getElementById("transactionUnitPrice").value;
			document.getElementById("transactionTotal").value=transactionQuantity*transactionUnitPrice;
		}
		</SCRIPT>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$(\'#photos\').galleryView({
					panel_width: 633,
					panel_height: 422,
					frame_width: 100,
					frame_height: 62,
					pause_on_hover: true,
					background_color: \'white\',
					border: \'none\',
					nav_theme: \'dark\'
				});
			});
		</script>
		
		<script type="text/javascript">
			function startGallery() {
				var myGallery = new gallery($(\'myGallery\'), {
				});
				document.gallery = myGallery;
			}
			window.onDomReady(startGallery);
		</script>
		
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push([\'_setAccount\', \'' . getSiteAnalytics() . '\']);
			_gaq.push([\'_trackPageview\']);
			(function() {
				var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
				ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
				var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
		
		
';
				echo '<script type="text/javascript" src="https://apis.google.com/js/plusone.js">';
					if ($_SESSION['lang'] == 'ja') { echo '{ lang: \'ja\'}'; }
				echo '</script>';
		
			echo '</head>';
	
			echo '<body>';
			
			echo '
			
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=119713071407082";
					fjs.parentNode.insertBefore(js, fjs);
				}(document, \'script\', \'facebook-jssdk\'));
				</script>
				
			';
			
				if ($_SESSION['siteID'] == 14) {
				
					echo '
					
						<!-- Start Alexa Certify Javascript -->
							<script type="text/javascript">
							_atrk_opts = { atrk_acct:"HrPti1aUS/00gZ", domain:"kutchannel.net",dynamic: true};
							(function() { var as = document.createElement(\'script\'); as.type = \'text/javascript\'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName(\'script\')[0];s.parentNode.insertBefore(as, s); })();
							</script>
							<noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=HrPti1aUS/00gZ" style="display:none" height="1" width="1" alt="" /></noscript>
						<!-- End Alexa Certify Javascript -->
					
					';
				
				}

				// if ($_SESSION['testMode'] == 'on') {
					// echo '<div style="margin:0px auto 5px auto;background-color:#fff;text-align:left;width:900px;">';
						// echo '$_SERVER[\'HTTP_HOST\'] = ' . $_SERVER['HTTP_HOST'] . '<br />';
						// echo '$_SERVER[\'REQUEST_URI\'] = ' . $_SERVER['REQUEST_URI'] . '<br />';
						// echo '$_SERVER[\'PHP_SELF\'] = ' . $_SERVER['PHP_SELF'] . '<br />';
						// echo '$_SERVER[\'QUERY_STRING\'] = ' . $_SERVER['QUERY_STRING'];
						
					// echo '</div>';
				// }
			
				if ($_SESSION['siteID'] == 2) { // NisekoHokkaido.com

					displayKutchannelHeader();
					
				} elseif ($_SESSION['siteID'] == 3) { // niseko.us

					displayKutchannelHeader();
					
				} elseif ($_SESSION['siteID'] == 4) { // nisekonews.net

					// echo '<div style="width:900px;margin:0px auto 0px auto;color:#fff;">' . getSiteDescription() . '. Welcome to ' . getSiteTitle() . '!</div>';
					
					displayKutchannelHeader();
					
				} elseif ($_SESSION['siteID'] == 5) { // nisekoproperty.net

					displayKutchannelHeader();

				} elseif ($_SESSION['siteID'] == 6) { // nisekorestaurants.com

					displayKutchannelHeader();

				} elseif ($_SESSION['siteID'] == 8) { // NisekoAccommodation.net

					/* echo '<div style="width:900px;margin:0px auto 0px auto;color:#fff;">Niseko\'s uniquely open accommodation guide. Find a place to stay, somebody to stay in your place, or even a roommate.<br />Find houses, apartments, condominiums, hotels, pensions, lodges, igloos, and more at NisekoAccommodation.net!</div>'; */
				
					displayKutchannelHeader();
					

				} elseif ($_SESSION['siteID'] == 9) { // NisekoShopping.com

					displayKutchannelHeader();

				} elseif ($_SESSION['siteID'] == 10) { // NisekoCalendar.com

					displayKutchannelHeader();

				} elseif ($_SESSION['siteID'] == 11) { // NisekoSnowForecast.com

					displayKutchannelHeader();
					
				} elseif ($_SESSION['siteID'] == 12) { // NisekoSnowReport.com

					displayKutchannelHeader();

				} elseif ($_SESSION['siteID'] == 13) { // nisekoweb.com

					displayKutchannelHeader();

				} elseif ($_SESSION['siteID'] == 14) { // niseko.kutchannel.net

					displayKutchannelHeader();

				} elseif ($_SESSION['siteID'] == 15) { // NisekoGolf.info

					displayKutchannelHeader();
						
				} elseif ($_SESSION['siteID'] == 16) { // nisekofirstsnow.com

					displayKutchannelHeader();

				} elseif ($_SESSION['siteID'] == 17) { // nisekoavalanche.info

					displayKutchannelHeader();

				} elseif ($_SESSION['siteID'] == 18) { // nisekojobs.com

					displayKutchannelHeader();

				} elseif ($_SESSION['siteID'] == 19) { // NisekoMagazine.com

					displayKutchannelHeader();

				} elseif ($_SESSION['siteID'] == 20) { // NisekoDelivery.com

					displayKutchannelHeader();

				} elseif ($_SESSION['siteID'] == 48) { // HirafuHighRollers.com

					displayKutchannelHeader();

				} elseif ($_SESSION['siteID'] == 52) { // NisekoSki.net

					displayKutchannelHeader();

				} elseif ($_SESSION['siteID'] == 53) { // NisekoSnowboarding.com

					displayKutchannelHeader();

				} elseif ($_SESSION['siteID'] == 21) { // hakodateguide.com

					echo '<div id="nisekoHeader">';
					$randomImageNumber = rand(1, 7);
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					echo '</div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 22) { // agilehokkaido.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 23) { // nisekocms.com

					displayKutchannelHeader();
					/*
					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';
					*/

				} elseif ($_SESSION['siteID'] == 24) { // nightlife.nisekobars.com

					displayKutchannelHeader();

				} elseif ($_SESSION['siteID'] == 25) { // agilekarada.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
						displayMenu();
						echo '<hr />';
						echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 26) { // preciousbox.agilehokkaido.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
						displayMenu();
						echo '<hr />';
						echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 27) { // wine.nisekoshopping.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 28) { // agileeikaiwa.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 29) { // beatbox.jp

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 30) { // agileshigoto.com

					echo '<div id="nisekoHeader">';
						if (!is_authed()) {
							echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
							getLanguageFlagLinks();
							displayHeaderTitleAndTagLine();
							displayHeaderImageLinks();
						} else {
							getLanguageFlagLinks();
							displayHeaderTitleAndTagLine();
						}
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 31) { // no.realtycms.com

					
					if ($_SESSION['userRoleForCurrentSite'] != 'siteClient') { displayMenu(); }
					if (!is_authed() || $_SESSION['userRoleForCurrentSite'] == 'siteClient') { getLanguageFlagLinks(); }
					
					
						echo '<div id="nisekoHeader">';
							// if (!is_authed()) {
								echo '<div>';
								
									echo '<div style="float:left;">';
										echo '<a href="/' . languageUrlPrefix() . '">';
											echo '<img src="/agileThemes/nisown/images/logo.png">';
										echo '</a>';
									echo '</div>';
									
									echo '<div style="float:right;">';
									
										echo '<nav id="navigation">';
									
										echo '<ul>';
											echo '<li><a id="nisownMenuProperty" href="' . languageUrlPrefix() . 'property/">' . agileResource('properties') . '</a>';
												echo '<span class="nisownSeparator"></span>';
											echo '</li>';
											echo '<li><a id="nisownMenuLearnMore" href="' . languageUrlPrefix() . 'about/">' . agileResource('learnMore') . '</a>';
												echo '<span class="nisownSeparator"></span>';
											echo '</li>';
											echo '<li><a id="nisownMenuContactUs" href="' . languageUrlPrefix() . 'contact-us/">' . agileResource('contactUs') . '</a>';
												echo '<span class="nisownSeparator"></span>';
											echo '</li>';
											echo '<li><a id="nisownMenuOwnerLogin" href="' . languageUrlPrefix() . 'login/">' . agileResource('ownerLogin') . '</a></li>';
										echo '</ul>';
										
										echo '</nav>';
										
									echo '</div>';
									echo '<div style="clear:both;"></div>';
									
								echo '</div>';
							/*
							} else {
								echo '<div style="padding:3px;">';
									echo '<img src="agileThemes/nisown/images/logo.png">';
								echo '</div>';
							}
							*/
						echo '</div>';
						
					
					echo '<div id="nisekoContainer">';
					
						if ($_SESSION['userRoleForCurrentSite'] == 'siteClient') {
							echo '<div id="ownerNavigation">';
								echo '<a class="ownerNavigation" href="/' . languageUrlPrefix() . 'property-details/">' . agileResource('propertyDetails') . '</a>';
									echo '|';
								echo '<a class="ownerNavigation" href="/' . languageUrlPrefix() . 'contracts/">' . agileResource('agreements') . '</a>';
									echo '|';
								echo '<a class="ownerNavigation" href="/' . languageUrlPrefix() . 'invoices/">' . agileResource('invoices') . '</a>';
									echo '|';
								echo '<a class="ownerNavigation" href="/' . languageUrlPrefix() . 'trust-cashflow/">' . agileResource('cashFlow') . '</a>';
									echo '|';
								echo '<a class="ownerNavigation" href="/' . languageUrlPrefix() . 'bank-information/">' . agileResource('bankInformation') . '</a>';
									echo '|';
								echo '<a class="ownerNavigation" href="/' . languageUrlPrefix() . 'profile/' . $_SESSION['userID'] . '/">' . agileResource('profile') . '</a>';
									echo '|';
								echo '<a class="ownerNavigation" href="/' . languageUrlPrefix() . 'logout/">' . agileResource('logout') . '</a>';
							echo '</div>';
						}
					
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 33) { // nc.realtycms.com

					getLanguageFlagLinks();
					echo '<div id="nisekoHeader">';
					
						echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'">';
							
							// OLD echo '<img src="agileThemes/niscon/images/banner.png">';
							
							// NEW echo '<img src="/agileThemes/niscon/images/headerbar.png" width="738" height="65" vspace="10" border="0" usemap="#Map" class="b0" />';
							
							echo '<img src="agileThemes/niscon/images/banner.png" width="738" height="65" vspace="10" border="0" usemap="#Map" class="b0">';
							
							echo '
							<map name="Map" id="Map">
								<area shape="rect" coords="1,1,491,64" href="home/" alt="Home" />
								<area shape="rect" coords="556,33,615,55" href="japanese/" alt="Japanese" />
								<area shape="rect" coords="626,33,671,56" href="chinese/" alt="Chinese" />
								<area shape="rect" coords="682,35,700,52" href="http://www.facebook.com/pages/Kutchan-Japan/Niseko-Consulting-Co-Ltd/37980599048" alt="Facebook" />
								<area shape="rect" coords="702,35,720,52" href="http://twitter.com/nisekocon" alt="Twitter" />
							</map>
							';
							
						echo '</div>';
						

					echo '</div>';
					
					echo '<div id="nisekoContainer">';
					
						displayMenu();

						echo '<div id="nisekoMain">';
					
				} elseif ($_SESSION['siteID'] == 36) { // tw1t.net

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 37) { // cswebb.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 38) { // agileaccounting.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 39) { // agilejapan.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 40) { // agilepos.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 41) { // certififiedcellars.net

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 42) { // daisetsuzan.net

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 43) { // dogapult.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 44) { // drupaljapan.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 45) { // ezoproperty.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 46) { // hakowebb.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 47) { // hatsu33.com // dead domain

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 48) { // hirafuhighrollers.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 49) { // hokkaidohosting.com
					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 50) { // joomlajapan.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 51) { // nisekomagazine.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 52) { // nisekoski.net

					displayKutchannelHeader();

				} elseif ($_SESSION['siteID'] == 53) { // nisekosnowboarding.com

					displayKutchannelHeader();

				} elseif ($_SESSION['siteID'] == 54) { // powderproperty.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 55) { // redpilljapan.com

					// echo '<div id="nisekoHeader">';
					// echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					// getLanguageFlagLinks();
					// displayHeaderTitleAndTagLine();
					// displayHeaderImageLinks();
					// echo '</div>';
					// echo '<div id="nisekoContainer">';
					// displayMenu();
					// echo '<hr />';
					// echo '<div id="nisekoMain">';
					
					displayKutchannelHeader();

				} elseif ($_SESSION['siteID'] == 56) { // shiyagare.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 57) { // suntzuhiphop.com // dead domain

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 58) { // tourdehokkaido.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 59) { // wordpressjapan.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 60) { // ngcompton.com

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 61) { // kutchannel.net

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 62) { // kutchan.net

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				} elseif ($_SESSION['siteID'] == 67) { // seattledatahosting.com

					echo '<div style="width:900px;margin:0px auto 0px auto;">';
						displayMenu();
					echo '</div>';
					
					echo '<div id="nisekoHeader">';
						displayHeaderTitleAndTagLine();
					echo '</div>';
					
					echo '<div id="nisekoContainer">';
						echo '<div id="nisekoMain">';

				} else {

					echo '<div id="nisekoHeader">';
					echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'"></div>';
					getLanguageFlagLinks();
					displayHeaderTitleAndTagLine();
					displayHeaderImageLinks();
					echo '</div>';
					echo '<div id="nisekoContainer">';
					displayMenu();
					echo '<hr />';
					echo '<div id="nisekoMain">';

				}
				
}

function getTemporaryNisekoLinkCloudForBanner() {
	 echo '<div id="headerBannerImage" onClick="location.href=\'' . getSiteURL() . '\'">';
		echo '<div style="float:left;margin-top:110px;width:510px;text-align:center;">';
					echo '<a class="sakura" href="http://NisekoHokkaido.com/' . languageUrlPrefix() . '">' . agileResource('areaGuide') . '</a>&nbsp;';
					echo '<a class="sakura" href="http://NisekoNews.net/' . languageUrlPrefix() . '">' . agileResource('news') . '</a>&nbsp;';
					echo '<a class="sakura" href="http://niseko.kutchannel.net/' . languageUrlPrefix() . '">' . agileResource('classifiedAds') . '</a>&nbsp;';
					echo '<a class="sakura" href="http://niseko.kutchannel.net/' . languageUrlPrefix() . 'forum/">' . agileResource('forum') . '</a>&nbsp;';
					echo '<a class="sakura" href="http://NisekoSnowReport.com/' . languageUrlPrefix() . '">' . agileResource('snowReports') . '</a>&nbsp;';
					echo '<a class="sakura" href="http://NisekoCalendar.com/' . languageUrlPrefix() . '">' . agileResource('events') . '</a>&nbsp;';
					echo '<a class="sakura" href="http://NisekoJobs.com/' . languageUrlPrefix() . '">' . agileResource('jobs') . '</a><br />';
					echo '<a class="sakura" href="http://NisekoAccommodation.net/' . languageUrlPrefix() . '">' . agileResource('accommodation') . '</a>&nbsp;';
					echo '<a class="sakura" href="http://NisekoProperty.net/' . languageUrlPrefix() . '">' . agileResource('propertyAndRealEstate') . '</a>&nbsp;';
					echo '<a class="sakura" href="http://NisekoRestaurants.com/' . languageUrlPrefix() . '">' . agileResource('restaurants') . '</a>&nbsp;';
					echo '<a class="sakura" href="http://Nightlife.NisekoBars.com/' . languageUrlPrefix() . '">' . agileResource('nightlife') . '</a>&nbsp;';
					echo '<a class="sakura" href="http://NisekoShopping.com/' . languageUrlPrefix() . '">' . agileResource('shopping') . '</a>';
		echo '</div>';
	echo '</div>';
}

function getLanguageFlagLinks() {

	if ($_SESSION['siteID'] == 27) {
		$iso3166 = 'au';
	} elseif (in_array('nisekopass', $_SESSION['siteModuleArray'])) {
		$flagArray = array();
		$flagArray['us'] = 0;
		$flagArray['en'] = 1;
		$flagArray['au'] = 2;
		$iso3166 = array_rand($flagArray);
	} else { $iso3166 = 'us'; }
	
	$currentURL = urldecode(preg_replace('/^%2F(en%2F|ja%2F)?/', '', urlencode($_SERVER['REQUEST_URI']), 1));
	echo '<div style="float:right;text-align:right;height:20px;width:374px;margin:5px 10px 1px 1px;">';
			// displayDropdownPageForward();
		echo '<a href="/' . $currentURL . '"><img src="/agileImages/' . $iso3166 . '.gif" alt="English" style="margin:10px 1px 1px 0px;border:1px solid #0971a1;" /></a>';
		echo '<a href="ja/' . $currentURL . '"><img src="/agileImages/ja.gif" alt="Japanese" style="margin:10px 8px 1px 1px;border:1px solid #0971a1;" /></a>';
	echo '</div>';
	echo '<div style="clear:right;"></div>';
}

function getNewLanguageFlagLinks() {
	
	$currentURL = urldecode(preg_replace('/^%2F(en%2F|ja%2F)?/', '', urlencode($_SERVER['REQUEST_URI']), 1));
	
	// if ($_SESSION['siteID'] == 27) { $iso3166 = 'au'; } elseif ($_SESSION['siteID'] == 14) { $iso3166 = 'us'; } else { $iso3166 = 'en'; }
	$iso3166 = 'us';
	
	echo '<div style="float:right;">';
		echo '<a href="/' . $currentURL . '">';
			echo '<img src="/agileImages/' . $iso3166 . '.gif" alt="English" style="margin:6px 1px 0px 1px;padding:2px;border:solid 1px #ccc;" />';
		echo '</a>';
		echo '<a href="ja/' . $currentURL . '">';
			echo '<img src="/agileImages/ja.gif" alt="Japanese" style="margin:6px 1px 0px 1px;padding:2px;border:solid 1px #ccc;" />';
		echo '</a>';
	echo '</div>';
	echo '<div style="clear:right;"></div>';
}

function displayHeaderTitleAndTagLine(
	$float = 'right', 
	$textAlign = 'center', 
	$height = 73, 
	$width = 374, 
	$margin = '1px 10px 1px 1px', 
	$overflow = 'auto'
) {
		echo '<div style="float:' . $float . ';text-align:' . $textAlign . ';height:' . $height . 'px;width:' . $width . 'px;margin:' . $margin . ';overflow:' . $autoflow . ';">';
			echo '<h1 id="headerSiteHeadline">' . getSiteHeadline() . '</h1>';
			echo '<h2 id="headerSiteTagline">' . getSiteTagline() . '</h2>';
		echo '</div>';
		echo '<div style="clear:right;"></div>';
}

function displayHeaderImageLinks() {

		echo '<div style="float:right;text-align:center;height:35px;width:374px;margin:1px 10px 1px 1px;">';
		
			// if ($_SESSION['siteID'] != 31 && $_SESSION['siteID'] != 33) { // don't use for NisCon and NisOwn
			if ($_SESSION['siteID'] != 67) { // don't use for SeattleDataHosting.com
				if (!is_authed()) {
					
						echo'<form action="' . languageUrlPrefix() . 'login/" method="post" style="margin:0px;">';
							echo '<input type="text" maxlength="255" style="margin:1px;padding:1px;width:80px;" name="userName" value="username" onfocus="if(this.value==\'username\')this.value=\'\'" />';
							echo '<input type="password" maxlength="255" style="margin:1px;padding:1px;width:80px;" name="userPassword" value="password" onfocus="if(this.value==\'password\')this.value=\'\'" />';
							echo '<input type="submit" name="submit" value="' . agileResource('login') . '" />';
							if (siteIsPublic()) {
								echo '<input type="button" value="' . agileResource('register') . '" onclick="window.location.href=\'' . languageUrlPrefix() . 'register/\'">';
							}
						echo '</form>';
						
				} else {
					
						if (in_array('nisekopass', $_SESSION['siteModuleArray'])) {
							echo '<a href="http://agilehokkaido.com/' . languageUrlPrefix() . '" target="_blank">';
								echo'<img src="agileThemes/' . getSiteTheme() . '/images/agilehokkaido.png" style="border-style:none;margin:8px 1px 2px 4px;" alt="Agile Hokkaido" />';
							echo '</a>';
							echo '<a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . '">';
								echo'<img src="agileImages/kutchannel-headerLink.png" style="border-style:none;margin:8px 1px 2px 4px;" alt="Niseko Hirafu" />';
							echo '</a>';
						}
				}
			}
			
		echo '</div>';

	echo '<div style="clear:both;"></div>';
	
}























function displayHeaderLoginForm() {
	echo'<form action="' . languageUrlPrefix() . 'login/" method="post" style="margin:0px;">';
		echo '<input type="text" maxlength="255" name="userName" style="width:50px;" value="username" onfocus="if(this.value==\'username\')this.value=\'\'" />';
		echo '<input type="password" maxlength="255" name="userPassword" style="width:50px;" value="password" onfocus="if(this.value==\'password\')this.value=\'\'" />';
		echo '<input type="submit" name="submit" value="' . agileResource('login') . '" />';
		if (siteIsPublic()) {
			echo '<input type="button" value="' . agileResource('register') . '" onclick="window.location.href=\'' . languageUrlPrefix() . 'register/\'">';
		}
	echo '</form>';
}

function displayLanguageFlagLinks($divStyle = '', $buttonStyle = '') {


	$flagArray = array();
	$flagArray['us'] = 0;
	$flagArray['en'] = 1;
	$flagArray['au'] = 2;
		
	if ($_SESSION['siteID'] == 27) {
		$iso3166 = 'au';
	} elseif (in_array('nisekopass', $_SESSION['siteModuleArray'])) {
		$iso3166 = array_rand($flagArray);
	} elseif ($_SESSION['siteID'] == 55) {
		$iso3166 = array_rand($flagArray);
	} else {
		$iso3166 = 'us';
	}
	
	$currentURL = urldecode(preg_replace('/^%2F(en%2F|ja%2F)?/', '', urlencode($_SERVER['REQUEST_URI']), 1));
	
	echo '<div style="' . $divStyle . '">';
		echo '<a href="/' . $currentURL . '"><img src="/agileImages/' . $iso3166 . '.gif" alt="English" style="' . $buttonStyle . '" /></a>';
		echo '<a href="ja/' . $currentURL . '"><img src="/agileImages/ja.gif" alt="Japanese" style="' . $buttonStyle . '" /></a>';
	echo '</div>';

}



function displayKutchannelUserWidget() {

	echo '<div style="width:153px;height:268px;border:1px solid #ccc;">';
		if (!is_authed()) {
			
			echo '<div style="margin:1px;border:1px solid #ccc;">';		
				echo'<form action="' . languageUrlPrefix() . 'login/" method="post" style="margin:0px;">';
					echo '<input type="text" maxlength="255" name="userName" style="width:100px;" value="username" onfocus="if(this.value==\'username\')this.value=\'\'" />';
					echo '<input type="password" maxlength="255" name="userPassword" style="width:100px;" value="password" onfocus="if(this.value==\'password\')this.value=\'\'" />';
					echo '<input type="submit" name="submit" style="width:100px;" value="' . agileResource('login') . '" />';
				echo '</form>';
			echo '</div>';
				
			if (siteIsPublic()) {
				echo '<div style="margin:1px;border:1px solid #ccc;">';
					echo agileResource('newToTheKutchannel');
					echo '<input type="button" style="width:100px;" value="' . agileResource('register') . '" onclick="window.location.href=\'http://niseko.kutchannel.net/' . languageUrlPrefix() . 'register/\'">';
				echo '</div>';
			}
			
		} else {
			echo 'Welcome back to The Kutchannel, ' . getUserName($_SESSION['userID']) . '!';
		}
	echo '</div>';
	
}



function displayKutchannelHeader() {
	
	// $currentURL = urldecode(preg_replace('/^%2F(en%2F|ja%2F)?/', '', urlencode($_SERVER['REQUEST_URI']), 1));

	if ($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/ja/') {
		echo '<div style="text-align:center;margin:0px auto 5px auto;color:#fff;">' . getSiteDescription() . '</div>';
	}
	$themeName = getSiteTheme();
	echo '<div id="nisekoHeader">';
		echo '<div style="float:left;">';
			// if ($_SESSION['lang'] == 'ja' && $themeName == 'kutchannel') {
				// echo '<img src="/agileThemes/' . getSiteTheme() . '/images/banner-ja.png">';
			// } else {
				echo '<img src="/agileThemes/' . getSiteTheme() . '/images/banner.png">';
			// }
				
			
		echo '</div>';
		echo '<div style="float:right;">';
			echo '<h1 id="headerSiteHeadline">' . getSiteHeadline() . '</h1>';
			echo '<h2 id="headerSiteTagline">' . getSiteTagline() . '</h2>';
		echo '</div>';
		echo '<div style="clear:both;"></div>';
		displayMenu();
	echo '</div>';
	
	echo '<div id="nisekoContainer">';
		echo '<div id="nisekoMain">';
}

	
?>