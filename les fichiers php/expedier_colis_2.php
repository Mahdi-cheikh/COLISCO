<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    // Redirect to the login page if not logged in
    header("Location: login.html");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "colisco";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $address = isset($_POST['address']) ? $conn->real_escape_string($_POST['address']) : '';
    $pickup_type = isset($_POST['pickup_type']) ? $conn->real_escape_string($_POST['pickup_type']) : '';
    $has_coordinates = isset($_POST['has_coordinates']) ? 1 : 0; // Checkbox value

    // Validate required fields
    if (empty($address) || empty($pickup_type)) {
        die("Address and Pickup Type are required.");
    }

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO colis_2 (user_name, address, pickup_type, has_coordinates) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $_SESSION['user_name'], $address, $pickup_type, $has_coordinates);

    if ($stmt->execute()) {
        // Redirect to the next page
        header("Location: expédier ou recevoir un colis 3.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
