<?php

class CarouselPanel extends ORM {

	public $carouselPanelID;
	public $channelID;
	public $carouselID;
	public $creator;
	public $created;
	public $imageID;
	public $carouselPanelAltEnglish;
	public $carouselPanelTitleEnglish;
	public $carouselPanelSubtitleEnglish;
	public $carouselPanelUrlEnglish;
	public $carouselPanelAltJapanese;
	public $carouselPanelTitleJapanese;
	public $carouselPanelSubtitleJapanese;
	public $carouselPanelUrlJapanese;
	public $carouselPanelDisplayOrder;
	public $carouselPanelPublished;
	public $carouselPanelDisplayWhileLoggedIn;
	public $carouselPanelDisplayWhileLoggedOut;

	public function __construct($carouselPanelID = null) {
		
		$this->carouselPanelID = 0;
		$this->channelID = 0;
		$this->carouselID = 0;
		$this->creator = 0;
		$this->created` datetime NOT NULL,
		$this->imageID = 0;
		$this->carouselPanelAltEnglish = '';
		$this->carouselPanelTitleEnglish = '';
		$this->carouselPanelSubtitleEnglish = '';
		$this->carouselPanelUrlEnglish = '';
		$this->carouselPanelAltJapanese = '';
		$this->carouselPanelTitleJapanese = '';
		$this->carouselPanelSubtitleJapanese = '';
		$this->carouselPanelUrlJapanese = '';
		$this->carouselPanelDisplayOrder = 0;
		$this->carouselPanelPublished = 0;
		$this->carouselPanelDisplayWhileLoggedIn = 0;
		$this->carouselPanelDisplayWhileLoggedOut = 0;
		
		if ($carouselPanelID) {
			$query = "SELECT * FROM jaga_CarouselPanel WHERE carouselPanelID = :carouselPanelID LIMIT 1";
			$core = Core::getInstance();
			$statement = $core->database->prepare($query);
			$statement->execute(array(':carouselPanelID' => $carouselPanelID));
			if ($row = $statement->fetch()) { foreach ($row AS $property => $value) { if (isset($this->$property)) { $this->$property = $value; } } }
		}

	}
	
}

?>