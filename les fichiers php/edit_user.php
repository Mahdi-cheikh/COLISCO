<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'colisco');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the user's current details
    $stmt = $conn->prepare("SELECT * FROM userregistration WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['user_id'];
    $user_type = $_POST['user_type'];
    $user_profile = $_POST['user_profile'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birth_date = $_POST['birth_date'];
    $nationality = $_POST['nationality'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];
    $referral_code = $_POST['referral_code'];
    $accepts_terms = isset($_POST['accepts_terms']) ? 1 : 0;
    $accepts_newsletter = isset($_POST['accepts_newsletter']) ? 1 : 0;

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'colisco');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the user's details
    $stmt = $conn->prepare("UPDATE userregistration SET user_type = ?, user_profile = ?, first_name = ?, last_name = ?, birth_date = ?, nationality = ?, email = ?, password = ?, phone_number = ?, referral_code = ?, accepts_terms = ?, accepts_newsletter = ? WHERE user_id = ?");
    $stmt->bind_param("ssssssssssiii", $user_type, $user_profile, $first_name, $last_name, $birth_date, $nationality, $email, $password, $phone_number, $referral_code, $accepts_terms, $accepts_newsletter, $id);
    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error updating user: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="checkbox"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="checkbox"] {
            width: auto;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
        }
        button:hover {
            background-color: #0056b3;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>Edit User</h1>
    <form method="POST">
        <input type="hidden" name="user_id" value="<?php echo $id; ?>">

        <div class="form-group">
            <label for="user_type">User Type:</label>
            <input type="text" name="user_type" id="user_type" value="<?php echo htmlspecialchars($user['user_type']); ?>" required>
        </div>

        <div class="form-group">
            <label for="user_profile">User Profile:</label>
            <input type="text" name="user_profile" id="user_profile" value="<?php echo htmlspecialchars($user['user_profile']); ?>" required>
        </div>

        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="birth_date">Birth Date:</label>
            <input type="date" name="birth_date" id="birth_date" value="<?php echo htmlspecialchars($user['birth_date']); ?>" required>
        </div>

        <div class="form-group">
            <label for="nationality">Nationality:</label>
            <input type="text" name="nationality" id="nationality" value="<?php echo htmlspecialchars($user['nationality']); ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="text" name="password" id="password" value="<?php echo htmlspecialchars($user['password']); ?>" required>
        </div>

        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" id="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
        </div>

        <div class="form-group">
            <label for="referral_code">Referral Code:</label>
            <input type="text" name="referral_code" id="referral_code" value="<?php echo htmlspecialchars($user['referral_code']); ?>">
        </div>

        <div class="form-group">
            <label for="accepts_terms">Accepts Terms:</label>
            <input type="checkbox" name="accepts_terms" id="accepts_terms" <?php echo $user['accepts_terms'] ? 'checked' : ''; ?>>
        </div>

        <div class="form-group">
            <label for="accepts_newsletter">Accepts Newsletter:</label>
            <input type="checkbox" name="accepts_newsletter" id="accepts_newsletter" <?php echo $user['accepts_newsletter'] ? 'checked' : ''; ?>>
        </div>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>