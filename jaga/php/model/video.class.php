<?php

class Video {

		
	public static function isYouTubeVideo ($url) {
		$videoID = 0;
		if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
			$videoID = $match[1];
		}
		return $videoID;
	}
	
}

?>