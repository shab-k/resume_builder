<?php
// $full_name = $email = $phone = $social_account = $skills = $user_profile = $education = $experience = '';
include('config/db_connect.php');
// write query for all datas
$sql = 'SELECT * FROM resumes ORDER BY created_at';
// $sql = 'SELECT full_name, email, phone, social_account, skills, user_profile, education, $experience, id FROM resumes ORDER BY created_at';

// get the result set (set of rows)
$result = mysqli_query($conn, $sql);

// fetch the resulting rows as an array
$resumes = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free the $result from memory (good practise)
mysqli_free_result($result);

// close connection
mysqli_close($conn);

// print_r($resumes);

?>

<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>

<h4 class="cards-title">Resumes!</h4>

<div class="card-container">
	<?php foreach ($resumes as $resume) { ?>
		<!-- mycard -->
		<!-- <div class="wrapper"> -->
		<div class="card">

			<div class="grid-area card-image">
				<img src="images/resume.jpg" class="resume">
			</div>

			<div class="grid-area card-content">
				<h6><?php echo htmlspecialchars($resume['full_name']); ?></h6>
				<div>
					<h6 class="resume-date">Created At:</h6>
					<p><?php echo date($resume['created_at']); ?></p>
				</div>
			</div>

			<div class="grid-area card-action">
				<a href="details.php?id=<?php echo $resume['id'] ?>">Details<i class="fas fa-long-arrow-alt-right"></i></a>
			</div>
		</div>
		<!-- </div> -->
		<!-- end mycard -->

	<?php } ?>
</div>

<?php include('templates/footer.php'); ?>

</html>