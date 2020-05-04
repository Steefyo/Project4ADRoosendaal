<?php
	
	// database
	$db_hostname = 'localhost';
	$db_username = 'root';			// user
	$db_password = 'usbw';		// pass
	$db_database = 'project4';			// db name

	// Make db-connection
	$mysqli = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
?>