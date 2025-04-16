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
    $ville_arr = isset($_POST['ville_arr']) ? trim($_POST['ville_arr']) : '';
    $pickup_type_arr = isset($_POST['pickup_type_arr']) ? trim($_POST['pickup_type_arr']) : '';
    $has_coordinates_arr = isset($_POST['has_coordinates_arr']) ? 1 : 0;

    // Debugging output
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    // Validate required fields
    if (empty($ville_arr) || empty($pickup_type_arr)) {
        die("All required fields must be filled.");
    }

    // Insert data into the `colis` table
    $stmt = $conn->prepare("UPDATE colis SET ville_arr = ?, pickup_type_arr = ?, has_coordinates_arr = ? WHERE id = (SELECT MAX(id) FROM colis)");
    $stmt->bind_param("sss", $ville_arr, $pickup_type_arr, $has_coordinates_arr);

    if ($stmt->execute()) {
        echo "Data updated successfully.";
        // Redirect to a confirmation page or next step
        header("Location: expédier ou recevoir un colis 4.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>