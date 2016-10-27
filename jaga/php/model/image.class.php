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

		$allowedExts = array("gif","GIF","jpeg","JPEG","jpg","JPG","png","PNG","ico","ICO");
		$extension = end(explode(".", $imageArray["name"]));
		
		$imageType = $imageArray["type"];
		
		if (
			(
				$imageType == "image/jpeg" || 
				$imageType == "image/jpg" || 
				$imageType == "image/png" || 
				$imageType == "image/gif" || 
				$imageType == "image/ico"
			)
			&& ($imageArray["size"] < 5242880)
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
			
				// AWS S3
				/*
				$sharedConfig = [
					'region'  => 'us-west-2',
					'version' => 'latest',
					'credentials' => [
						'key'    => 'my-access-key-id',
						'secret' => 'my-secret-access-key',
					]
				];
				
				$sdk = new Aws\Sdk($sharedConfig);
				$s3Client = new S3Client([
					'version'     => 'latest',
					'region'      => 'us-west-2',
					'credentials' => [
						'key'    => 'my-access-key-id',
						'secret' => 'my-secret-access-key',
					],
				]);
				$client = $sdk->createS3();
				*/
			
				// need new imageID
				$newImage = $image->imagePath . $imageID . '.' . $image->imageType;
				
				// ensure correct orientation
				$imageTmpName = $imageArray['tmp_name'];
				$sandboxImage = imagecreatefromstring(file_get_contents($imageTmpName));
				$exif = exif_read_data($imageTmpName);
				if(!empty($exif['Orientation'])) {
					switch($exif['Orientation']) {
						case 8:
							$sandboxImage = imagerotate($sandboxImage,90,0);
							break;
						case 3:
							$sandboxImage = imagerotate($sandboxImage,180,0);
							break;
						case 6:
							$sandboxImage = imagerotate($sandboxImage,-90,0);
							break;
					}
				}

				// upload image and create thumbnails
				switch ($image->imageType) {
					
					case ('jpg'):
						
						imagejpeg($sandboxImage, $newImage);
						$thumbnailSizeArray = array(50, 90, 150, 210, 330, 600, 768, 992, 1200);
						foreach ($thumbnailSizeArray AS $width) {
							$newImageThumbnail = $image->imagePath . $imageID . '-' . $width . 'px.' . $image->imageType;
							self::createThumbnail($newImage,$image->imageType,$newImageThumbnail,$width);
						}
						break;
						
					case ('png'):
					
						imagepng($sandboxImage, $newImage);
						break;

					default:
						move_uploaded_file($imageTmpName, $newImage) or die ('move_uploaded_file() ERROR');
					
				}

				return $imageID;
				
			}
			
		} else {
			return 'IMAGE UPLOAD ERROR: Your image must be a GIF, JPG  or PNG and be less than 2MB.';
		}

	}
	
	public function deleteImageFile($imageID) {

	}

	public function createThumbnail($source, $filetype, $destination, $desiredWidth) {

		// CURRENTLY SUPPORTS JPG ONLY
		
		$filetype = strtolower($filetype);
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
	
	public function getObjectImageUrlArray($imageObject, $imageObjectID) {

		$core = Core::getInstance();
		$query = "SELECT imageID, imagePath, imageType, imageLegacy FROM jaga_Image WHERE imageObject = :imageObject AND imageObjectID = :imageObjectID";
		$statement = $core->database->prepare($query);
		
		$statement->execute(array(':imageObject' => $imageObject, ':imageObjectID' => $imageObjectID));
		
		$objectImageArray = array();
		while ($row = $statement->fetch()) {
			if ($row['imageLegacy'] == 0) {
				$objectImageArray[$row['imageID']] = "/" . $row['imagePath'] . $row['imageID'] . "." . $row['imageType'];
			} elseif ($row['imageLegacy'] == 1) {
				$objectImageArray[$row['imageID']] = $row['imagePath'];
			}
		}

		return $objectImageArray;
	}
	
	public function getObjectMainImagePath($imageObject, $imageObjectID, $thumbnailWidth = 0) {
	
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
			$mainImageThumbnailPath = $row['imagePath'] . $row['imageID'] . "-" . $thumbnailWidth . "px." . $row['imageType'];
			if ($thumbnailWidth != 0 && file_exists($mainImageThumbnailPath) && $row['imageType'] == 'jpg') {
				$mainImagePath = "/" . $row['imagePath'] . $row['imageID'] . "-" . $thumbnailWidth . "px." . $row['imageType'];
			} else {
				$mainImagePath = "/" . $row['imagePath'] . $row['imageID'] . "." . $row['imageType'];
			}
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