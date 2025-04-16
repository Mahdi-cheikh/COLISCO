<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$email = $_POST['email'];
$password = $_POST['password'];

$conn = new mysqli('localhost', 'root', '', 'colisco');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for modal
$showModal = false;
$modalMessage = "";

// Check if the email exists in the UserRegistration table
$stmt = $conn->prepare("SELECT password, first_name, last_name FROM userregistration WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verify the password
    if ($password === $user['password']) { // Use plain text comparison (not recommended for production)
        // Dynamically create user_name by concatenating first_name and last_name
        $user_name = $user['first_name'] . ' ' . $user['last_name'];

        // Store the dynamically created user_name in the session
        $_SESSION['user_name'] = $user_name;

        // Check if the user is the specific admin
        if ($email === "admin@gmail.com" && $password === "1234") {
            // Redirect to the admin dashboard
            header("Location: admin_dashboard.php");
            exit();
        }

        // Insert login data into the users table (allow duplicates)
        $insert_stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $insert_stmt->bind_param("ss", $email, $password);
        if (!$insert_stmt->execute()) {
            // If a duplicate entry error occurs, ignore it
            if ($conn->errno === 1062) { // Error code for duplicate entry
                error_log("Duplicate entry for email: $email"); // Log the error
            } else {
                // Handle other errors
                $showModal = true;
                $modalMessage = "Error: " . $insert_stmt->error;
            }
        } else {
            // Debugging: Confirm successful insertion
            error_log("User inserted successfully: $email");
        }
        $insert_stmt->close();

        if (!$showModal) {
            // Redirect to index2.php if no errors
            header("Location: index2.php");
            exit();
        }
    } else {
        // Set modal for invalid password
        $showModal = true;
        $modalMessage = "Mot de passe invalide. Veuillez réessayer.";
    }
} else {
    // Set modal for no user found
    $showModal = true;
    $modalMessage = "Aucun utilisateur trouvé avec cette adresse e-mail. Veuillez réessayer.";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Modal styles */
        #errorModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            background-color: white;
            width: 400px;
            padding: 15px;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        #errorModal p {
            font-weight: bold;
            font-size: 18px;
        }
        #errorModal button {
            margin-top: 20px;
            padding: 15px 25px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 19px;
        }
    </style>
</head>
<body>
    <!-- Modal Structure -->
    <div id="errorModal">
        <p id="modalMessage"></p>
        <button onclick="closeModal()">Retour</button>
    </div>

    <script>
        // Function to show the modal with a custom message
        function showModal(message) {
            document.getElementById('modalMessage').innerText = message;
            document.getElementById('errorModal').style.display = 'block';
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('errorModal').style.display = 'none';
            window.location.href = 'login.html'; // Redirect to login page after closing
        }

        // Show the modal if PHP sets the message
        <?php if ($showModal): ?>
        showModal("<?php echo $modalMessage; ?>");
        <?php endif; ?>
    </script>
</body>
</html>