<?php

function displayDateInput($defaultDate, $fieldName, $isTextBoxReadOnly, $width = 100) {
			
	echo '<input type="text" name="' . $fieldName . '" id="' . $fieldName . 'Input" style="width:' . $width . 'px" value="' . $defaultDate . '"';
		if ($isTextBoxReadOnly == 1) { echo ' readonly="readonly"'; }
	echo ' />';
	echo '<button type="reset" id="' . $fieldName . 'Button">...</button>';

	echo '<script type="text/javascript">Calendar.setup({inputField:"' . $fieldName . 'Input",ifFormat:"%Y-%m-%d",showsTime:false,button:"' . $fieldName . 'Button",singleClick:false,step:1});</script>';

}

function displayDateTimeInput($defaultDateTime, $fieldName, $isTextBoxReadOnly, $width = 150) {
			
	echo '<input type="text" name="' . $fieldName . '" id="' . $fieldName . 'Input" style="width:' . $width . 'px" value="' . $defaultDateTime . '"';
		if ($isTextBoxReadOnly == 1) { echo ' readonly="readonly"'; }
	echo ' />';
	echo '<button type="reset" id="' . $fieldName . 'Button">...</button>';

	echo '<script type="text/javascript">Calendar.setup({inputField:"' . $fieldName . 'Input",ifFormat:"%Y-%m-%d %H:%M:%S",showsTime:true,button:"' . $fieldName . 'Button",singleClick:false,step:1});</script>';

}

function displayTimeOnlyInput($time = '12:00:00', $fieldName = '') {
	echo '<select name="' . $fieldName . '">';
		$hours = 0;
		while ($hours < 24) {
			$i = 0;
			while ($i < 2) {
				$minutes = $i * 30;
					$thisTime = str_pad($hours, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutes, 2, '0', STR_PAD_LEFT);
					$thisTimeWithSeconds = $thisTime . ':00';
					echo '<option value="' . $thisTimeWithSeconds . '"';
						if ($time == $thisTimeWithSeconds) { echo ' selected'; }
					echo '>';
						echo $thisTime;
						if ($hours <= '12') { echo ' AM'; } else { echo ' PM'; }
					echo '</option>';
				$i++;
			}
			$hours++;
		}
	echo '</select>';
}

?>