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

// Fetch data from the tables
$sql = "
    SELECT 
        colis.username, 
        colis.photo, 
        colis_2.address AS address_2, 
        colis_3.address AS address_3, 
        colis_4.price 
    FROM colis
    INNER JOIN colis_2 ON colis.id = colis_2.colis_id
    INNER JOIN colis_3 ON colis.id = colis_3.colis_id
    INNER JOIN colis_4 ON colis.id = colis_4.colis_id
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Create a new table to store the data
    $createTableSql = "
        CREATE TABLE IF NOT EXISTS confirmation_colis (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_name VARCHAR(255),
            photo VARCHAR(255),
            address_2 VARCHAR(255),
            address_3 VARCHAR(255),
            price DECIMAL(10, 2)
        )
    ";
    if ($conn->query($createTableSql) === TRUE) {
        echo "Table 'confirmation_colis' created successfully or already exists.<br>";
    } else {
        die("Error creating table: " . $conn->error);
    }

    // Insert data into the new table
    while ($row = $result->fetch_assoc()) {
        $userName = $conn->real_escape_string($row['username']);
        $photo = $conn->real_escape_string($row['photo']);
        $address2 = $conn->real_escape_string($row['address_2']);
        $address3 = $conn->real_escape_string($row['address_3']);
        $price = $conn->real_escape_string($row['price']);

        $insertSql = "
            INSERT INTO confirmation_colis (user_name, photo, address_2, address_3, price)
            VALUES ('$userName', '$photo', '$address2', '$address3', '$price')
        ";
        if ($conn->query($insertSql) === TRUE) {
            echo "Data inserted successfully for user: $userName<br>";
        } else {
            echo "Error inserting data: " . $conn->error . "<br>";
        }
    }

    echo "Data successfully transferred to the new table.";
} else {
    echo "No data found.";
}

$conn->close();
?>