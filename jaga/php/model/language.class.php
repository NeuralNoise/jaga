<?php

class Lang extends ORM {

	public $langKey;
	public $enLang;
	public $enCount;
	public $jaLang;
	public $jaCount;
	public $langTimeStamp;

	public function __construct($langKey) {
		
		if ($langKey != '') {
		
			$core = Core::getInstance();
			$query = "SELECT * FROM jaga_Language WHERE langKey = :langKey LIMIT 1";
			$statement = $core->database->prepare($query);
			$statement->execute(array(':langKey' => $langKey));
			if (!$row = $statement->fetch()) { die("a language key is required: __construct('$langKey')"); }
			foreach ($row AS $key => $value) { if (!is_int($key)) { $this->$key = $value; } }
			
		} else {

			$this->langKey = 0;
			$this->enLang = '';
			$this->enCount = 0;
			$this->jaLang = '';
			$this->jaCount = 0;
			$this->langTimeStamp = date('Y-m-d H:i:s');
			
		}
		
	}

	public static function getLang($langKey) {

		if ($_SESSION['lang'] == 'ja') { $lang = "ja"; } else { $lang = "en"; }
		$langAttribute = $lang . "Lang";
		$core = Core::getInstance();
		$query = "SELECT $langAttribute AS resource FROM jaga_Language WHERE langKey = :langKey LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':langKey' => $langKey));
		if ($row = $statement->fetch()) { return $row['resource']; } else { return $langKey; }
		self::langCounterPlusOne($lang, $langKey);
		
	}
	
	public static function langCounterPlusOne($lang, $langKey) {
		
		if ($_SESSION['lang'] != 'ja') { $lang = "en"; }
		$plusOneAttribute = $lang . "Count";
		$core = Core::getInstance();
		$query = "UPDATE jaga_Language SET $plusOneAttribute = $plusOneAttribute + 1 WHERE langKey = :langKey LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':langKey' => $langKey));

	}
	
	public static function getBrowserDefaultLanguage() {
		if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			$lang = 'en';
		} else {
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		}
		if ($lang != 'ja') { $lang = 'en'; }
		return $lang;
	}
	
}

?>