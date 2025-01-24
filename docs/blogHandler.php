<?php
require_once("database.php");

try {
    $db = new PDO("mysql:host=localhost;dbname=tdl478", "tdl478", "5652702UofRme?");
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit();
}

if (isset($_GET['recentBlogId'])) {
    $recentBlogId = $_GET['recentBlogId'];
} else {
    $recentBlogId = 0;
}

$query = "SELECT Users.username, Users.avatar,
Blogs.blog_id, SUBSTRING_INDEX(Blogs.blog_content, ' ', 3) AS blog_content_preview, Blogs.date_time, Blogs.featured_image,
COUNT(Comments.comment_id) AS comment_count
FROM Blogs 
INNER JOIN Users 
ON Blogs.user_id = Users.user_id
LEFT JOIN Comments 
ON Blogs.blog_id = Comments.blog_id
WHERE Blogs.blog_id > $recentBlogId
GROUP BY 
Blogs.blog_id, 
Users.username, 
Users.avatar, 
Blogs.date_time, 
Blogs.featured_image
ORDER BY Blogs.date_time DESC 
LIMIT 20";

try {
    $result = $db->query($query);
    $json = array();

    while($row = $result->fetch()) {
        $json[] = $row;
    }

    echo json_encode(['success' => true, 'blogs' => $json]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Failed to fetch blogs']);
}

$db = null;
exit();
?>