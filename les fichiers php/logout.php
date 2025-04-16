<?php
session_start();
session_destroy(); // Destroy the session
header("Location: index2.php"); // Redirect to the home page
exit();
?>