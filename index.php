<?php

	ini_set('display_errors', '1');
	date_default_timezone_set('UTC');
	
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/config/config.php');

	$url = rtrim($_SERVER['REQUEST_URI'], '/') . '/';
	$urlArray = explode('/', substr($url, 1, -1));

	$controller = new Controller();
	$resource = $controller->getResource($urlArray);

	print($resource);

?>