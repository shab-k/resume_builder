<?php

include('config/db_connect.php');

$profile_photo = $full_name = $email = $phone = $social_account = $skills = $user_profile = $education = $experience = '';
$errors = array('profile_photo' => '', 'full_name' => '', 'email' => '', 'phone' => '', 'social_account' => '', 'skills' => '', 'user_profile' => '', 'education' => '', 'experience' => '');
// form validation
if (isset($_POST['submit'])) {
    //Photo upload
    $imgFile = $_FILES['user_image']['name'];
    $fileTmpName = $_FILES['user_image']['tmp_name'];
    $imgSize = $_FILES['user_image']['size'];

    //check profile photo
    if (empty($imgFile)) {
        $errors['profile_photo'] = 'Photo is required <br />';
    } else {
        $upload_dir = 'uploads/';
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));
        $allowed_extensions = array('jpg', 'jpeg', 'png');
        // rename uploading image
        $profile_photo = rand(1000, 1000000) . "." . $imgExt;

        if (in_array($imgExt, $allowed_extensions)) {

            if ($imgSize < 5000000) {
                move_uploaded_file($fileTmpName, $upload_dir . $profile_photo);
            } else {
                // echo 'your file is too big!';
                $errors['profile_photo'] = 'Your file is too big!<br />';
            }
        } else {
            // echo 'you can not upload photos of this type!';
            $errors['profile_photo'] = 'Only JPG, JPEG & PNG files are allowed.<br />';
        }
    }

    // check full_name
    if (empty($_POST['full_name'])) {
        $errors['full_name'] = 'Full Name is required <br />';
    } else {
        $full_name = $_POST['full_name'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $full_name)) {
            $errors['full_name'] = 'Fullname must be in letters & spaces only';
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
        if (ctype_digit($phone) && strlen($phone) == 10) {
            $phone = substr($phone, 0, 3) . '-' .
                substr($phone, 3, 3) . '-' .
                substr($phone, 6);
        }
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

        // if (!preg_match('', $skills)) {
        //     $errors['skills'] =  'Each paragraph should start with a hyphen!';
        // }

        // $msg = "<p>" . preg_replace('#([\\r\]\\s*?[\\r\]){2,}#', '</p>$0<p>', htmlspecialchars(strip_tags(stripslashes($message['Msg'])))) . "</p>";
    }
    // check user_profile
    if (empty($_POST['user_profile'])) {
        $errors['user_profile'] =  'Profile text is required <br />';
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

    if (!array_filter($errors)) {
        // create sql
        $sql = "INSERT INTO resumes(profile_photo, full_name, email, phone, social_account, skills, user_profile, education, experience ) VALUES(:profile_photo, :full_name, :email, :phone, :social_account, :skills, :user_profile, :education, :experience)";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([':profile_photo' => $profile_photo, ':full_name' => $full_name, ':email' => $email, ':phone' => $phone, ':social_account' => $social_account, ':skills' => $skills, ':user_profile' => $user_profile, ':education' => $education, ':experience' => $experience])) {

            header('Location: index.php');
        } else {
            echo 'Error while inserting.';
        }
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
            <label for="photo"></label>
            <input class="nano" type="file" name="user_image" value="<?php echo htmlspecialchars($profile_photo) ?>">
            <div class="error-message"><?php echo $errors['profile_photo']; ?></div>

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
            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone) ?>">
            <!-- pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" -->
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