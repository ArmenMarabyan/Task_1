<?php
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	require_once 'functions.php';

	$db = connectDb();

	if(isset($_REQUEST['submit'])) {
	if(isset($_FILES['file']['name'])) {
		
		$xml = $_FILES['file'];
		$fileExt = pathinfo($xml['name'],PATHINFO_EXTENSION);

		if($fileExt != 'xml') {
			$_SESSION['errors'] = 'Please import xml';
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

			if(mysqli_query($db, $sql)){
					//echo "Table created successfully.";
			} else{
					//echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
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
					header("Location: /");
				} 


			}
		}
	}

}


?>

<?php require_once dirname(__FILE__) . '/views/partials/header.php'; ?>


			<div class="col-lg-12 my-3 p-3 bg-white rounded shadow-sm">

				<form action="import.php" method='post' enctype="multipart/form-data">
					
					<div class="form-group">
						<div class="custom-file mb-3">
							<input type="file" class="custom-file-input" id="customFile" name="file">
							<label class="custom-file-label" for="customFile">Choose XML</label>
						</div>
					</div>

					<div class="mt-3">
						<button type="submit" class="btn btn-primary" name="submit">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	

<?php require_once dirname(__FILE__) . '/views/partials/scripts.php'; ?>



</body>
</html>

