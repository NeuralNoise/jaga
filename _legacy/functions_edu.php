<?php

/*
CREATE TABLE IF NOT EXISTS `edu_class` (
  `classID` int(8) NOT NULL auto_increment,
  `classAddedByUserID` int(8) NOT NULL,
  `classAddedDateTime` datetime NOT NULL,
  `classStartDateTime` datetime NOT NULL,
  `classEndDateTime` datetime NOT NULL,
  `classNameEnglish` varchar(100) NOT NULL,
  `classNameJapanese` varchar(100) NOT NULL,
  `classNameJapaneseReading` varchar(100) NOT NULL,
  `classDescription` text NOT NULL,
  `schoolID` int(8) NOT NULL,
  PRIMARY KEY  (`classID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

CREATE TABLE IF NOT EXISTS `edu_classStudent` (
  `classID` int(8) NOT NULL,
  `userID` int(8) NOT NULL,
  `classStudentAttended` varchar(3) NOT NULL,
  `classStudentTeacherComments` text NOT NULL,
  PRIMARY KEY  (`classID`,`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `edu_school` (
  `schoolID` int(8) NOT NULL auto_increment,
  `schoolAddedByUserID` int(8) NOT NULL,
  `schholAddedDateTime` datetime NOT NULL,
  `schoolNameEnglish` varchar(50) NOT NULL,
  `schoolNameJapanese` varchar(50) NOT NULL,
  `schoolNameJapaneseReading` varchar(50) NOT NULL,
  `schoolURL` varchar(255) NOT NULL,
  `schoolDescription` text NOT NULL,
  PRIMARY KEY  (`schoolID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
*/

function displayClassSeatingChart($classID) {

	if ($_SESSION['lang'] == 'en') { $languageUrlPrefix = ''; } else { $languageUrlPrefix = $_SESSION['lang'] . '/'; }

	if (!is_authed()) {
	echo '<div style="position:relative;float:left;width:615px;height:150px;border:1px solid #ccc;margin-bottom:5px;background-color:#fff;">';
	
		echo '
<p>英会話を習いたくても、毎週同じ時間に来れない！<br />
高い入学金・教材費など払いたくない！</p>

<p>そんな人にお勧め⇩⇩⇩<br />
英会話カフェでは営業時間であればご希望の日にち・時間でご予約できます。(営業時間⇨火・水・木の18:00〜21:00)</p>

<p>英会話カフェでは一回毎のセッションでのお支払となっております。<br />
他の料金は一切頂きません。(1セッション=1500円)</p>

<p>美味しいコーヒーや紅茶を飲みながら、リラックスして英会話を楽しみましょう♪(*^^)o∀*∀o(^^*)♪</p>';
	
	echo '</div>';
	}
	
	
	if (is_authed()) {
		echo '<div style="float:right;text-align:center;width:250px;border:solid 1px #ccc;background-color:#fff;">';
			echo agileResource('yourSchedule') . '<br />';
			$resultGetStudentSchedule = mysql_query("SELECT * FROM edu_classStudent LEFT JOIN edu_class ON edu_classStudent.classID = edu_class.classID WHERE edu_classStudent.userID = $_SESSION[userID] ORDER BY edu_class.classStartDateTime DESC" );
			if (mysql_num_rows($resultGetStudentSchedule) > 0) {
				echo '<table>';
				while($rowGetStudentSchedule = mysql_fetch_array($resultGetStudentSchedule)) {
					echo '<tr><td><a href="' . $languageURLPrefix . 'classes/' . $rowGetStudentSchedule['classID'] . '/">' . $rowGetStudentSchedule['classStartDateTime'] . '</a></td></tr>';
				}
				echo '</table>';
			} else {
				echo 'You are not registered for any classes yet.';
			}
			displayBanners(250);
		echo '</div>';
	} else {
		displayBanners(250);
	}
	
	
	echo '<div style="position:relative;float:left;width:615px;height:400px;background-color:#fff;border:1px solid #ccc;background-image:url(\'/agileImages/SeatingFor6.png\')">';
	
		echo '<div id="captainsChair">';
			// echo '<a class="eduSeat" href="' . $languageUrlPrefix . 'teacher/' . $classID . '/">';
			echo '<a class="eduSeat">';
				echo agileResource('nativeSpeakerGuide');
			echo '</a>';
		echo '</div>';
		
		echo '<div id="chair001">';
			$seat001 = isThisSeatTaken($classID, 1);
			if ($seat001 == 0) {
				echo '<a class="eduSeat" href="' . $languageUrlPrefix . 'enroll/' . $classID . '/1/">' . agileResource('reserveSeat') . '</a>';
			} else {
				echo '<a class="eduSeat">' . getUserName($seat001) . '</a>';
			}
		echo '</div>';
		
		echo '<div id="chair002">';
			$seat002 = isThisSeatTaken($classID, 2);
			if ($seat002 == 0) {
				echo '<a class="eduSeat" href="' . $languageUrlPrefix . 'enroll/' . $classID . '/2/">' . agileResource('reserveSeat') . '</a>';
			} else {
				echo '<a class="eduSeat">' . getUserName($seat002) . '</a>';
			}
		echo '</div>';
		
		echo '<div id="chair003">';
			$seat003 = isThisSeatTaken($classID, 3);
			if ($seat003 == 0) {
				echo '<a class="eduSeat" href="' . $languageUrlPrefix . 'enroll/' . $classID . '/3/">' . agileResource('reserveSeat') . '</a>';
			} else {
				echo '<a class="eduSeat">' . getUserName($seat003) . '</a>';
			}
		echo '</div>';
		
		echo '<div id="chair004">';
			$seat004 = isThisSeatTaken($classID, 4);
			if ($seat004 == 0) {
				echo '<a class="eduSeat" href="' . $languageUrlPrefix . 'enroll/' . $classID . '/4/">' . agileResource('reserveSeat') . '</a>';
			} else {
				echo '<a class="eduSeat">' . getUserName($seat004) . '</a>';
			}
		echo '</div>';
		
		echo '<div id="chair005">';
			$seat005 = isThisSeatTaken($classID, 5);
			if ($seat005 == 0) {
				echo '<a class="eduSeat" href="' . $languageUrlPrefix . 'enroll/' . $classID . '/5/">' . agileResource('reserveSeat') . '</a>';
			} else {
				echo '<a class="eduSeat">' . getUserName($seat005) . '</a>';
			}
		echo '</div>';
		
		echo '<div id="middleOfTable">';
			echo '<form method="post" id="changeClass" action="' . $languageUrlPrefix . 'classes/">';
				echo '<div style="text-align:left;">';
					echo '<table style="border:1px solid #ccc;margin:5px auto 5px auto;">';
					
							$resultGetClassInfo = mysql_query("SELECT * FROM edu_class WHERE classType = 'eikaiwa' AND classID = $classID LIMIT 1");
							while($rowGetClassInfo = mysql_fetch_array($resultGetClassInfo)) {
								echo '<tr>';
									echo '<td class="borderAlignCenter">';
										displayClassDropdown($classID);
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td class="borderAlignCenter">';
										if ($_SESSION['lang'] == 'ja') {
											echo $rowGetClassInfo['classNameJapanese'];
										} else {
											echo $rowGetClassInfo['classNameEnglish'];
										}
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td class="borderAlignCenter">' . $rowGetClassInfo['classDescription'] . '</td>';
								echo '</tr>';
							}
					echo '</table>';
				echo '</div>';
			echo '</form>';
		echo '</div>';
		
	echo '</div>';
	
	
	
	echo '<div style="clear:both;"></div>';

}


function educationGetCutOffDateTime($hours) {
	$cutOffTimeStamp= time() + ($hours * 3600);
	$cutOffDateTime = date('Y-m-d H:i:s', $cutOffTimeStamp);
	return $cutOffDateTime;
}


function displayClassDropdown($classID) {
	echo '<select name="classID" style="width:250px;" onChange="document.forms[\'changeClass\'].submit()">';
		$cutOffDate = educationGetCutOffDateTime(24);
		$resultGetClassList = mysql_query( "SELECT * FROM edu_class WHERE classType = 'eikaiwa' AND classStartDateTime > '$cutOffDate' ORDER BY classStartDateTime ASC" );
		while($rowGetClassList = mysql_fetch_array($resultGetClassList)) {
			echo '<option value="' . $rowGetClassList['classID'] . '"';
				if ($classID == $rowGetClassList['classID']) { echo ' selected="selected"'; }
				echo '>' . formatDateAndTime(strtotime($rowGetClassList['classStartDateTime']));
				echo '～';
				echo getTimeFromTimestamp(strtotime($rowGetClassList['classEndDateTime']));
			echo ' (一人に&yen;' . $rowGetClassList['classTuition'] . ')';		
			echo '</option>';
		}
	echo '</select>';
}


function getClassName($classID) {
		$resultGetClassName = mysql_query("SELECT * FROM edu_class WHERE classID = $classID LIMIT 1");
		while($rowGetClassName = mysql_fetch_array($resultGetClassName)) {
			if ($_SESSION['lang'] == 'ja') {
				return $rowGetClassName['classNameJapanese'];
			} else {
				return $rowGetClassName['classNameEnglish'];
			}
		}
}

function getClassStartDateTime($classID) {
		$resultGetClassStartDateTime = mysql_query("SELECT * FROM edu_class WHERE classID = $classID LIMIT 1");
		while($rowGetClassStartDateTime = mysql_fetch_array($resultGetClassStartDateTime)) {
			return $rowGetClassStartDateTime['classStartDateTime'];
		}
}

function getClassEndDateTime($classID) {
		$resultGetClassEndDateTime = mysql_query("SELECT * FROM edu_class WHERE classID = $classID LIMIT 1");
		while($rowGetClassEndDateTime = mysql_fetch_array($resultGetClassEndDateTime)) {
			return $rowGetClassEndDateTime['classEndDateTime'];
		}
}


function insertClassStudent($classID, $seatID) {

		$userID = $_SESSION['userID'];
		$classStudentEnrollmentDateTime = date('Y-m-d H:i:s');
		
		$queryInsertClassStudent = "INSERT INTO edu_classStudent (
			classID,
			userID,
			classStudentEnrollmentDateTime,
			classStudentSelectedSeat
			) VALUES (
			$classID,
			$userID,
			'$classStudentEnrollmentDateTime',
			$seatID
		)";

		mysql_query ($queryInsertClassStudent) or die ('ERROR: insertClassStudent()');

}





function isThisSeatTaken($classID, $seatID) {

/*
CREATE TABLE IF NOT EXISTS `edu_classStudent` (
  `classID` int(8) NOT NULL,
  `userID` int(8) NOT NULL,
  `classStudentEnrollmentDateTime` datetime NOT NULL,
  `classStudentAttended` varchar(3) NOT NULL,
  `classStudentTeacherComments` text NOT NULL,
  `classStudentSelectedSeat` varchar(8) NOT NULL,
  PRIMARY KEY  (`classID`,`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
*/
	
	$resultIsThisSeatTaken = mysql_query("SELECT * FROM edu_classStudent WHERE classID = $classID AND classStudentSelectedSeat = $seatID LIMIT 1");
	if (mysql_num_rows($resultIsThisSeatTaken) == 1) {
		while($rowIsThisSeatTaken = mysql_fetch_array($resultIsThisSeatTaken)) {
			return $rowIsThisSeatTaken['userID'];
			// return "SELECT * FROM edu_classStudent WHERE classID = $classID AND classStudentSelectedSeat = $seatID LIMIT 1";
		}
	} else {
		return 0;
	}

}









































function displayEduCourseTable() {

	if ($_SESSION['roleID'] == 'Super Administrator') {
		$resultGetStudentCourses = mysql_query("SELECT * FROM edu_course" );
	} else {
		$resultGetStudentCourses = mysql_query("SELECT * FROM edu_courseStudent LEFT JOIN edu_course ON edu_courseStudent.courseID = edu_course.eduCourseID WHERE edu_courseStudent.userID = $_SESSION[userID];" );
	}
	
	
	if (mysql_num_rows($resultGetStudentCourses) > 0) {
	
		echo '<div style="text-align:center;">';
			echo '<table style="margin:5px auto 5px auto;background-color:#fff;">';
				while($rowGetStudentCourses = mysql_fetch_array($resultGetStudentCourses)) {
					echo '<tr>';
						echo '<td class="borderAlignLeft">';
							echo '<a href="' . languageUrlPrefix() . 'courses/' . $rowGetStudentCourses['eduCourseID'] . '/">' . $rowGetStudentCourses['eduCourseTitleEnglish'] . '</a>';
						echo '</td>';
					echo '</tr>';
				}
			echo '</table>';
		echo '</div>';
		
		
	} else {
		echo 'You are not yet enrolled in any courses. Please ask Christopher.';
	}
}




function displayEduCourseView($courseID) {

	echo '<div style="text-align:center;">';
		
			echo '<table style="margin:5px auto 5px auto;">';
		
		$resultGetCourseClasses = mysql_query("SELECT * FROM edu_class WHERE eduCourseID = $courseID" );
		
		echo '<tr>';
		
			echo '<td class="borderAlignCenter">' . agileResource('class') . '</td>';
			echo '<td class="borderAlignCenter">' . agileResource('attendance') . '</td>';
			echo '<td class="borderAlignCenter">' . agileResource('assignment') . '</td>';
			echo '<td class="borderAlignCenter">' . agileResource('test') . '</td>';
			echo '<td class="borderAlignCenter">' . agileResource('grade') . '</td>';
		
		echo '</tr>';
		
		while($rowReturnCourseClass = mysql_fetch_array($resultGetCourseClasses)) {
		
			$classAttendancePoints = $rowReturnCourseClass['classAttendancePoints'];
		
			echo '<tr>';
				echo '<td class="borderAlignLeft">' . $rowReturnCourseClass['classStartDateTime'] . '</td>';
				echo '<td class="borderAlignCenter">';
				
					$resultGetThisStudentsAttendanceThisClass = mysql_query("SELECT * FROM edu_classStudent WHERE classID = $rowReturnCourseClass[classID] AND userID = $_SESSION[userID] LIMIT 1");
					while($rowGetThisStudentsAttendanceThisClass = mysql_fetch_array($resultGetThisStudentsAttendanceThisClass)) {
						if ($rowGetThisStudentsAttendanceThisClass['classStudentAttended'] == 1) {
							echo $classAttendancePoints . ' / ' . $classAttendancePoints;
						}
					}
				
				echo '</td>';
				echo '<td class="borderAlignCenter"></td>';
				echo '<td class="borderAlignCenter"></td>';
				echo '<td class="borderAlignCenter"></td>';
			echo '</tr>';
		
		}
			echo '</table>';
		echo '</div>';
}



function howManyClassesIsStudentIn($studentID) {
	$resultGetClassesStudentIsIn = mysql_query("SELECT * FROM edu_classStudent WHERE userID = $studentID");
	return mysql_num_rows($resultGetClassesStudentIsIn);
}

?>