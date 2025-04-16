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
    $ville_dep = isset($_POST['ville_dep']) ? $conn->real_escape_string($_POST['ville_dep']) : '';
    $pickup_type_dep = isset($_POST['pickup_type_dep']) ? $conn->real_escape_string($_POST['pickup_type_dep']) : '';
    $has_coordinates_dep = isset($_POST['has_coordinates_dep']) ? 1 : 0;
   

    // Validate required fields
    if (empty($ville_dep) || empty($pickup_type_dep) ) {
        die("All required fields must be filled.");
    }

    // Insert data into the `colis` table
    $stmt = $conn->prepare("UPDATE colis SET ville_dep = ?, pickup_type_dep = ?, has_coordinates_dep = ? WHERE id = (SELECT MAX(id) FROM colis)");
    $stmt->bind_param("sss", $ville_dep, $pickup_type_dep, $has_coordinates_dep);

    if ($stmt->execute()) {
        echo "Data updated successfully in the colis table.";
        // Redirect to a confirmation page or next step
        header("Location:expédier ou recevoir un colis 3.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>