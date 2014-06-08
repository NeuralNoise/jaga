<?php

function displayProjectList() {

		$userProjects = join(",", $_SESSION['userProjectArray']);
		if ($_SESSION['lang'] == 'ja') {
			$query = "SELECT * FROM shigoto_project WHERE projectID in ($userProjects) ORDER BY projectNameJapaneseReading";
		} else {
			$query = "SELECT * FROM shigoto_project WHERE projectID in ($userProjects) ORDER BY projectNameEnglish";
		}
		
		$result = mysql_query($query);
		
		// echo '<div style="text-align:center;">';
			echo '<table style="width:100%;margin:0px auto 0px auto;background-color:#fff;">';
				echo '<tr>';
				
					echo '<td class="borderAlignLeft" colspan="5">';
						echo '<input type="button" value="Create New Project" onclick="window.location.href=\'projects/create/\'">';
					echo '</td>';
				echo '</tr>';
				
				
				if ($_SESSION['testMode'] == 'on') {
					echo '<tr>';
						echo '<td class="borderAlignLeft" colspan="5">';
							echo $query;
						echo '</td>';
					echo '</tr>';
				}
				
				
				echo '<tr>';
					echo '<td class="fieldLabel">' . agileResource('projectID') . '</td>';
					echo '<td class="fieldLabel">' . agileResource('projectName') . '</td>';
					echo '<td class="fieldLabel">' . agileResource('tasks') . '</td>';
					echo '<td class="fieldLabel">' . agileResource('timelog') . '</td>';
					echo '<td class="fieldLabel">' . agileResource('action') . '</td>';
				echo '</tr>';

				
			$rowBackgroundCounter = 1;
			while($row = mysql_fetch_array($result)) {
				$projectID = $row['projectID'];
				echo '<tr';
						if ($rowBackgroundCounter % 2) { echo ' style="background-color:#eee;"'; }
				echo '>';
				
					echo '<td class="borderAlignCenter">' . $projectID . '</td>';
					echo '<td class="borderAlignLeft">' . getProjectName($projectID) . '</td>';
					echo '<td class="borderAlignCenter">';
							echo '<a href="' . languageUrlPrefix() . 'task/project/' . $projectID . '/">' . agileResource('tasks') . ' (' . getNumberOfTasksForThisProject($projectID) . ')</a>';
					echo '</td>';
					echo '<td class="borderAlignCenter">';
							echo '<a href="' . languageUrlPrefix() . 'timelog/project/' . $projectID . '/">' . agileResource('timelog') . ' (' . getThisProjectsTotalHours($projectID) . ')</a>';
					echo '</td>';
					echo '<td class="borderAlignCenter">';
						if ($row['projectCreatedByUserID'] == $_SESSION['userID']) {
							echo '<a href="' . languageUrlPrefix() . 'projects/update/' . $row['projectID'] . '/">' . agileResource('manage') . '</a>';
						}
					echo '</td>';
				echo '</tr>';
				$rowBackgroundCounter = $rowBackgroundCounter + 1;
			}

			echo '</table>';
		// echo '</div>';
		
}

function displayGroupList() {

	echo '<table style="width:100%;margin:0px auto 0px auto;background-color:#fff;">';
		
			if ($_SESSION['lang'] == 'ja') {
				$resultGetGroups = mysql_query("SELECT * FROM shigoto_group WHERE siteID = '$_SESSION[siteID]' ORDER BY groupNameJapanese ASC");
			} else {
				$resultGetGroups = mysql_query("SELECT * FROM shigoto_group WHERE siteID = '$_SESSION[siteID]' ORDER BY groupNameEnglish ASC");
			}
			
			while($rowGetGroup = mysql_fetch_array($resultGetGroups)) {
						
				echo '<tr>';
				
					echo '<td class="borderAlignCenter">' . $rowGetGroup['groupID'] . '</td>';
					echo '<td class="borderAlignLeft">' . getGroupName($rowGetGroup['groupID']) . '</td>';
					echo '<td class="borderAlignLeft">' . getUserName($rowGetGroup['groupCreatedByUserID']) . '</td>';
					echo '<td class="borderAlignCenter">' . $rowGetGroup['groupCreationDateTime'] . '</td>';
					
					echo '<td class="borderAlignCenter">';
						echo '<a class="agileTooltip">';
							$resultGetGroupUsers = mysql_query("SELECT * FROM shigoto_groupUser WHERE groupID = $rowGetGroup[groupID]");
							if (mysql_num_rows($resultGetGroupUsers) != 0) { echo '<span><p style="text-align:left;">'; }
							while($rowGetGroupUser = mysql_fetch_array($resultGetGroupUsers)) { echo getUserName($rowGetGroupUser['userID']) . '<br />'; }
							if (mysql_num_rows($resultGetGroupUsers) != 0) { echo '</p></span>'; }
							echo agileResource('members');
							echo '&nbsp;';
							echo '(' . mysql_num_rows($resultGetGroupUsers) . ')';
						echo '</a>';
					echo '</td>';
					
					echo '<td class="borderAlignCenter">';
						echo '<a class="agileTooltip">';
							$resultGetGroupProjects = mysql_query("SELECT * FROM shigoto_project WHERE groupID = $rowGetGroup[groupID]");
							if (mysql_num_rows($resultGetGroupProjects) != 0) { echo '<span><p style="text-align:left;">'; }
							while($rowGetGroupProject = mysql_fetch_array($resultGetGroupProjects)) { echo getProjectName($rowGetGroupProject['projectID']) . '<br />'; }
							if (mysql_num_rows($resultGetGroupProjects) != 0) { echo '</p></span>'; }
							echo agileResource('projects');
							echo '&nbsp;';
							echo '(' . mysql_num_rows($resultGetGroupProjects) . ')';
						echo '</a>';
					echo '</td>';
					
				echo '</tr>';
			}
					
		echo '</table>';
		
}

function displayProjectCrud($action = 'create', $projectID = 0) {

	if ($action == 'update') {
		$result = mysql_query("SELECT * FROM shigoto_project WHERE projectID = $projectID LIMIT 1");
		while($row = mysql_fetch_array($result)) {
			$projectID = $row['projectID'];
			$projectNameEnglish = $row['projectNameEnglish'];
			$projectNameJapanese = $row['projectNameJapanese'];
			$projectNameJapaneseReading = $row['projectNameJapaneseReading'];
			$groupID = $row['groupID'];
		}
	} else {
		$projectNameEnglish = '';
		$projectNameJapanese = '';
		$projectNameJapaneseReading = '';
		$groupID = 0;
	}

	echo '<div style="text-align:center;">';
		echo '<form name="shigoto_project_master" method="post" action="' . languageUrlPrefix() . 'projects/' . $action . '/">';
		if ($action == 'update') { echo '<input type="hidden" name="projectID" value="' . $projectID . '">'; }
		echo '<table style="margin:5px auto 5px auto;background-color:#fff;">';
		
			echo '<tr>';
				echo '<td class="fieldLabelLeft">' . agileResource('groupName') . '</td>';
				echo '<td class="borderAlignLeft">';
					if ($action == 'create') {
						displayAgileGroupDropdown($groupID, 'groupID', 0, 100);
					} elseif ($action == 'update') {
						echo getGroupname($groupID);
					}
					
				echo '</td>';
			echo '</tr>';
		
			echo '<tr>';
				echo '<td class="fieldLabelLeft">' . agileResource('projectNameEnglish') . '</td>';
				echo '<td class="borderAlignLeft"><input type="text" name="projectNameEnglish" value="' . $projectNameEnglish . '"></td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td class="fieldLabelLeft">' . agileResource('projectNameJapanese') . '</td>';
				echo '<td class="borderAlignLeft"><input type="text" name="projectNameJapanese" value="' . $projectNameJapanese . '"></td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td class="fieldLabelLeft">' . agileResource('projectNameJapaneseReading') . '</td>';
				echo '<td class="borderAlignLeft"><input type="text" name="projectNameJapaneseReading" value="' . $projectNameJapaneseReading . '"></td>';
			echo '</tr>';

			echo '<tr>';
				echo '<td class="borderAlignRight" colspan="2">';
					echo '<input type="submit" name="submit" value="' . agileResource($action) . '">';
				echo '</td>';
			echo '</tr>';
			
		echo '</table>';
		echo '</form>';
	echo '</div>';

}

function insertProject($groupID, $projectNameEnglish, $projectNameJapanese, $projectNameJapaneseReading) {

	$projectCreatedByUserID = $_SESSION['userID'];
	$projectCreationDateTime = date('Y-m-d H:i:s');
	
	$queryInsertProject = "INSERT INTO shigoto_project (
			projectNameEnglish,
			projectNameJapanese,
			projectNameJapaneseReading,
			projectCreatedByUserID,
			projectCreationDateTime,
			groupID
	) VALUES (
			'$projectNameEnglish',
			'$projectNameJapanese',
			'$projectNameJapaneseReading',
			'$projectCreatedByUserID',
			'$projectCreationDateTime',
			'$groupID'
	)";
	

	mysql_query ($queryInsertProject) or die ('insertProject() failed');
	
}

function updateProject($projectID, $projectNameEnglish, $projectNameJapanese, $projectNameJapaneseReading) {

	$queryUpdateProject = "UPDATE shigoto_project SET
		projectNameEnglish = '$projectNameEnglish',
		projectNameJapanese = '$projectNameJapanese',
		projectNameJapaneseReading = '$projectNameJapaneseReading'
		WHERE projectID = '$projectID' LIMIT 1";
		
	mysql_query ($queryUpdateProject) or die (agileResource('unableToUpdateProject'));

}

function thisUserOwnsThisProject($projectID) {
	$resultThisUserOwnsThisProject = mysql_query("SELECT * FROM shigoto_project WHERE projectID = '$projectID' AND projectCreatedByUserID = '$_SESSION[userID]' LIMIT 1");
	if (mysql_num_rows($resultThisUserOwnsThisProject) == 1) {
		return true;
	}
}

function getTaskName($taskID) {

	$resultGetTaskName = mysql_query("SELECT * FROM shigoto_task WHERE taskID = '$taskID' LIMIT 1");
	while($rowGetTaskName = mysql_fetch_array($resultGetTaskName)) {
		$taskName = $rowGetTaskName['taskName'];
	}
	return $taskName;
}

function getProjectName($projectID) {

	$resultGetProjectName = mysql_query("SELECT * FROM shigoto_project WHERE projectID = '$projectID' LIMIT 1");
	while($rowGetProjectName = mysql_fetch_array($resultGetProjectName)) {
		if ($_SESSION['lang'] == 'ja') {
			$projectName = $rowGetProjectName['projectNameJapanese'];
		} else {
			$projectName = $rowGetProjectName['projectNameEnglish'];
		}
	}
	return $projectName;
}

function getGroupName($groupID) {

	$resultGetGroupName = mysql_query("SELECT * FROM shigoto_group WHERE groupID = '$groupID' LIMIT 1");
	while($rowGetGroupName = mysql_fetch_array($resultGetGroupName)) {
		if ($_SESSION['lang'] == 'ja') {
			$groupName = $rowGetGroupName['groupNameJapanese'];
		} else {
			$groupName = $rowGetGroupName['groupNameEnglish'];
		}
	}
	return $groupName;
}

function getTimeLogClassificationName($classificationID) {


	$resultGetClassificationName = mysql_query("SELECT * FROM shigoto_classification WHERE classificationID = '$classificationID' LIMIT 1");
	while($rowGetClassificationName = mysql_fetch_array($resultGetClassificationName)) {
		if ($_SESSION['lang'] == 'ja') {
			$classificationName = $rowGetClassificationName['classificationJapanese'];
		} else {
			$classificationName = $rowGetClassificationName['classificationEnglish'];
		}
	}
	return $classificationName;
}

function getShigotoStatusName($taskStatusID) {


	$resultGetStatusName = mysql_query("SELECT * FROM shigoto_taskStatus WHERE taskStatusID = '$taskStatusID' LIMIT 1");
	while($rowGetStatusName = mysql_fetch_array($resultGetStatusName)) {
		if ($_SESSION['lang'] == 'ja') {
			$statusName = $rowGetStatusName['taskStatusJapanese'];
		} else {
			$statusName = $rowGetStatusName['taskStatusEnglish'];
		}
	}
	return $statusName;
}

function getShigotoPriorityName($taskPriorityID) {


	$resultGetPriorityName = mysql_query("SELECT * FROM shigoto_taskPriority WHERE taskPriorityID = '$taskPriorityID' LIMIT 1");
	while($rowGetPriorityName = mysql_fetch_array($resultGetPriorityName)) {
		if ($_SESSION['lang'] == 'ja') {
			$priorityName = $rowGetPriorityName['taskPriorityJapanese'];
		} else {
			$priorityName = $rowGetPriorityName['taskPriorityEnglish'];
		}
	}
	return $priorityName;
}

function getShigotoClassificationName($taskClassificationID) {

	$resultGetClassificationName = mysql_query("SELECT * FROM shigoto_classification WHERE classificationID = '$taskClassificationID' LIMIT 1");
	while($rowGetClassificationName = mysql_fetch_array($resultGetClassificationName)) {
		if ($_SESSION['lang'] == 'ja') {
			$classificationName = $rowGetClassificationName['classificationJapanese'];
		} else {
			$classificationName = $rowGetClassificationName['classificationEnglish'];
		}
	}
	return $classificationName;
}

function displayProjectDropdown($projectID) {
	echo '<select name="projectID">';
		echo '<option value="all">' . agileResource('projects') . '</option>';
	
		if ($_SESSION['roleID'] == 'Super Administrator' || $_SESSION['roleID'] == 'Accountant') {
			$resultGetFilteredProjectList = mysql_query( "SELECT * FROM shigoto_project ORDER BY projectNameEnglish ASC" );
		} else {
			$resultGetFilteredProjectList = mysql_query(
				"SELECT * FROM shigoto_projectUser LEFT JOIN shigoto_project ON shigoto_projectUser.projectID = shigoto_project.projectID WHERE shigoto_projectUser.userID = $_SESSION[userID]"
			);
		}
		
		
		
		while($rowGetFilteredProjectList = mysql_fetch_array($resultGetFilteredProjectList)) {
			echo '<option value="' . $rowGetFilteredProjectList['projectID'] . '"';
			
			if ($projectID == $rowGetFilteredProjectList['projectID']) { echo ' selected="selected"'; }
			
			echo '>' . getProjectName($rowGetFilteredProjectList['projectID']) . '</option>';
		}
	echo '</select>';
}

function insertIntoTimeLog(
	$userID, 
	$timeLogRecordedDateTime, 
	$timeLogContributionDate, 
	$timeLogClassificationID, 
	$projectID,
	$taskID,
	$timeLogTime, 
	$timeLogDescription
	) {
	
		$query = "INSERT INTO shigoto_timeLog (
			userID, 
			timeLogRecordedDateTime, 
			timeLogContributionDate, 
			timeLogClassificationID, 
			projectID, 
			taskID,
			timeLogTime, 
			timeLogDescription
		) VALUES (
			'$userID', 
			'$timeLogRecordedDateTime', 
			'$timeLogContributionDate', 
			'$timeLogClassificationID', 
			'$projectID', 
			'$taskID', 
			'$timeLogTime', 
			'$timeLogDescription'
		)";
		
	mysql_query ($query) or die ('Could not create time log entry via function.');

}

function displayPriorityCheckboxes($selectedPriorityID) {

	echo '<b>' . agileResource('Priority') . '</b>';
	echo '&nbsp;';
	$resultGetPriorityCheckboxes = mysql_query("SELECT * FROM shigoto_taskPriority ORDER BY taskPriorityDisplayOrder ASC");
	while ($rowGetPriorityCheckboxes = mysql_fetch_array($resultGetPriorityCheckboxes)) {
		echo '<input type="checkbox" name="selectedPriorityID[]" value="' . $rowGetPriorityCheckboxes['taskPriorityID'] .  '"';
			if (in_array($rowGetPriorityCheckboxes['taskPriorityID'], $selectedPriorityID)) { echo ' checked'; }				
		echo '>';
					
		echo '&nbsp;';
						
		if ($_SESSION['lang'] == 'ja') {
			echo $rowGetPriorityCheckboxes['taskPriorityJapanese'];
		} else {
			echo $rowGetPriorityCheckboxes['taskPriorityEnglish'];
		}
		echo '&nbsp;';
	}

}

function displayStatusCheckboxes($selectedStatusID) {

	echo '<b>' . agileResource('Status') . '</b>';
	echo '&nbsp;';
	$resultGetStatusCheckboxes = mysql_query("SELECT * FROM shigoto_taskStatus ORDER BY taskStatusDisplayOrder ASC");
	while ($rowGetStatusCheckboxes = mysql_fetch_array($resultGetStatusCheckboxes)) {
		echo '<input type="checkbox" name="selectedStatusID[]" value="' . $rowGetStatusCheckboxes['taskStatusID'] .  '"';
			if (in_array($rowGetStatusCheckboxes['taskStatusID'], $selectedStatusID)) { echo ' checked'; }				
		echo '>';
					
		echo '&nbsp;';
						
		if ($_SESSION['lang'] == 'ja') {
			echo $rowGetStatusCheckboxes['taskStatusJapanese'];
		} else {
			echo $rowGetStatusCheckboxes['taskStatusEnglish'];
		}
		echo '&nbsp;';
	}

}

function displayShigotoUserDropdown($selectedUserID = 0, $selectName = 'userID', $displayAllOption = 1, $widthInPixels = 150) {
	echo '<select name="' . $selectName . '" style="width:' . $widthInPixels . 'px">';
	
		if ($displayAllOption == 1) { echo '<option value="all">' . agileResource('users') . '</option>'; }
		
		if ($_SESSION['roleID'] == 'Super Administrator') {
			$resultGetShigotoUserDropdown = mysql_query(
				"SELECT * FROM j00mla_ver4_users ORDER BY name ASC"
			);
		} else {
			$userGroupArray = join(",", $_SESSION['userGroupArray']);
			$resultGetShigotoUserDropdown = mysql_query(
				"SELECT j00mla_ver4_users.id, j00mla_ver4_users.name FROM shigoto_groupUser LEFT JOIN j00mla_ver4_users ON shigoto_groupUser.userID = j00mla_ver4_users.id WHERE shigoto_groupUser.groupID IN ($userGroupArray) GROUP BY shigoto_groupUser.userID ORDER BY shigoto_groupUser.userID;"
			);
		}
		while($rowGetShigotoUserDropdown = mysql_fetch_array($resultGetShigotoUserDropdown)) {
			echo '<option value="' . $rowGetShigotoUserDropdown['id'] . '"';
			
			if ($selectedUserID == $rowGetShigotoUserDropdown['id']) { echo ' selected="selected"'; }
			
			echo '>' . $rowGetShigotoUserDropdown['name'] . '</option>';
		}
	echo '</select>';
}

function displayShigotoUserDropdownThisProjectsGroup($selectedUserID, $projectID, $selectName) {

	// MAKE SURE THIS ONLY SHOWS THIS PROJECT'S GROUP'S USERS EVEN IF USER IS ADMIN OR ACCOUNTANT
	// only members of a project's group may be owners of that project's tasks
	
	$resultGetThisProjectsGroup = mysql_query( "SELECT * FROM shigoto_project WHERE projectID = $projectID LIMIT 1" );
	while($rowGetThisProjectsGroup = mysql_fetch_array($resultGetThisProjectsGroup)) { $groupID = $rowGetThisProjectsGroup['groupID']; }

	$resultGetUserIdArray = mysql_query( "SELECT * FROM shigoto_groupUser WHERE groupID = $groupID" );
	while($rowGetUserIdArray = mysql_fetch_array($resultGetUserIdArray)) { $userArrayID[] = $rowGetUserIdArray['userID']; }
		
	$userWhereClause = join(',',$userArrayID);

	echo '<select name="' . $selectName . '" style="width:150px;">';
		$resultGetUserDropdownForThisGroup = mysql_query( "SELECT * FROM j00mla_ver4_users WHERE id IN ($userWhereClause) ORDER BY name ASC" );
		while($rowGetUserDropdownForThisGroup = mysql_fetch_array($resultGetUserDropdownForThisGroup)) {
			echo '<option value="' . $rowGetUserDropdownForThisGroup['id'] . '"';
				if ($selectedUserID == $rowGetUserDropdownForThisGroup['id']) { echo ' selected="selected"'; }
			echo '>' . $rowGetUserDropdownForThisGroup['name'] . '</option>';
		}
	echo '</select>';
	
}

function displayShigotoPriorityDropdown($selectedPriorityID = 0, $selectName = 'priorityID', $displayAllOption = 1, $widthInPixels = 150) {
	echo '<select name="' . $selectName . '" style="width:' . $widthInPixels . 'px">';

		if ($displayAllOption == 1) { echo '<option value="all">' . agileResource('priority') . '</option>'; }
		$resultGetShigotoPriorities = mysql_query("SELECT * FROM shigoto_taskPriority ORDER BY taskPriorityDisplayOrder");
		while($rowGetShigotoPriorities = mysql_fetch_array($resultGetShigotoPriorities)) {
			echo '<option value="' . $rowGetShigotoPriorities['taskPriorityID'] . '"';
				if ($selectedPriorityID == $rowGetShigotoPriorities['taskPriorityID']) { echo ' selected="selected"'; }
			echo '>';
				if ($_SESSION['lang'] == 'ja') { echo $rowGetShigotoPriorities['taskPriorityJapanese']; } else { echo $rowGetShigotoPriorities['taskPriorityEnglish']; }
			echo '</option>';
		}
	echo '</select>';
}



function displayAgileClassificationDropdown(
	$selectedClassificationID = 0, 
	$selectName = 'classificationID', 
	$displayAllOption = 1, 
	$widthInPixels = 150
) {

	echo '<select name="' . $selectName . '" style="width:' . $widthInPixels . 'px">';
		$result111 = mysql_query("SELECT * FROM shigoto_classification WHERE (siteID = '0' OR siteID = '$_SESSION[siteID]') ORDER BY classificationDisplayOrder");
		if ($displayAllOption == 1) { echo '<option value="all">' . agileResource('classification') . '</option>'; }
		while($row111 = mysql_fetch_array($result111)) {
			echo '<option value="' . $row111['classificationID'] . '"';
				if ($row111['classificationID'] == $selectedClassificationID) { echo ' selected="selected"'; }
			echo '>' . getTimeLogClassificationName($row111['classificationID']) . '</option>';
		}
	echo '</select>';

}






function displayTimeLogClassificationDropdown($classificationID) {
	echo '<select name="classificationID">';
		$result111 = mysql_query("SELECT * FROM shigoto_classification WHERE (siteID = '0' OR siteID = '$_SESSION[siteID]') ORDER BY classificationDisplayOrder");
		echo '<option value="all">' . agileResource('classification') . '</option>';
		while($row111 = mysql_fetch_array($result111)) {
			echo '<option value="' . $row111['classificationID'] . '"';
				if ($row111['classificationID'] == $classificationID) { echo ' selected="selected"'; }
			echo '>' . getTimeLogClassificationName($row111['classificationID']) . '</option>';
		}
	echo '</select>';
}

function displayAgileStatusDropdown($selectedStatusID = 0, $selectName = 'statusID', $displayAllOption = 1, $widthInPixels = 150) {
	echo '<select name="' . $selectName . '" style="width:' . $widthInPixels . 'px">';
		
		if ($displayAllOption == 1) { echo '<option value="all">' . agileResource('status') . '</option>'; }
		
		$result111 = mysql_query("SELECT * FROM shigoto_taskStatus ORDER BY taskStatusDisplayOrder");
		while($row111 = mysql_fetch_array($result111)) {
			echo '<option value="' . $row111['taskStatusID'] . '"';
				if ($row111['taskStatusID'] == $selectedStatusID) { echo ' selected="selected"'; }
			echo '>' . getShigotoStatusName($row111['taskStatusID']) . '</option>';
		}
		
	echo '</select>';
}

function displayAgileProjectDropdown($projectID = 0, $selectName = 'projectID', $displayAllOption = 1, $widthInPixels = 150) {
	echo '<select name="' . $selectName . '" style="width:' . $widthInPixels . 'px">';
		if ($displayAllOption == 1) { echo '<option value="all">' . agileResource('projects') . '</option>'; }
		if ($_SESSION['roleID'] == 'Super Administrator') {
			$resultGetFilteredProjectList = mysql_query( "SELECT * FROM shigoto_project ORDER BY projectNameEnglish ASC" );
		} else {
			$userProjects = join(",", $_SESSION['userProjectArray']);
			$resultGetFilteredProjectList = mysql_query("SELECT * FROM shigoto_project WHERE projectID in ($userProjects) ORDER BY projectNameEnglish ASC");
		}
		while($rowGetFilteredProjectList = mysql_fetch_array($resultGetFilteredProjectList)) {
			echo '<option value="' . $rowGetFilteredProjectList['projectID'] . '"';
			if ($projectID == $rowGetFilteredProjectList['projectID']) { echo ' selected="selected"'; }
			echo '>' . getProjectName($rowGetFilteredProjectList['projectID']) . '</option>';
		}
	echo '</select>';
}

function displayAgileGroupDropdown($groupID = 0, $selectName = 'groupID', $displayAllOption = 1, $widthInPixels = 150) {

	echo '<select name="' . $selectName . '" style="width:' . $widthInPixels . 'px">';
		if ($displayAllOption == 1) { echo '<option value="all">' . agileResource('groups') . '</option>'; }
		
		if ($_SESSION['roleID'] == 'Super Administrator') {
			$resultGetFilteredGroupList = mysql_query( "SELECT * FROM shigoto_group ORDER BY groupNameEnglish ASC" );
		} else {
			$userGroups = join(",", $_SESSION['userGroupArray']);
			$resultGetFilteredGroupList = mysql_query("SELECT * FROM shigoto_group WHERE groupID in ($userGroups) ORDER BY groupNameEnglish ASC");
		}
		while($rowGetFilteredGroupList = mysql_fetch_array($resultGetFilteredGroupList)) {
			echo '<option value="' . $rowGetFilteredGroupList['groupID'] . '"';
			if ($groupID == $rowGetFilteredGroupList['groupID']) { echo ' selected="selected"'; }
			echo '>' . getGroupName($rowGetFilteredGroupList['groupID']) . '</option>';
		}
	echo '</select>';
}

function isTaskInGroupThatUserBelongsTo($taskID, $userID) {

	$siteID = $_SESSION['siteID'];
	$userGroupArray = array();
	$resultGetUserGroups = mysql_query("SELECT * FROM shigoto_group, shigoto_groupUser WHERE shigoto_group.groupID = shigoto_groupUser.groupID AND shigoto_groupUser.userID = $userID AND shigoto_group.siteID = $siteID");
	while ($rowGetUserGroups = mysql_fetch_array($resultGetUserGroups)) {
		$userGroupArray[] = $rowGetUserGroups['groupID'];
	}
	$groupID = getGroupWithTaskID($taskID);
	if (in_array($groupID, $userGroupArray)) { return true; } else { return false; }

}

function getGroupWithTaskID($taskID) {

	$queryGetTasksProject = "SELECT projectID FROM shigoto_task WHERE taskID = $taskID LIMIT 1";
	$resultGetTasksProject = mysql_query($queryGetTasksProject);
	while ($rowGetUserProject = mysql_fetch_array($resultGetTasksProject)) { $projectID = $rowGetUserProject['projectID'];}
	// echo $queryGetTasksProject . '<br />';
	
	$queryGetProjectsGroup = "SELECT groupID FROM shigoto_project WHERE projectID = $projectID LIMIT 1";
	$resultGetProjectsGroup = mysql_query($queryGetProjectsGroup);
	while ($rowGetProjectGroup = mysql_fetch_array($resultGetProjectsGroup)) { $groupID = $rowGetProjectGroup['groupID'];}
	// echo $queryGetProjectsGroup . '<br />';
	
	return $groupID;
}

function getGroupIDWithProjectID($projectID) {

	$query = "SELECT groupID FROM shigoto_project WHERE projectID = '$projectID' LIMIT 1";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) { $groupID = $row['groupID']; }
	return $groupID;

}

function getThisSitesGroups() {

	$siteID = $_SESSION['siteID'];
	$thisSitesGroups = array();
	$resultGetThisSitesGroups = mysql_query("SELECT * FROM shigoto_group WHERE siteID = $siteID ORDER BY groupID ASC");
	while($rowGetThisSitesGroups = mysql_fetch_array($resultGetThisSitesGroups)) {
		$thisSitesGroups[] = $rowGetThisSitesGroups['groupID'];
	}
	return $thisSitesGroups;

}

function getNumberOfTasksForThisProject($projectID) {

	$resultGetProjectsTasks = mysql_query("SELECT * FROM shigoto_task WHERE projectID = $projectID");
	$numberOfTasks = mysql_num_rows($resultGetProjectsTasks);
	return $numberOfTasks;

}

function getThisProjectsTotalHours($projectID) {
	$totalHours = 0;
	$resultGetThisProjectsTotalHours = mysql_query("SELECT timeLogTime FROM shigoto_timeLog WHERE projectID = $projectID");
	while($rowGetThisProjectsTotalHours = mysql_fetch_array($resultGetThisProjectsTotalHours)) {
		$totalHours = $totalHours + $rowGetThisProjectsTotalHours['timeLogTime'];
	}
	return $totalHours;
}

function getThisTasksTotalHours($taskID) {
	$totalHours = 0;
	$resultGetThisTasksTotalHours = mysql_query("SELECT timeLogTime FROM shigoto_timeLog WHERE taskID = $taskID");
	while($rowGetThisTasksTotalHours = mysql_fetch_array($resultGetThisTasksTotalHours)) {
		$totalHours = $totalHours + $rowGetThisTasksTotalHours['timeLogTime'];
	}
	return $totalHours;
}

function currentUserHasOnlyOneProject() {
	if (count($_SESSION['userProjectArray']) == 1) { return true; } else { return false; }
}

function getProjectIdIfCurrentUserOnlyHasOneProject() {
	if (count($_SESSION['userProjectArray']) == 1) {
		foreach ($_SESSION['userProjectArray'] as $projectID) { $usersOnlyProjectID = $projectID; }
		return $usersOnlyProjectID;
	}
}


















function getNewShigotoGroupDropdown($groupID) {

	$groupIDdropdown = '';

	$userGroups = join(",", $_SESSION['userGroupArray']);
	if ($_SESSION['lang'] == 'ja') {
		$resultGetGroups = mysql_query("SELECT * FROM shigoto_group WHERE groupID in ($userGroups) ORDER BY groupNameJapanese ASC");
	} else {
		$resultGetGroups = mysql_query("SELECT * FROM shigoto_group WHERE groupID in ($userGroups) ORDER BY groupNameEnglish ASC");
	}

	$groupIDdropdown .= '<select name="groupID" onchange="displayNewShigotoDropdownWidget(this.value);">';
	
		// $groupIDdropdown .= '<option value="0">' . agileResource('groups') . '</option>';
		while($rowGetGroups = mysql_fetch_array($resultGetGroups)) {
			$groupIDdropdown .= '<option value="' . $rowGetGroups['groupID'] . '"';
			if ($groupID == $rowGetGroups['groupID']) { $groupIDdropdown .= ' selected="selected"'; }
			$groupIDdropdown .= '>' . getGroupName($rowGetGroups['groupID']) . '</option>';
		}
		
	$groupIDdropdown .= '</select>';
	
	return $groupIDdropdown;

}

function getNewShigotoProjectDropdownWithGroup($groupID, $projectID) {

	$projectIDdropdown = '';

	$userGroups = join(",", $_SESSION['userGroupArray']);
	$userProjects = join(",", $_SESSION['userProjectArray']);
	
	if ($groupID == 0) {
		if ($_SESSION['lang'] == 'ja') {
			$resultGetProjects = mysql_query("SELECT * FROM shigoto_project WHERE groupID in ($userGroups) AND projectID in ($userProjects) ORDER BY projectNameJapanese ASC");
		} else {
			$resultGetProjects = mysql_query("SELECT * FROM shigoto_project WHERE groupID in ($userGroups) AND projectID in ($userProjects) ORDER BY projectNameEnglish ASC");
		}
	} else {
		if ($_SESSION['lang'] == 'ja') {
			$resultGetProjects = mysql_query("SELECT * FROM shigoto_project WHERE groupID = '$groupID' AND projectID in ($userProjects) ORDER BY projectNameJapanese ASC");
		} else {
			$resultGetProjects = mysql_query("SELECT * FROM shigoto_project WHERE groupID = '$groupID' AND projectID in ($userProjects) ORDER BY projectNameEnglish ASC");
		}
	}
	

	$projectIDdropdown .= '<select name="projectID">';
		$projectIDdropdown .= '<option value="0">' . agileResource('projects') . '</option>';

		while($rowGetProjects = mysql_fetch_array($resultGetProjects)) {
			$projectIDdropdown .= '<option value="' . $rowGetProjects['projectID'] . '"';
			if ($projectID == $rowGetProjects['projectID']) { $projectIDdropdown .= ' selected="selected"'; }
			$projectIDdropdown .= '>' . getProjectName($rowGetProjects['projectID']) . '</option>';
		}
		
	$projectIDdropdown .= '</select>';
	
	return $projectIDdropdown;
	
}

function getNewShigotoUserDropdownWithGroup($groupID, $userID) {

	$userIDdropdown = '';

	$userGroups = join(",", $_SESSION['userGroupArray']);

	if ($groupID == 0) {
		$resultGetUsers = mysql_query("SELECT DISTINCT(shigoto_groupUser.userID) FROM shigoto_groupUser LEFT JOIN j00mla_ver4_users ON shigoto_groupUser.userID = j00mla_ver4_users.id WHERE shigoto_groupUser.groupID in ($userGroups) ORDER BY j00mla_ver4_users.username ASC");
	} else {
		$resultGetUsers = mysql_query("SELECT DISTINCT(shigoto_groupUser.userID) FROM shigoto_groupUser LEFT JOIN j00mla_ver4_users ON shigoto_groupUser.userID = j00mla_ver4_users.id WHERE shigoto_groupUser.groupID = '$groupID' ORDER BY j00mla_ver4_users.username ASC");
	}
	
	
	$userIDdropdown .= '<select name="userID">';
		$userIDdropdown .= '<option value="0">' . agileResource('users') . '</option>';
		while($rowGetUsers = mysql_fetch_array($resultGetUsers)) {
			$userIDdropdown .= '<option value="' . $rowGetUsers['userID'] . '"';
			if ($userID == $rowGetUsers['userID']) { $userIDdropdown .= ' selected="selected"'; }
			$userIDdropdown .= '>' . getUserName($rowGetUsers['userID']) . '</option>';
		}
	$userIDdropdown .= '</select>';

	return $userIDdropdown;
	
}

function getNewShigotoClassificationDropdownWithGroup($groupID, $classificationID) {

	$taskClassificationIDdropdown = '';

	$userGroups = join(",", $_SESSION['userGroupArray']);

	$queryGetClassifications = "SELECT * FROM shigoto_classification WHERE groupID = '$groupID' ORDER BY classificationDisplayOrder ASC";

	$resultGetClassifications = mysql_query($queryGetClassifications);
	
	
	$taskClassificationIDdropdown .= '<select name="taskClassificationID">';
		$taskClassificationIDdropdown .= '<option value="0">' . agileResource('classifications') . '</option>';
		while($rowGetClassifications = mysql_fetch_array($resultGetClassifications)) {
			$taskClassificationIDdropdown .= '<option value="' . $rowGetClassifications['classificationID'] . '"';
			if ($classificationID == $rowGetClassifications['classificationID']) { $taskClassificationIDdropdown .= ' selected="selected"'; }
			$taskClassificationIDdropdown .= '>' . getShigotoClassificationNameWithID($rowGetClassifications['classificationID']) . '</option>';
		}
	$taskClassificationIDdropdown .= '</select>';

	return $taskClassificationIDdropdown;
	
}



function getUsersDefaultGroup($userID) {
	$defaultGroup = 0;
	$query = "SELECT * FROM shigoto_groupUser WHERE userID = $userID AND groupUserDefaultGroup = 1 LIMIT 1";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) { $defaultGroup = $row['groupID']; }
	return $defaultGroup;
}

?>