<?php


function displayNisekoCmsInvoiceList() {

	echo '<div style="text-align:center;">';
		echo '<table style="margin:0px auto 0px auto;background-color:#fff;width:100%;font-family:verdana;font-size:10px;">';
	
			$thisClientsUsers = join(',', $_SESSION['userClientArray']);
			$queryThisClientsUsers = "SELECT clientID FROM accounting_client WHERE clientID IN ($thisClientsUsers) ORDER BY clientNameEnglish";
			$resultThisClientsUsers = mysql_query($queryThisClientsUsers);
			while ($rowThisClientsUsers = mysql_fetch_array($resultThisClientsUsers)) {
			
				$clientID = $rowThisClientsUsers['clientID'];
				
				echo '<tr style="background-color:#ddd;">';
					echo '<td class="borderAlignLeft" colspan="7">' . getClientName($clientID) . '</td>';
				echo '</tr>';

				$queryGetInvoices = "SELECT * FROM accounting_invoice WHERE clientID = '$clientID' ORDER BY invoiceDate ASC LIMIT 12";
				$resultGetInvoices = mysql_query($queryGetInvoices);
				while ($rowGetInvoices = mysql_fetch_array($resultGetInvoices)) {
					
					$invoiceID = $rowGetInvoices['invoiceID'];
					
					echo '<tr style="background-color:#fff;">';
						echo '<td class="borderAlignCenter" style="width:25px;">&rarr;</td>';
						echo '<td class="borderAlignCenter" style="width:25px;">&rarr;</td>';
						echo '<td class="borderAlignLeft">';
							echo date('F Y', strtotime($rowGetInvoices['invoiceYearMonth'])) . ' (' . agileResource('invoice') . ' &#35;' . $invoiceID . ')';
						echo '</td>';
						echo '<td class="borderAlignRight" style="width:75px;">' . getCurrencySymbol() . number_format($rowGetInvoices['invoiceTotal']) . '</td>';
						echo '<td class="borderAlignRight" style="width:75px;">' . agileResource($rowGetInvoices['invoicePaymentStatus']) . '</td>';
						echo '<td class="borderAlignRight" style="width:300px;">';
						
							if ($rowGetInvoices['invoicePaymentStatus'] != 'paid' && ($_SESSION['userRoleForCurrentSite'] == 'siteManager' || $_SESSION['userRoleForCurrentSite'] == 'siteAccountant')) {
							
								echo '<input type="button" value="' . agileResource('markInvoiceAsPaid') . '" onclick="window.location.href=\'/' . languageUrlprefix() . 'invoice/mark-invoice-as-paid/' . $invoiceID . '/\'">';
								
							}
							
							echo '<input type="button" style="width:100px;" value="' . agileResource('viewInvoice') . '" onclick="window.location.href=\'/' . languageUrlprefix() . 'invoice/view/' . $invoiceID . '/\'">';
							echo '<input type="button" value="' . agileResource('printInvoice') . '" onclick="window.location.href=\'/' . languageUrlprefix() . 'invoice/print/' . $invoiceID . '/\'">';
						echo '</td>';
					echo '</tr>';
				
				}

			}

		echo '</table>';
	echo '</div>';

}

function displayNisekoCmsInvoice($invoiceID, $view = 'web') {

	if ($view == 'web') {
		$divStyleAttribute = 'text-align:center;';
		$tableStyleAttribute = 'margin:0px auto 0px auto;background-color:#fff;width:100%;font-family:verdana;font-size:10px;';
	} elseif ($view == 'print') {
		$divStyleAttribute = 'text-align:left;';
		$tableStyleAttribute = 'margin:25px;background-color:#fff;width:700px;font-family:verdana;font-size:11px;';
	}
	
	echo '<div style="' . $divStyleAttribute . '">';
		echo '<table style="' . $tableStyleAttribute . '">';

			$queryGetInvoice = "SELECT * FROM accounting_invoice WHERE invoiceID = '$invoiceID' LIMIT 1";
			$resultGetInvoice = mysql_query($queryGetInvoice);
			while ($rowGetInvoice = mysql_fetch_array($resultGetInvoice)) {
				$clientID = $rowGetInvoice['clientID'];
				$invoiceDate = $rowGetInvoice['invoiceDate'];
				$invoiceSubTotal = $rowGetInvoice['invoiceSubTotal'];
				$invoiceTax = $rowGetInvoice['invoiceTax'];
				$invoiceTotal = $rowGetInvoice['invoiceTotal'];
				$invoicePaymentStatus = $rowGetInvoice['invoicePaymentStatus'];
			}

			echo '<tr style="background-color:#ddd;">';
				echo '<td  style="border:1px solid #ccc;text-align:left;" colspan="8">';
					echo '<h3 style="margin:0px;">' . getSiteTitle() . '</h3>';
				echo '</td>';
			echo '</tr>';
			echo '<tr><td style="border:1px solid #ccc;text-align:right;" colspan="8">' . agileResource('client') . ': ' . getClientName($clientID) . '</td></tr>';
			echo '<tr><td style="border:1px solid #ccc;text-align:right;" colspan="8">' . date('jS F Y', strtotime($invoiceDate)) . '</td></tr>';
			echo '<tr><td style="border:1px solid #ccc;text-align:right;" colspan="8">' . agileResource('invoice') . ': &#35;' . $invoiceID . '</td></tr>';
			
			echo '<tr><td style="border:1px solid #ccc;text-align:right;font-size:12px;" colspan="8">';
				echo '<b>振込先</b><br /><b>銀行支店</b> 北洋銀行末広町支店<br /><b>口座</b> 普通預金 3216953<br /><b>名義</b> ウエブ・クリストフアー・スコツト';
			echo '</td></tr>';
		
			echo '<tr style="background-color:#eee;">';
				echo '<td style="border:1px solid #ccc;text-align:center;">' . agileResource('id') . '</td>';
				echo '<td style="border:1px solid #ccc;text-align:center;">' . agileResource('date') . '</td>';
				echo '<td style="border:1px solid #ccc;text-align:center;">' . agileResource('description') . '</td>';
				echo '<td style="border:1px solid #ccc;text-align:center;">' . agileResource('qtyHours') . '</td>';
				echo '<td style="border:1px solid #ccc;text-align:center;">' . agileResource('unitSpecifier') . '</td>';
				echo '<td style="border:1px solid #ccc;text-align:center;">' . agileResource('unitPrice') . '</td>';
				echo '<td style="border:1px solid #ccc;text-align:center;">' . agileResource('taxIncluded') . '</td>';
				echo '<td style="border:1px solid #ccc;text-align:center;">' . agileResource('lineTotal') . '</td>';
			echo '</tr>';
			
			$queryGetTransactions = "SELECT * FROM accounting_transaction WHERE invoiceID = '$invoiceID' ORDER BY transactionEndDate ASC";
			$resultGetTransactions = mysql_query($queryGetTransactions);
			while ($rowGetTransactions = mysql_fetch_array($resultGetTransactions)) {
				echo '<tr>';
					echo '<td style="border:1px solid #ccc;text-align:center;" style="width:75px;">' . $rowGetTransactions['transactionID'] . '</td>';
					echo '<td style="border:1px solid #ccc;text-align:center;" style="width:75px;">' . $rowGetTransactions['transactionEndDate'] . '</td>';
					echo '<td style="border:1px solid #ccc;text-align:left;">' . $rowGetTransactions['transactionDescription'] . '</td>';
					echo '<td style="border:1px solid #ccc;text-align:center;" style="width:50px;">' . $rowGetTransactions['transactionQuantity'] . '</td>';
					echo '<td style="border:1px solid #ccc;text-align:center;" style="width:50px;">' . getUnitSpecifier($rowGetTransactions['unitSpecifierID']) . '</td>';
					echo '<td style="border:1px solid #ccc;text-align:right;" style="width:50px;">' . getCurrencySymbol() . number_format($rowGetTransactions['transactionUnitPrice'], 0) . '</td>';
					echo '<td style="border:1px solid #ccc;text-align:center;" style="width:50px;">';
						if ($rowGetTransactions['transactionTaxIncluded'] == 1) { echo '&#10004;'; }
					echo '</td>';
					echo '<td style="border:1px solid #ccc;text-align:right;">' . getCurrencySymbol() . number_format($rowGetTransactions['transactionTotal'], 0) . '</td>';
				echo '</tr>';
			}
		
			echo '<tr>';
				echo '<td style="border:1px solid #ccc;text-align:right;" colspan="7" style="background-color:#eee;">' . agileResource('invoiceSubTotal') . '</td>';
				echo '<td style="border:1px solid #ccc;text-align:right;">' . getCurrencySymbol() . number_format($invoiceSubTotal) . '</td>';
			echo '</tr>';
		
			echo '<tr>';
				echo '<td style="border:1px solid #ccc;text-align:right;" colspan="7" style="background-color:#eee;">' . agileResource('invoiceTax') . '</td>';
				echo '<td style="border:1px solid #ccc;text-align:right;">' . getCurrencySymbol() . number_format($invoiceTax) . '</td>';
			echo '</tr>';
		
			echo '<tr>';
				echo '<td style="border:1px solid #ccc;text-align:right;" colspan="7" style="background-color:#eee;">' . agileResource('invoiceTotal') . '</td>';
				echo '<td style="border:1px solid #ccc;text-align:right;"><b>' . getCurrencySymbol() . number_format($invoiceTotal) . '</b></td>';
			echo '</tr>';
			
			/*
			echo '<tr>';
				echo '<td style="border:1px solid #ccc;text-align:left;" colspan="8" style="background-color:#eee;">';
					displayEasyContentModule(1000272, 'float:left;text-align:left;');
				echo '</td>';
			echo '</tr>';
			*/

		echo '</table>';
	echo '</div>';
}

function displayNisekoCmsPrintInvoice($invoiceID) {

	$invoiceTitle = 'INVOICE - ' . $invoiceID;
	
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml">';
	echo '<head>';
	echo '<title>' . $invoiceTitle . '</title>';
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	echo '</head>';
	echo '<body>';
		displayNisekoCmsInvoice($invoiceID, 'print');
	echo '</body>';
	echo '</html>';

}

function insertInvoice(
	$siteID,
	$invoiceDateTimeCreated,
	$invoiceCreatedByUserID,
	$clientID,
	$invoiceYearMonth,
	$invoiceDate,
	$invoiceComment,
	$invoiceSubTotal,
	$invoiceTaxRate,
	$invoiceTax,
	$invoiceTotal,
	$invoicePaymentStatus,
	$transactionIdArray
) {

	$query = "
		INSERT INTO accounting_invoice (
			siteID,
			invoiceDateTimeCreated,
			invoiceCreatedByUserID,
			clientID,
			invoiceYearMonth,
			invoiceDate,
			invoiceComment,
			invoiceSubTotal,
			invoiceTaxRate,
			invoiceTax,
			invoiceTotal,
			invoicePaymentStatus
		) VALUES (
			'$siteID',
			'$invoiceDateTimeCreated',
			'$invoiceCreatedByUserID',
			'$clientID',
			'$invoiceYearMonth',
			'$invoiceDate',
			'$invoiceComment',
			'$invoiceSubTotal',
			'$invoiceTaxRate',
			'$invoiceTax',
			'$invoiceTotal',
			'$invoicePaymentStatus'
		)
	";
	
	mysql_query($query);
	$invoiceID = mysql_insert_id();
	
	postToAuditTrail(0, 'insertInvoice', 'successful', '', $invoiceID, 'accounting_invoice', $invoiceID, 'invoiceID');


	foreach ($transactionIdArray AS $transactionID) {
		updateTransactionStatus($transactionID, 'invoiced');
		updateTransactionInvoiceID($transactionID, $invoiceID);
	}

}

function updateInvoice() {



}

function updateInvoiceStatus($invoiceID, $invoicePaymentStatus) {
	$query = "UPDATE accounting_invoice SET
			invoicePaymentStatus = '$invoicePaymentStatus'
			WHERE invoiceID = '$invoiceID' LIMIT 1";
	mysql_query($query) or die ('could not update invoiceStatus via updateInvoiceStatus()');
	postToAuditTrail($_SESSION['userID'], 'updateInvoiceStatus', 'successful', 'oldStatus', $invoicePaymentStatus, 'accounting_invoice', $invoiceID, 'invoicePaymentStatus');
	
}

function markInvoiceAsPaid($invoiceID) {

	// change invoiceStatus to "paid"
	updateInvoiceStatus($invoiceID, 'paid');
	
	// get array of this invoices transactions' transactionIDs
	$transactionIdArray = array();
	$queryThisInvoicesTransactions = "SELECT * FROM accounting_transaction WHERE invoiceID = '$invoiceID'";
	$resultThisInvoicesTransactions = mysql_query($queryThisInvoicesTransactions);
	while ($rowThisInvoicesTransactions = mysql_fetch_array($resultThisInvoicesTransactions)) {
		$transactionIdArray[] = $rowThisInvoicesTransactions['transactionID'];
	}
	
	// mark corresponding transactions' transactionStatus to "paid"
	foreach ($transactionIdArray as $transactionID) { updateTransactionStatus($transactionID, 'paid'); }
	
    // invoice total added to trust accounting module as trust expense
	$invoiceTotal = getInvoiceTotal($invoiceID);
	
}

/*
function getInvoiceIdWithClientPropertyYearMonth($clientID, $propertyID, $yearMonth) {
	$invoiceID = 0;
	$query = "SELECT * FROM accounting_invoice WHERE clientID = '$clientID' AND propertyID = '$propertyID' AND invoiceYearMonth = '$yearMonth' LIMIT 1";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) { $invoiceID = $row['invoiceID']; }
	return $invoiceID;
}
*/

function getInvoiceTotal($invoiceID) {
	$invoiceTotal = 0;
	$query = "SELECT invoiceTotal FROM accounting_invoice WHERE invoiceID = '$invoiceID' LIMIT 1";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) { $invoiceTotal = $row['invoiceTotal']; }
	return $invoiceTotal;
}

/*
function anInvoiceExistsForThisClientPropertyYearMonth($clientID, $propertyID, $yearMonth) {
	$query = "SELECT * FROM accounting_invoice WHERE clientID = '$clientID' AND propertyID = '$propertyID' AND invoiceYearMonth = '$yearMonth'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 1) { return true; } else { return false; }
}
*/

function getThisClientsProperties($clientID) {
	$propertyIdArray = array();
	$resultGetThisClientsProperties = mysql_query("SELECT propertyID FROM property_propertyClient WHERE clientID = '$clientID'");
	while($rowGetThisClientsProperties = mysql_fetch_array($resultGetThisClientsProperties)) { $propertyIdArray[] = $rowGetThisClientsProperties['propertyID']; }
	return $propertyIdArray;
}

?>