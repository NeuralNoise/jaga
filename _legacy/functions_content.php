<?php





function createContentTest(
	$contentCategoryKey, 
	$entryTitleEnglish, 
	$entryTitleJapanese, 
	$entryPublishStartDate,
	$entryPublishEndDate, 
	$entryPublished, 
	$entryContentEnglish, 
	$entryContentJapanese, 
	$isEvent, 
	$eventDate, 
	$eventStartTime, 
	$eventEndTime
) {

	$siteID = $_SESSION['siteID'];
	$userID = $_SESSION['userID'];
	$entrySubmissionDateTime = date('Y-m-d H:i:s');
	$entryLastModified = date('Y-m-d H:i:s');
	
	if ($entryTitleEnglish != '' && $entryTitleJapanese == '') { $entryTitleJapanese = $entryTitleEnglish; }
	if ($entryTitleJapanese != '' && $entryTitleEnglish == '') { $entryTitleEnglish = $entryTitleJapanese; }
	if ($entryContentEnglish != '' && $entryContentJapanese == '') { $entryContentJapanese = $entryContentEnglish; }
	if ($entryContentJapanese != '' && $entryContentEnglish == '') { $entryContentEnglish = $entryContentJapanese; }
	
	$queryInsertContent = "INSERT INTO nisekocms_content (
			siteID,
			contentCategoryKey,
			entrySubmittedByUserID, 
			entrySubmissionDateTime, 
			entryPublishStartDate, 
			entryPublishEndDate, 
			entryTitleEnglish,
			entryTitleJapanese,
			entryContentEnglish,
			entryContentJapanese,
			entryPublished,
			isEvent,
			eventDate,
			eventStartTime,
			eventEndTime,
			entryLastModified
		) VALUES (
			'$siteID',
			'$contentCategoryKey',
			'$userID',
			'$entrySubmissionDateTime', 
			'$entryPublishStartDate', 
			'$entryPublishEndDate', 
			'$entryTitleEnglish',
			'$entryTitleJapanese',
			'$entryContentEnglish',
			'$entryContentJapanese',
			'$entryPublished',
			'$isEvent',
			'$eventDate',
			'$eventStartTime',
			'$eventEndTime',
			'$entryLastModified'
		)";
	mysql_query($queryInsertContent) or die ($queryInsertContent);
	
	$auditTrailObjectID = mysql_insert_id();
	
	$auditTrailUserName = $_SESSION['userID'];
	$auditTrailAction = 'insertContent';
	$auditTrailResult = 'success';
	$auditTrailOldData = '';
	$auditTrailNewData = $entryTitleEnglish;
	$auditTrailObject = 'content';
	$auditTrailField = 'entryTitleEnglish';
	
	postToAuditTrail(
		$auditTrailUserName, 
		$auditTrailAction, 
		$auditTrailResult, 
		$auditTrailOldData,
		$auditTrailNewData,
		$auditTrailObject,
		$auditTrailObjectID,
		$auditTrailField
	);
	
	$toAddress = getSiteAutomatedEmailAddress();
	$fromAddress = getSiteAutomatedEmailAddress();
	$mailSubject = "[ " . getUserName($auditTrailUserName) . " submitted \"" . $entryTitleEnglish . "\" ]";
	$mailMessage = getSiteURL() . "/" . getContentListURL($contentCategoryKey) . $auditTrailObjectID . "/";
	$siteID = $_SESSION['siteID'];
	$userID = $_SESSION['userID'];
	agileMail($toAddress, $fromAddress, $mailSubject, $mailMessage, $siteID, $userID, 'plaintext');
	
	return $auditTrailObjectID;

}

function updateContentTest(
	$entryID, 
	$contentCategoryKey, 
	$entryTitleEnglish, 
	$entryTitleJapanese, 
	$entryPublishStartDate, 
	$entryPublishEndDate, 
	$entryPublished, 
	$entryContentEnglish, 
	$entryContentJapanese, 
	$isEvent, 
	$eventDate, 
	$eventStartTime, 
	$eventEndTime
) {
	
	if ($entryTitleEnglish != '' && $entryTitleJapanese == '') { $entryTitleJapanese = $entryTitleEnglish; }
	if ($entryTitleJapanese != '' && $entryTitleEnglish == '') { $entryTitleEnglish = $entryTitleJapanese; }
	if ($entryContentEnglish != '' && $entryContentJapanese == '') { $entryContentJapanese = $entryContentEnglish; }
	if ($entryContentJapanese != '' && $entryContentEnglish == '') { $entryContentEnglish = $entryContentJapanese; }
	
	$entryLastModified = date('Y-m-d H:i:s');
	
		$queryUpdateContent = "
			UPDATE nisekocms_content SET
				contentCategoryKey = '$contentCategoryKey',
				entryTitleEnglish = '$entryTitleEnglish',
				entryTitleJapanese = '$entryTitleJapanese',
				entryContentEnglish = '$entryContentEnglish',
				entryContentJapanese = '$entryContentJapanese',
				entryPublishStartDate = '$entryPublishStartDate',
				entryPublishEndDate = '$entryPublishEndDate',
				entryPublished = '$entryPublished',
				isEvent = '$isEvent',
				eventDate = '$eventDate',
				eventStartTime = '$eventStartTime',
				eventEndTime = '$eventEndTime',
				entryLastModified = '$entryLastModified'
			WHERE entryID = '$entryID' LIMIT 1
		";
		
		mysql_query ($queryUpdateContent) or die ($queryUpdateContent);
	
		$auditTrailObjectID = $entryID;
		
		$auditTrailUserName = $_SESSION['userID'];
		$auditTrailAction = 'updateContent';
		$auditTrailResult = 'success';
		$auditTrailOldData = '';
		$auditTrailNewData = $entryTitleEnglish;
		$auditTrailObject = 'content';
		$auditTrailField = 'entryTitleEnglish';
		
		postToAuditTrail(
			$auditTrailUserName, 
			$auditTrailAction, 
			$auditTrailResult, 
			$auditTrailOldData,
			$auditTrailNewData,
			$auditTrailObject,
			$auditTrailObjectID,
			$auditTrailField
		);
		
		$toAddress = 'The Kutchannel <' . getSiteAutomatedEmailAddress() . '>';
		$fromAddress = 'The Kutchannel <' . getSiteAutomatedEmailAddress() . '>';
		$mailSubject = "[ " . getUserName($auditTrailUserName) . " updated \"" . $entryTitleEnglish . "\" ]";
		$mailMessage = getSiteURL() . "/" . getContentListURL($contentCategoryKey) . $auditTrailObjectID . "/";
		$siteID = $_SESSION['siteID'];
		$userID = $_SESSION['userID'];
		agileMail($toAddress, $fromAddress, $mailSubject, $mailMessage, $siteID, $userID, 'plaintext');

}





function insertContent(
	$entrySiteID, 
	$entryUrl, 
	$entryCategoryID, 
	$entrySubmittedByUserID, 
	$entrySubmissionDateTime,
	$entryPublishStartDate, 
	$entryPublishEndDate, 
	$entryTitleEnglish, 
	$entryTitleJapanese, 
	$entryContentEnglish, 
	$entryContentJapanese, 
	$entryPublished
) {

	$insertQuery = "INSERT INTO `nisekocms_content` (
		`entrySiteID`, 
		`entryUrl`, 
		`entryCategoryID`,
		`entrySubmittedByUserID`, 
		`entrySubmissionDateTime`, 
		`entryPublishStartDate`, 
		`entryPublishEndDate`, 
		`entryTitleEnglish`, 
		`entryTitleJapanese`, 
		`entryContentEnglish`, 
		`entryContentJapanese`, 
		`entrySortOrder`, 
		`pageID`, 
		`entryPublished`
	) VALUES (
		$entrySiteID, 
		$entryUrl, 
		$entryCategoryID, 
		$entrySubmittedByUserID, 
		$entrySubmissionDateTime,
		$entryPublishStartDate, 
		$entryPublishEndDate, 
		$entryTitleEnglish, 
		$entryTitleJapanese, 
		$entryContentEnglish, 
		$entryContentJapanese, 
		$entryPublished
	)";
	
	mysql_query ($insertQuery) or die ('ERROR (insertContent)');

}

function displayContentList($contentCategoryKey = '', $contentCategoryCSS = 'float:left;height:350px;width:615px;text-align:left;margin:5px;border:1px solid #ccc;overflow:auto;') {

	echo '<div style="' . $contentCategoryCSS . '">';
	
		echo '<table style="width:100%;">';
		
			echo '<tr>';
				echo '<td class="borderAlignRight" colspan="2">';
						echo '<a href="' . languageUrlPrefix() . getContentNewCrudURL($contentCategoryKey) . '">';
							echo agileResource(getContentNewCrudTitle($contentCategoryKey));
						echo '</a>';
				echo '</td>';
			echo '</tr>';
			
			
			$rowCount = 0;
			
			$siteID = $_SESSION['siteID'];
			$userID = $_SESSION['userID'];
			
			
			if (!is_authed()) {
				$resultGetContentListQuery = "SELECT * FROM nisekocms_content WHERE contentCategoryKey = '$contentCategoryKey' AND entrySiteID = $siteID AND entryPublished = 1 ORDER BY entryPublishStartDate DESC";
			} else {
				$resultGetContentListQuery = "SELECT * FROM nisekocms_content WHERE contentCategoryKey = '$contentCategoryKey' AND entrySiteID = $siteID AND (entryPublished = 1 OR entrySubmittedByUserID = $userID) ORDER BY entryPublishStartDate DESC";
			}
			
			
			$resultGetContentList = mysql_query($resultGetContentListQuery);
			while($rowGetContentItem = mysql_fetch_array($resultGetContentList)) {
				if (($rowCount % 2) == 0) { $rowStyle = 'background-color:#fff'; } else { $rowStyle = 'background-color:#eee'; }
				
				echo '<tr style="' . $rowStyle . '">';
					echo '<td class="borderAlignLeft">';
						echo getUserName($rowGetContentItem['entrySubmittedByUserID']);
					echo '</td>';
					echo '<td class="borderAlignLeft">';
						echo '<a href="' . languageUrlPrefix() . getNewContentListName($contentCategoryKey) . '/' . $rowGetContentItem['entryID'] . '/';
						
							if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
						
						echo '">';
							echo $rowGetContentItem['entryTitleEnglish'];
						echo '</a>';
					echo '</td>';
				echo '</tr>';
				
				/*
				echo '<tr style="' . $rowStyle . '">';
					echo '<td class="borderAlignLeft" colspan="2">';
						echo $rowGetContentItem['entryContentEnglish'];
					echo '</td>';
				echo '</tr>';
				*/
				
				$rowCount++;
			}

		echo '</table>';
	echo '</div>';

}

function displayContentAdminList() {

	$siteID = $_SESSION['siteID'];
	$queryGetContentAdminList = "SELECT * FROM nisekocms_content WHERE entrySiteID = $siteID ORDER BY entryPublishStartDate DESC";
	$resultGetContentAdminList = mysql_query($queryGetContentAdminList);
	
	echo '<div style="text-align:center;">';
		echo '<table style="margin:5px auto 5px auto;background-color:#fff;">';
			
			echo '<tr>';
				echo '<td class="borderAlignCenter">' . agileResource('entryID') . '</td>';
				echo '<td class="borderAlignCenter">' . agileResource('entryTitle') . '</td>';
			echo '</tr>';
			
			while ($rowGetContentAdminList = mysql_fetch_array($resultGetContentAdminList)) {
				echo '<tr>';
					echo '<td class="borderAlignCenter">' . $rowGetContentAdminList['entryID'] . '</td>';
					echo '<td class="borderAlignCenter">';
						echo '<a href="' . languageUrlPrefix() . 'manage-content/update/' . $rowGetContentAdminList['entryID'] . '/';
						
							if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
						
						echo '">';
							echo $rowGetContentAdminList['entryTitleEnglish'];
						echo '</a>';
					echo '</td>';
				echo '</tr>';
			}
		
		echo '</table>';
	echo '</div>';
}

function displayContentCRUD($action = 'new', $contentCategoryKey = '', $contentID = 0) {

	$siteID = $_SESSION['siteID'];

	if ($contentCategoryKey == '' && $contentID != 0) { $contentCategoryKey = getContentCategoryKey($contentID); }
	
	if ($action == 'new') {
	
		$pageTitle = agileResource(getContentNewCrudTitle($contentCategoryKey));
		$formAction = languageUrlPrefix() . getContentNewCrudURL($contentCategoryKey);
	
		$entryTitleEnglish = '';
		$entryPublished = 1;
		$entryContentEnglish = '';
		
		
		
	} elseif ($action == 'update') {
	
		$pageTitle = agileResource(getContentUpdateCrudTitle($contentCategoryKey));
		$formAction = languageUrlPrefix() . getContentUpdateCrudURL($contentCategoryKey) . $contentID . '/';
	
		$resultGetContentToUpdate = mysql_query("SELECT * FROM nisekocms_content WHERE entryID = $contentID AND entrySiteID = $siteID LIMIT 1");
		while($rowGetContentToUpdate = mysql_fetch_array($resultGetContentToUpdate)) {
			$entryTitleEnglish = $rowGetContentToUpdate['entryTitleEnglish'];
			$entryPublished = $rowGetContentToUpdate['entryPublished'];
			$entryContentEnglish = $rowGetContentToUpdate['entryContentEnglish'];
		}
		
		
		
	}
	
	echo '<div>';
	echo '<form method="post" action="' . $formAction . '">';
	if ($action == 'update') {
		echo '<input type="hidden" name="entryID" value="' . $contentID . '">';
	}
	echo '<input type="hidden" name="contentCategoryKey" value="' . $contentCategoryKey . '">';
	// echo '<input type="hidden" name="formAction" value="' . $formAction . '">';
		echo '<table style="width:100%;">';
			echo '<tr>';
				echo '<td>' . $pageTitle . '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td class="borderAlignLeft">';
					echo '<input type="text" name="entryTitleEnglish" value="';
						echo $entryTitleEnglish;
					echo '" style="width:300px;">';	
					echo ' ' . agileResource('publish') . ' ';
					echo '<input type="checkbox" name="entryPublished" value="1"';
						if ($entryPublished == 1) { echo ' checked'; }
					echo '>';

				echo '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td class="borderAlignLeft"><textarea name="entryContentEnglish" class="ckeditor">';
					echo $entryContentEnglish;
				echo '</textarea></td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td class="borderAlignRight">';
					echo '<input type="submit" name="submit" value="' . agileResource('save') . '">';
				echo '</td>';
			echo '</tr>';
		echo '</table>';
		echo '</form>';
	echo '</div>';
}

function displayContent($contentID, $contentCategoryCSS = 'float:left;height:350px;width:615px;text-align:left;margin:5px;border:1px solid #ccc;overflow:auto;') {

	$contentCategoryKey = getContentCategoryKey($contentID);
	// echo getContentCategoryKey($contentID);
	
	$resultGetContentQuery = "SELECT * FROM nisekocms_content WHERE entryID = $contentID LIMIT 1";
	$resultGetContentEntry = mysql_query($resultGetContentQuery);
	while($rowGetContentItem = mysql_fetch_array($resultGetContentEntry)) {

		echo '<div style="' . $contentCategoryCSS . '">';
		echo '<table style="width:100%;">';
			echo '<tr style="background-color:#34596e;">';
				echo '<td class="borderAlignCenter" colspan="2">';
					echo '<h2 style="margin:0px;color:#ffffff;">';
						echo $rowGetContentItem['entryTitleEnglish'];
					echo '</h2>';
				echo '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td class="borderAlignLeft">';
					echo getUserName($rowGetContentItem['entrySubmittedByUserID']);
				echo '</td>';
				echo '<td class="borderAlignLeft">';
					echo $rowGetContentItem['entryTitleEnglish'];
				echo '</td>';
			echo '</tr>';
				
			echo '<tr>';
				echo '<td class="borderAlignLeft" colspan="2">';
					echo $rowGetContentItem['entryContentEnglish'];
				echo '</td>';
			echo '</tr>';

			// IF ADMIN OR OWNER ALLOW UPDATING
			
			if ($rowGetContentItem['entrySubmittedByUserID'] == $_SESSION['userID']) {
				echo '<tr>';
					echo '<td class="borderAlignRight" colspan="2">';
						echo '<a href="' . languageUrlPrefix() . agileResource(getContentUpdateCrudURL($contentCategoryKey)) . $rowGetContentItem['entryID'] . '/">';
							echo agileResource(getContentUpdateCrudTitle($contentCategoryKey));
						echo '</a>';
					echo '</td>';
				echo '</tr>';
			}
			
		echo '</table>';
		echo '</div>';

	}

}

function getContentListTitle($contentCategoryKey) {

	$query = "SELECT contentCategory_listTitle FROM nisekocms_contentCategory WHERE contentCategoryKey = '$contentCategoryKey' LIMIT 1";
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 1) {
		while($row = mysql_fetch_array($result)) {
			if ($row['contentCategory_listTitle'] != '') {
				$returnResult = $row['contentCategory_listTitle'];
			} else {
				$returnResult = 'contentCategory_listTitle not set';
			}
		}
	} else {
		$returnResult = 'categoryDoesNotExist';
	}
	return $returnResult;
}

function getContentListURL($contentCategoryKey) {
	$query = "SELECT contentCategory_listURL FROM nisekocms_contentCategory WHERE contentCategoryKey = '$contentCategoryKey' LIMIT 1";
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 1) {
		while($row = mysql_fetch_array($result)) {
			if ($row['contentCategory_listURL'] != '') {
				$returnResult = $row['contentCategory_listURL'];
			} else {
				$returnResult = 'contentCategory_listURL not set';
			}
		}
	} else {
		$returnResult = 'categoryDoesNotExist';
	}
	return $returnResult;
}

function getContentNewCrudTitle($contentCategoryKey) {

	$query = "SELECT contentCategory_newCrudTitle FROM nisekocms_contentCategory WHERE contentCategoryKey = '$contentCategoryKey' LIMIT 1";

	$result = mysql_query($query);
	if (mysql_num_rows($result) == 1) {
		while($row = mysql_fetch_array($result)) {
			if ($row['contentCategory_newCrudTitle'] != '') {
				$returnResult = $row['contentCategory_newCrudTitle'];
			} else {
				$returnResult = 'contentCategoryCrudNameNotSet';
			}
		}
	} else {
		$returnResult = 'getContentNewCrudTitle() failed';
	}
	return $returnResult;
}

function getContentNewCrudURL($contentCategoryKey) {
	$query = "SELECT contentCategory_newCrudURL FROM nisekocms_contentCategory WHERE contentCategoryKey = '$contentCategoryKey' LIMIT 1";
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 1) {
		while($row = mysql_fetch_array($result)) {
			if ($row['contentCategory_newCrudURL'] != '') {
				$returnResult = $row['contentCategory_newCrudURL'];
			} else {
				$returnResult = 'contentCategoryNewContentLinkNotSet';
			}
		}
	} else {
		$returnResult = 'getContentNewCrudURL() failed';
	}
	return $returnResult;
}

function getContentUpdateCrudTitle($contentCategoryKey) {
	
	// echo '$contentCategoryKey = ' . $contentCategoryKey;
	
	$query = "SELECT contentCategory_updateCrudTitle FROM nisekocms_contentCategory WHERE contentCategoryKey = '$contentCategoryKey' LIMIT 1";
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 1) {
		while($row = mysql_fetch_array($result)) {
			if ($row['contentCategory_updateCrudTitle'] != '') {
				$returnResult = $row['contentCategory_updateCrudTitle'];
			} else {
				$returnResult = 'contentCategoryCrudNameNotSet';
			}
		}
	} else {
		$returnResult = 'categoryDoesNotExist - getContentUpdateCrudTitle()';
	}
	return $returnResult;
}

function getContentUpdateCrudURL($contentCategoryKey) {
	$query = "SELECT contentCategory_updateCrudURL FROM nisekocms_contentCategory WHERE contentCategoryKey = '$contentCategoryKey' LIMIT 1";
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 1) {
		while($row = mysql_fetch_array($result)) {
			if ($row['contentCategory_updateCrudURL'] != '') {
				$returnResult = $row['contentCategory_updateCrudURL'];
			} else {
				$returnResult = 'contentCategoryNewContentLinkNotSet - getContentUpdateCrudURL()';
			}
		}
	} else {
		$returnResult = 'categoryDoesNotExist';
	}
	return $returnResult;
}

function getContentCategoryKey($contentID) {

	// echo $contentID;
	
	$query = "SELECT contentCategoryKey FROM nisekocms_content WHERE entryID = $contentID LIMIT 1";
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 1) {
		while($row = mysql_fetch_array($result)) {
			if ($row['contentCategoryKey'] != '') {
				$contentCategoryKey = $row['contentCategoryKey'];
			} else {
				$contentCategoryKey = 'contentCategoryKeyNotSet';
			}
		}
	} else {
		$contentCategoryKey = 'contentDoesNotExist';
	}
	return $contentCategoryKey;
}

function displayRecentJoomlaContentFiltered($category, $domain, $numberOfItems) {
	
	if ($category != '') {
		$categoryWhereClause = 'j00mla_ver4_categories.alias = \'' . $category . '\' AND '; 
	} else {
		$categoryWhereClause = '';
	}

$currentDateTime = date('Y-m-d H:i:s');

$resultGetContentListQuery = "
	
SELECT

nisekocms_content.entryID AS contentID,
nisekocms_content.entryTitleEnglish AS contentTitle,
nisekocms_content.entryUrl AS contentAlias,
nisekocms_content.entrySubmissionDateTime AS created,
j00mla_ver4_users.username AS username,
nisekocms_content.entryViews AS contentViews,
j00mla_ver4_categories.title as categoryTitle,
j00mla_ver4_categories.alias as categoryAlias

FROM

(nisekocms_content LEFT JOIN j00mla_ver4_categories ON nisekocms_content.entryCategoryID = j00mla_ver4_categories.id) LEFT JOIN j00mla_ver4_users ON nisekocms_content.entrySubmittedByUserID = j00mla_ver4_users.id

WHERE

$categoryWhereClause


nisekocms_content.entryPublished = 1 AND
nisekocms_content.entryPublishStartDate <= '$currentDateTime' AND 
(nisekocms_content.entryPublishEndDate >= '$currentDateTime' OR nisekocms_content.entryPublishEndDate = '000-00-00 00:00:00')

ORDER BY

created

DESC

LIMIT

$numberOfItems

";


		$contentNewCrudTitle = getContentNewCrudTitle($category);
		$contentNewCrudURL = getContentNewCrudURL($category);
		$contentListURL = getContentListURL($category);
		
		echo '<table style="width:100%;">';
			echo '<tr style="background-color:#115b8a;">';
				echo '<td colspan="2" class="borderAlignCenter">';
					echo '<div>';
						echo '<h3 style="float:left;margin:0px 0px 0px 10px;color:#ffffff;">';
							if ($category != '') { echo agileResource($category); }
						echo '</h3>';

						echo '<a href="' . $domain . languageUrlPrefix() . $contentNewCrudURL;
						echo '" style="float:right;margin:2px 2px 0px 0px;color:#ffffff;text-decoration:none;"';
						
						
						echo '>';
							echo '<img src="agileThemes/kutchannel/images/plus-symbol.png">';
						echo '</a>';
						
						echo '<a href="' . $domain . languageUrlPrefix() . $contentNewCrudURL;
						echo '" style="float:right;margin:2px 2px 0px 0px;color:#ffffff;text-decoration:none;"';
						
						
						echo '>';
							echo agileResource($contentNewCrudTitle);
						echo '</a>';
						
							echo '<a href="' . $domain . languageUrlPrefix();
							
							if ($domain == '') { echo $contentListURL; }
							
							echo '" style="float:right;margin:2px 10px 0px 0px;color:#ffffff;text-decoration:none;"';
							echo '>';
								echo '&nbsp;<img src="agileThemes/kutchannel/images/upper-right-arrow.png">';
							echo '</a>';
						
						echo '<a href="' . $domain . languageUrlPrefix();
						
							if ($domain == '') { echo $contentListURL; }
							
						echo '" style="float:right;margin:2px 2px 0px 0px;color:#ffffff;text-decoration:none;"';

						echo '>';
							echo agileResource('more');
						echo '</a>';
						
						echo '<div style="clear:both;"></div>';
					echo '</div>';
					
				echo '</td>';
			echo '</tr>';

		$rowCount = 0;
		$resultGetContentList = mysql_query($resultGetContentListQuery);

		while($rowGetContentItem = mysql_fetch_array($resultGetContentList)) {
			
			echo '<tr style="background-color:';
				if (($rowCount % 2) == 0) { echo '#fff'; } else { echo '#eee'; }
			echo '">';
				
				echo '<td class="borderAlignLeft">' . $rowGetContentItem['username'] . '</td>';
				
				echo '<td class="borderAlignLeft">';
					echo '<a class="agileLinkage" href="' . $domain . languageUrlPrefix() . $contentListURL . $rowGetContentItem['contentID'] . '/">';
						echo $rowGetContentItem['contentTitle'];
					echo '</a>';
				echo '</td>';
				
			echo '</tr>';
			
			$rowCount++;
		}

	echo '</table>';	

}

function displayContentListModule(
		$contentCategoryKey = '', 
		$siteID = 0, 
		$domainToLinkTo = '', 
		$queryLimit = 'LIMIT 7', 
		$divStyleAttribute = '', 
		$tableStyleAttribute = 'width:100%;'
	) {
	
	$currentDateTime = date('Y-m-d H:i:s');
	
	$contentNewCrudTitle = getContentNewCrudTitle($contentCategoryKey);
	
	$contentNewCrudURL = $domainToLinkTo . languageUrlPrefix() . getContentNewCrudURL($contentCategoryKey);
	if (is_authed()) { $contentNewCrudURL .= 'token=' . $_SESSION['userToken']; }
	
	$contentListURL = $domainToLinkTo . languageUrlPrefix() . getContentListURL($contentCategoryKey);
	if (is_authed()) { $contentListURL .= 'token=' . $_SESSION['userToken']; }
	
	if ($siteID != 0) { $whereQuerySiteID = "nisekocms_content.siteID = '$siteID' AND"; } else { $whereQuerySiteID = ''; }
	if ($_SESSION['lang'] == 'ja') {
		$selectQueryEntryContent = 'nisekocms_content.entryContentJapanese AS entryContent';
	} else {
		$selectQueryEntryContent = 'nisekocms_content.entryContentEnglish AS entryContent';
	}
	
	$resultGetContentListQuery = "
		SELECT
			nisekocms_content.entrySubmittedByUserID as userID,
			nisekocms_content.entryID as entryID,
			$selectQueryEntryContent
		FROM
			nisekocms_content
		WHERE
			$whereQuerySiteID
			nisekocms_content.contentCategoryKey = '$contentCategoryKey' AND
			nisekocms_content.entryPublished = '1' AND
			nisekocms_content.entryPublishStartDate <= '$currentDateTime' AND 
			(nisekocms_content.entryPublishEndDate >= '$currentDateTime' OR nisekocms_content.entryPublishEndDate = '000-00-00 00:00:00')
		ORDER BY entryLastModified DESC $queryLimit
	";

		echo '<table style="' . $tableStyleAttribute .'">';
		
			
			if ($_SESSION['siteID'] == 26) {
				echo '<tr style="background-color:#f6921d;">';
			} elseif ($_SESSION['siteID'] == 55) {
				echo '<tr style="background-color:' . getSitePrimaryColor($_SESSION['siteID']) . ';">';
			} elseif (in_array('nisekopass',$_SESSION['siteModuleArray'])) {
				echo '<tr style="background-color:#a2c0d2;">';
			} else {
				echo '<tr style="background-color:#115b8a;">';
			}
				
				if (in_array('nisekopass',$_SESSION['siteModuleArray'])) {
					$tdTextColor = '#000';
				} else {
					$tdTextColor = '#fff';
				}
				
				echo '<td colspan="2" class="borderAlignCenter">';
					echo '<div>';
						echo '<h3 style="float:left;margin:0px 0px 0px 5px;color:' . $tdTextColor . ';">' . agileResource($contentCategoryKey) . '</h3>';

						echo '<a href="' . $contentNewCrudURL . '" style="float:right;margin:2px 2px 0px 0px;color:' . $tdTextColor . ';text-decoration:none;">';
							echo '<img src="/agileThemes/kutchannel/images/plus-symbol.png">';
						echo '</a>';
						echo '<a href="' . $contentNewCrudURL . '" style="float:right;margin:2px 2px 0px 0px;color:' . $tdTextColor . ';text-decoration:none;">';
							echo agileResource($contentNewCrudTitle);
						echo '</a>';
						echo '<a href="' . $contentListURL . '" style="float:right;margin:2px 10px 0px 0px;color:' . $tdTextColor . ';text-decoration:none;">';
							echo '&nbsp;<img src="/agileThemes/kutchannel/images/upper-right-arrow.png">';
						echo '</a>';
						echo '<a href="' . $contentListURL . '" style="float:right;margin:2px 2px 0px 0px;color:' . $tdTextColor . ';text-decoration:none;">';
							echo agileResource('more');
						echo '</a>';
						echo '<div style="clear:both;"></div>';
					echo '</div>';
				echo '</td>';
			echo '</tr>';

			$rowCount = 0;
			$resultGetContentList = mysql_query($resultGetContentListQuery);
			while($rowGetContentItem = mysql_fetch_array($resultGetContentList)) {
			
				$contentViewURL = $domainToLinkTo . languageUrlPrefix() . getContentListURL($contentCategoryKey) . $rowGetContentItem['entryID'] . '/';
				if (is_authed()) { $contentViewURL .= 'token=' . $_SESSION['userToken']; }
			
				if (($rowCount % 2) == 0) { $trStyleAttribute = 'background-color:#fff;'; } else { $trStyleAttribute = 'background-color:#eee;'; }
				echo '<tr style="' . $trStyleAttribute . '">';
					echo '<td class="borderAlignLeft">' . getUserName($rowGetContentItem['userID']) . '</td>';
					echo '<td class="borderAlignLeft">';
						echo '<a class="agileLinkage" href="' . $contentViewURL . '">';
							echo strip_tags(getContentTitle($rowGetContentItem['entryID']));
						echo '</a>';
					echo '</td>';
				echo '</tr>';
				$rowCount++;
			}

		echo '</table>';

}

function displayFrontPageContent($siteID, $height = 400, $width = 613, $border = 'border:1px solid #ccc;') {

		echo '<div style="height:' . $height . 'px;width:' . $width . 'px;text-align:center;' . $border . '">';

		
		if ($_SESSION['lang'] == 'ja') {
			$resultGetContentItem = mysql_query("SELECT entryTitleJapanese as title, entryContentJapanese as content FROM nisekocms_content WHERE entrySiteID = $siteID AND entryUrl = 'front' LIMIT 1");
		} else {
			$resultGetContentItem = mysql_query("SELECT entryTitleEnglish as title, entryContentEnglish as content FROM nisekocms_content WHERE entrySiteID = $siteID AND entryUrl = 'front' LIMIT 1");
		}
		
		
		echo '<table>';
		
		while($rowGetContentItem = mysql_fetch_array($resultGetContentItem)) {
			echo '<tr>';
				if ($_SESSION['siteID'] != 31 && $_SESSION['siteID'] != 33) {
					echo '<td style="text-align:left;">';
				} else {
					if ($_SESSION['siteID'] == 31) {
						echo '<td>';
					} else {
						echo '<td class="borderAlignLeft">';
					}
				}
					echo $rowGetContentItem['content'];
				echo '</td>';
			echo '</tr>';
		}
		
		echo '</table>';
	echo '</div>';
}

function displayAgileContent($siteID, $entryUrl) {

		$resultGetAgileContentItem = mysql_query("SELECT * FROM nisekocms_content WHERE entrySiteID = $siteID AND entryUrl = '$entryUrl' LIMIT 1");
		while($rowGetAgileContentItem = mysql_fetch_array($resultGetAgileContentItem)) {
			$entryTitleJapanese = $rowGetAgileContentItem['entryTitleJapanese'];
			$entryContentJapanese = $rowGetAgileContentItem['entryContentJapanese'];
			$entryTitleEnglish = $rowGetAgileContentItem['entryTitleEnglish'];
			$entryContentEnglish = $rowGetAgileContentItem['entryContentEnglish'];
			$useRightColumn = $rowGetAgileContentItem['useRightColumn'];
		}
		
		if ($useRightColumn == 1) { echo '<div style="float:left;width:615px;">'; } else { echo '<div>'; }
		echo '<table style="width:100%;background-color:#fff;">';
			if ($_SESSION['lang'] == 'ja') {
				// echo '<tr><td class="borderAlignLeft">' . $entryTitleJapanese . '</td></tr>';	
				echo '<tr><td class="borderAlignLeft">' . $entryContentJapanese . '</td></tr>';
			} else {
				// echo '<tr><td class="borderAlignLeft">' . $entryTitleEnglish . '</td></tr>';	
				echo '<tr><td class="borderAlignLeft">' . $entryContentEnglish . '</td></tr>';
			}
		echo '</table>';
		echo '</div>';
		if ($useRightColumn == 1) {
			displayBanners(250);
			echo '<div style="clear:both;">';
		}
		
}

function displayStaticContent($page) {
	echo '<div>';
		echo '<table style="width:100%;">';
		
		if ($_SESSION['lang'] == 'ja') {
			$resultGetContentItem = mysql_query("SELECT entryTitleJapanese as title, entryContentJapanese as content FROM nisekocms_content WHERE entryURL = '$page' LIMIT 1");
		} else {
			$resultGetContentItem = mysql_query("SELECT entryTitleEnglish as title, entryContentEnglish as content FROM nisekocms_content WHERE entryURL = '$page' LIMIT 1");
		}
		
		while($rowGetContentItem = mysql_fetch_array($resultGetContentItem)) {
			echo '<tr><td class="borderAlignLeft">' . $rowGetContentItem['title'] . '</td></tr>';	
			echo '<tr><td class="borderAlignLeft">' . $rowGetContentItem['content'] . '</td></tr>';
		}
		echo '</table>';
	echo '</div>';
}

function insertNisekoCmsContent(
		$entryURL,
		$entryTitleEnglish,
		$contentCategoryKey,
		$entryPublished,
		$entryContentEnglish
	) {
	
		$entrySiteID = getSiteID();
		$contentCategoryKey = $contentCategoryKey;
		$entrySubmittedByUserID = $_SESSION['userID'];
		$entrySubmissionDateTime = date('Y-m-d H:i:s');
		$entryPublishStartDate = date('Y-m-d');
		$entryPublishEndDate = '2020-12-31';
		$entryTitleEnglish = mysql_real_escape_string($entryTitleEnglish);
		$entryTitleJapanese = mysql_real_escape_string($entryTitleEnglish); // need to revise
		$entryContentEnglish = mysql_real_escape_string($entryContentEnglish);
		$entryContentJapanese = mysql_real_escape_string($entryContentEnglish); // need to revise
		$entryPublished = mysql_real_escape_string($entryPublished);
	
		$query = "INSERT INTO nisekocms_content (
			entrySiteID,
			entryUrl,
			contentCategoryKey,
			entrySubmittedByUserID, 
			entrySubmissionDateTime, 
			entryPublishStartDate, 
			entryPublishEndDate, 
			entryTitleEnglish,
			entryTitleJapanese,
			entryContentEnglish,
			entryContentJapanese,
			entryPublished
		) VALUES (
			$entrySiteID,
			'$entryUrl',
			'$contentCategoryKey',
			$entrySubmittedByUserID, 
			'$entrySubmissionDateTime', 
			'$entryPublishStartDate', 
			'$entryPublishEndDate', 
			'$entryTitleEnglish',
			'$entryTitleJapanese',
			'$entryContentEnglish',
			'$entryContentJapanese',
			$entryPublished
		)";
		
		mysql_query ($query) or die ($query);
		
		$auditTrailObjectID = mysql_insert_id();
		
		$auditTrailUserName = $_SESSION['userID'];
		$auditTrailAction = 'insertNisekoCmsContent';
		$auditTrailResult = 'success';
		$auditTrailOldData = '';
		$auditTrailNewData = $entryTitleEnglish;
		$auditTrailObject = 'content';
		$auditTrailField = 'entryTitleEnglish';
		
		postToAuditTrail(
			$auditTrailUserName, 
			$auditTrailAction, 
			$auditTrailResult, 
			$auditTrailOldData,
			$auditTrailNewData,
			$auditTrailObject,
			$auditTrailObjectID,
			$auditTrailField
		);
		
	}

function updateNisekoCmsContent($contentID, $contentCategoryKey, $entryTitleEnglish, $entryContentEnglish, $entryPublished) {

		// forced to remove mysql_real_string_escape() here...
	
		$contentID = $contentID;
		$contentCategoryKey = $contentCategoryKey;
		$entryTitleEnglish = $entryTitleEnglish;
		$entryTitleJapanese = $entryTitleEnglish; // need to revise
		$entryContentEnglish = $entryContentEnglish;
		$entryContentJapanese = $entryContentEnglish; // need to revise
		$entryPublished = $entryPublished;
	
		$query = "UPDATE nisekocms_content SET
			contentCategoryKey = '$contentCategoryKey',
			entryTitleEnglish = '$entryTitleEnglish',
			entryTitleJapanese = '$entryTitleJapanese',
			entryContentEnglish = '$entryContentEnglish',
			entryContentJapanese = '$entryContentJapanese',
			entryPublished = $entryPublished
		WHERE entryID = $contentID LIMIT 1";
		
		mysql_query ($query) or die ($query);
		
		// echo $query;
	}
	
function displayClassifiedEmploymentAds($section, $category) {
	
	
	if ($section != '') {
		$sectionWhereClause = 'j00mla_ver4_sections.alias = \'' . $section . '\' AND ';
	} else {
		$sectionWhereClause = '';
	}
	
	if ($category != '') {
		$categoryWhereClause = 'j00mla_ver4_categories.alias = \'' . $category . '\' AND '; 
	} else {
		$categoryWhereClause = '';
	}
	
	
	$currentDateTime = date('Y-m-d H:i:s');
	
				echo '<table style="width:615px;margin:5px auto 5px auto;">';
				
					echo '<tr style="background-color:#115b8a;">';
						echo '<td colspan="5" class="borderAlignCenter">';
							echo '<h2 style="margin:0px;color:#ffffff;">';
								if ($section != '' && $category == '') { // only SECTION
									echo agileResource($section);
								} elseif ($section != '' && $category != '') { // SECTION and CATEGORY
									echo agileResource($section) . ' - ' . agileResource($category);
							}
							echo '</h2>';
						echo '</td>';
					echo '</tr>';

$resultGetContentListQuery = "
	
SELECT

j00mla_ver4_content.id AS contentID,
j00mla_ver4_content.title AS contentTitle,
j00mla_ver4_content.alias AS contentAlias,
j00mla_ver4_content.created AS created,
j00mla_ver4_users.username AS username,
j00mla_ver4_content.hits AS contentViews,
j00mla_ver4_categories.title as categoryTitle,
j00mla_ver4_categories.alias as categoryAlias,
j00mla_ver4_sections.title as sectionTitle

FROM

((j00mla_ver4_content LEFT JOIN j00mla_ver4_categories ON j00mla_ver4_content.catid = j00mla_ver4_categories.id) LEFT JOIN j00mla_ver4_sections ON j00mla_ver4_content.sectionid = j00mla_ver4_sections.id) LEFT JOIN j00mla_ver4_users ON j00mla_ver4_content.created_by = j00mla_ver4_users.id

WHERE

// $sectionWhereClause
$categoryWhereClause

j00mla_ver4_content.state = 1 AND
j00mla_ver4_content.publish_up < '$currentDateTime' AND 
(j00mla_ver4_content.publish_down > '$currentDateTime' OR j00mla_ver4_content.publish_down = '000-00-00 00:00:00')

ORDER BY

j00mla_ver4_content.created

DESC

";

		$rowCount = 0;
		$resultGetContentList = mysql_query($resultGetContentListQuery);

		while($rowGetContentItem = mysql_fetch_array($resultGetContentList)) {
			if ($section == 'info') { $typeOfContent = 'guide'; }
			elseif ($section == 'classifieds') { $typeOfContent = 'ads'; }
			elseif ($section == 'news') { $typeOfContent = 'news'; }
			else { $typeOfContent = 'content'; }
			echo '<tr style="background-color:';
					if (($rowCount % 2) == 0) { echo '#fff'; } else { echo '#eee'; }
				echo '">';
				echo '<td class="borderAlignLeft" colspan="3">';
					echo '<a class="agileLinkage" href="' . $languageUrlPrefix . $typeOfContent . '/' . $rowGetContentItem['contentAlias'] . '/">';
						echo $rowGetContentItem['contentTitle'];
					echo '</a>';
				echo '</td>';
			echo '</tr>';
			echo '<tr style="background-color:';
					if (($rowCount % 2) == 0) { echo '#fff'; } else { echo '#eee'; }
				echo '">';
				echo '<td class="borderAlignLeft">' . $rowGetContentItem['username'] . '</td>';
				echo '<td class="borderAlignRight"><i>' . $rowGetContentItem['created'] . '</i></td>';
				echo '<td class="borderAlignRight">' . $rowGetContentItem['contentViews'] . '</td>';
			echo '</tr>';
			$rowCount++;
		}

	echo '</table>';	
	
	
}

function userOwnsContent($entryID) {

	if (isset($_SESSION['userID'])) {
		$userID = $_SESSION['userID'];
		$query = "SELECT entrySubmittedByUserID FROM nisekocms_content WHERE entryID = '$entryID' AND entrySubmittedByUserID = '$userID' LIMIT 1";
		$result = mysql_query($query);
		if (mysql_num_rows($result) == 1) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}

}

function displayContentTestList(
	$contentCategoryKey,
	$tableStyleAttribute = 'margin:5px auto 5px auto;background-color:#fff;',
	$limitClausePage = 1
) {

	$limitClausePageAdjusted = $limitClausePage - 1;
	$entriesPerPage = 25;
	$firstRecord = $limitClausePageAdjusted * $entriesPerPage;
	
	// $limitClause = "LIMIT $firstRecord, $entriesPerPage";
	$limitClause = '';
	
	$currentDate = date('Y-m-d');

	
	
			if ($_SESSION['userRoleForCurrentSite'] == 'siteManager') {
				$queryContentTestList = "
					SELECT * FROM nisekocms_content 
					WHERE contentCategoryKey = '$contentCategoryKey'
					AND siteID = '$_SESSION[siteID]'
					ORDER BY entrySubmissionDateTime DESC $limitClause
				";
			} else {
				if (is_authed()) {
					$queryContentTestList = "
					SELECT * FROM nisekocms_content 
					WHERE contentCategoryKey = '$contentCategoryKey'
					AND siteID = '$_SESSION[siteID]'
					AND (entrySubmittedByUserID = '$_SESSION[userID]' OR (entryPublished = '1' AND entryPublishStartDate <= '$currentDate' AND (entryPublishEndDate >= '$currentDate' OR entryPublishEndDate = '0000-00-00'))) ORDER BY entryLastModified DESC $limitClause";
				} else {
					$queryContentTestList = "
					SELECT * FROM nisekocms_content 
					WHERE contentCategoryKey = '$contentCategoryKey'
						AND entryPublished = 1 
						AND entryPublishStartDate <= '$currentDate' 
						AND (entryPublishEndDate >= '$currentDate' OR entryPublishEndDate = '0000-00-00')
						AND siteID = '$_SESSION[siteID]'
					ORDER BY entryLastModified DESC
					$limitClause";
				}
			}
	
	
	
	
	
	
	
	$resultContentTestList = mysql_query($queryContentTestList);
	
	
	
	$numberOfPages = mysql_num_rows($resultContentTestList);
	
	
	
	
	if (is_authed()) { $rowSpan = 7; } else{ $rowSpan = 5; }
		
		echo '<table style="' . $tableStyleAttribute . '">';
		
			echo '<tr>';
					echo '<td class="fieldLabelLeft" colspan="' . $rowSpan . '">';
						echo '<h2 style="margin:0px;">';
							
								if (is_authed() && $_SESSION['siteNetwork'] == 'nisekopass') {
									echo '<a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . 'token=' . $_SESSION['userToken'] . '">' . agileResource('theKutchannel') . '</a>';
								} elseif (!is_authed() && $_SESSION['siteNetwork'] == 'nisekopass') {
									echo '<a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . '">' . agileResource('niseko') . '</a>';
								} else {
									echo '<a href="/' . languageUrlPrefix();
										if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
									echo '">' . getSiteTitle() . '</a>';
								}
								
							echo ' &rarr; ';
							echo agileResource(getContentListTitle($contentCategoryKey));
						echo '</h2>';
					echo '</td>';
			echo '</tr>';
			
			echo '<tr>';
					echo '<td class="fieldLabelLeft" colspan="' . $rowSpan . '">';
						echo '<h2 style="margin:0px;">';
							echo '<a href="' . languageUrlPrefix() . getContentNewCrudURL($contentCategoryKey) . '"';
								if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
							echo '>' . agileResource(getContentNewCrudTitle($contentCategoryKey)) . '</a>';
						echo '</h2>';
					echo '</td>';
			echo '</tr>';
		
			echo '<tr>';
					echo '<td class="fieldLabelCenter">' . agileResource('username') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('title') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('date') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('views') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('replies') . '</td>';
					if (is_authed()) { 
						echo '<td class="fieldLabelCenter">' . agileResource('public') . '</td>';
						echo '<td class="fieldLabelCenter">' . agileResource('action') . '</td>';
					}
			echo '</tr>';
		
			while($rowContentTestList = mysql_fetch_array($resultContentTestList)) {
			
				$replyCount = 0;
				$replyCount = getContentTotalReplyCount($rowContentTestList['entryID']);
				
				echo '<tr>';
					echo '<td class="borderAlignLeft">' . getUserName($rowContentTestList['entrySubmittedByUserID']) . '</td>';
					echo '<td class="borderAlignLeft">';
						echo '<a href="' . languageUrlPrefix() . getContentListURL($contentCategoryKey) . $rowContentTestList['entryID'] . '/';
							if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
						echo '">';
							echo getContentTitle($rowContentTestList['entryID']);
						echo '</a>';
					echo '</td>';
					echo '<td class="borderAlignCenter">' . date('Y-m-d', strtotime($rowContentTestList['entrySubmissionDateTime'])) . '</td>';
					echo '<td class="borderAlignCenter">' . $rowContentTestList['entryViews'] . '</td>';
					
					
					echo '<td class="borderAlignCenter">';
						
						if ($replyCount != 0) { echo $replyCount; }
					echo '</td>';
					
					if (is_authed()) { 
						echo '<td class="borderAlignCenter">';
							if ($rowContentTestList['entryPublished'] == 1) { echo '&#10004;'; }
						echo '</td>';
						echo '<td class="borderAlignCenter">';
							if (userOwnsContent($rowContentTestList['entryID'])) {
								echo '<a href="' . languageUrlPrefix() . getContentUpdateCrudURL($contentCategoryKey) . $rowContentTestList['entryID'] . '/">';
									echo agileResource(getContentUpdateCrudTitle($contentCategoryKey));
								echo '</a>';
							} elseif ($_SESSION['userRoleForCurrentSite'] == 'siteManager') {
								echo '<a href="' . languageUrlPrefix() . getContentUpdateCrudURL($contentCategoryKey) . $rowContentTestList['entryID'] . '/">';
									echo agileResource('moderateContent');
								echo '</a>';
							}
						echo '</td>';
					}
				echo '</tr>';
			}
		echo '</table>';
		
		// if ($_SESSION['testMode'] == 'on') {
			// echo '<br />' . $queryContentTestList;
		// }
}

function displayContentTestCrud(
	$type = 'create', 
	$contentCategoryKey = '', 
	$entryID = 0, 
	$entryTitleEnglish = '', 
	$entryTitleJapanese = '',
	$entryPublished = 1, 
	$entryContentEnglish = '',
	$entryContentJapanese = '',
	$entryPublishStartDate = '',
	$entryPublishEndDate = '',
	$isEvent = 0,
	$eventDate = '',
	$eventStartTime = '',
	$eventEndTime = ''
) {


	if ($type == 'create') {
		$formAction = languageUrlPrefix() . getContentNewCrudUrl($contentCategoryKey);
		$crudTitle = getContentNewCrudTitle($contentCategoryKey);
		$entryPublishStartDate = date('Y-m-d');
		$entryPublishEndDate = '2020-12-31';
		if ($contentCategoryKey == 'events') { $isEvent = 1; }
	} elseif ($type == 'update') {
		$formAction = languageUrlPrefix() . getContentUpdateCrudUrl($contentCategoryKey) . $entryID . '/';
		$crudTitle = getContentUpdateCrudTitle($contentCategoryKey);
	}

	echo '<form name="nisekocms_content_form" method="post" action="' . $formAction . '" enctype="multipart/form-data">';
	echo '<table style="margin:5px auto 5px auto;background-color:#fff;">';
	
	
	if ($type == 'update') { echo '<input type="hidden" name="entryID" value="' . $entryID . '">'; }
	echo '<input type="hidden" name="contentCategoryKey" value="' . $contentCategoryKey . '">';
	
		echo '<tr>';
			echo '<td class="fieldLabelLeft" colspan="6">';
				echo '<h1 style="margin:0px;">' . agileResource($crudTitle) . '</h1>';
			echo '</td>';
		echo '</tr>';
		
		echo '<tr>';
			
			echo '<td class="fieldLabelCenter">' . agileResource('publishStartDate') . '</td>';
			echo  '<td class="fieldLabelCenter">';
				displayDateInput($entryPublishStartDate, 'entryPublishStartDate', 1, 100);
			echo '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('publishEndDate') . '</td>';
			echo  '<td class="fieldLabelCenter">';
				displayDateInput($entryPublishEndDate, 'entryPublishEndDate', 1, 100);
			echo '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('publish') . '</td>';
			echo  '<td class="fieldLabelCenter">';
				echo '<input type="checkbox" name="entryPublished" value="1"';
					if ($entryPublished == 1) { echo ' checked'; }
				echo '>';
			echo '</td>';
		echo '</tr>';
		
		
		
			
		
			if ($type == 'update') {

				$queryContentImages = "
					SELECT fileID, fileName, filePath, fileSize
					FROM nisekocms_fileIndex 
					WHERE fileObject = 'nisekocms_content'
					AND fileObjectID = '$entryID'
					ORDER BY fileSubmissionDateTime DESC
				";
				$resultContentImages = mysql_query($queryContentImages);
				$numberOfImages = mysql_num_rows($resultContentImages);
				if ($numberOfImages > 0) {
				
					echo '<tr>';
						echo '<td class="fieldLabelLeft" colspan="6">';
							echo '<b>' . agileResource('images') . '</b>';
						echo '</td>';
					echo '</tr>';
					
					while ($rowContentImages = mysql_fetch_array($resultContentImages)) {
					
						
					
						$fileID =  $rowContentImages['fileID'];
						$filePath = $rowContentImages['filePath'];
						$fileName = $rowContentImages['fileName'];
						$fileSize = $rowContentImages['fileSize'];

						$imageSizeArray = array();
						$imageSizeArray = agileImageScale($filePath, 50, 30);
						echo '<tr>';
							echo '<td class="borderAlignCenter" colspan="1">';
							
								echo '<div>';
									echo '<img src="/image/' . $fileID . '/" style="width:' . $imageSizeArray[1] . 'px;height:' . $imageSizeArray[2] . 'px;margin:2px;">';
								echo '</div>';
							echo '</td>';
							
							echo '<td class="borderAlignLeft" colspan="3">' . $fileName . ' (' . formatBytes($fileSize) . ')</td>';
							echo '<td class="borderAlignCenter">' . agileResource('imageDelete') . '</td>';
							echo  '<td class="borderAlignCenter"><input type="checkbox" name="deleteImage[' . $fileID . ']"></td>';
						echo '</tr>';

					}

				}

			}
			
			
			echo '<tr>';
				echo '<td class="fieldLabelCenter">';
					echo '<b>' . agileResource('images') . '</b>';
				echo '</td>';
				echo '<td class="fieldLabelLeft" colspan="5">';
					echo '<i>' . agileResource('upTo2MBeach') . '</i>';
				echo '</td>';
			echo '</tr>';
						
			echo '<tr>';
				echo '<td class="fieldLabelCenter" colspan="1">' . agileResource('imageUpload1') . '</td>';
				echo '<td class="fieldLabelLeft" colspan="5"><input type="file" name="contentImage[]"></td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td class="fieldLabelCenter" colspan="1">' . agileResource('imageUpload2') . '</td>';
				echo '<td class="fieldLabelLeft" colspan="5"><input type="file" name="contentImage[]"></td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td class="fieldLabelCenter" colspan="1">' . agileResource('imageUpload3') . '</td>';
				echo '<td class="fieldLabelLeft" colspan="5"><input type="file" name="contentImage[]"></td>';
			echo '</tr>';

			
		// if ($_SESSION['userID'] == 2) {
			echo '<tr>';
				
				echo '<td class="fieldLabelCenter">';
				
					echo '<b>' . agileResource('Calendar') . '</b>';
				echo '</td>';
				echo '<td class="fieldLabelLeft" colspan="5">';
					echo '<i>';
						echo agileResource('isThisAnEvent');
						echo '&nbsp;';
						echo '<input type="radio" name="isEvent" value="1"';
							if ($isEvent == 1) { echo ' checked'; }
						echo ' onChange="toggle(\'contentEventInput\')">' . agileResource('yes');
						echo '&nbsp;';
						echo '<input type="radio" name="isEvent" value="0"';
							if ($isEvent == 0) { echo ' checked'; }
						echo ' onChange="toggle(\'contentEventInput\')">' . agileResource('no');
					echo '</i>';
					
					// echo '<br />';
					
					echo '<div id="contentEventInput" style="display:';
						if ($isEvent == '1') { echo 'block'; } else { echo 'none'; }
					echo ';">';
						echo '<hr />';
						echo agileResource('eventDate') . '&nbsp;';
						displayDateInput($eventDate, 'eventDate', 1, 100);
						echo '<br />';
						echo agileResource('eventStartTime') . '&nbsp;';
						displayTimeOnlyInput($eventStartTime, 'eventStartTime');
						echo '&nbsp;' . agileResource('eventEndTime') . '&nbsp;';
						displayTimeOnlyInput($eventEndTime, 'eventEndTime');
					echo '</div>';
					
				echo '</td>';
				
			echo '</tr>';
		// }
			
			
			
			
		echo '<tr>';
			echo '<td class="fieldLabelRight" style="background-color:#fff;" colspan="6">';
				echo '<b>' . agileResource('english') . '</b>';
			echo '</td>';
		echo '</tr>';
					
		echo '<tr>';
			echo '<td class="fieldLabelCenter">' . agileResource('entryTitleEnglish') . '</td>';
			echo '<td class="fieldLabelLeft" colspan="5">';
				echo '<input type="text" name="entryTitleEnglish" value="';
					echo $entryTitleEnglish;
				echo '" style="width:350px;">';	
			echo '</td>';
		echo '</tr>';
	
		echo '<tr>';
			echo '<td class="fieldLabelCenter" colspan="6">';
				echo '<textarea name="entryContentEnglish" placeholder="' . agileResource('contentEnglish') . '" style="width:500px;height:300px;">'; // echo ' class="ckeditor"';
					echo $entryContentEnglish;
				echo '</textarea>';
			echo '</td>';
		echo '</tr>';
		
		echo '<tr>';
			echo '<td class="fieldLabelRight" style="background-color:#fff;" colspan="6">';
				echo '<b>' . agileResource('japanese') . '</b>';
			echo '</td>';
		echo '</tr>';
		
		echo '<tr>';
			echo '<td class="fieldLabelCenter">' . agileResource('entryTitleJapanese') . '</td>';
			echo '<td class="fieldLabelLeft" colspan="5">';
				echo '<input type="text" name="entryTitleJapanese" value="';
					echo $entryTitleJapanese;
				echo '" style="width:350px;">';	
			echo '</td>';
		echo '</tr>';
	
		echo '<tr>';
			echo '<td class="fieldLabelCenter" colspan="6">';
				echo '<textarea name="entryContentJapanese" placeholder="' . agileResource('contentJapanese') . '" style="width:500px;height:300px;">'; // echo ' class="ckeditor"';
					echo $entryContentJapanese;
				echo '</textarea>';
			echo '</td>';
		echo '</tr>';

		
		
		echo '<tr>';
			echo '<td class="fieldLabelRight" colspan="6">';
				echo '<input type="submit" name="submit" value="' . agileResource($crudTitle) . '">';
			echo '</td>';
		echo '</tr>';
	
	echo '</table>';
	echo '</form>';

}

function displayContentTestView($entryID, $tableStyleAttribute = 'margin:5px auto 5px auto;background-color:#fff;') {

		addOneToPageViewContent($entryID);
		$contentCategoryKey = getContentCategoryKey($entryID);
		$currentDate = date('Y-m-d');
		$query = "SELECT * FROM nisekocms_content WHERE entryID = '$entryID' LIMIT 1";
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result)) {
			$entryTitleEnglish = $row['entryTitleEnglish'];
			$entryTitleJapanese = $row['entryTitleJapanese'];
			$entryPublishStartDate = $row['entryPublishStartDate'];
			$entryPublishEndDate = $row['entryPublishEndDate'];
			$entryPublished = $row['entryPublished'];
			$entryContentEnglish = $row['entryContentEnglish'];
			$entryContentJapanese = $row['entryContentJapanese'];
			$entrySubmittedByUserID = $row['entrySubmittedByUserID'];
			$entrySubmissionDateTime = $row['entrySubmissionDateTime'];
			$contentCoordinates = $row['contentCoordinates'];
			
			$isEvent = $row['isEvent'];
			$eventDate = $row['eventDate'];
			$eventStartTime = $row['eventStartTime'];
			$eventEndTime = $row['eventEndTime'];
		}

		
		// if ($_SESSION['userID'] == 2) {
			if (is_authed()) {
			
				$queryNextArticle = "
				SELECT * FROM nisekocms_content WHERE contentCategoryKey = '$contentCategoryKey' AND siteID = '$_SESSION[siteID]' AND (entrySubmittedByUserID = '$_SESSION[userID]' OR (entryPublished = '1' AND entryPublishStartDate <= '$currentDate' AND (entryPublishEndDate >= '$currentDate' OR entryPublishEndDate = '0000-00-00'))) AND entrySubmissionDateTime > '$entrySubmissionDateTime' ORDER BY entrySubmissionDateTime ASC LIMIT 1";
				
				$queryPreviousArticle = "
				SELECT * FROM nisekocms_content WHERE contentCategoryKey = '$contentCategoryKey' AND siteID = '$_SESSION[siteID]' AND (entrySubmittedByUserID = '$_SESSION[userID]' OR (entryPublished = '1' AND entryPublishStartDate <= '$currentDate' AND (entryPublishEndDate >= '$currentDate' OR entryPublishEndDate = '0000-00-00'))) AND entrySubmissionDateTime < '$entrySubmissionDateTime' ORDER BY entrySubmissionDateTime DESC LIMIT 1";
				
			} else {
			
				$queryNextArticle = "
				SELECT * FROM nisekocms_content WHERE contentCategoryKey = '$contentCategoryKey' AND entryPublished = 1 AND entryPublishStartDate <= '$currentDate' AND (entryPublishEndDate >= '$currentDate' OR entryPublishEndDate = '0000-00-00') AND siteID = '$_SESSION[siteID]' AND entrySubmissionDateTime > '$entrySubmissionDateTime' ORDER BY entrySubmissionDateTime ASC LIMIT 1";
				
				$queryPreviousArticle = "
				SELECT * FROM nisekocms_content WHERE contentCategoryKey = '$contentCategoryKey' AND entryPublished = 1 AND entryPublishStartDate <= '$currentDate' AND (entryPublishEndDate >= '$currentDate' OR entryPublishEndDate = '0000-00-00') AND siteID = '$_SESSION[siteID]' AND entrySubmissionDateTime < '$entrySubmissionDateTime' ORDER BY entrySubmissionDateTime DESC LIMIT 1";
				
			}
			
			$resultNextArticle = mysql_query($queryNextArticle);
			if (mysql_num_rows($resultNextArticle) == 1) {
				$rowNextArticle = mysql_fetch_array($resultNextArticle);
				$nextURL = '/' . languageUrlPRefix() . getContentListURL($contentCategoryKey) . $rowNextArticle['entryID'] . '/';
				$nextEntryID = $rowNextArticle['entryID'];
			} else { $nextURL = 'none'; }

			$resultPreviousArticle = mysql_query($queryPreviousArticle);
			if (mysql_num_rows($resultPreviousArticle) == 1) {
				$rowPreviousArticle = mysql_fetch_array($resultPreviousArticle);
				$previousURL = '/' . languageUrlPRefix() . getContentListURL($contentCategoryKey) . $rowPreviousArticle['entryID'] . '/';
				$previousEntryID = $rowPreviousArticle['entryID']; 
			} else { $previousURL = 'none'; }

		// }
		
		
		
		
		
		
		
		if (
			($_SESSION['userID'] != $entrySubmittedByUserID && $_SESSION['userRoleForCurrentSite'] != 'siteManager') && $entryPublished != 1
		) {
			echo agileResource('thisPostIsNoLongerAvailable');
		} else {
		
			if (is_authed() && $contentCategoryKey != 'static') { echo '<form method="post" action="' . languageUrlPrefix() . 'comment-on-content/' . $entryID . '/">'; }
			
			
			
			echo '<table style="' . $tableStyleAttribute . 'table-layout:fixed;">';

				if ($entryPublished == 0) {
					echo '<tr>';
						echo '<td class="fieldLabelCenter" style="background-color:#f00;color:#fff;">';
							echo agileResource('thisPostIsNotCurrentlyPublished');
						echo '</td>';
					echo '</tr>';
				}
				
				echo '<tr>';
						echo '<td class="fieldLabelLeft" colspan="' . $rowSpan . '">';
							echo '<h2 style="margin:0px;">';
								
									if (is_authed() && $_SESSION['siteNetwork'] == 'nisekopass') {
										echo '<a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . 'token=' . $_SESSION['userToken'] . '">' . agileResource('theKutchannel') . '</a>';
									} elseif (!is_authed() && $_SESSION['siteNetwork'] == 'nisekopass') {
										echo '<a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . '">' . agileResource('niseko') . '</a>';
									} else {
										echo '<a href="/' . languageUrlPrefix();
											if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
										echo '">' . getSiteTitle() . '</a>';
									}
									
								echo ' &rarr; ';
								echo '<a href="/' . languageUrlPrefix() . getContentListURL($contentCategoryKey) . '';
									if (is_authed()) { echo 'token=' . $_SESSION['userToken']; }
								echo '">';
									echo agileResource(getContentListTitle($contentCategoryKey));
								echo '</a>';
								
								echo ' &rarr; ';
								if ($_SESSION['lang'] == 'ja') { echo $entryTitleJapanese; } else { echo $entryTitleEnglish; }
								
							echo '</h2>';
						echo '</td>';
				echo '</tr>';
			
				echo '<tr>';
					echo '<td class="fieldLabelCenter">';
						echo '<div>';
						
							if ($nextURL != 'none') {
								echo '<div style="float:left;margin:1px;width:36px;">';
									echo '<a href="' . $nextURL . '"><img src="/agileImages/Nav-LeftArrow.png" alt="' . agileResource('nextArticle') . ' - ' . $nextEntryID . '" style="height:35px;"></a>';
								echo '</div>';
							}
							
							if ($previousURL != 'none') {
								echo '<div style="float:right;margin:1px;width:36px;">';
									echo '<a href="' . $previousURL . '"><img src="/agileImages/Nav-RightArrow.png" alt="' . agileResource('previousArticle') . ' - ' . $previousEntryID . '" style="height:35px;"></a>';
								echo '</div>';
							}
							
							// echo '<h2 style="margin:0px;">';
								// if ($_SESSION['lang'] == 'ja') { echo $entryTitleJapanese; } else { echo $entryTitleEnglish; }
							// echo '</h2>';
							if (is_authed() && $entrySubmittedByUserID == $_SESSION['userID']) {
								echo 'Thanks for posting, <a href="/' . languageUrlPrefix() . 'user/' . $entrySubmittedByUserID . '/">' . getUserName($entrySubmittedByUserID) . '</a>!';
								echo '&nbsp;';
								echo '[<a href="' . getContentUpdateCrudURL($contentCategoryKey) . $entryID . '/">';
									echo agileResource(getContentUpdateCrudTitle($contentCategoryKey));
								echo '</a>]';
								
							} else {
								echo 'Posted by <a href="/' . languageUrlPrefix() . 'user/' . $entrySubmittedByUserID . '/">' . getUserName($entrySubmittedByUserID) . '</a> at ' . $entrySubmissionDateTime . '.';
							}
							
							if ($isEvent == 1) {
							
								echo '<div style="font-weight:bold;">';
									echo agileResource('thisIsAnEvent') . ' ';
									echo $eventDate;
									if ($eventStartTime != '00:00:00') { echo ' ' . $eventStartTime . '~'; }
									if ($eventStartTime != '00:00:00' && $eventEndTime != '00:00:00') { echo $eventEndTime; }
								echo '</div>';
							
							}
						echo '</div>';
					echo '</td>';
				echo '</tr>';
				

				// if ($_SESSION['userID'] == 2) {
					$queryContentImages = "
						SELECT fileID, fileName, filePath 
						FROM nisekocms_fileIndex 
						WHERE fileObject = 'nisekocms_content'
						AND fileObjectID = '$entryID'
						ORDER BY fileSubmissionDateTime DESC
					";
					$resultContentImages = mysql_query($queryContentImages);
					if (mysql_num_rows($resultContentImages) > 0) {
					
						echo '<tr>';
							echo '<td class="borderAlignCenter">';
								
								echo '<div id="basic" class="masonryDiv">';
								// echo '<div style="white-space:pre-line;overflow:auto;">';
								
									while ($rowContentImages = mysql_fetch_array($resultContentImages)) {
									
										$fileID =  $rowContentImages['fileID'];
										$filePath = $rowContentImages['filePath'];
										$fileName = $rowContentImages['fileName'];

										$imageSizeArray = array();
										$imageSizeArray = agileImageScale($filePath, 720, 100);

										echo '<a href="/' . languageUrlPrefix() . 'image/view/' . $fileID . '/">';
											echo '<img src="/image/' . $fileID . '/" style="width:' . $imageSizeArray[1] . 'px;height:' . $imageSizeArray[2] . 'px;margin:2px;">';
										echo '</a>';

									}
								echo '</div>';
							echo '</td>';
						echo '</tr>';
						
					}
				// }
		
			echo '<tr>';
				echo '<td class="borderAlignLeft">';
					echo '<div style="white-space:pre-line;overflow:auto;">';
						if ($_SESSION['lang'] == 'ja') { echo $entryContentJapanese; } else { echo $entryContentEnglish; }
					echo '</div>';
				echo '</td>';
			echo '</tr>';
			
			
			
			
			if ($contentCoordinates != '') {
				echo '<tr>';
					echo '<td class="borderAlignLeft">';
						// echo '<div style="white-space:pre-line;overflow:auto;">';
							echo '<iframe width="100%" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/?q=' . $contentCoordinates . '&amp;ie=UTF8&amp;t=h&amp;z=14&amp;ll=' . $contentCoordinates . '&amp;output=embed"></iframe>';
						// echo '</div>';
					echo '</td>';
				echo '</tr>';
			}
			
			
			

			$queryGetThisContentsComments = "SELECT * FROM nisekocms_contentComment WHERE siteID = '$_SESSION[siteID]' AND contentID = '$entryID' ORDER BY commentDateTime ASC";
			$resultGetThisContentsComments = mysql_query($queryGetThisContentsComments);
			while ($rowGetThisContentsComments = mysql_fetch_array($resultGetThisContentsComments)) {
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . getUserName($rowGetThisContentsComments['userID']) . ' <i>' . $rowGetThisContentsComments['commentDateTime'] . '</i></td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="borderAlignLeft">';
						echo '<div style="white-space:pre-line;overflow:auto;">';
							echo $rowGetThisContentsComments['commentContent'];
						echo '</div>';
					echo '</td>';
				echo '</tr>';
			}
			
			if (is_authed()) {
			
				
				if ($contentCategoryKey != 'static') { // no WYSIWYG for static pages

					echo '<tr>';
					echo '<input type="hidden" name="entryID" value="' . $entryID . '">';
						echo '<td class="fieldLabelCenter">';
							echo '<textarea name="commentContent" style="width:640px;height:150px;margin:10px;"></textarea>';
						echo '</td>';
					echo '</tr>';
			
					echo '<tr>';
						echo '<td class="fieldLabelRight">';
							echo '<input type="submit" name="submit" value="' . agileResource('submitComment') . '">';
						echo '</td>';
					echo '</tr>';
				}
				
			} else {
			
				echo '<tr>';
					echo '<td class="fieldLabelCenter">' . agileResource('youMustbeLoggedInToComment') . '</td>';
				echo '</tr>';
				
			}
		
		echo '</table>';
		if (is_authed() && $contentCategoryKey != 'static') { echo '</form>'; }
		
	}
	

}

function createContentComment($contentID, $commentContent) {

	$siteID = $_SESSION['siteID'];
	$userID = $_SESSION['userID'];
	$commentDateTime = date('Y-m-d H:i:s');
	
	$queryInsertContentComment = "INSERT INTO nisekocms_contentComment (
			contentID,
			siteID,
			userID, 
			commentDateTime, 
			commentContent
		) VALUES (
			'$contentID',
			'$siteID',
			'$userID',
			'$commentDateTime', 
			'$commentContent'
		)";
	mysql_query($queryInsertContentComment) or die ($queryInsertContentComment);
	
	// agileMail($toAddress, $fromAddress, $mailSubject, $mailMessage, $siteID, $userID);
	
	postToAuditTrail($auditTrailUserName, 'commentedOnContent', 'successful', '', $commentContent, 'contentComment', $contentID, '');

}
	
function addOneToPageViewContent($entryID) {

	$query = "UPDATE nisekocms_content SET entryViews = entryViews + 1 WHERE entryID = '$entryID' LIMIT 1";
	mysql_query($query);

}
	
function getContentTitle($entryID) {
	$query = "SELECT * FROM nisekocms_content WHERE entryID = '$entryID' LIMIT 1";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result)) {
		if ($_SESSION['lang'] == 'ja') {
			$contentTitle = $row['entryTitleJapanese'];
		} else {
			$contentTitle = $row['entryTitleEnglish'];
		}
	}
	return $contentTitle;
}

function getContentTotalReplyCount($entryID) {
	$query = "SELECT * FROM nisekocms_contentComment WHERE siteID = '$_SESSION[siteID]' AND contentID = '$entryID'";
	$result = mysql_query($query);
	$contentTotalReplyCount = mysql_num_rows($result);
	return $contentTotalReplyCount;
}

function displayEasyContentModule($entryID, $divStyleAttribute) {

	$resultGetContent = "SELECT * FROM nisekocms_content WHERE entryID = '$entryID' LIMIT 1";
	$resultGetContent = mysql_query($resultGetContent);
	while($rowGetContent = mysql_fetch_array($resultGetContent)) {
		echo '<div style="' . $divStyleAttribute . '">';
			if ($_SESSION['lang'] == 'ja') {
				echo $rowGetContent['entryContentJapanese'];
			} else {
				echo $rowGetContent['entryContentEnglish'];
			}
		echo '</div>';
	}
	
}

function getContentCategoryName($contentCategoryKey) {
	$query = "SELECT * FROM nisekocms_contentCategory WHERE contentCategoryKey = '$contentCategoryKey' LIMIT 1";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result)) {
		if ($_SESSION['lang'] == 'ja') { $contentCategoryName = $row['contentCategoryJapanese']; } else { $contentCategoryName = $row['contentCategoryEnglish']; }
	}
	return $contentCategoryName;
}

function getContentMetaDescription($entryID) {
	$query = "SELECT * FROM nisekocms_content WHERE entryID = '$entryID' LIMIT 1";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result)) {
		if ($_SESSION['lang'] == 'ja') { $metaDescriptionNama = $row['entryContentJapanese']; } else { $metaDescriptionNama = $row['entryContentEnglish']; }
		$metaDescription = agileTruncate(htmlspecialchars(strip_tags(str_replace(array("\r\n", "\r", "\n"), " ", $metaDescriptionNama))), 200);
	}
	return $metaDescription;
}

function getContentSiteID($entryID) {
	$query = "SELECT siteID FROM nisekocms_content WHERE entryID = '$entryID' LIMIT 1";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result)) { $siteID = $row['siteID']; }
	return $siteID;
}

function contentCategoryExistsAndIsEnabledForCurrentSite($contentCategory_listURL) {

	$query = "SELECT contentCategoryKey FROM nisekocms_contentCategory WHERE contentCategory_listURL = '$contentCategory_listURL' LIMIT 1";
	// echo $query;
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 0) { return false; } else {
		$row = mysql_fetch_array($result);
		$queryCheckSiteContentCategory = "
			SELECT * FROM jaga_siteContentCategory 
			WHERE siteID = '$_SESSION[siteID]' 
			AND contentCategoryKey = '$row[contentCategoryKey]' 
			LIMIT 1
		";
		$resultCheckSiteContentCategory = mysql_query($queryCheckSiteContentCategory);
		if (mysql_num_rows($resultCheckSiteContentCategory) == 0) { return false; } else { return true; }
	}

}

?>