<?php
require 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

// Read JSON from request
$data = json_decode(file_get_contents('php://input'), true);

// Grab variables safely
$firstName = $data['firstName'] ?? '';
$lastName  = $data['lastName'] ?? '';
$username     = $data['username'] ?? '';
$password  = $data['password'] ?? '';

// Hash the password
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Prepare SQL
$stmt = $conn->prepare("INSERT INTO Users (firstName, lastName, username, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $firstName, $lastName, $username, $passwordHash);

// Execute with error handling
try {
    $stmt->execute();
    echo json_encode(["success" => true, "message" => "User registered"]);

} catch (mysqli_sql_exception $e) {

    // Check for duplicate entry error
    if ($e->getCode() == 1062) {
        echo json_encode([
            "success" => false,
            "message" => "Username already exists"
        ]);
    } else {
        echo json_encode([
        	"success" => false,
        	"message" => $e->getMessage()
    	]);
    }
}

// Close connections
$stmt->close();
$conn->close();
?>
