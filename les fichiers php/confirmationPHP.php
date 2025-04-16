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

// Fetch the price from the database
$price = 0; // Default price
$sql = "SELECT price FROM colis_4 WHERE user_name = ? ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['user_name']);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $price = $row['price'];
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boostez votre annonce</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add your CSS here */
    </style>
</head>
<body>
    <main>
        <div class="container">
            <div class="icon-container">
                <img src="lightning-icon.png" alt="Lightning Icon" class="icon">
            </div>
            <h1>Boostez votre annonce !</h1>
            <div class="info-box">
                <h2>Prépayez votre annonce</h2>
                <p>Maximisez vos chances de livraison rapide</p>
                <ul>
                    <li><span>✔</span> Pas de négociation</li>
                    <li><span>✔</span> Livraison rapide</li>
                    <li><span>✔</span> Nous vous remboursons si aucun transporteur ne se propose</li>
                </ul>
            </div>
            <form method="POST" action="process_payment.php">
                <button type="submit" class="btn-primary">Prépayer <?php echo htmlspecialchars($price); ?> TND</button>
            </form>
            <button class="btn-secondary" onclick="skipStep()">Passer cette étape</button>
        </div>
    </main>
    <script>
        function skipStep() {
            window.location.href = "next_step.php";
        }
    </script>
</body>
</html>

