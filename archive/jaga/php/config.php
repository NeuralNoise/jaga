<?php

// Start the session
session_start();

// MySQL Settings
$db_host = 'localhost';
$db_user = 'nisekocms';
$db_pass = 'RQcEolbryJ';
$db_database = 'kutchannelDB';

// Connect to the database
$agileConnect = mysql_connect ($db_host, $db_user, $db_pass, true) or die ('Could not connect to the database.');
mysql_selectdb ($db_database, $agileConnect) or die ('Could not select database.');

// Seed the random number generator
srand();

// set time zone to be used by application
date_default_timezone_set('Asia/Tokyo');

// Include functions
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/_jaga.php');

// Legacy Functions
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_accommodation.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_accounting.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_bootstrap.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_contract.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_edu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_events.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_expense.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_firstSnow.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_footer.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_header.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_invoice.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_property.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_shigoto.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_shigotoTask.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_shigotoClassifications.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_skill.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_tw1t_view.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_twitter.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_auditTrail.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_contact.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_content.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_dateInput.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_images.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_isAuthed.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_languageDependent.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_login.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_logout.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_mail.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_makeUrlFriendly.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_message.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_navigation.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_nisekocms.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_pagesServed.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_register.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_resource.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_security.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_setLanguage.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_site.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_timeInput.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_user.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_validation.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_shop.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/functions_calendar.php');


if (!isset($_SESSION['siteID']) || $_SESSION['siteID'] == 0) { $_SESSION['siteID'] = getSiteID(); }
if (!isset($_SESSION['lang'])) { $_SESSION['lang'] = 'en'; }
if (!isset($_SESSION['userID'])) { $_SESSION['userID'] = 0; }



// for now we'll assume no sites require age verification
// $_SESSION['ageVerified'] = 1;

// Load user's CLIENTS, PROJECTS, DOMAINS, USERS into session arrays
// loadUserSessionArrays();

// Load site's enabled modules
// loadSiteSessionArrays();


// if (is_authed()) {
	// $_SESSION['userToken'] = getExistingUserToken($_SESSION['userID']);
	// if (!userIsLoggedIn($_SESSION['userID'])) {
		// if ($_SESSION['lang'] == 'ja') { $forwardUrl = '/ja/'; } else { $forwardUrl = '/'; }
		// user_logout();
		// header("Location: $forwardUrl");
	// }
// }


?>