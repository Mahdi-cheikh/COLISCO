<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: login.html");
    exit();
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'colisco');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all records from the users table
$sql_users = "SELECT user_id, email, password, created_at, updated_at FROM users";
$result_users = $conn->query($sql_users);

// Fetch all records from the userregistration table
$sql_userregistration = "SELECT user_id, user_type, user_profile, first_name, last_name, birth_date, nationality, email, password, phone_number, referral_code, accepts_terms, accepts_newsletter, created_at, updated_at FROM userregistration";
$result_userregistration = $conn->query($sql_userregistration);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9; /* Light background for better contrast */
            color: #333; /* Darker text for readability */
        }
        h1, h2 {
            text-align: center;
            color: #444; /* Slightly darker heading color */
        }
        h2 {
            margin-top: 40px; /* Add spacing between sections */
            font-size: 24px; /* Larger font size for section headings */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff; /* White background for tables */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for better visibility */
        }
        table, th, td {
            border: 1px solid #ddd; /* Light border for cleaner look */
        }
        th, td {
            padding: 12px; /* Increased padding for better spacing */
            text-align: center;
        }
        th {
            background-color: #007bff; /* Blue background for headers */
            color: white; /* White text for headers */
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Alternate row background for readability */
        }
        tr:hover {
            background-color: #e9ecef; /* Highlight row on hover */
        }
        .action-buttons a {
            text-decoration: none;
            color: white;
            padding: 10px 20px; /* Larger buttons */
            border-radius: 8px; /* Rounded corners */
            font-size: 16px; /* Larger font size */
            font-weight: bold; /* Bold text */
            display: inline-block;
            margin: 5px; /* Add spacing between buttons */
        }
        .edit-btn {
            background-color: #28a745; /* Green for edit */
        }
        .delete-btn {
            background-color: #dc3545; /* Red for delete */
        }
        .edit-btn:hover {
            background-color: #218838; /* Darker green on hover */
        }
        .delete-btn:hover {
            background-color: #c82333; /* Darker red on hover */
        }
        
        
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">
            <a href="index2.php">
              <img src="logo2.png" width="200px" height="50px" alt="Logo">
            </a>
        </div>

        <div class="nav-buttons">
            <?php if (isset($_SESSION['user_name'])): ?>
                <!-- Display profile picture and user name -->
                <div class="profile">
                    <a href="profil.php">
                        <img src="utilisateur.png" alt="Profile Picture" class="profile-pic">
                    </a>
                    <span class="user-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                </div>
                <a href="logout.php" class="btn login">Se Déconnecter</a>
            <?php else: ?>
                <a href="recherche trajet.php" class="btn">Voir les annonces</a>
                <a href="login.html" class="btn login">Se Connecter</a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Add margin to the content below the nav -->
    <div style="margin-top: 110px;">
        <h2>Users Table</h2>
        <div style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; border-radius: 5px; padding: 10px;">
            <table>
                <thead>
                    <tr>
                        <th>user_id</th>
                        <th>email</th>
                        <th>password</th>
                        <th>created_at</th>
                        <th>updated_at</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_users->num_rows > 0): ?>
                        <?php while ($row = $result_users->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['user_id']; ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['password']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                <td><?php echo htmlspecialchars($row['updated_at']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <h2>User Registration Table</h2>
        <div style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; border-radius: 5px; padding: 10px;">
            <table>
                <thead>
                    <tr>
                        <th>user_id</th>
                        <th>user_type</th>
                        <th>user_profile</th>
                        <th>first_name</th>
                        <th>last_name</th>
                        <th>birth_date</th>
                        <th>nationality</th>
                        <th>email</th>
                        <th>password</th>
                        <th>phone_number</th>
                        <th>referal_code</th>
                        <th>accept_terms</th>
                        <th>accept_nexsletter</th>
                        <th>created_at</th>
                        <th>updated_at</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_userregistration->num_rows > 0): ?>
                        <?php while ($row = $result_userregistration->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['user_id']; ?></td>
                                <td><?php echo htmlspecialchars($row['user_type']); ?></td>
                                <td><?php echo htmlspecialchars($row['user_profile']); ?></td>
                                <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['birth_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['nationality']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['password']); ?></td>
                                <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                                <td><?php echo htmlspecialchars($row['referral_code']); ?></td>
                                <td><?php echo htmlspecialchars($row['accepts_terms']); ?></td>
                                <td><?php echo htmlspecialchars($row['accepts_newsletter']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                <td><?php echo htmlspecialchars($row['updated_at']); ?></td>
                                <td class="action-buttons">
                                    <a href="edit_user.php?id=<?php echo $row['user_id']; ?>" class="edit-btn">Modifier</a>
                                    <a href="delete_user.php?id=<?php echo $row['user_id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this user?');">Supprimer</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="16">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Add a new section for the "Colis Table" -->
        <h2>Colis Table</h2>
        <div style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; border-radius: 5px; padding: 10px;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background-color: #007bff; color: white;">
                    <tr>
                        <th>id</th>
                        <th>user_name</th>
                        <th>photos</th>
                        <th>quantity</th>
                        <th>object</th>
                        <th>exact_dimensions</th>
                        <th>format</th>
                        <th>weight</th>
                        <th>additional_info</th>
                        <th>ville_dep</th>
                        <th>pickup_type_dep</th>
                        <th>has_coordinates_dep</th>
                        <th>ville_arr</th>
                        <th>pickup_type_arr</th>
                        <th>has_coordinates_arr</th>
                        <th>price</th>
                        <th>created_at</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch all records from the colis table
                    $sql_colis = "SELECT id, user_name, photos, quantity, object, exact_dimensions, format, weight, additional_info, ville_dep, pickup_type_dep, has_coordinates_dep, ville_arr, pickup_type_arr, has_coordinates_arr, price, created_at FROM colis";
                    $result_colis = $conn->query($sql_colis);

                    if ($result_colis->num_rows > 0): ?>
                        <?php while ($row = $result_colis->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                                <td>
                                    <?php if (!empty($row['photos'])): ?>
                                        <img src="<?php echo htmlspecialchars($row['photos']); ?>" alt="Photo" style="width: 100px; height: auto; border-radius: 5px;">
                                    <?php else: ?>
                                        No photo
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                <td><?php echo htmlspecialchars($row['object']); ?></td>
                                <td><?php echo htmlspecialchars($row['exact_dimensions']); ?></td>
                                <td><?php echo htmlspecialchars($row['format']); ?></td>
                                <td><?php echo htmlspecialchars($row['weight']); ?></td>
                                <td><?php echo htmlspecialchars($row['additional_info']); ?></td>
                                <td><?php echo htmlspecialchars($row['ville_dep']); ?></td>
                                <td><?php echo htmlspecialchars($row['pickup_type_dep']); ?></td>
                                <td><?php echo htmlspecialchars($row['has_coordinates_dep']); ?></td>
                                <td><?php echo htmlspecialchars($row['ville_arr']); ?></td>
                                <td><?php echo htmlspecialchars($row['pickup_type_arr']); ?></td>
                                <td><?php echo htmlspecialchars($row['has_coordinates_arr']); ?></td>
                                <td><?php echo htmlspecialchars($row['price']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                <td class="action-buttons">
                                    <a href="edit_colis.php?id=<?php echo $row['id']; ?>" class="edit-btn">Modifier</a>
                                    <a href="delete_colis.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this colis?');">Supprimer</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="18">No colis found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php $conn->close(); ?>
</body>
</html>