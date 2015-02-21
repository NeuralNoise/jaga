<?php

	include($_SERVER['DOCUMENT_ROOT'] . '/jaga/php/config/config.php');

	$textColor = '#555555';
	$textColorRed = hexdec(substr($textColor, 1, 2));
	$textColorGreen = hexdec(substr($textColor, 3, 2));
	$textColorBlue = hexdec(substr($textColor, 5, 2));
	
	$backgroundColor = '#eeeeee';
	$backgroundColorRed = hexdec(substr($backgroundColor, 1, 2));
	$backgroundColorGreen = hexdec(substr($backgroundColor, 3, 2));
	$backgroundColorBlue = hexdec(substr($backgroundColor, 5, 2));
	
	$image = imagecreate(70,20);
	$setBackgroundColor = imagecolorallocate($image, $backgroundColorRed, $backgroundColorGreen, $backgroundColorBlue);
	$setTextColor = imagecolorallocate($image, $textColorRed, $textColorGreen, $textColorBlue);
	
	$raptchaCode =  substr(md5(uniqid(rand())), 0, 6);
	Session::setSession('raptcha', $raptchaCode);

	imagettftext($image, 14, 0, 7, 17, $setTextColor, "../fonts/times.ttf", $raptchaCode);
	header("content-type: image/png");
	imagepng($image);
	imagedestroy($image);

?>