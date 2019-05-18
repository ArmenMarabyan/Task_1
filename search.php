<?php

	require_once dirname(__FILE__) . '/app/db_connect.php';
	require_once dirname(__FILE__) . '/app/functions.php';

	$db = connectDb();

	if(isset($_GET['search'])) {
		$result = searchResults($_GET['search'], $db);
	}
?>

<?php require_once dirname(__FILE__) . '/views/partials/header.php'; ?>


			<div class="col-lg-12 my-3 p-3 bg-white rounded shadow-sm">

				<?php include dirname(__FILE__) . '/views/partials/alerts.php'; ?>
				
				<form class="search_form mb-2" method="get" action="">
					<div class="form-group d-flex">
						<input type="text" class="form-control" placeholder="Search" name="search">
						<div class="input-group-append">
							<button class="btn btn-secondary" type="submit">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
				</form>

				<table class="table table-striped table-dark" id="addresses">
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
							<th scope="col">action</th>
						</tr>
					</thead>
					<tbody>

				<?php if(isset($result)): ?>
						<h3><?= mysqli_num_rows($result);?> results</h3>
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
								<th>
									<form action="result.php" method="get">
										<input type="hidden" value="<?=$row['id']?>" name="id">
										<button class="btn btn-secondary" type="submit">
											select
										</button>
									</form>
								</th>
							</tr>
						<?php endwhile; ?>						
			<?php endif; ?>
		    </tbody>
			</table>
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