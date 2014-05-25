<?php

	if ($_SESSION['lang'] == 'en') { $languageUrlPrefix = ''; } else { $languageUrlPrefix = $_SESSION['lang'] . '/'; }

	if (isset($login_error)) {
		echo '<p align="center">' . $login_error . '</p>';
	}

	echo '<div style="text-align:center;">';
	echo '<table style="margin:5px auto 5px auto;">';
	echo '<form action="' . $languageUrlPrefix . 'login/" method="post">';

	echo '<tr>';
		echo '<td class="borderAlignLeft">' . agileResource('userName') . ':</td>';
		echo '<td class="borderAlignLeft">';
			echo '<input type="text" size="20" maxlength="255" name="userName"';
			if (isset($_POST['userName'])) {
				echo ' value="' . $_POST['userName'] . '"';
			}
			echo ' />';
		echo '</td>';
	echo '</tr>';

	echo '<tr>';
		echo '<td class="borderAlignLeft">' . agileResource('password') . ':</td>';
			echo '<td class="borderAlignLeft">';
			echo '<input type="password" size="20" maxlength="255" name="userPassword" />';
			echo '</td>';
		echo '</tr>';
	echo '<tr>';
		echo '<td colspan="2" class="borderAlignCenter">';
			echo '<input type="submit" name="submit" value="' . agileResource('login') . '" />';
		echo '</td>';
	echo '</tr>';

	echo '</form>';

	echo '</table>';

	echo '</div>';

?>