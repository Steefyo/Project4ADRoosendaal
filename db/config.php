<?php
	function Openpdo()
	// database
	$_hostname = 'localhost';
	$_username = 'root';	// user
	$_password = '1234';	// pass
	$_database = 'project4';	// db name

	// Make db-connection PDO way (new)

	$pdo = new PDO("mysql:host=$_hostname;dbname=$_database",$_username,$_password);

	return $pdo;
}

function $Closepdo($pdo)
{$pdo  -> close();

}
?>