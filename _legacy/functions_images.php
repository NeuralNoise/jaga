<?php

function imageUpload($uploadedImage, $imageObject, $imageObjectID) {

	// INITIALIZE REQUIRED FUNCTION VARIABLES

		define('MAX_SIZE', '1000');
		$errors = 0;
		$imageSubmittedByUserID = $_SESSION['userID'];
		$imageSubmissionDateTime = date('Y-m-d H:i:s');
		$siteID = $_SESSION['siteID'];
		$tempImageFileName = md5(uniqid(rand(), true));
		// $tempImageLocation = 'agileImages/tempImageFiles/temp.jpg';
		$tempImageLocation = 'agileImages/tempImageFiles/' . $tempImageFileName . '.jpg';
		$newImageFileType = 'image/jpeg';
		
	// GET ATTRIBUES OF UPLOADED IMAGE
	
		$uploadedImageName = stripslashes($uploadedImage['name']);
		$uploadedImageSize = $uploadedImage['size'];
		$uploadedFileTmpName = $uploadedImage['tmp_name'];
		$uploadedFileType = $uploadedImage['type'];

	// CALCULATE NEW IMAGE DIMENSIONS
		
		list($oldWidth, $oldHeight) = getimagesize($uploadedFileTmpName);
		// $newWidth = 300;
		$newWidth = $oldWidth;
		//$newHeight = ($oldHeight / $oldWidth) * $newWidth;
		$newHeight = $oldHeight;

	// CHECK FILE TYPE
		
		// if (($uploadedFileType != "image/jpeg") && ($uploadedFileType != "image/png") && ($uploadedFileType != "image/gif")) {
		if ($uploadedFileType != "image/jpeg") {
			die ("Images should be in JPG/JPEG format.");
			$errors = 1;
		} else {
	
	// CHECK FILE SIZE
	
		// if ($uploadedImageSize > MAX_SIZE*1024) {
		if ($uploadedImageSize > MAX_SIZE*256) {
			die ("Images should be smaller than 256K.");
			$errors = 1;
		}
	
	// CREATE IMAGE RESOURCE
	
			if($uploadedFileType == 'image/jpeg') {
				$imageResource = imagecreatefromjpeg($uploadedFileTmpName);
			}
			
			/* elseif ($uploadedFileType=="image/png") {
				$imageResource = imagecreatefrompng($uploadedFileTmpName);
			} elseif ($uploadedFileType=="image/gif") {
				$imageResource = imagecreatefromgif($uploadedFileTmpName);
			} */
				
		}
		
	// CREATE CANVAS AT MATCH NEW IMAGE DIMENSIONS
	
		$newImage = imagecreatetruecolor($newWidth,$newHeight);
		
	// RESIZE IMAGE AND APPLY TO CANVAS
		
		imagecopyresampled($newImage,$imageResource,0,0,0,0,$newWidth,$newHeight,$oldWidth,$oldHeight);
		
	// REDUCE QUALITY TO REDUCE STORAGE REQUIREMENTS
	// SAVE NEW IMAGE TEMPORARILY TO DISK FOR MANIPULATION <== REALLY WANT TO ELIMINATE THIS STEP!!!!!!!!!!!!!
		
		imagejpeg($newImage,$tempImageLocation,75);

	// GET $fileSize AND $content OF NEW IMAGE TO SAVE INTO DB
	
		$fileSize = filesize($tempImageLocation);
			
		$fp = fopen($tempImageLocation, 'r');
		$content = addslashes(fread($fp, filesize($tempImageLocation)));
		fclose($fp);
		
		// START INSERT INTO DATABASE
		$query = "INSERT INTO image (
			imageSubmittedByUserID,
			imageSubmissionDateTime,
			imageName, 
			imageType, 
			imageSize, 
			imageContent,
			imageObject,
			imageObjectID,
			siteID
		) VALUES (
			'$imageSubmittedByUserID',
			'$imageSubmissionDateTime',
			'$uploadedImageName',
			'$newImageFileType',
			'$fileSize',
			'$content',
			'$imageObject',
			'$imageObjectID',
			'$siteID'
		)";
		mysql_query($query) or die('Error. Image upload failed in imageUpload().');
	
		// TAKE OUT THE TRASH
		imagedestroy($imageResource);
		imagedestroy($newImage);
		unlink($tempImageLocation);

}

function agileImageScale($imagePath, $desiredMaxWidth, $desiredMaxHeight) {
	
		$actualImageSize = getimagesize($imagePath);
		$actualImageWidth = $actualImageSize[0];
		$actualImageHeight = $actualImageSize[1];
		
		if ($actualImageWidth > $desiredMaxWidth || $actualImageHeight > $desiredMaxHeight) {
			$newImageRatio = $actualImageHeight / $actualImageWidth;
			if ($actualImageWidth > $desiredMaxWidth) {
				$newImageWidth = $desiredMaxWidth;
				$newImageHeight = $newImageWidth * $newImageRatio;
			}
			if ($newImageHeight > $desiredMaxHeight) {
				$newImageHeight = $desiredMaxHeight;
				$newImageWidth = $newImageHeight / $newImageRatio;
			}
		} else {
			$newImageWidth = $actualImageWidth;
			$newImageHeight = $actualImageHeight;
		}
		
		
		$newImageWidth = intval($newImageWidth);
		$newImageHeight = intval($newImageHeight);
		
		
		if ($newImageWidth == 0) {
			$newImageWidth = $desiredMaxHeight / $newImageRatio;
		}
		
		if ($newImageHeight == 0) { $newImageHeight = $desiredMaxHeight; }
		
		
		return array($imagePath, $newImageWidth, $newImageHeight, $newImageRatio);
		
}

function agileDBImageScale($imageID, $desiredMaxWidth, $desiredMaxHeight) {
	
		if (doesImageExist($imageID)) {
			$imagePath = getSiteURL() . '/image.php?imageID=' . $imageID;
		} else {
			$imagePath = 'agileImages/noImage.png';
		}
	
		$actualImageSize = getimagesize($imagePath);
		$actualImageWidth = $actualImageSize[0];
		$actualImageHeight = $actualImageSize[1];
		
		if ($actualImageWidth > $desiredMaxWidth || $actualImageHeight > $desiredMaxHeight) {
			$newImageRatio = $actualImageHeight / $actualImageWidth;
			if ($actualImageWidth > $desiredMaxWidth) {
				$newImageWidth = $desiredMaxWidth;
				$newImageHeight = $newImageWidth * $newImageRatio;
			}
			if ($newImageHeight > $desiredMaxHeight) {
				$newImageHeight = $desiredMaxHeight;
				$newImageWidth = $newImageHeight / $newImageRatio;
			}
		} else {
			$newImageWidth = $actualImageWidth;
			$newImageHeight = $actualImageHeight;
		}
		
		
		$newImageWidth = intval($newImageWidth);
		$newImageHeight = intval($newImageHeight);
		
		
		if ($newImageWidth == 0) {
			$newImageWidth = $desiredMaxHeight / $newImageRatio;
		}
		
		if ($newImageHeight == 0) { $newImageHeight = $desiredMaxHeight; }
		
		
		return array($imagePath, $newImageWidth, $newImageHeight, $newImageRatio);
		
}

function doesImageExist($imageID) {
		$resultCheckIfImageExists = mysql_query("SELECT * FROM image WHERE imageID = '$imageID' LIMIT 1");
		if (mysql_num_rows($resultCheckIfImageExists) == 1) { return true; } else { return false; }
}
	
	/* SAMPLE USAGE
	$scaledImage = agileImageScale('shopFiles/productCategoryImages/8.jpg', 200, 120);
	echo '<div>';
		echo 'Scaled to less than 200 x 120:<br />';
		echo '<img src="' . $scaledImage[0] . '" style="width:' . $scaledImage[1] . 'px;height:' . $scaledImage[2] . 'px;">';
	echo '</div>';
	*/
	
	/* SAMPLE USAGE WITH MARGIN CALCULATION
	$topMarginCalculation = (120 - $scaledImage[2]) / 2;
	$topMargin = number_format($topMarginCalculation, 0);
						
	echo '<img src="' . $scaledImage[0] . '" style="width:' . $scaledImage[1] . 'px;height:' . $scaledImage[2] . 'px;border-style:none;margin-top:' . $topMargin . 'px;">';
	*/		

	
function nisekocmsMultiFileUpload($fileArray = array(), $fileObject = '', $fileObjectID = 0) {
	
	$errorArray = array();
	
	$totalNumberOfFiles = count($fileArray['name']);
	$i = 0;
	while ($i < $totalNumberOfFiles) {

		if ($fileArray['error'][$i] == 0) {
		
			if ($fileArray['size'][$i] > 2097152) { $errorArray[$i][] = 'filesLargerThan2MbAreNotSupported'; }
			
			$allowedExtensions = array("gif", "jpeg", "jpg", "png", "pdf", "csv", "txt", "zip");
			$extension = strtolower(end(explode('.',$fileArray['name'][$i])));
			if (!in_array($extension, $allowedExtensions)) { $errorArray[$i][] = 'fileExtensionNotSupported'; }
			
			$allowedTypes = array('image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png', 'application/pdf', 'application/vnd.ms-excel', 'application/msword', 'text/csv', 'text/plain');
			if (!in_array($fileArray["type"][$i], $allowedTypes)) { $errorArray[$i][] = 'fileTypeNotSupported'; }
		
			if (empty($errorArray[$i])) { // save file to file index and move this file into somewhere

				$siteID = $_SESSION['siteID'];
				$fileSubmittedByUserID = $_SESSION['userID'];
				$fileSubmissionDateTime = date('Y-m-d H:i:s');
				$fileType = $fileArray['type'][$i];
				$fileSize = $fileArray['size'][$i];

				$query = "INSERT INTO nisekocms_fileIndex (
					`siteID`,
					`fileSubmittedByUserID`,
					`fileSubmissionDateTime`,
					`fileType`,
					`fileSize`,
					`fileObject`,
					`fileObjectID`
				) VALUES (
					'$siteID',
					'$fileSubmittedByUserID',
					'$fileSubmissionDateTime',
					'$fileType',
					'$fileSize',
					'$fileObject',
					'$fileObjectID'
				)";
				
				mysql_query ($query) or die ($query);
				
				$fileID = mysql_insert_id();
				$filePath = "/var/www/nisekocms/nisekocms.com/uploads/" . $fileID . "-" . str_replace(' ', '_', $fileArray['name'][$i]);
				$fileName = $fileID . '-' . str_replace(' ', '_', $fileArray['name'][$i]);
				
				$queryAddPathAndName = "
					UPDATE nisekocms_fileIndex 
					SET filePath = '$filePath', fileName = '$fileName'
					WHERE fileID = '$fileID' LIMIT 1";
				mysql_query ($queryAddPathAndName) or die ($queryAddPathAndName);
				
				// $newImage = new SimpleImage();
				// $newImage->load($fileArray['tmp_name'][$i]);
				// $newImage->resizeToWidth(100);
				// $newImage->save($filePath);
				// move_uploaded_file($newImage, $filePath);
				
				move_uploaded_file($fileArray['tmp_name'][$i], $filePath);
				
				$auditTrailUserName = $_SESSION['userID'];
				$auditTrailAction = 'fileUpload';
				$auditTrailResult = 'successful';
				$auditTrailOldData = '';
				$auditTrailNewData = $fileName;
				$auditTrailObject = 'nisekocms_fileIndex';
				$auditTrailObjectID = $fileID;
				$auditTrailField = 'nisekocms_fileIndex';
					
				postToAuditTrail(
					$auditTrailUserName, 
					$auditTrailAction, 
					$auditTrailResult, 
					$auditTrailOldData,
					$auditTrailNewData,
					$auditTrailObject,
					$auditTrailObjectID,
					$auditTrailField
				);

			}
		}
		
		$i++;
		
	}

	if (!empty($errorArray)) { return $errorArray; }
	
}

class SimpleImage {

   var $image;
   var $image_type;

   function load($filename) {

      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
	  
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
	  
   }
   
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {

      if ($image_type == IMAGETYPE_JPEG) {
         imagejpeg($this->image,$filename,$compression);
      } elseif ($image_type == IMAGETYPE_GIF) {
         imagegif($this->image,$filename);
      } elseif ($image_type == IMAGETYPE_PNG) {
         imagepng($this->image,$filename);
      }
	  
      if ($permissions != null) { chmod($filename,$permissions); }
	  
   }
   
   function output($image_type=IMAGETYPE_JPEG) {

      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {

         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {

         imagepng($this->image);
      }
   }
   function getWidth() {
      return imagesx($this->image);
   }
   
   function getHeight() { return imagesy($this->image); }
   
   function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }

   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }

   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
   }

   function resize($width,$height) {
     
		// OLD (issue with transparency)
		// $new_image = imagecreatetruecolor($width, $height);
		// imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
		// $this->image = $new_image;
		
		// NEW (resolves transparency issue)
		$new_image = imagecreatetruecolor($width, $height);
		
		if( $this->image_type == IMAGETYPE_GIF || $this->image_type == IMAGETYPE_PNG ) {
			$current_transparent = imagecolortransparent($this->image);
			if($current_transparent != -1) {
				$transparent_color = imagecolorsforindex($this->image, $current_transparent);
				$current_transparent = imagecolorallocate($new_image, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']); imagefill($new_image, 0, 0, $current_transparent);
				imagecolortransparent($new_image, $current_transparent);
			} elseif ($this->image_type == IMAGETYPE_PNG) {
				imagealphablending($new_image, false);
				$color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
				imagefill($new_image, 0, 0, $color);
				imagesavealpha($new_image, true);
			}
		}
		imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
		
		$this->image = $new_image;
	}

}

function userCanDeleteFile($userID, $fileID) {
	$query = "SELECT * FROM nisekocms_fileIndex WHERE fileSubmittedByUserID = '$userID' AND fileID = '$fileID' LIMIT 1";
	// echo $query;
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 1 || $_SESSION['userRoleForCurrentSite'] == 'siteManager') { return true; } else { return false; }
}

function nisekocmsDeleteFile($fileID) {
	
	$userID = $_SESSION['userID'];
	if (userCanDeleteFile($userID, $fileID)) {
	
		$query = "SELECT * FROM nisekocms_fileIndex WHERE fileID = '$fileID' LIMIT 1";
		// echo $query;
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		
		$fileID = $row['fileID'];
		$filePath = $row['filePath'];
		
		if (unlink($filePath)) {
			$deleteQuery = "DELETE FROM nisekocms_fileIndex WHERE fileID = '$fileID' LIMIT 1";
			// echo $deleteQuery;
			mysql_query($deleteQuery);
		}
		
	}
}

?>