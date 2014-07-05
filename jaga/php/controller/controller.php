<?php

class Config {
    static $confArray;
    public static function read($name) { return self::$confArray[$name]; }
    public static function write($name, $value) { self::$confArray[$name] = $value; }
}

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
			
			$domain = $_SERVER['HTTP_HOST'];
			$tmp = explode('.', $domain);
			$subdomain = current($tmp);
			
			return '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"><head><title>The Kutchannel: The "' . $subdomain . '" channel does not yet exist.</title><META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW"></head><body style="background-color:#FFFF99;padding-top:150px;"><div style="text-align:center;"><a href="http://the.kutchannel.net/"><img src="/jaga/images/banner.png" style="max-width:100%;border-style:none;"></a><br />This channel has not yet been created. <a href="http://the.kutchannel.net/create-a-channel/' . $subdomain . '/" style="text-decoration:none;">Create it</a>!</div></body></html>';
			die();
			
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
					header("Location: /");
					
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

		} else {
		
			$page = new PageView();
			$html = $page->buildPage($urlArray);
			return $html;
			
		}

	}
	
}

class Core {

    public $database;
    private static $instance;

    private function __construct() {
        
		$dsn = 'mysql:host=' . Config::read('db.host') . ';dbname='    . Config::read('db.basename') . ';connect_timeout=15';
        $user = Config::read('db.user');            
        $password = Config::read('db.password');
		$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
		
		try {
			$this->database = new PDO($dsn, $user, $password, $options);
		} catch (PDOException $Exception) {
			throw new DatabaseException($Exception->getMessage(),(int)$s->getCode());
		}

    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }
	
}

class ORM {

	public function insert($object) {
	
		$objectName = get_class($object);
		$objectVariableArray = get_object_vars($object);
		$objectPropertyArray = array_keys($objectVariableArray);
		$tablePrefix = self::getTablePrefix();
		$tableName = $tablePrefix . $objectName;
		if (!self::tableExists($tableName)) { die('ORM::insert($object) => A table does not exist with that object name.'); }
		
		// create insert query
		$query = "INSERT INTO $tableName (" . implode(', ', $objectPropertyArray) . ") VALUES (:" . implode(', :', $objectPropertyArray) . ")";
		
		// build prepared statement
		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		foreach ($objectVariableArray AS $property => $value) {
			$attribute = ':' . $property;
			$statement->bindValue($attribute, $value);
		}
		
		// execute
		if (!$statement->execute()){ die("ORM::insert(\$object) => There was a problem saving your new $objectName."); }
		
		// return last_insert_id
		$lastInsertID = $core->database->lastInsertId();
		return $lastInsertID;
		
	}
	
	public function update($object, $conditions) {
		
		print_r($object);
		
		$objectName = get_class($object);
		$objectVariableArray = get_object_vars($object);
		$tablePrefix = self::getTablePrefix();
		$tableName = $tablePrefix . $objectName;
		if (!self::tableExists($tableName)) { die('ORM::insert($object) => A table does not exist with that object name.'); }
		
		$scooby = array();
		foreach ($conditions AS $condition => $value) { $scooby[] = "$condition = :$condition"; }
		$scoobyString =  implode(' AND ', $scooby);
		
		$shaggy = array();
		foreach ($objectVariableArray AS $property => $value) { $shaggy[] = "$property = :$property"; }
		$shaggyString =  implode(', ', $shaggy);
		
		// create insert query
		$query = "UPDATE $tableName SET $shaggyString WHERE $scoobyString LIMIT 1";
		
		print_r($query);
		// build prepared statement
		
		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		
		foreach ($conditions AS $condition => $value) {
			$attribute = ':' . $condition;
			$statement->bindValue($attribute, $value);
		}
		
		foreach ($objectVariableArray AS $property => $value) {
			$attribute = ':' . $property;
			$statement->bindValue($attribute, $value);
		}
		
		// execute
		if (!$statement->execute()){ die("ORM::insert(\$object) => There was a problem saving your new $objectName."); }
		
	}
	
	public function delete($object) {
		
		$objectName = get_class($object);
		$objectVariableArray = get_object_vars($object);
		$tablePrefix = self::getTablePrefix();
		$tableName = $tablePrefix . $objectName;
		if (!self::tableExists($tableName)) { die('ORM::delete($object) => A table does not exist with that object name.'); }
		
		// create delete query
		$scooby = array();
		foreach ($objectVariableArray AS $key => $value) { $scooby[] = "$key = '$value'"; }
		$scoobyString = implode(' AND ', $scooby);
		$query = "DELETE FROM $tableName WHERE $scoobyString LIMIT 1";
		
		// build prepared statement
		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		
		// execute
		if (!$statement->execute()){ die("ORM::delete(\$object) => There was a problem deleting your $objectName."); }
		
	}

	private function getTablePrefix() {
		$tablePrefix = 'jaga_';
		return $tablePrefix;
	}
	
	private function tableExists($tableName) {
	
		$core = Core::getInstance();
		$queryTableCheck = "SELECT 1 FROM $tableName LIMIT 1";
		$statement = $core->database->prepare($queryTableCheck);
		$statement->execute();
		if ($row = $statement->fetch()){ return true; } else { return false; }
		
	}

}

class Session {

	public $sessionID;
	public $userID;
	public $sessionDateTimeSet;
	public $sessionDateTimeExpire;
	public $sessionIP;
	public $sessionUserAgent;

	public function __construct() {

		$this->sessionID = $_COOKIE['TheKutchannel'];
		$this->userID = $_SESSION['userID'];
		$this->sessionDateTimeSet = date('Y-m-d H:i:s');
		$this->sessionDateTimeExpire = date("Y-m-d H:i:s", strtotime("+1 month"));
		$this->sessionIP = $_SERVER['REMOTE_ADDR'];
		$this->sessionUserAgent = $_SERVER['HTTP_USER_AGENT'];

	}
	
	public function createAuthSession() {
		
		$core = Core::getInstance();
		$query = "INSERT INTO jaga_session (sessionID,userID,sessionDateTimeSet,sessionDateTimeExpire,sessionIP,sessionUserAgent
		) VALUES (:sessionID, :userID, :sessionDateTimeSet, :sessionDateTimeExpire, :sessionIP, :sessionUserAgent)";
		$statement = $core->database->prepare($query);
		
		$statement->bindParam(':sessionID', $this->sessionID);
		$statement->bindParam(':userID', $this->userID);
		$statement->bindParam(':sessionDateTimeSet', $this->sessionDateTimeSet);
		$statement->bindParam(':sessionDateTimeExpire', $this->sessionDateTimeExpire);
		$statement->bindParam(':sessionIP', $this->sessionIP);
		$statement->bindParam(':sessionUserAgent', $this->sessionUserAgent);
		
		$statement->execute();
		
	}

	/* START STATIC */
	
	static $sessionArray;
	
	public static function getSession($name) {
		if (isset(self::$sessionArray[$name])) {
			return self::$sessionArray[$name];
		} else {
			return "Session variable '$name' has not been set properly.";
		}
	}
    
	public static function setSession($name, $value) {
		
		self::$sessionArray[$name] = $value;
		
		if (!isset($_SESSION)) { session_start(); }
		$_SESSION[$name] = $value;
		
	}
	
	public static function unsetSession($name) {
	
		unset(self::$sessionArray[$name]);
		unset($_SESSION[$name]);
		
	}

	public static function sessionDump () {
		return self::$sessionArray;
	}
	
	public static function getAuthSessionUserID($sessionID) {
	
		$core = Core::getInstance();
		$currentDateTime = date('Y-m-d H:i:s');
		$query = "SELECT userID FROM jaga_session WHERE sessionID = :sessionID AND sessionDateTimeExpire > :currentDateTime LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':sessionID' => $sessionID, ':currentDateTime' => $currentDateTime));
		$userID = 0;
		if ($row = $statement->fetch()) { $userID = $row['userID']; }
		return $userID;
		
	}
	
	/* END STATIC */
	
}

?>