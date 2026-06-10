<?php
require 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

// Read input in JSON format
$data = json_decode(file_get_contents('php://input'), true);

// Variables for modification
$userId    = $data['userId'] ?? 0;
$firstName = $data['firstName'] ?? '';
$lastName  = $data['lastName'] ?? '';
$phone     = $data['phone'] ?? '';
$email     = $data['email'] ?? '';

// Validation
if (!$userId || !$firstName || !$lastName) {
    echo json_encode([
        "success" => false,
        "message" => "Missing required fields"
    ]);
    exit;
}

// Insert Contact
$stmt = $conn->prepare(
    "INSERT INTO Contacts (user_ID, first_name, last_name, phone, email)
     VALUES (?, ?, ?, ?, ?)"
);

$stmt->bind_param("issss", $userId, $firstName, $lastName, $phone, $email);

try {
    $stmt->execute();

    echo json_encode([
        "success" => true,
        "message" => "Contact added"
    ]);

} catch (mysqli_sql_exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

// Cleanup
$stmt->close();
$conn->close();
?>
