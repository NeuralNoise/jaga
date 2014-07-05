<?php

require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/controller/Config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/controller/Controller.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/controller/Core.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/controller/ORM.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/controller/Session.php');

require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/model.php');

require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/view/view.php');

Config::write('db.host', 'localhost');
Config::write('db.basename', 'kutchannelDB');
Config::write('db.user', 'kutchannel');
Config::write('db.password', 'KiyEthPK6M');

?>