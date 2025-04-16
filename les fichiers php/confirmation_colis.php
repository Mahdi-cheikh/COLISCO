<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Colis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #4a4a4a; /* Match the background color in the image */
            color: #fff;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            display: flex;
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
            width: 500px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: #000;
        }
        .card img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            background-color: #d3d3d3; /* Placeholder background for missing images */
        }
        .card-content {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 10px;
        }
        .card-content p {
            margin: 0;
            background-color: #eaeaea;
            padding: 10px;
            border-radius: 4px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Confirmation Colis</h1>
    <div class="container">
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

        // Fetch data from the confirmation_colis table
        $sql = "SELECT photo, object, address_2, address_3, price FROM confirmation_colis";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '
                <div class="card">
                    <img src="upload/' . htmlspecialchars($row['photo']) . '" alt="Photo">
                    <div class="card-content">
                        <p>' . htmlspecialchars($row['object']) . '</p>
                        <p>' . htmlspecialchars($row['address_2']) . '</p>
                        <p>' . htmlspecialchars($row['address_3']) . '</p>
                        <p>$' . htmlspecialchars($row['price']) . '</p>
                    </div>
                </div>';
            }
        } else {
            echo "<p style='text-align: center;'>No data found.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>