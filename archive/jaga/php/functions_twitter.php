<?php

function getTwitterUserNumberOfFollowers($twitterUserName) {

	$jsonURL = "https://api.twitter.com/1/users/lookup.json?screen_name=$twitterUserName";
	$json = file_get_contents($jsonURL,0,null,null);
	$jsonOutput = json_decode($json, true);
	
	if (is_array($jsonOutput)) {
		return $jsonOutput[0]['followers_count'];
	}
	

}

?>