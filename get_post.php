<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$host = "localhost";
$db_name = "blog";
$username = "root";
$password = ""; 

$id = isset($_GET['id']) ? $_GET['id'] : die();

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    
   
    $sql = "SELECT * FROM posts WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        echo json_encode($post);
    } else {
        echo json_encode(["error" => "Post not found"]);
    }

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>