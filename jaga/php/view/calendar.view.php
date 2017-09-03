<?php

class CalendarView {

	public function displayCalendar($yearMonth,$channelID) {

		// $events = Content::getEvents();
	
		// foreach ($events AS $eventID) {
			
			// $event = new Content($eventID);
			// $contentIsEvent = $event->contentIsEvent;
			// $contentEventDate = $event->contentEventDate;
			// $contentEventStartTime = $event->contentEventStartTime;
			
		// }

		$html = '
		
		<div class="container">
		
            <div class="row">

				<div class="col-xs-12 calMonth">
                
					<div class="calMonthHeader">July 2015</div>
					
					<div class="calMonthWeek calMonthDaysOfWeek">
						<div class="calMonthDay calMonthDayOfWeek">SUN</div>
						<div class="calMonthDay calMonthDayOfWeek">MON</div>
						<div class="calMonthDay calMonthDayOfWeek">TUE</div>
						<div class="calMonthDay calMonthDayOfWeek">WED</div>
						<div class="calMonthDay calMonthDayOfWeek">THU</div>
						<div class="calMonthDay calMonthDayOfWeek">FRI</div>
						<div class="calMonthDay calMonthDayOfWeek">SAT</div>
					</div>
					
					<div class="calMonthWeek">
						<div class="calMonthDay calMonthDayOutOfRangeDay">28</div>
						<div class="calMonthDay calMonthDayOutOfRangeDay">29</div>
						<div class="calMonthDay calMonthDayOutOfRangeDay">30</div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>1</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>2</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>3</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>4</a></div>
					</div>
					
					<div class="calMonthWeek">
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>5</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>6</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>7</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>8</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>9</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>10</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>11</a></div>
					</div>
					
					<div class="calMonthWeek">
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>12</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>13</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>14</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>15</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>16</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>17</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>18</a></div>
					</div>

					<div class="calMonthWeek">
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>19</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>20</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>21</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>22</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>23</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>24</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>25</a></div>
					</div>

					<div class="calMonthWeek">
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>26</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>27</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>28</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>29</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>30</a></div>
						<div class="calMonthDay"><a href="#"><span class="glyphicon glyphicon-plus"></span>31</a></div>
						<div class="calMonthDay calMonthDayOutOfRangeDay">1</a></div>
					</div>
				
				</div>
				
			</div> <!-- END ROW -->
        </div> <!-- END CONTAINER -->
		
		';

		return $html;

	}


}

?>