<?php

class Controller {
	
	public function __construct() {
	
		if (!isset($_COOKIE['jaga'])) { $cookie = new Cookie(); }
	
		$channelID = Channel::getSelectedChannelID();
		Session::setSession('channelID', $channelID);
		$channelKey = Channel::getChannelKey($channelID);
		Session::setSession('channelKey', $channelKey);
		
		$userID = 0;
		if (isset($_COOKIE['jaga'])) {
			$sessionID = $_COOKIE['jaga'];
			$userID = Session::getAuthSessionUserID($sessionID);
		}
		
		Session::setSession('userID', $userID);

	}

	public function getResource($urlArray) {

		if ($_SESSION['channelID'] == 0) {
			
			$siteUrl = 'http://' . Config::read('site.url') . '/';
			
			$domain = $_SERVER['HTTP_HOST'];
			$tmp = explode('.', $domain);
			$subdomain = current($tmp);

			$reservedChannelNames = Channel::getReservedChannelNameArray();
			
			if (in_array($subdomain,$reservedChannelNames)) {
				return '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"><head><title>JAGA: This channel is reserved.</title><META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW"></head><body style="background-color:#555;color:#fff;padding-top:150px;"><div style="text-align:center;"><a href="' . $siteUrl . '"><img src="/jaga/images/banner.png" style="max-width:100%;border-style:none;"></a><br />This channel is reserved.</div></body></html>';
				die();			
			} else {
				return '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"><head><title>JAGA: This channel does not yet exist.</title><META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW"></head><body style="background-color:#eee;color:#000;padding-top:150px;"><div style="text-align:center;"><a href="' . $siteUrl . '"><img src="/jaga/images/banner.png" style="max-width:100%;border-style:none;"></a><br />This channel has not yet been created. <a href="' . $siteUrl . 'settings/channels/create/' . $subdomain . '/" style="text-decoration:none;">Create it</a>!</div></body></html>';
				die();
			}

		}
	
		$arrayOfSupportedLanguages = array('en','ja');
		$lang = Lang::getBrowserDefaultLanguage();
		if ($_SESSION['userID'] != 0) { $lang = User::getUserSelectedLanguage($_SESSION['userID']); }
		if (!in_array($lang, $arrayOfSupportedLanguages)) { $lang = 'en'; }

		if (!isset($_SESSION['lang'])) { Session::setSession('lang', $lang); }

		$i = 0; while ($i <= 3) { if (!isset($urlArray[$i])) { $urlArray[$i] = ''; } $i++; } // minimum 3 array pointers
		$notHTML = array('rss','sitemap.xml','channel.css','lang');
		$inputArray = array();
		$errorArray = array();

		if ($urlArray[0] == 'login') {
			
			if (Authentication::isLoggedIn()) { header("Location: /"); };
			
			if (isset($_POST['jagaLoginSubmit'])) {
			
				$inputArray['username'] = $_POST['username'];
				
				$username = $_POST['username'];
				$password = $_POST['password'];
			
				$errorArray = Authentication::checkAuth($username, $password);
				
				if (empty($errorArray)) {
				
					// log user in
					$userID = User::getUserIDwithUserNameOrEmail($username);
					Session::setSession('userID', $userID);
					
					// set userLastVisitDateTime
					User::setUserLastVisitDateTime($userID);
					
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
					
					// reset channel session view counter
					Session::setSession('displayChannelWelcome', 1);
					
					header("Location: $forwardURL");
					
				}
				
			}

			
		}
		
		if ($urlArray[0] == 'register') {

			if (!empty($_POST)) {
			
				$inputArray = $_POST;
				$username = $inputArray['username'];
				$userEmail = $inputArray['userEmail'];
				$password = $inputArray['password'];
				$confirmPassword = $inputArray['confirmPassword'];
				$raptcha = $inputArray['raptcha'];
				$obFussyCat = isset($inputArray[$_SESSION['obFussyCat']]);
				$errorArray = Authentication::register($username, $userEmail, $password, $confirmPassword, $raptcha, $obFussyCat);
				
				if (empty($errorArray)) {

					$user = new User(0);
					$user->username = $username;
					$user->userDisplayName = $username;
					$user->userEmail = $userEmail;
					$user->userPassword = md5($password);
					$userID = Content::insert($user);
					
					if ($_SESSION['channelKey'] != 'www') {
						Subscription::subscribeUser($userID, $_SESSION['channelID']);
					} else {
						Subscription::subscribeUser($userID, 14);
					}
					
					$forwardURL = '/thank-you-for-registering/';
					header("Location: $forwardURL");
					
				}
				
			}

		}
		
		if ($urlArray[0] == 'logout') {

			Authentication::logout();
			header("Location: /");
			
		}
			
		if ($urlArray[0] == 'k' && ($urlArray[1] == 'update' || $urlArray[1] == 'create')) {

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
					if ($_SESSION['userID'] != $contentSubmittedByUserID && !Authentication::isAdmin()) { die ('You can only edit your own content.'); }
				}
			}
			
			// IF USER INPUT EXISTS
			if (!empty($_POST)) {

				$inputArray = $_POST;

				// VALIDATION
				if ($inputArray['contentTitleEnglish'] == '' && $inputArray['contentTitleJapanese'] == '') { $errorArray['contentTitle'][] = 'Every post needs a title.'; }
				if ($inputArray['contentCategoryKey'] == '') { $errorArray['contentCategoryKey'][] = 'A category must be selected.'; }
				
				
				if (empty($errorArray)) {
					
					if ($urlArray[1] == 'create') {

						$content = new Content(0);
						
						// filter out auto_increment key
						unset($content->contentID);
						
						// set object property values
						foreach ($inputArray AS $property => $value) { if (isset($content->$property)) { $content->$property = $value; } }
						
						// modify values where required
						$content->contentURL = Content::createContentURL($inputArray['contentTitleEnglish']);
						if ($content->contentURL == '' || Content::contentURLExists($content->contentURL)) {
							$content->contentURL = Content::generateNonDuplicateContentURL($content->contentURL);
						}
						if (!isset($inputArray['contentPublished'])) { $content->contentPublished = 0; }
						if (!isset($inputArray['contentHasLocation'])) { $content->contentHasLocation = 0; }
						if (!isset($inputArray['contentIsEvent'])) { $content->contentIsEvent = 0; }
						
						$contentID = Content::insert($content);

						if (!empty($_FILES)) {

							// print_r($_FILES);
							
							$numberOfImages = count($_FILES['contentImages']['name']);
							
							for ($i = 0; $i < $numberOfImages; $i++) {
							
								$imageArray = array();
								$imageArray['name'] = $_FILES['contentImages']['name'][$i];
								$imageArray['type'] = $_FILES['contentImages']['type'][$i];
								$imageArray['tmp_name'] = $_FILES['contentImages']['tmp_name'][$i];
								$imageArray['error'] = $_FILES['contentImages']['error'][$i];
								$imageArray['size'] = $_FILES['contentImages']['size'][$i];
								
								$imageObject = 'Content';
								$imageObjectID = $contentID;
								Image::uploadImageFile($imageArray,$imageObject,$imageObjectID);
								
							}

						}
	
						$postSubmitURL = "/k/" . $inputArray['contentCategoryKey'] . "/";
						
						$addresseeEmail = Config::read('admin.email');
						$senderEmail = Config::read('system.email');
						$mailSubject = '[new jaga.io post by ' . User::getUserName($_SESSION['userID']) . '] => \'' . $content->getTitle() . '\'';
						$mailContent = 'http://' . $_SESSION['channelKey'] . '.' . Config::read('system.url') . '/k/' . $inputArray['contentCategoryKey'] . '/' . $content->contentURL . '/';
						
						Mail::sendEmail($addresseeEmail, $senderEmail, $mailSubject, $mailContent, $_SESSION['channelID'], $_SESSION['userID'], 'plaintext');
						
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
						
						// modify values where required
						if (!isset($inputArray['contentPublished'])) { $content->contentPublished = 0; }
						if (!isset($inputArray['contentHasLocation'])) { $content->contentHasLocation = 0; }
						if (!isset($inputArray['contentIsEvent'])) { $content->contentIsEvent = 0; }
						
						// build conditions
						$conditions = array();
						$conditions['contentID'] = $contentID;
						
						// unset attributes that you don't want to update
						unset($content->contentID);
						
						// update object
						Content::update($content, $conditions);

						// image upload
						if (!empty($_FILES)) {

							$numberOfImages = count($_FILES['contentImages']['name']);
							
							for ($i = 0; $i < $numberOfImages; $i++) {

								$imageArray = array();
								$imageArray['name'] = $_FILES['contentImages']['name'][$i];
								$imageArray['type'] = $_FILES['contentImages']['type'][$i];
								$imageArray['tmp_name'] = $_FILES['contentImages']['tmp_name'][$i];
								$imageArray['error'] = $_FILES['contentImages']['error'][$i];
								$imageArray['size'] = $_FILES['contentImages']['size'][$i];
								
								$imageObject = 'Content';
								$imageObjectID = $contentID;
								Image::uploadImageFile($imageArray,$imageObject,$imageObjectID);

							}

						}
						
						$postSubmitURL = "/k/" . $inputArray['contentCategoryKey'] . "/";
					
						header("Location: $postSubmitURL");
						
					}

				}
				
			}

		}

		if ($urlArray[0] == 'k' && $urlArray[1] == 'comment' && is_numeric($urlArray[2])) {
			
			if ($_SESSION['userID'] == 0) { die('You must be logged in to comment.'); }
			$contentPath = Content::getContentURL($urlArray[2]);
			if (!empty($_POST)) { $inputArray = $_POST; } else { header("Location: $contentPath"); }
			
			$comment = new Comment(0);
			unset($comment->commentID);
			foreach ($inputArray AS $property => $value) { if (isset($comment->$property)) { $comment->$property = $value; } }
			$comment->commentObject = 'Content';
			$comment->commentObjectID = $urlArray[2];
			$commentID = Comment::insert($comment);

			$content = new Content($urlArray[2]);
			$channel = new Channel($content->channelID);
			$commenter = new User($_SESSION['userID']);
			
			$mailSender = 'JagaBot <noreply@jaga.io>';
			$mailSubject = $commenter->getUserDisplayName() . ' has commented on [' . $content->getTitle() . ']';
			$mailMessage = 'http://' . $channel->channelKey . '.jaga.io/k/' . $content->contentCategoryKey . '/' . $content->contentURL . '/';
				
			$usersToNotify = $content->usersToNotifyOfComments();
			
			foreach ($usersToNotify AS $userID) {
				$recipient = new User($userID);
				$mailRecipient = $recipient->getUserDisplayName() . ' <' . $recipient->userEmail . '>';
				Mail::sendEmail($mailRecipient, $mailSender, $mailSubject, $mailMessage, $_SESSION['channelKey'], $_SESSION['userID']);
			}
			
			Mail::sendEmail('JagaAdmin <' . Config::read('admin.email') . '>', $mailSender, $mailSubject, $mailMessage, $_SESSION['channelKey'], $_SESSION['userID']);
			
			header("Location: $contentPath");
			
		}
		
		if ($urlArray[0] == 'k' && $urlArray[1] == 'comment' && $urlArray[2] == 'delete' && is_numeric($urlArray[3])) {

			$commentID = $urlArray[3];
			$comment = new Comment($commentID);
			if ($comment->userID != $_SESSION['userID']) { die('You do not own this comment, you silly goose!'); }
			if ($comment->commentObject == 'Content') {
				$contentPath = Content::getContentURL($comment->commentObjectID);
			} else {
				die ("What kind of comment exactly you trying to delete, boss? It obviously ain't content.");
			}
			$conditions = array('commentID' => $commentID);
			Comment::delete($comment, $conditions);
			header("Location: $contentPath");
			
		}
		
		if ($urlArray[0] == 'k' && $urlArray[1] == 'delete' && is_numeric($urlArray[2])) {

		
			if (isset($_POST['jagaDeleteContentConfirmation'])) {
				
				$contentID = $urlArray[2];
				$content = new Content($contentID);
				$contentCategoryKey = $content->contentCategoryKey;
				$authorUserID = $content->contentSubmittedByUserID;
				if ($authorUserID != $_SESSION['userID']) { die('"You cannot delete posts that do not belong to you." - Controller::getResource()'); }
				$conditions = array('contentID' => $contentID);
				ChannelCategory::delete($content, $conditions);
				
				$postSubmitURL = "/k/" . $contentCategoryKey . "/";
				header("Location: $postSubmitURL");
			
			}
			
		}
		
		if ($urlArray[0] == 'settings') {
		
			// REDIRECT USERS WITHOUT CREDS TO LOGIN ROUTE
			if ($_SESSION['userID'] == 0) {
				Session::setSession('loginForwardURL', $_SERVER['REQUEST_URI']);
				header("Location: /login/");
			}

			if ($urlArray[1] == 'profile') {
				
				// IF USER INPUT EXISTS
				if (!empty($_POST)) {
				
					$inputArray = $_POST;
					
					// print_r($inputArray);
					
					// VALIDATION
					if ($inputArray['userDisplayName'] == '') { $errorArray['userDisplayName'][] = 'A display name is required.'; }
					if ($inputArray['userEmail'] == '') { $errorArray['userEmail'][] = 'An email address is required.'; }
					if ($inputArray['userPassword'] != $inputArray['confirmPassword']) { $errorArray['confirmPassword'][] = 'Passwords do not match.'; }
					
					if (empty($errorArray)) {
					
						$userID = $_SESSION['userID'];
					
						// build object
						$user = new User($userID);
						foreach ($inputArray AS $property => $value) { if (isset($user->$property)) { $user->$property = $value; } }
						if ($inputArray['userPassword'] != '') { $user->userPassword = md5($inputArray['userPassword']); }
						
						// build conditions
						$conditions = array();
						$conditions['userID'] = $userID;
						
						// unset attributes that you don't want to update
						unset($user->userID);
						unset($user->username);
						unset($user->userEmailVerified);
						unset($user->userAcceptsEmail);
						unset($user->userRegistrationChannelID);
						unset($user->userRegistrationDateTime);
						unset($user->userLastVisitDateTime);
						unset($user->userTestMode);
						unset($user->userBlackList);
						unset($user->userSelectedLanguage);
						if ($inputArray['userPassword'] == '') { unset($user->userPassword); }

						// update user
						User::update($user, $conditions);
						
						// upload profile image
						if (!empty($_FILES)) {
							$image = $_FILES['profileImage'];
							$imageObject = 'User';
							$imageObjectID = $userID;
							Image::uploadImageFile($image,$imageObject,$imageObjectID);
						}

						$postSubmitURL = "/settings/profile/";
						header("Location: $postSubmitURL");
						
					}
					
				}

			}
			
			if ($urlArray[1] == 'channels') {
			
				// LOGGED IN USERS ONLY
				if ($_SESSION['userID'] == 0) { die('you are not logged in'); }
			
				// CHANNEL OWNER ONLY FOR UPDATE
				if ($urlArray[2] == 'update') {
					if ($urlArray[3] == '') {
						die ('A channel must be selected.');
					} else {
						$channelID = Channel::getChannelID($urlArray[3]);
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
						$errorArray['channelKey'] = 'The Key can contain only letters, numbers, and hyphens.';
					}
					
					// check if channel key exists
					if ($inputArray['channelTitleEnglish'] == '') { $errorArray['channelTitleEnglish'] = 'A title is required field.'; }
					if ($inputArray['channelKeywordsEnglish'] == '') { $errorArray['channelKeywordsEnglish'] = 'Keywords are required.'; }
					if ($inputArray['channelDescriptionEnglish'] == '') { $errorArray['channelDescriptionEnglish'] = 'A description is required.'; }
					// is at least one contentCategorySelected?
					
					if (empty($errorArray)) {
					
						if ($urlArray[2] == 'create') {

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
							
							// START NewCategory //
							foreach ($inputArray['newCategory'] AS $newCategory) {
								
								if ($newCategory != '') { // also check to see if category exists
								
									if (!Category::categoryExists($newCategory)) {
										$category = new Category();
										$category->contentCategoryKey = $newCategory;
										$category->contentCategoryEnglish = $newCategory;
										$category->contentCategoryJapanese = $newCategory;
										$category->contentCategoryJapaneseReading = $newCategory;
										Category::insert($category);
									}
									
									$channelCategory = new ChannelCategory();
									$channelCategory->channelID = $channelID;
									$channelCategory->contentCategoryKey = $newCategory;
									ChannelCategory::insert($channelCategory);
								
								}
								
								

							}
							// END NewCategory //

							header("Location: /channels/");
							
						} elseif ($urlArray[2] == 'update' && isset($urlArray[3])) {
						
							$channelID = Channel::getChannelID($urlArray[3]);
						
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
										$conditions = array('channelID' => $channelCategory->channelID, 'contentCategoryKey' => $channelCategory->contentCategoryKey);
										ChannelCategory::delete($channelCategory, $conditions);
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
								
								
							// START NewCategory //
							foreach ($inputArray['newCategory'] AS $newCategory) {
								
								if ($newCategory != '') { // also check to see if category exists
								
									$category = new Category();
									$category->contentCategoryKey = $newCategory;
									$category->contentCategoryEnglish = $newCategory;
									$category->contentCategoryJapanese = $newCategory;
									$category->contentCategoryJapaneseReading = $newCategory;
									Category::insert($category);
									
									$channelCategory = new ChannelCategory();
									$channelCategory->channelID = $channelID;
									$channelCategory->contentCategoryKey = $newCategory;
									ChannelCategory::insert($channelCategory);
								
								}
								
								

							}
							// END NewCategory //
							

							// die ();
							header("Location: /settings/channels/");
							
						}

					}

				}

			
			}
			
			if ($urlArray[1] == 'subscriptions') {
			
			}

		}
		
		if ($urlArray[0] == 'subscribe') {
			
			if ($_SESSION['userID'] != 0) {
				Subscription::subscribeUser($_SESSION['userID'], $_SESSION['channelID']);
			} else {
				$errorArray['subscribe'][] = 'You must be logged in to subscribe.';
			}
		
		}
		
		if ($urlArray[0] == 'unsubscribe') {

			if ($_SESSION['userID'] != 0) {
				Subscription::unsubscribeUser($_SESSION['userID'], $_SESSION['channelID']);
			} else {
				$errorArray['unsubscribe'][] = 'You must be logged in to unsubscribe.';
			}
			
		}
		
		if ($urlArray[0] == 'account-recovery') {
			
			if (isset($_POST['jagaAccountRecoverySubmit'])) {
				$inputArray = $_POST;
				$userEmail = $inputArray['userEmail'];
				$raptcha = $inputArray['raptcha'];
				$errorArray = AccountRecovery::accountRecoveryRequestValidation($userEmail, $raptcha);
				if (empty($errorArray)) {
				
					$accountRecovery = new AccountRecovery(0);
					unset($accountRecovery->accountRecoveryID);
					$accountRecovery->accountRecoveryEmail = $userEmail;
					$accountRecovery->accountRecoveryRequestDateTime = date('Y-m-d H:i:s');
					$accountRecovery->accountRecoveryUserID = User::getUserID($userEmail);
					$accountRecoveryID = AccountRecovery::insert($accountRecovery);

					// send email
					$newAccountRecovery = new AccountRecovery($accountRecoveryID);
					$accountRecoveryMash = $newAccountRecovery->accountRecoveryMash;
					$userName = User::getUsername($accountRecovery->accountRecoveryUserID);
					$mailMessage = "<html><body>Hello, <b>$userName</b>!<br /><br />You can use your username to reset your password at the following URL:<br /><br />http://jaga.io/reset-password/" . $accountRecoveryMash . "/<br /><br /><i>Only your most recent Account Recovery link is valid.<br />This Account Recovery link is only valid for 24 hours.</i></body></html>";
					Mail::sendEmail($userEmail, "jaga.io <noreply@jaga.io>", "Account Recovery", $mailMessage, $_SESSION['channelID'], $_SESSION['userID'], "html");
					
					// forward
					$postSubmitURL = "/account-recovery-mail-sent/";
					header("Location: $postSubmitURL");
					
				}
			}
		
		}
		
		if ($urlArray[0] == 'reset-password') {
		
			if (!ctype_xdigit($urlArray[1])) { header("Location: /account-recovery/"); }

			if (isset($_POST['jagaResetPasswordSubmit'])) {
			
				$inputArray = $_POST;
				$accountRecoveryMash = $urlArray[1];
				if ($accountRecoveryMash != $inputArray['accountRecoveryMash']) { die(" POST/GET accountRecoveryMash equivalence fail"); }
				$username = $inputArray['username'];
				$password = $inputArray['password'];
				$confirmPassword = $inputArray['confirmPassword'];
				$raptcha = $inputArray['raptcha'];
				
				$errorArray = AccountRecovery::resetPasswordRequestValidation($accountRecoveryMash, $username, $password, $confirmPassword, $raptcha);
				
				if (empty($errorArray)) {
				
					// accountRecoveryVisited
					$accountRecoveryID = AccountRecovery::getAccountRecoveryID($accountRecoveryMash);
					$accountRecovery = new AccountRecovery($accountRecoveryID);
					$accountRecovery->accountRecoveryVisited = 1;
					$conditions = array('accountRecoveryID' => $accountRecoveryID);
					AccountRecovery::update($accountRecovery, $conditions);

					// change user password
					$userID = User::getUserID($username);
					$user = new User($userID);
					$user->userPassword = md5($password);
					$conditions = array('userID' => $userID);
					User::update($user, $conditions);
					
					// forward
					$postSubmitURL = "/password-reset-successful/";
					header("Location: $postSubmitURL");
					
				}
			}

		}
		
		if ($urlArray[0] == 'imo' && $urlArray[1] == 'send' && is_numeric($urlArray[2])) {
			
			$messageRecipientUserID = $urlArray[2];
			if (!empty($_POST)) { $inputArray = $_POST; } else { header("Location: /imo/"); }
			if ($_SESSION['userID'] == 0) { die('You must be logged in to send messages.'); }
			if ($_SESSION['userID'] == $messageRecipientUserID) { die('You cannot send yourself messages.'); }
			if (!User::userIDexists($messageRecipientUserID)) { die('The user you are trying to send a message to does not exist.'); }
			if ($inputArray['messageContent'] == '') { die('Your message is empty.'); }
			// is this a duplicate message?
			$message = new Message(0);
			unset($message->messageID);
			foreach ($inputArray AS $property => $value) { if (isset($message->$property)) { $message->$property = $value; } }
			$message->messageSenderUserID = $_SESSION['userID'];
			$message->messageRecipientUserID = $messageRecipientUserID;
			$message->messageDateTimeSent = date("Y-m-d H:i:s");
			$message->messageSenderIP = $_SERVER['REMOTE_ADDR'];
			$messageID = Message::insert($message);
			header("Location: /imo/");
			
		}
		
		if ($urlArray[0] == 'imo' && $urlArray[1] == 'delete' && is_numeric($urlArray[2])) {
			
			$messageID = $urlArray[2];
			if ($_SESSION['userID'] == 0) { die('You must be logged in to delete a message.'); }
			$message = new Message($messageID);
			if ($message->messageSenderUserID != $_SESSION['userID']) { die('You can only delete messages that you have sent.'); }
			$conditions = array('messageID' => $messageID);
			Message::delete($message, $conditions);
			header("Location: /imo/");
			
		}
		
		if ($urlArray[0] == 'spudnik') {
			
		}

		if ($urlArray[0] == 'first-snow-contest' && $_SESSION['channelID'] == 14) {
			
			if (isset($_POST['jagaPredictionSubmit'])) {
				
				$inputArray = $_POST;
				$date = $inputArray['date'];
				$time = $inputArray['time'];
				$dateTimePredicted = date('Y-m-d H:i:s', strtotime($date . " " . $time . ":00"));

				if (!Authentication::isLoggedIn()) { $errorArray['auth'][] = 'You must be logged in to enter the Niseko First Snow Contest.'; }
				
				if ($date == '') { $errorArray['date'][] = 'Date is a required field.'; }
				$dt = DateTime::createFromFormat("Y-m-d", $date);
				if ($dt === false || array_sum($dt->getLastErrors())) { $errorArray['date'][] = 'Date does not appear to be formatted correctly.'; }
				if (date("Y") != date("Y", strtotime($date))) { $errorArray['date'][] = 'Please select a date from the current year.'; }
				
				if ($time == '') { $errorArray['time'][] = 'Time is a required field.'; }
				$td = DateTime::createFromFormat("Y-m-d H:i:s", "20-12-18 " . $time . ":00");
				if ($td === false || array_sum($td->getLastErrors())) { $errorArray['time'][] = 'Time does not appear to be formatted correctly.'; }

				if (empty($errorArray)) {
					
					// delete current user's prediction(s) for current year
					$userPredictions = Prediction::getUserPredictionArray($_SESSION['userID'],date('Y'));
					foreach ($userPredictions as $predictionID) {
						$prediction = new Prediction($predictionID);
						if ($prediction->userID != $_SESSION['userID']) { die('[prediction] There was an unexpected error. Please try again.'); }
						$conditions = array('predictionID' => $predictionID);
						Prediction::delete($prediction, $conditions);
					}

					// add current user's new prediction
					$prediction = new Prediction(0); // instantiate object
					unset($prediction->predictionID); // unset key
					$prediction->dateTimePredicted = $dateTimePredicted;
					$predictionID = Prediction::insert($prediction);
					
					header("Location: /first-snow-contest/");
					
				}
				
			}
			
		}
		
		if (!in_array($urlArray[0],$notHTML)) {
			$page = new PageView($urlArray);
			$html = $page->buildPage($urlArray, $inputArray, $errorArray);
			return $html;
		}
		
		if ($urlArray[0] == 'lang') {

			if ($_SESSION['userID'] != 0) {
				$userID = $_SESSION['userID'];
				$user = new User($userID);
				if ($urlArray[1] == 'ja') { $user->userSelectedLanguage = 'ja'; } else { $user->userSelectedLanguage = 'en'; }
				$conditions = array(); $conditions['userID'] = $userID;
				User::update($user, $conditions);	
			}

			if ($urlArray[1] == 'ja') { $_SESSION['lang'] = 'ja'; } else { $_SESSION['lang'] = 'en'; }
			
			header("Location: /");

		}
		
		if ($urlArray[0] == 'rss') {

			$rss = new Rss();
			$feed = $rss->getFeed($urlArray);
			
			header("Content-Type: application/xml; charset=utf-8");
			return $feed;
			
		}
		
		if ($urlArray[0] == 'sitemap.xml') {
		
			$sitemap = new Sitemap($urlArray);
			$xml = $sitemap->getSitemap();
			return $xml;
			
		}
		
		if ($urlArray[0] == 'channel.css') {
		
			$theme = new ThemeView();
			$css = $theme->getTheme();
			
			header("Content-type: text/css");
			return $css;

		}
		
	}
	
}

?>