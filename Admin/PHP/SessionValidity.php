<?php
$db = mysqli_connect('localhost', 'root', '', 'callospa_admin_database');

// Check if session ID is set
if (isset($_SESSION['session_id'])) {
    $session_id = $_SESSION['session_id'];

    // Validate session in the database
    $query = "SELECT * FROM login_sessions WHERE session_id = ? AND expires > NOW()";
    $stmt = $db->prepare($query);
    $stmt->bind_param('s', $session_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Session is invalid
        echo 'invalid';
    } else {
        // Session is valid
        echo 'valid';
    }
} else {
    // No session, it's invalid
    echo 'invalid';
    session_destroy();
    header('Location: AdminLogin.php');
}
