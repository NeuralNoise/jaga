<?php

class Utilites {

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

}

?>