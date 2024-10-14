<?php
require_once 'collectivedb.php'; // Include your database connection functions
require 'activity_log.php';  // Include the activity log functions

session_start();
include 'LogOut.php'; 
// Fetch activity logs from the database
$adminDb = connectToAdminDatabase();
// session_unset();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../CSS/ActivityLogDashboard.css">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php include 'Sidebar.php'; ?>

    <!-- CONTENT -->
    <section id="content">

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Activity Log</h1>
                    <ul class="links">
                        <li><a href="#">Activity Log</a></li>
                        <li><i class="bx bx-chevron-right"></i></li>
                        <li><a class="active" href="AdministratorPage.php">Home</a></li>
                    </ul>
                </div>
            </div>
            <div class="table-data">
                <div class="activity-log">
                    <div class="head">
                        <h3>Recent Activities</h3>
                    </div>

                    <table border="1" cellpadding="10" cellspacing="0" class="table">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Action</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $adminDb->query("SELECT username, action, timestamp FROM activity_logs ORDER BY timestamp DESC");
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $username = htmlspecialchars($row['username']);
                                    $action = htmlspecialchars($row['action']);
                                    $timestamp = htmlspecialchars($row['timestamp']);
                                    echo "<tr>";
                                    echo "<td>$username</td>";
                                    echo "<td>$action</td>";
                                    echo "<td>$timestamp</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>No activities found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </section>

    <script src="../JS/Sidebar.js"></script>
</body>

</html>

<?php
$adminDb->close();
?>
