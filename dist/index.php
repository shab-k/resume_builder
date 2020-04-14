<?php
// $profile_photo = $full_name = $email = $phone = $social_account = $skills = $user_profile = $education = $experience = '';
include('config/db_connect.php');
//--------------------------pdo ----------------------
//   $sql = 'SELECT * FROM resumes WHERE full_name = ? && is_published = ? LIMIT ?';
$sql = 'SELECT * FROM resumes ORDER BY created_at DESC';
$stmt = $pdo->prepare($sql);
//   $stmt->execute([$full_name, $created_at]);
$stmt->execute();
$resumes = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html>
<!-- Photos by 8biticon.com -->
<?php include('templates/header.php'); ?>

<h4 class="cards-title">Resumes!</h4>

<div class="card-container">
	<?php foreach ($resumes as $resume) { ?>

		<div class="card">

			<div class="grid-area card-image">
				<!-- <img src="images/resume.jpg" class="resume"> -->
				<!-- <img src="uploads/<?= $resume->profile_photo ?>" class="resume"> -->
				<img src="uploads/<?= $resume->profile_photo ?>" class="resume">

			</div>

			<div class="grid-area card-content">
				<!-- <h6></h6> -->
				<h6><?= $resume->full_name ?></h6>
				<div>
					<h6 class="resume-date">Created At:</h6>
					<p><?= $resume->created_at ?></p>
				</div>
			</div>

			<div class="grid-area card-action">
				<a href="details.php?id=<?= $resume->id ?>">Details<i class="fas fa-long-arrow-alt-right"></i></a>
			</div>
		</div>

	<?php } ?>
</div>

<?php include('templates/footer.php'); ?>

</html>