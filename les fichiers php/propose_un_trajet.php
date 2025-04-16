<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    die("Vous devez être connecté pour proposer un trajet.");
}

// Database connection
$conn = new mysqli("localhost", "root", "", "colisco");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $search = isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '';
    $departure_city = isset($_POST['departure-city']) ? htmlspecialchars($_POST['departure-city']) : '';
    $arrival_city = isset($_POST['arrival-city']) ? htmlspecialchars($_POST['arrival-city']) : '';
    $detour = isset($_POST['detour']) ? intval($_POST['detour']) : 0;
    $max_amount = isset($_POST['max-amount']) ? htmlspecialchars($_POST['max-amount']) : '';
    $frequency = isset($_POST['frequency']) ? htmlspecialchars($_POST['frequency']) : '';
    $date = isset($_POST['date']) ? htmlspecialchars($_POST['date']) : '';
    $round_trip = isset($_POST['round-trip']) ? 1 : 0; // Checkbox value

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO trajets (user_name, search_type, departure_city, arrival_city, detour, max_amount, frequency, date, round_trip) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssssisssi",
        $_SESSION['user_name'],
        $search,
        $departure_city,
        $arrival_city,
        $detour,
        $max_amount,
        $frequency,
        $date,
        $round_trip
    );

    // Execute the query
       if ($stmt->execute()) {
        header("Location: index2.php");
        exit(); // Ensure no further code is executed after the redirect
    } else {
        echo "Erreur: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Méthode de requête non valide.";
}
?>