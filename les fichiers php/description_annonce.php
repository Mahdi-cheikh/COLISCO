<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Description Annonce</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .header a {
            text-decoration: none;
            color: #007bff;
            font-size: 18px;
            margin-right: 10px;
        }
        .header h1 {
            font-size: 20px;
            margin: 0;
        }
        .section {
            margin-bottom: 20px;
            border: 1px solid #007bff;
            border-radius: 8px;
            padding: 10px;
        }
        .section h2 {
            font-size: 18px;
            margin: 0 0 10px;
        }
        .section p {
            margin: 5px 0;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .icon {
            display: flex;
            align-items: center;
        }
        .icon img {
            width: 20px;
            height: 20px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="recherche trajet.php">&larr; Retour</a>
            <h1>
                <?php
                // Check if 'id' is passed in the URL
                if (isset($_GET['id'])) {
                    $id = intval($_GET['id']); // Sanitize the input

                    // Connect to the database
                    $conn = new mysqli("localhost", "root", "", "colisco");

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch the object details based on the ID
                    $sql = "SELECT object, price, weight, quantity, additional_info, ville_dep, ville_arr, user_name FROM colis WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // Output the object name
                        $row = $result->fetch_assoc();
                        echo htmlspecialchars($row['object']);
                    } else {
                        echo "Object not found";
                    }

                    // Close the connection
                    $stmt->close();
                    $conn->close();
                } else {
                    echo "No object selected";
                }
                ?>
            </h1>
        </div>
        <p>Référence N° <strong><?php echo isset($id) ? $id : 'N/A'; ?></strong></p>
        <p>Personne ne s'est encore proposé, soyez le premier!</p>

        <div class="section">
            <div class="row">
                <h2>Proposition</h2>
                <a href="discussion.php?user_name=<?php echo urlencode($row['user_name']); ?>" class="button">Discuter</a>            </div>
            <p><strong><?php echo isset($row['price']) ? htmlspecialchars($row['price']) . ' TND' : 'N/A'; ?></strong></p>
        </div>

        <div class="section">
            <h2><?php echo isset($row['object']) ? htmlspecialchars($row['object']) : 'N/A'; ?></h2>
            <p>Poids : <strong><?php echo isset($row['weight']) ? htmlspecialchars($row['weight']) : 'N/A'; ?></strong></p>
            <p>Quantité : <strong><?php echo isset($row['quantity']) ? htmlspecialchars($row['quantity']) : 'N/A'; ?></strong></p>
            <p>Description : <strong><?php echo isset($row['additional_info']) ? htmlspecialchars($row['additional_info']) : 'N/A'; ?></strong></p>
        </div>

        <div class="section">
            <div class="row">
                <div class="icon">
                    <img src="cartes-et-drapeaux.png" alt="Départ">
                    <p>Départ : <strong><?php echo isset($row['ville_dep']) ? htmlspecialchars($row['ville_dep']) : 'N/A'; ?></strong></p>
                </div>
                <a href="https://www.google.com/maps/dir/?api=1&origin=<?php echo urlencode($row['ville_dep']); ?>&destination=<?php echo urlencode($row['ville_arr']); ?>" 
                   class="button" 
                   target="_blank">
                   Afficher le trajet
                </a>
            </div>
            <div class="row">
                <div class="icon">
                    <img src="cartes-et-drapeaux.png" alt="Arrivée">
                    <p>Arrivée : <strong><?php echo isset($row['ville_arr']) ? htmlspecialchars($row['ville_arr']) : 'N/A'; ?></strong></p>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="row">
                <div class="icon">
                    <img src="profil.png" alt="User">
                    <p><strong><?php echo isset($row['user_name']) ? htmlspecialchars($row['user_name']) : 'N/A'; ?></strong></p>
                </div>
                              <a href="user_profile.php?user_name=<?php echo urlencode($row['user_name']); ?>" class="button">Afficher le profil</a>
            </div>
        </div>
    </div>
</body>
</html>