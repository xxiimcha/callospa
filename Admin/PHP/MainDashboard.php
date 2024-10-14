<?php
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: AdminServer.php');
}

$username = $_SESSION['username'] ?? 'Guest';

if (isset($_POST['logout_user'])) {
    $_SESSION['logged_out'] = "You are now logged out";
    header('location: AdminServer.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard - Callospa Resort and Residences</title>
    <link rel="stylesheet" href="../CSS/MainDashboard.css" />
</head>

<body>
    <header class="header">
        <div class="header-content">
            <h1>Welcome, <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>!</h1>
        </div>
    </header>

    <div class="sidebar">
        <ul>
            <li><a href="Dashboard.php">Dashboard</a></li>
            <li><a href="Rooms.php">Rooms</a></li>
            <li><a href="Events.php">Events</a></li>
            <li><a href="Amenities.php">Amenities</a></li>
            <li><a href="Sales.php">Sales</a></li>
            <li><a href="Account.php">Account</a></li>
            <li><a href="ActivityLog.php">Activity Log</a></li>
        </ul>
    </div>

    <main>
        <div class="input-group">
            <button type="submit" class="btn" name="logout_user">Logout</button>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> Callospa Resort and Residences</p>
    </footer>
</body>

</html>