<?php

function bootstrapHeader() {

	echo '<!DOCTYPE html>
	<html lang="en">
		<head>
			<title>' . getSiteTitle() . '</title>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta name="description" content="' . getSiteDescription() . '">
			<meta name="keywords" content="' . getSiteKeywords() . '">
			<meta name="author" content="' . agileResource('christopherWebb') . '">
			<meta name="generator" content="' . agileResource('nisekocms') . '" />';
			
			if (getSiteGoogleSiteVerification($_SESSION['siteID']) != '') { echo '
			<meta name="google-site-verification" content="' . getSiteGoogleSiteVerification($_SESSION['siteID']) . '" />'; }

			echo '
			<!-- Le styles -->
			<link href="/agileBootstrap/docs/assets/css/bootstrap.css" rel="stylesheet">
			<style type="text/css">
			  body {
				padding-top: 60px;
				padding-bottom: 40px;
			  }
			</style>
			
			<link href="/agileBootstrap/docs/assets/css/bootstrap-responsive.css" rel="stylesheet">

			<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
			
			<!--[if lt IE 9]>
			  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<![endif]-->

			<!-- Fav and touch icons -->
			
			<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/agileBootstrap/docs/assets/ico/apple-touch-icon-144-precomposed.png">
			<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/agileBootstrap/docs/assets/ico/apple-touch-icon-114-precomposed.png">
			<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/agileBootstrap/docs/assets/ico/apple-touch-icon-72-precomposed.png">
			<link rel="apple-touch-icon-precomposed" href="/agileBootstrap/docs/assets/ico/apple-touch-icon-57-precomposed.png">
			<link rel="shortcut icon" href="/agileBootstrap/docs/assets/ico/favicon.png">
		</head>';

}

function bootstrapBody() {

	echo '<body>';
	
	bootstrapNavigationMenu();
	
	echo '
		<div class="container">

			<!-- Main hero unit for a primary marketing message or call to action -->
				<div class="hero-unit">
					<h1>' . getSiteTitle() . '</h1>
						<p>' . getSiteDescription() . '</p>
						<p><a class="btn btn-primary btn-large">Learn more &raquo;</a></p>
				</div>

			<!-- Example row of columns -->';
			
				echo '<div class="row">';
					echo '<div class="span4">';
						echo '<h2>' . agileResource('jobs') . '</h2>';
						echo '<p>';
							bootstrapContentListTable('employment', 18, 'http://nisekojobs.com/');
						echo '</p>';
					echo '</div>';
					
					echo '<div class="span4">';
						echo '<h2>' . agileResource('accommodation') . '</h2>';
						echo '<p>';
							bootstrapContentListTable('accommodation', 8, 'http://nisekoaccommodation.net/');
						echo '</p>';
					echo '</div>';
					
					echo '<div class="span4">';
						echo '<h2>' . agileResource('property') . '</h2>';
						echo '<p>';
							bootstrapContentListTable('nisekorealestate', 5, 'http://nisekoproperty.net/');
						echo '</p>';
					echo '</div>';
				echo '</div>';
				
				echo '<div class="row">';
				
					echo '<div class="span3">';
						echo '<h3>' . agileResource('forum') . '</h3>';
						echo '<p>';
							bootstrapContentListTable('forum', 14, 'http://niseko.kutchannel.net/');
						echo '</p>';
					echo '</div>';
					
					echo '<div class="span3">';
						echo '<h3>' . agileResource('for-sale') . '</h3>';
						echo '<p>';
							bootstrapContentListTable('for-sale', 14, 'http://niseko.kutchannel.net/');
						echo '</p>';
					echo '</div>';
					
					echo '<div class="span3">';
						echo '<h3>' . agileResource('wanted') . '</h3>';
						echo '<p>';
							bootstrapContentListTable('wanted', 14, 'http://niseko.kutchannel.net/');
						echo '</p>';
					echo '</div>';
					
					echo '<div class="span3">';
						echo '<h3>' . agileResource('services') . '</h3>';
						echo '<p>';
							bootstrapContentListTable('services', 14, 'http://niseko.kutchannel.net/');
						echo '</p>';
					echo '</div>';
					
				echo '</div>';
				
				echo '<hr>';

}

function bootstrapContentListTable(
	$contentCategoryKey = '', 
	$siteID = 0, 
	$domainToLinkTo = '', 
	$queryLimit = 'LIMIT 7'
) {
	
	$currentDateTime = date('Y-m-d H:i:s');
	$contentNewCrudTitle = getContentNewCrudTitle($contentCategoryKey);
	$contentNewCrudURL = getContentNewCrudURL($contentCategoryKey);
	$contentListURL = getContentListURL($contentCategoryKey);
	
	if ($siteID != 0) { $whereQuerySiteID = "nisekocms_content.siteID = '$siteID' AND"; } else { $whereQuerySiteID = ''; }
	if ($_SESSION['lang'] == 'ja') {
		$selectQueryEntryContent = 'nisekocms_content.entryContentJapanese AS entryContent';
	} else {
		$selectQueryEntryContent = 'nisekocms_content.entryContentEnglish AS entryContent';
	}
	
	$resultGetContentListQuery = "
		SELECT
			nisekocms_content.entrySubmittedByUserID as userID,
			nisekocms_content.entryID as entryID,
			$selectQueryEntryContent
		FROM
			nisekocms_content
		WHERE
			$whereQuerySiteID
			nisekocms_content.contentCategoryKey = '$contentCategoryKey' AND
			nisekocms_content.entryPublished = '1' AND
			nisekocms_content.entryPublishStartDate <= '$currentDateTime' AND 
			(nisekocms_content.entryPublishEndDate >= '$currentDateTime' OR nisekocms_content.entryPublishEndDate = '000-00-00 00:00:00')
		ORDER BY entrySubmissionDateTime DESC $queryLimit
	";

		echo '<table class="table table-hover">';
		
			echo '<tr>';
				echo '<td colspan="2">';
					$addUrl = $domainToLinkTo . languageUrlPrefix() . $contentNewCrudURL;
					$addAnchorText = agileResource($contentNewCrudTitle);
					bootstrapLinkButton($addUrl, $addAnchorText);
				echo '</td>';
			echo '</tr>';

			$resultGetContentList = mysql_query($resultGetContentListQuery);
			while($rowGetContentItem = mysql_fetch_array($resultGetContentList)) {
				echo '<tr>';
					echo '<td>' . getUserName($rowGetContentItem['userID']) . '</td>';
					echo '<td>';
						echo '<a href="' . $domainToLinkTo . languageUrlPrefix() . $contentListURL . $rowGetContentItem['entryID'] . '/">';
							echo strip_tags(getContentTitle($rowGetContentItem['entryID']));
						echo '</a>';
					echo '</td>';
				echo '</tr>';
			}
			
			echo '<tr>';
				echo '<td colspan="2">';
					$moreUrl = $domainToLinkTo . languageUrlPrefix() . $contentListURL;
					$moreAnchorText = agileResource('more');
					bootstrapLinkButton($moreUrl, $moreAnchorText);
				echo '</td>';
			echo '</tr>';

		echo '</table>';

}

function bootstrapLinkButton($url, $anchorText) { echo '<a class="btn" href="' . $url . '">' . agileResource($anchorText) . ' &raquo;</a>'; }

function bootstrapFooter() {
	
	echo '
		<footer><p>&copy; ' . agileResource('agileHokkaido') . ' ' . date('Y') . '</p></footer>
		</div> <!-- /container -->

		<!-- Le javascript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="/agileBootstrap/docs/assets/js/jquery.js"></script>
		<script src="/agileBootstrap/docs/assets/js/bootstrap-transition.js"></script>
		<script src="/agileBootstrap/docs/assets/js/bootstrap-alert.js"></script>
		<script src="/agileBootstrap/docs/assets/js/bootstrap-modal.js"></script>
		<script src="/agileBootstrap/docs/assets/js/bootstrap-dropdown.js"></script>
		<script src="/agileBootstrap/docs/assets/js/bootstrap-scrollspy.js"></script>
		<script src="/agileBootstrap/docs/assets/js/bootstrap-tab.js"></script>
		<script src="/agileBootstrap/docs/assets/js/bootstrap-tooltip.js"></script>
		<script src="/agileBootstrap/docs/assets/js/bootstrap-popover.js"></script>
		<script src="/agileBootstrap/docs/assets/js/bootstrap-button.js"></script>
		<script src="/agileBootstrap/docs/assets/js/bootstrap-collapse.js"></script>
		<script src="/agileBootstrap/docs/assets/js/bootstrap-carousel.js"></script>
		<script src="/agileBootstrap/docs/assets/js/bootstrap-typeahead.js"></script>

	  </body>
	</html>';
}


function bootstrapNavigationMenu() {
		echo '
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<a class="brand" href="/">' . getSiteTitle() . '</a>
					<div class="nav-collapse collapse">
						<ul class="nav">
							<li class="active"><a href="/">' . agileResource('home') . '</a></li>
							<li><a href="/about/">' . agileResource('about') . '</a></li>
							<li><a href="/contact/">' . agileResource('contact') . '</a></li>
							<li class="dropdown"><a href="/" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="/">Action</a></li>
									<li><a href="/">Another action</a></li>
									<li><a href="/">Something else here</a></li>
									<li class="divider"></li>
									<li class="nav-header">Nav header</li>
									<li><a href="/">Separated link</a></li>
									<li><a href="/">One more separated link</a></li>
								</ul>
							</li>
						</ul>
						<form class="navbar-form pull-right">
							<input class="span2" type="text" placeholder="Email">
							<input class="span2" type="password" placeholder="Password">
							<button type="submit" class="btn">Sign in</button>
						</form>
					</div>
					<!--/.nav-collapse -->
				</div>
			</div>
		</div>';
}
?>