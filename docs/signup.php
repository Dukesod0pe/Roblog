<?php
require_once("database.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); //encodes
    return $data;
}

$errors = array();
$firstName = "";
$lastName = "";
$dob = "";
$email = "";
$username = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = test_input($_POST["fname_T"]);
    $lastName = test_input($_POST["lname_T"]);
    $dob = test_input($_POST["dob_T"]);
    $email = test_input($_POST["email_T"]);
    $username = test_input($_POST["uname_T"]);
    $password = test_input($_POST["pwd_T"]);

    $nameRegex = "/^[a-zA-Z]+$/";
    $dobRegex = "/^\d{4}[-]\d{2}[-]\d{2}$/";
    $emailRegex = "/^[a-zA-Z]{3}\d{3}@uregina.ca$/";
    $unameRegex = "/^[a-zA-Z0-9_]+$/";
    $passwordRegex = "/^\S+[^a-zA-Z ]+\S+$/";
    

    if (!preg_match($nameRegex, $firstName)) {
        $errors["fname_T"] = "Invalid First Name";
    }
    if (!preg_match($nameRegex, $lastName)) {
        $errors["lname_T"] = "Invalid Last Name";
    }
    if (!preg_match($dobRegex, $dob)) {
        $errors["dob_T"] = "Invalid Date of Birth";
    }
    if (!preg_match($emailRegex, $email)) {
        $errors["email_T"] = "Invalid Email";
    }
    if (!preg_match($unameRegex, $username)) {
        $errors["uname_T"] = "Invalid Username";
    }
    if (!preg_match($passwordRegex, $password)) {
        $errors["pwd_T"] = "Invalid Password";
    }

    $target_file = "";

    try {
        $db = new PDO("mysql:host=localhost; dbname=tdl478", "tdl478", "5652702UofRme?");
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("PDO Connection: " . $e->getMessage() . "\n<br />");
    }

    $query = "SELECT username FROM Users WHERE username='$username'";
    $result = $db->query($query);
    $match = $result->fetch();

    if ($match) {
        $errors["Account Taken"] = "A user with that username already exists.";
    }

    if (empty($errors)) {
        $query = "INSERT INTO Users (first_name, last_name, dob, email, username, password, avatar) 
        VALUES ('$firstName', '$lastName', '$dob', '$email', '$username', '$password', 'avatar_stub')";
        $result = $db->exec($query);
    }

    if (!$result) {
        $errors["Database Error:"] = "Failed to insert user";
    } else {
        $target_dir = "uploads/";
        $uploadOk = TRUE;
        $imageFileType = strtolower(pathinfo($_FILES["pfp_T"]["name"],PATHINFO_EXTENSION));
        $uid = $db->lastInsertId();
        $target_file = $target_dir . $uid . "." . $imageFileType;
    }

    if (file_exists($target_file)) {
        $errors["pfp_T"] = "Sorry, file already exists. ";
        $uploadOk = FALSE;
    }
        
    if ($_FILES["pfp_T"]["size"] > 1000000) {
        $errors["pfp_T"] = "File is too large. Maximum 1MB. ";
        $uploadOk = FALSE;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $errors["pfp_T"] = "Bad image type. Only JPG, JPEG, PNG & GIF files are allowed. ";
        $uploadOk = FALSE;
    }
                    
    if ($uploadOk) {
        
        $fileStatus = move_uploaded_file($_FILES["pfp_T"]["tmp_name"], $target_file);

        if (!$fileStatus) {
            $errors["Server Error"] = "There was an error moving your avatar file.";
            $uploadOK = FALSE;
        }
    }
    
    if (!$uploadOk)
    {
        $query = "DELETE FROM Users WHERE user_id=$uid";
        $result = $db->exec($query);
        if (!$result) {
            $errors["Database Error"] = "could not delete user when avatar upload failed";
        }
        $db = null;
    } else {
        $query = "UPDATE Users SET avatar='$target_file' WHERE user_id=$uid";
        $result = $db->exec($query);
        if (!$result) {
            $errors["Database Error:"] = "could not update avatar";
        } else {
            $db = NULL;
            header("Location: mainPage(Before).php");
            exit();

        }
    } 

    if (!empty($errors)) {
        foreach($errors as $type => $message) {
            print("$type: $message \n<br />");
        }
    }
    
}
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>Roblog Signup Page</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <meta name="referrer" content="unsafe-url">
    <meta charset="utf-8" />
    <script src="js/eventHandlers.js"></script>
</head>

<body>
    <div class="container_T">
        <div class="header_T">
            <a  href="mainPage(Before).html"><img class="Roblog" src="img/Logo.png" alt="Roblog"></a>
            
            <div class="login-note_T">
                <p>
                    Already have an account? 
                    <a href="mainPage(Before).php"> <!--dont forget to change these values-->
                    <input type="button" id="loginButton_T" value="Login" />
                    </a>
                </p> 
            </div>
        </div>

        <div class="signup-center_T">
            <h1>Signup</h1>
            <form class="signup-form_T" action="" method="post" enctype="multipart/form-data">
                <div class="form-input-grid_T">
                    <label for="fname_T">First Name:</label>
                    <input type="text" id="fname_T" name="fname_T" value="<?= $firstName ?>"/>
                    &nbsp; 
                    <div id="error-text-fname_T" class="error-text-hidden <?= isset($errors['fname_T'])?'':'hidden' ?>">
                        First name invalid - must only consist of letters
                    </div> 

                    <label for="lname_T">Last Name:</label>
                    <input type="text" id="lname_T" name="lname_T" value="<?= $lastName ?>" />
                    &nbsp; 
                    <div id="error-text-lname_T" class="error-text-hidden <?= isset($errors['lname_T'])?'':'hidden' ?>">
                        Last name invalid - must only consist of letters
                    </div> 

                    <label for="dob_T">Date of Birth:</label>
                    <input type="date" name="dob_T" id="dob_T" value="<?= $dob ?>" />
                    &nbsp; 
                    <div id="error-text-dob_T" class="error-text-hidden <?= isset($errors['dob_T'])?'':'hidden' ?>">
                        Date of Birth invalid - must not be empty
                    </div> 

                    <label for="email_T">Email:</label>
                    <input type="text" name="email_T" id="email_T" value="<?= $email ?>" />
                    &nbsp; 
                    <div id="error-text-email_T" class="error-text-hidden <?= isset($errors['email_T'])?'':'hidden' ?>">
                        Email invalid - must be a valid uregina email
                    </div> 

                    <label for="uname_T">Username:</label>
                    <input type="text" name="uname_T" id="uname_T" value="<?= $username ?>" />
                    &nbsp; 
                    <div id="error-text-uname_T" class="error-text-hidden <?= isset($errors['uname_T'])?'':'hidden' ?>">
                        Username invalid - must have no spaces or other non-word characters
                    </div> 

                    <label for="pwd_T">Password:</label>
                    <input type="password" name="pwd_T" id="pwd_T" value="<?= $password ?>" />
                    &nbsp; 
                    <div id="error-text-pwd_T" class="error-text-hidden <?= isset($errors['pwd_T'])?'':'hidden' ?>">
                        Password invalid - must be 6 characters or longer, have no spaces, and have at least one non-letter character
                    </div> 

                    <label for="confirmpwd_T">Confirm Password:</label>
                    <input type="password" name="confirmpwd_T" id="confirmpwd_T" />
                    &nbsp; 
                    <div id="error-text-confirmpwd_T" class="error-text-hidden">
                        Confirm Password invalid - the password you re-entered does not match your current password
                    </div> 

                    <label for="pfp_T">Choose Avatar:</label>
                    <input type="file" name="pfp_T" id="pfp_T" accept="images/*" />
                    <div id="error-text-pfp_T" class="error-text-hidden <?= isset($errors['pfp_T'])?'':'hidden' ?>">
                        Avatar invalid - must not be empty
                    </div> 
                    
                </div>
                <input type="submit" id="submitButton_T" value="Sign up"  />

            </form>
        </div>

    </div>
    <script src="js/eventRegisterSignup.js"></script>
</body>

</html>