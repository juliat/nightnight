<? require_once("head.php"); ?>

<body onload="setTime()">
		
	<h1>night night</h1>
	<h2>bedtime calculator</h2>
	
	<form action="sleepat.php?bedtime=1" method="post">
	
		<label> I have to wake up at </label>
		
		<!-- display options for hours 1-12 -->
		<select name="hour">
			<? 
			// loop to generate values for hours
			for ($hour=1; $hour <= 12; $hour++) {  ?>
				<? 
					// special case: default wake up hour to 7 am
					if ($hour==7){
						echo "<option value=".$hour." selected=\"selected\">".$hour."</option>";
					}
					// general case: print the hour
					else{
						echo "<option value=".$hour.">".$hour."</option>";
					}
				?>
			<?  }  ?>
		</select>
		
		<!-- display options for minutes in 5 minute increments -->
		<select name="min">
			<? 
			// loop to generate values for minutes 
			for ($min=0; $min < 60; $min=$min+5) { ?>
				<? 
				// add a leading 0 when min < 10
				// e.g. '0' --> '00'
				if ($min < 10) {
					echo "<option value=".$min.">0".$min."</option>";
				}
				else {
					echo "<option value=".$min.">".$min."</option>";
				}
				?>
			<? } ?>
		</select>
			
		<!-- choose option for AM or PM -->	
		<select name="am_pm">
			<option>AM</option>
			<option>PM</option>
		</select>
		
		<input type="submit" value="When should I go to bed?" onClick="MakeRequest();">
		
	</form>
	
	
	<form action="wakeupat.php?zzz=1" method="post">
	
		<label> or, find out when to wake up if you go to bed now </label>
		
		<input id="hiddenTimezoneName" type="hidden" name="timezoneName" value="js-generated"; >
		
		<input id="zzz" type="submit" value="Zzz" onClick="MakeRequest();">
		
	</form>
	
<!-- End Document
================================================== -->
</body>
</html>