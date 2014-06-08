<?php

	ini_set('display_errors', '1');

	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/config.php');

	$url = rtrim($_SERVER['REQUEST_URI'], '/') . '/';
	$urlArray = explode('/', substr($url, 1, -1));

	$controller = new Controller();
	$resource = $controller->getResource($urlArray);

	print($resource);

?>