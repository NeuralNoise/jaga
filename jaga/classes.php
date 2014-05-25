<?php

class Config {
    static $confArray;
    public static function read($name) { return self::$confArray[$name]; }
    public static function write($name, $value) { self::$confArray[$name] = $value; }
}

class Core {

    public $dbh;
    private static $instance;

    private function __construct() {
        $dsn = 'mysql:host=' . Config::read('db.host') . ';dbname='    . Config::read('db.basename') . ';connect_timeout=15';
        $user = Config::read('db.user');            
        $password = Config::read('db.password');
		$options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		); 
        $this->dbh = new PDO($dsn, $user, $password, $options);
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }

    // others global functions
}

class User {

	public $userID;
	public $username;
	
	public function __construct() {
	
		$this->userID = 0;
		$this->username = 'anonymous';
		
		$sql = "SELECT * FROM j00mla_ver4_users WHERE id != :id";
		$core = Core::getInstance();
		$statement = $core->dbh->prepare($sql);
		
		$statement->execute(array(':id' => 0));
		// $row = $statement->fetchAll();
		$row = $statement->fetch();
		
		print_r($row);
		
	}
	
}

?>
