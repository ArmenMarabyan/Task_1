<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);

function connectDb() {

	$dbParams = require_once 'config/db_params.php';

	$db = mysqli_connect($dbParams['host'], $dbParams['user'], $dbParams['password']);

	if (!$db) {
		echo "Error: Unable to connect to MySQL. Please check your DB connection parameters.\n";
		exit;
	}

	$selDb = mysqli_select_db($db, "roomservice");

	if (!$selDb) {
		$sql = 'CREATE DATABASE roomservice';

		if (mysqli_query($db, $sql)) {
			echo "Database created successfully\n";
		} else {
			echo 'Error creating database: '. "\n";
		}
	}

	return $db;
}

?>