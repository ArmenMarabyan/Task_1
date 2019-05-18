<?php

function connectDb() {
	// $host = $_SERVER['SERVER_NAME'];
	// $port = '3306';
	// $user = 'root';
	// $password = '';

	$dbParams = require_once  dirname(__FILE__) . '/config/db_params.php';
	// try{
	// 	$db = mysqli_connect($host , 'root', '', 'roomservice');
	//     if (!$db){
	//         throw new Exception('Unable to connect');
	//     }

	// }
	// catch(Exception $e){
	//     echo $e->getMessage();
	// }

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