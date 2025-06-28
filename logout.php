<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Clear the "Remember Me" cookie
if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, "/"); // Set expiration to an hour ago
}

// Redirect to the login page
header('Location: login.php');
exit();
?>