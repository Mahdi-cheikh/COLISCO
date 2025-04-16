<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
    <p>This is your account page where you can manage your details.</p>

    <ul>
        <li><a href="edit-profile.php">Edit Profile</a></li>
        <li><a href="order-history.php">Order History</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>