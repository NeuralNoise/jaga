<?php


function makeUrlFriendly($proposedUrl) {

	$searchArray = array();
	$searchArray[0] = '/ /';
	$searchArray[1] = '/"/';
	$searchArray[2] = '/\&/';
		
	$replaceArray = array();
	$replaceArray[0] = '-';
	$replaceArray[1] = '';
	$replaceArray[2] = '&#38;';
		
	$safeUrl = preg_replace($searchArray, $replaceArray, preg_replace('/[\[\\\^\$\.\|\?\*\+\(\)\{\}\]]/', '', $proposedUrl));
	
	return $safeUrl;
	
	
}



?>