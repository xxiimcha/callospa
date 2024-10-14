<?php
require 'collectivedb.php'; // Include your database connection functions
require 'archiving.php'; // Include the archiving functions
require 'activity_log.php'; // Include activity log functions

session_start();

if (isset($_SESSION['username'])) {
    echo "<script>var username = '" . $_SESSION['username'] . "';</script>";
} else {
    echo "<script>var username = '';</script>";
}

// Log when the archive page is accessed
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    logActivity($username, "Accessed Archive Page");
}

// Function to check if archive directory is empty
function isArchiveDirectoryEmpty($dir) {
    if (!is_readable($dir)) return false; // Directory doesn't exist or isn't readable
    return (count(scandir($dir)) == 2); // 2 items = '.' and '..' meaning it's empty
}

// Check if it's the start of the quarter
function isQuarterStart() {
    $currentMonth = date('n'); // Get the current month (1-12)
    $currentDay = date('j');    // Get the current day of the month

    // Check if it's the 1st day of January, April, July, or October
    return ($currentDay == 1 && in_array($currentMonth, [1, 4, 7, 10]));
}

// Check if the quarter has already been archived
function hasAlreadyArchivedThisQuarter($adminDb) {
    // Get the last archived date
    $result = $adminDb->query("SELECT MAX(archived_on) as last_archived FROM archived_files");
    $row = $result->fetch_assoc();
    $lastArchived = $row['last_archived'];

    // If there is no record, return false
    if (!$lastArchived) {
        return false;
    }

    // Check if last archived date is in the current quarter
    $lastArchivedDate = new DateTime($lastArchived);
    $currentQuarterStart = new DateTime();
    $currentQuarterStart->setDate((int)$currentQuarterStart->format('Y'), (int)(ceil($currentQuarterStart->format('n') / 3) * 3 - 2), 1);

    return $lastArchivedDate >= $currentQuarterStart;
}

// Establish connection to the admin database
$adminDb = connectToAdminDatabase();

$archiveDir = 'archives'; // Specify your archive directory

// Check if the directory is empty and archive if needed
if (isArchiveDirectoryEmpty($archiveDir)) {
    $archivedFileName = archiveData(); // Automatically archive data
    logActivity($username, "Auto Archived Data (Directory Empty)");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['archive'])) {
        $archivedFileName = archiveData(); // Call the function to archive data
        
        // Log the activity
        logActivity($username, "Manually Archived Data");

        // Redirect to avoid form resubmission on page refresh
        header('Location: archivedashboard.php');
        exit();
    }
}


// Auto-archive if it's the start of a new quarter and hasn't been archived yet
if (isQuarterStart() && !hasAlreadyArchivedThisQuarter($adminDb)) {
    $archivedFileName = archiveData(); // Automatically archive data if not already done this quarter
} 

// LOGOUT
include 'LogOut.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../CSS/ArchiveDashboard.css">
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
                    <h1>Archive</h1>
                    <ul class="links">
                        <li><a href="#">Archive</a></li>
                        <li><i class="bx bx-chevron-right"></i></li>
                        <li><a class="active" href="AdministratorPage.php">Home</a></li>
                    </ul>
                </div>
                <div class="manual-archive">
                    <form id="manualArchiveForm" method="post" action="archivedashboard.php">
                        <input type="submit" name="archive" value="Manually Archive Data">
                     </form>
                </div>
            </div>
            <div class="table-data">
                <div class="archives">
                    <div class="head">
                        <h3>Archive</h3>
                    </div>
                    <table border="1" cellpadding="10" cellspacing="0" class="table">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Archived On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch archived files from the database
                            $result = $adminDb->query("SELECT file_name, archived_on FROM archived_files ORDER BY archived_on DESC");

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $fileName = htmlspecialchars($row['file_name']);
                                    $archivedOn = htmlspecialchars($row['archived_on']);
                                    echo "<tr>";
                                    echo "<td>$fileName</td>";
                                    echo "<td>$archivedOn</td>";
                                    echo "<td><a href='download.php?file=" . urlencode($fileName) . "' onclick='logDownloadActivity(\"$fileName\")'><button class='download-btn'>Download</button></a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>No archived files found.</td></tr>";
                            }

                            $adminDb->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </section>
    <script src="../JS/Sidebar.js"></script>
    <script>
        var username = "<?php echo $_SESSION['username']; ?>";
    </script>
    <script src="../JS/ArchiveDashboard.js"></script>
</body>

</html>
