<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
header("Content-type: application/json");
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../classes/user.php';


$database = new Database();

$db = $database->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"), true);

//sanitize

$user->first_name = htmlspecialchars(strip_tags(trim($data['first_name'])));
$user->last_name = htmlspecialchars(strip_tags(trim($data['last_name'])));
$user->email = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
$user->mobile = preg_replace('/\D/', '', trim($data['mobile']));
$user->role = "customer";

$user->password = htmlspecialchars(strip_tags(trim($data['password'])));

if ($user->password !== $data['confirm_password']) {
    http_response_code(400);
    echo json_encode(["message" => "Passwords do not match.", "success" => false]);
    exit();
}
$user->password = password_hash($user->password, PASSWORD_BCRYPT);

if ($user->emailExists()) {
    http_response_code(409);
    echo json_encode(["message" => "Email already exists.", "success" => false]);
    exit();
}
//create user
if ($user->create()) {
    http_response_code(201);
    echo json_encode((["message" => "User registered successfully", "success" => true]));
} else {
    http_response_code(500);
    echo json_encode(["message" => "Error registering user.", "success" => false]);
}


?>