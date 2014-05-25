<?php

function displayJavaScriptTwitterWidget($keyword) {

			echo '
			<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
			<script>
				new TWTR.Widget({
					version: 2,
					type: \'search\',
					search: \'' . $keyword . '\',
					interval: 30000,
					title: \'ChishikiRadio\',
					subject: \'Now Playing\',
					width: 250,
					height: 300,
					theme: {
						shell: {
							background: \'#8ec1da\',
							color: \'#ffffff\'
						},
						tweets: {
							background: \'#ffffff\',
							color: \'#444444\',
							links: \'#1985b5\'
						}
					},
					features: {
						scrollbar: false,
						loop: true,
						live: true,
						behavior: \'default\'
					}
				}).render().start();
			</script>
		';

}

function displayBanners($divWidth = 250) {

	

	echo '<div style="float:right;text-align:center;width:' . $divWidth .'px;margin:0px 5px 0px 5px;border:solid 1px #ccc;">';
	
		if ($_SESSION['siteID'] != 23) {
			displayUserWidget();
			if ($_SESSION['siteID'] != 55) {
				displaySearchWidget();
			}
		}

		$imgWidth = $divWidth - 10;
		
		if (in_array('nisekopass', $_SESSION['siteModuleArray']) || $_SESSION['siteID'] == 30) {

			if ($_SESSION['siteID'] == 4) {
				echo '<a class="twitter-timeline" href="https://twitter.com/NisekoNews" data-widget-id="295795946137198592">Tweets by @NisekoNews</a>';
				echo '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
			} elseif ($_SESSION['siteID'] == 14) {
				echo '<a class="twitter-timeline" href="https://twitter.com/kutchannel" data-widget-id="294534664268419072">Tweets by @kutchannel</a>';
				echo '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
			} elseif ($_SESSION['siteID'] == 17) {
				echo '<a class="twitter-timeline" href="https://twitter.com/NisekoAvalanche" data-widget-id="295777186017853441">Tweets by @NisekoAvalanche</a>';
				echo '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
			}
		
			displayVerticalLinkage();
			
			if ($_SESSION['siteID'] == 5) {
				echo '<div class="fb-like-box" data-href="http://www.facebook.com/nisekoproperty" data-width="250" data-height="265" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="false"></div>';
			} elseif ($_SESSION['siteID'] == 8) {
				echo '<div class="fb-like-box" data-href="http://www.facebook.com/nisekoaccommodation.net" data-width="250" data-height="265" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="false"></div>';
			} else {
				echo '<div class="fb-like-box" data-href="http://www.facebook.com/kutchannel" data-width="250" data-height="265" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="false"></div>';
			}
	
			// echo '<div style="border:1px solid #ccc;margin:2px;padding:1px;">';
				// echo '<a href="http://hokkaidohosting.com/" target="_blank">';
					// echo '<img src="/agileImages/HokkaidoHosting-250px.png" style="width:' . $imgWidth .'px;border-style:none;margin:0px;">';
				// echo '</a>';
			// echo '</div>';
	
			

		} else {
		
			displayVerticalLinkage();
			
		}
		
	echo '</div>';
}

function displayMainBanners($network) {

	if ($network == 'redpill') {
		
		if (!is_authed()) {
			echo '<div style="width:882px;text-align:center;margin:0px auto 0px auto;">';
					echo '<img src="/agileImages/RedPillAndJaponika-x882y344.png" style="margin-bottom:5px;border-style:none;">';
			echo '</div>';
		}
		
	} else {
	
		if (!is_authed() && $_SESSION['siteID'] != 17) {
			
				if ($_SESSION['siteID'] == 16) { // NisekoFirstSnow.com
				
					// echo '<div style="float:left;width:728px;text-align:center;margin:0px auto 0px auto;">';
						// echo '<a href="http://niseko.us/be" target="_blank">';
							// echo '<img src="agileImages/sponsors/NisekoBarn/TheBarn-NisekoFirstSnow-2013.jpg" style="border-style:none;">';
						// echo '</a>';
					// echo '</div>';
					
					// echo '<div style="float:right;width:155px;height:270px;text-align:center;margin:0px 5px 0px auto;border-style:none;">';
						// echo '<img src="agileImages/NisekoPass-NisekoCMS-DownArrow.png" style="margin:0px 0px 0px 0px;border-style:none;">';
					// echo '</div>';
					
				} elseif ($_SESSION['siteID'] == 5) { // NisekoProperty.net
				
					
					echo '<div style="float:left;width:728px;text-align:center;margin:0px auto 0px auto;">';
						echo '<a href="http://niseko.us/';
							if ($_SESSION['lang'] == 'ja') { echo '1a2'; } else { echo '1a1'; }
						echo '">';
							echo '<img src="agileImages/ZeniDev-726x90.png" style="border-style:none;">';
						echo '</a>';
					echo '</div>';
					
					echo '<div style="float:right;width:155px;height:270px;text-align:center;margin:0px 5px 0px auto;border-style:none;">';
						echo '<a href="http://niseko.us/1ab" target="_blank">';
							echo '<img src="agileImages/sponsors/NisekoConsulting/NisekoConsulting-155x270.jpg" style="margin:0px 0px 0px 0px;border-style:none;">';
						echo '</a>';
					echo '</div>';
					
					// echo '<div style="float:left;width:728px;text-align:center;margin:0px auto 0px auto;">';
						// echo '<a href="http://niseko.us/be" target="_blank">';
							// echo '<img src="agileImages/sponsors/NisekoBarn/NisekoBarn-726x90.jpg" style="border-style:none;">';
						// echo '</a>';
					// echo '</div>';
					
					echo '<a href="http://niseko.us/1aa" target="_blank">';
						echo '<img src="agileImages/sponsors/HolidayNiseko/HolidayNiseko-726x90.png" style="border-style:none;">';
					echo '</a>';
					
					echo '<a href="http://niseko.us/1ab" target="_blank">';
						echo '<img src="agileImages/sponsors/NisekoConsulting/NisekoConsulting-726x90.jpg" style="border-style:none;margin:0px 1px 0px 0px;">';
					echo '</a>';

				} elseif ($_SESSION['siteID'] == 8) { // NisekoAccommodation.net
				
					echo '<a href="http://niseko.us/1aa" target="_blank">';
						echo '<img src="agileImages/sponsors/HolidayNiseko/HolidayNiseko-726x90.png" style="border-style:none;">';
					echo '</a>';
					
					echo '<div style="float:right;width:155px;height:270px;text-align:center;margin:0px 5px 0px auto;border-style:none;">';
						echo '<a href="http://niseko.us/1ab" target="_blank">';
							echo '<img src="agileImages/sponsors/NisekoConsulting/NisekoConsulting-155x270.jpg" style="margin:0px 0px 0px 0px;border-style:none;">';
						echo '</a>';
					echo '</div>';
					
					echo '<div style="float:left;width:728px;text-align:center;margin:0px auto 0px auto;">';
						echo '<a href="http://niseko.us/1d0">';
							echo '<img src="agileImages/ZeniDev-726x90.png" style="border-style:none;">';
						echo '</a>';
					echo '</div>';
					
					echo '<div style="float:left;width:728px;text-align:center;margin:0px auto 0px auto;">';
						// echo '<a href="http://niseko.us/be" target="_blank">';
							// echo '<img src="agileImages/sponsors/NisekoBarn/NisekoBarn-726x90.jpg" style="border-style:none;">';
						// echo '</a>';
						echo '<a href="http://niseko.us/1ab" target="_blank">';
							echo '<img src="agileImages/sponsors/NisekoConsulting/NisekoConsulting-726x90.jpg" style="border-style:none;margin:0px 1px 0px 0px;">';
						echo '</a>';
					echo '</div>';
					
					// http://niseko.us/1d0
					// agileImages/sponsors/Abucha/Abucha-Staff2013.png

				
				} elseif ($_SESSION['siteID'] == 18) { // NisekoJobs.com
				
				 
				
					
					
					echo '<div style="float:left;width:728px;text-align:center;margin:0px auto 0px auto;">';
						echo '<a href="http://niseko.us/1d0">';
							echo '<img src="agileImages/sponsors/Abucha/Abucha-Staff2013.png" style="border-style:none;">';
						echo '</a>';
					echo '</div>';

					echo '<div style="float:right;width:155px;height:270px;text-align:center;margin:0px 5px 0px auto;border-style:none;">';
						echo '<a href="http://niseko.us/1ab" target="_blank">';
							echo '<img src="agileImages/sponsors/NisekoConsulting/NisekoConsulting-155x270.jpg" style="margin:0px 0px 0px 0px;border-style:none;">';
						echo '</a>';
					echo '</div>';
					
					echo '<div style="float:left;width:728px;text-align:center;margin:0px auto 0px auto;">';
						// echo '<a href="http://niseko.us/be" target="_blank">';
							// echo '<img src="agileImages/sponsors/NisekoBarn/NisekoBarn-726x90.jpg" style="border-style:none;">';
						// echo '</a>';
						echo '<a href="http://niseko.us/';
							if ($_SESSION['lang'] == 'ja') { echo '1a2'; } else { echo '1a1'; }
						echo '">';
							echo '<img src="agileImages/ZeniDev-726x90.png" style="border-style:none;">';
						echo '</a>';
					echo '</div>';
					
					echo '<a href="http://niseko.us/1aa" target="_blank">';
						echo '<img src="agileImages/sponsors/HolidayNiseko/HolidayNiseko-726x90.png" style="border-style:none;">';
					echo '</a>';
					
				} elseif ($_SESSION['siteID'] == '6' || $_SESSION['siteID'] == '9' || $_SESSION['siteID'] == '20' || $_SESSION['siteID'] == '24') {

					echo '<div style="float:left;width:728px;text-align:center;margin:0px auto 0px auto;">';
						
						echo '<a href="http://nisekowinesupply.com/" target="_blank">';
							echo '<img src="agileImages/sponsors/NisekoWineSupply/NWS-420x90y.jpg" style="border-style:none;margin:0px 2px 0px 0px;">';
						echo '</a>';

						if ($_SESSION['lang'] == 'ja') { echo '<a href="http://niseko.us/1a2">'; } else { echo '<a href="http://niseko.us/1a1">'; }
							echo '<img src="/agileImages/300x90-center-z.jpg" style="border-style:none;">';
						echo '</a>';
						
					echo '</div>';

					echo '<div style="float:right;width:155px;height:270px;text-align:center;margin:0px 5px 0px auto;border-style:none;">';
						// echo '<a href="http://niseko.us/1ab" target="_blank">';
							echo '<img src="agileImages/sponsors/FlyingFish/TheFlyingFish.png" style="margin:0px 0px 0px 0px;border-style:none;">';
						// echo '</a>';
					echo '</div>';
					
					echo '<div style="float:left;width:728px;text-align:center;margin:0px auto 0px auto;">';
						// echo '<a href="http://niseko.us/be" target="_blank">';
							// echo '<img src="agileImages/726x90-v2.jpg" style="border-style:none;">';
						// echo '</a>';
						echo '<a href="http://niseko.us/1aa" target="_blank">';
							echo '<img src="agileImages/sponsors/HolidayNiseko/HolidayNiseko-726x90.png" style="border-style:none;">';
						echo '</a>';
					echo '</div>';

					echo '<div style="float:left;width:728px;text-align:center;margin:0px auto 0px auto;">';
						echo '<div style="float:left;width:728px;text-align:center;margin:0px auto 0px auto;">';
							echo '<a href="http://niseko.us/';
								if ($_SESSION['lang'] == 'ja') { echo '1a2'; } else { echo '1a1'; }
							echo '">';
								echo '<img src="agileImages/ZeniDev-726x90.png" style="border-style:none;">';
							echo '</a>';
						echo '</div>';
					echo '</div>';

				} else {

					echo '<div style="float:left;width:728px;text-align:center;margin:0px auto 0px auto;">';
						
						echo '<a href="http://niseko.us/fe" target="_blank">';
							echo '<img src="agileImages/NDH_Kutchannel_Top.jpg" style="border-style:none;margin:0px 2px 0px 0px;">';
						echo '</a>';

						if ($_SESSION['lang'] == 'ja') { echo '<a href="http://niseko.us/1a2">'; } else { echo '<a href="http://niseko.us/1a1">'; }
							echo '<img src="/agileImages/300x90-center-z.jpg" style="border-style:none;">';
						echo '</a>';
						
					echo '</div>';

					echo '<div style="float:right;width:155px;height:270px;text-align:center;margin:0px 5px 0px auto;border-style:none;">';
						echo '<a href="http://niseko.us/1ab" target="_blank">';
							echo '<img src="agileImages/sponsors/NisekoConsulting/NisekoConsulting-155x270.jpg" style="margin:0px 0px 0px 0px;border-style:none;">';
						echo '</a>';
					echo '</div>';
					
					// echo '<div style="float:right;width:155px;height:270px;text-align:center;margin:0px 5px 0px auto;border-style:none;">';
						// echo '<a href="http://niseko.kutchannel.net/music/1003267/" target="_blank">';
							// echo '<img src="agileImages/sponsors/DarciFord/BoroyaPizzaGigDec2013.jpg" style="width:155px;margin:0px auto 0px autoborder-style:none;">';
						// echo '</a>';
					// echo '</div>';
					
					// echo '<div style="float:left;width:728px;text-align:center;margin:0px auto 0px auto;">';
						// echo '<a href="http://niseko.us/be" target="_blank">';
							// echo '<img src="agileImages/726x90-v2.jpg" style="border-style:none;">';
						// echo '</a>';
					// echo '</div>';
					
					echo '<div style="float:left;width:728px;text-align:center;margin:0px auto 0px auto;">';
						echo '<a href="http://niseko.us/1aa" target="_blank">';
							echo '<img src="agileImages/sponsors/HolidayNiseko/HolidayNiseko-726x90.png" style="border-style:none;">';
						echo '</a>';
					echo '</div>';

					echo '<div style="float:left;width:728px;text-align:center;margin:0px auto 0px auto;">';
						echo '<div style="float:left;width:728px;text-align:center;margin:0px auto 0px auto;">';
							echo '<a href="http://niseko.us/';
								if ($_SESSION['lang'] == 'ja') { echo '1a2'; } else { echo '1a1'; }
							echo '">';
								echo '<img src="agileImages/ZeniDev-726x90.png" style="border-style:none;">';
							echo '</a>';
						echo '</div>';
					echo '</div>';
					
					// echo '<a href="http://niseko.us/1ab" target="_blank">';
						// echo '<img src="agileImages/sponsors/NisekoConsulting/NisekoConsulting-726x90.jpg" style="border-style:none;margin:0px 1px 0px 0px;">';
					// echo '</a>';

				}
				
			echo '<div style="clear:both;margin-bottom:5px;"></div>';

		}
	}
	
}

function displayContentRssFeed($siteID, $contentCategoryKeyArray = array()) {

	
	$contentCategoryKeyArrayString = "'" . join('\',\'',$contentCategoryKeyArray) . "'";
	
	$queryGetContent = "
	SELECT * FROM nisekocms_content 
	WHERE siteID = $siteID 
	AND contentCategoryKey IN ($contentCategoryKeyArrayString)
	AND entryPublished = 1
	ORDER BY entrySubmissionDateTime DESC LIMIT 25
	";

	// echo $queryGetContent;
	$resultGetContent = mysql_query($queryGetContent);
	
	while($rowGetContent = mysql_fetch_array($resultGetContent)) {

		$contentURL = getSiteURL() . '/' . getContentListURL($rowGetContent['contentCategoryKey']) . $rowGetContent['entryID'] . '/';
		$contentTitle = forceRssValidation($rowGetContent['entryTitleEnglish']);
		$contentTitle = str_replace('&', '&amp;', str_replace('&nbsp;', ' ', $contentTitle));
		$contentCreationDate = date('D jS M Y', strtotime($rowGetContent['entrySubmissionDateTime']));
		$contentCreationDateRFC822 = date('D, d M Y H:i:s O', strtotime($rowGetContent['entrySubmissionDateTime']));
		$contentText = forceRssValidation($rowGetContent['entryContentEnglish']);
		$contentText = substr($contentText, 0, strrpos(substr($contentText, 0, 255), ' ')) . '...';
		
		echo '
			<item>';
				echo '<title>' . $contentTitle . '</title>';
				echo '<link>' . $contentURL . '</link>';
				echo '<description>' . html_entity_decode($contentText) . '</description>';
				echo '<category>' . getSiteTitle() . '</category>';
				echo '<guid isPermaLink="true">' . $contentURL . '</guid>';
				echo '<pubDate>' . $contentCreationDateRFC822 . '</pubDate>';
			echo '</item>
		';
	}
	
}

function forceRssValidation($input) {

	$output = '';
	$output = strip_tags($input);
		
	$stringsToFilter1 = array("&yen;");
	$output = str_replace($stringsToFilter1, 'jpy', $output);
		
	$stringsToFilter2 = array("&nbsp;","\r","\n");
	$output = str_replace($stringsToFilter2, ' ', $output);
		
	$stringsToFilter3 = array("&#39;");
	$output = str_replace($stringsToFilter3, "'", $output);
	
	$stringsToFilter4 = array("&ndash;");
	$output = str_replace($stringsToFilter4, "-", $output);
	
	$output = str_replace("&amp;", "and", $output);
	$output = str_replace("&", "and", $output);
	
	$output = preg_replace("/[ \t]+/", " ", $output);
	
	return $output;
}

function displaySitemapHTML($siteID, $contentCategoryKeyArray = array()) {
	
	$currentDate = date('Y-m-d');
	echo '<div style="text-align:left;margin:5px;">';
	if (!empty($contentCategoryKeyArray)) {
		echo '<ul>';
		foreach ($contentCategoryKeyArray as $contentCategoryKey) {
			echo '<li><a href="/' . languageUrlPrefix() . getContentListURL($contentCategoryKey) . '">' . getContentCategoryName($contentCategoryKey) . '</a>';
				$queryContentCategory = "
				SELECT * FROM nisekocms_content 
				WHERE contentCategoryKey = '$contentCategoryKey'
				AND entryPublished = 1 
				AND entryPublishStartDate <= '$currentDate' 
				AND (entryPublishEndDate >= '$currentDate' OR entryPublishEndDate = '0000-00-00')
				AND siteID = '$siteID'
				ORDER BY entrySubmissionDateTime DESC
				";
				$resultContentCategory = mysql_query($queryContentCategory);
				
				if (mysql_num_rows($resultContentCategory) != 0) {
					echo '<ul>';
						while($rowContentCategory = mysql_fetch_array($resultContentCategory)) {
							echo '<li><a href="/' . languageUrlPrefix() . getContentListURL($contentCategoryKey) . $rowContentCategory['entryID'] . '/">' . $rowContentCategory['entryTitleEnglish'] . '</a></li>';
						}
					echo '</ul>';
				}
			echo '</li>';
		}
		echo '</ul>';
	}
	echo '</div>';
	
	
	
}

function displaySitemapXML($siteID, $contentCategoryKeyArray = array()) {
	echo '<?xml version="1.0" encoding="UTF-8"?>
';
	echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
';
	$currentDate = date('Y-m-d');
	if (!empty($contentCategoryKeyArray)) {
		$contentCategoryKeyString = "'" . join("','", $contentCategoryKeyArray) . "'";
		// echo $contentCategoryKeyString;
		$queryContent = "
				SELECT * FROM nisekocms_content 
				WHERE contentCategoryKey IN ($contentCategoryKeyString)
				AND entryPublished = 1 
				AND entryPublishStartDate <= '$currentDate' 
				AND (entryPublishEndDate >= '$currentDate' OR entryPublishEndDate = '0000-00-00')
				AND siteID = '$siteID'
				ORDER BY entrySubmissionDateTime DESC
		";
		$resultContent = mysql_query($queryContent);
		if (mysql_num_rows($resultContent) != 0) {
			while($rowContent = mysql_fetch_array($resultContent)) {
				$linkURL = getSiteURL() . '/' . languageUrlPrefix() . getContentListURL($rowContent['contentCategoryKey']) . $rowContent['entryID'] . '/';
				echo '	<url><loc>' . $linkURL . '</loc></url>
';
			}
		}
	}
	echo '</urlset>';
}

function displaySearchWidget($width = 246) {

	echo '<div style="width:' . $width . 'px;margin:1px 1px 1px 1px;border:1px solid #ccc;">';
		echo '<div style="background-color:#a2c0d2;margin:2px;border:1px solid #ccc;">';
			echo '<form method="post" action="http://nisekoweb.com/' . languageUrlPrefix() . 'search/" style="margin:5px;">';
			echo '<input type="text" name="searchterm" value="" style="width:125px;margin:1px;">';
			echo '&nbsp;';
			echo '<input type="submit" name="submit" value="' . agileResource('searchNiseko') . '" style="width:125px;margin:1px;">';
			echo '</form>';
		echo '</div>';
	echo '</div>';


}

function displayUserWidget($width = 246) {

	$registerURL = '';
	if (in_array('nisekopass',$_SESSION['siteModuleArray'])) {
		$color = '#000000';
		$backgroundColor = '#a2c0d2';
		$newToSite = 'newToTheKutchannel';
		$registerURL = 'http://niseko.kutchannel.net';
		$crapCSS = 'margin:1px 1px 1px 1px;border:1px solid #ccc;';
	} elseif ($_SESSION['siteID'] == 55) {
		$color = '#ffffff';
		$backgroundColor = getSitePrimaryColor($_SESSION['siteID']);
		$newToSite = 'newToRedPill';
		$crapCSS = 'margin:0px;';
	} else {
		$color = '#000000';
		$backgroundColor = getSitePrimaryColor($_SESSION['siteID']);
		$newToSite = 'newToSite';
		$crapCSS = 'margin:1px 1px 1px 1px;border:1px solid #ccc;';
	}

	$crapCSS = 'margin:1px 1px 1px 1px;border:1px solid #ccc;';
	
	echo '<div style="width:' . $width . 'px;' . $crapCSS .'">';
		if (!is_authed()) {
			
			echo '<div style="background-color:' . $backgroundColor . ';color:' . $color . ';margin:2px;border:1px solid #ccc;">';		
				echo'<form action="' . languageUrlPrefix() . 'login/" method="post" style="margin:0px;">';
					echo '<input type="text" maxlength="255" name="userName" style="width:125px;margin:1px;" value="username" onfocus="if(this.value==\'username\')this.value=\'\'" />';
					echo '<input type="password" maxlength="255" name="userPassword" style="width:125px;margin:1px;" value="password" onfocus="if(this.value==\'password\')this.value=\'\'" />';
					echo '<input type="submit" name="submit" style="width:125px;margin:1px;" value="' . agileResource('login') . '" />';
				echo '</form>';
			echo '</div>';
				
			if (siteIsPublic()) {
				echo '<div style="background-color:' . $backgroundColor . ';color:' . $color . ';margin:2px;border:1px solid #ccc;">';
					echo agileResource($newToSite);
					echo '<input type="button" style="width:125px;margin:1px;" value="' . agileResource('register') . '" onclick="window.location.href=\'' . $registerURL . '/' . languageUrlPrefix() . 'register/\'">';
				echo '</div>';
			}
			
		} else {
			echo '<div style="background-color:' . $backgroundColor . ';color:' . $color . ';margin:2px;border:1px solid #ccc;">';
			
				if ($_SESSION['lang'] == 'ja') {
					echo '<b>' . getUserName($_SESSION['userID']) . '様</b>～ お帰りなさい。';
				} else {
					echo 'Welcome back, <b>' . getUserName($_SESSION['userID']) . '</b>!';
				}
				
				echo '<input type="button" style="width:125px;margin:1px;" value="' . agileResource('profile') . '" onclick="window.location.href=\'' . languageUrlPrefix() . 'user/update/' . $_SESSION['userID'] . '/\'">';
				
				echo '<input type="button" style="width:125px;margin:1px;" value="' . agileResource('logout') . '" onclick="window.location.href=\'' . languageUrlPrefix() . 'logout/\'">';
				
			echo '</div>';
		}

	echo '</div>';
	
	
	
}

function displayVerticalLinkage() {

	if (in_array('nisekopass', $_SESSION['siteModuleArray'])) {
	
		$resultGetBanners = mysql_query("SELECT * FROM nisekocms_banner WHERE siteID = 14 AND bannerEnabled = 1 ORDER BY bannerDisplayOrder ASC");
		while($rowGetBanner = mysql_fetch_array($resultGetBanners)) {
	
			$bannerURL = $rowGetBanner['bannerTargetURL'] . languageUrlPrefix();
			if (is_authed()) { $bannerURL .= 'token=' . $_SESSION['userToken']; }
		
			
			echo '<div style="width:250px;height:47px;border-style:none;margin:1px auto 0px auto;background-image:url(\'/agileImages/250px-NisekoButtonBackground.png\');" onClick="location.href=\'' . $bannerURL . '\'">';
			
				echo '<a style="color:#115b8a;" href="' . $bannerURL . '">';
					echo '<h3 style="margin:0px;padding-top:10px;">';
						if ($_SESSION['lang'] == 'ja') { echo $rowGetBanner['bannerHeadlineJapanese']; } else { echo $rowGetBanner['bannerHeadline']; }
					echo '</h3>';
				echo '</a>';
				
					if ($_SESSION['lang'] == 'ja') {
						echo '<a style="float:left;color:#f00;font-size:10px;margin:1px 0px 0px 10px;" href="' . $bannerURL . '">';
						echo $rowGetBanner['bannerTagLineJapanese'];
					} else {
						echo '<a style="float:left;color:#f00;font-size:9px;margin:0px 0px 0px 10px;" href="' . $bannerURL . '">';
						echo $rowGetBanner['bannerTagLine'];
					}
				echo '</a>';
				
				
					if ($_SESSION['lang'] == 'ja') {
						echo '<a style="float:right;color:#115b8a;font-size:9px;margin:1px 10px 0px 0px;" href="' . $bannerURL . '">' . $rowGetBanner['bannerCleanURL'] . '</a>';
					} else {
						echo '<a style="float:right;color:#115b8a;font-size:9px;margin:0px 10px 0px 0px;" href="' . $bannerURL . '">' . $rowGetBanner['bannerCleanURL'] . '</a>';
					}
				
				echo '<div style="clear:both;"></div>';
			echo '</div>';
		}
		
	} elseif ($_SESSION['siteID'] == 55) {

		// if ($_SESSION['userID'] == 2) {
			$resultGetBanners = mysql_query("SELECT * FROM nisekocms_banner WHERE siteID = '55' AND bannerEnabled = '1'");
			while($rowGetBanner = mysql_fetch_array($resultGetBanners)) {
		
				$bannerURL = $rowGetBanner['bannerTargetURL'] . languageUrlPrefix();
				if (is_authed()) { $bannerURL .= 'token=' . $_SESSION['userToken']; }
			
				
				echo '<div style="width:250px;height:47px;border-style:none;margin:1px auto 0px auto;background-image:url(\'/agileImages/250px-RedPillButtonBackground.png\');" onClick="location.href=\'' . $bannerURL . '\'">';
				
					echo '<a style="color:#fff;" href="' . $bannerURL . '">';
						echo '<h3 style="margin:0px;padding-top:10px;">';
							if ($_SESSION['lang'] == 'ja') { echo $rowGetBanner['bannerHeadlineJapanese']; } else { echo $rowGetBanner['bannerHeadline']; }
						echo '</h3>';
					echo '</a>';
					
						if ($_SESSION['lang'] == 'ja') {
							echo '<a style="float:left;color:#000;font-size:10px;margin:1px 0px 0px 10px;" href="' . $bannerURL . '">';
							echo $rowGetBanner['bannerTagLineJapanese'];
						} else {
							echo '<a style="float:left;color:#000;font-size:9px;margin:0px 0px 0px 10px;" href="' . $bannerURL . '">';
							echo $rowGetBanner['bannerTagLine'];
						}
					echo '</a>';
					
					
						if ($_SESSION['lang'] == 'ja') {
							echo '<a style="float:right;color:#000;font-size:9px;margin:1px 10px 0px 0px;" href="' . $bannerURL . '">' . $rowGetBanner['bannerCleanURL'] . '</a>';
						} else {
							echo '<a style="float:right;color:#000;font-size:9px;margin:0px 10px 0px 0px;" href="' . $bannerURL . '">' . $rowGetBanner['bannerCleanURL'] . '</a>';
						}
					
					echo '<div style="clear:both;"></div>';
				echo '</div>';
				
			}
			
			// echo '<div style="border:1px solid #ccc;margin:2px;padding:1px;">';
				// echo '<a href="http://hokkaidohosting.com/" target="_blank">';
					// echo '<img src="/agileImages/HokkaidoHosting-250px.png" style="width:' . $imgWidth .'px;border-style:none;margin:0px;">';
				// echo '</a>';
			// echo '</div>';
		// }
	}



}

function formatBytes($size, $precision = 2){
    $base = log($size) / log(1024);
    $suffixes = array('', 'k', 'M', 'G', 'T');   
	
	// $formattedBytes = round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
	$suffix = $suffixes[floor($base)];
	if ($suffix == '' || $suffix == 'k') { $precision = 0; } else { $precision = 1; }
	
	$formattedBytes = round(pow(1024, $base - floor($base)), $precision) . $suffix;
	
	return $formattedBytes;
}

?>