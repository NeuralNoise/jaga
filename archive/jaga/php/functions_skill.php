<?php

function displaySkillList() {

	$query = "SELECT * FROM shigoto_skill ORDER BY skillID DESC";
	$result = mysql_query($query);

	echo '<table style="margin:5px auto 5px auto;background-color:#fff;width:100%;font-family:verdana;font-size:10px;">';
	
		echo '<tr>';
			echo '<td class="fieldLabelLeft" colspan="5">';
				echo '<input type="button" value="' . agileResource('createSkill') . '" onclick="window.location.href=\'/' . languageUrlPrefix() . 'skill/create/\'">';
			echo '</td>';
		echo '</tr>';
	
		echo '<tr>';
			echo '<td class="fieldLabelCenter">' . agileResource('ID') . '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('skillEnglish') . '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('skillJapanese') . '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('skillCategory') . '</td>';
			echo '<td class="fieldLabelCenter">' . agileResource('action') . '</td>';
		echo '</tr>';
		
		while ($row = mysql_fetch_array($result)) {
			echo '<tr>';
				echo '<td class="borderAlignCenter">' . $row['skillID'] . '</td>';
				echo '<td class="borderAlignCenter">' . $row['skillEnglish'] . '</td>';
				echo '<td class="borderAlignCenter">' . $row['skillJapanese'] . '</td>';
				echo '<td class="borderAlignCenter">' . getSkillCategoryName($row['skillCategoryID']) . '</td>';
				echo '<td class="borderAlignCenter">';
					echo '<input type="button" value="' . agileResource('updateSkill') . '" onclick="window.location.href=\'/' . languageUrlPrefix() . 'skill/update/' . $row['skillID'] . '/\'">';
				echo '</td>';
			echo '</tr>';
		}
		
	echo '</table>';

}

function displaySkillCRUD($formType = 'create', $skillID = 0, $skillEnglish = '', $skillJapanese = '', $skillCategoryID = 0) {

	echo '<form method="post" action="/' . languageUrlPrefix() . 'skill/';
		if ($formType == 'create') { echo 'create/'; } elseif ($formType == 'update') { echo 'update/' . $skillID . '/'; }
	echo '">';
	
	echo '<table style="margin:5px auto 5px auto;background-color:#fff;font-family:verdana;font-size:10px;">';
		echo '<tr>';
			echo '<td class="fieldLabelCenter">' . agileResource('skillEnglish') . '</td>';
			echo '<td class="fieldLabelCenter"><input type="text" name="skillEnglish" value="' . $skillEnglish . '"></td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td class="fieldLabelCenter">' . agileResource('skillJapanese') . '</td>';
			echo '<td class="fieldLabelCenter"><input type="text" name="skillJapanese" value="' . $skillJapanese . '"></td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td class="fieldLabelCenter">' . agileResource('skillCategory') . '</td>';
			echo '<td class="fieldLabelCenter">';
				displaySkillCategoryDropdown($skillCategoryID);
			echo '</td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td class="fieldLabelRight" colspan="2"><input type="submit" name="submit" value="';
				if ($formType == 'create') { echo agileResource('createSkill'); } elseif ($formType == 'update') { echo agileResource('updateSkill'); }
			echo '"></td>';
		echo '</tr>';
		
	echo '</table>';
	echo '</form>';
}

function createSkill($skillEnglish, $skillJapanese, $skillCategoryID) {
	
	$siteID = $_SESSION['siteID'];
	$skillSubmittedByUserID = $_SESSION['userID'];
	$skillSubmissionDateTime = time('Y-m-d H:i:s');
	
	if ($skillEnglish == '') { $skillEnglish = $skillJapanese; }
	if ($skillJapanese == '') { $skillJapanese = $skillEnglish; }
	
	$query = "INSERT INTO shigoto_skill (
			siteID,
			skillSubmittedByUserID,
			skillSubmissionDateTime, 
			skillEnglish, 
			skillJapanese, 
			skillCategoryID
	) VALUES (
			'$siteID', 
			'$skillSubmittedByUserID', 
			'$skillSubmissionDateTime', 
			'$skillEnglish', 
			'$skillJapanese', 
			'$skillCategoryID'
	)";
	mysql_query ($query) or die ('Could not create skill via createSkill()');
	
}

function updateSkill($skillID, $skillEnglish, $skillJapanese, $skillCategoryID) {

	$query = "UPDATE shigoto_skill SET
		skillEnglish = '$skillEnglish',
		skillJapanese = '$skillJapanese',
		skillCategoryID = '$skillCategoryID'
		WHERE skillID = '$skillID' LIMIT 1";
		
	mysql_query ($query) or die ('Could not update skill via updateSkill()');

}

function displaySkillCategoryDropdown($classificationID) {

	if ($_SESSION['lang'] == 'ja') {
		$query = "SELECT * FROM shigoto_classification ORDER BY classificationJapanese";
	} else {
		$query = "SELECT * FROM shigoto_classification ORDER BY classificationEnglish";
	}
	
	$result = mysql_query($query);
	echo '<select name="classificationID">';
	while ($row = mysql_fetch_array($result)) {
		echo '<option value="' . $row['classificationID'] . '"';
			if ($classificationID == $row['classificationID']) { echo ' selected="selected">'; }
		echo '>';
			if ($_SESSION['lang'] == 'ja') { echo $row['classificationJapanese']; } else { echo $row['classificationEnglish']; }
		echo '</option>';
	}
	echo '</select>';
}

function getSkillCategoryName($classificationID) {
	$skillCategoryName = '';
	$query = "SELECT * FROM shigoto_classification WHERE classificationID = '$classificationID' LIMIT 1";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		if ($_SESSION['lang'] == 'ja') {
			$skillCategoryName = $row['classificationJapanese'];
		} else {
			$skillCategoryName = $row['classificationEnglish'];
		}
	}
	return $skillCategoryName;
}

?>