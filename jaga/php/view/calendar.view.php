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
		
		
		// events via content
		$first_day = $selected_month->format('Y-m-01');
		$last_day = $selected_month->format('Y-m-t');
		$events = Content::getEvents($first_day,$last_day,$channelID);
		
		$h = '<div class="container">';
		
			$h .= '<div class="row">';
			
				$h .= '<div class="col-xs-12">';
					$h .= "<div class=\"row\">";
						$h .= "<div class=\"col-xs-4\">";
							$h .= "<a class=\"btn btn-default calNavButton\" href=\"/calendar/" . $previousYear . "/\">";
								$h .= "<span class=\"glyphicon glyphicon-fast-backward\"></span>";
							$h .= "</a>";					
							$h .= "<a class=\"btn btn-default calNavButton\" href=\"/calendar/" . $previousMonth . "/\">";
								$h .= "<span class=\"glyphicon glyphicon-step-backward\"></span>";
							$h .= "</a>";
						$h .= "</div>";
						$h .= "<div class=\"col-xs-4 text-center\"><b>" . $cal_header . "</b></div>";
						$h .= "<div class=\"col-xs-4 text-right\">";
							$h .= "<a class=\"btn btn-default pull-right calNavButton\" href=\"/calendar/" . $nextYear . "/\">";
								$h .= "<span class=\"glyphicon glyphicon-fast-forward\"></span>";
							$h .= "</a>";
							$h .= "<a class=\"btn btn-default pull-right calNavButton\" href=\"/calendar/" . $nextMonth . "/\">";
								$h .= "<span class=\"glyphicon glyphicon-step-forward\"></span>";
							$h .= "</a>";
						$h .= "</div>";
					$h .= "</div>";
				$h .= "</div>";

				$h .= '<div class="col-xs-12">';
				
					$h .= '<div class="table-responsive">';
					
						$h .= "<table class=\"table table-bordered\">";
						
							$h .= '<tr class="calMonthWeek calMonthDaysOfWeek">';
								for ($x = -1; $x < 6; $x++) { $h .= '<th class="calMonthDay calMonthDayOfWeek">' . jddayofweek($x,2) . '</th>'; }
							$h .= '</tr>';

							if ($first_weekday_of_month != 7) { // first row: if first day of the week is not a sunday
								$h .= '<tr class="calMonthWeek">';
									for ($x = 0; $x < 7; $x++) {
										if ($x < $first_weekday_of_month) {
											$end_of_previous_month_counter++;
											$h .= '<td class="calMonthDay calMonthDayOutOfRangeDay">' . $end_of_previous_month_counter . '</td>';
										} else {
											$h .= '<td class="calMonthDay">';
												$ymd = $this_date->format('Y-m-d');
												$h .= '<p class="bg-info">' . $this_date->format('j') . '</p>';
												if (isset($events[$ymd])) {
													foreach ($events[$ymd] AS $contentID) {
														$event = new Content($contentID);
														$channel = new Channel($event->channelID);
														$h .= '<a href="http://' . $channel->channelKey . '.jaga.io' . $event->getURL() . '">' . $event->getTitle() . '</a>';
													}
												}
											$h .= '</td>';
											$this_date->modify('+1 day');
											$days_left--;
										}
									}
								$h .= '</tr>';
							}

							while ($days_left >= 7) { // middle rows: loop until less than 7 days left
								$h .= '<tr class="calMonthWeek">';
								for ($x = 0; $x < 7; $x++) {
									$h .= '<td class="calMonthDay">';
										$ymd = $this_date->format('Y-m-d');
										$h .= '<p class="bg-info">' . $this_date->format('j') . '</p>';
										if (isset($events[$ymd])) {
											foreach ($events[$ymd] AS $contentID) {
												$event = new Content($contentID);
												$channel = new Channel($event->channelID);
												$h .= '<a href="http://' . $channel->channelKey . '.jaga.io' . $event->getURL() . '">' . $event->getTitle() . '</a>';
											}
										}
									$h .= '</td>';
									$this_date->modify('+1 day');
									$days_left--;
								}
								$h .= '</tr>';
							}
							
							if ($days_left >= 1) { // last row: if more than one day remains
								$h .= '<tr class="calMonthWeek">';
									$z = 1;
									for ($x = 0; $x < 7; $x++) {
										if ($days_left > 0) {
											$h .= '<td class="calMonthDay">';
												$ymd = $this_date->format('Y-m-d');
												$h .= '<p class="bg-info">' . $this_date->format('j') . '</p>';
												if (isset($events[$ymd])) {
													foreach ($events[$ymd] AS $contentID) {
														$event = new Content($contentID);
														$channel = new Channel($event->channelID);
														$h .= '<a href="http://' . $channel->channelKey . '.jaga.io' . $event->getURL() . '">' . $event->getTitle() . '</a>';
													}
												}
											$h .= '</td>';
											$this_date->modify('+1 day');
											$days_left--;
										} else {
											$h .= '<td class="calMonthDay calMonthDayOutOfRangeDay">' . $z . '</td>';
											$z++;
										}
									}
								$h .= '</tr>';
							}
							
						$h .= '</table>';
					
					$h .= '</div>';
				
				$h .= '</div>';
				
			$h .= '</div>';

        $h .= '</div>';

		$h .= "<div class=\"container\">";
			$h .= "<div class=\"row\" id=\"list\">";
				foreach($events AS $date_events) {
					foreach ($date_events AS $contentID) {
						$h .= ContentView::listItem($contentID);
					}
				}
			$h .= "</div>";
		$h .= "</div>";

		return $h;

	}

}

?>