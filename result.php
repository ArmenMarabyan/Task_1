<?php

	require_once dirname(__FILE__) . '/app/db_connect.php';
	require_once dirname(__FILE__) . '/app/functions.php';
	
	$db = connectDb();

	if(isset($_GET['id'])) {
		$id = (int) $_GET['id'];
	}

	$sql = "SELECT id, street, address FROM addresses WHERE id != $id";

	$result = mysqli_query($db, $sql);

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
				

				<table class="table table-striped table-dark" id="addresses">
					<thead>
						<tr>
							<th scope="col">Distance < 5 Km</th>
							<th scope="col">Distance From 5 Km to 30 Km</th>
							<th scope="col">Distance more than 30 Km</th>
						</tr>
					</thead>
					<tbody>

					<?php if(isset($result)): ?>
						<?php while($row = mysqli_fetch_assoc($result)): ?>
							<tr>
								<td>
									<?php if (getDistance($id,$row['id']) < 5): ?>
										<?php echo $row['street'] ." ". $row['address']?>
										(<?= getDistance($id,$row['id']); ?> km)
									<?php endif ?>
								</td>
								<td>
									<?php if (getDistance($id,$row['id']) > 5 && getDistance($id,$row['id']) < 10): ?>
										<?php echo $row['street'] ." ". $row['address']?>
										(<?= getDistance($id,$row['id']); ?> km)
									<?php endif ?>
								</td>
								<td>
									<?php if (getDistance($id,$row['id']) > 10): ?>
										<?php echo $row['street'] ." ". $row['address']?>
										(<?= getDistance($id,$row['id']); ?> km)
									<?php endif ?>
								</td>
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
		    $('td:empty').each(function(i){
		    	console.log($('td'))
			 $(this).hide().parents('table').find('th:nth-child('+(i+1)+')').hide();
			});
		});
	</script>

</body>
</html>