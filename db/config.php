<?php
	
	// database
	$_hostname = 'localhost';
	$_username = 'username';	// user
	$_password = 'password';	// pass
	$_database = 'database';	// db name

	// Make db-connection PDO way (new)

	$pdo = new PDO("mysql:host=$_hostname:3306;dbname=$_database",$_username,$_password);


?>