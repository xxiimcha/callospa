<?php
// Include database connection and start session
include 'callospa_admin_database.php';

// Initialize user ID to null and get the username from session
$id = null;
$username = $_SESSION['username'] ?? null;

if ($username) {
  try {
    // Prepare statement and fetch user id
    $query = "SELECT id FROM admin1 WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
      $user = $result->fetch_assoc();
      $id = $user['id'];
    }
    $stmt->close();
  } catch (Exception $e) {
    error_log("Error retrieving user ID: " . $e->getMessage());
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  
<head>
  <link rel="stylesheet" href="../CSS/Sidebar.css" />
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
<section id="sidebar">
    <ul>
      <li>
        <span class="logo">Callospa Resort</span>
        <button onclick=toggleSidebar() id="toggle-btn"><i class="bx bx-menu"></i></button>
      </li>
      <li>
        <a href="AdministratorPage.php"><i class="bx bxs-dashboard"></i><span>Dashboard</span></a>
      </li>
      </li>
      <li>
        <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <i class="bx bxs-book-open"></i>
          <span>Reservations</span>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="RoomsDashboard.php"><i class="bx bxs-bed"></i><span>Room Reservations</span></a></li>
            <li><a href="EventsDashboard.php"><i class="bx bxs-calendar-check"></i><span>Event Reservations</span></a></li>
            <li><a href="AmenitiesDashboard.php"><i class="bx bxs-bath"></i><span>Spa Reservations</span></a></li>
          </div>
        </ul>
      </li>

      <li>
        <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <i class="bx bxs-dollar-circle"></i>
          <span>Sales</span>
        </button>
          <ul class="sub-menu">
            <div>
              <li><a href="RoomsSales.php"><i class="bx bxs-bed"></i><span>Room Sales</span></a></li>
              <li><a href="EventsSales.php"><i class="bx bxs-calendar-check"></i><span>Event Sales</span></a></li>
              <li><a href="AmenitiesSales.php"><i class="bx bxs-bath"></i><span>Spa Sales</span></a></li>
            </div>
          </ul>
      </li>

      <li>
        <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <i class="bx bxs-cog"></i>
          <span>Manage</span>
        </button>
          <ul class="sub-menu">
            <div>
              <?php if ($id === 0): ?>
              <li><a href="ManageUsers.php"><i class="bx bxs-user"></i><span>Manage Users</span></a></li> 
              <?php endif; ?>
              <li><a href="ManageRooms.php"><i class="bx bxs-bed"></i><span>Manage Rooms</span></a></li>
              <li><a href="ManageEvents.php"><i class="bx bxs-calendar-check"></i><span>Manage Events</span></a></li>
              <li><a href="ManageAmenities.php"><i class="bx bxs-bath"></i><span>Manage Amenities</span></a></li>
              <li><a href="ManagePackages.php"><i class="bx bxs-package"></i><span>Manage Packages</span></a></li>
            </div>
          </ul>
      </li>

      <?php if ($id === 0): ?>
      <li><a href="AccountDashboard.php"><i class="bx bxs-user-circle"></i><span>Account</span></a></li>
      <li><a href="ActivityLogDashboard.php"><i class="bx bxs-book-content"></i><span>Activity Log</span></a></li>
      <li><a href="ArchiveDashboard.php"><i class="bx bxs-archive"></i><span>Archive</span></a></li>
      <?php endif; ?>

      <li>
        <form method="POST" action="">
          <button class="dropdown-btn" type="submit" name="logout_user">
            <i class="bx bxs-log-out-circle"></i>
            <span>Logout</span>
          </button>
        </form>
      </li>
    </ul>
</section>
</body>

</html>
