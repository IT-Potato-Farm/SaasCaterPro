<?php 
session_start();
header("Content-type: application/json");
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../classes/user.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$data = json_decode(file_get_contents("php://input"), true);


$user->email = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
$user->password = htmlspecialchars(strip_tags(trim($data['password'])));


$loginResult = $user->login();

if ($loginResult['success']) {
    
    http_response_code(200);
    echo json_encode($loginResult);
} else {
    http_response_code(401);
    echo json_encode($loginResult);
}
?>