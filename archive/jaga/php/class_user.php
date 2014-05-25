<?php

/*
CREATE TABLE IF NOT EXISTS `j00mla_ver4_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(150) NOT NULL DEFAULT '',
  `usernameEnglish` varchar(50) NOT NULL,
  `userNameJapanese` varchar(50) NOT NULL,
  `userNameJapaneseReading` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `phoneNumber1` varchar(50) NOT NULL,
  `phoneNumber2` varchar(50) NOT NULL,
  `fax` varchar(50) NOT NULL,
  `address1` varchar(50) NOT NULL,
  `address2` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `statePrefecture` varchar(50) NOT NULL,
  `countryOfResidence` varchar(50) NOT NULL,
  `countryOfCitizenship` varchar(50) NOT NULL,
  `postalCode` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL DEFAULT '',
  `usertype` varchar(25) NOT NULL DEFAULT '',
  `block` tinyint(4) NOT NULL DEFAULT '0',
  `sendEmail` tinyint(4) DEFAULT '0',
  `gid` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `registerDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  `shigotoGroupID` int(8) NOT NULL,
  `testMode` tinyint(1) NOT NULL,
  `natto` varchar(3) NOT NULL,
  `uniqueKey` varchar(10) NOT NULL,
  `verified` varchar(3) NOT NULL,
  `userRegistrationSiteID` int(8) NOT NULL,
  `userLoggedIn` int(1) NOT NULL,
  `userToken` varchar(50) NOT NULL,
  `userTokenExpiry` datetime NOT NULL,
  `userTokenIP` varchar(50) NOT NULL,
  `userTokenUserAgent` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`),
  KEY `gid_block` (`gid`,`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10966 ;
*/

class user {

	public $userID
	public $username;

	public function __construct($userID = 0) {
	
		if ($userID == 0) {
			$this->username = 'anonymous';
		}
	
	}
}


$dildo = $new->user;
echo $dildo.username;


?>