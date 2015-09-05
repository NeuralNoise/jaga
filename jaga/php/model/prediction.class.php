<?php

class Prediction extends ORM {

	public $predictionID;
	public $userID;
	public $channelID;
	public $predictionObject;
	public $predictionObjectID;
	public $dateTimeSubmitted;
	public $dateTimePredicted;
	public $comment;
	public $year;
	public $result;
	
	public function __construct($predictionID) {
	
		if ($predictionID != 0) {
		
			$core = Core::getInstance();
			$query = "SELECT * FROM jaga_Prediction WHERE predictionID = :predictionID LIMIT 1";
			$statement = $core->database->prepare($query);
			$statement->execute(array(':predictionID' => $predictionID));
			if (!$row = $statement->fetch()) { die("Prediction [$predictionID] does not exist."); }
			foreach ($row AS $key => $value) { if (!is_int($key)) { $this->$key = $value; } }
			
		} else {

			$this->predictionID = 0;
			$this->userID = $_SESSION['userID'];
			$this->channelID = $_SESSION['channelID'];
			$this->predictionObject = '';
			$this->predictionObjectID = 0;
			$this->dateTimeSubmitted = date('Y-m-d H:i:s');
			$this->dateTimePredicted = date('Y-m-d H:i:s');
			$this->comment = '';
			$this->year = date('Y');
			$this->result = '';

		}
		
	}
	
	public static function getPredictions($channelID, $year, $orderBy = '', $limit = 0) {
		
		$query = "SELECT * FROM jaga_Prediction WHERE channelID = :channelID AND year = :year";
		if ($orderBy) { $query .= " ORDER BY " . $orderBy; }
		if ($limit) { $query .= " LIMIT " . $limit; }

		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		$statement->execute(array(':channelID' => $channelID, ':year' => $year));
		
		$predictionArray = array();
		while ($row = $statement->fetch()) { $predictionArray[] = $row['predictionID']; }
		return $predictionArray;
		
	}
	
	public static function getYears($channelID) {
		
		$query = "
			SELECT DISTINCT(year) FROM jaga_Prediction 
			WHERE channelID = :channelID
			ORDER BY dateTimePredicted DESC
		";

		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		$statement->execute(array(':channelID' => $channelID));
		
		$years = array();
		while ($row = $statement->fetch()) { $years[] = $row['year']; }
		return $years;
		
	}
	
	public static function getUserPrediction($userID, $year) {
		
		$query = "
			SELECT predictionID FROM jaga_Prediction 
			WHERE userID = :userID AND year = :year
			ORDER BY dateTimeSubmitted DESC
			LIMIT 1
		";

		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID, ':year' => $year));
		
		$predictionID = 0;
		while ($row = $statement->fetch()) { $predictionID = $row['predictionID']; }
		return $predictionID;
		
	}
	
	public static function getUserPredictionArray($userID, $year) {
		
		$query = "
			SELECT predictionID FROM jaga_Prediction 
			WHERE userID = :userID AND year = :year
			ORDER BY dateTimeSubmitted DESC
		";

		$core = Core::getInstance();
		$statement = $core->database->prepare($query);
		$statement->execute(array(':userID' => $userID, ':year' => $year));
		
		$predictionArray = array();
		while ($row = $statement->fetch()) { $predictionArray[] = $row['predictionID']; }
		return $predictionArray;
		
	}
	
}

?>