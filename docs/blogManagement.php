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

$query = "SELECT Blogs.blog_id, Blogs.user_id, Blogs.blog_content, Blogs.featured_image, Blogs.date_time, 
COUNT(Comments.comment_id) AS comment_count
FROM Blogs 
LEFT JOIN Comments ON Blogs.blog_id = Comments.blog_id
WHERE Blogs.user_id=$uid
GROUP BY Blogs.blog_id
ORDER BY date_time DESC";

$result = $db->query($query);
?>


<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>Roblog Blog Management Page</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <meta name="referrer" content="unsafe-url">
    <meta charset="utf-8" />
</head>

<body>
    <div class="container_T">
        <div class="header_T">
            <a href="mainPage(After).php"><img class="Roblog" src="img/Logo.png" alt="Roblog"></a>

            <a href="logout.php">
                <input type="button" id="logoutButton_T" value="Logout" />
            </a>
        </div>

        <div class="dashboard_T">
            
                <img class="profile-pic" src="<?= $avatar ?>" alt="avatar">
                <h2><?= $username ?></h2>
            
            

            <a href="blogCreation.php">
                <button>Create</button>
            </a>

            <a href="blogManagement.php">
                <button>Blog Management</button>
            </a>

            <a href="">
                <button>Draft</button>
            </a>

            <a href="">
                <button>Profile</button>
            </a>

        </div>

        <div class="blogManagement-center_T">
            <div class="mini-header_T">
                <h1>Blog Management</h1>
            </div>

            <?php
  
                echo '<div class="blog-list_T">';
                while($row = $result->fetch()) {

            ?> 
                <div class="blog_T">
                    <div class="content-block_T">
                        <img class="avatar" src="<?= $avatar ?>" alt="avatar">
                        <h2 class="name"><?= $username ?></h2>
                        <p><?= $row["date_time"] ?></p>
                        <p></p>
                        <a href="blogDetails.php?blog_id=<?= $row['blog_id']?>" id="viewPost_T">View My Post</a>
                        <div class="content-image_T">
                            <img id="targetImage_T" src="<?= $row["featured_image"] ?> " alt="<?= $row["featured_image"] ?>">
                        </div>
                        <div class="content-text_T">
                            <p>
                                <?= $row["blog_content"] ?>
                            </p>
                        </div>
                        

                    </div>

                    <div class="comment-block_T">
                        <div class="align-left_T">
                            <h2>Comments = <?= $row["comment_count"] ?></h2>
                        </div>
                    <?php
                        $blogId = $row['blog_id'];
                        $query2 ="SELECT Comments.comment_content, Comments.comment_username, Comments.comment_avatar, Comments.comment_date_time, 
COALESCE(SUM(Votes.up_votes), 0) AS up_votes, COALESCE(SUM(Votes.down_votes), 0) AS down_votes
FROM Comments
LEFT JOIN Votes ON Comments.comment_id = Votes.comment_id
WHERE Comments.blog_id=$blogId
GROUP BY Comments.comment_id
ORDER BY Comments.comment_date_time DESC";
                        
                        $result2 = $db->query($query2);

                        while ($row2 = $result2->fetch()) {
                    ?>
                        
                        <div class="comment_T">
                            <img class="avatar" src="<?= $row2["comment_avatar"] ?>" alt="avatar">

                            <div class="comment-header_T">
                                <h3><?= $row2["comment_username"] ?></h3>
                                <p><?= $row2["comment_date_time"] ?></p>
                            </div>

                            <div class="comment-text_T">
                                <p><?= $row2["comment_content"] ?></p>
                            </div>


                            <button><span class="vote_T"><img src="img/UPVOTE_ON.png"></span></button>
                            <div id="counter"><?= $row2['up_votes'] - $row2['down_votes'] ?></div>
                            <button><span class="vote_T"><img src="img/DOWNVOTE_ON.png"></span></button>
                        </div>

                       
            <?php 
                }
                $result2 = null;
            ?>
                        
                    </div>

                </div>        

            <?php 
                }
                echo '</div>';
                $result = null;
                $db = null;
            ?>

        </div>
    </div>
</body>