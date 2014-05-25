<?php


function displayShortenURLForm($urlOriginal = 'http://', $urlDescription = '', $urlTag1 = '', $urlTag2 = '', $urlTag3 = '', $errorArray = array()) {

	echo '<form action="' . languageUrlPrefix() . 'shorten-a-url/" method="post">';
	
		echo '<table style="margin:5px auto 5px auto;background-color:#fff;">';
	
			echo '<tr>';
				echo '<td class="fieldLabelLeft" colspan="3">';
					echo agileResource('urlToShorten');
				echo '</td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td class="borderAlignCenter" colspan="3">';
					echo '<input type="text" name="urlOriginal" style="width:400px;';
						if (in_array('urlOriginal', $errorArray)) { echo 'background-color:#F9CCCA;'; }
					echo '" value="' . $urlOriginal . '">';
				echo '</td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td class="fieldLabelLeft" colspan="3">';
					echo agileResource('urlDescription');
				echo '</td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td class="borderAlignCenter" colspan="3">';
					echo '<textarea name="urlDescription" style="width:400px;" ';
					echo 'onKeyDown="limitSizeOfTextArea(this.form.urlDescription,this.form.countdown,115);" ';
					echo 'onKeyUp="limitSizeOfTextArea(this.form.urlDescription,this.form.countdown,115);">';
						echo $urlDescription;
					echo '</textarea>';
				echo '</td>';
			echo '</tr>';
			
			
			echo '<tr>';
				echo '<td class="fieldLabelLeft" colspan="3">';
					echo agileResource('addUpTo3Tags');
				echo '</td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td class="borderAlignCenter">';
					echo '<input type="text" name="urlTag1" value="' . $urlTag1 . '" style="width:100px;">';
				echo '</td>';
				echo '<td class="borderAlignCenter">';
					echo '<input type="text" name="urlTag2" value="' . $urlTag2 . '" style="width:100px;">';
				echo '</td>';
				echo '<td class="borderAlignCenter">';
					echo '<input type="text" name="urlTag3" value="' . $urlTag3 . '" style="width:100px;">';
				echo '</td>';
			echo '</tr>';
			
			if (!is_authed()) {
			
				echo '<tr>';
					echo '<td class="fieldLabelLeft" colspan="3">';
						echo agileResource('securityCodeNecessaryIfNotLoggedIn');
					echo '</td>';
				echo '</tr>';
			
				echo '<tr>';
					echo '<td class="borderAlignCenter">';
						echo '<img src="/agileModules/nisekocmsCore/view/nisekocms_captcha.php">';
					echo '</td>';
					echo '<td class="borderAlignCenter">';
						echo '<input type="text" name="agileCaptcha" style="width:100px;';
							if (in_array('agileCaptcha', $errorArray)) { echo 'background-color:#F9CCCA;'; }
						echo '">';
					echo '</td>';
					echo '<td class="borderAlignCenter">';
						echo '<input type="submit" name="submit" value="' . agileResource('shortenUrl') . '">';
					echo '</td>';
				echo '</tr>';
				
			} else {
			
				echo '<tr>';
					echo '<td class="fieldLabelRight" colspan="3">';
						echo '<input type="submit" name="submit" value="' . agileResource('shortenUrl') . '">';
					echo '</td>';
				echo '</tr>';
			
			}
		
		echo '</table>';
	
	echo '</form>';

}

?>