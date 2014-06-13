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
			
			$errorArray = array();
			
			if (isset($_POST['jagaLoginSubmit'])) {
			
				$username = $_POST['username'];
				$password = $_POST['password'];
			
				$errorArray = Authentication::checkAuth($username, $password);
				
				if (empty($errorArray)) {
				
					// log user in
					$userID = User::getUserIDwithUserNameOrEmail($username);
					Session::setSession('userID', $userID);
					
					// set cookie (just use existing one)
					// echo '$_COOKIE[\'TheKutchannel\']: ' . $_COOKIE['TheKutchannel'];
					// $cookie = new Cookie();
					
					// save session to db
					$authSession = new Session();
					$authSession->createAuthSession();
					
					// terminate script; forward header
					header("Location: /");
					
				}
				
			}
			
			$page = new PageView();
			$html = $page->buildPage($urlArray, $errorArray);
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

    // globals here
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