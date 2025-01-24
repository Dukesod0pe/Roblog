<?php
// Step 1: Start the session to retrieve the logged-in user's ID
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: mainPage(Before).php");
    exit();
} else {
    $uid = $_SESSION["user_id"];
    $username = $_SESSION["uname_T"];
    $avatar = $_SESSION["pfp_T"];
}

try {
    $db = new PDO("mysql:host=localhost; dbname=tdl478", "tdl478", "5652702UofRme?");
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("PDO Connection: " . $e->getMessage() . "\n<br />");
}

$errors = array();
$blog_content = "";

// Step 3: Check if Form is Submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Step 4: Fetch and Sanitize Form Data
    $blog_content = htmlspecialchars(trim($_POST["blog_content"]));
    
    $featured_image = NULL;

    // Handle image upload
    if (!empty($_FILES["featured_image"]["name"])) {
        $target_dir = "uploads/";
        $uploadOk = TRUE;
        $filename = pathinfo($_FILES["featured_image"]["name"], PATHINFO_FILENAME);
        $imageFileType = strtolower(pathinfo($_FILES["featured_image"]["name"],PATHINFO_EXTENSION));
        $featured_image = $target_dir . $filename . "." . $imageFileType;

        if (file_exists($featured_image)) {
            $errors["featured_image"] = "Sorry, file already exists. ";
            $uploadOk = FALSE;
        }

        if ($_FILES["featured_image"]["size"] > 1000000) {
            $errors["featured_image"] = "File is too large. Maximum 1MB. ";
            $uploadOk = FALSE;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $errors["featured_image"] = "Bad image type. Only JPG, JPEG, PNG & GIF files are allowed. ";
            $uploadOk = FALSE;
        }

        if ($uploadOk) {
            
            $fileStatus = move_uploaded_file($_FILES["featured_image"]["tmp_name"], $featured_image);

            if (!$fileStatus) {
                $errors["Server Error"] = "There was an error moving your target file.";
                $uploadOK = FALSE;
            } else {
                echo "Your image was uploaded successfully! \n<br />";
            }
        }

        if (!empty($errors)) {
            foreach($errors as $type => $message) {
                print("$message \n<br />");
            }
        }
    }
    

    if (!empty($blog_content && empty($errors))) {
        $query = "INSERT INTO Blogs (user_id, blog_content, featured_image, date_time) VALUES ($uid, '$blog_content', '$featured_image', NOW())";
        $result = $db->exec($query);
    
        if ($result) {
            echo "Blog post saved successfully!";
        }
        
    } else if (empty($blog_content)) {
        echo "Blog post cannot be empty.";
    }
    
    // Step 6: Close the Statement and Connection
    $result = NULL;
    $db = NULL;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roblog Blog Creation Page</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="js/eventHandlers.js"></script>
</head>

<body>
    <div class="Logo">
        <a href="mainPage(After).php"><img class="Roblog" src="img/Logo.png" alt="Roblog"></a>

        <a href="logout.php">
            <button class="LogoutButton">Log Out</button>
        </a>
    </div>

    <div class="Page_D">
        <div class="Leftside_D">
            <img class="profile-pic" src="<?= $avatar ?>" alt="avatar">

            <div>
                <h2><b><?= $username ?></b></h2>
            </div>

            <div class="CreateSidebar_D">
                <a href="blogCreation.php">
                    <button>Create</button>
                </a>
            </div>

            <div class="ManagementSidebar_D">
                <a href="blogManagement.php">
                    <button>Blog Management</button>
                </a>
            </div>

            <div class="DraftSidebar_D">
                <a href="">
                    <button>Draft</button>
                </a>
            </div>

            <div class="ProfileSidebar_D">
                <a href="">
                    <button>Profile</button>
                </a>
            </div>
        </div>

        <div class="Rightside_D">
            <div class="CreateSpace_D">
                <form action="" method="post" class="admin-form" enctype="multipart/form-data">
                    <img src="<?= $avatar ?>" alt="avatar">
                    <h2><b><?= $username ?></b></h2>

                    <div>
                        <textarea type="text" class="userInput_D" id="blogInput" name="blog_content"><?= $blog_content ?></textarea>
                        <div id="blogCounter" class="counter"></div>
                    </div>

                    <input type="#" id="uploadFile"  hidden />
                    <label class="fileUpload_D" for="uploadFile">
                        <!-- <ion-icon name="folder-outline" class="folder_pic"></ion-icon> -->
                        <img src="img/file.png" alt="fileIcon">
                    </label>

                    <input type="file" id="featured_image" name="featured_image" hidden  />
                    <label for="featured_image" class="imageUpload_D">
                        <img src="img/img.png" alt="imageIcon">
                    </label>

                    <input type="#" id="uploadMusic" hidden />
                    <label for="uploadMusic" class="musicUpload_D">
                        <img src="img/music.png" alt="musicIcon">
                    </label>

                    <input type="#" id="uploadLocation" hidden />
                    <label for="uploadLocation" class="locationUpload_D">
                        <img src="img/location.png" alt="locationIcon">
                    </label>
                    
                    </br>
                    </br>
                    </br>

                    <div class="textFile_D">
                        <p>Add File</p>
                    </div>

                    <div class="textImg_D">
                        <p>Add Picture</p>
                    </div>

                    <div class="textMusic_D">
                        <p>Add Music</p>
                    </div>

                    <div class="textLocation_D">
                        <p>Add Location</p>
                    </div>

                    </br>
                    </br>
                    </br>

                    <input type="submit" value="Draft" class="DraftButton_D">
                    <input type="submit" value="Post" class="PostButton_D">
                </form>
            </div>
        </div>
    </div>
    <script src="js/eventRegisterBlogCreation.js"></script>
</body>

</html>