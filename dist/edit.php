<?php
//  error_reporting( ~E_NOTICE ); //???
include('config/db_connect.php');
// $profile_photo = $full_name = $email = $phone = $social_account = $skills = $user_profile = $education = $experience = '';
// check GET request id param
if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = $_GET['id'];
    $sql = 'SELECT * FROM resumes WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $resume = $stmt->fetch();
    // $resume = $stmt->fetch(PDO::FETCH_ASSOC);
    // extract($resume);
} else {
    header("Location: index.php");
}

if (isset($_POST['submit'])) {

    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $social_account = $_POST['social_account'];
    $skills = $_POST['skills'];
    $user_profile = $_POST['user_profile'];
    $education = $_POST['education'];
    $experience = $_POST['experience'];
    //photo edit
    $imgFile = $_FILES['user_image']['name'];
    $fileTmpName = $_FILES['user_image']['tmp_name'];
    $imgSize = $_FILES['user_image']['size'];
    //check profile photo
    if (empty($imgFile)) {
        // if no image selected the old image remain as it is.
        $profile_photo = $resume->profile_photo; // old image from database
    } else {
        $upload_dir = 'uploads/';
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));
        $allowed_extensions = array('jpg', 'jpeg', 'png');
        // rename uploading image
        $profile_photo = rand(1000, 1000000) . "." . $imgExt;

        if (in_array($imgExt, $allowed_extensions)) {
            
            if ($imgSize < 5000000) {
                unlink($upload_dir . $resume->profile_photo);
                move_uploaded_file($fileTmpName, $upload_dir.$profile_photo);
            } else {
                // echo 'your file is too big!';
                $errors['profile_photo'] = 'Your file is too big! it should be less then 5MB.<br />';
            }
        } else {
            // echo 'Only JPG, JPEG & PNG files are allowed.';
            $errors['profile_photo'] = 'Only JPG, JPEG & PNG files are allowed.<br />';
        }
    }
  
    $sql = "UPDATE resumes SET profile_photo=:profile_photo, full_name=:full_name, email=:email, phone=:phone, social_account=:social_account, skills=:skills, user_profile=:user_profile, education=:education, experience=:experience WHERE id=:id";
    $stmt = $pdo->prepare($sql);

    // $stmt->bindParam(':profile_photo', $profile_photo);
    // $stmt->bindParam(':uname', $username);
    // $stmt->bindParam(':ujob', $userjob);
    // $stmt->bindParam(':upic', $userpic);
    // $stmt->bindParam(':uid', $id);

   
    if ($stmt->execute([':id' => $id, ':profile_photo' => $profile_photo, ':full_name' => $full_name, ':email' => $email, ':phone' => $phone, ':social_account' => $social_account, ':skills' => $skills, ':user_profile' => $user_profile, ':education' => $education, ':experience' => $experience])) {
        header('Location: index.php');
    }
    // if ($stmt->execute(['id' => $id])) {
    //     header('Location: index.php');
    // }


}

?>

<!DOCTYPE html>
<html>
<?php include('templates/header.php'); ?>

<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
    <div class="wrapper">
        <section class="grid-area full_name">
            <h4>Full Name:</h4>
            <input type="text" name="full_name" value="<?= $resume->full_name ?>">
        </section>
        <section class="grid-area photo">
            <img src="uploads/<?= $resume->profile_photo ?>" class="resume">
            <label for="photo"></label>
            <!-- <input type="file" name="file" accept="image/*" value="<?php echo htmlspecialchars($profile_photo) ?>"> -->
            <input type="file" name="user_image" accept="image/*" value="uploads/<?= $resume->profile_photo ?>">
        </section>
        <section class="grid-area contact">
            <h4>Contact</h4>
            <hr>

            <i class="fas fa-envelope"></i>
            <input type="text" name="email" value="<?= $resume->email ?>">


            <i class="fas fa-phone-square"></i>
            <input type="tel" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" value="<?= $resume->phone ?>">



            <i class="fab fa-linkedin"></i>
            <input type="text" name="social_account" value="<?= $resume->social_account ?>">

        </section>
        <section class="grid-area skills">
            <h4>Skills</h4>
            <hr>

            <!-- <input type="text" full_name="skills"> -->
            <textarea name="skills" id="skills" cols="55" rows="10"><?= $resume->skills ?></textarea>

        </section>
        <section class="grid-area profile">
            <h4>Profile</h4>
            <hr>

            <textarea name="user_profile" id="user_profile" cols="25" rows="15"><?= $resume->user_profile ?></textarea>
        </section>
        <section class="grid-area main">
            <h4>Education</h4>
            <hr>

            <textarea name="education" id="education" cols="55" rows="10"><?= $resume->education ?></textarea>

            <h4>Experience</h4>
            <hr>

            <textarea name="experience" id="experience" cols="55" rows="10"><?= $resume->experience ?></textarea>
        </section>
    </div>

    <!-- EDIT FORM -->
    <form method="POST" class="submit">
        <input type="hidden" name="id" value="<?= $resume->id ?>">
        <input class="btn btn--sm" type="submit" name="submit" value="Submit" class="btn btn--sm">
    </form>
</form>


<?php include('templates/footer.php'); ?>

</html>