<?php
require 'archiving.php';
require 'activity_log.php';
session_start();

// Initializing variables
$username = "";
$errors = array();

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'callospa_admin_database');

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// LOGIN USER
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        // Prepare the query to prevent SQL injection
        $query = "SELECT * FROM admin1 WHERE username = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // Verify the password against the hashed password
            if (password_verify($password, $user['password'])) {
                // Check if the user is already logged in (i.e., they have an active session)
                $check_session_query = "SELECT * FROM login_sessions WHERE user_id = ? AND expires > NOW()";
                $check_stmt = $db->prepare($check_session_query);
                $check_stmt->bind_param('s', $username);
                $check_stmt->execute();
                $check_result = $check_stmt->get_result();

                if ($check_result->num_rows > 0) {
                    // User is already logged in, don't allow a new login
                    array_push($errors, "This user is already logged in. Please log out first.");
                } else {
                    // User is not logged in, proceed with login

                    // Set session variables
                    $_SESSION['username'] = $username;
                    $_SESSION['logged_in'] = true;

                    // Generate a session ID and store session details in the database
                    $user_id = $username;
                    $session_id = bin2hex(random_bytes(16));
                    $ip_address = $_SERVER['REMOTE_ADDR'];
                    $user_agent = $_SERVER['HTTP_USER_AGENT'];
                    $login_time = date('Y-m-d H:i:s');
                    $expires = date('Y-m-d H:i:s', strtotime('+1 hour')); // 1-hour session

                    $session_query = "INSERT INTO login_sessions (user_id, session_id, ip_address, user_agent, login_time, expires) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $db->prepare($session_query);
                    $stmt->bind_param('ssssss', $user_id, $session_id, $ip_address, $user_agent, $login_time, $expires);
                    $stmt->execute();

                    // Set the session ID in the user's session
                    $_SESSION['session_id'] = $session_id;

                    // Redirect to Administrator Page
                    header('location: AdministratorPage.php');
                    exit(); // Stop script execution
                }

                $check_stmt->close();
            } else {
                array_push($errors, "Wrong username/password combination");
            }
        } else {
            array_push($errors, "Wrong username/password combination");
        }

        $stmt->close();
    }
}

// SESSION VALIDATION
if (isset($_SESSION['session_id'])) {
    $session_id = $_SESSION['session_id'];

    // Validate session: check if it exists and hasn't expired
    $query = "SELECT * FROM login_sessions WHERE session_id = ? AND expires > NOW()";
    $stmt = $db->prepare($query);
    $stmt->bind_param('s', $session_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Session is invalid or expired, redirect to login page
        header('location: AdminLogin.php');
        exit(); // Stop script execution
    }

    $stmt->close();
}
?>
