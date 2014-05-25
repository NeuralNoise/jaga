<?php

function displayShigotoTaskList(
	$selectedPriorityArray, 
	$selectedStatusArray, 
	$groupID, 
	$projectID, 
	$taskCurrentOwnerUserID, 
	$classificationID, 
	$orderBy
) {

		echo '<div style="text-align:center;">';
			echo '<form name="taskListForm" id="taskListForm" method="post" action="'. languageUrlPrefix() . 'tasks/">';
			echo '<table style="width:100%;margin:5px auto 5px auto;background-color:#fff;font-family:verdana;font-size:10px;">';
				echo '<input type="hidden" name="action" value="list">';
				
				echo '<tr>';
					echo '<td colspan="10" class="borderAlignLeft">';
						echo '<input type="button" value="' . agileResource('Create New Task') . '" onclick="window.location.href=\'/'. languageUrlPrefix() . 'task/create/select-project/\'">';
						echo '<input type="hidden" name="orderBy" id="orderBy" value="' . $orderBy . '" />';
					echo '</td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td colspan="9" class="borderAlignRight">';
						displayPriorityCheckboxes($selectedPriorityArray);
					echo '</td>';
					echo '<td class="borderAlignCenter" rowspan="2">';
						echo '<input type="submit" value="' . agileResource('Display') . '">';
					echo '</td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td colspan="9" class="borderAlignRight"><b>' . agileResource('Status') . '&nbsp;</b>';
						displayStatusCheckboxes($selectedStatusArray);
					echo '</td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="borderAlignRight" colspan="10">';
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
				// if ($_SESSION['userID'] == 2) {

						echo '<div id="groupIDdropdown" style="float:left;margin:1px;border:1px solid #ccc;">';
							echo getNewShigotoGroupDropdown($groupID);
						echo '</div>';
						
						echo '<div id="projectIDdropdown" style="float:left;margin:1px;border:1px solid #ccc;">';
							echo getNewShigotoProjectDropdownWithGroup($groupID, $projectID);
						echo '</div>';
						
						echo '<div id="userIDdropdown" style="float:left;margin:1px;border:1px solid #ccc;">';	
							echo getNewShigotoUserDropdownWithGroup($groupID, $taskCurrentOwnerUserID);
						echo '</div>';
						
						echo '<div id="taskClassificationIDdropdown" style="float:left;margin:1px;border:1px solid #ccc;">';
							echo getNewShigotoClassificationDropdownWithGroup($groupID, $classificationID);
						echo '</div>';
							
						echo '<div style="clear:both;"></div>';

	
				/*
				} else {
						
						displayAgileProjectDropdown($projectID, 'projectID', 1);
							echo '&#160;';
						displayShigotoUserDropdown($taskCurrentOwnerUserID);
							echo '&#160;';
						echo '<select name="taskClassificationID">';
							echo '<option value="all">' . agileResource('classification') . '</option>';
							$resultGetClassification = mysql_query("SELECT * FROM shigoto_classification WHERE (siteID = '0' OR siteID = '$_SESSION[siteID]') ORDER BY classificationDisplayOrder ASC");
							while ($rowGetClassification = mysql_fetch_array($resultGetClassification)) {
								echo '<option value="' . $rowGetClassification['classificationID'] . '"';
								if ($rowGetClassification['classificationID'] == $classificationID) {
									echo ' selected';
								}
								echo '>';
									if ($_SESSION['lang'] == 'ja') {
										echo $rowGetClassification['classificationJapanese'];
									} else {
										echo $rowGetClassification['classificationEnglish'];
									}
								echo '</option>';
							}
						echo '</select> ';
					
						
					}
					
					*/
















































					
						
					echo '</td>';
				echo '</tr>';

				echo'<tr style="background-color:#ddd;">';
					echo '<td class="borderAlignCenter">';
						echo '<a href="javascript:document.taskListForm.orderBy.value=\'';
							if ($orderBy == 'shigoto_task.taskID ASC') { echo 'shigoto_task.taskID DESC'; } else { echo 'shigoto_task.taskID ASC'; }
						echo '\';document.taskListForm.submit();" class="taskLink">ID</a>';
					echo '</td>';
					
					echo'<td class="borderAlignCenter">';
					echo '<a href="javascript:document.taskListForm.orderBy.value=\'';
						if ($orderBy == 'shigoto_taskPriority.taskPriorityDisplayOrder ASC') { echo 'shigoto_taskPriority.taskPriorityDisplayOrder DESC'; } else { echo 'shigoto_taskPriority.taskPriorityDisplayOrder ASC'; }
					echo '\';document.taskListForm.submit();" class="taskLink">';
							echo agileResource('Priority');
						echo '</a>';
					echo '</td>';
					
					echo'<td class="borderAlignCenter">';
					echo '<a href="javascript:document.taskListForm.orderBy.value=\'';
						if ($orderBy == 'shigoto_project.projectNameEnglish ASC') { echo 'shigoto_project.projectNameEnglish DESC'; } else { echo 'shigoto_project.projectNameEnglish ASC'; }
					echo '\';document.taskListForm.submit();" class="taskLink">';
							echo agileResource('Project');
						echo '</a>';
					echo '</td>';
					
					echo'<td class="borderAlignCenter">';
						echo '<a href="javascript:document.taskListForm.orderBy.value=\'';
							if ($orderBy == 'shigoto_task.taskCurrentOwnerUserID ASC') { echo 'shigoto_task.taskCurrentOwnerUserID DESC'; } else { echo 'shigoto_task.taskCurrentOwnerUserID ASC'; }
						echo '\';document.taskListForm.submit();" class="taskLink">';
							echo agileResource('Task Owner');
						echo '</a>';
					echo '</td>';
					echo'<td class="borderAlignCenter">';
						echo '<a href="javascript:document.taskListForm.orderBy.value=\'';
							if ($orderBy == 'shigoto_task.taskName ASC') { echo 'shigoto_task.taskName DESC'; } else { echo 'shigoto_task.taskName ASC'; }
						echo '\';document.taskListForm.submit();" class="taskLink">';
							echo agileResource('Tasks');
						echo '</a>';
					echo '</td>';
					
					echo'<td class="borderAlignCenter">';
						echo '<a href="javascript:document.taskListForm.orderBy.value=\'';
							if ($orderBy == 'shigoto_classification.classificationDisplayOrder ASC') { echo 'shigoto_classification.classificationDisplayOrder DESC'; } else { echo 'shigoto_classification.classificationDisplayOrder ASC'; }
						echo '\';document.taskListForm.submit();" class="taskLink">';
							echo agileResource('Classification');
						echo '</a>';
					echo '</td>';
					
					echo'<td class="borderAlignCenter">';
						echo '<a href="javascript:document.taskListForm.orderBy.value=\'';
							if ($orderBy == 'shigoto_taskStatus.taskStatusDisplayOrder ASC') { echo 'shigoto_taskStatus.taskStatusDisplayOrder DESC'; } else { echo 'shigoto_taskStatus.taskStatusDisplayOrder ASC'; }
						echo '\';document.taskListForm.submit();" class="taskLink">';
							echo agileResource('Status');
						echo '</a>';
					echo '</td>';
					
					echo'<td class="borderAlignCenter">';
						echo '<a href="javascript:document.taskListForm.orderBy.value=\'';
							if ($orderBy == 'shigoto_task.taskDeadLine ASC') { echo 'shigoto_task.taskDeadLine DESC'; } else { echo 'shigoto_task.taskDeadLine ASC'; }
						echo '\';document.taskListForm.submit();" class="taskLink">';
							echo agileResource('Deadline');
						echo '</a>';
					echo '</td>';
					
					echo'<td class="borderAlignCenter">' . agileResource('estimatedHours') . '</td>';
					echo'<td class="borderAlignCenter">' . agileResource('actualHours') . '</td>';

				echo '</tr>';

				// if ($projectID == 'all') {
				if ($projectID == 0) {
					if (empty($_SESSION['userProjectArray'])) {
						if ($_SESSION['roleID'] != 'Super Administrator' && $_SESSION['roleID'] != 'Accountant') {
							$whereClauseProject = 'shigoto_task.projectID IN (0)';
							$whereClauseSuperArray[] = $whereClauseProject;
						}
					} else {
						$whereClauseProject = 'shigoto_task.projectID IN (' . join(',',$_SESSION['userProjectArray']) . ')';
						$whereClauseSuperArray[] = $whereClauseProject;
					}
				} else {
					$whereClauseProject = 'shigoto_task.projectID = ' . $projectID;
					$whereClauseSuperArray[] = $whereClauseProject;
				}
				
				$thisGroupProjectArray = array();
				$querySelectedGroupsProjects = "SELECT * FROM shigoto_project WHERE groupID = $groupID";
				$resultSelectedGroupsProjects = mysql_query($querySelectedGroupsProjects);
				while ($rowSelectedGroupsProjects = mysql_fetch_array($resultSelectedGroupsProjects)) { $thisGroupProjectArray[] = $rowSelectedGroupsProjects['projectID']; }
				$thisGroupProjectArrayString = join(',',$thisGroupProjectArray);
				$whereClauseSuperArray[] = 'shigoto_task.projectID IN (' . $thisGroupProjectArrayString . ')';
				
				// if ($taskCurrentOwnerUserID != 'all') {
				if ($taskCurrentOwnerUserID != 0) {
					$whereClauseOwnerUser = 'shigoto_task.taskCurrentOwnerUserID = ' . $taskCurrentOwnerUserID;
					$whereClauseSuperArray[] = $whereClauseOwnerUser;
				}
				
				// if ($classificationID != 'all') {
				if ($classificationID != 0) {
					$whereClauseClassification = 'shigoto_task.taskClassificationID = ' . $classificationID;
					$whereClauseSuperArray[] = $whereClauseClassification;
				}
				
				if (!empty($selectedPriorityArray)) {
					$whereClausePriority = 'shigoto_task.taskPriorityID IN (' . join(',',$selectedPriorityArray) . ')';
					$whereClauseSuperArray[] = $whereClausePriority;
				}
				
				if (!empty($selectedStatusArray)) {
					$whereClauseStatus = 'shigoto_task.taskStatusID IN (' . join(',',$selectedStatusArray) . ')';
					$whereClauseSuperArray[] = $whereClauseStatus;
				}
				
				if (!empty($whereClauseSuperArray)) { $whereClauseSuperArrayString = 'WHERE ' . join(' AND ',$whereClauseSuperArray); }
				
				$taskQuery = "
					SELECT 
						shigoto_task.taskID, 
						shigoto_task.taskEstimatedTimeToComplete,
						shigoto_project.projectNameEnglish, 
						shigoto_taskPriority.taskPriorityID,
						shigoto_taskStatus.taskStatusID,
						shigoto_taskPriority.taskPriorityEnglish, 
						shigoto_taskStatus.taskStatusEnglish, 
						shigoto_task.taskDeadLine, 
						j00mla_ver4_users.name,
						shigoto_task.taskName, 
						shigoto_classification.classificationEnglish,
						shigoto_classification.classificationDisplayOrder
					FROM shigoto_task 
					LEFT JOIN shigoto_project
						ON shigoto_task.projectID = shigoto_project.projectID
					LEFT JOIN shigoto_taskPriority
						ON shigoto_task.taskPriorityID = shigoto_taskPriority.taskPriorityID
					LEFT JOIN shigoto_taskStatus
						ON shigoto_task.taskStatusID = shigoto_taskStatus.taskStatusID
					LEFT JOIN j00mla_ver4_users 
						ON shigoto_task.taskCurrentOwnerUserID = j00mla_ver4_users.id
					LEFT JOIN shigoto_classification
						ON shigoto_task.taskClassificationID = shigoto_classification.classificationID
					$whereClauseSuperArrayString
					ORDER BY $orderBy
				";
				
				
				
				// if ($_SESSION['testMode'] == 'on') { echo '<tr><td class="borderAlignLeft" colspan="11"><pre style="width:800px;overflow:auto;">' . $taskQuery . '</pre></td>'; }
				
				
				
				$totalEstimatedHoursThisQuery = 0;
				$actualHoursThisQuery = 0;
				
				$rowBackgroundCounter = 1;
				$result = mysql_query($taskQuery);
				while($row = mysql_fetch_array($result)) {
					$rowBackgroundColor = ' style="background-color:#eee;"';
					echo '<tr';
						if ($rowBackgroundCounter % 2) { echo $rowBackgroundColor; }
					echo ' class="taskRowDifferentiation">';
						echo '<td class="borderAlignLeft">';
							echo '<a href="' . languageUrlPrefix() . 'task/view/' . $row['taskID'] . '/">' . $row['taskID'] . '</a>';
						echo '</td>';
						echo '<td class="borderAlignCenter"';
							if ($row['taskPriorityID'] == 1) {
								echo ' style="background-color:#FFBBBB;"';
							} elseif ($row['taskPriorityID'] == 2) {
								echo ' style="background-color:#BDF4CB;"';
							} elseif ($row['taskPriorityID'] == 3) {
								echo ' style="background-color:#CEF0FF;"';
							} elseif ($row['taskPriorityID'] == 4) {
								echo ' style="background-color:#FFF79A;"';
							} elseif ($row['taskPriorityID'] == 5) {
								echo ' style="background-color:#EEEEEE;"';
							}
						echo '>' . $row['taskPriorityEnglish'] . '</td>';
						echo '<td class="borderAlignCenter">' . $row['projectNameEnglish'] . '</td>';
						echo '<td class="borderAlignCenter">' . $row['name'] . '</td>';
						echo '<td class="borderAlignLeft">';
							echo '<a href="' . languageUrlPrefix() . 'task/view/' . $row['taskID'] . '/">';
								echo htmlspecialchars($row['taskName']);
							echo '</a>';
						echo '</td>';
						echo '<td class="borderAlignCenter">' . $row['classificationEnglish'] . '</td>';
						echo '<td class="borderAlignCenter">' . $row['taskStatusEnglish'] . '</td>';
						echo '<td class="borderAlignCenter"';
							$todaysDate = time();
							$thisTasksDeadline = strtotime($row['taskDeadLine']);
							$taskStatusIDisTaskDone = $row['taskStatusID'];
							if ($thisTasksDeadline < $todaysDate && $taskStatusIDisTaskDone != 1) {
								echo ' style="background-color:#FBB;"'; // Overdue
							}
						echo '>';
							if ($_SESSION['lang'] == 'ja') {
								echo date('Y年m月d日 H:i:s', strtotime($row['taskDeadLine']));
							} else {
								echo date('Y-m-d H:i:s', strtotime($row['taskDeadLine']));
							}
						echo '</td>';
						echo'<td class="borderAlignRight">' . $row['taskEstimatedTimeToComplete'] . '</td>';
						echo'<td class="borderAlignRight">' . getThisTasksTotalHours($row['taskID']) . '</td>';
					echo '</tr>';
					$totalEstimatedHoursThisQuery = $totalEstimatedHoursThisQuery + $row['taskEstimatedTimeToComplete'];
					$actualHoursThisQuery = $actualHoursThisQuery + getThisTasksTotalHours($row['taskID']);
					$rowBackgroundCounter = $rowBackgroundCounter + 1;
				}
				
				echo '<tr>';
				
				echo '<td class="borderAlignLeft" colspan="8"></td>';
				echo '<td class="borderAlignRight">' . $totalEstimatedHoursThisQuery . '</td>';
				echo '<td class="borderAlignRight">' . $actualHoursThisQuery . '</td>';
				
				echo '</tr>';
				
				
			echo '</table>';
		echo '</form>';
	echo '</div>';

}

function displayShigotoTaskCrud(
	$type = 'create', 
	$projectID = 0, 
	$taskID = 0, 
	$taskName = '', 
	$taskPriorityID = 2, 
	$classificationID = 0, 
	$taskDescription = '', 
	$taskDeadLine = '', 
	$taskStatusID = 0, 
	$taskEstimatedTimeToComplete = 0, 
	$taskActualTimeToComplete = 0, 
	$thisTaskUserID = array(), 
	$errorArray = array()
	) {

	$taskSubmittedByUserID = $_SESSION['userID'];
	$taskCurrentOwnerUserID = $_SESSION['userID'];

	if ($type == 'update' && empty($errorArray) && $taskID != 0) {
	
		$resultGetExistingTaskData = mysql_query("SELECT * FROM shigoto_task WHERE taskID = $taskID LIMIT 1");
		while ($rowGetExistingTaskData = mysql_fetch_array($resultGetExistingTaskData)) {
		
			$taskSubmittedByUserID =  $rowGetExistingTaskData['taskSubmittedByUserID'];
			$taskCurrentOwnerUserID = $rowGetExistingTaskData['taskCurrentOwnerUserID'];
			$taskName = $rowGetExistingTaskData['taskName'];
			$taskPriorityID = $rowGetExistingTaskData['taskPriorityID'];
			$classificationID = $rowGetExistingTaskData['taskClassificationID'];
			$taskDescription = $rowGetExistingTaskData['taskDescription'];
			$taskDeadLine = $rowGetExistingTaskData['taskDeadLine'];
			$taskStatusID = $rowGetExistingTaskData['taskStatusID'];
			$taskEstimatedTimeToComplete = $rowGetExistingTaskData['taskEstimatedTimeToComplete'];
			$taskActualTimeToComplete = $rowGetExistingTaskData['taskActualTimeToComplete'];
			$projectID = $rowGetExistingTaskData['projectID'];
			$thisTaskUserID[] = array();
		
		}
	
	}
	
	$groupID = getGroupIDWithProjectID($projectID);
	
	
	if (taskIsClosed($taskID)) { $type = 'view'; }
	
		echo '<div style="text-align:center;">';
		
			if ($type == 'create') {
				echo '<form method="post" action="' . languageUrlPrefix() . 'task/create/">';
			} elseif ($type == 'update') {
				echo '<form method="post" action="' . languageUrlPrefix() . 'task/view/' . $taskID . '/">';
			}
			
			echo '<input type="hidden" name="projectID" value="' . $projectID . '">';
			
			if ($type == 'update') {
				echo '<input type="hidden" name="taskID" value="' . $taskID . '">';
			}
			
			echo '<table style="margin:5px auto 0px auto;background-color:#fff;width:615px;font-family:verdana;font-size:12px;">';
			
				echo '<tr>';
					echo '<td class="fieldLabelLeft" colspan="2" style="background-color:#ddd;"><h3 style="margin:0px;">' . agileResource('task') . '</h3></td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('taskName') . '</td>';
					echo '<td class="borderAlignLeft">';
					
						if ($type == 'view') {
							echo '<b>' . $taskName . '</b>';
						} else {
							if ($type == 'create' || $taskSubmittedByUserID == $_SESSION['userID']) {
								echo '<input type="textbox" name="taskName" value="' . $taskName . '" style="width:250px;">';
							} else {
								echo '<input type="hidden" name="taskName" value="' . $taskName . '">';
								echo '<b>' . $taskName . '</b>';
							}
						}
						
					echo '</td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('projectID') . '</td>';
					echo '<td class="borderAlignLeft">' . getProjectName($projectID) . '</td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('taskSubmittedByUserID') . '</td>';
					echo '<td class="borderAlignLeft">';
						echo getUserName($taskSubmittedByUserID);
					echo '</td>';
				echo '</tr>';

			
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('taskCurrentOwnerUserID') . '</td>';
					echo '<td class="borderAlignLeft">';
						if ($type == 'view') {
							echo getUserName($taskCurrentOwnerUserID);
						} else {
							displayShigotoUserDropdownThisProjectsGroup($taskCurrentOwnerUserID, $projectID, 'taskCurrentOwnerUserID');
						}
					echo '</td>';
				echo '</tr>';

				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('taskPriorityID') . '</td>';
					echo '<td class="borderAlignLeft">';

						if ($type == 'view') {
							echo getShigotoPriorityName($taskPriorityID);
						} else {
							if ($type == 'create') {
								displayShigotoPriorityDropdown(2, 'taskPriorityID', 0);
							} elseif ($type == 'update') {
								displayShigotoPriorityDropdown($taskPriorityID, 'taskPriorityID', 0);
							}
						}
						
					echo '</td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('classificationID') . '</td>';
					echo '<td class="borderAlignLeft">';
						if ($type == 'view') {
							echo getShigotoClassificationName($classificationID);
						} else {
							if ($type == 'create') {
								echo getNewShigotoClassificationDropdownWithGroup($groupID, 0);
							} elseif ($type == 'update') {
								echo getNewShigotoClassificationDropdownWithGroup($groupID, $classificationID);
							}
						}
					echo '</td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('taskStatusID') . '</td>';
					echo '<td class="borderAlignLeft">';
						
						if ($type == 'view') {
							echo getShigotoStatusName($taskStatusID);
						} else {
							if ($type == 'create') {
								displayAgileStatusDropdown(3, 'taskStatusID', 0);
							} elseif ($type == 'update') {
								displayAgileStatusDropdown($taskStatusID, 'taskStatusID', 0);
							}
						}
						
					echo '</td>';
				echo '</tr>';

				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('taskDeadLine') . '</td>';
					echo '<td class="borderAlignLeft">';
						if ($type == 'view') {
							echo $taskDeadLine;
						} else {
							if ($type == 'create') {
								displayDateTimeInput(date('Y-m-d H:i:s',strtotime('+1 week')), 'taskDeadLine', 1);
							} else {
								displayDateTimeInput($taskDeadLine, 'taskDeadLine', 1);
							}
						}
					echo '</td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('taskEstimatedTimeToComplete') . '</td>';
					echo '<td class="borderAlignLeft">';
						if ($type == 'create') {
							displayTimeInput(0, 0, 'taskEstimatedTimeToCompleteHours', 'taskEstimatedTimeToCompleteMinutes', 81);
						} else { echo $taskEstimatedTimeToComplete; }
					echo '</td>';
				echo '</tr>';
				
				if ($type == 'update') {
					echo '<tr>';
						echo '<td class="fieldLabelLeft">' . agileResource('timeSpentOnTaskSoFar') . '</td>';
						echo '<td class="borderAlignLeft">';
							echo number_format(getTasksTotalTime($taskID), 2);
							if ($_SESSION['testMode'] == 'on') {
								echo '&nbsp;(<a href="' . languageUrlPrefix() . 'timelog/task/' . $taskID . '/">' . agileResource('timelog') . '</a>)';
							}
						echo '</td>';
					echo '</tr>';
				}
				
				echo '<tr>';
					echo '<td class="fieldLabelLeft" colspan="2" style="background-color:#ddd;">';
						echo '<h3 style="margin:0px;">';
							echo agileResource('taskDescriptionCrud');
							echo '<input id="descriptionEditCheckbox" type="checkbox" onchange="descriptionEditControl();">';
						echo '</h3>';
					echo '</td>';
				echo '</tr>';
				
				
				echo '<tr>';
					echo '<td class="borderAlignLeft" colspan="2">';
					
						if ($type == 'view') {
							echo '<div style="width:400px;">' . $taskDescription . '</div>';
						} else {
							if ($type == 'create' || $taskSubmittedByUserID == $_SESSION['userID']) {
								echo '<textarea id="taskDescriptionTextbox" class="ckeditor" name="taskDescription" style="width:400px;">' . $taskDescription . '</textarea>';
							} else {
								echo '<div style="width:400px;">' . $taskDescription . '</div>';
								echo '<input type="hidden" name="taskDescription" value="doNotUpdateTaskDescription">';
							}
						}
						
					echo '</td>';
				echo '</tr>';

				

				
				if ($type == 'create') {
					echo '<tr>';
							echo '<td class="fieldLabelLeft" colspan="2">' . agileResource('selectedUsersWillReceiveTaskNotificationMails') . '</td>';
					echo '</tr>';

					echo '<tr>';
						echo '<td class="borderAlignLeft" colspan="2">';
				
							$resultGetGroupID = mysql_query("SELECT groupID FROM shigoto_project WHERE projectID = $projectID LIMIT 1");
							while($rowGetGroupID = mysql_fetch_array($resultGetGroupID)) { $thisProjectGroupID = $rowGetGroupID['groupID']; }
					
							$resultDisplayGroupUserCheckboxes = mysql_query("
								SELECT shigoto_groupUser.userID, j00mla_ver4_users.name 
								FROM shigoto_groupUser 
								LEFT JOIN j00mla_ver4_users 
								ON shigoto_groupUser.userID = j00mla_ver4_users.id 
								WHERE shigoto_groupUser.groupID = $thisProjectGroupID
							");

							while($rowDisplayGroupUserCheckboxes = mysql_fetch_array($resultDisplayGroupUserCheckboxes)) {
					
								echo '<input type="checkbox" name="thisTaskUserID[]" value="' . $rowDisplayGroupUserCheckboxes['userID'] . '"';
									if ($rowDisplayGroupUserCheckboxes['userID'] == $_SESSION['userID']) { echo ' checked'; }
								echo '>';
						
								echo '&nbsp;' . $rowDisplayGroupUserCheckboxes['name'] . '<br />';
							}
					
						echo '</td>';
					echo '</tr>';
					
				} elseif ($type == 'update' || $type == 'view') {
		
					// NOTIFICATION MAIL RECIPIENTS
		
					$resultGetTaskUsers = mysql_query("SELECT userID FROM shigoto_taskUser WHERE taskID = $taskID");
					if (mysql_num_rows($resultGetTaskUsers) != 0) {
						while($rowGetTaskUsers = mysql_fetch_array($resultGetTaskUsers)) { $userNameArray[] = getUserName($rowGetTaskUsers['userID']); }
						$userNameArraySting = join(', ',$userNameArray);
						echo '<tr>';
								echo '<td class="fieldLabelLeft" colspan="2">' . agileResource('usersReceivingNotificationMailsForThisTask') . '</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td class="borderAlignLeft" colspan="2">';
							// while($rowGetTaskUsers = mysql_fetch_array($resultGetTaskUsers)) { echo getUserName($rowGetTaskUsers['userID']) . '<br />'; }
								echo $userNameArraySting;
							echo '</td>';
						echo '</tr>';
					}
					
					// COMMENTS
		
				echo '<tr>';
					echo '<td class="fieldLabelLeft" colspan="2" style="background-color:#ddd;"><h3 style="margin:0px;">' . agileResource('taskComments') . '</h3></td>';
				echo '</tr>';
		
		
					$resultGetTaskComments = mysql_query("SELECT * FROM shigoto_taskComment WHERE taskID = $taskID ORDER BY taskCommentSubmittedDateTime ASC");
					while($rowGetTaskComments = mysql_fetch_array($resultGetTaskComments)) {
						echo '<tr>';
							echo '<td class="fieldLabelLeft" colspan="2">';
								echo '<b>' . getUserName($rowGetTaskComments['taskCommentSubmittedUserID']) . '</b>';
								echo ' (' . $rowGetTaskComments['taskCommentSubmittedDateTime'] . ')';
							echo '</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td class="borderAlignLeft" colspan="2">' . $rowGetTaskComments['taskCommentContent'] . '</td>';
						echo '</tr>';
					}

					if ($type == 'update') {
						// ADD NEW COMMENT FIELD
					
						echo '<tr>';
							echo '<td class="borderAlignCenter" colspan="2">';
								echo '<textarea class="ckeditor" name="taskCommentContent" style="width:600px;height:200px;"></textarea>';
							echo '</td>';
						echo '</tr>';
					}
					
				}

				
		
		// SUBMIT BUTTON
				if ($type != 'view') {
				echo '<tr>';
					echo '<td class="borderAlignRight" colspan="2">';
						
						if ($type == 'update') {
							echo agileResource('timeSpentOnThisTask');
							echo '&nbsp;';
							displayTimeInput();
							echo '&nbsp;';
						}
						
						echo '<input type="submit" name="submit" value="';
							if ($type == 'create') { echo agileResource('createTask'); } elseif ($type == 'update') { echo agileResource('updateTicketAndAddComment'); }
						echo '">';
					echo '</td>';
				echo '</tr>';
				}

			echo '</table>';
			if ($type != 'view') { echo '</form>'; }
		echo '</div>';
		
		
		// AUDIT TRAIL
		
		if ($type == 'update' || $type == 'view') {
			echo '<div style="text-align:center;">';
			echo '<table style="margin:0px auto 5px auto;background-color:#fff;width:615px;font-family:verdana;font-size:10px;">';
				echo '<tr>';
					echo '<td class="fieldLabelLeft" colspan="5" style="background-color:#ddd;"><h3 style="margin:0px;">' . agileResource('auditTrail') . '</h3></td>';
				echo '</tr>';
			
				echo '<tr>';
					echo '<td class="fieldLabelLeft">' . agileResource('auditTrailDateTime') . '</td>';
					echo '<td class="fieldLabelLeft">' . agileResource('auditTrailUserName') . '</td>';
					echo '<td class="fieldLabelLeft">' . agileResource('auditTrailField') . '</td>';
					echo '<td class="fieldLabelLeft">' . agileResource('auditTrailOldData') . '</td>';
					echo '<td class="fieldLabelLeft">' . agileResource('auditTrailNewData') . '</td>';
				echo '</tr>';
			
				$resultGetTaskAuditTrail = mysql_query("SELECT * FROM auditTrail WHERE (auditTrailAction = 'updateTask' OR auditTrailAction = 'createTask') AND auditTrailObjectID = $taskID ORDER BY auditTrailDateTime DESC");
				while($rowGetTaskAuditTrail = mysql_fetch_array($resultGetTaskAuditTrail)) {
					echo '<tr>';
						echo '<td class="borderAlignCenter">';
							echo $rowGetTaskAuditTrail['auditTrailDateTime'];
						echo '</td>';
						echo '<td class="borderAlignCenter">';
							// if ($rowGetTaskAuditTrail['auditTrailUserName'] != '') {
								echo getUserName($rowGetTaskAuditTrail['auditTrailUserName']);
							// }
						echo '</td>';
						echo '<td class="borderAlignCenter">';
							echo agileResource($rowGetTaskAuditTrail['auditTrailField']);
						echo '</td>';
						echo '<td class="borderAlignCenter">';
							if ($rowGetTaskAuditTrail['auditTrailOldData'] != '') {
								echo getAuditTrailResource($rowGetTaskAuditTrail['auditTrailField'], $rowGetTaskAuditTrail['auditTrailOldData']);
							}
						echo '</td>';
						echo '<td class="borderAlignCenter">';
							if ($rowGetTaskAuditTrail['auditTrailNewData'] != '') {
								echo getAuditTrailResource($rowGetTaskAuditTrail['auditTrailField'], $rowGetTaskAuditTrail['auditTrailNewData']);
							}
						echo '</td>';
					echo '</tr>';
				}
				echo '</table>';
				echo '</div>';

		}




}

function createTask(
	$taskCurrentOwnerUserID, 
	$taskName, 
	$taskPriorityID, 
	$classificationID, 
	$taskDescription, 
	$taskDeadLine, 
	$taskStatusID, 
	$projectID, 
	$taskEstimatedTimeToComplete, 
	$thisTaskUserID = array(), 
	$errorArray = array()
) {

		$taskDateTimeSubmitted = date('Y-m-d H:i:s');
		$taskSubmittedByUserID = $_SESSION['userID'];

		$cleanTaskDescription = mysql_real_escape_string($taskDescription);
		
		$queryInsertTask = "INSERT INTO shigoto_task (
			taskDateTimeSubmitted,
			taskSubmittedByUserID, 
			taskCurrentOwnerUserID,
			taskName, 
			taskPriorityID, 
			taskClassificationID, 
			taskDescription, 
			taskDeadLine, 
			taskStatusID,
			projectID,
			taskEstimatedTimeToComplete
		) VALUES (
			'$taskDateTimeSubmitted',
			'$taskSubmittedByUserID',
			'$taskCurrentOwnerUserID',
			'$taskName', 
			'$taskPriorityID', 
			'$classificationID', 
			'$cleanTaskDescription', 
			'$taskDeadLine', 
			'$taskStatusID',
			'$projectID',
			'$taskEstimatedTimeToComplete'
		)";
		mysql_query ($queryInsertTask) or die ('queryInsertTask error');
		
		$taskID = mysql_insert_id();
		
		postToAuditTrail($_SESSION['userID'], 'createTask', 'successful', '', $taskCurrentOwnerUserID, 'shigoto_task', $taskID, 'taskCurrentOwnerUserID');
		postToAuditTrail($_SESSION['userID'], 'createTask', 'successful', '', $taskPriorityID, 'shigoto_task', $taskID, 'taskPriorityID');
		postToAuditTrail($_SESSION['userID'], 'createTask', 'successful', '', $taskStatusID, 'shigoto_task', $taskID, 'taskStatusID');
		postToAuditTrail($_SESSION['userID'], 'createTask', 'successful', '', $classificationID, 'shigoto_task', $taskID, 'taskClassificationID');
		
		if (!empty($thisTaskUserID)) {
			foreach ($thisTaskUserID as $userID) {
				$queryInsertTaskUser = "INSERT INTO shigoto_taskUser (
					taskID,
					userID
				) VALUES (
					'$taskID',
					'$userID'
				)";
				mysql_query ($queryInsertTaskUser) or die ('queryInsertTaskUser error');
			}
		}
		
		// START NOTIFICATION MAIL CREATION
			
			
			$fromAddress = getSiteAutomatedEmailAddress();
			$mailSubject = '[ ' . getTaskName($taskID) . ' ] (task creation notification)';
			$siteID = $_SESSION['siteID'];
			$userID = $_SESSION['userID'];
			
			$mailMessage = '<html>';
				$mailMessage .= '<body style="text-align:left;">';
					$mailMessage .= '<div style="text-align:center;background-color:#eee;width:500px;border:1px solid #999;background-image:url(\'http://agilehokkaido.com/agileThemes/agilehokkaido/images/backgroundFade.png\');background-repeat:repeat-x;">';
					$mailMessage .= '<table style="margin:10px auto 10px auto;width:480px;background-color:#fff;">';
						$mailMessage .= '<tr>';
							$mailMessage .= '<td style="text-align:left;border:1px solid #ccc;background-color:#ddd;"><b>' . getTaskName($taskID) . '</b></td>';
						$mailMessage .= '</tr>';
						
						if ($taskDescription != '') {
							$mailMessage .= '<tr>';
								$mailMessage .= '<td style="text-align:justify;border:1px solid #ccc;">';
									$mailMessage .= $taskDescription;
									// $mailMessage .= str_replace(array("\\r\\n", "\\r", "\\n"), "<br />", $taskDescription);
									// $mailMessage .= nl2br($taskDescription) // see if this works
								$mailMessage .= '</td>';
							$mailMessage .= '</tr>';
						}
						
						$mailMessage .= '<tr>';
							$mailMessage .= '<td style="border:1px solid #ccc;text-align:right;">';
								$mailMessage .= '<a href="' . getSiteURL() . '/task/view/' . $taskID . '/" style="text-decoration:none;">VIEW THIS TASK</a>';
							$mailMessage .= '</td>';
						$mailMessage .= '</tr>';
					$mailMessage .= '</table>';
					$mailMessage .= '</div>';
				$mailMessage .= '</body>';
			$mailMessage .= '</html>';
			
			$resultGetTaskUsers = mysql_query("
				SELECT * FROM shigoto_taskUser 
				LEFT JOIN j00mla_ver4_users 
				ON shigoto_taskUser.userID = j00mla_ver4_users.id 
				WHERE shigoto_taskUser.taskID = $taskID
			");
				
			while($rowGetTaskUser = mysql_fetch_array($resultGetTaskUsers)) {
				$toAddress = $rowGetTaskUser['email'];
				agileMail($toAddress, $fromAddress, $mailSubject, $mailMessage, $siteID, $userID, 'html');
			}
				
}

function updateShigotoTask($taskID, $taskName, $taskCurrentOwnerUserID, $taskPriorityID, $taskClassificationID, $taskStatusID, $taskDeadLine, $taskDescription) {

	$queryUpdateTask = "UPDATE shigoto_task SET 
		taskCurrentOwnerUserID = '$taskCurrentOwnerUserID', 
		taskPriorityID = '$taskPriorityID', 
		taskClassificationID = '$taskClassificationID', 
		taskStatusID = '$taskStatusID', 
		taskDeadLine = '$taskDeadLine'
		WHERE taskID = '$taskID'";
	mysql_query($queryUpdateTask) or die (agileResource('could not update task via updateShigotoTask()'));
	
	// following two fields SHOULD only be edited by the user that created the task
	
		$queryUpdateTaskName = "UPDATE shigoto_task SET taskName = '$taskName' WHERE taskID = '$taskID'";
		mysql_query($queryUpdateTaskName) or die (agileResource('could not update task name in updateShigotoTask()'));
	
		if ($taskDescription != 'doNotUpdateTaskDescription') {
			$queryUpdateTaskDescription = "UPDATE shigoto_task SET taskDescription = '$taskDescription' WHERE taskID = '$taskID'";
			mysql_query($queryUpdateTaskDescription) or die (agileResource('could not update task description in updateShigotoTask()'));
		}

}

function displaySelectProjectForm() {
			echo '<div style="text-align:center;">';
				echo '<form method="post" action="' . languageUrlPrefix() . 'task/create/">';
				echo '<table style="margin:5px auto 5px auto;background-color:white;">';
					echo '<tr>';
						echo '<td class="fieldLabelLeft">';
							echo agileResource('pleaseSelectProject');
						echo '</td>';
						echo '<td class="borderAlignLeft">';
							displayAgileProjectDropdown(0, 'projectID', 0);
						echo '</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td class="borderAlignRight" colspan="2">';
							echo '<input type="submit" name="goToStep2" value="' . agileResource('next') . '">';
						echo '</td>';
					echo '</tr>';
				echo '</table>';
				echo '</form>';
			echo '</div>';
}

function insertTaskComment($taskID, $currentUserID, $dateTimeNow, $taskCommentContent) {

	$queryInsertTaskComment = "INSERT INTO shigoto_taskComment (
		taskID,
		taskCommentSubmittedUserID,
		taskCommentSubmittedDateTime,
		taskCommentContent
	) VALUES (
		'$taskID',
		'$currentUserID',
		'$dateTimeNow',
		'$taskCommentContent'
	)";
	mysql_query ($queryInsertTaskComment) or die ('could not insert taskComment via insertTaskComment()');


}

function getTasksTotalTime($taskID) {
	$result = mysql_query("SELECT SUM(timeLogTime) AS timeLogTime FROM shigoto_timeLog WHERE taskID = $taskID");
	if (mysql_num_rows($result) == 0) {
		$tasksTotalTime = 0;
	} else {
		while ($row = mysql_fetch_array($result)) { $tasksTotalTime = $row['timeLogTime']; }
	}
	return $tasksTotalTime;
}

function getCurrentSiteProductServiceDefaultShigotoProductService() {
	$siteID = $_SESSION['siteID'];
	$result = mysql_query("SELECT productServiceID FROM accounting_productService WHERE siteID = $siteID AND productServiceDefaultShigotoProductService = 1 LIMIT 1");
	if (mysql_num_rows($result)) {
		while ($row = mysql_fetch_array($result)) { return $row['productServiceID']; }
	} else { return 0; }
}

function taskIsClosed($taskID) {
	$result = mysql_query("SELECT * FROM shigoto_task WHERE taskID = $taskID LIMIT 1");
	while ($row = mysql_fetch_array($result)) { if ($row['taskStatusID'] == 1) { $taskIsClosed = true; } else { $taskIsClosed = false; } }
	return $taskIsClosed;
}




?>