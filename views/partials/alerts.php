<?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
	<div class="alert alert-danger" role="alert">
		<ul>
		<?php foreach ($_SESSION['errors'] as $error): ?>
			<li><?=$error?></li>
		<?php endforeach ?>
		</ul>
	</div>
<?php endif ?>


<?php if (isset($_SESSION['success']) && !empty($_SESSION['success'])): ?>
	<div class="alert alert-success" role="alert">
		<ul>
		<?php foreach ($_SESSION['success'] as $message): ?>
			<li><?=$message?></li>
		<?php endforeach ?>
		</ul>
	</div>
<?php endif ?>
<?php unset($_SESSION['errors']);?>
<?php unset($_SESSION['success']);?>