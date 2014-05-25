<?php


function getAuditTrailResource($auditTrailObject, $auditTrailObjectID) {

	if ($auditTrailObject == 'taskCurrentOwnerUserID') {
		$auditTrailResource = getUserName($auditTrailObjectID);
	} elseif ($auditTrailObject == 'taskClassificationID') {
		$auditTrailResource = getShigotoClassificationName($auditTrailObjectID);
	} elseif ($auditTrailObject == 'taskPriorityID') {
		$auditTrailResource = getShigotoPriorityName($auditTrailObjectID);
	} elseif ($auditTrailObject == 'taskStatusID') {
		$auditTrailResource = getShigotoStatusName($auditTrailObjectID);
	} elseif ($auditTrailObject == 'propertyID') {
		$auditTrailResource = getPropertyName($auditTrailObjectID);
	} elseif ($auditTrailObject == 'accommodationID') {
		$auditTrailResource = getAccommodationName($auditTrailObjectID);
	} else {
		$auditTrailResource = $auditTrailObjectID;
	}
	
	return $auditTrailResource;
	
}


/*

function getFieldName($auditTrailField) {
	if ($auditTrailField == 'taskCurrentOwnerUserID') {
		$fieldName = 'taskCurrentOwnerUserID';
	} elseif ($auditTrailField == 'taskPriorityID') {
		$fieldName = 'priority';
	} elseif ($auditTrailField == 'taskStatusID') {
		$fieldName = 'status';
	} elseif ($auditTrailField == 'taskClassificationID') {
		$fieldName = 'classification';
	}
	
	return $fieldName;
}

*/


// postToAuditTrail($auditTrailUserName, $auditTrailAction, $auditTrailResult, $auditTrailOldData, $auditTrailNewData, $auditTrailObject, $auditTrailObjectID, $auditTrailField);

function postToAuditTrail(
		$auditTrailUserName, 
		$auditTrailAction, 
		$auditTrailResult, 
		$auditTrailOldData = '',
		$auditTrailNewData = '',
		$auditTrailObject = '',
		$auditTrailObjectID = 0,
		$auditTrailField = ''
	) {

		if (isset($_SESSION['userID'])) { $auditTrailUserName = $_SESSION['userID']; } // auditTrailIsAlwaysLoggedInUser
		
		$auditTrailSiteID = $_SESSION['siteID'];
		$auditTrailDateTime = date('Y-m-d H:i:s');
		$auditTrailIPaddress = $_SERVER['REMOTE_ADDR'];

		$auditTrailOldData = mysql_real_escape_string($auditTrailOldData);
		
		$queryLogInAuditTrail = "INSERT INTO auditTrail (
			auditTrailSiteID,
			auditTrailDateTime,
			auditTrailUserName,
			auditTrailAction,
			auditTrailOldData,
			auditTrailNewData,
			auditTrailResult,
			auditTrailIPaddress,
			auditTrailObject,
			auditTrailObjectID,
			auditTrailField
			) VALUES (
			'$auditTrailSiteID',
			'$auditTrailDateTime',
			'$auditTrailUserName',
			'$auditTrailAction',
			'$auditTrailOldData',
			'$auditTrailNewData',
			'$auditTrailResult',
			'$auditTrailIPaddress',
			'$auditTrailObject',
			'$auditTrailObjectID',
			'$auditTrailField'
		)";

		// echo '<pre>' . $queryLogInAuditTrail . '</pre>';
		mysql_query ($queryLogInAuditTrail) or die ('Error in postToAuditTrail()');


}

















function post404toAudit() {

		if (isset($_SESSION['siteID'])) { $fof_SiteID = $_SESSION['siteID']; } else { $fof_SiteID = 0; }
		if (isset($_SESSION['userID'])) { $fof_UserID = $_SESSION['userID']; } else { $fof_UserID = 0; }
		$fof_DateTime = date('Y-m-d H:i:s');
		$fof_REMOTE_ADDRESS = $_SERVER['REMOTE_ADDR'];
		$fof_PHP_SELF = $_SERVER['PHP_SELF'];
		$fof_HTTP_HOST = $_SERVER['HTTP_HOST'];
		$fof_REQUEST_URI = $_SERVER['REQUEST_URI'];
		$fof_HTTP_REFERER = $_SERVER['HTTP_REFERER'];
		$fof_HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
		
		$query404toAudit = "INSERT INTO audit404 (
			404_SiteID,
			404_UserID,
			404_DateTime,
			404_REMOTE_ADDRESS,
			404_PHP_SELF,
			404_HTTP_HOST,
			404_REQUEST_URI,
			404_HTTP_REFERER,
			404_HTTP_USER_AGENT
		) VALUES (
			'$fof_SiteID',
			'$fof_UserID',
			'$fof_DateTime',
			'$fof_REMOTE_ADDRESS',
			'$fof_PHP_SELF',
			'$fof_HTTP_HOST',
			'$fof_REQUEST_URI',
			'$fof_HTTP_REFERER',
			'$fof_HTTP_USER_AGENT'
		)";

		mysql_query ($query404toAudit) or die ('Error in post404toAudit()');

}



?>