<?php

	// CONTROLLER
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/controller/Config.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/controller/Controller.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/controller/Core.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/controller/ORM.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/controller/Session.php');

	// MODEL
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/Audit.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/Authentication.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/Calendar.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/Category.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/Channel.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/ChannelCategory.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/Comment.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/Content.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/Cookie.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/File.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/Form.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/Image.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/Language.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/Mail.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/Message.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/RSS.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/SEO.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/Shop.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/Sitemap.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/Subscription.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/Theme.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/User.php');
	
	// VIEW
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/view/AuthenticationView.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/view/CarouselView.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/view/CategoryView.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/view/ChannelView.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/view/CommentView.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/view/ContentView.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/view/MenuView.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/view/PageView.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/view/ProfileView.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/view/SubscriptionView.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/view/ThemeView.php');
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/view/UserView.php');

	// DB: apply gitignore to taterbase.php
	require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/config/taterbase.php');

	/* taterbase.php requires following 4 lines: */

	// Config::write('db.host', 'localhost');
	// Config::write('db.basename', 'dbname');
	// Config::write('db.user', 'dbuser');
	// Config::write('db.password', 'XXXXXXXX');

?>