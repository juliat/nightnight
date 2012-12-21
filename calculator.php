<? 
function calcTime($hr, $min, $add_subt, $minutes) {

	$hr = (int)$hr;
	$min = (int)$min;
	
	//add the minutes
	if ($add_subt == "add") {
		$min += $minutes;
	}
	else {
		$min -= $minutes;
	}
	while($min >= 60) {
		// when minutes overflow, go to hours
		$min = $min - 60;
		$hr = $hr + 1;
	}

	while($min < 0) {
		// when minutes go negative, start subtracting hours
		$min += 60;
		$hr = $hr - 1;
	}

	// when hours go negative, that means we're in the previous day and shold work
	// in those 24 hours
	if ($hr <= 0) {
		$hr += 24;
	}
	
	// mod the hours so that they are less than 24
	$hr = $hr % 24;
	
	return array('hr' => $hr,
				 'min' => $min
				 );
}


function formatTime($hr, $min) {

	if ($hr < 12) {
		$am_pm = "AM";
	}
	else {
		$am_pm = "PM";
	}
	
	// now that we know if it's morning or night, we can change
	// the hours to 12 hour format
	$hr = $hr % 12;
	// 12%12 = 0, hr should be formatted as 12 there
	if ($hr == 0){
		$hr = "12";
	}
	// add leading 0 to single digit minutes
	if ($min < 10) {
		$min = "0".$min;
	}
	
	// concatenate time string
	$time = $hr.":".$min." ".$am_pm;
	
	return $time;
}


/* given a time (in hours and minutes) and whether the cycles are for waking or sleeping, 
 * returns an array of times when a person should go to bed or wake up and associates 
 * each time with how many hours of sleep a person will get 
 * if they go to bed or wake up at the time */
function getCycles($wake_or_sleep, $hr, $min) {
	// if calculating sleep cycle times for wake_up times, add 90 minutes to calculate the cycles
	if ($wake_or_sleep == "wake") {
		$time_operation = "add";
	}
	// if calculating sleep cycle times for sleep_times, (when to go to sleep, given a wake up time), 
	// subtract 90 minutes to calculate the cycles
	else {
		// wake or sleep == sleep
		$time_operation = "subt";
	}
	
	// sleep cycles are 90 min
	// give options for 1, 2, 3, 4, 5, 6 sleep cycles
	$cycleTimes = array();
	for ($cycles=1; $cycles <= 6; $cycles++) { 

		// add 90 min for every iteration
		$newTime = calcTime($hr, $min, $time_operation, 90);
		$hr = $newTime['hr'];
		$min = $newTime['min'];
		$time = formatTime($hr, $min); 
		
		$cycleTimes[$cycles] = $time;
		$cycleTimes[$time] = 1.5*$cycles; // maps cycles to hours of sleep
	}  // end for
	
	return $cycleTimes;
}



/* given user's current timezone, gets the time and returns an 	
 * array of times when a person should wake up */
function wake_up_times($timezone) {
	
	// if javascript has retreived the user's timezone, use that value to set the timezone
	if ($timezone != "js-generated") {
		date_default_timezone_set($timezone);
	}
	// otherwise use East Coast time as default
	else {
		date_default_timezone_set('America/New_York');
	}
	
	// get current time
	$now = explode(":", date("H:i")); // date returns a string like 17:16:18, hours:min:sec (with leading 0s)
	// split it into hours and minutes
	$hr = $now[0];
	$min = $now[1];
	// time of day
	if ($hr >= 12) {
		$am_pm = "PM";
	}
	else {
		$am_pm = "AM";
	}

	// add 14 minutes to current time -- it takes 14 minutes to fall asleep
	$newTime = calcTime($hr, $min, "add", 14);
	$hr = $newTime['hr'];
	$min = $newTime['min'];

	// call cycle-calculating function
	$wakeupTimes = getCycles("wake", $hr, $min);

	return $wakeupTimes;
	
}
	
	

/* given a time when a person needs to wake up, returns the times that they
 * should try to go to bed */
function sleep_times($hr, $min, $am_pm) {
	
	// factor in 14 minutes that it will take someone to 
	// fall asleep
	$adjusted_time = calcTime($hr, $min, "subt", 14);
	$hr = $adjusted_time['hr'];
	$min = $adjusted_time['min'];
	
	// call get cycles to get array of times
	$sleepTimes = getCycles("sleep", $hr, $min);
		
	return $sleepTimes;
}

?>

