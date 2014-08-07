<?php

class Controller {
	
	public function __construct() {
	
		if (!isset($_COOKIE['TheKutchannel'])) { $cookie = new Cookie(); }
	
		$channelID = Channel::getSelectedChannelID();
		Session::setSession('channelID', $channelID);
		
		$userID = 0;
		if (isset($_COOKIE['TheKutchannel'])) {
			$sessionID = $_COOKIE['TheKutchannel'];
			$userID = Session::getAuthSessionUserID($sessionID);
		}
		
		Session::setSession('userID', $userID);
		
		// if (!empty($_POST)) { Session::setSession('post', $_POST); } else {  }

	}

	public function getResource($urlArray) {

		if ($_SESSION['channelID'] == 0) {
		
			// note: still need to reroute reserved strings
			
			$reservedDomains = array('dev');
			
			$domain = $_SERVER['HTTP_HOST'];
			$tmp = explode('.', $domain);
			$subdomain = current($tmp);
			
			if (in_array($subdomain,$reservedDomains)) {
				return '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"><head><title>The Kutchannel: This subdomain is reserved.</title><META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW"></head><body style="background-color:#FFFF99;padding-top:150px;"><div style="text-align:center;"><a href="http://the.kutchannel.net/"><img src="/jaga/images/banner.png" style="max-width:100%;border-style:none;"></a><br />This subdomain is reserved.</div></body></html>';
				die();			
			} else {
				return '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"><head><title>The Kutchannel: The "' . $subdomain . '" channel does not yet exist.</title><META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW"></head><body style="background-color:#FFFF99;padding-top:150px;"><div style="text-align:center;"><a href="http://the.kutchannel.net/"><img src="/jaga/images/banner.png" style="max-width:100%;border-style:none;"></a><br />This channel has not yet been created. <a href="http://the.kutchannel.net/create-a-channel/' . $subdomain . '/" style="text-decoration:none;">Create it</a>!</div></body></html>';
				die();
			}

		}
	
		$arrayOfSupportedLanguages = array('en','ja');
		if (in_array($urlArray[0], $arrayOfSupportedLanguages)) {
			Session::setSession('lang', $urlArray[0]);
			array_shift($urlArray);
		} else {
			Session::setSession('lang', 'en');
		}

		$i = 0; while ($i <= 3) { if (!isset($urlArray[$i])) { $urlArray[$i] = ''; } $i++; } // minimum 3 array pointers

		if ($urlArray[0] == 'login') {
			
			$inputArray = array();
			$errorArray = array();
			
			if (isset($_POST['jagaLoginSubmit'])) {
			
				$username = $_POST['username'];
				$password = $_POST['password'];
			
				$errorArray = Authentication::checkAuth($username, $password);
				
				if (empty($errorArray)) {
				
					// log user in
					$userID = User::getUserIDwithUserNameOrEmail($username);
					Session::setSession('userID', $userID);
					
					// save session to db
					$authSession = new Session();
					$authSession->createAuthSession();
					
					// terminate script; forward header
					if (isset($_SESSION['loginForwardURL'])) {
						$forwardURL = $_SESSION['loginForwardURL'];
						Session::unsetSession('loginForwardURL');
						header("Location: $forwardURL");
					} else {
						$forwardURL = '/';
					}
					header("Location: $forwardURL");
					
				}
				
			}
			
			$page = new PageView();
			$html = $page->buildPage($urlArray, $inputArray, $errorArray);
			return $html;
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
		} elseif ($urlArray[0] == 'register') {
		
			$inputArray = array();
			$errorArray = array();
			
			if (isset($_POST['jagaRegisterSubmit'])) {
			
				$inputArray['username'] = $_POST['username'];
				$inputArray['userEmail'] = $_POST['userEmail'];
				
				$username = $_POST['username'];
				$userEmail = $_POST['userEmail'];
				$password = $_POST['password'];
				$confirmPassword = $_POST['confirmPassword'];
			
				$errorArray = Authentication::register($username, $userEmail, $password, $confirmPassword);
				
				if (empty($errorArray)) {
				
					// register user
					// $userID = User::getUserIDwithUserNameOrEmail($username);
					// Session::setSession('userID', $userID);

					// terminate script; forward header
					$forwardURL = '/thank-you-for-registering/';
					header("Location: $forwardURL");
					
				}
				
			}
			
			$page = new PageView();
			$html = $page->buildPage($urlArray, $inputArray, $errorArray);
			return $html;
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
		
		} elseif ($urlArray[0] == 'logout') {

			Authentication::logout();
			header("Location: /");
			
		} elseif ($urlArray[0] == 'rss') {

			$rss = new Rss();
			$feed = $rss->getFeed($urlArray);
			return $feed;
			
		} elseif ($urlArray[0] == 'sitemap.xml') {
		
			$sitemap = new Sitemap();
			$xml = $sitemap->getSitemap($urlArray);
			return $xml;
			
		} elseif ($urlArray[0] == 'channel.css') {
		
			$theme = new ThemeView();
			$css = $theme->getTheme();
			
			header("Content-type: text/css");
			return $css;
			
		} elseif ($urlArray[0] == 'manage-channels') {

			// LOGGED IN USERS ONLY
			if ($_SESSION['userID'] == 0) { die('you are not logged in'); }
		
			// CHANNEL OWNER ONLY FOR UPDATE
			if ($urlArray[1] == 'update') {
				if ($urlArray[2] == '') {
					die ('A channel must be selected.');
				} else {
					$channelID = Channel::getChannelID($urlArray[2]);
					$channel = new Channel($channelID);
					$channelCreatorID = $channel->siteManagerUserID;
					if ($_SESSION['userID'] != $channelCreatorID) { die ('You do not own this channel.'); }
				}
			}
			
			// INITIALIZE $inputArray and $errorArray
			$inputArray = array();
			$errorArray = array();
			
			// IF USER INPUT EXISTS
			if (!empty($_POST)) {
			
				$inputArray = $_POST;

				// VALIDATION
				if (!preg_match('/^[a-zA-Z0-9-]+$/', $inputArray['channelKey'])) {
					$errorArray[] = 'The Key can contain only letters, numbers, and hyphens.';
				}
				// check if channel key exists
				if ($inputArray['channelTitleEnglish'] == '') { $errorArray[] = 'A title is required field.'; }
				if ($inputArray['channelKeywordsEnglish'] == '') { $errorArray[] = 'Keywords are required.'; }
				if ($inputArray['channelDescriptionEnglish'] == '') { $errorArray[] = 'A description is required.'; }
				// is at least one contentCategorySelected?
				
				if (empty($errorArray)) {
				
					if ($urlArray[1] == 'create') {

						$channel = new Channel(0);
						
						// filter out auto_increment key
						unset($channel->channelID);
						
						// set object property values
						foreach ($inputArray AS $property => $value) { if (isset($channel->$property)) { $channel->$property = $value; } }
						
						$channelID = Channel::insert($channel);

						// START ChannelCategory //
						foreach ($inputArray['contentCategoryKey'] AS $contentCategoryKey) {
							$channelCategory = new ChannelCategory();
							$channelCategory->channelID = $channelID;
							$channelCategory->contentCategoryKey = $contentCategoryKey;
							ChannelCategory::insert($channelCategory);
						}
						// END ChannelCategory //
						
						header("Location: /channels/");
						
					} elseif ($urlArray[1] == 'update' && isset($urlArray[2])) {
					
						$channelID = Channel::getChannelID($urlArray[2]);
					
						// build object
						$channel = new Channel($channelID);
						foreach ($inputArray AS $property => $value) { if (isset($channel->$property)) { $channel->$property = $value; } }
						
						// build conditions
						$conditions = array();
						$conditions['channelID'] = $channelID;
						
						// unset attributes that you don't want to update
						unset($channel->channelID);
						
						// update object
						Channel::update($channel, $conditions);
						
							// START ChannelCategory //
							
							$oldCategoryArray = array_keys(ChannelCategory::getChannelCategoryArray($channelID));
							$newCategoryArray = $inputArray['contentCategoryKey'];
							
							// if the old ain't in the new, delete it
							foreach ($oldCategoryArray AS $oldContentCategoryKey) {
								if (!in_array($oldContentCategoryKey, $newCategoryArray)) {
									$channelCategory = new ChannelCategory();
									$channelCategory->channelID = $channelID;
									$channelCategory->contentCategoryKey = $oldContentCategoryKey;
									ChannelCategory::delete($channelCategory);
								}
							}
							
							// if the new ain't in the old, insert it
							foreach ($newCategoryArray AS $newContentCategoryKey) {
								if (!in_array($newContentCategoryKey, $oldCategoryArray)) {
									$channelCategory = new ChannelCategory();
									$channelCategory->channelID = $channelID;
									$channelCategory->contentCategoryKey = $newContentCategoryKey;
									ChannelCategory::insert($channelCategory);
								}
							}
							
							// END ChannelCategory //

						// die ();
						header("Location: /manage-channels/");
						
					}

				}

			}
			
			$page = new PageView();
			$html = $page->buildPage($urlArray, $inputArray, $errorArray);
			return $html;

		} elseif ($urlArray[0] == 'k' && ($urlArray[1] == 'update' || $urlArray[1] == 'create')) {
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
			// INITIALIZE $inputArray and $errorArray
			$inputArray = array();
			$errorArray = array();
			
			
			// LOGGED IN USERS ONLY
			if ($_SESSION['userID'] == 0) {
				Session::setSession('loginForwardURL', $_SERVER['REQUEST_URI']);
				header("Location: /login/");
			}
		
			// CONTENT OWNER ONLY FOR UPDATE
			if ($urlArray[1] == 'update') {
				if ($urlArray[2] == '' || $urlArray[2] == 0) {
					die ('Content must be selected.');
				} else {
					$contentID = $urlArray[2];
					$content = new Content($contentID);
					$contentSubmittedByUserID = $content->contentSubmittedByUserID;
					if ($_SESSION['userID'] != $contentSubmittedByUserID) { die ('You can only edit your own content.'); }
				}
			}
			
			// IF USER INPUT EXISTS
			if (!empty($_POST)) {
			
				$inputArray = $_POST;

				// VALIDATION
				if ($inputArray['contentTitleEnglish'] == '') { $errorArray[] = 'Every post needs a title.'; }
				if ($inputArray['contentEnglish'] == '') { $errorArray[] = 'Your post is empty.'; }
				if ($inputArray['contentCategoryKey'] == '') { $errorArray[] = 'A category must be selected.'; }
				// is this category enabled for this channel? check it
				
				
				if (empty($errorArray)) {
					
					if ($urlArray[1] == 'create') {

						$content = new Content(0);
						
						// filter out auto_increment key
						unset($content->contentID);
						
						// set object property values
						foreach ($inputArray AS $property => $value) { if (isset($content->$property)) { $content->$property = $value; } }
						
						// modify values where required
						$content->contentURL = SEO::googlify($inputArray['contentTitleEnglish']);
						
						
						
						$contentID = Content::insert($content);

						$postSubmitURL = "/k/" . $inputArray['contentCategoryKey'] . "/";
						header("Location: $postSubmitURL");
						
					} elseif ($urlArray[1] == 'update' && isset($urlArray[2])) {
					
						$contentID = $urlArray[2];
					
						// build object
						$content = new Content($contentID);
						foreach ($inputArray AS $property => $value) {
							if (isset($content->$property)) {
								$content->$property = $value;
							}
						}
						
						// build conditions
						$conditions = array();
						$conditions['contentID'] = $contentID;
						
						// unset attributes that you don't want to update
						unset($content->contentID);
						
						// update object
						// print_r($content);
						Content::update($content, $conditions);

						$postSubmitURL = "/k/" . $inputArray['contentCategoryKey'] . "/";
						
						header("Location: $postSubmitURL");
						
					}

				}
				
			}
		
			$page = new PageView();
			$html = $page->buildPage($urlArray, $inputArray, $errorArray);
			return $html;

		} else {
		
			$page = new PageView();
			$html = $page->buildPage($urlArray);
			return $html;
			
		}

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	}
	
}

?>