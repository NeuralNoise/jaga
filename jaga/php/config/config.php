<?php

require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/controller/controller.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/model/model.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/view/view.php');

Config::write('db.host', 'localhost');
Config::write('db.basename', 'kutchannelDB');
Config::write('db.user', 'kutchannel');
Config::write('db.password', 'KiyEthPK6M');

?>