<?php
require_once("database.php");

$userId = $_GET['user_id'];
$commentId = $_GET['comment_id'];
$blogId = $_GET['blog_id'];
$voteType = $_GET['voteType'];

try {
    $db = new PDO("mysql:host=localhost;dbname=tdl478", "tdl478", "5652702UofRme?");
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $query = "SELECT user_id, comment_id FROM Votes WHERE user_id=$userId AND comment_id=$commentId";
    $result = $db->query($query);
    $match = $result->fetch();

    if($match) {
        if ($voteType == "upvote") {
            $updateQuery = "UPDATE Votes SET up_votes=1, down_votes=0 WHERE user_id=$userId AND comment_id=$commentId";
        } elseif ($voteType == "downvote") {
            $updateQuery = "UPDATE Votes SET up_votes=0, down_votes=1 WHERE user_id=$userId AND comment_id=$commentId";
        }
        $result = $db->exec($updateQuery);
    } else {
        if ($voteType == "upvote") {
            $insertQuery = "INSERT INTO Votes (user_id, comment_id, up_votes, down_votes) VALUES ($userId, $commentId, 1, 0)";
        } elseif ($voteType == "downvote") {
            $insertQuery = "INSERT INTO Votes (user_id, comment_id, up_votes, down_votes) VALUES ($userId, $commentId, 0, 1)";
        }
        $result = $db->exec($insertQuery);
    }

    
    $voteCountQuery = "SELECT SUM(up_votes) - SUM(down_votes) AS totalVotes FROM Votes WHERE comment_id=$commentId";
    $result = $db->query($voteCountQuery);
    if ($result) {
        $row = $result->fetch();
        $totalVotes = $row['totalVotes'];
    } else {
        $totalVotes = 0;
    }

    $json = [
        'success' => true, 
        'newVoteCount' => $totalVotes
    ];

    echo json_encode($json);
    
    $result = null;
    $totalVotes = null;
    $db = null;

} catch (PDOException $e) {
    $json =[
        'success' => false, 
        'message' => $e->getMessage()
    ];
    echo json_encode($json);
}
?>