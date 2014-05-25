<?php

// MIGRATION
// UPDATE `nisekocms_content` SET `entrySeoURL` = LCASE(REPLACE(`entryTitleEnglish`, ' ', '-' ))

function jagaBoogie($urlArray) {

	if ($urlArray[0] == '') { $pageName = 'index'; } else { $pageName = mysql_real_escape_string($urlArray[0]); }

	jagaHeader($urlArray);

	jagaNavigation($urlArray);

	// jagaJumboTron($urlArray);

	if ($pageName == 'index') {
		jagaCarousel($urlArray);
		jagaHomeBoy($urlArray);
	} elseif ($pageName == 'login') {

		if (!isset($_POST['submit_login'])) {
			displayJagaLoginForm();
		} else {
			
			$username = mysql_real_escape_string($_POST['userName']);
			$password = mysql_real_escape_string($_POST['userPassword']);
			
			
			// IF VALIDATES {
				// login
			// } ELSE {
				displayJagaLoginForm();
			// }
			
			
			
			
		}
		
		
	} elseif ($pageName == 'logout') {
		user_logout();
	} elseif ($pageName == 'register') {
		echo 'register';
	} elseif ($pageName == 'user') {
		displayUserProfile($urlArray[1]);
	} elseif (contentCategoryExistsAndIsEnabledForCurrentSite($pageName) && $urlArray[1] == '') {
	
		displayJagaContentList($pageName);
	
	} elseif (contentExistsForThisUrl($urlArray[1])) {
	
		displayJagaContent($urlArray[1]);
		
	} else {
		echo $pageName . ':404';
	}

	jagaFooter($urlArray);
}

function jagaHeader($urlArray) {
	
	echo "<!DOCTYPE html>\n";
	echo "<html lang=\"" . $_SESSION['lang'] . "\">\n\n";

	echo "\t<head>\n\n";
	
		echo "\t\t<meta charset=\"utf-8\">\n";
		echo "\t\t<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n";
		echo "\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no\"/>\n";
		echo "\t\t<meta name=\"description\" content=\"\">\n";
		echo "\t\t<meta name=\"author\" content=\"Christopher Webb\">\n";
		echo "\t\t<link rel=\"shortcut icon\" href=\"/jaga/images/favicon.ico\">\n\n";

		echo "\t\t<title>" . agileResource('theKutchannel') . "</title>\n\n";

		echo "\t\t<link rel=\"stylesheet\" href=\"/jaga/fonts/font-awesome/font-awesome-4.0.3/css/font-awesome.min.css\">\n";
		echo "\t\t<link rel=\"stylesheet\" href=\"/jaga/bootstrap/bootstrap-3.1.1/css/bootstrap.min.css\">\n";
		echo "\t\t<link rel=\"stylesheet\" href=\"/jaga/css/kutchannel.css\">\n\n";

	echo "\t</head>\n\n";

	echo "\t<body>\n\n";
}

function jagaNavigation($urlArray) {
	
	echo "
    <div class=\"navbar navbar-default navbar-fixed-top\" role=\"navigation\">
      <div class=\"container\">
        <div class=\"navbar-header\">
          <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#jagaHeaderNavBar\">
            <span class=\"sr-only\">Toggle navigation</span>
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
          </button>
          <a class=\"navbar-brand\" href=\"/" . languageUrlPrefix() . "\"><img src=\"http://niseko.kutchannel.net/agileThemes/kutchannel/images/banner.png\" style=\"height:30px;position:relative;top:-5px;\"></a>
        </div>
        <div id=\"jagaHeaderNavBar\" class=\"navbar-collapse collapse\">
          <form method=\"post\" action=\"/" . languageUrlPrefix() . "login/\" class=\"navbar-form navbar-right\" role=\"form\">
            <div class=\"form-group\">
              <input type=\"text\" placeholder=\"Username or Email\" class=\"form-control\">
            </div>
            <div class=\"form-group\">
              <input type=\"password\" placeholder=\"Password\" class=\"form-control\">
            </div>
            <button type=\"submit\" class=\"btn btn-success\">Sign in</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>\n\n";
	
}

function jagaJumboTron($urlArray) {

	echo "
		<!-- Main jumbotron for a primary marketing message or call to action -->
		<div class=\"jumbotron hidden-xs\">
		  <div class=\"container\">
			<h1>Welcome to Niseko!</h1>
			<p>Located on Hokkaido, Japan's expansive and scenic northernmost island, Niseko is Asia's premier four-season alpine resort area. If you're visiting here, working here, investing here, or living here, then hopefully The Kutchannel is for you.
			<p><a class=\"btn btn-primary btn-lg\" role=\"button\">Learn more &raquo;</a></p>
		  </div>
		</div>
	";

}

function jagaFooter($urlArray) {

			echo "\t\t<hr>\n";
			
				echo "\t\t<div class=\"container\">\n";
					echo "<a href=\"/about/\">" . agileResource('about') . "</a>";
					echo "<a href=\"/tos/\">" . agileResource('termsOfService') . "</a>";
					echo "<a href=\"/privacy/\">" . agileResource('privacyPolicy') . "</a>";
					echo "<a href=\"/sitemap/\">" . agileResource('sitemap') . "</a>";
					echo "<a href=\"/sponsor/\">" . agileResource('sponsor') . "</a>";
					echo "<a chref=\"/contact/\">" . agileResource('contact') . "</a>";
					echo "&copy; " . agileResource('theKutchannel') . " 2006-" . date('Y');
				echo "\t\t</div>\n";
			
		echo "\t</div>\n";
		
		echo "\t<!-- /container -->\n\n";
		
		echo "\t<div class=\"container\" style=\"margin-top:10px;\">\n";
			echo "\t\t<pre>\n";
				print_r($urlArray);
			echo "\n\t\t</pre>\n";
			echo "\t\t<pre>\n";
				print_r($_POST);
			echo "\n\t\t</pre>\n";
			echo "\t\t<pre>\n";
				print_r($_FILES);
			echo "\n\t\t</pre>\n";
			echo "\t\t<pre>\n";
				print_r($_SESSION);
			echo "\n\t\t</pre>\n";
		echo "\t</div>\n\n";
		echo "\t<!-- /container -->\n\n";
		
		if ($urlArray[0] != 'login') {
			echo "\t<nav class=\"navbar navbar-default navbar-fixed-bottom\" role=\"navigation\">\n";
				echo "\t\t<div class=\"container\" id=\"sponsor\">\n";
					echo "\t\t\t<div class=\"navbar-header\">\n";
						echo "\t\t\t\t<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#jagaFooterNavBar\">\n";
							echo "\t\t\t\t\t<span class=\"sr-only\">Toggle navigation</span>\n";
							echo "\t\t\t\t\t<span class=\"icon-bar\"></span>\n";
							echo "\t\t\t\t\t<span class=\"icon-bar\"></span>\n";
							echo "\t\t\t\t\t<span class=\"icon-bar\"></span>\n";
						echo "\t\t\t\t</button>\n";
						$currentURL = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
						echo "<a class=\"navbar-brand\" style=\"position:relative;top:-7px;\"><i class=\"fa fa-share fa-2x\" style=\"color:#000;\"></i></a>\n";
						echo "<a class=\"navbar-brand\" style=\"position:relative;top:-7px;\" href=\"
							https://twitter.com/share?text=The%20Kutchannel&url=" . $currentURL . "\"><i class=\"fa fa-twitter-square fa-2x\"></i></a>\n";
						echo "<a class=\"navbar-brand\" style=\"position:relative;top:-7px;\" href=\"https://www.facebook.com/sharer/sharer.php?u=" . $currentURL . "\"><i class=\"fa fa-facebook-square fa-2x\"></i></a>\n";
						echo "<a class=\"navbar-brand\" style=\"position:relative;top:-7px;\" href=\"https://plus.google.com/share?url=" . $currentURL . "\"><i class=\"fa fa-google-plus-square fa-2x\"></i></a>\n";
					echo "\t\t\t</div>\n";
					echo "\t\t\t<div id=\"jagaFooterNavBar\" class=\"collapse navbar-collapse\">\n";
						echo "\t\t\t\t<form class=\"navbar-form navbar-right\" role=\"search\">\n";
							echo "\t\t\t\t\t<div class=\"form-group\">\n";
								echo "\t\t\t\t\t\t<input type=\"text\" class=\"form-control\" placeholder=\"Search\">\n";
							echo "\t\t\t\t\t</div>\n";
							echo "\t\t\t\t\t<button type=\"submit\" class=\"btn btn-default\">" . agileResource('search') . "</button>\n";
						echo "\t\t\t\t</form>\n";
					echo "\t\t\t</div>\n";	
				echo "\t\t</div>\n";
			echo "\t</nav>\n";
			echo "\t<!-- /nav -->\n\n";
		}
		
		echo "\t<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js\"></script>\n";
		echo "\t<script src=\"/jaga/bootstrap/bootstrap-3.1.1/js/bootstrap.min.js\"></script>\n\n";
		
		echo "\t</body>\n\n";
	echo "</html>";
	
}

function jagaHomeBoy($urlArray) {

	echo "\t<div class=\"container\">\n";
		$queryContentCategories = "SELECT contentCategoryKey FROM jaga_siteContentCategory WHERE siteID = '$_SESSION[siteID]';";
		$resultContentCategories = mysql_query($queryContentCategories);
		$i = 0;
		$categoryCount = mysql_num_rows($resultContentCategories);
		while ($rowContentCategories = mysql_fetch_array($resultContentCategories)) {
			$contentCategoryKey = $rowContentCategories['contentCategoryKey'];
			if ($i % 4 == 0) { echo "\t\t<div class=\"row\">\n"; }
				echo "\t\t\t<div class=\"col-xs-12 col-sm-6 col-md-3\">";
					echo "\t\t\t\t<div class=\"panel panel-default\">\n";
						echo "\t\t\t\t<div class=\"panel-heading\">\n";
							echo "\t\t\t\t<h3>" . getContentCategoryName($rowContentCategories['contentCategoryKey']) . "</h3>\n";
						echo "\t\t\t\t</div>\n";
						echo "\t\t\t\t<div class=\"panel-body\">\n";
							$queryGetContent = "
								SELECT * FROM nisekocms_content 
								WHERE contentCategoryKey = '$contentCategoryKey' 
								ORDER BY entrySubmissionDateTime DESC 
								LIMIT 5
							";
							$resultGetContent = mysql_query($queryGetContent);
							echo "\t\t\t\t\t<div class=\"list-group\">\n";
								while ($rowGetContent = mysql_fetch_Array($resultGetContent)) {
									echo "<a class=\"list-group-item\" href=\"/" . getContentListURL($contentCategoryKey) . '/' . $rowGetContent['entrySeoURL'] . "/\">";
										echo '<strong>' . getUserName($rowGetContent['entrySubmittedByUserID']) . '</strong>';
										echo "<span class=\"badge\">" . date('M d', strtotime($rowGetContent['entrySubmissionDateTime'])) . "</span>";
										echo '<p style="color:#0f5c8c;" class="list-group-item-text">' . $rowGetContent['entryTitleEnglish'] . '</p>';
									echo "</a>";
								}
							echo "\t\t\t\t\t</div>\n";
							echo "<a class=\"list-group-item\" href=\"/" . languageUrlPrefix() . getContentListURL($contentCategoryKey) . "/\">view more...</a>";
						echo "\t\t\t\t</div>\n";
					echo "\t\t\t\t</div>\n";
				echo "\t\t\t</div>\n\n";
			if ($i % 4 == 3 || $i == $categoryCount) { echo "\t\t</div>\n"; }
			$i++;
		}
	echo "\t</div>\n\n";
}

function jagaCarousel($urlArray) {

	echo "\t<div class=\"container\" style=\"margin-bottom:10px;\">\n";
	
		echo "\t<div id=\"carousel-example-generic\" class=\"carousel slide\" data-ride=\"carousel\">\n";
		
			// <!-- Indicators -->
			// <ol class="carousel-indicators">
				// <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
				// <li data-target="#carousel-example-generic" data-slide-to="1"></li>
				// <li data-target="#carousel-example-generic" data-slide-to="2"></li>
			// </ol>

		echo "\t\t<!-- Wrapper for slides -->\n";
		echo "\t\t<div class=\"carousel-inner\">\n";
		
			echo "\t\t\t<div class=\"item active\">\n";
				echo "\t\t\t\t<img src=\"http://niseko.kutchannel.net/agileImages/sponsors/HolidayNiseko/HolidayNiseko-726x90.png\" style=\"margin:0px auto;\">\n";
			echo "\t\t\t</div>\n";
			
			echo "\t\t\t<div class=\"item\">\n";
				echo "\t\t\t\t<img src=\"http://nisekoproperty.net/agileImages/sponsors/NisekoConsulting/NisekoConsulting-726x90.jpg\" style=\"margin:0px auto;\">\n";
			echo "\t\t\t</div>\n";
			
			echo "\t\t\t<div class=\"item\">\n";
				echo "\t\t\t\t<img src=\"http://niseko.kutchannel.net/agileImages/ZeniDev-726x90.png\" style=\"margin:0px auto;\">\n";
			echo "\t\t\t</div>\n";
			
		echo "\t\t</div>\n";

		echo '
		  <!-- Controls -->
		  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left"></span>
		  </a>
		  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right"></span>
		  </a>
		</div>

		';
	echo "\t</div>\n\n";
	
}


// START CONTENT //

function contentExistsForThisUrl($entrySeoURL) {
	$query = "SELECT * FROM nisekocms_content WHERE entrySeoURL = '$entrySeoURL'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 1) { return true; } else { return false; }
}

function displayJagaContent($entrySeoURL) {

	$resultGetContent = "SELECT * FROM nisekocms_content WHERE entrySeoURL = '$entrySeoURL' LIMIT 1";
	$resultGetContent = mysql_query($resultGetContent);
	$rowGetContent = mysql_fetch_array($resultGetContent);
	
	$contentID = $rowGetContent['entryID'];
	$contentSubmittedByUserID =  $rowGetContent['entrySubmittedByUserID'];
	$contentSubmittedByUserName = getUserName($contentSubmittedByUserID);
	$contentSubmissionDateTime =  $rowGetContent['entrySubmissionDateTime'];
	
	if ($_SESSION['lang'] == 'ja') {
		$contentTitle = $rowGetContent['entryTitleJapanese'];
		$content = $rowGetContent['entryContentJapanese'];
	} else {
		$contentTitle = $rowGetContent['entryTitleEnglish'];
		$content = $rowGetContent['entryContentEnglish'];
	}
	
	echo "\n\t<div class=\"container\">\n";
	
		echo "\t\t<div class=\"panel panel-default\">\n";
			echo "\t\t\t<div class=\"panel-heading\"><h1>" . $contentTitle . "</h1></div>\n";
			echo "\t\t\t<div class=\"panel-body\">" . nl2br(strip_tags($content)) . "</div>\n";
			echo "\t\t\t<div class=\"panel-footer text-right\">";
				echo "Submitted by <a href=\"/" . languageUrlPrefix() . "user/" . $contentSubmittedByUserName . "/\">" . $contentSubmittedByUserName . "</a> at " . $contentSubmissionDateTime;
			echo "</div>\n";
		echo "\t\t</div>\n";
		
		$queryGetContentComments = "SELECT * FROM nisekocms_contentComment WHERE contentID = '$contentID' ORDER BY commentDateTime ASC";
		$resultGetContentComments = mysql_query($queryGetContentComments);
		
		while ($rowGetContentComments = mysql_fetch_array($resultGetContentComments)) {
		
			$contentCommentSubmittedByUserID =  $rowGetContentComments['userID'];
			$contentCommentSubmittedByUserName = getUserName($rowGetContentComments['userID']);
			$contentCommentSubmissionDateTime =  $rowGetContentComments['commentDateTime'];
			$contentComment = $rowGetContentComments['commentContent'];
		
			echo "\t\t<div class=\"panel panel-default\">\n";
				echo "\t\t\t<div class=\"panel-body\">" . nl2br(strip_tags($contentComment)) . "</div>\n";
				echo "\t\t\t<div class=\"panel-footer text-right\">";
					echo "Submitted by <a href=\"/" . languageUrlPrefix() . "user/" . $contentCommentSubmittedByUserName . "/\">" . $contentCommentSubmittedByUserName . "</a> at " . $contentCommentSubmissionDateTime;
				echo "</div>\n";
			echo "\t\t</div>\n";
			
		}
		
		
	echo "\t</div>\n";
	
}

function displayJagaContentList($contentCategorySeoURL) {

	$query = "
		SELECT contentCategoryKey FROM nisekocms_contentCategory 
		WHERE contentCategory_listURL = '$contentCategorySeoURL'
		LIMIT 1
	";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	$contentCategoryKey = $row['contentCategoryKey'];
	
	
	echo "\t\t\t<div class=\"container\">";
		echo "\t\t\t\t<div class=\"panel panel-default\">\n";
			echo "\t\t\t\t<div class=\"panel-heading\">\n";
				echo "\t\t\t\t<h3>" . getContentCategoryName($contentCategoryKey) . "</h3>\n";
			echo "\t\t\t\t</div>\n";
			echo "\t\t\t\t<div class=\"panel-body\">\n";
				$queryGetContent = "
					SELECT * FROM nisekocms_content 
					WHERE contentCategoryKey = '$contentCategoryKey' 
					ORDER BY entrySubmissionDateTime DESC 
					LIMIT 25
				";
				$resultGetContent = mysql_query($queryGetContent);
				echo "\t\t\t\t\t<div class=\"list-group\">\n";
					while ($rowGetContent = mysql_fetch_Array($resultGetContent)) {
						echo "<a class=\"list-group-item\" href=\"/" . getContentListURL($contentCategoryKey) . '/' . $rowGetContent['entrySeoURL'] . "/\">";
							echo '<strong>' . getUserName($rowGetContent['entrySubmittedByUserID']) . '</strong>';
							echo "<span class=\"badge\">" . date('M d', strtotime($rowGetContent['entrySubmissionDateTime'])) . "</span>";
							echo '<p style="color:#0f5c8c;" class="list-group-item-text">' . $rowGetContent['entryTitleEnglish'] . '</p>';
						echo "</a>";
					}
				echo "\t\t\t\t\t</div>\n";
				echo "<a class=\"list-group-item\" href=\"/" . languageUrlPrefix() . getContentListURL($contentCategoryKey) . "/\">view more...</a>";
			echo "\t\t\t\t</div>\n";
		echo "\t\t\t\t</div>\n";
	echo "\t\t\t</div>\n\n";
	
	
	
 
}

// END CONTENT //



// START AUTHENTICATION //

function displayJagaLoginForm($username = '', $password = '', $errorArray = array()) {
    
	echo "\t<div class=\"container\">\n";    
		echo "\t\t<div id=\"loginbox\" style=\"margin-top:50px;\" class=\"mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2\">\n";                
			echo "\t\t\t<div class=\"panel panel-default\">\n";
			
				echo "\t\t\t\t<div class=\"panel-heading\">\n";
					echo "\t\t\t\t\t<div class=\"panel-title\">Sign In</div>\n";
					echo "\t\t\t\t\t<div style=\"float:right;font-size:80%;position:relative;top:-10px;\">";
						echo "<a href=\"/" . languageUrlPrefix() . "password-recovery/\">" . agileResource('forgotPassword') . "</a>";
					echo "</div>\n";
				echo "\t\t\t\t</div>\n";
				
				echo "\t\t\t\t<div style=\"padding-top:30px\" class=\"panel-body\">\n";
				
					if (!empty($errorArray)) {
						echo "\t\t\t\t\t<div id=\"login-alert\" class=\"alert alert-danger col-sm-12\"></div>\n";
					}
					
					echo "\t\t\t\t\t<form id=\"login\" class=\"form-horizontal\" role=\"form\" method=\"post\" action=\"/" . languageUrlPrefix() . "login/\">\n";
					
						echo "\t\t\t\t\t\t<div style=\"margin-bottom: 25px\" class=\"input-group\">\n";
							echo "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>\n";
							echo "\t\t\t\t\t\t\t<input id=\"login-username\" type=\"text\" class=\"form-control\" name=\"username\" value=\"\" placeholder=\"username or email\">\n";       
						echo "\t\t\t\t\t\t</div>\n";
						
						echo "\t\t\t\t\t\t<div style=\"margin-bottom: 25px\" class=\"input-group\">\n";
							echo "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>\n";
							echo "\t\t\t\t\t\t\t<input id=\"login-password\" type=\"password\" class=\"form-control\" name=\"password\" placeholder=\"password\">\n";
						echo "\t\t\t\t\t\t</div>\n";
						
						// echo "\t\t\t\t\t\t<div class=\"input-group\">\n";
							// echo "\t\t\t\t\t\t\t<div class=\"checkbox\">\n";
								// echo "\t\t\t\t\t\t\t\t<label>\n";
								// echo "\t\t\t\t\t\t\t\t<input id=\"login-remember\" type=\"checkbox\" name=\"remember\" value=\"1\"> Remember me\n";
								// echo "\t\t\t\t\t\t\t\t</label>\n";
							// echo "\t\t\t\t\t\t\t</div>\n";
						// echo "\t\t\t\t\t\t</div>\n";
						
						echo "\t\t\t\t\t\t<div style=\"margin-top:10px;\" class=\"form-group\">\n";
							echo "\t\t\t\t\t\t\t<!-- Button -->\n";
							echo "\t\t\t\t\t\t\t<div class=\"col-sm-12 controls\">\n";
								echo "\t\t\t\t\t\t\t\t<a id=\"btn-login\" href=\"#\" class=\"btn btn-success\">" . agileResource('login') . "</a>\n";
								// echo "\t\t\t\t\t\t\t\t<a id=\"btn-fblogin\" href=\"#\" class=\"btn btn-primary\">Login with Facebook</a>\n";
							echo "\t\t\t\t\t\t\t</div>\n";
						echo "\t\t\t\t\t\t</div>\n";
						
						echo "\t\t\t\t\t\t<div class=\"form-group\">\n";
							echo "\t\t\t\t\t\t\t<div class=\"col-md-12 control\">\n";
								echo "\t\t\t\t\t\t\t\t<div style=\"border-top: 1px solid#888; padding-top:15px; font-size:85%;\" >\n";
								echo "\t\t\t\t\t\t\t\tDon't have an account?\n";
								echo "\t\t\t\t\t\t\t\t<a href=\"/" . languageUrlPrefix() . "register/\">" . agileResource('register') . "</a>\n";
								echo "\t\t\t\t\t\t\t\t</div>\n";
							echo "\t\t\t\t\t\t\t</div>\n";
						echo "\t\t\t\t\t\t</div>\n";
						
					echo "\t\t\t\t\t</form>\n";
				echo "\t\t\t\t</div>\n";
			echo "\t\t\t</div>\n";
		echo "\t\t</div>\n";
	echo "\t</div>\n";
}

function displayJagaRegistrationForm() {
	/*
        <div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Sign Up</div>
                            <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()">Sign In</a></div>
                        </div>  
                        <div class="panel-body" >
                            <form id="signupform" class="form-horizontal" role="form">
                                
                                <div id="signupalert" style="display:none" class="alert alert-danger">
                                    <p>Error:</p>
                                    <span></span>
                                </div>
                                    
                                
                                  
                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="email" placeholder="Email Address">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="firstname" class="col-md-3 control-label">First Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="firstname" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lastname" class="col-md-3 control-label">Last Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="lastname" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-md-3 control-label">Password</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="passwd" placeholder="Password">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="icode" class="col-md-3 control-label">Invitation Code</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="icode" placeholder="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-signup" type="button" class="btn btn-info"><i class="icon-hand-right"></i> &nbsp Sign Up</button>
                                        <span style="margin-left:8px;">or</span>  
                                    </div>
                                </div>
                                
                                <div style="border-top: 1px solid #999; padding-top:20px"  class="form-group">
                                    
                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-fbsignup" type="button" class="btn btn-primary"><i class="icon-facebook"></i>   Sign Up with Facebook</button>
                                    </div>                                           
                                        
                                </div>
                                
                                
                                
                            </form>
                         </div>
                    </div>

               
               
                
         </div>
		
	*/
}

// END AUTHENTICATION //


function displayUserProfile($username) {

	$query = "SELECT * FROM j00mla_ver4_users WHERE username = '$username'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) != 1) { die('displayUserProfile:ERROR'); }
	$row = mysql_fetch_array($result);
	
	$userID = $row['id'];
	
	echo "\t<div class=\"container\">\n";
		echo "\t\t<div class=\"row\">\n";
			echo "\t\t\t<div class=\"panel panel-default\">\n";
			
			
				echo "\t\t\t\t<div class=\"panel-heading\">\n";
					echo $username;
				echo "\t\t\t\t</div>\n";
				
				
				echo "\t\t\t\t<div class=\"panel-body\">\n";
					echo $username;
				echo "\t\t\t\t</div>\n";
				
				echo "\t\t\t\t<div class=\"table-responsive\">\n";
					echo "\t\t\t\t\t<table class=\"table table-striped table-hover\">\n";
					
						$queryGetUserContent = "
							SELECT * FROM nisekocms_content 
							WHERE entrySubmittedByUserID = '$userID'
							ORDER BY entrySubmissionDateTime DESC
						";
						$resultGetUserContent = mysql_query($queryGetUserContent);
						
						
						
						while ($rowGetUserContent = mysql_fetch_array($resultGetUserContent)) {
						
							if ($_SESSION['lang'] == 'ja') {
								$contentTitle = $rowGetUserContent['entryTitleJapanese'];
							} else {
								$contentTitle = $rowGetUserContent['entryTitleEnglish'];
							}
						
							echo "\t\t\t\t\t\t<tr>\n";
								echo "\t\t\t\t\t\t\t<td>" . $contentTitle . "</td>\n";
							echo "\t\t\t\t\t\t</tr>\n";
						}
						
					echo "\t\t\t\t\t</table>\n";
				echo "\t\t\t\t</div>\n";
				
				echo "\t\t\t\t<div class=\"panel-footer\">\n";
					echo $username;
				echo "\t\t\t\t</div>\n";
				
				
			echo "\t\t\t</div>\n";
		echo "\t\t</div>\n";
	echo "\t</div>\n\n";
	

}

?>