<?php
	
	// database
	$_hostname = 'localhost';
	$_username = 'root';	// user
	$_password = '';	// pass
	$_database = 'project4';	// db name

	// Make db-connection PDO way (new)
	$pdo = new PDO("mysql:host=$_hostname;dbname=$_database",$_username,$_password);
?>