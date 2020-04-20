<?php
// include('config/db_connect.php');
require_once('config/db_connect.php');

$sql = 'SELECT * FROM resumes ORDER BY created_at DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$resumes = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html>
<!-- Photos by 8biticon.com -->
<?php include('templates/header.php'); ?>

<h1 class="cards-title">Resumes!</h1>

<div class="card-container">
	<?php foreach ($resumes as $resume) { ?>

		<div class="card">
			<div class="grid-area card-image">
				<img src="uploads/<?= $resume->profile_photo ?>" class="resume">
			</div>

			<div class="grid-area card-content">
				<h5><?= $resume->full_name ?></h5>
				<div>
					<h6 class="nano">Created At:</h6>
					<p class="nano"><?= $resume->created_at ?></p>
				</div>
			</div>

			<div class="grid-area card-action">
				<a href="details.php?id=<?= $resume->id ?>"><span class="nano">Details</span><i class="fas fa-long-arrow-alt-right"></i></a>
			</div>
		</div>

	<?php } ?>
</div>

<?php include('templates/footer.php'); ?>

</html>