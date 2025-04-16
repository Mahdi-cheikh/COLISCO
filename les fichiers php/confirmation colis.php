<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "colisco"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from each table
$colisData = $conn->query("SELECT id, photos, object FROM colis");
$colis2Data = $conn->query("SELECT user_name, address AS address_2 FROM colis_2");
$colis3Data = $conn->query("SELECT address AS address_3 FROM colis_3");
$colis4Data = $conn->query("SELECT price FROM colis_4");

// Create an associative array to store combined data
$data = [];

// Process data from `colis`
while ($row = $colisData->fetch_assoc()) {
    $data[] = [
        'photo' => $row['photos'],
        'object' => $row['object'],
        'user_name' => null,
        'address_2' => null,
        'address_3' => null,
        'price' => null,
    ];
}

// Process data from `colis_2`
$index = 0;
while ($row = $colis2Data->fetch_assoc()) {
    if (isset($data[$index])) {
        $data[$index]['user_name'] = $row['user_name'];
        $data[$index]['address_2'] = $row['address_2'];
    }
    $index++;
}

// Process data from `colis_3`
$index = 0;
while ($row = $colis3Data->fetch_assoc()) {
    if (isset($data[$index])) {
        $data[$index]['address_3'] = $row['address_3'];
    }
    $index++;
}

// Process data from `colis_4`
$index = 0;
while ($row = $colis4Data->fetch_assoc()) {
    if (isset($data[$index])) {
        $data[$index]['price'] = $row['price'];
    }
    $index++;
}

// Display data in the desired structure
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Colis</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: rgb(255, 255, 255); /* Light gray background for better contrast */
        }
        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); /* Responsive grid layout */
            gap: 30px; /* Larger gap between cards */
            padding: 20px; /* Add padding around the container */
        }
        .card {
            display: flex; /* Use flexbox for layout */
            align-items: center; /* Vertically align content */
            border: 2px solid #ddd; /* Slightly thicker border */
            border-radius: 12px; /* More rounded corners */
            padding: 20px; /* Adjust padding */
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2); /* Larger shadow for better emphasis */
            background-color: #fff; /* White background for the card */
            transition: transform 0.3s ease; /* Add hover effect */
        }
        .card:hover {
            transform: scale(1.05); /* Slight zoom on hover */
        }
        .card img {
            width: 150px; /* Larger image size */
            height: auto;
            border-radius: 12px; /* Rounded corners for the image */
            margin-right: 20px; /* Add spacing between the image and details */
        }
        .card .details {
            flex: 1; /* Allow details to take up remaining space */
        }
        .card .details div {
            margin-bottom: 12px; /* Increased spacing between details */
            font-size: 1.4em; /* Larger font size for better readability */
            font-weight: bold; /* Make text bold */
        }        .validate-button {
            display: inline-block; /* Make it behave like a button */
            margin-top: 20px; /* Add more space above the button */
            padding: 10px 20px;
            background-color: rgb(0, 104, 249); /* Blue color */
            color: #fff; /* White text */
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 1em;
            text-align: center; /* Center the text inside the button */
            text-decoration: none; /* Remove the underline */
            transition: background-color 0.3s ease;
        }
        
        .validate-button:hover {
            background-color: #218838; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <div class="container">';

foreach ($data as $row) {
    // Use the photo path directly from the database
    $photoPath = htmlspecialchars($row['photo']);

    // Check if the photo exists
   

    // Render the card
    echo '<div class="card">';
    echo '<img src="' . $photoPath . '" alt="Photo">';
    echo '<div class="details">';
    echo '<div>Objet: ' . htmlspecialchars($row['object']) . '</div>';
    echo '<div>Départ : ' . htmlspecialchars($row['address_2']) . '</div>';
    echo '<div>Arrivée : ' . htmlspecialchars($row['address_3']) . '</div>';
    echo '<div>Prix Proposé: ' . htmlspecialchars($row['price']) . ' TND</div>';
    echo '<a href="index2.php?user=' . urlencode($row['user_name']) . '" class="validate-button">Validate</a>';
    echo '</div>';
    echo '</div>';
}

echo '</div>
</body>
</html>';

$conn->close();
?>