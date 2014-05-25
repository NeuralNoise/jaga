<?php

function displayTimeInput($hours = 0, $minutes = 0, $hoursSelectName = 'timeLogTimeHours', $minutesSelectName = 'timeLogTimeMinutes', $maxHours = 24) {


	echo '<select name="' . $hoursSelectName . '">';
		$startHours = 0;
		while ($startHours != $maxHours) {
			echo '<option value="'.$startHours.'">'.$startHours.'</option>';
			$startHours = $startHours + 1;
		}
	echo '</select>';
								
	echo '&nbsp;:&nbsp;';

	echo '<select name="' . $minutesSelectName . '">';
		echo '<option value="0">00</option>';
		echo '<option value="0.25">15</option>';
		echo '<option value="0.5">30</option>';
		echo '<option value="0.75">45</option>';
	echo '</select>';
}

?>