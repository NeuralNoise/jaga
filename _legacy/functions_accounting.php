<?php

function getClientName($clientID) {
	$resultGetClientName = mysql_query("SELECT clientNameEnglish, clientNameJapanese FROM accounting_client WHERE clientID = $clientID");
	while($rowGetClientName = mysql_fetch_array($resultGetClientName)) {
		if ($_SESSION['lang'] == 'ja') {
			$clientName = $rowGetClientName['clientNameJapanese'];
		} else {
			$clientName = $rowGetClientName['clientNameEnglish'];
		}
		
	}
	return $clientName;
}

function getProductServiceName($productServiceID) {
	$resultGetProductServiceName = mysql_query("SELECT productServiceNameEnglish, productServiceNameJapanese FROM accounting_productService WHERE productServiceID = $productServiceID");
	while($rowGetProductServiceName = mysql_fetch_array($resultGetProductServiceName)) {
		
		if ($_SESSION['lang'] == 'ja') {
			$productServiceName = $rowGetProductServiceName['productServiceNameJapanese'];
		} else {
			$productServiceName = $rowGetProductServiceName['productServiceNameEnglish'];
		}
	}
	return $productServiceName;
}

function getUnitSpecifier($unitSpeciferID = 0) {
	
	$query = "SELECT * FROM accounting_unitSpecifier WHERE unitSpecifierID = '$unitSpeciferID' LIMIT 1";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		if ($_SESSION['lang'] == 'ja') {
			$unitSpecifier = $row['unitSpecifierJapanese'];
		} else {
			$unitSpecifier = $row['unitSpecifierEnglish'];
		}
	}
	return $unitSpecifier;
}

function displayTransactionList($clientID, $productServiceID, $startDate, $endDate) {

	if ($_SESSION['lang'] == 'en') { $languageUrlPrefix = ''; } else { $languageUrlPrefix = $_SESSION['lang'] . '/'; }
	
	$userClientArrayString = join(',', $_SESSION['userClientArray']);
	
	$transactionWhereClause = 'WHERE siteID = ' . $_SESSION['siteID'] . ' AND clientID IN (' . $userClientArrayString . ')';
	if ($clientID != 'all') { $transactionWhereClause = $transactionWhereClause . ' AND clientID = ' . $clientID; }
	if ($productServiceID != 'all') { $transactionWhereClause = $transactionWhereClause . ' AND productServiceID = ' . $productServiceID; }
	$transactionWhereClause = $transactionWhereClause . ' AND transactionEndDate >= \'' . $startDate . '\' AND transactionEndDate <= \'' . $endDate . '\'';

	$result = mysql_query("SELECT * FROM accounting_transaction $transactionWhereClause ORDER BY transactionID DESC");
	
	
		echo '<div style="text-align:center;font-size:11px;">';
			echo '<table style="margin:5px auto 5px auto;background-color:#fff;width:100%;font-family:verdana;font-size:10px;">';
			
				echo '<tr>';
					echo '<td class="borderAlignLeft" colspan="15">';
						echo '<input type="button" value="' . agileResource('addTransaction') . '" onclick="window.location.href=\'' . languageUrlPrefix() . 'transactions/create/\'">';
					echo '</td>';
				echo '</tr>';
				
				if ($_SESSION['testMode'] == 'on') {
					echo '<tr>';
						echo '<td class="borderAlignRight" colspan="15">';
								echo $transactionWhereClause;
						echo '</td>';
					echo '</tr>';
				}
				
				echo '<tr>';
					echo '<td class="borderAlignRight" colspan="15">';
							displayTransactionListFilter($clientID, $productServiceID, $startDate, $endDate);
					echo '</td>';
				echo '</tr>';
				
				echo '<tr>';
					echo '<td class="fieldLabelCenter">' . agileResource('ID') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('date') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('clientName') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('productOrService') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('description') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('quantity') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('unitSpecifier') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('unitPrice') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('lineTotal') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('taxIncluded') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('invoiceable') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('invoice') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('status') . '</td>';
					echo '<td class="fieldLabelCenter">' . agileResource('action') . '</td>';
				echo '</tr>';
				
				$iRow = 0;
				$transactionTotal = 0;
				
				while($row = mysql_fetch_array($result)) {

						if ($iRow % 2 == 0) { echo '<tr style="background-color:#fff;">'; } else { echo '<tr style="background-color:#ddd;">'; }

							echo '<td class="borderAlignCenter">' . $row['transactionID'] . '</td>';
							echo '<td class="borderAlignCenter">' . $row['transactionEndDate'] . '</td>';
							echo '<td class="borderAlignCenter">' . getClientName($row['clientID']) . '</td>';
							echo '<td class="borderAlignCenter">' . getProductServiceName($row['productServiceID']) . '</td>';
							echo '<td class="borderAlignCenter"><a class="agileTooltip"><span>' . $row['transactionDescription'] . '</span>
							<img src="agileImages/speechBubble.png" style="height:15px;"></a></td>';
							echo '<td class="borderAlignCenter">' . $row['transactionQuantity'] . '</td>';
							echo '<td class="borderAlignCenter">' . getUnitSpecifier($row['unitSpecifierID']) . '</td>';
							echo '<td class="borderAlignRight">';
								if ($row['transactionUnitPrice'] != 0) { echo '&yen;' . number_format($row['transactionUnitPrice']); }
							echo '</td>';
							echo '<td class="borderAlignRight">';
								if ($row['transactionTotal'] != 0) { echo '&yen;' . number_format($row['transactionTotal']); }
							echo '</td>';
							echo '<td class="borderAlignCenter">';
								if ($row['transactionTaxIncluded'] == 1) { echo '&#10004;'; }
							echo '</td>';
							echo '<td class="borderAlignCenter">';
								if ($row['transactionDisplayOnInvoice'] == 1) { echo '&#10004;'; }
							echo '</td>';
							echo '<td class="borderAlignCenter">';
								if ($row['invoiceID'] != 0) { echo $row['invoiceID']; } else { echo '&nbsp;'; }
							echo '</td>';
							echo '<td class="borderAlignCenter">' . agileResource($row['transactionStatus']) . '</td>';
							echo '<td class="borderAlignCenter">';
								
								if ($row['transactionStatus'] == 'pending') {
									echo '<input type="button" value="' . agileResource('updateTransaction') . '" onclick="window.location.href=\'' . languageUrlPrefix() . 'transaction/update/' . $row['transactionID']  . '/\'">';
								}
							
							echo '</td>';
							
						echo '</tr>';
						
						$iRow = $iRow + 1;
						$transactionTotal = $transactionTotal + $row['transactionTotal'];

				}
				
				echo '<tr>';
					echo '<td class="borderAlignRight" colspan="10"></td>';
					echo '<td class="borderAlignRight">&yen;' . number_format($transactionTotal) . '</td>';
					echo '<td class="borderAlignCenter" colspan="4"></td>';
				echo '</tr>';
				
			echo '</table>';
		echo '</div>';
}

function getClientNameThisLanguage($clientID) {
	if ($_SESSION['lang'] == 'ja') {
		$resultGetClientName = mysql_query("SELECT clientNameJapanese FROM accounting_client WHERE clientID = '$clientID' LIMIT 1");
		while($rowGetClientName = mysql_fetch_array($resultGetClientName)) {
			$client = $rowGetClientName['clientNameJapanese'];
		}
	} else {
		$resultGetClientName = mysql_query("SELECT clientNameEnglish FROM accounting_client WHERE clientID = '$clientID' LIMIT 1");
		while($rowGetClientName = mysql_fetch_array($resultGetClientName)) {
			$client = $rowGetClientName['clientNameEnglish'];
		}
	}
	
	return $client;
}

function getPaymentMethodName($paymentMethodID) {
	if ($_SESSION['lang'] == 'ja') {
		$resultGetPaymentMethodName = mysql_query("SELECT paymentMethodJapanese FROM accounting_paymentMethod WHERE paymentMethodID = '$paymentMethodID' LIMIT 1");
		while($rowGetPaymentMethodName = mysql_fetch_array($resultGetPaymentMethodName)) {
			$paymentMethodName = $rowGetPaymentMethodName['paymentMethodJapanese'];
		}
	} else {
		$resultGetPaymentMethodName = mysql_query("SELECT paymentMethodEnglish FROM accounting_paymentMethod WHERE paymentMethodID = '$paymentMethodID' LIMIT 1");
		while($rowGetPaymentMethodName = mysql_fetch_array($resultGetPaymentMethodName)) {
			$paymentMethodName = $rowGetPaymentMethodName['paymentMethodEnglish'];
		}
	}
	
	return $paymentMethodName;
}

function getDomainName($domainID) {

	$resultGetDomainName = mysql_query("SELECT domainName FROM nisekocms_domain WHERE domainID = '$domainID' LIMIT 1");
	while($rowGetDomainName = mysql_fetch_array($resultGetDomainName)) {
		$domainName = $rowGetDomainName['domainName'];
	}
	return $domainName;
}

function insertPayment($paymentDate, $clientID, $paymentMethodID, $paymentAmount, $paymentComment) {

		$siteID = $_SESSION['siteID'];

		$query = "INSERT INTO accounting_payment (
			siteID,
			paymentDate,
			clientID, 
			paymentMethodID,
			paymentAmount, 
			paymentComment
		) VALUES (
			$siteID,
			'$paymentDate',
			$clientID,
			'$paymentMethodID',
			'$paymentAmount',
			'$paymentComment'
		)";
		
		mysql_query ($query) or die ('Could not create task entry via function.');
	
}

function displayClientList() {
		
					$result = mysql_query("SELECT * FROM accounting_client WHERE siteID = '$_SESSION[siteID]' ORDER BY clientNameEnglish ASC");

					echo '<div style="text-align:center;">';
						echo '<table style="margin:5px auto 5px auto;background-color:#fff;width:100%;font-family:verdana;font-size:10px;">';
						
							echo '<tr>';
								echo '<td class="borderAlignLeft" colspan="';
									if ($_SESSION['testMode'] == 'on') { echo '13'; } else { echo '12'; }
								echo '">';
									echo '<input type="button" value="' . agileResource('createClient') . '" onclick="window.location.href=\'' . languageUrlPrefix() . 'clients/create/\'">';
								
								echo '</td>';
							echo '</tr>';
							
							echo '<tr>';
								echo '<td class="fieldLabel">' .agileResource('clientID') . '</td>';
								echo '<td class="fieldLabel">' .agileResource('clientName') . '</td>';
								echo '<td class="fieldLabel">' .agileResource('clientEMail') . '</td>';
								echo '<td class="fieldLabel">' .agileResource('clientURL') . '</td>';
								echo '<td class="fieldLabel">' .agileResource('clientPhone') . '</td>';
								echo '<td class="fieldLabel">' .agileResource('countryID') . '</td>';
								echo '<td class="fieldLabel">' .agileResource('action') . '</td>';
							echo '</tr>';

							while($row = mysql_fetch_array($result)) {
							
								$clientID = $row['clientID'];
							
								echo '<tr>';
									echo '<td class="borderAlignCenter">' . $row['clientID'] . '</td>';
									echo '<td class="borderAlignCenter">';
										if ($_SESSION['lang'] == 'ja') { echo $row['clientNameJapanese']; } else { echo $row['clientNameEnglish']; }
									echo '</td>';
									echo '<td class="borderAlignCenter">';
										if ($row['clientEMail'] != '') {
											echo '<a href="mailto:' . $row['clientEMail'] . '"><img src="agileImages/mail.png"></a>';
										}
									echo '</td>';
									echo '<td class="borderAlignCenter">';
										if ($row['clientURL'] != '') { echo '<a href="' . $row['clientURL'] . '" target="_new"><img src="agileImages/www.png"></a>';}
									echo '</td>';
									echo '<td class="borderAlignCenter">' . $row['clientPhone'] . '</td>';
									echo '<td class="borderAlignCenter">' . getCountryName($row['countryID']) . '</td>';
									echo '<td class="borderAlignCenter">';
										echo '<input type="button" value="' . agileResource('updateClient') . '" onclick="window.location.href=\'' . languageUrlPrefix() . 'clients/update/' . $clientID . '/\'">';
									echo '</td>';
								echo '</tr>';
							}
					
						echo '</table>';
					echo '</div>';
}

function displayClientCrud(
	$type = 'create',
	$clientID = 0,
	$clientNameEnglish = '',
	$clientNameJapanese = '',
	$clientNameJapaneseReading = '',
	$clientAbbreviatedName = '',
	$clientAddress1 = '',
	$clientAddress2 = '',
	$cityID = 0,
	$stateID = 0,
	$countryID = 0,
	$clientPostalCode = '',
	$clientPhone = '',
	$clientFax = '',
	$clientURL = '',
	$clientEMail = '',
	$contractArray = array(),
	$errorArray = array()
) {

		$siteID = $_SESSION['siteID'];
		
		if ($type == 'create') {
			$formUrl = languageUrlPrefix() . 'clients/create/';
			$pageTitle = 'createClient';
			$submitButtonValue = 'createClient';
		} elseif ($type == 'update') {
			$formUrl = languageUrlPrefix() . 'clients/update/' . $clientID . '/';
			$pageTitle = 'updateClient';
			$submitButtonValue = 'updateClient';
		}

		if ($type = 'update' && empty($errorArray)) {
		
			$resultGetClientData = mysql_query("SELECT * FROM accounting_client WHERE clientID = $clientID LIMIT 1");
			while ($rowGetClientData = mysql_fetch_array($resultGetClientData)) {
				$clientNameEnglish = $rowGetClientData['clientNameEnglish'];
				$clientNameJapanese = $rowGetClientData['clientNameJapanese'];
				$clientNameJapaneseReading = $rowGetClientData['clientNameJapaneseReading'];
				$clientAbbreviatedName = $rowGetClientData['clientAbbreviatedName'];
				$clientAddress1 = $rowGetClientData['clientAddress1'];
				$clientAddress2 = $rowGetClientData['clientAddress2'];
				$cityID = $rowGetClientData['cityID'];
				$stateID = $rowGetClientData['stateID'];
				$countryID = $rowGetClientData['countryID'];
				$clientPostalCode = $rowGetClientData['clientPostalCode'];
				$clientPhone = $rowGetClientData['clientPhone'];
				$clientFax = $rowGetClientData['clientFax'];
				$clientURL = $rowGetClientData['clientURL'];
				$clientEMail = $rowGetClientData['clientEMail'];
			}

			$resultGetContractArray = mysql_query("SELECT * FROM contract_contractClient WHERE clientID = $clientID ORDER BY contractID ASC");
			while ($rowGetContractArray = mysql_fetch_array($resultGetContractArray)) { $contractArray[] = $rowGetContractArray['contractID']; }
		
		}





						echo '<p align="center">' . agileResource($pageTitle) . '</p>';

						
						
						
						echo '<form action="' . $formUrl . '" method="post">';
						
						echo '<table style="border-style:none;margin:5px auto 5px auto;font-family:verdana;font-size:10px;">';

						echo '<tr>';
							echo '<td class="borderAlignLeft">' . agileResource('clientNameEnglish') . '</td>';
							echo '<td class="borderAlignCenter"><input name="clientNameEnglish" type="textbox" style="width:300px;" value="' . $clientNameEnglish . '"></td>';
						echo '</tr>';

						echo '<tr>';
							echo '<td class="borderAlignLeft">' . agileResource('clientNameJapanese') . '</td>';
							echo '<td class="borderAlignCenter"><input name="clientNameJapanese" type="textbox" style="width:300px;" value="' . $clientNameJapanese . '"></td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td class="borderAlignLeft">' . agileResource('clientNameJapaneseReading') . '</td>';
							echo '<td class="borderAlignCenter"><input name="clientNameJapaneseReading" type="textbox" style="width:300px;" value="' . $clientNameJapaneseReading . '"></td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td class="borderAlignLeft">' . agileResource('clientAbbreviatedName') . '</td>';
							echo '<td class="borderAlignCenter"><input name="clientAbbreviatedName" type="textbox" style="width:300px;" value="' . $clientAbbreviatedName . '"></td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td class="borderAlignLeft">' . agileResource('clientAddress1') . '</td>';
							echo '<td class="borderAlignCenter"><input name="clientAddress1" type="textbox" style="width:300px;" value="' . $clientAddress1 . '"></td>';
						echo '</tr>';
						
						
						
						echo '<tr>';
							echo '<td class="borderAlignLeft">' . agileResource('clientAddress2') . '</td>';
							echo '<td class="borderAlignCenter"><input name="clientAddress2" type="textbox" style="width:300px;" value="' . $clientAddress2 . '"></td>';
						echo '</tr>';
						
						
						echo '<tr>';
							echo '<td class="borderAlignLeft">' . agileResource('geographicalLocation') . '</td>';
							echo '<td class="borderAlignCenter">';
							
								displayGeographyWidget($countryID, $stateID, $cityID);
							
							echo '</td>';
						echo '</tr>';
						
						
						echo '<tr>';
							echo '<td class="borderAlignLeft">' . agileResource('clientPostalCode') . '</td>';
							echo '<td class="borderAlignCenter"><input name="clientPostalCode" type="textbox" style="width:300px;" value="' . $clientPostalCode . '"></td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td class="borderAlignLeft">' . agileResource('clientPhone') . '</td>';
							echo '<td class="borderAlignCenter"><input name="clientPhone" type="textbox" style="width:300px;" value="' . $clientPhone . '"></td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td class="borderAlignLeft">' . agileResource('clientFax') . '</td>';
							echo '<td class="borderAlignCenter"><input name="clientFax" type="textbox" style="width:300px;" value="' . $clientFax . '"></td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td class="borderAlignLeft">' . agileResource('clientURL') . '</td>';
							echo '<td class="borderAlignCenter"><input name="clientURL" type="textbox" style="width:300px;" value="' . $clientURL . '"></td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td class="borderAlignLeft">' . agileResource('clientEMail') . '</td>';
							echo '<td class="borderAlignCenter"><input name="clientEMail" type="textbox" style="width:300px;" value="' . $clientEMail . '"></td>';
						echo '</tr>';

						echo '<tr>';
							echo '<td class="borderAlignLeft">' . agileResource('contracts') . '</td>';
							echo '<td class="borderAlignCenter">';
								
								
								echo '<select name="contractID[]" multiple="multiple" style="width:300px;">';
										$resultDisplayContractListbox = mysql_query("SELECT * FROM contract_contract WHERE siteID = $siteID ORDER BY contractTitleEnglish ASC");
										while ($rowDisplayContractListbox = mysql_fetch_array($resultDisplayContractListbox)) {
											echo '<option value="' . $rowDisplayContractListbox['contractID'] . '"';
												if (in_array($rowDisplayContractListbox['contractID'], $contractArray)) { echo ' selected="true"'; }
											echo '>';
												echo $rowDisplayContractListbox['contractTitleEnglish'];
											echo '</option>';
										}
								echo '</select>';
								
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td class="borderAlignCenter" colspan="2">';
								echo '<input name="submit" type="submit" value="' . agileResource($submitButtonValue) . '">';
							echo '</td>';
						echo '</tr>';

						echo '</table>';

						echo '</form>';




}

function insertClient(
	$clientNameEnglish, 
	$clientNameJapanese, 
	$clientNameJapaneseReading, 
	$clientAbbreviatedName, 
	$clientAddress1, 
	$clientAddress2, 
	$cityID, 
	$stateID, 
	$countryID, 
	$clientPostalCode, 
	$clientPhone, 
	$clientFax, 
	$clientURL, 
	$clientEMail, 
	$contractArray = array()
) {
	
	$siteID = $_SESSION['siteID'];
	$clientCreatedByUserID = $_SESSION['userID'];
	$clientCreatedByDateTime = date('Y-m-d H:i:s');
						
	$query = "INSERT INTO accounting_client (
		siteID,
		clientCreatedByUserID,
		clientCreatedByDateTime,
		clientNameEnglish, 
		clientNameJapanese,
		clientNameJapaneseReading,
		clientAbbreviatedName,
		clientAddress1,
		clientAddress2,
		cityID,
		stateID,
		countryID,
		clientPostalCode,
		clientPhone,
		clientFax,
		clientURL,
		clientEMail
	) VALUES (
		'$siteID',
		'$clientCreatedByUserID',
		'$clientCreatedByDateTime',
		'$clientNameEnglish', 
		'$clientNameJapanese',
		'$clientNameJapaneseReading',
		'$clientAbbreviatedName',
		'$clientAddress1',
		'$clientAddress2',
		'$cityID',
		'$stateID',
		'$countryID',
		'$clientPostalCode',
		'$clientPhone',
		'$clientFax',
		'$clientURL',
		'$clientEMail'
	)";
						
	mysql_query ($query) or die ('Could not create client via insertClient()');
	$clientID = mysql_insert_id();

	insertIntoContractClient($clientID, $contractArray);
	insertIntoClientUserPerSiteSettings($clientID);

}

function insertIntoContractClient($clientID, $contractArray) {

	$signedContractArray = array();
	$resultGetSignedContracts = mysql_query("SELECT * FROM contract_contractClient WHERE clientID = $clientID AND contractSigned = 1");
	while ($rowGetSignedContracts = mysql_fetch_array($resultGetSignedContracts)) { $signedContractArray[] = $rowGetSignedContracts['contractID']; }
		
	if (!empty($contractArray)) {
		foreach ($contractArray as $contractID) {
			if (!in_array($contractID, $signedContractArray)) {
				$query = "INSERT INTO contract_contractClient (
					clientID,
					contractID
				) VALUES (
					$clientID, 
					$contractID
				)";
				mysql_query ($query) or die ('could not link client to contract via insertIntoContractClient()');
			}
		}
	}	
}

function deleteUnsignedClientContracts($clientID) {
	$query = "DELETE FROM contract_contractClient WHERE clientID = '$clientID'";
	mysql_query ($query) or die ('could not unlink contract and client in deleteUnsignedClientContracts()');
}

function updateClient(
	$clientID, 
	$clientNameEnglish, 
	$clientNameJapanese, 
	$clientNameJapaneseReading, 
	$clientAbbreviatedName, 
	$clientAddress1, 
	$clientAddress2, 
	$cityID, 
	$stateID, 
	$countryID, 
	$clientPostalCode, 
	$clientPhone, 
	$clientFax, 
	$clientURL, 
	$clientEMail, 
	$contractArray
) {

	$resultUpdateClient = "UPDATE accounting_client SET
			clientNameEnglish = '$clientNameEnglish', 
			clientNameJapanese = '$clientNameJapanese',
			clientNameJapaneseReading = '$clientNameJapaneseReading',
			clientAbbreviatedName = '$clientAbbreviatedName',
			clientAddress1 = '$clientAddress1',
			clientAddress2 = '$clientAddress2',
			cityID = '$cityID',
			stateID = '$stateID',
			countryID = '$countryID',
			clientPostalCode = '$clientPostalCode',
			clientPhone = '$clientPhone',
			clientFax = '$clientFax',
			clientURL = '$clientURL',
			clientEMail = '$clientEMail'
			WHERE clientID = $clientID LIMIT 1";

	mysql_query($resultUpdateClient) or die ('could not update user via resultUpdateClient in updateClient()');
	
	deleteUnsignedClientContracts($clientID);
	insertIntoContractClient($clientID, $contractArray);

}

function displayClientDropdown($clientID) {

	if ($_SESSION['lang'] == 'ja') { $orderBy = 'clientNameJapaneseReading'; } else { $orderBy = 'clientNameEnglish'; }
	$resultGetClientDropDown = mysql_query("
		SELECT * FROM accounting_client 
		WHERE siteID = '$_SESSION[siteID]' 
		ORDER BY $orderBy
	");
	echo '<select name="clientID">';
		echo '<option value="all">' . agileResource('selectAClient') . '</option>';
		while($rowGetClientDropDown = mysql_fetch_array($resultGetClientDropDown)) {
			echo '<option value="' . $rowGetClientDropDown['clientID'] . '"';
				if ($clientID == $rowGetClientDropDown['clientID']) { echo ' selected="selected"'; }
			echo '>';
				echo getClientName($rowGetClientDropDown['clientID']);
			echo '</option>';
		}
	echo '</select>';

}

function displayProductServiceDropdown($productServiceID) {

	if ($_SESSION['lang'] == 'ja') { $orderBy = 'productServiceNameJapanese'; } else { $orderBy = 'productServiceNameEnglish'; }
	$resultGetProductServiceDropDown = mysql_query("SELECT * FROM accounting_productService WHERE siteID = '$_SESSION[siteID]' ORDER BY $orderBy");

	echo '<select name="productServiceID">';
		echo '<option value="all">' . agileResource('selectAProductService') . '</option>';
		while($rowGetProductServiceDropDown = mysql_fetch_array($resultGetProductServiceDropDown)) {
			echo '<option value="' . $rowGetProductServiceDropDown['productServiceID'] . '"';
				if ($productServiceID == $rowGetProductServiceDropDown['productServiceID']) { echo ' selected="selected"'; }
			echo '>';
				echo getProductServiceName($rowGetProductServiceDropDown['productServiceID']);
			echo '</option>';
		}
	echo '</select>';
	
}

function displayTransactionListFilter($clientID, $productServiceID, $startDate, $endDate) {
	echo '<form method="post" action="' . $languageUrlPrefix . 'transactions/">';
			echo '<div style="float:right;">';
					echo '<input type="submit">';
			echo '</div>';
			echo '<div style="float:right;">';
				displayDateInput($endDate, 'endDate', 1);
			echo '</div>';
			echo '<div style="float:right;">';
				displayDateInput($startDate, 'startDate', 1);
			echo '</div>';
			echo '<div style="float:right;">';
				displayProductServiceDropdown($productServiceID);
			echo '</div>';
			echo '<div style="float:right;">';
				displayClientDropdown($clientID);
			echo '</div>';
			echo '<div style="clear:right;"></div>';
	echo '</form>';
	
	
	
}

function insertTransaction(
			$clientID, 
			$productServiceID, 
			$transactionStartDate, 
			$transactionEndDate, 
			$transactionDescription, 
			$transactionQuantity, 
			$unitSpecifierID, 
			$transactionUnitPrice, 
			$transactionTotal, 
			$transactionTaxIncluded, 
			$transactionDisplayOnInvoice,
			$transactionStatus
		) {
		
			$siteID = $_SESSION['siteID'];
			$transactionSubmittedByUserID = $_SESSION['userID'];
			$transactionSubmissionDateTime = date('Y-m-d H:i:s');
			
			$query = "INSERT INTO accounting_transaction (
				siteID,
				clientID,
				transactionSubmittedByUserID,
				transactionSubmissionDateTime,
				productServiceID, 
				transactionStartDate, 
				transactionEndDate, 
				transactionDescription, 
				transactionQuantity, 
				unitSpecifierID, 
				transactionUnitPrice, 
				transactionTotal, 
				transactionTaxIncluded, 
				transactionDisplayOnInvoice,
				transactionStatus
			) VALUES (
				'$siteID',
				'$clientID', 
				'$transactionSubmittedByUserID',
				'$transactionSubmissionDateTime',
				'$productServiceID', 
				'$transactionStartDate', 
				'$transactionEndDate', 
				'$transactionDescription', 
				'$transactionQuantity', 
				'$unitSpecifierID',
				'$transactionUnitPrice',
				'$transactionTotal',
				'$transactionTaxIncluded',
				'$transactionDisplayOnInvoice',
				'$transactionStatus'
			)";
			
			mysql_query ($query) or die ('Could not create transaction via insertTransaction()...');
}

function updateTransaction(
		$transactionID,
		$clientID,
		$productServiceID,
		$transactionStartDate,
		$transactionEndDate,
		$transactionDescription,
		$transactionQuantity,
		$unitSpecifierID,
		$transactionUnitPrice,
		$transactionTotal,
		$transactionTaxIncluded,
		$transactionDisplayOnInvoice,
		$transactionStatus
	) {

	
	$queryUpdateTransaction = "UPDATE accounting_transaction SET
			clientID = '$clientID', 
			productServiceID = '$productServiceID',
			transactionStartDate = '$transactionStartDate',
			transactionEndDate = '$transactionEndDate',
			transactionDescription = '$transactionDescription',
			transactionQuantity = '$transactionQuantity',
			unitSpecifierID = '$unitSpecifierID',
			transactionUnitPrice = '$transactionUnitPrice',
			transactionTotal = '$transactionTotal',
			transactionTaxIncluded = $transactionTaxIncluded,
			transactionDisplayOnInvoice = $transactionDisplayOnInvoice,
			transactionStatus = '$transactionStatus'
			WHERE transactionID = '$transactionID' LIMIT 1";
	mysql_query($queryUpdateTransaction) or die ('could not update transaction via updateTransaction()');

}

function updateTransactionStatus($transactionID, $transactionStatus) {

	$queryUpdateTransaction = "UPDATE accounting_transaction SET
			transactionStatus = '$transactionStatus'
			WHERE transactionID = '$transactionID' LIMIT 1";
	mysql_query($queryUpdateTransaction) or die ('could not update transaction via updateTransactionStatus()');

}

function updateTransactionInvoiceID($transactionID, $invoiceID) {
	$queryUpdateTransaction = "UPDATE accounting_transaction SET
			invoiceID = '$invoiceID'
			WHERE transactionID = '$transactionID' LIMIT 1";
	mysql_query($queryUpdateTransaction) or die ('could not update transaction via updateTransactionInvoiceID()');

}

function getThisSitesClients($siteID = 0) {

	if ($siteID == 0) { $siteID = $_SESSION['siteID']; }
	$thisSitesClients = array();
	$resultGetThisSitesClients = mysql_query("SELECT * FROM accounting_client WHERE siteID = '$siteID' ORDER BY clientID ASC");
	while($rowGetThisSitesClients = mysql_fetch_array($resultGetThisSitesClients)) {
		$thisSitesClients[] = $rowGetThisSitesClients['clientID'];
	}
	return $thisSitesClients;

}

function clientIsThiSitesClient($clientID) {
	$siteID = $_SESSION['siteID'];
	$resultClientIsThisSitesClient = mysql_query("SELECT * FROM accounting_client WHERE clientID = $clientID AND siteID = $siteID LIMIT 1");
	if (mysql_num_rows($resultClientIsThisSitesClient) == 1) { return true; } else { return false; }
}

function displayTransactionCrud(
	$type = 'create', 
	$transactionID = 0, 
	$clientID = 0, 
	$productServiceID = 0, 
	$transactionStartDate = '',
	$transactionEndDate = '',
	$transactionDescription = '',
	$transactionQuantity = 0,
	$unitSpecifierID = 0, 
	$transactionUnitPrice = 0,
	$transactionTotal = 0,
	$transactionTaxIncluded = 1,
	$transactionDisplayOnInvoice = 1,
	$transactionStatus = 'pending'
) {


	$transactionStartDate = date('Y-m-d');
	$transactionEndDate = date('Y-m-d');
	
	if ($type == 'update') {
		$queryGetThisTransaction = "SELECT * FROM accounting_transaction WHERE transactionID = $transactionID LIMIT 1";
		$resultGetThisTransaction = mysql_query($queryGetThisTransaction);
		while ($rowGetThisTransaction = mysql_fetch_array($resultGetThisTransaction)) {
			$transactionID = $rowGetThisTransaction['transactionID'];
			$clientID = $rowGetThisTransaction['clientID'];
			$productServiceID = $rowGetThisTransaction['productServiceID'];
			$transactionStartDate = $rowGetThisTransaction['transactionStartDate'];
			$transactionEndDate = $rowGetThisTransaction['transactionEndDate'];
			$transactionDescription = $rowGetThisTransaction['transactionDescription'];
			$transactionQuantity = $rowGetThisTransaction['transactionQuantity'];
			$unitSpecifierID = $rowGetThisTransaction['unitSpecifierID'];
			$transactionUnitPrice = $rowGetThisTransaction['transactionUnitPrice'];
			$transactionTotal = $rowGetThisTransaction['transactionTotal'];
			$transactionTaxIncluded = $rowGetThisTransaction['transactionTaxIncluded'];
			$transactionDisplayOnInvoice = $rowGetThisTransaction['transactionDisplayOnInvoice'];
			$transactionStatus = $rowGetThisTransaction['transactionStatus'];
		}
	}

echo '<div style="text-align:center;">';
							
				if ($type == 'create') {
					echo '<form action="' . languageUrlPrefix() . 'transactions/create/" method="post">';
				} elseif ($type == 'update') {
					echo '<form action="' . languageUrlPrefix() . 'transaction/update/' . $transactionID . '/" method="post">';
				}
				
				// echo '<h1 style="margin:0px;font-family:verdana;">' . agileResource('transaction') . '</h1>';
				
				echo '<table style="margin:0px auto 0px auto;background-color:#fff;width:100%;font-family:verdana;font-size:10px;">';
								
									echo '<tr>';
										echo '<td class="fieldLabelCenter">' . agileResource('client') . '</td>';
										echo '<td class="fieldLabelCenter">' . agileResource('productOrService') . '</td>';
										echo '<td class="fieldLabelCenter">' . agileResource('startDate') . '</td>';
										echo '<td class="fieldLabelCenter">' . agileResource('endDate') . '</td>';
									echo '</tr>';
									
									echo '<tr>';
									
										echo '<td class="borderAlignCenter">';
											displayClientDropdown($clientID);
										echo '</td>';
										
										echo '<td class="borderAlignCenter">';
											echo '<select name="productServiceID">';
												$result1 = mysql_query("SELECT * FROM accounting_productService WHERE siteID = $_SESSION[siteID] ORDER BY productServiceNameEnglish");
												while($row1 = mysql_fetch_array($result1)) {
												echo '<option value="' . $row1['productServiceID'] . '"';
													if ($row1['productServiceID'] == $productServiceID) { echo ' selected'; }
												echo '>' . $row1['productServiceNameEnglish'] . '</option>';
												}
											echo '</select>';
										echo '</td>';
										
										echo '<td class="borderAlignCenter">';
											echo displayDateInput($transactionStartDate, 'transactionStartDate', 1);
										echo '</td>';
										
										echo '<td class="borderAlignCenter">';
											echo displayDateInput($transactionEndDate, 'transactionEndDate', 1);
										echo '</td>';
										
									echo '</tr>';
									
									echo '<tr>';
										
										echo '<td class="fieldLabelCenter">' . agileResource('quantity') . '</td>';
										echo '<td class="fieldLabelCenter">' . agileResource('unitSpecifier') . '</td>';
										echo '<td class="fieldLabelCenter">' . agileResource('unitPrice') . '</td>';
										echo '<td class="fieldLabelCenter">' . agileResource('total') . '</td>';
									echo '</tr>';
									
									echo '<tr>';
									
										
										
										echo '<td class="borderAlignCenter">';
											echo '<input name="transactionQuantity" type="textbox" id="transactionQuantity" onblur="calculateTransactionTotal()" value="' . $transactionQuantity . '">';
										echo '</td>';

										echo '<td class="borderAlignCenter">';
											echo '<select name="unitSpecifierID">';
												$result2 = mysql_query("SELECT * FROM accounting_unitSpecifier");
												while($row2 = mysql_fetch_array($result2)) {
													echo '<option value="' . $row2['unitSpecifierID'] . '"';
														if ($unitSpecifierID == $row2['unitSpecifierID']) {
															echo ' selected';
														}
													echo '>' . $row2['unitSpecifierEnglish'] . '</option>';
												}
											echo '</select>';
										echo '</td>';

										echo '<td class="borderAlignCenter">';
											echo '<input name="transactionUnitPrice" type="textbox" id="transactionUnitPrice" onblur="calculateTransactionTotal()" value="' . $transactionUnitPrice . '">';
										echo '</td>';
										
										echo '<td class="borderAlignCenter">';
											echo '<input name="transactionTotal" type="textbox" id="transactionTotal" readonly="readonly" value="' . $transactionTotal . '">';
										echo '</td>';
									echo '</tr>';
									
									echo '<tr>';
									
										echo '<td class="fieldLabelCenter">' . agileResource('description') . '</td>';
										echo '<td class="fieldLabelCenter" colspan="3">' . agileResource('details') . '</td>';
									
									echo '</tr>';
									
									echo '<tr>';
									
										echo '<td class="fieldLabelCenter">';
											echo '<input type="text" name="transactionDescription" style="width:200px;" value="' . $transactionDescription . '">';
										echo '</td>';
										echo '<td class="fieldLabelCenter">';
											echo '<input type="checkbox" name="transactionTaxIncluded"  value="1"';
												if ($transactionTaxIncluded == 1) { echo ' checked="checked"'; }
											echo '>';
											echo agileResource('taxIncluded');
										echo '</td>';
										echo '<td class="fieldLabelCenter">';
											echo '<input type="checkbox" name="transactionDisplayOnInvoice"  value="1"';
												if ($transactionDisplayOnInvoice == 1) { echo ' checked="checked"'; }
											echo '>';
											echo agileResource('displayOnInvoice');
										echo '</td>';
										echo '<td class="fieldLabelCenter">';
											displayTransactionStatusDropdown($transactionStatus);
										echo '</td>';
									
									echo '</tr>';
									
									echo '<tr>';
										echo '<td class="borderAlignRight" colspan="5">';
											echo '<input name="submit" type="submit" value="';
											if ($type == 'create') {
												echo agileResource('createTransaction');
											} elseif ($type == 'update') {
												echo agileResource('updateTransaction');
											}
											echo '">';
										echo '</td>';
									echo '</tr>';

								echo '</table>';
								
								echo '</form>';
								
							echo '</div>';

}

function displayTransactionStatusDropdown($transactionStatus) {

	echo '<select name="transactionStatus">';
		echo '<option value="pending"';
			if ($transactionStatus == 'pending') { echo ' selected'; }
		echo '>' . agileResource('pending') . '</option>';
		echo '<option value="invoiced"';
			if ($transactionStatus == 'invoiced') { echo ' selected'; }
		echo '>' . agileResource('invoiced') . '</option>';
		echo '<option value="paid"';
			if ($transactionStatus == 'paid') { echo ' selected'; }
		echo '>' . agileResource('paid') . '</option>';
		echo '<option value="canceled"';
			if ($transactionStatus == 'canceled') { echo ' selected'; }
		echo '>' . agileResource('canceled') . '</option>';
	echo '</select>';

}





function createInvoice(
	$clientID,
	$invoiceYearMonth,
	$invoiceDate,
	$invoiceComment,
	$invoiceSubTotal,
	$invoiceTaxRate,
	$invoiceTax,
	$invoiceTotal,
	$invoicePaymentStatus
) {

		/*
		CREATE TABLE IF NOT EXISTS `accounting_invoice` (
		  `invoiceID` int(8) NOT NULL AUTO_INCREMENT,
		  `siteID` int(8) NOT NULL,
		  `invoiceDateTimeCreated` datetime NOT NULL,
		  `invoiceCreatedByUserID` int(8) NOT NULL,
		  `clientID` int(8) NOT NULL,
		  `invoiceYearMonth` varchar(7) NOT NULL,
		  `invoiceDate` date NOT NULL,
		  `invoiceComment` text NOT NULL,
		  `invoiceSubTotal` decimal(10,2) NOT NULL,
		  `invoiceTaxRate` decimal(4,2) NOT NULL,
		  `invoiceTax` decimal(10,2) NOT NULL,
		  `invoiceTotal` decimal(10,2) NOT NULL,
		  `invoicePaymentStatus` varchar(10) NOT NULL,
		  PRIMARY KEY (`invoiceID`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100001 ;
		*/

		
}





function userCanViewInvoice($userID, $invoiceID) { // invoice must belong to client that user has access to

	$clientArray = array();
	$queryGetClientArray = "SELECT clientID FROM accounting_clientUser WHERE userID = '$userID'";
	$resultGetClientArray = mysql_query($queryGetClientArray);
	while ($rowGetClientArray = mysql_fetch_array($resultGetClientArray)) { $clientArray[] = $rowGetClientArray['clientID']; }
	$clientArrayString = join(',',$clientArray);
	
	$query = "SELECT * FROM accounting_invoice WHERE invoiceID = '$invoiceID' AND clientID IN ($clientArrayString)";
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 1) { return true; } else { return false; }

}





?>