<?php

function totalPagePlusOne() {
	$result = mysql_query("UPDATE nisekocms_site SET pagesServed = pagesServed + 1 WHERE siteID = $_SESSION[siteID] LIMIT 1") or die(mysql_error());  
}

function totalPagesServed() {
	$totalPagesServed = 0;
	$result = mysql_query("SELECT * FROM nisekocms_site");
	while($row = mysql_fetch_array($result)) { $totalPagesServed = $totalPagesServed + $row['pagesServed']; }
	return $totalPagesServed;
}

function totalPagesServedThisSite($siteID) {
	$totalPagesServedThisSite = 0;
	$result = mysql_query("SELECT * FROM nisekocms_site WHERE siteID = $siteID LIMIT 1");
	while($row = mysql_fetch_array($result)) { $totalPagesServedThisSite = $row['pagesServed']; }
	return $totalPagesServedThisSite;
}

?>