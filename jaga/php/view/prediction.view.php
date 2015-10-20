<?php

class PredictionView {

	private $contestState; // 'open','pending','closed'

	public static function displayPredictions($inputArray, $errorArray) {
		
		$years = Prediction::getYears($_SESSION['channelID']);

		$html = "\n\n";
		$html .= "\t\t<div class=\"container\"> <!-- START CONTAINER -->\n";
		
			$html .= "<div class=\"row\">";
			
				$html .= "<div class=\"col-xs-12 col-md-4 col-md-push-8\">";
					$html .= Self::predictionForm($inputArray, $errorArray);
				$html .= "\t\t</div>\n\n";
				
				$html .= "<div class=\"col-xs-12 col-md-8 col-md-pull-4\">";
					$html .= "\t\t\t<div class=\"panel-group\" id=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">\n";

						foreach ($years as $year) {
							
							$html .= "\t\t\t\t<div class=\"panel panel-default\">\n";
								
								$html .= "\t\t\t\t\t<div class=\"panel-heading\" role=\"tab\" id=\"heading$year\">\n";
									$html .= "\t\t\t\t\t\t<h4 class=\"panel-title\">";
										$html .= "<a class=\"" . ($years[0] == $year ? "" : "collapsed") . "\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse$year\" aria-expanded=\"true\" aria-controls=\"collapse$year\">" . $year . "</a>";
									$html .= "</h4>\n";
								$html .= "\t\t\t\t\t</div>\n";
								
								$html .= "\t\t\t\t\t<div id=\"collapse$year\" class=\"panel-collapse collapse" . ($years[0] == $year ? " in" : "") . "\" role=\"tabpanel\" aria-labelledby=\"heading$year\">\n";
									
									$html .= "\t\t\t\t\t\t<div class=\"panel-body\">\n";
											
													
										$predictions = Prediction::getPredictions($_SESSION['channelID'], $year, 'dateTimePredicted DESC');
										for ($i = 0; $i < count($predictions); $i++) {
									
											$prediction = new Prediction($predictions[$i]);
											$predictionID =  $prediction->predictionID;
											$userID = $prediction->userID;
											$dateTimePredicted = date('Y-m-d H:i', strtotime($prediction->dateTimePredicted));
											$comment = $prediction->comment;
											$result = $prediction->result;
											$year = $prediction->year;

											$user = new User($userID);
											$username = $user->username;
											$userDisplayName = $user->userDisplayName;

											switch($result) {
												case 'winner': $trClass = "bg-success"; break;
												case 'runnerup': $trClass = "bg-warning"; break;
												default:
													if ($userID == $_SESSION['userID']) { $trClass = "bg-info"; } 
													else if ($i%2==1) { $trClass = "alternate-row"; }
													else { $trClass = ""; } break;
											}

											$html .= "<div class=\"" . $trClass . "\"><p>";
											
												$imageURL = Image::getObjectMainImagePath('User', $userID, 50);
												if ($imageURL) { $html .= "<a href=\"http://jaga.io/u/" . urlencode($username) . "/\"><img src=\"$imageURL\" style=\"margin:5px;width:50px;\"></a>"; }
												if ($result != "" && $result != "-") { $html .=  "<strong>" . strtoupper($result) . "</strong><span class=\"hidden-xs\">: </span><br class=\"visible-xs-inline\"/>"; }
												$html .= "<b><a href=\"http://jaga.io/u/" . urlencode($username) . "/\">" . ($userDisplayName?$userDisplayName:$username) . "</a></b><span class=\"hidden-xs\"> => </span><br class=\"visible-xs-inline\"/>";
												$html .= date('M jS \a\t\ H:i a', strtotime($dateTimePredicted));
												
											$html .= "</p></div>";

										}
												
									$html .= "\t\t\t\t\t\t</div>\n";
								$html .= "\t\t\t\t\t</div>\n";
							$html .= "\t\t\t\t</div>\n";

						}

					$html .= "\t\t\t</div>\n";
				$html .= "\t\t</div>\n\n";
			$html .= "\t\t</div>\n\n";
		$html .= "\t\t</div>\n\n";
		
		return $html;
	
	}

	public static function predictionForm($inputArray = array(), $errorArray = array()) {
		
		$predictionID = Prediction::getUserPrediction(($_SESSION['userID']),date('Y'));
		$prediction = new Prediction($predictionID);
		$dateTimePredicted = $prediction->dateTimePredicted;
		
		if (isset($inputArray['date'])) { $date = $inputArray['date']; } else { $date = date('Y-m-d', strtotime($dateTimePredicted)); }
		if (isset($inputArray['time'])) { $time = $inputArray['time']; } else { $time = date('H:i', strtotime($dateTimePredicted)); }

		$html = "<div class=\"panel panel-default\">";
			$html .= "<div class=\"panel-heading\"><div class=\"panel-title\">" . date('Y') . " " . Lang::getLang('firstSnowContest') . "</div></div>";
			$html .= "<div class=\"panel-body\">";
			
				$html .= "Congratulations <a href=\"/u/RML/\">RML</a>, you are the winner of this year's first snow contest! You've won a dinner for 6 including drinks at <a href=\"https://www.facebook.com/lecochon.niseko\" target=\"_blank\">Bistrot le Cochon</a>.";
				/*
				$html .= "<form class=\"form-horizontal\" id=\"jagaPredictionForm\" name=\"jagaPredictionForm\"" . (Authentication::isLoggedIn()?" method=\"post\" action=\"/first-snow-contest/\"":"") . ">";
					$html .= "<div class=\"form-group" . (isset($errorArray['date'])?"  has-error":"") . "\">";
						$html .= "<label for=\"date\" class=\"control-label col-xs-3\">" . Lang::getLang('predictionDate') . "</label>";
						$html .= "<div class=\"col-xs-9\"><input class=\"form-control\" type=\"date\" name=\"date\" value=\"" . $date . "\" required " . (Authentication::isLoggedIn()?"":" readonly") . "></div>";
					$html .= "</div>";
					$html .= "<div class=\"form-group" . (isset($errorArray['time'])?"  has-error":"") . "\">";
						$html .= "<label for=\"time\" class=\"control-label col-xs-3\">" . Lang::getLang('predictionTime') . "</label>";
						$html .= "<div class=\"col-xs-9\"><input class=\"form-control\" type=\"time\" name=\"time\" value=\"" . $time . "\" required " . (Authentication::isLoggedIn()?"":" readonly") . "></div>";
					$html .= "</div>";
					
					if (Authentication::isLoggedIn()) {
						if ($predictionID) { $buttonValue = 'updateYourEntry'; } else { $buttonValue = 'submitYourEntry'; }
						$html .= "<input class=\"btn btn-default btn-block jagaFormButton\" type=\"submit\" name=\"jagaPredictionSubmit\" id=\"jagaPredictionSubmit\" value=\"" . Lang::getLang($buttonValue) . "\">";
					} else {
						$html .= "<a class=\"btn btn-default btn-block jagaFormButton\" href=\"/login/\" name=\"jagaPredictionSubmit\" id=\"jagaPredictionSubmit\">" . Lang::getLang('loginToEnter') . "</a>";
					}
				$html .= "</form>";
				*/
				
			$html .= "</div>";
		$html .= "</div>\n\n";

		return $html;
		
	}
	
	public static function predictionContentWidget() {
		
		$html = "\t\t\t\t<div class=\"item col-xs-12 col-sm-6 col-md-4 col-lg-3\">\n";
			$html .= "\t\t\t\t\t<div class=\"panel panel-default\">\n";
				
				$html .= "\t\t\t\t\t\t<div class=\"panel-heading jagaContentPanelHeading\">\n";
					$html .= "<h4><a href=\"/first-snow-contest/\">" . date('Y') . " " . Lang::getLang('firstSnowContest') . "</a></h4>";
				$html .= "\t\t\t\t\t\t</div>\n";


				$html .= "<div class=\"panel-body\">";
				
					// $html .= "Snow has been forecast for Niseko-Hirafu. We will post results soon!<hr />";
					
					$html .= "<p><b>Congratulations <a href=\"/u/RML/\">RML</a>!</b> You are the winner of The Kutchannel's 8th Annual Niseko First Snow Contest!</p><hr />";
					
					$html .= "<p>You've won a dinner for 6 including drinks at <a href=\"https://www.facebook.com/lecochon.niseko\" target=\"_blank\">Bistrot le Cochon</a>.</p><hr />";
					
					$html .= "<p><small>THANK TO EVERYBODY for playing, THANKS TO <a href=\"http://360niseko.com/\" target=\"_blank\">360NISEKO.COM</a> for judging, ";
					$html .= "THANKS TO <a href=\"https://www.facebook.com/lecochon.niseko\" target=\"_blank\">BISTROT LE COCHON</a> for sponsoring, ";
					
					if ($_SESSION['userID']) { $html .= "and THANK <a href=\"/u/" . User::getUserName($_SESSION['userID']) . "/\">YOU</a> for using The Kutchannel!</small></p>"; }
					else { $html .= "and THANK YOU for using The Kutchannel!</i></p>"; }
					
					/*
					$predictions = Prediction::getPredictions($_SESSION['channelID'], date('Y'), 'dateTimeSubmitted DESC', 5);
					for ($i = 0; $i < count($predictions); $i++) {
				
						$prediction = new Prediction($predictions[$i]);
						$predictionID =  $prediction->predictionID;
						$userID = $prediction->userID;
						$dateTimePredicted = date('Y-m-d H:i', strtotime($prediction->dateTimePredicted));
						$year = $prediction->year;

						$user = new User($userID);
						$username = $user->username;
						$userDisplayName = $user->userDisplayName;

						if ($i%2==1) { $trClass = "alternate-row"; } else { $trClass = ""; }
						
						$html .= "<div class=\"" . $trClass . "\" style=\"margin-bottom:10px;\">";
						
							$html .= "<div style=\"float:left;\">";
								$imageURL = Image::getObjectMainImagePath('User', $userID, 50);
								if ($imageURL) { $html .= "<a href=\"http://jaga.io/u/" . urlencode($username) . "/\"><img src=\"$imageURL\" style=\"width:50px;margin:5px;\"></a>"; }
							$html .= "</div>";
							
							$html .= "<div style=\"float:left;\">";
								$html .= "<b><a href=\"http://jaga.io/u/" . urlencode($username) . "/\">" . ($userDisplayName?$userDisplayName:$username) . "</a></b><br />";
								$html .= date('M jS \a\t\ H:i a', strtotime($dateTimePredicted));
							$html .= "</div>";
							
							$html .= "<div style=\"clear:both;\"></div>";
							
						$html .= "</div>";

					}
					*/
					
					// if (empty(Prediction::getUserPredictionArray($_SESSION['userID'],date('Y')))) { $html .= self::predictionForm(); }
				
				$html .= "</div>";

			$html .= "\t\t\t\t\t</div>\n";
		$html .= "\t\t\t\t</div>\n";
		
		return $html;
		
	}
	
}

?>