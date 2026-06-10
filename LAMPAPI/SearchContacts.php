<?php
require 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

// Get JSON from request
$data = json_decode(file_get_contents('php://input'), true);

// Grab the search term safely
$searchTerm = $data['search'] ?? '';
$userId     = $data['userId'] ?? '';

// Prepare SQL with LIKE for search
$stmt = $conn->prepare(
    "SELECT contact_ID as id, first_name as firstName, last_name as lastName, phone, email 
     FROM Contacts 
     WHERE user_ID = ? AND (first_name LIKE ? OR last_name LIKE ? OR phone LIKE ? OR email LIKE ?)"
);

// Format search query for partial matches
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
    "results" => $contacts
]);

// Close connections
$stmt->close();
$conn->close();
?>
