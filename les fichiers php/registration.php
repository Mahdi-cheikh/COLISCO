<?php
$userType = $_POST['type'];
$userProfile = $_POST['profile'];
$firstName = $_POST['prenom'];
$lastName = $_POST['nom'];
$birthDate = $_POST['date_naissance'];
$nationality = $_POST['nationalite'];
$email = $_POST['email'];
$password = $_POST['password'];
$phoneNumber = $_POST['telephone'];
$referralCode = $_POST['code_parrainage'] ?? null;
$acceptsTerms = isset($_POST['conditions']) ? 1 : 0;
$acceptsNewsletter = isset($_POST['newsletter']) ? 1 : 0;




$conn = new mysqli('localhost','root', '', 'colisco');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO Userregistration (user_type, user_profile, first_name, last_name, birth_date, nationality, email, password, phone_number, referral_code, accepts_terms, accepts_newsletter) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssii", $userType, $userProfile, $firstName, $lastName, $birthDate, $nationality, $email, $password, $phoneNumber, $referralCode, $acceptsTerms, $acceptsNewsletter);

    if ($stmt->execute()) {
        // Registration successful, redirect to login.html
        header("Location: login.html");
        exit();
    } else {
        // Handle errors during registration
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>