<?php
require_once 'collectivedb.php'; // Include your database connection functions

// Function to log the user's activity
function logActivity($username, $action) {
    $adminDb = connectToAdminDatabase(); // Connect to the database
    $stmt = $adminDb->prepare("INSERT INTO activity_logs (username, action) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $action);
    $stmt->execute();
    $stmt->close();
    $adminDb->close(); // Close the database connection
}

// Function to get the activity logs from the database
function getActivityLogs() {
    $adminDb = connectToAdminDatabase(); // Connect to the database
    $result = $adminDb->query("SELECT username, action, timestamp FROM activity_logs ORDER BY timestamp DESC");
    
    $logs = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $logs[] = $row; // Store each log in an array
        }
    }
    
    $adminDb->close(); // Close the database connection
    return $logs;
}

// Handle the POST request from JavaScript to log activity when the button is clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if username and action are set
    if (isset($_POST['username']) && isset($_POST['action'])) {
        $username = $_POST['username'];
        $action = $_POST['action'];
        logActivity($username, $action); // Log the action
        

    }
}


?>
