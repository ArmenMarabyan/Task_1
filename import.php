<?php
	require_once dirname(__FILE__) . '/app/db_connect.php';
	require_once dirname(__FILE__) . '/app/functions.php';

	$db = connectDb();

	if(isset($_REQUEST['submit'])) {
		if(isset($_FILES['file']['name'])) {
			importXml($_FILES['file'], $db);
		}

	}

?>

<?php require_once dirname(__FILE__) . '/views/partials/header.php'; ?>


			<div class="col-lg-12 my-3 p-3 bg-white rounded shadow-sm">

				<?php include dirname(__FILE__) . '/views/partials/alerts.php'; ?>

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

