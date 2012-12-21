<?
require_once("calculator.php");
require_once("head.php"); 	
?>
<body>
	<h1><a href="index.php">night night</a></h1>
	<h2>bedtime calculator</h2>

<?
if ($_GET['bedtime'] == "1") { 
	// get form data
	$hour = $_POST['hour'];
	$min =  $_POST['min'];
	$am_pm = $_POST['am_pm'];
	$wake_up_time = formatTime($hour, $min);
	// calculate times
	$times = sleep_times($hour, $min, $am_pm);
	// print_r($times);
?>
	<p> If you have to get up at <strong><? echo $wake_up_time; ?></strong>, then you should try to go to bed at one of the following times.</p>
	<p class="note">(Note: these times are when you should be getting in bed; they give you 14 minutes to fall asleep.)</p>
	
	<ul>
<?
	/* print an html list of the times, going from the last time in the list (most hours of sleep)
	 * to the first (least hours of sleep) */
	for ($cycle = 6; $cycle >= 1; $cycle--) {
		$time = $times[$cycle];
		$hours_of_sleep = $times[$time];
?>
		<li id="<?echo $cycle."-cycles";?>">
			<? echo $time; ?>, <span>for</span>
			<? echo $hours_of_sleep; ?> hours <span>of sleep </span>
		</li>
<?	}
?>
	</ul>
	
	<p>Sleep cycles last 90 minutes. Waking up in the middle of a sleep cycle leaves you feeling tired and groggy, but waking up in between cycles lets you wake up feeling refreshed and alert!
	</p>
<?
}
?>
</body>
</html>