<?php

class Cookie {
	
	public function __construct() {

		$sessionID = md5($_SERVER['REMOTE_ADDR'].'-'.time().'-natto');
		$sessionExpiry = strtotime("+1 month", time());
		
		setcookie(
			'TheKutchannel',
			$sessionID,
			// time() + (31 * 24 * 60 * 60), // one month
			$sessionExpiry,
			'/',
			'.kutchannel.net',
			FALSE
		);

	}
	
}

?>