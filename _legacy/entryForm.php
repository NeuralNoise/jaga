<?php

include 'agileIncludes/config.php';
if (isset($_GET['lang'])) { setLanguage($_GET['lang']); } else { setLanguage('en'); }

if (is_authed()) {

	if (!isset($_POST['submit'])) {
						
		displayHeader();

			echo '<div align="center" style="text-align:center;">';
				echo '<b>Welcome to the 6th Annual Kutchannel "Niseko First Snow" Contest!</b>';	
			echo '</div>';

			echo '<div align="center" style="text-align:center;">';
							
			// echo '<form action="/' . languageUrlPrefix() . 'first-snow-entry-form/" method="post">';	
			echo '<table style="margin:10px auto 0px auto;background-color:#ffffff;">';
								
			
			echo '<tr>';
				echo '<td colspan="2" class="borderAlignCenter">';
					echo '<b>The entry period has expired. Please try again next year!</b>';
				echo '</td>';
			echo '</tr>';
			
								
			// echo '<tr>';
				// echo '<td colspan="2" class="borderAlignCenter">';
					// echo '<b>' . agileResource('goAheadAndMakeYourPredictionHere') . '</b>';
				// echo '</td>';
			// echo '</tr>';
								
			// echo '<tr>';
				// echo '<td class="borderAlignCenter" style="width:100px;">' . agileResource('location') . '</td>';
				// echo '<td class="borderAlignCenter">' . agileResource('dateAndTime') . '</td>';
			// echo '</tr>';
								
			/*
			$resultGetSnowLocations = mysql_query("SELECT * FROM snowLocation WHERE snowLocationEnabled = 1");
			while($rowGetSnowLocations = mysql_fetch_array($resultGetSnowLocations)) {
								
				echo '<tr>';
				echo '<td class="borderAlignCenter" style="width:100px;">';
					echo getSnowLocationName($rowGetSnowLocations['snowLocationID']);
				echo '</td>';
				echo '<td class="borderAlignCenter">';
					echo '<input type="text" name="snowPrediction[' . $rowGetSnowLocations['snowLocationID'] . ']" id="inputField' . $rowGetSnowLocations['snowLocationID'] . '" style="width:150px" value="' . date('Y-m-d 12:00:00') . '"  readonly="true" /><button type="reset" id="inputButton' . $rowGetSnowLocations['snowLocationID'] . '">...</button>';
					echo '
						<script type="text/javascript">
							Calendar.setup({
								inputField     :    "inputField' . $rowGetSnowLocations['snowLocationID'] . '",      // id of the input field
								ifFormat       :    "%Y-%m-%d %H:%M:%S",       // format of the input field
								showsTime      :    true,            // will display a time selector
								button         :    "inputButton' . $rowGetSnowLocations['snowLocationID'] . '",   // trigger for the calendar (button ID)
								singleClick    :    false,           // double-click mode
								step           :    1                // show all years in drop-down boxes (instead of every other year as default)
							});
						</script>
					';
				echo '</td>';
				echo '</tr>';

			}

			echo '<tr>';
				echo '<td class="borderAlignCenter" colspan="2">';
					echo '<input name="submit" type="submit" value="Submit Your Prediction!">';
				echo '</td>';
			echo '</tr>';
			*/
			
			echo '</table>';
			// echo '</form>';
							
			echo '</div>';
						
			echo '<div align="center" style="text-align:center;">';
				echo '"The Village" this year is once again defined as snow coverage of the patio in front of our kind sponsor, <a class="nisekoBlue" href="http://niseko.us/aa" target="_blank">The Barn</a>.';
				// echo '<br />If you submit the form multiple times, we\'ll use your most recent entry.';
			echo '</div>';

			displayFooter();
							
		} elseif (isset($_POST['submit'])) {

			// $snowPredictionDateTimeSubmitted = date('Y-m-d H:i:s');
			// $userID = $_SESSION['userID'];
			// $predictionArray = $_POST['snowPrediction'];
			// $year = date('Y');

			// foreach ($predictionArray as $key => $value) {
				// $queryInsertPrediction = "INSERT INTO snowPrediction (
					// userID, 
					// snowLocationID, 
					// snowPredictionDateTimeSubmitted,
					// snowPredictionDateTimeOfPrediction,
					// year
				// ) VALUES (
					// '$userID', 
					// '$key', 
					// '$snowPredictionDateTimeSubmitted',
					// '$value',
					// '$year'
				// )";
				// mysql_query($queryInsertPrediction);
			// }
				
			// $forwardURL = '/';		
			// header("Location: $forwardURL");
						
		}
			
	} else {
	
		displayHeader();
		
			echo '<div align="center" style="text-align:center;">';
				echo 'A <a href="http://niseko.kutchannel.net/">Kutchannel</a> login is required to submit the entry form. The deadline for entries this year is October 31st!';
			echo '</div>';
		
			echo '<div align="center" style="text-align:left;">';
		
				echo '<ul>';
					echo '<li>If you already have a Kutchannel login, <i>right on</i>, just login and submit your "Niseko First Snow" entry form.</li>';
					echo '<li>If you don\'t have a Kutchannel login yet, <i>no wuckas</i>, just <a href="http://niseko.kutchannel.net/' . languageUrlPrefix() . 'register/">register for a free Kutchannel account today</a>!</li>';
				echo '</ul>';
				
			echo '</div>';
		
			echo '<div align="center" style="text-align:center;">';
				echo 'Login and submit your predictions for a chance to win a free world class dinner for 4 at <a href="http://niseko.us/aa" target="_blank">The Barn</a> during your visit to <a href="http://niseko.kutchannel.net/" target="_blank">Niseko</a> this winter.';
			echo '</div>';
		
		displayFooter();
		
	}
 
?>