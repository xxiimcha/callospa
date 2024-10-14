<?php
session_start();
require 'activity_log.php'; // Include activity log functions

// Log a specific activity (e.g., opening a page)
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    logActivity($username, "Accessed " . basename($_SERVER['PHP_SELF'])); // Log the page opened
}

?>
