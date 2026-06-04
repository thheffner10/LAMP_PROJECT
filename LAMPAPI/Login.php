<?php
require 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

// --- TABLE & COLUMN NAMES (easy to map to frontend) ---
$tableUsers = "Users";
$colId = "id";
$colFirstName = "firstName";
$colLastName = "lastName";
$colLogin = "login";
$colPassword = "password";

// --- READ JSON FROM POST ---
$data = json_decode(file_get_contents('php://input'), true);
$inputLogin = $data['login'] ?? '';
$inputPassword = $data['password'] ?? '';

// --- PREPARE SELECT QUERY ---
$stmt = $conn->prepare("SELECT $colId, $colFirstName, $colLastName, $colPassword FROM $tableUsers WHERE $colLogin = ?");
$stmt->bind_param("s", $inputLogin);
$stmt->execute();
$result = $stmt->get_result();

// --- CHECK IF USER EXISTS ---
if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "User not found"]);
    exit;
}

// --- VERIFY PASSWORD ---
$user = $result->fetch_assoc();
if (password_verify($inputPassword, $user[$colPassword])) {
    // Remove password before sending back
    unset($user[$colPassword]);
    echo json_encode(["success" => true, "user" => $user]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid password"]);
}

// --- CLOSE CONNECTIONS ---
$stmt->close();
$conn->close();
?>
