<?php

function getProductName($productID) {
	$productName = '';
	$resultGetProductName = mysql_query("SELECT productNameEnglish, productNameJapanese FROM shop_product WHERE productID = '$productID' LIMIT 1");
	while($rowGetProductName = mysql_fetch_array($resultGetProductName)) {
		if ($_SESSION['lang'] == 'ja') {
			$productName = $rowGetProductName['productNameJapanese'];
		} else {
			$productName = $rowGetProductName['productNameEnglish'];
		}
	}
	return $productName;
}

function getProductDescription($productID) {
	$productDecription = '';
	$resultGetProductDescription = mysql_query("SELECT productDescriptionEnglish, productDescriptionJapanese FROM shop_product WHERE productID = '$productID' LIMIT 1");
	while($rowGetProductDescription = mysql_fetch_array($resultGetProductDescription)) {
		if ($_SESSION['lang'] == 'ja') {
			$productDecription = $rowGetProductDescription['productDescriptionJapanese'];
		} else {
			$productDecription = $rowGetProductDescription['productDescriptionEnglish'];
		}
	}
	return $productDecription;
}
	
function getProductCategoryName($categoryID) {
		$resultGetCategoryName = mysql_query("SELECT * FROM shop_category WHERE categoryID = '$categoryID' LIMIT 1");
		while($rowGetCategoryName = mysql_fetch_array($resultGetCategoryName)) {
			if ($_SESSION['lang'] == 'ja') {
			
				if (($rowGetCategoryName['categoryNameJapanese']) == '') {
					return $rowGetCategoryName['categoryNameEnglish'];
				} else {
					return $rowGetCategoryName['categoryNameJapanese'];
				}
				
				
			} else {
			
			
				return $rowGetCategoryName['categoryNameEnglish'];
				
				
			}
		}
	}
	
function getManufacturerName($manufacturerID) {
		$resultGetManufacturerName = mysql_query("SELECT * FROM shop_manufacturer WHERE manufacturerID = '$manufacturerID' LIMIT 1");
		while($rowGetManufacturerName = mysql_fetch_array($resultGetManufacturerName)) {
			if ($_SESSION['lang'] == 'ja') {
			
				if (($rowGetManufacturerName['manufacturerNameJapanese']) == '') {
					return $rowGetManufacturerName['manufacturerNameEnglish'];
				} else {
					return $rowGetManufacturerName['manufacturerNameJapanese'];
				}
				
				
			} else {
			
			
				return $rowGetManufacturerName['manufacturerNameEnglish'];
				
				
			}
		}
	}
	
function getCurrentProductPrice($productID) {
		$resultGetCurrentProductPrice = mysql_query("SELECT price FROM shop_productPrice WHERE productID = '$productID' ORDER BY productPriceCreationDateTime DESC LIMIT 1");
		while($rowGetCurrentProductPrice = mysql_fetch_array($resultGetCurrentProductPrice)) {
				return $rowGetCurrentProductPrice['price'];
		}
	}

function displayVerticalNavigation($categoryID = 'all', $manufacturerID = 'all') {
	
	$siteID = $_SESSION['siteID'];
	echo '<div class="shopVerticalNavMenuHeaderBlock">' . agileResource('categories') . '</div>';
		
		$queryCategoryLeftColumnBlocks = "SELECT * FROM shop_category WHERE siteID = $siteID AND categoryEnabled = 1 ORDER BY categoryDisplayOrder ASC";
		$resultCategoryLeftColumnBlocks = mysql_query($queryCategoryLeftColumnBlocks);
		while($rowCategoryLeftColumnBlocks = mysql_fetch_array($resultCategoryLeftColumnBlocks)) {

			echo '<div class="shopVerticalNavMenuBlock">';
				echo '<a class="';
					if ($categoryID == $rowCategoryLeftColumnBlocks['categoryID']) {
						echo 'shopVerticalNavMenuItemSelected';
						$manufacturerLink = 'all';
						if ($manufacturerID == 'all') {
							$categoryLink = 'all';
						} else {
							$categoryLink = $rowCategoryLeftColumnBlocks['categoryID'];
						}
					} else {
						echo 'shopVerticalNavMenuItem';
						$manufacturerLink = $manufacturerID;
						$categoryLink = $rowCategoryLeftColumnBlocks['categoryID'];
					}
				echo '" href="' . languageUrlPrefix() . 'store/';
					echo $categoryLink;
				echo '/';
					echo $manufacturerLink;
				echo '/">';
					echo getProductCategoryName($rowCategoryLeftColumnBlocks['categoryID']);
				echo '</a>';
			echo '</div>';
			
		}

		echo '<div class="shopVerticalNavMenuHeaderBlock">' . agileResource('manufacturers') . '</div>';
		
		$queryManufacturerLeftColumnBlocks = "SELECT * FROM shop_manufacturer WHERE siteID = '$siteID' AND manufacturerEnabled = '1' ORDER BY manufacturerDisplayOrder ASC";
		
		$resultManufacturerLeftColumnBlocks = mysql_query($queryManufacturerLeftColumnBlocks);
		while($rowManufacturerLeftColumnBlocks = mysql_fetch_array($resultManufacturerLeftColumnBlocks)) {
		
			echo '<div class="shopVerticalNavMenuBlock">';
				echo '<a class="';
					if ($manufacturerID == $rowManufacturerLeftColumnBlocks['manufacturerID']) {
						echo 'shopVerticalNavMenuItemSelected';
						$categoryLink = 'all';
						if ($categoryID == 'all') {
							$manufacturerLink = 'all';
						} else {
							$manufacturerLink = $rowManufacturerLeftColumnBlocks['manufacturerID'];
						}
					} else {
						echo 'shopVerticalNavMenuItem';
						$categoryLink = $categoryID;
						$manufacturerLink = $rowManufacturerLeftColumnBlocks['manufacturerID'];
					}
				echo '" href="' . languageUrlPrefix() . 'store/';
					echo $categoryLink;
				echo '/';
					echo $manufacturerLink;
				echo '/">';
					echo getManufacturerName($rowManufacturerLeftColumnBlocks['manufacturerID']);
				echo '</a>';
			echo '</div>';
		}
		

}

function displayProductList($categoryID = 'all', $manufacturerID = 'all') {

	$siteID = $_SESSION['siteID'];
	$currentDate = date('Y-m-d');
	
	if ($categoryID == 'all' && $manufacturerID == 'all') {
	
		$query = "
			SELECT * FROM shop_product 
			WHERE siteID = '$siteID' 
			AND productEnabled = '1'
			AND productStartSellingDate <= '$currentDate'
			AND productStopSellingDate >= '$currentDate'
		";
	
	} elseif ($categoryID != 'all' && $manufacturerID == 'all') {
	
		$query = "
			SELECT * FROM shop_productCategory, shop_product 
			WHERE shop_productCategory.productID = shop_product.productID 
			AND shop_productCategory.categoryID = '$categoryID'
			AND shop_product.siteID = '$siteID' 
			AND shop_product.productEnabled = '1'
			AND shop_product.productStartSellingDate <= '$currentDate'
			AND shop_product.productStopSellingDate >= '$currentDate'
		";
		
	} elseif ($categoryID == 'all' && $manufacturerID != 'all') {
	
		$query = "
			SELECT * FROM shop_product 
			WHERE siteID = '$siteID' 
			AND productEnabled = '1'
			AND productManufacturerID = '$manufacturerID'
			AND productStartSellingDate <= '$currentDate'
			AND productStopSellingDate >= '$currentDate'
		";
		
	} elseif ($categoryID != 'all' && $manufacturerID != 'all') {
		
		$query = "
			SELECT * FROM shop_productCategory, shop_product 
			WHERE shop_productCategory.productID = shop_product.productID 
			AND shop_productCategory.categoryID = '$categoryID'
			AND shop_product.siteID = '$siteID' 
			AND shop_product.productEnabled = '1'
			AND shop_product.productManufacturerID = '$manufacturerID'
			AND shop_product.productStartSellingDate <= '$currentDate'
			AND shop_product.productStopSellingDate >= '$currentDate'
		";
		
	}
	
	
	echo '<table id="shopProductList">';
		
		$result = mysql_query($query);
		$count = 1;
		while ($row = mysql_fetch_Array($result)) {
	
			$productID = $row['productID'];
			$productImageID = getShopProductImageID($productID);
			if ($count % 2 == 0) { $trClassName = 'shopProductEven'; } else { $trClassName = 'shopProductOdd'; }
			
			
			$productImage = '/agileModules/agileShop/images/product/' . $productID . '-main.jpg';
			
			echo '<tr class="' . $trClassName . '">';
				echo '<td class="shopProductImage" rowspan="3">';
					echo '<div style="height:100px;width:150px;margin:5px;border:1px solid #ccc;overflow:hidden;">';
					echo '<img src="' . $productImage . '" style="height:120px;">';
					
					/*
					if (file_exists($productImage)) {
						$scaledImage = agileDBImageScale($productImageID, 200, 120);
						echo '<img src="' . $scaledProductImage[0] . '" style="width:' . $scaledProductImage[1] . 'px;height:' . $scaledProductImage[2] . 'px;">';
					} else {
						$imgUrl = 'agileImages/noImage.png';
						$noImage = agileImageScale("$imgUrl", 200, 120);
						echo '<img src="' . $noImage[0] . '" style="width:' . $noImage[1] . 'px;height:' . $noImage[2] . 'px;">';
					}
					*/
					echo '</div>';
				echo '</td>';
				
				echo '<td class="shopProductName">';
					echo '<h3 class="shopProductName">' . getProductName($productID) . '</h3>';
				echo '</td>';

			echo '</tr>';
			
			echo '<tr class="' . $trClassName . '">';
		
				echo '<td class="shopProductDescription">' . getProductDescription($productID) . '</td>';

			echo '</tr>';
			
			echo '<tr class="' . $trClassName . '">';
				echo '<td class="shopProductAction">';
					echo '<form action="' . languageUrlPrefix() . 'store/add-to-cart/" method="post">';
						echo '<input type="hidden" name="productID" value="' . $productID . '">';
						echo '<select name="quantity">';
							echo '<option value="1">' . agileResource('qty') . '</option>';
							$quantityCounter = 2;
							while ($quantityCounter <= 144) {
								echo '<option value="' . $quantityCounter . '">' . $quantityCounter . '</option>';
								$quantityCounter = $quantityCounter + 1;
							}
						echo '</select>';
						echo '&nbsp;';
						echo getCurrencySymbol();
						echo number_format(getCurrentProductPrice($productID));
						echo '<input type="submit" value="' . agileResource('addToCart') . '">';
					echo '</form>';
				echo '</td>';
				
			echo '</tr>';
			
			$count = $count + 1;
			
		}
	echo '</table>';
}

function shopAgeVerificationRequired($siteID) {
	$resultGetShopAgeVerificationRequired = mysql_query("SELECT * FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
	while($rowGetShopAgeVerificationRequired = mysql_fetch_array($resultGetShopAgeVerificationRequired)) {
		return $rowGetShopAgeVerificationRequired['shopAgeVerificationRequired'];
	}
}
	
function shopRequiredAge($siteID) {
		
		//shopAgeVerificationRequired
		
		$resultGetShopRequiredAge = mysql_query("SELECT shopRequiredAge FROM nisekocms_site WHERE siteID = '$siteID' LIMIT 1");
		while($rowGetShopRequiredAge = mysql_fetch_array($resultGetShopRequiredAge)) {
			return $rowGetShopRequiredAge['shopRequiredAge'];
		}
	
	}

function displayCartAsTable() {
	
		echo '<table style="width:800px;margin:0px auto 0px auto;border:1px solid #dddddd;">';
				echo '<tr style="background-color:#eeeeee;">';
					echo '<td class="borderAlignCenter">ID</td>';
					echo '<td class="borderAlignCenter">' . agileResource('image') . '</td>';
					echo '<td class="borderAlignCenter">' . agileResource('product') . '</td>';
					echo '<td class="borderAlignCenter">' . agileResource('quantity') . '</td>';
					echo '<td class="borderAlignCenter">' . agileResource('unitPrice') . '</td>';
					echo '<td class="borderAlignCenter">' . agileResource('lineTotal') . '</td>';
				echo '</tr>';
		
				$orderSubTotal = 0;
				foreach ($_SESSION['shoppingCartArray'] as $productID=>$quantity) {
			
					echo '<tr>';
						echo '<td class="borderAlignCenter">' . $productID . '</td>';
						echo '<td class="borderAlignCenter"><img src="agileModules/agileShop/images/product/' . $productID . '-main.jpg" style="height:25px;"></td>';
						echo '<td class="borderAlignLeft">' . getProductName($productID) . '</td>';
						echo '<td class="borderAlignCenter">' . $quantity . '</td>';
						$unitPrice = getCurrentPrice($productID);
						echo '<td class="borderAlignRight">' . getCurrencySymbol() . number_format($unitPrice) . '</td>';
						$lineTotal = $quantity * $unitPrice;
						echo '<td class="borderAlignRight" style="width:200px;">' . getCurrencySymbol() . number_format($lineTotal) . '</td>';
					echo '</tr>';
			
					$orderSubTotal = $orderSubTotal + $lineTotal;
				}
			
				$orderTaxTotal = $orderSubTotal * .05;
				echo '<tr>';
					echo '<td class="borderAlignRight" colspan="5">Tax: </td>';
					echo '<td class="borderAlignRight" style="width:200px;">' . getCurrencySymbol() . number_format($orderTaxTotal) . '</td>';
				echo '</tr>';
				
				
				$orderTotal = $orderSubTotal + $orderTaxTotal;
				echo '<tr>';
					echo '<td class="borderAlignRight" colspan="5">Subtotal: </td>';
					echo '<td class="borderAlignRight" style="width:200px;">' . getCurrencySymbol() . number_format($orderTotal) . '</td>';
				echo '</tr>';
				
				echo '</table>';
	
	}
	
function displayPaymentOptionsAsTable() {
	
		echo '<table style="width:800px;margin:0px auto 0px auto;border:1px solid #dddddd;">';
					echo '<tr style="background-color:#eeeeee;">';
						echo '<td class="borderAlignCenter" style="width:50px;">select</td>';
						echo '<td class="borderAlignCenter">paymentOptions</td>';
						echo '<td class="borderAlignCenter" style="width:200px;">paymentOptionFee</td>';
					echo '</tr>';
			
					$resultGetPaymentOptions = mysql_query("SELECT * FROM paymentOptions ORDER BY paymentOptionsID ASC");
					while($rowGetPaymentOptions = mysql_fetch_array($resultGetPaymentOptions)) {
						echo '<tr>';
						echo '<td class="borderAlignCenter" style="width:50px;"><input type="radio" name="paymentOptionsID" value="' . $rowGetPaymentOptions['paymentOptionsID'] . '" onChange="selectPaymentOption.disabled=false;"';
								if ($_SESSION['paymentOptionsID'] == $rowGetPaymentOptions['paymentOptionsID']) { echo ' checked="checked"'; }
							echo '></td>';
							echo '<td class="borderAlignleft">';
								if ($_SESSION['lang'] == 'ja') {
									echo $rowGetPaymentOptions['paymentOptionsJapanese'];
								} else {
									echo $rowGetPaymentOptions['paymentOptionsEnglish'];
								}
							echo '</td>';
							echo '<td class="borderAlignRight" style="width:200px;">' . getCurrencySymbol() . 'XX,XXX</td>';
						echo '</tr>';
					}
			
		echo '</table>';
	
	}

function getCurrentPrice($productID) {
		$resultGetCurrentPrice = mysql_query("SELECT price FROM shop_productPrice WHERE productID = $productID ORDER BY productPriceCreationDateTime DESC");
		while($rowGetCurrentPrice = mysql_fetch_array($resultGetCurrentPrice)) {
			return $rowGetCurrentPrice['price'];
		}
	}

function getShopCategoryImageID($shopCategoryID) {
		$resultGetShopCategoryImageID = mysql_query("SELECT * FROM image WHERE imageObject = 'shopCategory' AND imageObjectID = $shopCategoryID ORDER BY imageSubmissionDateTime DESC LIMIT 1");
		while($rowGetShopCategoryImageID = mysql_fetch_array($resultGetShopCategoryImageID)) {
			return $rowGetShopCategoryImageID['imageID'];
		}
	}

function getShopProductImageID($shopProductID) {
		$resultGetShopProductImageID = mysql_query("SELECT * FROM image WHERE imageObject = 'shopProduct' AND imageObjectID = $shopProductID ORDER BY imageSubmissionDateTime DESC LIMIT 1");
		while($rowGetShopProductImageID = mysql_fetch_array($resultGetShopProductImageID)) {
			return $rowGetShopProductImageID['imageID'];
		}
	}
	
function getShopManufacturerImageID($shopManufacturerID) {
		$resultGetShopManufacturerImageID = mysql_query("SELECT * FROM image WHERE imageObject = 'shopManufacturer' AND imageObjectID = $shopManufacturerID ORDER BY imageSubmissionDateTime DESC LIMIT 1");
		while($rowGetShopManufacturerImageID = mysql_fetch_array($resultGetShopManufacturerImageID)) {
			return $rowGetShopManufacturerImageID['imageID'];
		}
	}

?>