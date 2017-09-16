-- --------------------------------------------------------
-- Host:                         zenilistdb.co2dst0led4r.us-west-2.rds.amazonaws.com
-- Server version:               5.6.34-log - MySQL Community Server (GPL)
-- Server OS:                    Linux
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for jagaDB
CREATE DATABASE IF NOT EXISTS `jagaDB` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `jagaDB`;

-- Dumping structure for table jagaDB.jaga_AccountRecovery
CREATE TABLE IF NOT EXISTS `jaga_AccountRecovery` (
  `accountRecoveryID` int(8) NOT NULL AUTO_INCREMENT,
  `accountRecoveryEmail` varchar(255) NOT NULL,
  `accountRecoveryUserID` int(8) NOT NULL,
  `accountRecoveryRequestDateTime` datetime NOT NULL,
  `accountRecoveryRequestedFromIP` varchar(50) NOT NULL,
  `accountRecoveryMash` varchar(40) NOT NULL,
  `accountRecoveryVisited` int(1) NOT NULL,
  PRIMARY KEY (`accountRecoveryID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_Audit
CREATE TABLE IF NOT EXISTS `jaga_Audit` (
  `auditID` int(12) NOT NULL AUTO_INCREMENT,
  `channelID` int(8) NOT NULL,
  `auditDateTime` datetime NOT NULL,
  `auditUserID` int(8) NOT NULL,
  `auditIP` varchar(45) NOT NULL,
  `auditAction` varchar(255) NOT NULL,
  `auditObject` varchar(20) NOT NULL,
  `auditObjectID` int(12) NOT NULL,
  `auditOldValue` varchar(255) NOT NULL,
  `auditNewValue` varchar(255) NOT NULL,
  `auditResult` varchar(255) NOT NULL,
  `auditNote` text NOT NULL,
  PRIMARY KEY (`auditID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_BlacklistDomain
CREATE TABLE IF NOT EXISTS `jaga_BlacklistDomain` (
  `domain` varchar(100) CHARACTER SET utf8 NOT NULL,
  `channelID` int(8) DEFAULT NULL,
  `blockedByUserID` int(8) NOT NULL,
  `dateTimeBlocked` datetime NOT NULL,
  `dateTimeOfBlockExpiration` datetime NOT NULL,
  `attemptsSinceBlocked` int(12) NOT NULL,
  PRIMARY KEY (`domain`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_BlacklistIP
CREATE TABLE IF NOT EXISTS `jaga_BlacklistIP` (
  `ip` varchar(50) CHARACTER SET utf8 NOT NULL,
  `channelID` int(8) DEFAULT NULL,
  `blockedByUserID` int(8) NOT NULL,
  `dateTimeBlocked` datetime NOT NULL,
  `dateTimeOfBlockExpiration` datetime NOT NULL,
  `attemptsSinceBlocked` int(12) NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_Carousel
CREATE TABLE IF NOT EXISTS `jaga_Carousel` (
  `carouselID` int(12) NOT NULL AUTO_INCREMENT,
  `channelID` int(12) NOT NULL,
  `creator` int(12) NOT NULL,
  `created` datetime NOT NULL,
  `carouselPath` varchar(255) NOT NULL,
  `carouselTitleEnglish` varchar(255) NOT NULL,
  `carouselSubtitleEnglish` varchar(255) NOT NULL,
  `carouselTitleJapanese` varchar(255) NOT NULL,
  `carouselSubtitleJapanese` varchar(255) NOT NULL,
  `carouselPublished` int(1) NOT NULL,
  `carouselDisplayWhileLoggedIn` int(1) NOT NULL,
  `carouselDisplayWhileLoggedOut` int(1) NOT NULL,
  `fullWidth` int(1) DEFAULT NULL,
  `fixedHeight` int(3) DEFAULT NULL,
  PRIMARY KEY (`carouselID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_CarouselPanel
CREATE TABLE IF NOT EXISTS `jaga_CarouselPanel` (
  `carouselPanelID` int(12) NOT NULL AUTO_INCREMENT,
  `channelID` int(12) NOT NULL,
  `carouselID` int(12) NOT NULL,
  `creator` int(12) NOT NULL,
  `created` datetime NOT NULL,
  `imageID` int(12) NOT NULL,
  `carouselPanelAltEnglish` varchar(255) NOT NULL,
  `carouselPanelTitleEnglish` varchar(255) NOT NULL,
  `carouselPanelSubtitleEnglish` varchar(255) NOT NULL,
  `carouselPanelUrlEnglish` varchar(255) NOT NULL,
  `carouselPanelAltJapanese` varchar(255) NOT NULL,
  `carouselPanelTitleJapanese` varchar(255) NOT NULL,
  `carouselPanelSubtitleJapanese` varchar(255) NOT NULL,
  `carouselPanelUrlJapanese` varchar(255) NOT NULL,
  `carouselPanelDisplayOrder` int(4) NOT NULL,
  `carouselPanelPublished` int(1) NOT NULL,
  `carouselPanelDisplayWhileLoggedIn` int(1) NOT NULL,
  `carouselPanelDisplayWhileLoggedOut` int(1) NOT NULL,
  PRIMARY KEY (`carouselPanelID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_Category
CREATE TABLE IF NOT EXISTS `jaga_Category` (
  `contentCategoryKey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contentCategoryEnglish` varchar(255) CHARACTER SET utf8 NOT NULL,
  `contentCategoryJapanese` varchar(255) CHARACTER SET utf8 NOT NULL,
  `contentCategoryJapaneseReading` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`contentCategoryKey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_Channel
CREATE TABLE IF NOT EXISTS `jaga_Channel` (
  `channelID` int(8) NOT NULL AUTO_INCREMENT,
  `channelKey` varchar(50) CHARACTER SET utf8 NOT NULL,
  `channelDomain` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `channelCreationDateTime` datetime NOT NULL,
  `channelEnabled` int(1) NOT NULL,
  `channelTitleEnglish` varchar(255) CHARACTER SET utf8 NOT NULL,
  `channelTitleJapanese` varchar(255) CHARACTER SET utf8 NOT NULL,
  `channelTagLineEnglish` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `channelTagLineJapanese` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `channelKeywordsEnglish` varchar(255) CHARACTER SET utf8 NOT NULL,
  `channelKeywordsJapanese` varchar(255) CHARACTER SET utf8 NOT NULL,
  `channelDescriptionEnglish` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `channelDescriptionJapanese` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `themeKey` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `siteTwitter` varchar(20) CHARACTER SET utf8 NOT NULL,
  `pagesServed` int(12) NOT NULL,
  `siteManagerUserID` int(8) NOT NULL,
  `isPublic` int(1) NOT NULL,
  `isCloaked` int(1) NOT NULL,
  `isNSFW` int(1) NOT NULL,
  PRIMARY KEY (`channelID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_ChannelCategory
CREATE TABLE IF NOT EXISTS `jaga_ChannelCategory` (
  `channelID` int(8) NOT NULL,
  `contentCategoryKey` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `channelCategoryDesciptionEnglish` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `channelCategoryDesciptionJapanese` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`channelID`,`contentCategoryKey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_ChannelCohorts
CREATE TABLE IF NOT EXISTS `jaga_ChannelCohorts` (
  `cohortID` int(8) NOT NULL AUTO_INCREMENT,
  `channelID` int(12) NOT NULL,
  `channelCohortAnchorEnglish` varchar(50) CHARACTER SET utf8 NOT NULL,
  `channelCohortAnchorJapanese` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`cohortID`,`channelID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_Comment
CREATE TABLE IF NOT EXISTS `jaga_Comment` (
  `commentID` int(12) NOT NULL AUTO_INCREMENT,
  `channelID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `commentDateTime` datetime NOT NULL,
  `commentObject` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `commentObjectID` int(11) NOT NULL,
  `commentContent` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`commentID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_Content
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_Family
CREATE TABLE IF NOT EXISTS `jaga_Family` (
  `famKey` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `famEnglish` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `famJapanese` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`famKey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_FamilyChannel
CREATE TABLE IF NOT EXISTS `jaga_FamilyChannel` (
  `famKey` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `channelID` int(12) NOT NULL,
  `order` int(4) NOT NULL,
  PRIMARY KEY (`famKey`,`channelID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_Image
CREATE TABLE IF NOT EXISTS `jaga_Image` (
  `imageID` int(12) NOT NULL AUTO_INCREMENT,
  `imageDisplayOrder` int(4) NOT NULL,
  `channelID` int(8) NOT NULL,
  `imageSubmittedByUserID` int(8) NOT NULL,
  `imageSubmissionDateTime` datetime NOT NULL,
  `imagePath` varchar(255) NOT NULL,
  `s3url` varchar(100) NOT NULL,
  `imageObject` varchar(20) NOT NULL,
  `imageObjectID` int(8) NOT NULL,
  `imageDisplayClassification` varchar(20) NOT NULL,
  `imageOriginalName` varchar(50) NOT NULL,
  `imageType` varchar(30) NOT NULL,
  `imageSize` int(11) NOT NULL,
  `imageDimensionX` int(5) NOT NULL,
  `imageDimensionY` int(5) NOT NULL,
  `imageDisplayInGallery` int(1) NOT NULL,
  `imageLegacy` int(1) NOT NULL,
  PRIMARY KEY (`imageID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_Language
CREATE TABLE IF NOT EXISTS `jaga_Language` (
  `langKey` varchar(255) CHARACTER SET utf8 NOT NULL,
  `enLang` varchar(255) CHARACTER SET utf8 NOT NULL,
  `enCount` int(12) NOT NULL,
  `jaLang` varchar(255) CHARACTER SET utf8 NOT NULL,
  `jaCount` int(12) NOT NULL,
  `langTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`langKey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_Mail
CREATE TABLE IF NOT EXISTS `jaga_Mail` (
  `mailID` int(8) NOT NULL AUTO_INCREMENT,
  `channelID` int(8) NOT NULL,
  `mailSentByUserID` int(8) NOT NULL,
  `mailSentDateTime` datetime NOT NULL,
  `mailToAddress` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mailFromAddress` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mailSubject` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mailMessage` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`mailID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_Message
CREATE TABLE IF NOT EXISTS `jaga_Message` (
  `messageID` int(12) NOT NULL AUTO_INCREMENT,
  `messageSenderUserID` int(8) NOT NULL,
  `messageRecipientUserID` int(8) NOT NULL,
  `messageContent` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `messageDateTimeSent` datetime NOT NULL,
  `messageSenderIP` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `messageReadByRecipient` int(1) NOT NULL,
  PRIMARY KEY (`messageID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_Prediction
CREATE TABLE IF NOT EXISTS `jaga_Prediction` (
  `predictionID` int(8) NOT NULL AUTO_INCREMENT,
  `userID` int(8) NOT NULL,
  `channelID` int(8) NOT NULL,
  `predictionObject` varchar(20) NOT NULL,
  `predictionObjectID` int(8) NOT NULL,
  `dateTimeSubmitted` datetime NOT NULL,
  `dateTimePredicted` datetime NOT NULL,
  `comment` text NOT NULL,
  `year` int(4) NOT NULL,
  `result` varchar(10) NOT NULL,
  PRIMARY KEY (`predictionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_Session
CREATE TABLE IF NOT EXISTS `jaga_Session` (
  `sessionID` varchar(32) CHARACTER SET utf8 NOT NULL,
  `userID` int(12) NOT NULL,
  `sessionDateTimeSet` datetime NOT NULL,
  `sessionDateTimeExpire` datetime NOT NULL,
  `sessionIP` varchar(50) CHARACTER SET utf8 NOT NULL,
  `sessionUserAgent` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`sessionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_Subscription
CREATE TABLE IF NOT EXISTS `jaga_Subscription` (
  `userID` int(8) NOT NULL,
  `channelID` int(8) NOT NULL,
  `subscriptionDate` date NOT NULL,
  PRIMARY KEY (`userID`,`channelID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_theme
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

-- Data exporting was unselected.
-- Dumping structure for table jagaDB.jaga_User
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
  `userTimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `userChannelAllocation` int(3) NOT NULL DEFAULT '7',
  `userShadowBan` int(1) NOT NULL,
  `userAccessKey` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `userEmail` (`userEmail`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
