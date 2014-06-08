<?php

	function setLanguage($lang) {
		if($lang == 'ja') {
			$_SESSION['lang'] = 'ja';
		} else {
			$_SESSION['lang'] = 'en';
		}
	}

?>