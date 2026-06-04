<?php
require 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

// Get JSON from request
$data = json_decode(file_get_contents('php://input'), true);

// Grab the search term safely
$searchTerm = $data['searchTerm'] ?? '';
$userId     = $data['userId'] ?? ''; // assume your frontend sends the logged-in user's id

// Prepare SQL with LIKE for search
$stmt = $conn->prepare(
    "SELECT id, firstName, lastName, phone, email 
     FROM Contacts 
     WHERE userId = ? AND (firstName LIKE ? OR lastName LIKE ? OR phone LIKE ? OR email LIKE ?)"
);

// Add wildcards for LIKE
$likeTerm = "%$searchTerm%";
$stmt->bind_param("issss", $userId, $likeTerm, $likeTerm, $likeTerm, $likeTerm);

// Execute
$stmt->execute();
$result = $stmt->get_result();

// Fetch all results
$contacts = $result->fetch_all(MYSQLI_ASSOC);

// Return JSON
echo json_encode([
    "success" => true,
    "contacts" => $contacts
]);

// Close connections
$stmt->close();
$conn->close();
?>
