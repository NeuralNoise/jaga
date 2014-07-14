<?php

class SEO {

	public static function googlify($string) {
		$url = ereg_replace("[-]+", "-", ereg_replace("[^a-z0-9-]", "", strtolower( str_replace(" ", "-", $string) ) ) );
		return $url;
	}

}

?>