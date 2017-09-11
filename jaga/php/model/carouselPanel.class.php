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
		$this->creator = $_SESSION['userID'];
		$this->created = date('Y-m-d H:i:S');
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
	
	public function alt() {
	
		if ($_SESSION['lang'] == 'ja' && !empty($this->carouselPanelAltJapanese)) {
			return $this->carouselPanelAltJapanese;
		} else {
			return $this->carouselPanelAltEnglish;
		}
	
	}
	
	public function title() {
	
		if ($_SESSION['lang'] == 'ja' && !empty($this->carouselPanelTitleJapanese)) {
			return $this->carouselPanelTitleJapanese;
		} else {
			return $this->carouselPanelTitleEnglish;
		}
	
	}
	
	public function subtitle() {
	
		if ($_SESSION['lang'] == 'ja' && !empty($this->carouselPanelSubtitleJapanese)) {
			return $this->carouselPanelSubtitleJapanese;
		} else {
			return $this->carouselPanelSubtitleEnglish;
		}
	
	}
	
	public function url() {
	
		if ($_SESSION['lang'] == 'ja' && !empty($this->carouselPanelUrlJapanese)) {
			return $this->carouselPanelUrlJapanese;
		} else {
			return $this->carouselPanelUrlEnglish;
		}
	
	}
	
	public static function panels($carouselID) {
		
		$core = Core::getInstance();
		$query = "SELECT carouselPanelID FROM jaga_CarouselPanel ";
		$query .= "WHERE carouselID = :carouselID AND carouselPanelPublished = 1 ";
		$query .= "AND " . (Authentication::isLoggedIn()?"carouselPanelDisplayWhileLoggedIn":"carouselPanelDisplayWhileLoggedOut") . " = 1 ";
		$query .= "ORDER BY carouselPanelDisplayOrder ASC";
		$statement = $core->database->prepare($query);
		$statement->bindParam(':carouselID',$carouselID);
		$statement->execute();

		$panels = array();
		while ($row = $statement->fetch()) { $panels[] = $row['carouselPanelID']; }
		return $panels;

	}
	
}

?>