<?php
require_once("database.php");

try {
    $db = new PDO("mysql:host=localhost;dbname=tdl478", "tdl478", "5652702UofRme?");
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit();
}

if (isset($_GET['recentCommentId'])) {
    $recentCommentId = $_GET['recentCommentId'];
} else {
    $recentCommentId = 0;
}

$query = "SELECT U.username, C.comment_content AS Body, SUM(up_votes) - SUM(down_votes) AS NumVotes, C.comment_avatar, C.comment_id
    FROM Comments AS C 
    JOIN Users AS U 
    ON C.user_id=U.user_id 
    JOIN Votes AS V 
    ON C.comment_id=V.comment_id 
    WHERE C.blog_id > $recentCommentId
    GROUP BY C.comment_id 
    ORDER BY NumVotes DESC";

try {
    $result = $db->query($query);
    $json = array();

    while($row = $result->fetch()) {
        $json[] = $row;
    }

    echo json_encode(['success' => true, 'comments' => $json]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Failed to fetch comments']);
}

$db = null;
exit();

exit();
?>