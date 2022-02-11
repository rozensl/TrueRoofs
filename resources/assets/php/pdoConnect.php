<?php
	// to make the connection to the database using the pdo api
	// https://zetcode.com/php/pdo/
	
	// variables to connect 
	$servername = "localhost";
	$dbname = "trueroofs";
	$user = "root";
	$passwd = "";
	
	// pdo object
	$pdo = NULL;

	try {
		$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $user, $passwd);
	} catch (PDOException $e) {
		// exception if connection failed
		echo '<p> database connection failed</p>';
		die();
	}
?>