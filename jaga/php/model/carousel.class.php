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

		if ($carouselID) {
			$query = "SELECT * FROM jaga_Carousel WHERE carouselID = :carouselID LIMIT 1";
			$core = Core::getInstance();
			$statement = $core->database->prepare($query);
			$statement->execute(array(':carouselID' => $carouselID));
			if ($row = $statement->fetch()) { foreach ($row AS $property => $value) { if (isset($this->$property)) { $this->$property = $value; } } }
		}

	}
	
}

?>