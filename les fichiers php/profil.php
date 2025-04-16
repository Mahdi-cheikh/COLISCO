<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: login.html");
    exit;
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'colisco');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle deletion of colis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_colis_id'])) {
    $delete_colis_id = intval($_POST['delete_colis_id']);
    $sql = "DELETE FROM colis WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_colis_id);
    $stmt->execute();
    $stmt->close();
    // Redirect to refresh the page and avoid resubmission
    header("Location: profil.php");
    exit;
}

// Handle deletion of trajets
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_trajet_id'])) {
    $delete_trajet_id = intval($_POST['delete_trajet_id']);
    $sql = "DELETE FROM trajets WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_trajet_id);
    $stmt->execute();
    $stmt->close();
    // Redirect to refresh the page and avoid resubmission
    header("Location: profil.php");
    exit;
}

// Fetch user details from userregistration table
$user_details = [];
if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];
    $sql = "SELECT first_name, last_name, email, user_type, user_profile 
            FROM userregistration 
            WHERE CONCAT(first_name, ' ', last_name) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user_details = $result->fetch_assoc();
    }
    $stmt->close();
}

// Fetch all colis where user_name matches the session user_name
$colis_list = [];
$sql = "SELECT * FROM colis WHERE user_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $colis_list[] = $row;
    }
}
$stmt->close();

// Fetch all trajets where user_name matches the session user_name
$trajets_list = [];
$sql = "SELECT * FROM trajets WHERE user_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $trajets_list[] = $row;
    }
}
$stmt->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', Arial, sans-serif;
            background-color: rgb(245, 245, 245);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .profile-container {
            background-color: white;
            border-radius: 20px;
            width: 60%;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 50px;
        }

        .profile-container h1 {
            font-size: 28px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .user-info {
            margin-bottom: 30px;
            padding: 20px;
            background-color: rgb(239, 232, 214);
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .user-info h1 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #333;
        }

        .user-info p {
            margin: 10px 0;
            font-size: 16px;
            color: #555;
        }

        .highlight-box {
            background-color: rgb(255, 255, 255);
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-height: 400px;
            overflow-y: auto;
        }

        .colis-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 12px;
            background-color: #f9f9f9;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .colis-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .colis-photo {
            width: 80px;
            height: 80px;
            background-color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            overflow: hidden;
        }

        .colis-photo img {
            max-width: 100%;
            max-height: 100%;
        }

        .colis-details {
            flex: 1;
            margin-left: 20px;
        }

        .colis-details p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        .validate-button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .validate-button:hover {
            background-color: #cc0000;
        }

        .return-button {
            display: inline-block;
            background-color: #4a00ff;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .return-button:hover {
            background-color: #3700cc;
            transform: translateY(-2px);
        }

        /* Scrollbar Styling */
        .highlight-box::-webkit-scrollbar {
            width: 8px;
        }

        .highlight-box::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 4px;
        }

        .highlight-box::-webkit-scrollbar-thumb:hover {
            background-color: #aaa;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-container {
                width: 90%;
                padding: 20px;
            }

            .colis-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .colis-details {
                margin-left: 0;
                margin-top: 10px;
            }

            .validate-button {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <!-- User Information Section -->
        <div class="user-info">
            <h1>Mes Coordonnées</h1>
            <p><strong>Prénom:</strong> <?php echo htmlspecialchars($user_details['first_name'] ?? 'Non disponible'); ?></p>
            <p><strong>Nom:</strong> <?php echo htmlspecialchars($user_details['last_name'] ?? 'Non disponible'); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user_details['email'] ?? 'Non disponible'); ?></p>
            <p><strong>Type:</strong> <?php echo htmlspecialchars($user_details['user_type'] ?? 'Non disponible'); ?></p>
            <p><strong>Profil:</strong> <?php echo htmlspecialchars($user_details['user_profile'] ?? 'Non disponible'); ?></p>
        </div>

        <h1>Mes Colis</h1>
        <div class="highlight-box">
            <?php if (!empty($colis_list)): ?>
                <?php foreach ($colis_list as $colis): ?>
                    <div class="colis-item">
                        <div class="colis-photo">
                            <?php if (!empty($colis['photos'])): ?>
                                <img src="<?php echo htmlspecialchars($colis['photos']); ?>" alt="Photos">
                            <?php else: ?>
                                <span>Photo</span>
                            <?php endif; ?>
                        </div>
                        <div class="colis-details">
                            <p><strong>Objet:</strong> <?php echo htmlspecialchars($colis['object']); ?></p>
                            <p><strong>Ville Départ:</strong> <?php echo htmlspecialchars($colis['ville_dep']); ?></p>
                            <p><strong>Ville Arrivée:</strong> <?php echo htmlspecialchars($colis['ville_arr']); ?></p>
                            <p><strong>Prix:</strong> <?php echo htmlspecialchars($colis['price']); ?> TND</p>
                        </div>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="delete_colis_id" value="<?php echo htmlspecialchars($colis['id']); ?>">
                            <button type="submit" class="validate-button">Supprimé</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun colis trouvé.</p>
            <?php endif; ?>
        </div>

        <h1>Mes Trajets</h1>
        <div class="highlight-box">
            <?php if (!empty($trajets_list)): ?>
                <?php foreach ($trajets_list as $trajet): ?>
                    <div class="colis-item">
                        <div class="colis-details">
                            <p><strong>Ville Départ:</strong> <?php echo htmlspecialchars($trajet['departure_city']); ?></p>
                            <p><strong>Ville Arrivée:</strong> <?php echo htmlspecialchars($trajet['arrival_city']); ?></p>
                            <p><strong>Détour Maximum:</strong> <?php echo htmlspecialchars($trajet['detour']); ?> km</p>
                            <p><strong>Montant Maximum:</strong> <?php echo htmlspecialchars($trajet['max_amount']); ?> TND</p>
                            <p><strong>Fréquence:</strong> <?php echo htmlspecialchars($trajet['frequency']); ?></p>
                            <p><strong>Date:</strong> <?php echo htmlspecialchars($trajet['date']); ?></p>
                        </div>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="delete_trajet_id" value="<?php echo htmlspecialchars($trajet['id']); ?>">
                            <button type="submit" class="validate-button">Supprimé</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun trajet trouvé.</p>
            <?php endif; ?>
        </div>

        <!-- Return Button -->
        <div style="text-align: center; margin-top: 20px;">
            <a href="index2.php" class="return-button">Retour</a>
        </div>
    </div>
</body>
</html>