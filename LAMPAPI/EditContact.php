<?php
require 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Variables
$id        = $data['id'] ?? 0;
$userId    = $data['userId'] ?? 0;
$firstName = $data['firstName'] ?? '';
$lastName  = $data['lastName'] ?? '';
$phone     = $data['phone'] ?? '';
$email     = $data['email'] ?? '';

// Basic validation
if (!$id || !$userId) {
    echo json_encode([
        "success" => false,
        "message" => "Missing contact id or userId"
    ]);
    exit;
}

// Query for update
$stmt = $conn->prepare(
    "UPDATE Contacts 
     SET first_name = ?, last_name = ?, phone = ?, email = ?
     WHERE contact_ID = ? AND user_ID = ?"
);

$stmt->bind_param("ssssii", $firstName, $lastName, $phone, $email, $id, $userId);

// Execute safely
try {
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "success" => true,
            "message" => "Contact updated"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "No contact found or no changes made"
        ]);
    }

} catch (mysqli_sql_exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database error"
    ]);
}

// Cleanup
$stmt->close();
$conn->close();
?>
