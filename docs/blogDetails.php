<?php
session_start();
require_once("database.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: mainPage(Before).php");
    exit();
} else {
    $blogId = $_GET['blog_id'];
    $userId = $_SESSION["user_id"];
    $username = $_SESSION["uname_T"];
    $avatar = $_SESSION["pfp_T"];
}

//DB connection
try {
    $db = new PDO("mysql:host=localhost;dbname=tdl478", "tdl478", "5652702UofRme?");
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Default fetch mode
} catch (PDOException $e) {
    //Handle the connection error
    echo "Database connection failed: " . $e->getMessage();
    exit;
}

//Check if Comment Form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['commentInput'])) {
        $newComment = htmlspecialchars($_POST['commentInput']);
    } else {
        $newComment = ""; 
    }

    if (isset($_POST['submitComment'])) {
        // Insert the comment into the database
        try {
        // Insert the comment into the Comments table
        $query = "INSERT INTO Comments (blog_id, user_id, comment_content, comment_username, comment_avatar, comment_date_time) 
        VALUES ($blogId, $userId, '$newComment', '$username', '$avatar', NOW())";
        $result = $db->exec($query);

        // Retrieve the last inserted ID (comment_id) for the Votes table
        $commentId = $db->lastInsertId();

        // Insert the initial votes for the new comment
        $query = "INSERT INTO Votes (user_id, comment_id, up_votes, down_votes) 
        VALUES ($userId, $commentId, 0, 0)";
        $result = $db->exec($query);


        // Refresh the page to display the new comment
        header("Location: blogDetails.php?blog_id=$blogId");
        exit();
        } catch (PDOException $e) {
        echo "Error adding comment: " . $e->getMessage();
        }
    }

    
    
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['submitUpVote'])) {
        try {
            $userId = $_GET['user_id'];
            $commentId = $_GET['comment_id'];

            $query = "SELECT user_id, comment_id FROM Votes WHERE user_id=$userId AND comment_id=$commentId";
            $result = $db->query($query);
            $match = $result->fetch();

            if ($match) {
                $query = "UPDATE Votes SET up_votes=1 , down_votes=0 WHERE user_id=$userId AND comment_id=$commentId";
                $result = $db->exec($query);
                
            } else {
                $query = "INSERT INTO Votes(user_id, comment_id, up_votes, down_votes)
    VALUES ($userId, $commentId, 1, 0)";
                $result = $db->exec($query);
            }
            header("Location: blogDetails.php?blog_id=$blogId");
            exit();
        } catch (PDOException $e) {
            echo "Error adding vote: " . $e->getMessage();
        }
    }

    if (isset($_GET['submitDownVote'])) {
        try {
            $userId = $_GET['user_id'];
            $commentId = $_GET['comment_id'];

            $query = "SELECT user_id, comment_id FROM Votes WHERE user_id=$userId AND comment_id=$commentId";
            $result = $db->query($query);
            $match = $result->fetch();

            if ($match) {
                $query = "UPDATE Votes SET up_votes=0 , down_votes=1 WHERE user_id=$userId AND comment_id=$commentId";
                $result = $db->exec($query);
                
            } else {
                $query = "INSERT INTO Votes(user_id, comment_id, up_votes, down_votes)
    VALUES ($userId, $commentId, 0, 1)";
                $result = $db->exec($query);
            }
            header("Location: blogDetails.php?blog_id=$blogId");
            exit();
        } catch (PDOException $e) {
            echo "Error adding vote: " . $e->getMessage();
        }
       
    }
}

?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Robog Blog Detail Page</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="js/eventHandlers.js"></script>
</head>

<body>
    <div class="Logo">
        <a href="mainPage(After).php"><img class="Roblog" src="img/Logo.png" alt="Roblog"></a>
        <a href="logout.php"><button class="LogoutButton">Log Out</button></a>
    </div>

    <?php
    //Query for actual Blog Post Content
    $query="SELECT U.avatar, U.username, 
B.blog_id, B.date_time, B.blog_content, B.featured_image
FROM Users AS U
JOIN Blogs AS B
ON U.user_id=B.user_id
WHERE B.blog_id=$blogId";

    $result = $db->query($query);
    $row1 = $result->fetch();
    ?>

    <div class="post_G">
        <img class="image_G" src="<?=$row1['avatar']?>" alt="<?=$row1['avatar']?>">

        <div class="name_G">
            <p><?=$row1['username']?></p>
            <span class="time-ago_G"><?=$row1['date_time']?></span>
        </div>

        <div class="mainpost_G">
            <img class="blog-image" src="<?=$row1['featured_image']?>" alt="<?=$row1['featured_image']?>">
            <p>
                <?=$row1['blog_content']?>
            </p>
            
        </div>

        <!-- Comments Section -->
        <div id="commentSection_G" class="commentSection_G">
            <h3>Comments</h3>

            <?php
            
    //Query for Comments
    $blid = $row1['blog_id'];
    $query = "SELECT U.username, C.comment_content AS Body, SUM(up_votes) - SUM(down_votes) AS NumVotes, C.comment_avatar, C.comment_id
    FROM Comments AS C 
    JOIN Users AS U 
    ON C.user_id=U.user_id 
    JOIN Votes AS V 
    ON C.comment_id=V.comment_id 
    WHERE C.blog_id=$blid
    GROUP BY C.comment_id 
    ORDER BY NumVotes DESC";

    try {
    $result = $db->query($query); //Execute the query
    } catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage(); //Handle query errors
    }
            while ($row = $result->fetch()) {
                ?>
            <div class="comment_G">
                <img src="<?= $row['comment_avatar'] ?>" alt="<?= $row['comment_avatar'] ?>">
                <div class="comment-details_G">
                        <span class="comment-author_G"><?=$row['username']?></span>
                        <p class="comment-text_G"><?=$row['Body']?></p>
                        <form class="comment-votes_G" action="" method="get" id="voteForm"> 
                            <input type="hidden" id="user_id" name="user_id" value="<?= $userId ?>">
                            <input type="hidden" id="comment_id" name="comment_id" value="<?= $row['comment_id'] ?>">
                            <input type="hidden" id="blog_id" name="blog_id" value="<?= $blid ?>">
                            
                            <button type="button" class="submitVote" data-comment-id="<?= $row['comment_id'] ?>" data-vote-type="upvote">
                                <span class="vote_G"><img src="img/UPVOTE_ON.png"></span>
                            </button>

                            <div id="counter-<?= $row['comment_id'] ?>"><?= $row['NumVotes'] ?></div>

                            <button type="button" class="submitVote" data-comment-id="<?= $row['comment_id'] ?>" data-vote-type="downvote">
                                <span class="vote_G"><img src="img/DOWNVOTE_ON.png"></span>
                            </button>
                        </form>
                        
                    </div>
                </div>
            </div> 
                <?php
            }
        $db=null;
        ?>
            <!-- Add Comment Input -->
            <div class="add-comment_G">
                <form method="post" action="">
                    <textarea id="commentInput" name="commentInput" placeholder="Write your comment..." required></textarea>
                    <button type="submit" name="submitComment">Submit</button>
                </form>
            </div>
            <div id="commentCounter" class="counter"></div>
        </div>
    </div>
    <script src="js/eventRegisterBlogDetail.js"></script>
</body>

</html>