<?php
session_start();
require_once("database.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: mainPage(Before).php");
    exit();
} else {
    $uid = $_SESSION["user_id"];
    $username = $_SESSION["uname_T"];
    $avatar = $_SESSION["pfp_T"];
}

try {
    $db = new PDO($attr, $db_user, $db_pwd, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

$query = "SELECT Users.username, Users.avatar,
Blogs.blog_id, SUBSTRING_INDEX(Blogs.blog_content, ' ', 3) AS blog_content_preview, Blogs.date_time, Blogs.featured_image,
COUNT(Comments.comment_id) AS comment_count
FROM Blogs 
INNER JOIN Users 
ON Blogs.user_id = Users.user_id
LEFT JOIN Comments 
ON Blogs.blog_id = Comments.blog_id
GROUP BY 
Blogs.blog_id, 
Users.username, 
Users.avatar, 
Blogs.date_time, 
Blogs.featured_image
ORDER BY Blogs.date_time DESC 
LIMIT 20";

$result = $db->query($query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roblog Main Page - After Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
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
            <?php
                while($row = $result->fetch()) {
                    
            ?>
            <div id="blog">
                <a href="blogDetails.php?blog_id=<?= $row['blog_id']?>">
                    <button>
                        <img class="avatar" src="<?= $row['avatar'] ?>" alt="avatar">

                        <div>
                            <h2 class="name"><?= $row['username'] ?></h2>
                        </div>

                        <div>
                            <p><?= $row['date_time'] ?></p>
                        </div>

                        </br>

                        <div class="image_D ">
                            <img src="<?= $row['featured_image'] ?>" alt="image">
                        </div>

                        </br>

                        <h3 class="title_D"><?= $row['blog_content_preview'] ?>...</h3>

                        <div class="content_D">
                            <p>Total Comments = <?= $row['comment_count'] ?></p>
                        </div>
                    </button>
                </a>
            </div>

            <?php
                }
                $result = null;
                $db = null;
            ?>
        </div>
    </div>
</body>

</html>