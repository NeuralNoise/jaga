<?php

require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/view.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/controller.php');

Config::write('db.host', 'localhost');
Config::write('db.basename', 'kutchannelDB');
Config::write('db.user', 'kutchannel');
Config::write('db.password', 'KBEesuVryH');

?>