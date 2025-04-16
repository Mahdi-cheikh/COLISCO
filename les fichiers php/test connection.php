<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'colisco';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully to the database!";
}

$conn->close();
?>