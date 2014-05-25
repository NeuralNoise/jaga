<?php


function contactDisplayCRUD($contactSurname = '', $contactEMail = '', $contactMessage = '') {

	echo '<div style="text-align:center;">';
		echo '<form name="agileContact" method="post" action="/contact/">';
			echo '<table style="margin:5px auto 5px auto;background-color:#fff;">';
				echo '<tr>';
					echo '<td class="fieldLabelCenter">' . agileResource('contactSurname') . '</td>';
					echo '<td class="fieldLabelCenter" colspan="2">';
						echo '<input type="text" name="contactSurname" value="' . $contactSurname . '" style="width:250px;">';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="fieldLabelCenter">' . agileResource('contactEMail') . '</td>';
					echo '<td class="fieldLabelCenter" colspan="2">';
						echo '<input type="text" name="contactEMail" value="' . $contactEMail . '" style="width:250px;">';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="fieldLabelCenter">' . agileResource('contactMessage') . '</td>';
					echo '<td class="fieldLabelCenter" colspan="2">';
						echo '<textarea name="contactMessage" style="width:250px;height:200px;">' . $contactMessage . '</textarea>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="fieldLabelCenter"><img src="agileModules/nisekocmsCore/view/nisekocms_captcha.php"></td>';
					echo '<td class="fieldLabelCenter"><input type="text" name="agileCaptcha" style="width:75px;"></td>';
					echo '<td class="fieldLabelRight">';
						echo '<input type="submit" name="submit" value="' . agileResource('send') . '">';
					echo '</td>';
				echo '</tr>';
			echo '</table>';
		echo '</form>';
	echo '</div>';
	
}

function checkContactFormDataValidity() {

}

function contactInsertData($contactName, $contactEMail, $contactMessage) {

	$siteID = $_SESSION['siteID'];
	$contactSubmittedByDateTime = date('Y-m-d H:i:s');
	$contactSubmittedFromIpAddress = $_SERVER['REMOTE_ADDR'];
	$contactMessageClean = mysql_real_escape_string($contactMessage);

	$querySaveContactFormSubmission = "INSERT INTO nisekocms_contact (
		siteID,
		contactSubmittedByDateTime,
		contactSubmittedFromIpAddress,
		contactName,
		contactEMail,
		contactMessage
	) VALUES (
		'$siteID',
		'$contactSubmittedByDateTime',
		'$contactSubmittedFromIpAddress',
		'$contactName',
		'$contactEMail',
		'$contactMessageClean'
	)";

	mysql_query ($querySaveContactFormSubmission) or die ('Could not save your submission via contactInsertData().');

}

function contactSendEMail($contactSurname, $contactEMail, $contactMessage) {

	$to = 'support@agilehokkaido.com';
	$subject = '[A message from ' . $contactSurname . ' via ' . getSiteTitle() . ']';
	$message = stripslashes($contactMessage);
	$headers = 'From: ' . $contactEMail;
	mail("$to","$subject","$message","$headers");

}




















function displayRealtyCMSContactForm(
	$contactName = '', 
	$contactAddress = '', 
	$contactHomeTelephone = '', 
	$contactMobile = '', 
	$contactEMail = '', 
	$contactTypePropertyManagement = '', 
	$propertyTypeRentalPropertyEnquiry = '',
	$contactAdditionalFeaturesOrRequirements = '',
	$contactErrorArray = array()
) {

		echo '<form action="' . languageUrlPrefix() . 'contact-us/" method="post" name="contactUsForm">';

		echo '<table id="realtyCmsContact">';
		
			echo '<tr>';
				echo '<td class="realtyCmsContactCenter" colspan="2">';
					displayEasyContentModule(1000246, 'text-align:left;');
				echo '</td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td class="realtyCmsContactLeft">';
					echo agileResource('name');
					echo ' *';
				echo '</td>';
				echo '<td class="realtyCmsContactLeft">';
					echo '<input name="contactName" type="text" style="width:300px;';
						if (in_array('contactName', $contactErrorArray)) { echo 'background-color:#F9CCCA;'; }
					echo '" value="' . $contactName . '" />';
				echo '</td>';
			echo '</tr>';

			echo '<tr>';
				echo '<td class="realtyCmsContactLeft">';
					echo agileResource('address');
				echo '</td>';
				echo '<td class="realtyCmsContactLeft">';
					echo '<textarea name="contactAddress" style="width:300px;">' . $contactAddress . '</textarea>';
				echo '</td>';
			echo '</tr>';
					
			echo '<tr>';
				echo '<td class="realtyCmsContactLeft">';
					echo agileResource('homeTelephone');
				echo '</td>';
				echo '<td class="realtyCmsContactLeft">';
					echo '<input name="contactHomeTelephone" type="text" style="width:300px;" value="' . $contactHomeTelephone . '" />';
				echo '</td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td class="realtyCmsContactLeft">';
					echo agileResource('mobile');
					echo ' *';
				echo '</td>';
				echo '<td class="realtyCmsContactLeft">';
				
					echo '<input name="contactMobile" type="text" style="width:300px;';
						if (in_array('contactMobile', $contactErrorArray)) { echo 'background-color:#F9CCCA;'; }
					echo '" value="' . $contactMobile . '" />';

				echo '</td>';
			echo '</tr>';

					
			echo '<tr>';
				echo '<td class="realtyCmsContactLeft">';
					echo agileResource('email');
					echo ' *';
				echo '</td>';
				echo '<td class="realtyCmsContactLeft">';
					
					echo '<input name="contactEMail" type="text" style="width:300px;';
						if (in_array('contactEMail', $contactErrorArray)) { echo 'background-color:#F9CCCA;'; }
					echo '" value="' . $contactEMail . '" />';
					
				echo '</td>';
			echo '</tr>';

			echo '<tr>';
				echo '<td class="realtyCmsContactLeft">';
					echo agileResource('contactEnquiryType');
				echo '</td>';
				echo '<td class="realtyCmsContactLeft">';
					echo '<input name="contactTypePropertyManagement" type="checkbox" value="1"';
						if ($contactPurchaseTypeBuy == 1) { echo ' checked'; }
					echo '> ' . agileResource('propertyManagementQuoteRequest') . '<br />';
					echo '<input name="contactTypeRental" type="checkbox" value="1"';
						if ($contactPurchaseTypeRent == 1) { echo ' checked'; }
					echo '> ' . agileResource('propertyTypeRentalPropertyEnquiry') . '<br />';
				echo '</td>';
			echo '</tr>';

			echo '<tr>';
				echo '<td class="realtyCmsContactLeft">';
					echo agileResource('contactAdditionalFeaturesOrRequirements');
				echo '</td>';
				echo '<td class="realtyCmsContactLeft">';
					echo '<textarea name="contactAdditionalFeaturesOrRequirements" style="width:300px;height:150px;">' . $contactAdditionalFeaturesOrRequirements . '</textarea>';
				echo '</td>';
			echo '</tr>';

			echo '<tr>';
				echo '<td class="realtyCmsContactLeft" colspan="2">';
					if ($_SESSION['lang'] == 'ja') {
						echo 'あなたのIPアドレスは'. $_SERVER['REMOTE_ADDR'];
					} else {
						echo 'Your computer IP address is '. $_SERVER['REMOTE_ADDR'];
					}
				echo '</td>';
			echo '</tr>';

			echo '<tr>';
				echo '<td class="realtyCmsContactLeft">';
					echo agileResource('confirmSecurityCode');
					echo ' *';
				echo '</td>';
				echo '<td class="realtyCmsContactLeft" style="vertical-align:middle;">';
					echo '<div style="float:left;">';
						echo '<img src="/nisekocms_captcha.php">';
					echo '</div>';
					echo '<div style="float:left;margin-top:5px;">';
						echo '<input name="agileCaptcha" type="text" style="';
							if (in_array('agileCaptcha', $contactErrorArray)) { echo 'background-color:#F9CCCA;'; }
						echo '" size="10" />';
					echo '</div>';
					echo '<div style="clear:both;"></div>';
				echo '</td>';
			echo '</tr>';

			echo '<tr>';
				echo '<td class="realtyCmsContactRight" colspan="2">';
					echo '<input type="submit" name="submit" value="' . agileResource('submitEnquiry') . '">';
				echo '</td>';
			echo '</tr>';
		echo '</table>';
	echo '</form>';
}


function realtyCmsSendContactFormEmail(
	$contactName, 
	$contactAddress, 
	$contactHomeTelephone, 
	$contactMobile, 
	$contactEMail, 
	$contactTypePropertyManagement = '', 
	$propertyTypeRentalPropertyEnquiry = '',
	$contactAdditionalFeaturesOrRequirements = ''
) {

	$siteID = $_SESSION['siteID'];
	$toAddress = getSiteContactFormToAddress($siteID);
	$fromAddress = $contactEMail;
	$mailSubject = 'Enquiry from ' . $contactName . ' via ' . getSiteTitle();
	if (isset($_SESSION['userID'])) { $userID = $_SESSION['userID']; } else { $userID = 0; }
	
	$mailMessage = '<html>';
	$mailMessage .= '<body style="text-align:left;">';

	$mailMessage .= '<table>';
		$mailMessage .= '<tr><td style="border:1px solid #ccc;">' . agileResource('contactName') . '</td><td style="border:1px solid #ccc;">' . $contactName . '</td></tr>';
		$mailMessage .= '<tr><td style="border:1px solid #ccc;">' . agileResource('contactAddress') . '</td><td style="border:1px solid #ccc;">' . $contactAddress . '</td></tr>';
		$mailMessage .= '<tr><td style="border:1px solid #ccc;">' . agileResource('contactHomeTelephone') . '</td><td style="border:1px solid #ccc;">' . $contactHomeTelephone . '</td></tr>';
		$mailMessage .= '<tr><td style="border:1px solid #ccc;">' . agileResource('contactMobile') . '</td><td style="border:1px solid #ccc;">' . $contactMobile . '</td></tr>';
		$mailMessage .= '<tr><td style="border:1px solid #ccc;">' . agileResource('contactEMail') . '</td><td style="border:1px solid #ccc;">' . $contactEMail . '</td></tr>';

		$mailMessage .= '<tr>';
			$mailMessage .= '<td style="border:1px solid #ccc;">' . agileResource('contactTypePropertyManagement') . '</td>';
			$mailMessage .= '<td style="border:1px solid #ccc;">';
				if ($contactTypePropertyManagement == 1) { $mailMessage .= '&#10004;'; } else { $mailMessage .= '&nbsp;'; }
			$mailMessage .= '</td>';
		$mailMessage .= '</tr>';
		
		$mailMessage .= '<tr>';
			$mailMessage .= '<td style="border:1px solid #ccc;">' . agileResource('propertyTypeRentalPropertyEnquiry') . '</td>';
			$mailMessage .= '<td style="border:1px solid #ccc;">';
				if ($propertyTypeRentalPropertyEnquiry == 1) { $mailMessage .= '&#10004;'; } else { $mailMessage .= '&nbsp;'; }
			$mailMessage .= '</td>';
		$mailMessage .= '</tr>';

		$mailMessage .= '<tr><td style="border:1px solid #ccc;">' . agileResource('contactAdditionalFeaturesOrRequirements') . '</td><td style="border:1px solid #ccc;">' . $contactAdditionalFeaturesOrRequirements . '</td></tr>';
		
	$mailMessage .= '</table>';
	$mailMessage .= 'This message was sent from ' . $_SERVER['REMOTE_ADDR'] . '.';
	$mailMessage .= '</body>';
	$mailMessage .= '</html>';
	
	agileMail($toAddress, $fromAddress, $mailSubject, $mailMessage, $siteID, $userID, 'html');
	
}












?>