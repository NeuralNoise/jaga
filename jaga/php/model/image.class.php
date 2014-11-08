<?php

class Image extends ORM {

	public $imageID;
	public $imageDisplayOrder;
	public $channelID;
	public $imageSubmittedByUserID;
	public $imageSubmissionDateTime;
	public $imagePath;
	public $imageObject;
	public $imageObjectID;
	public $imageDisplayClassification;
	public $imageOriginalName;
	public $imageType;
	public $imageSize;
	public $imageDimensionX;
	public $imageDimensionY;
	public $imageDisplayInGallery;
	
	public function __construct($imageID = 0) {
	
	}

	public function uploadImageFile(
		$imageArray,
		$imageObject,
		$imageObjectID
	) {

		$allowedExts = array("gif","jpeg","jpg","JPG","png","PNG");
		$extension = end(explode(".", $imageArray["name"]));
		
		if (
			(($imageArray["type"] == "image/jpeg") || ($imageArray["type"] == "image/jpg")) // need gif & png!
			&& ($imageArray["size"] < 2097152)
			&& in_array($extension, $allowedExts)
		) {

			if ($imageArray["error"] > 0) {
			
				return $imageArray['error'];
				
			} else {
			
				$image = new Image(0);
				
				$image->imageDisplayOrder = 0;
				$image->channelID = $_SESSION['channelID'];
				$image->imageSubmittedByUserID = $_SESSION['userID'];
				$image->imageSubmissionDateTime = date('Y-m-d H:i:s');
				$image->imagePath = 'jaga/images/';
				$image->imageObject = $imageObject;
				$image->imageObjectID = $imageObjectID;
				$image->imageDisplayClassification = '';
				$image->imageOriginalName = $imageArray["name"];
				$image->imageType = substr($imageArray["type"],6);
				if ($image->imageType == 'jpeg') { $image->imageType = 'jpg'; }
				$image->imageSize = $imageArray['size'];
				$image->imageDimensionX = 0;
				$image->imageDimensionY = 0;
				$image->imageDisplayInGallery = 1;

				unset($image->imageID);
				$imageID = self::insert($image);
			
				// need new imageID
				$newImage = $image->imagePath . $imageID . '.' . $image->imageType;
				
				move_uploaded_file($imageArray['tmp_name'], $newImage) or die ('move_uploaded_file() ERROR');
				
				if ($image->imageType == 'jpg') {
					$newImageThumbnail50px = $image->imagePath . $imageID . '-50px.' . $image->imageType;
					self::createThumbnail($newImage,$newImageThumbnail50px,50);
				}
				
				return $imageID;
				
			}
			
		} else {
			return 'IMAGE UPLOAD ERROR: Your image must be a JPG less than 2MB.';
		}

	}
	
	public function deleteImageFile($imageID) {

	}

	public function createThumbnail($source, $destination, $desiredWidth) {

		$sourceImage = imagecreatefromjpeg($source);
		$width = imagesx($sourceImage);
		$height = imagesy($sourceImage);
		$desiredHeight = floor($height * ($desiredWidth / $width));
		$virtualImage = imagecreatetruecolor($desiredWidth, $desiredHeight);
		imagecopyresampled($virtualImage, $sourceImage, 0, 0, 0, 0, $desiredWidth, $desiredHeight, $width, $height);
		imagejpeg($virtualImage, $destination);
		
	}

	public function objectHasImage($imageObject, $imageObjectID) {
		$core = Core::getInstance();
		$query = "SELECT * FROM jaga_Image WHERE imageObject = :imageObject AND imageObjectID = :imageObjectID";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':imageObject' => $imageObject, ':imageObjectID' => $imageObjectID));
		if ($row = $statement->fetch()) { return true; } else { return false; }
	}
	
	public function getObjectMainImagePath($imageObject, $imageObjectID) {
	
		$core = Core::getInstance();
		$query = "
			SELECT imagePath, imageID, imageType 
			FROM jaga_Image 
			WHERE imageObject = :imageObject AND imageObjectID = :imageObjectID 
			ORDER BY imageSubmissionDateTime DESC 
			LIMIT 1
		";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':imageObject' => $imageObject, ':imageObjectID' => $imageObjectID));
	
		if ($row = $statement->fetch()) {
			$mainImagePath = "/" . $row['imagePath'] . $row['imageID'] . "." . $row['imageType'];
			return $mainImagePath;
		} else { return ""; }
	
	}
	
	public function getLegacyObjectMainImagePath($imageObject, $imageObjectID) {
	
		$core = Core::getInstance();
		$query = "
			SELECT imagePath 
			FROM jaga_Image 
			WHERE imageObject = :imageObject AND imageObjectID = :imageObjectID AND imageLegacy = 1
			ORDER BY imageSubmissionDateTime DESC 
			LIMIT 1
		";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':imageObject' => $imageObject, ':imageObjectID' => $imageObjectID));
		if ($row = $statement->fetch()) { return $row['imagePath']; } else { return ""; }
	
	}
	
}

?>