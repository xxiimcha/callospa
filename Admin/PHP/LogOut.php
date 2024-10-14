<?php
$db = mysqli_connect('localhost', 'root', '', 'callospa_admin_database');
if (isset($_POST['logout_user'])) {
  // Check if session ID is available
  if (isset($_SESSION['session_id'])) {
    $session_id = $_SESSION['session_id'];
    $query = "DELETE FROM login_sessions WHERE session_id='$session_id'";
    if (!mysqli_query($db, $query)) {
      echo "Error: " . mysqli_error($db);
    }

    // Clear cookies
    setcookie("user", "", time() - 3600, "/"); // Expire cookie
    setcookie(session_name(), "", time() - 3600, "/"); // Expire session cookie

    // End session
    session_unset();
    session_destroy();

    // Redirect to login page
    header("Location: AdminLogin.php");
    exit();
  } else {
    // Handle case where session ID is not set
    header("Location: AdminLogin.php");
    exit();
  }
}
