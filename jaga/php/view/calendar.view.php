<?php

class CalendarView {

	public function displayCalendar($date,$channelID) {

		// selected month
		$selected_month = new DateTime($date);
		$cal_header = $selected_month->format('F Y');
		$first_weekday_of_month = $selected_month->format('N');
		$last_day_of_month = $selected_month->format('t');

		// previous year
		$prev_year = new DateTime($date);
		$prev_year->modify('-1 year');
		$previousYear = $prev_year->format('Y-m');

		// previous month
		$prev_month = new DateTime($date);
		$prev_month->modify('first day of previous month');
		$last_day_of_previous_month = $prev_month->format('t');
		$previousMonth = $prev_month->format('Y-m');
		
		// next month
		$next_month = new DateTime($date);
		$next_month->modify('first day of next month');
		$nextMonth = $next_month->format('Y-m');
		
		// next year
		$next_year = new DateTime($date);
		$next_year->modify('+1 year');
		$nextYear = $next_year->format('Y-m');
		
		// counter utilities
		$this_date = new DateTime($date);
		$this_date->modify('first day of this month');
		$days_left = $last_day_of_month;
		$end_of_previous_month_counter = $last_day_of_previous_month - $first_weekday_of_month;
		
		$h = '<div class="container">';
			$h .= '<div class="row">';
				$h .= '<div class="col-xs-12 calMonth">';

					$h .= "<div class=\"row\">";
						$h .= "<div class=\"col-xs-4\">";
							$h .= "<a class=\"btn btn-default calNavButton\" href=\"/calendar/" . $previousYear . "/\">";
								$h .= "<span class=\"glyphicon glyphicon-fast-backward\"></span>";
							$h .= "</a>";					
							$h .= "<a class=\"btn btn-default calNavButton\" href=\"/calendar/" . $previousMonth . "/\">";
								$h .= "<span class=\"glyphicon glyphicon-step-backward\"></span>";
							$h .= "</a>";
						$h .= "</div>";
						
						$h .= "<div class=\"col-xs-4 text-center\">" . $cal_header . "</div>";
						
						$h .= "<div class=\"col-xs-4 text-right\">";
							$h .= "<a class=\"btn btn-default pull-right calNavButton\" href=\"/calendar/" . $nextYear . "/\">";
								$h .= "<span class=\"glyphicon glyphicon-fast-forward\"></span>";
							$h .= "</a>";
							$h .= "<a class=\"btn btn-default pull-right calNavButton\" href=\"/calendar/" . $nextMonth . "/\">";
								$h .= "<span class=\"glyphicon glyphicon-step-forward\"></span>";
							$h .= "</a>";
						$h .= "</div>";
					$h .= "</div>";

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
									$h .= '<div class="calMonthDay"><a href="/calendar/' . $this_date->format('Y-m-d') . '/"><span class="glyphicon glyphicon-plus"></span>' . $this_date->format('j') . '</a></div>';
									$this_date->modify('+1 day');
									$days_left--;
								}
							}
						$h .= '</div>';

					}

					while ($days_left >= 7) { // middle rows: loop until less than 7 days left
						$h .= '<div class="calMonthWeek">';
						for ($x = 0; $x < 7; $x++) {
							$h .= '<div class="calMonthDay"><a href="/calendar/' . $this_date->format('Y-m-d') . '/"><span class="glyphicon glyphicon-plus"></span>' . $this_date->format('j') . '</a></div>';
							$this_date->modify('+1 day');
							$days_left--;
						}
						$h .= '</div>';
					}
					
					if ($days_left >= 1) { // last row: if more than one day remains
						$h .= '<div class="calMonthWeek">';
							$z = 1;
							for ($x = 0; $x < 7; $x++) {
								if ($days_left > 0) {
									$h .= '<div class="calMonthDay"><a href="/calendar/' . $this_date->format('Y-m-d') . '/"><span class="glyphicon glyphicon-plus"></span>' . $this_date->format('j') . '</a></div>';
									$this_date->modify('+1 day');
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