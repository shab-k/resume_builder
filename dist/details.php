<?php

include('config/db_connect.php');

if (isset($_POST['delete'])) {

    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    $sql = "DELETE FROM resumes WHERE id = $id_to_delete";

    if (mysqli_query($conn, $sql)) {
        header('Location: index.php');
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }
}

// check GET request id param
if (isset($_GET['id'])) {

    // escape sql chars
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // make sql
    $sql = "SELECT * FROM resumes WHERE id = $id";

    // get the query result
    $result = mysqli_query($conn, $sql);

    // fetch result in array format
    $resume = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html>
<?php include('templates/header.php'); ?>

<div class="wrapper">
    <?php if ($resume) : ?>
        <section class="grid-area full_name">
            <h4>Full Name:</h4>
            <div><?php echo $resume['full_name']; ?></div>
        </section>
        <section class="grid-area photo">
            <img src="./images/8biticon.jpg" alt="">
        </section>
        <section class="grid-area contact">
            <h4>Contact</h4>
            <hr>
            <i class="fas fa-envelope"></i>
            <div><?php echo $resume['email']; ?></div>

            <i class="fas fa-phone-square"></i>
            <div><?php echo $resume['phone']; ?></div>

            <i class="fab fa-linkedin"></i>
            <div><?php echo $resume['social_account']; ?></div>
        </section>
        <section class="grid-area skills">
            <h4>Skills</h4>
            <hr>
            <div><?php echo $resume['skills']; ?></div>
        </section>
        <section class="grid-area profile">
            <h4>Profile</h4>
            <hr>
            <div><?php echo $resume['user_profile']; ?></div>
        </section>
        <section class="grid-area main">
            <h4>Education</h4>
            <hr>
            <div><?php echo $resume['education']; ?></div>
            <h4>Experience</h4>
            <hr>
            <div><?php echo $resume['experience']; ?></div>
        </section>

    <?php else : ?>
        <h5>No such resume exists!</h5>
    <?php endif ?>
</div>
<p class="resume-date">Created At: <?php echo date($resume['created_at']); ?></p>
<!-- DELETE FORM -->
<form action="details.php" method="POST" class="submit">
    <input type="hidden" name="id_to_delete" value="<?php echo $resume['id']; ?>">
    <input class="btn btn--sm" type="submit" name="delete" value="Delete" class="btn btn--sm">
</form>

<?php include('templates/footer.php'); ?>

</html>