<?php
require 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

// --- READ JSON INPUT ---
$data = json_decode(file_get_contents('php://input'), true);

// --- VARIABLES (easy to match frontend later) ---
$userId    = $data['userId'] ?? 0;
$firstName = $data['firstName'] ?? '';
$lastName  = $data['lastName'] ?? '';
$phone     = $data['phone'] ?? '';
$email     = $data['email'] ?? '';

// --- BASIC VALIDATION ---
if (!$userId || !$firstName || !$lastName) {
    echo json_encode([
        "success" => false,
        "message" => "Missing required fields"
    ]);
    exit;
}

// --- INSERT CONTACT ---
$stmt = $conn->prepare(
    "INSERT INTO Contacts (userId, firstName, lastName, phone, email)
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
        "message" => "Database error"
    ]);
}

// --- CLEANUP ---
$stmt->close();
$conn->close();
?>
