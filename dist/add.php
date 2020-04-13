<?php

include('config/db_connect.php');

$full_name = $email = $phone = $social_account = $skills = $user_profile = $education = $experience = '';
$errors = array('full_name' => '', 'email' => '', 'phone' => '', 'social_account' => '', 'skills' => '', 'user_profile' => '', 'education' => '', 'experience' => '');
// form validation
if (isset($_POST['submit'])) {
    //Photo upload
    // $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];

    // $fileErr = $_FILES['file']['err'];
    // $fileType = $_FILES['file']['type'];

    // $fileExt = explode('.', $fileName);
    $upload_dir = 'uploads/';
    $fileActualExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed_extensions = array('jpg', 'jpeg', 'png');
    $profile_photo = rand(1000, 1000000) . "." . $fileActualExt;
    move_uploaded_file($fileTmpName, $upload_dir . $profile_photo);
    //check photo
    // if (in_array($fileActualExt, $allowed)) {
    //     if ($fileErr === 0) {
    //         if ($fileSize < 1000000) {
    //             $fileNameNew = uniqid('', true) . "." . $fileActualExt;
    //             $fileDestination = 'uploads/' . $fileNameNew;
    //             move_uploaded_file($fileTmpName, $fileDestination);
    //         } else {
    //             echo 'your file is too big!';
    //         }
    //     } else {
    //         echo 'There is an error uploading your photo!';
    //     }
    // } else {
    //     echo 'you can not upload photos of this type!';
    // }

    // check full_name
    if (empty($_POST['full_name'])) {
        $errors['full_name'] = 'Full Name is required <br />';
    } else {
        $full_name = $_POST['full_name'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $full_name)) {
            $errors['full_name'] = 'full_name must be letters and spaces only';
        }
    }

    // check email
    if (empty($_POST['email'])) {
        $errors['email'] = 'An email is required <br />';
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email must be a valid email address';
        }
    }
    // check phone
    if (empty($_POST['phone'])) {
        $errors['phone'] = 'Phone number is required <br />';
    } else {
        $phone = $_POST['phone'];
        // if (!preg_match('/^-(\s(.*+))*\n-\s(.*)*$/', $phone)) {  //////////////change it!!!!
        //     $errors['phone'] =  'Phone number ....!';
        // }
    }
    // check social account
    if (empty($_POST['social_account'])) {
        $errors['social_account'] = 'A social account link is required <br />';
    } else {
        $social_account = $_POST['social_account'];
        // if (!preg_match('/^-(\s(.*+))*\n-\s(.*)*$/', $social_account)) {  //////change it!!!!
        //     $errors['social_account'] =  'blah!';
        // }
    }

    // check skills
    if (empty($_POST['skills'])) {
        $errors['skills'] =  'Skills are required <br />';
    } else {
        $skills = $_POST['skills'];
        if (!preg_match('/^-(\s(.*+))*\n-\s(.*)*$/', $skills)) {
            // if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $skills)) {

            $errors['skills'] =  'Each paragraph should start with a hyphen!';
        }
    }
    // check user_profile
    if (empty($_POST['user_profile'])) {
        $errors['user_profile'] =  'user_profile is required <br />';
    } else {
        $user_profile = $_POST['user_profile'];
        // if (!preg_match('/^[a-zA-Z\s]+$/', $user_profile)) {
        //     $errors['user_profile'] = 'profile must be in letters & spaces only!';
        // }
    }
    // check education
    if (empty($_POST['education'])) {
        $errors['education'] =  'Education is required <br />';
    } else {
        $education = $_POST['education'];
        // if (!preg_match('/^[a-zA-Z\s]+$/', $education)) {
        //     $errors['education'] = 'education must be in letters & spaces only!';
        // }
    }
    // check experience
    if (empty($_POST['experience'])) {
        $errors['experience'] =  'Experience is required <br />';
    } else {
        $experience = $_POST['experience'];
        // if (!preg_match('/^[a-zA-Z\s]+$/', $experience)) {
        //     $errors['experience'] = 'experience must be letters and spaces only';
        // }
    }

    if (array_filter($errors)) {
        echo 'errors in form';
    } else {
        // create sql
        $sql = "INSERT INTO resumes(profile_photo, full_name, email, phone, social_account, skills, user_profile, education, experience ) VALUES(:profile_photo, :full_name, :email, :phone, :social_account, :skills, :user_profile, :education, :experience)";
        $stmt = $pdo->prepare($sql);

        // echo 'Post Added';

        if ($stmt->execute([':profile_photo' => $profile_photo, ':full_name' => $full_name, ':email' => $email, ':phone' => $phone, ':social_account' => $social_account, ':skills' => $skills, ':user_profile' => $user_profile, ':education' => $education, ':experience' => $experience])) {
            // $message = 'data inserted successfully';
            header('Location: index.php');
        }
        // else {
        //     echo 'query error: ' . mysqli_error($conn);
        // }
    }
} //end POST check

?>

<!DOCTYPE html>
<html>
<?php include('templates/header.php'); ?>

<form class="" action="add.php" method="POST" enctype="multipart/form-data">
    <div class="wrapper">
        <section class="grid-area full_name">
            <h4>Full Name:</h4>
            <label for="full_name"></label>
            <input type="text" name="full_name" value="<?php echo htmlspecialchars($full_name) ?>">
            <div class="error-message"><?php echo $errors['full_name']; ?></div>
        </section>
        <section class="grid-area photo">
            <!-- <img src="./images/8biticon.jpg" alt=""> -->
            <label for="photo"></label>
            <input type="file" name="file" value="<?php echo htmlspecialchars($full_name) ?>">
        </section>
        <section class="grid-area contact">
            <h4>Contact</h4>
            <hr>
            <label for="email"></label>
            <i class="fas fa-envelope"></i>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
            <div class="error-message"><?php echo $errors['email']; ?></div>

            <label for="phone"></label>
            <i class="fas fa-phone-square"></i>
            <input type="tel" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" value="<?php echo htmlspecialchars($phone) ?>">
            <div class="error-message"><?php echo $errors['phone']; ?></div>

            <label for="social media account"></label>
            <i class="fab fa-linkedin"></i>
            <input type="text" name="social_account" value="<?php echo htmlspecialchars($social_account) ?>">
            <div class="error-message"><?php echo $errors['social_account']; ?></div>
        </section>
        <section class="grid-area skills">
            <h4>Skills</h4>
            <hr>
            <label for="skills"></label>
            <!-- <input type="text" full_name="skills"> -->
            <textarea name="skills" id="skills" cols="55" rows="10"><?php echo htmlspecialchars($skills) ?></textarea>
            <div class="error-message"><?php echo $errors['skills']; ?></div>
        </section>
        <section class="grid-area profile">
            <h4>Profile</h4>
            <hr>
            <label for="user_profile"></label>
            <textarea name="user_profile" id="user_profile" cols="25" rows="15"><?php echo htmlspecialchars($user_profile) ?></textarea>
            <div class="error-message"><?php echo $errors['user_profile']; ?></div>
        </section>
        <section class="grid-area main">
            <h4>Education</h4>
            <hr>
            <label for="education"></label>
            <textarea name="education" id="education" cols="55" rows="10"><?php echo htmlspecialchars($education) ?></textarea>
            <div class="error-message"><?php echo $errors['education']; ?></div>
            <h4>Experience</h4>
            <hr>
            <label for="experience"></label>
            <textarea name="experience" id="experience" cols="55" rows="10"><?php echo htmlspecialchars($experience) ?></textarea>
            <div class="error-message"><?php echo $errors['experience']; ?></div>
        </section>
    </div>
    <div class="submit">
        <input type="submit" name="submit" value="Submit" class="btn btn--sm">
    </div>
</form>


<?php include('templates/footer.php'); ?>

</html>