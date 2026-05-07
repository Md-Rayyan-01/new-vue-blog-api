<?php
// api.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

// Database credentials
$host = "localhost";
$db_name = "blog";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $exception) {
    echo json_encode(["error" => "Connection error: " . $exception->getMessage()]);
    exit();
}

// Fetch posts
$query = "SELECT id, title, excerpt, image_url, created_at FROM posts ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute();

$posts = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Format the date
    $row['created_at'] = date('F j, Y', strtotime($row['created_at']));
    $posts[] = $row;
}

echo json_encode($posts);
?>