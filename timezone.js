function setTime() {
	var timezone = jstz.determine_timezone();
	document.getElementById('hiddenTimezoneName').value=timezone.name();
	// alert('set timezone');
}