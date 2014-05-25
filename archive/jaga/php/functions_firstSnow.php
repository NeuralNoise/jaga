<?php

function averageOfAllThisYearsEntries($year) {

	$startDate = $year . '-09-01 00:00:00';
	$endDate = $year . '-12-31 23:59:59';
	$totalTime = 0;
	$totalEntries = 0;
	$resultGetEachUser = mysql_query("SELECT DISTINCT userID FROM snowPrediction WHERE snowPredictionDateTimeOfPrediction >= '$startDate' AND snowPredictionDateTimeOfPrediction <= '$endDate' ORDER BY snowPredictionDateTimeOfPrediction DESC");
	while($rowGetEachUser = mysql_fetch_array($resultGetEachUser)) {
		$resultGetUsersMostRecentRelevantEntry = mysql_query("SELECT userID, snowPredictionDateTimeOfPrediction FROM snowPrediction WHERE userID = '$rowGetEachUser[userID]' ORDER BY snowPredictionDateTimeOfPrediction DESC LIMIT 1");
		while($rowGetUsersMostRecentRelevantEntry = mysql_fetch_array($resultGetUsersMostRecentRelevantEntry)) {
			$totalTime = $totalTime + strtotime($rowGetUsersMostRecentRelevantEntry['snowPredictionDateTimeOfPrediction']);
			$totalEntries = $totalEntries + 1;
		}
	}
	
	$averagePredictionDateTime = $totalTime / $totalEntries;
	return date('Y-m-d H:i:s', $averagePredictionDateTime);

}


function displayDateThisLanguage($date) {

}



function displayFirstSnowPredictionList() {

	echo '<div style="float:left;text-align:center;margin:5px;width:615px;height:900px;overflow:auto;">';
		echo '<table style="background-color:#fff;width:100%;">';
			
			echo '<tr>';
				echo '<td colspan="5" class="borderAlignLeft">';
				
					// echo '<input type="button" value="' . agileResource('makeYourPrediction') . '" onclick="window.location.href=\'' . languageUrlPrefix() . 'first-snow-entry-form/\'">';
					// echo '<b>Congratulations to <a class="agileLinkage" href="http://niseko.kutchannel.net/en/userpanel/profile/userprofile/Lorenzo">Lorenzo</a>, the winner of the 2011 Niseko First Snow contest.<br />An amazing dinner is waiting for you at <a class="agileLinkage" href="http://niseko.us/be">The Barn</a>.<br />Thanks to everybody for participating. Have an epic season!</b>';
					
					echo 'The NISEKO FIRST SNOW entry period for 2013 expired on the 31st of October. Eyes on the skies!';
					
				echo '</td>';
			echo '</tr>';
			
			echo '<tr bgcolor="#dddddd">';
				echo '<td class="borderAlignCenter">' . agileResource('submissionDate') . '</td>';
				echo '<td class="borderAlignCenter">' . agileResource('entrant') . '</td>';
				echo '<td class="borderAlignCenter">' . agileResource('predictedDateAndTime') . '</td>';
				echo '<td class="borderAlignCenter">' . agileResource('year') . '</td>';
				echo '<td class="borderAlignCenter">' . agileResource('result') . '</td>';
			echo '</tr>';
			
			$resultGetSnowPredictions = mysql_query("SELECT * FROM snowPrediction ORDER BY snowPredictionDateTimeOfPrediction DESC");
			$iRow = 0;
			while($rowGetSnowPredictions = mysql_fetch_array($resultGetSnowPredictions)) {
				if ($iRow % 2 == 0) { echo '<tr bgcolor="#ffffff"'; } else { echo '<tr bgcolor="#eeeeee"'; }
				if ($rowGetSnowPredictions['snowPredictionResult'] == 'winner') { echo ' style="color:#00f;"';
				} elseif ($rowGetSnowPredictions['year'] != 2013) { echo ' style="color:#666;"'; }
				echo '>';
					echo '<td class="borderAlignCenter">' . $rowGetSnowPredictions['snowPredictionDateTimeSubmitted'] . '</td>';
					echo '<td class="borderAlignLeft">' . getUserName($rowGetSnowPredictions['userID']) . '</td>';
					echo '<td class="borderAlignCenter">' . date('Y-M-d H:i', strtotime($rowGetSnowPredictions['snowPredictionDateTimeOfPrediction'])) . '</td>';
					echo '<td class="borderAlignCenter">' . $rowGetSnowPredictions['year'] . '</td>';
					echo '<td class="borderAlignCenter">' . $rowGetSnowPredictions['snowPredictionResult'] . '</td>';
				echo '</tr>';
				$iRow = $iRow + 1;
			}
			
		echo '</table>';
		
	echo '</div>';
	
}


?>