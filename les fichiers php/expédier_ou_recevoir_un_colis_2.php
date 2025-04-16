<?php

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
    $stmt = $conn->prepare("INSERT INTO colis_enlevement (user_name, address, pickup_type, has_coordinates) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $_SESSION['user_name'], $address, $pickup_type, $has_coordinates);

    if ($stmt->execute()) {
        // Redirect to the next page
        header("Location: expédier_ou_recevoir_un_colis_3.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expédier ou Recevoir un Colis</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container">
        <h1>Enlèvement</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="address">Adresse</label>
                <input type="text" id="address" name="address" placeholder="Ex: 13 cité el nour nabeul" required>
            </div>

            <div class="form-group">
                <label for="pickup-type">Type d'enlèvement</label>
                <select id="pickup-type" name="pickup_type" required>
                    <option value="">Choisir un type d'enlèvement</option>
                    <option value="domicile">À domicile</option>
                    <option value="point-relais">Point relais</option>
                </select>
            </div>

            <div class="form-group inline-group">
                <input type="checkbox" id="has-coordinates" name="has_coordinates">
                <label for="has-coordinates">J'ai les coordonnées de l'expéditeur</label>
            </div>

            <div class="form-navigation">
                <button type="button" class="prev-btn" onclick="location.href='Expédier ou recevoir un colis.php'">Précédent</button>
                <button type="submit" class="next-btn">Suivant</button>
            </div>
        </form>
    </div>
</body>
</html>