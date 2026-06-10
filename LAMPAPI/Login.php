<?php
require 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

// Read json
$data = json_decode(file_get_contents('php://input'), true);
$inputUsername = $data['username'] ?? '';
$inputPassword = $data['password'] ?? '';

// Prepare select query
$stmt = $conn->prepare("SELECT user_ID, firstName, lastName, username, password FROM Users WHERE username = ?");
$stmt->bind_param("s", $inputUsername);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists or not
if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "User not found"]);
    exit;
}

// Verify password
$user = $result->fetch_assoc();
if (password_verify($inputPassword, $user['password'])) {
    // Remove password before sending back
    unset($user['password']);
    echo json_encode(["success" => true, "user" => $user]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid password"]);
}

// Close connections
$stmt->close();
$conn->close();
?>
