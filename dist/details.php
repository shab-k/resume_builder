<?php

include('config/db_connect.php');

if (isset($_POST['delete'])) {

    $id_to_delete = $_POST['id_to_delete'];
    $sql = 'DELETE FROM resumes WHERE id=:id_to_delete';
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([':id_to_delete' => $id_to_delete])) {
        header('Location: index.php');
    }
}

// check GET request id param
if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $sql = 'SELECT * FROM resumes WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $resume = $stmt->fetch();
}

?>

<!DOCTYPE html>
<html>
<?php include('templates/header.php'); ?>

<div class="wrapper">
    <?php if ($resume) : ?>
        <section class="grid-area full_name">
            <h4>Full Name:</h4>
            <div><?= $resume->full_name ?></div>
        </section>
        <section class="grid-area photo">
            <img src="./images/8biticon.jpg" alt="">
        </section>
        <section class="grid-area contact">
            <h4>Contact</h4>
            <hr>
            <i class="fas fa-envelope"></i>
            <div><?= $resume->email ?></div>

            <i class="fas fa-phone-square"></i>
            <div><?= $resume->phone ?></div>

            <i class="fab fa-linkedin"></i>
            <div><?= $resume->social_account ?></div>
        </section>
        <section class="grid-area skills">
            <h4>Skills</h4>
            <hr>
            <div><?= $resume->skills ?></div>
        </section>
        <section class="grid-area profile">
            <h4>Profile</h4>
            <hr>
            <div><?= $resume->user_profile ?></div>
        </section>
        <section class="grid-area main">
            <h4>Education</h4>
            <hr>
            <div><?= $resume->education ?></div>
            <h4>Experience</h4>
            <hr>
            <div><?= $resume->experience ?></div>
        </section>

    <?php else : ?>
        <h5>No such resume exists!</h5>
    <?php endif ?>
</div>
<p class="resume-date">Created At: <?= $resume->created_at ?></p>
<!-- DELETE FORM -->
<form action="details.php" method="POST" class="submit">
    <input type="hidden" name="id_to_delete" value="<?= $resume->id ?>">
    <input class="btn btn--sm" type="submit" name="delete" value="Delete" class="btn btn--sm">
</form>

<a class="btn btn--sm" href="edit.php?id=<?= $resume->id ?>">Edit</a>


<?php include('templates/footer.php'); ?>

</html>