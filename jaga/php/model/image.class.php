<?php

class Image {

	public function createImage(
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

				$imageOriginalName = $imageArray["name"];
				$imagePath = 'zeni/images/';
				$imageType = substr($imageArray["type"],6);
				if ($imageType == 'jpeg') { $imageType = 'jpg'; }
				$imageSize = $imageArray['size'];
				$imageDimensionX = 0;
				$imageDimensionY = 0;
				$channelID = $_SESSION['channelID'];
				$imageSubmittedByUserID = $_SESSION['userID'];
				$imageSubmissionDateTime = date('Y-m-d H:i:s');

				
				// need new imageID
				$newImage = $imagePath . $imageID . '.' . $imageType;
				
				
				move_uploaded_file($imageArray['tmp_name'], $newImage) or die ('move_uploaded_file() ERROR');
				
				if ($imageType == 'jpg') {
					$newImageThumbnail50px = $imagePath . $imageID . '-50px.' . $imageType;
					self::createThumbnail($newImage,$newImageThumbnail50px,50);
				}
				
				return $imageID;
				
			}
			
		} else {
			return 'IMAGE UPLOAD ERROR: Your image must be a JPG less than 2MB.';
		}

	}
	
	public function deleteImage($imageID) {

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
		$query = "SELECT imagePath FROM jaga_Image WHERE imageObject = :imageObject AND imageObjectID = :imageObjectID LIMIT 1";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':imageObject' => $imageObject, ':imageObjectID' => $imageObjectID));
		if ($row = $statement->fetch()) { return $row['imagePath']; } else { return ""; }
	
	}
	
}

?>