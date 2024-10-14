<?php
session_start(); // Start the session

// Dummy credentials for demonstration (replace with real credentials in production)
$validUsername = 'admin';
$validPassword = 'password';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate credentials
    if ($username === $validUsername && $password === $validPassword) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username; // Store username in session
        header('Location: MainDashboard.php'); // Redirect to the main dashboard
        exit();
    } else {
        // Redirect with an error message
        header('Location: AdminDashboard.php?error=invalid_credentials');
        exit();
    }
} else {
    // Redirect to login page if the form was not submitted
    header('Location: AdminDashboard.php');
    exit();
}
