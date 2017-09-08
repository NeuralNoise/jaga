<?php

class Carousel extends ORM {

	public $carouselID;
	public $channelID;
	public $creator;
	public $created;
	public $carouselPath;
	public $carouselTitleEnglish;
	public $carouselSubtitleEnglish;
	public $carouselTitleJapanese;
	public $carouselSubtitleJapanese;
	public $carouselPublished;
	public $carouselDisplayWhileLoggedIn;
	public $carouselDisplayWhileLoggedOut;
	public $fullWidth;
	public $fixedHeight;

	public function __construct($carouselID = null) {

		$this->carouselID = 0;
		$this->channelID = 0;
		$this->creator = $_SESSION['userID'];
		$this->created = date('Y-m-d H:i:s');
		$this->carouselPath = '';
		$this->carouselTitleEnglish = '';
		$this->carouselSubtitleEnglish = '';
		$this->carouselTitleJapanese = '';
		$this->carouselSubtitleJapanese = '';
		$this->carouselPublished = 0;
		$this->carouselDisplayWhileLoggedIn = 0;
		$this->carouselDisplayWhileLoggedOut = 0;
		$this->fullWidth = 0;
		$this->fixedHeight = 0;

		if ($carouselID) {
			$query = "SELECT * FROM jaga_Carousel WHERE carouselID = :carouselID LIMIT 1";
			$core = Core::getInstance();
			$statement = $core->database->prepare($query);
			$statement->execute(array(':carouselID' => $carouselID));
			if ($row = $statement->fetch()) { foreach ($row AS $property => $value) { if (isset($this->$property)) { $this->$property = $value; } } }
		}

	}
	
	public static function getCarouselID($urlArray) {
		
		$newUrlArray = array();
		foreach ($urlArray AS $url) { if (!empty($url)) { $newUrlArray[] = $url; } }
		$carouselPath = join('/',$newUrlArray);
		
		$core = Core::getInstance();
		$query = "SELECT carouselID FROM jaga_Carousel ";
		$query .= "WHERE channelID = :channelID AND carouselPath = :carouselPath AND carouselPublished = 1 ";
		$query .= "AND " . (Authentication::isLoggedIn()?"carouselDisplayWhileLoggedIn":"carouselDisplayWhileLoggedOut") . " = 1 ";
		$query .= "LIMIT 1";
		
		$statement = $core->database->prepare($query);
		$statement->bindParam(':channelID',$_SESSION['channelID']);
		$statement->bindParam(':carouselPath',$carouselPath);
		$statement->execute();

		$carouselID = 0;
		if ($row = $statement->fetch()) { $carouselID = $row['carouselID']; }
		return $carouselID;

	}
	
}

?>