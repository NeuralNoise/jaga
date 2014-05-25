<?php

function is_authed() {
	// Check if the encrypted username is the same
	// as the unencrypted one, if it is, it hasn't been changed
	if (isset($_SESSION['userName']) && (md5($_SESSION['userName']) == $_SESSION['encrypted_name'])) {
		return true;
	} else {
		return false;
	}
}

?>