<?php

	function createExpense(
		$expenseSubmittedByUserID,
		$expenseSubmissionDateTime,
		$expenseDate,
		$vendorID,
		$expenseClassificationID,
		$expenseAmount,
		$expenseComment
	) {
		$query = "INSERT INTO accounting_expense (
			expenseSubmittedByUserID,
			expenseSubmissionDateTime,
			expenseDate, 
			vendorID, 
			expenseClassificationID, 
			expenseAmount, 
			expenseComment
		) VALUES (
			'$expenseSubmittedByUserID', 
			'$expenseSubmissionDateTime', 
			'$expenseDate', 
			'$vendorID', 
			'$expenseClassificationID', 
			'$expenseAmount', 
			'$expenseComment'
		)";
		mysql_query ($query) or die ('Could not create expense via createExpense()...');
	}
	
	

function getVendorName($vendorID) {

	$resultGetVendorName = mysql_query("SELECT * FROM accounting_vendor WHERE vendorID = '$vendorID' LIMIT 1");
	while($rowGetVendorName = mysql_fetch_array($resultGetVendorName)) {
		if ($_SESSION['lang'] == 'ja') {
			$vendorName = $rowGetVendorName['vendorNameJapanese'];
		} else {
			$vendorName = $rowGetVendorName['vendorNameEnglish'];
		}
	}
	echo $vendorName;
}





function displayUserDropdown($userID) {

	if ($_SESSION['lang'] == 'ja') {
		$result = mysql_query("SELECT * FROM framework_user ORDER BY userNameJapanese ASC");
	} else {
		$result = mysql_query("SELECT * FROM framework_user ORDER BY userNameEnglish ASC");
	}

	echo '<select name="userID">';
		echo '<option value="all">' . agileResource('user') . '</option>';
	while($row = mysql_fetch_array($result)) {
		echo '<option value="' . $row['userID'] . '"';
			if ($userID == $row['userID']) { echo ' selected="selected"'; }
		echo '>';
			if ($_SESSION['lang'] == 'ja') { echo $row['userNameJapanese']; } else { echo $row['userNameEnglish']; }
		echo '</option>';
	}
	echo '</select>';
	
	
}

function displayVendorDropdown($vendorID) {

	if ($_SESSION['lang'] == 'ja') {
		$result = mysql_query("SELECT * FROM accounting_vendor ORDER BY vendorNameJapanese ASC");
	} else {
		$result = mysql_query("SELECT * FROM accounting_vendor ORDER BY vendorNameEnglish ASC");
	}

	echo '<select name="vendorID">';
	echo '<option value="all">' . agileResource('vendor') . '</option>';
	while($row = mysql_fetch_array($result)) {
		echo '<option value="' . $row['vendorID'] . '"';
			if ($vendorID == $row['vendorID']) { echo ' selected="selected"'; }
		echo '>';
			if ($_SESSION['lang'] == 'ja') { echo $row['vendorNameJapanese']; } else { echo $row['vendorNameEnglish']; }
		echo '</option>';
	}
	echo '</select>';

}

function displayExpenseClassificationDropdown($classificationID) {

	if ($_SESSION['lang'] == 'ja') {
		$result = mysql_query("SELECT * FROM accounting_expenseClassification ORDER BY expenseClassificationJapanese");
	} else {
		$result = mysql_query("SELECT * FROM accounting_expenseClassification ORDER BY expenseClassificationEnglish");
	}
	
	echo '<select name="classificationID">';
	echo '<option value="all">' . agileResource('classification') . '</option>';
	while($row = mysql_fetch_array($result)) {
		echo '<option value="' . $row['expenseClassificationID'] . '"';
			if ($classificationID == $row['expenseClassificationID']) { echo ' selected="selected"'; }
		echo '>';
			if ($_SESSION['lang'] == 'ja') { echo $row['expenseClassificationJapanese']; } else { echo $row['expenseClassificationEnglish']; }
		echo '</option>';
	}
	echo '</select>';
	
}






function displayStartDate($startDate) {

	echo agileResource('startDate');

	echo'<input type="text" name="startDate" id="startDateInput" style="width:100px" value="' . $startDate . '" />';
	echo '<button type="reset" id="startDateButton">...</button>';

	echo '
		<script type="text/javascript">
			Calendar.setup({
				inputField     :    "startDateInput",      // id of the input field
				ifFormat       :    "%Y-%m-%d",       // format of the input field
				showsTime      :    false,            // will display a time selector
				button         :    "startDateButton",   // trigger for the calendar (button ID)
				singleClick    :    false,           // double-click mode
				step           :    1                // show all years in drop-down boxes (instead of every other year as default)
			});
		</script>
	';
	
}

function displayEndDate($endDate) {

	echo agileResource('endDate');
						
	echo '<input type="text" name="endDate" id="endDateInput" style="width:100px" value="' . $endDate . '" />';
	echo '<button type="reset" id="endDateButton">...</button>';

	echo '
		<script type="text/javascript">
			Calendar.setup({
				inputField     :    "endDateInput",      // id of the input field
				ifFormat       :    "%Y-%m-%d",       // format of the input field
				showsTime      :    false,            // will display a time selector
				button         :    "endDateButton",   // trigger for the calendar (button ID)
				singleClick    :    false,           // double-click mode
				step           :    1                // show all years in drop-down boxes (instead of every other year as default)
			});
		</script>
	';

}

?>