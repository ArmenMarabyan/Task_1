<?php

function addressesList($db) {
	return mysqli_query($db, 'SELECT * FROM addresses');
}

function getDistance($fromId, $toId) {
	global $db;
	$earthRadius = 6371;
	$sql = "SELECT cord_x, cord_y FROM addresses WHERE id=$fromId OR id=$toId";
	$query = mysqli_fetch_all(mysqli_query($db, $sql));
	$fromX = deg2rad($query[0][0]);
	$fromY = deg2rad($query[0][1]);
	$toX = deg2rad($query[1][0]);
	$toY = deg2rad($query[1][1]);
	$xDelta = abs($toX - $fromX);
	$yDelta = abs($toY - $fromY);
	$angle = 2 * asin(sqrt(pow(sin($xDelta / 2), 2) + cos($fromX) * cos($toX) * pow(sin($yDelta / 2), 2)));
	$distance = $angle * $earthRadius;
	if ($distance > 30) {
		$distance = round($distance, 0);
	} else {
		$distance = round($distance, 1);
	}
	return $distance;
}

function importXml($xml, $db) {
	$fileExt = pathinfo($xml['name'],PATHINFO_EXTENSION);

	if($fileExt != 'xml') {
		$_SESSION['errors'] = ['Please upload xml'];
	}else {
		mysqli_query($db, "DROP TABLE IF EXISTS addresses");
		$sql = "CREATE TABLE IF NOT EXISTS `addresses`(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		`address` varchar(255) NOT NULL,
		`street` varchar(255) NOT NULL,
		`street_name` varchar(255) NOT NULL,
		`street_type` varchar(255) NOT NULL,
		`adm` varchar(255) NOT NULL,
		`adm1` varchar(255) NOT NULL,
		`adm2` varchar(255) NOT NULL,
		`cord_y` varchar(255) NOT NULL,
		`cord_x` varchar(255) NOT NULL,
		FULLTEXT(address, street, street_name, street_type, adm, adm1, adm2)
		)";
		//todo

		if(mysqli_query($db, $sql)){
			
		} else{
			$_SESSION['errors'] = ['error'];
			exit();
		}

		$data = simplexml_load_file($xml['tmp_name']);


		foreach ($data->children() as $row) {
			$address = $row->addresses_address;
			$street = $row->addresses_street;
			$street_name = $row->addresses_street_name;
			$street_type = $row->addresses_street_type;
			$adm = $row->addresses_adm;
			$adm1 = $row->addresses_adm1;
			$adm2 = $row->addresses_adm2;
			$cord_y = $row->addresses_cord_y;
			$cord_x = $row->addresses_cord_x;

			$sql = "INSERT INTO addresses(address, street, street_name, street_type, adm, adm1, adm2, cord_y, cord_x) VALUES ('" . $address . "','" . $street . "','" . $street_name . "','" . $street_type . "','" . $adm . "','" . $adm1 . "','" . $adm2 . "','" . $cord_y . "','" . $cord_x . "')";

			$res = mysqli_query($db, $sql);

			if($res) {
				$_SESSION['success'] = ['Xml imported successfully'];
				if(!empty($_SERVER['HTTP_REFERER'])) {
				    
				
				    header("Location: /assignment_1");
				}
			} 
		}
	}
}

function searchResults($query, $db) {
	$query = trim(htmlspecialchars(mysqli_real_escape_string($db, $query)));
	if (strlen($query) < 3) {
		$result = NULL;
	} else {
		$query = str_replace(' ', '* ', $query) . "*";
		$sql = "SELECT * FROM addresses 
				WHERE MATCH(address, street, street_name, street_type, adm, adm1, adm2)
				 	  AGAINST ('".$query."' IN BOOLEAN MODE)";
		$result = mysqli_query($db, $sql);
	}

	return $result;
}