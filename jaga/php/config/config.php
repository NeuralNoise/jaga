<?php

	// CONTROLLER
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/controller/Config.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/controller/Controller.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/controller/Core.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/controller/ORM.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/controller/Session.php');

	
	// MODEL
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/model.php');

	// VIEW
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/view/view.php');


	
	// DB: apply gitignore to taterbase.php
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/config/taterbase.php');

	/* taterbase.php requires following 4 lines: */

	// Config::write('db.host', 'localhost');
	// Config::write('db.basename', 'dbname');
	// Config::write('db.user', 'dbuser');
	// Config::write('db.password', 'XXXXXXXX');

?>