<?php

class CalendarView {

	public function displayCalendar($yearMonth,$channelID) {

		// selected month
		$d = new DateTime($yearMonth);
		$cal_header = $d->format('F Y');
		$first_weekday_of_month = $d->format('N');
		$last_day_of_month = $d->format('t');
		$date_counter = 1;
		$days_left = $last_day_of_month;
		
		// previous month
		$d->modify('first day of previous month');
		$last_day_of_previous_month = $d->format('t');
		$end_of_previous_month_counter = $last_day_of_previous_month - $first_weekday_of_month;
		
		$h = '<div class="container">';
			$h .= '<div class="row">';
				$h .= '<div class="col-xs-12 calMonth">';
					
					$h .= '<div class="calMonthHeader">' . $cal_header . '</div>';
					
					$h .= '<div class="calMonthWeek calMonthDaysOfWeek">';
						for ($x = -1; $x < 6; $x++) {
							$h .= '<div class="calMonthDay calMonthDayOfWeek">' . jddayofweek($x,2) . '</div>';
						}
					$h .= '</div>';
					
					if ($first_weekday_of_month != 7) { // first row: if first day of the week is not a sunday
						
						$h .= '<div class="calMonthWeek">';
							for ($x = 0; $x < 7; $x++) {
								if ($x < $first_weekday_of_month) {
									$end_of_previous_month_counter++;
									$h .= '<div class="calMonthDay calMonthDayOutOfRangeDay">' . $end_of_previous_month_counter . '</div>';
								} else {
									$h .= '<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>' . $date_counter . '</a></div>';
									$date_counter++;
									$days_left--;
								}
							}
						$h .= '</div>';

					}

					while ($days_left >= 7) { // middle rows: loop until less than 7 days left
						$h .= '<div class="calMonthWeek">';
						for ($x = 0; $x < 7; $x++) {
							$h .= '<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>' . $date_counter . '</a></div>';
							$date_counter++;
							$days_left--;
						}
						$h .= '</div>';
					}
					
					if ($days_left >= 1) { // last row: if more than one day remains
						$h .= '<div class="calMonthWeek">';
							$z = 1;
							for ($x = 0; $x < 7; $x++) {
								if ($days_left > 0) {
									$h .= '<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>' . $date_counter . '</a></div>';
									$date_counter++;
									$days_left--;
								} else {
									$h .= '<div class="calMonthDay calMonthDayOutOfRangeDay">' . $z . '</div>';
									$z++;
								}
							}
						$h .= '</div>';
					}
					
				$h .= '</div>';
			$h .= '</div>';
        $h .= '</div>';

		return $h;

	}


}

?>