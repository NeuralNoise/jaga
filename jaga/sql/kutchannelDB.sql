CREATE TABLE IF NOT EXISTS `jaga_Category` (
  `contentCategoryKey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contentCategoryEnglish` varchar(255) CHARACTER SET utf8 NOT NULL,
  `contentCategoryJapanese` varchar(255) CHARACTER SET utf8 NOT NULL,
  `contentCategoryJapaneseReading` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`contentCategoryKey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `jaga_Channel` (
  `channelID` int(8) NOT NULL AUTO_INCREMENT,
  `channelKey` varchar(50) CHARACTER SET utf8 NOT NULL,
  `channelCreationDateTime` datetime NOT NULL,
  `channelEnabled` int(1) NOT NULL,
  `channelTitleEnglish` varchar(255) CHARACTER SET utf8 NOT NULL,
  `channelTitleJapanese` varchar(255) CHARACTER SET utf8 NOT NULL,
  `channelKeywordsEnglish` varchar(255) CHARACTER SET utf8 NOT NULL,
  `channelKeywordsJapanese` varchar(255) CHARACTER SET utf8 NOT NULL,
  `channelDescriptionEnglish` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `channelDescriptionJapanese` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `themeKey` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `siteTwitter` varchar(20) CHARACTER SET utf8 NOT NULL,
  `pagesServed` int(12) NOT NULL,
  `siteManagerUserID` int(8) NOT NULL,
  PRIMARY KEY (`channelID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=100008;

CREATE TABLE IF NOT EXISTS `jaga_ChannelCategory` (
  `channelID` int(8) NOT NULL,
  `contentCategoryKey` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`channelID`,`contentCategoryKey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `jaga_Comment` (
  `contentID` int(8) NOT NULL,
  `channelID` int(8) NOT NULL,
  `userID` int(8) NOT NULL,
  `commentDateTime` datetime NOT NULL,
  `commentContent` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`contentID`,`userID`,`commentDateTime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `jaga_Content` (
  `contentID` int(8) NOT NULL AUTO_INCREMENT,
  `channelID` int(8) NOT NULL,
  `contentURL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contentCategoryKey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contentSubmittedByUserID` int(8) NOT NULL,
  `contentSubmissionDateTime` datetime NOT NULL,
  `contentPublishStartDate` date NOT NULL,
  `contentPublishEndDate` date NOT NULL,
  `contentLastModified` datetime NOT NULL,
  `contentTitleEnglish` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contentTitleJapanese` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contentEnglish` text COLLATE utf8_unicode_ci NOT NULL,
  `contentJapanese` text COLLATE utf8_unicode_ci NOT NULL,
  `contentLinkURL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contentPublished` int(1) NOT NULL,
  `contentViews` int(12) NOT NULL,
  `contentIsEvent` int(1) NOT NULL,
  `contentEventDate` date NOT NULL,
  `contentEventStartTime` time NOT NULL,
  `contentEventEndTime` time NOT NULL,
  `contentHasLocation` int(1) NOT NULL,
  `contentLatitude` decimal(9,6) NOT NULL,
  `contentLongitude` decimal(9,6) NOT NULL,
  PRIMARY KEY (`contentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9999913;

CREATE TABLE IF NOT EXISTS `jaga_Image` (
  `imageID` int(12) NOT NULL AUTO_INCREMENT,
  `imageDisplayOrder` int(4) NOT NULL,
  `channelID` int(8) NOT NULL,
  `imageSubmittedByUserID` int(8) NOT NULL,
  `imageSubmissionDateTime` datetime NOT NULL,
  `imagePath` varchar(255) NOT NULL,
  `imageObject` varchar(20) NOT NULL,
  `imageObjectID` int(8) NOT NULL,
  `imageDisplayClassification` varchar(20) NOT NULL,
  `imageOriginalName` varchar(50) NOT NULL,
  `imageType` varchar(30) NOT NULL,
  `imageSize` int(11) NOT NULL,
  `imageDimensionX` int(5) NOT NULL,
  `imageDimensionY` int(5) NOT NULL,
  `imageDisplayInGallery` int(1) NOT NULL,
  PRIMARY KEY (`imageID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100001;

CREATE TABLE IF NOT EXISTS `jaga_language` (
  `resourceID` varchar(255) CHARACTER SET utf8 NOT NULL,
  `resourceEnglish` varchar(255) CHARACTER SET utf8 NOT NULL,
  `resourceEnglishCount` int(12) NOT NULL,
  `resourceJapanese` varchar(255) CHARACTER SET utf8 NOT NULL,
  `resourceJapaneseCount` int(12) NOT NULL,
  `languageResourceTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`resourceID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `jaga_mail` (
  `mailID` int(8) NOT NULL AUTO_INCREMENT,
  `siteID` int(8) NOT NULL,
  `mailSentByUserID` int(8) NOT NULL,
  `mailSentDateTime` datetime NOT NULL,
  `mailToAddress` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mailFromAddress` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mailSubject` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mailMessage` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`mailID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1000001;

CREATE TABLE IF NOT EXISTS `jaga_session` (
  `sessionID` varchar(32) CHARACTER SET utf8 NOT NULL,
  `userID` int(8) NOT NULL,
  `sessionDateTimeSet` datetime NOT NULL,
  `sessionDateTimeExpire` datetime NOT NULL,
  `sessionIP` varchar(50) CHARACTER SET utf8 NOT NULL,
  `sessionUserAgent` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`sessionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `jaga_Subscription` (
  `userID` int(8) NOT NULL,
  `channelID` int(8) NOT NULL,
  PRIMARY KEY (`userID`,`channelID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `jaga_theme` (
  `themeKey` varchar(50) CHARACTER SET utf8 NOT NULL,
  `themeEnabled` int(1) NOT NULL,
  `themeCreatedByUserID` int(8) NOT NULL,
  `themeCreationDateTime` datetime NOT NULL,
  `navbarBackgroundColor` varchar(6) CHARACTER SET utf8 NOT NULL,
  `navbarBackgroundColorActive` varchar(6) CHARACTER SET utf8 NOT NULL,
  `navbarBorderColor` varchar(6) CHARACTER SET utf8 NOT NULL,
  `navbarTextColor` varchar(6) CHARACTER SET utf8 NOT NULL,
  `navbarTextColorHover` varchar(6) CHARACTER SET utf8 NOT NULL,
  `navbarTextColorActive` varchar(6) CHARACTER SET utf8 NOT NULL,
  `headingText` varchar(6) CHARACTER SET utf8 NOT NULL,
  `contentPanelHeadingTextColor` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `contentPanelHeadingBackgroundColor` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`themeKey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `jaga_User` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `userDisplayName` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `userEmail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `userEmailVerified` int(1) NOT NULL DEFAULT '0',
  `userAcceptsEmail` int(1) DEFAULT '0',
  `userPassword` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `userRegistrationChannelID` int(8) NOT NULL DEFAULT '0',
  `userRegistrationDateTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `userLastVisitDateTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `userTestMode` int(1) NOT NULL DEFAULT '0',
  `userBlackList` int(1) NOT NULL DEFAULT '0',
  `userSelectedLanguage` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `userEmail` (`userEmail`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=999904;