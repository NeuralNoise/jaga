<?php

class Language {

	public $lang;

	public function setLanguage($langKey) {
		if($langKey == 'ja') { $this->lang = 'ja'; } else { $this->lang = 'en'; }
	}
	
	public function getLanguage($langKey) {
		return $this->lang;
	}
	
	public function getBrowserDefaultLanguage() {
		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		if ($lang != 'ja') { $lang = 'en'; }
		return $lang;
	}
	
}

?>