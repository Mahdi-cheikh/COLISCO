<?php
session_start(); // Start the session

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = htmlspecialchars($_POST['comment']);
    $commenter_name = htmlspecialchars($_POST['commenter_name']);
    $profile_user_name = htmlspecialchars($_POST['profile_user_name']);
    $rating = intval($_POST['rating']); // Get the star rating

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "colisco");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the comment and rating into the database
    $sql = "INSERT INTO comments (user_name, commenter_name, comment, rating) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $profile_user_name, $commenter_name, $comment, $rating);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // Refresh the page to show the new comment
    header("Location: " . $_SERVER['PHP_SELF'] . "?user_name=" . urlencode($profile_user_name));
    exit;
}

// Check if 'user_name' is passed in the URL
if (isset($_GET['user_name'])) {
    $user_name = htmlspecialchars($_GET['user_name']); // Sanitize the input
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 700px;
            width: 90%;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .header h1 {
            font-size: 32px;
            margin: 0;
            color: #333;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .details {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
            text-align: left;
        }

        .details p {
            margin: 10px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .details p strong {
            color: #333;
        }

        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 20px;
            border: none;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 20px;
            }

            .header h1 {
                font-size: 28px;
            }

            .details {
                font-size: 14px;
            }

            .button {
                font-size: 14px;
                padding: 10px 20px;
            }
        }

        .comments-section {
            margin-top: 30px;
            text-align: left;
        }

        .comments-section h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
            font-weight: bold;
            text-align: center;
        }

        .comments-list {
            display: flex; /* Make the comments list horizontal */
            flex-direction: row; /* Ensure horizontal layout */
            gap: 15px; /* Add spacing between comments */
            overflow-x: auto; /* Enable horizontal scrolling */
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .comments-list::-webkit-scrollbar {
            height: 8px; /* Height of the horizontal scrollbar */
        }

        .comments-list::-webkit-scrollbar-thumb {
            background-color: #ccc; /* Color of the scrollbar thumb */
            border-radius: 4px;
        }

        .comments-list::-webkit-scrollbar-thumb:hover {
            background-color: #aaa; /* Darker color on hover */
        }

        .comment {
            min-width: 250px; /* Ensure each comment has a fixed width */
            background-color: #ffffff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .comment:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .comment p {
            margin: 5px 0;
            color: #555;
            font-size: 14px;
            line-height: 1.6;
        }

        .comment .stars {
            font-size: 18px;
            color: #f5c518;
            margin-bottom: 5px;
        }

        .comment .timestamp {
            font-size: 12px;
            color: #888;
            text-align: right;
            margin-top: 10px;
        }

        .comment strong {
            color: #333;
            font-weight: bold;
        }

        .comment-form .form-group {
            margin-bottom: 20px;
        }

        .comment-form label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        .comment-form input,
        .comment-form textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .comment-form input:focus,
        .comment-form textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        .comment-form button {
            display: inline-block;
            padding: 12px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .comment-form button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .rating {
            display: flex;
            flex-direction: row; /* Change to row for horizontal layout */
            justify-content: center; /* Center the stars horizontally */
            gap: 5px; /* Add spacing between stars */
            margin-top: 10px;
        }

        .rating input {
            display: none; /* Hide the radio buttons */
        }

        .rating label {
            font-size: 24px;
            color: #ddd;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .rating input:checked ~ label {
            color: #f5c518; /* Highlight selected stars */
        }

        .rating label:hover,
        .rating label:hover ~ label {
            color: #f5c518; /* Highlight stars on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Profile Utilisateur</h1>
        </div>
        <div class="details">
            <?php
            if (isset($user_name)) {
                // Connect to the database
                $conn = new mysqli("localhost", "root", "", "colisco");

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch user details based on first_name and last_name
                $name_parts = explode(' ', $user_name, 2);
                $first_name = $name_parts[0] ?? '';
                $last_name = $name_parts[1] ?? '';
                $sql = "SELECT first_name, last_name, email, phone_number FROM userregistration WHERE first_name = ? AND last_name = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $first_name, $last_name);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    echo "<p><strong>Prénom:</strong> " . htmlspecialchars($user['first_name']) . "</p>";
                    echo "<p><strong>Nom:</strong> " . htmlspecialchars($user['last_name']) . "</p>";
                    echo "<p><strong>Email:</strong> " . htmlspecialchars($user['email']) . "</p>";
                    echo "<p><strong>Numéro de téléphone:</strong> " . htmlspecialchars($user['phone_number']) . "</p>";
                } else {
                    echo "<p>Utilisateur introuvable.</p>";
                }

                $stmt->close();
                $conn->close();
            } else {
                echo "<p>Aucun utilisateur sélectionné.</p>";
            }
            ?>
        </div>
        <div class="comments-section">
            <h2>Commentaires</h2>
            <div class="comments-list">
                <?php
                if (isset($user_name)) {
                    // Connect to the database
                    $conn = new mysqli("localhost", "root", "", "colisco");

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch comments for the profile
                    $sql = "SELECT commenter_name, comment, rating, created_at FROM comments WHERE user_name = ? ORDER BY created_at DESC";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $user_name);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($comment = $result->fetch_assoc()) {
                            echo "<div class='comment'>";
                            echo "<p><strong>" . htmlspecialchars($comment['commenter_name']) . ":</strong> " . htmlspecialchars($comment['comment']) . "</p>";
                            echo "<p class='stars'>";
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $comment['rating']) {
                                    echo "★"; // Filled star
                                } else {
                                    echo "☆"; // Empty star
                                }
                            }
                            echo "</p>";
                            echo "<p class='timestamp'>" . htmlspecialchars($comment['created_at']) . "</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Aucun commentaire pour ce profil.</p>";
                    }

                    $stmt->close();
                    $conn->close();
                }
                ?>
            </div>
            <form method="POST" class="comment-form">
                <input type="hidden" name="profile_user_name" value="<?php echo htmlspecialchars($user_name); ?>">
                <div class="form-group">
                    <label for="commenter_name">Votre nom:</label>
                    <input type="text" id="commenter_name" name="commenter_name" required>
                </div>
                <div class="form-group">
                    <label for="comment">Votre commentaire:</label>
                    <textarea id="comment" name="comment" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="rating">Votre note:</label>
                    <div class="rating">
                        <input type="radio" id="star5" name="rating" value="5"><label for="star5" title="5 étoiles">★</label>
                        <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="4 étoiles">★</label>
                        <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="3 étoiles">★</label>
                        <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="2 étoiles">★</label>
                        <input type="radio" id="star1" name="rating" value="1"><label for="star1" title="1 étoile">★</label>
                    </div>
                </div>
                <button type="submit" class="button">Envoyer</button>
            </form>
        </div>
    </div>
</body>
</html>