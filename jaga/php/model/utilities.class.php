<?php

class Utilities {

	public function generateNatto () {
		$natto = '';
		for ($i = 0; $i < 3; $i++) { $natto .= chr(rand(35, 126)); }
		return $natto;
	}

	public function generateUniqueKey () {
		$uniqueKey = '';
		for ($i = 0; $i < 10; $i++) { $uniqueKey .= chr(rand(97, 122)); }
		return $uniqueKey;
	}
	
	public function generateMash() {
		$natto = Self::generateNatto();
		$accountRecoveryMash = md5(time() . $natto);
		return $accountRecoveryMash;
	}
	
	public function isValidMd5($md5) {
		return preg_match('/^[a-f0-9]{32}$/', $md5);
	}

	public function truncate($string, $limit, $break = '.', $pad = '...') {
		$truncatedString = $string;
		if(strlen($string) > $limit) {
			if(false !== ($breakpoint = strpos($string, $break, $limit))) {
				if($breakpoint < strlen($string) - 1){
					$truncatedString = substr($string, 0, $breakpoint) . $pad;
				}
			}
		}
		return $truncatedString;
	}
	
	public function remove_bbcode($string) {
		$pattern = '~\[[^]]+]~';
		$replace = '';
		return preg_replace($pattern, $replace, $string);
	}
	
	public function remove_urls($string) {
		$pattern = '#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si';
		$replace = '';
		return preg_replace($pattern, $replace, $string);
	}

}

?>