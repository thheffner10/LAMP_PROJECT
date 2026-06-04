<?php
require 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

// Read JSON from request
$data = json_decode(file_get_contents('php://input'), true);

// Grab variables safely
$contactId = $data['id'] ?? 0;    // id of the contact to delete
$userId    = $data['userId'] ?? 0; // your session/user id

// Prepare SQL
$stmt = $conn->prepare("DELETE FROM Contacts WHERE id=? AND userId=?");
$stmt->bind_param("ii", $contactId, $userId);

// Execute
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(["success" => true, "message" => "Contact deleted"]);
} else {
    echo json_encode(["success" => false, "message" => "Contact not found or already deleted"]);
}

// Close connections
$stmt->close();
$conn->close();
?>
