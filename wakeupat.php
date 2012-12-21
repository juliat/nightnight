<?
require_once("calculator.php");
require_once("head.php"); 	
?>
<body>
	<h1><a href="index.php">night night</a></h1>
	<h2>bedtime calculator</h2>
<?
// user pressed zzz button, so tell them when they should go to sleep if
// they're going to bed now
if ($_GET['zzz'] == "1") {
	$timezoneName = $_POST['timezoneName'];
	// echo $timezoneName;
	$times = wake_up_times($timezoneName); 
?>
	
	<p>It takes about 14 minutes to fall asleep. If you get in bed right now, you should try to wake up at one of the following times.
	</p>
	
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
<?
}

?>
</body>
</html>