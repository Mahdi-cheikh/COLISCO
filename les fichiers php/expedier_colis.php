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
    $user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Anonymous';
    $photos = isset($_FILES['photos']['name'][0]) ? $_FILES['photos']['name'] : [];
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
    $object = isset($_POST['object']) ? $conn->real_escape_string($_POST['object']) : '';
    $exact_dimensions = isset($_POST['exact-dimensions']) ? 1 : 0;
    $format = isset($_POST['format']) ? $conn->real_escape_string($_POST['format']) : null;
    $weight = isset($_POST['weight']) ? $conn->real_escape_string($_POST['weight']) : null;
    $additional_info = isset($_POST['additional-info']) ? $conn->real_escape_string($_POST['additional-info']) : null;

    // Validate required fields
    if (empty($quantity) || empty($object)) {
        die("All required fields must be filled.");
    }

    // Handle file uploads
    $uploadDir = "upload/";
    $uploadedPhotos = [];
    if (!empty($photos)) {
        foreach ($_FILES['photos']['name'] as $key => $name) {
            $fileType = $_FILES['photos']['type'][$key];
            $fileSize = $_FILES['photos']['size'][$key];
            $tmpName = $_FILES['photos']['tmp_name'][$key];

            // Validate file type and size
            if (in_array($fileType, ['image/jpeg', 'image/png', 'image/gif']) && $fileSize <= 7000000) {
                $targetFile = $uploadDir . uniqid() . "_" . basename($name);
                if (move_uploaded_file($tmpName, $targetFile)) {
                    $uploadedPhotos[] = $targetFile;
                } else {
                    echo "Error uploading file: " . $name;
                }
            } else {
                echo "Invalid file type or size for: " . $name;
            }
        }
    }

    $photos = implode(",", $uploadedPhotos); // Store file paths as a comma-separated string

    // Insert data into the `colis` table
    $stmt = $conn->prepare("INSERT INTO colis (user_name, photos, quantity, object, exact_dimensions, format, weight, additional_info) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisssss", $user_name, $photos, $quantity, $object, $exact_dimensions, $format, $weight, $additional_info);
    if ($stmt->execute()) {
        echo "Data inserted successfully into the colis table.";
        // Redirect to a confirmation page or next step
        header("Location: expédier ou recevoir un colis 2.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>