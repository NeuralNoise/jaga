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
	
	function isValidMd5($md5) {
		return preg_match('/^[a-f0-9]{32}$/', $md5);
	}

}

?>