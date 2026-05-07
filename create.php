<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

$host = "localhost";
$db_name = "blog"; 
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (!empty($data['title']) && !empty($data['content'])) {
        $sql = "INSERT INTO posts (title, excerpt, content, image_url) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            $data['title'],
            $data['excerpt'],
            $data['content'],
            $data['image_url'] ?? 'https://via.placeholder.com/600x400'
        ]);

        echo json_encode(["status" => "success", "message" => "Post created successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Missing title or content"]);
    }

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $e->getMessage()]);
}
?>