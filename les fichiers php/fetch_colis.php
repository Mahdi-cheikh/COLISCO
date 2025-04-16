<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "colisco");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the colis table
$sql = "SELECT ville_dep, price FROM colis";
$result = $conn->query($sql);

$colis = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $colis[] = $row;
    }
}

// Return data as JSON
header("Content-Type: application/json");
echo json_encode($colis);

$conn->close();
?>