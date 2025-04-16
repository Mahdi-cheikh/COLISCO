<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$user_name = $_SESSION['user_name'];
$conn = new mysqli('localhost', 'root', '', 'colisco');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all details from colis where user_name matches the session user_name
$sql = "SELECT * FROM colis WHERE user_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result();

$packages = [];
while ($row = $result->fetch_assoc()) {
    $packages[] = $row; // Add the entire row to the packages array
}

echo json_encode($packages); // Return all details as JSON
$stmt->close();
$conn->close();
?>