<?php
// Start the session
session_start();

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
    // Retrieve form data
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;

    // Validate required fields
    if ($price <= 0) {
        die("A valid price must be provided.");
    }

    // Update the `colis` table with the price
    $stmt = $conn->prepare("UPDATE colis SET price = ? WHERE id = (SELECT MAX(id) FROM colis)");
    $stmt->bind_param("d", $price);

    if ($stmt->execute()) {
        echo "Price updated successfully in the colis table.";
        // Redirect to a confirmation page or next step
        header("Location: confirmation annonce.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>