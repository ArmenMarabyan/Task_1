<?php

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}

	error_reporting(E_ALL);
	
	require_once 'functions.php';

	$db = connectDb();

	$result = mysqli_query($db, 'SELECT * FROM addresses');

	if(isset($_GET['search'])) {
		$query = htmlspecialchars(mysqli_real_escape_string($db, $_GET['search']));

		if (strlen($query) < 3) {
			echo "At least 3 characters are required\n";
		} else {
			$query = str_replace(' ', '* ', $query) . "*";
			$sql = "SELECT * FROM addresses 
					WHERE MATCH(address, street, street_name, street_type, adm, adm1, adm2)
					 	  AGAINST ('".$query."' IN BOOLEAN MODE)";
			$result = mysqli_query($db, $sql);
		}

	}

?>



<?php require_once dirname(__FILE__) . '/views/partials/header.php'; ?>

			<div class="col-lg-12 my-3 p-3 bg-white rounded shadow-sm">

				<?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
					<div class="alert alert-danger" role="alert">
						<ul>
						<?php foreach ($_SESSION['errors'] as $error): ?>
							<li><?=$error?></li>
						<?php endforeach ?>
						</ul>
					</div>
				<?php endif ?>
				
				<?php if($result): ?>

				<form class="search_form mb-2" method="get" action="search.php">
					<div class="form-group d-flex">
						<input type="text" class="form-control" placeholder="Search" name="search">
						<div class="input-group-append">
							<button class="btn btn-secondary" type="submit">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
				</form>

				<table class="table table-striped table-dark table-responsive" id="addresses">
					<thead>
						<tr>
							<th scope="col">id</th>
							<th scope="col">address</th>
							<th scope="col">streer</th>
							<th scope="col">street_name</th>
							<th scope="col">street_type</th>
							<th scope="col">adm</th>
							<th scope="col">adm1</th>
							<th scope="col">adm2</th>
							<th scope="col">cord_y</th>
							<th scope="col">cord_x</th>
						</tr>
					</thead>
					<tbody>

						<?php while($row = mysqli_fetch_assoc($result)): ?>
							<tr>
								<th scope="row"><?=$row['id']?></th>
								<td><?=$row['address']?></td>
								<td><?=$row['street']?></td>
								<td><?=$row['street_name']?></td>
								<td><?=$row['street_type']?></td>
								<td><?=$row['adm']?></td>
								<td><?=$row['adm1']?></td>
								<td><?=$row['adm2']?></td>
								<td><?=$row['cord_y']?></td>
								<td><?=$row['cord_x']?></td>
							</tr>
						<?php endwhile; ?>


					</tbody>
				</table>
				
				
			<?php endif; ?>
			</div>
		</div>
	</div>
	
<?php require_once dirname(__FILE__) . '/views/partials/scripts.php'; ?>
	

	<script>
		$(document).ready(function() {
		    $('#addresses').DataTable( {
		        "pagingType": "full_numbers",
		        searching: false,
		        info: false,
				"bSort" : false
		    });
		});
	</script>

</body>
</html>