<?php

require_once("database.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); //encodes
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = array();
    $dataOK = TRUE;

    $email = test_input($_POST["email_T"]);
    $emailRegex = "/^[a-zA-Z]{3}\d{3}@uregina.ca$/";
    if (!preg_match($emailRegex, $email)) {
        $errors["email_T"] = "Invalid Email";
        $dataOK = FALSE;
    }

    $password = test_input($_POST["password_T"]);
    $passwordRegex = "/^\S+[^a-zA-Z ]+\S+$/";
    if (!preg_match($passwordRegex, $password)) {
        $errors["password_T"] = "Invalid Password";
        $dataOK = FALSE;
    }
    
    if ($dataOK) {
        try {
            $db = new PDO("mysql:host=localhost; dbname=tdl478", "tdl478", "5652702UofRme?");
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("PDO Connection: " . $e->getMessage() . "\n<br />");
        }
        

        $query = "SELECT user_id, email, username, password, avatar FROM Users WHERE email='$email' AND password='$password'";
        $result = $db->query($query);

        if (!$result) {
            $errors["Database Error"] = "Could not retrieve user information";
        } elseif ($row = $result->fetch()) {
            session_start();

            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["uname_T"] = $row["username"];
            $_SESSION["pfp_T"] = $row["avatar"];

            $db = null;
            header("Location: mainPage(After).php");
            exit();
        } else {
            $errors["Login Failed"] = "That username/password combination does not exist.";
        }

        $db = null;

    } else {
        $errors['Login Failed'] = "You entered invalid data while logging in.";
    }

    if(!empty($errors)){
        foreach($errors as $type => $message) {
            echo "$type: $message <br />\n";
        }
        
    }
    
}

try {
    $db = new PDO("mysql:host=localhost; dbname=tdl478", "tdl478", "5652702UofRme?");
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("PDO Connection: " . $e->getMessage() . "\n<br />");
}

$query = "SELECT Users.username, Users.avatar,
SUBSTRING_INDEX(Blogs.blog_content, ' ', 3) AS blog_content_preview, Blogs.date_time
FROM Blogs 
INNER JOIN Users 
ON Blogs.user_id = Users.user_id 
ORDER BY Blogs.date_time DESC 
LIMIT 5";

$result = $db->query($query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roblog Main Page - Before Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="js/eventHandlers.js"></script>
</head>

<body>
    <div class="TopBar_D">
        <h1>Welcome back!</h1>
    </div>

    <div class="TheBottomPage_D">
        <div class="SideBar_D">
            <h3>Recent Posts</h3>

            <?php
                while($row = $result->fetch()) {
            ?>
            <div class="Post_D">
                <img src="img/blankAvatar.jpg" alt="avatar">
                <h4><?= $row['username'] ?></h4>
                <p><?= $row['date_time'] ?></p>
                <h6><?= $row['blog_content_preview'] ?>...</h6>
            </div>
            <?php
                }
                $result = null;
                $db = null;
            ?>
        </div>

        <div class="Login_D">
            <img src="img/Logo.png" alt="logo">
            <form action="" method="post" id="loginform_T" >
                <div class="form-input-grid_D">
                    <label for="email_T">Email:</label>
                    <input type="text" id="email_T" name="email_T" />
                    &nbsp;
                    <div id="error-text-email_T" class="error-text-hidden">
                        Email is invalid - must be a valid uregina email
                    </div>

                    <label for="password_T">Password:</label>
                    <input type="password" id="password_T" name="password_T" />
                    &nbsp;
                    <div id="error-text-password_T" class="error-text-hidden">
                        Password is invalid - must be 6 characters or longer, and have no spaces
                    </div>
                </div>

                <input type="submit" id="submitButton_D" value="Login" />
                <p>Don't have an account?
                    <a href="signup.php">Sign Up</a>
                </p>
            </form>    
        </div>
        
    </div>
    <script src="js/eventRegisterLogin.js"></script>
</body>

</html>