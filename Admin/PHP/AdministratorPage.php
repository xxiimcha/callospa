<?php
require 'activity_log.php';
session_start(); // Start the session
include 'SessionValidity.php';
include 'update_reservation_status.php';

$resort_conn = connectToResortDatabase();
$admin_conn = connectToAdminDatabase();

// Log activity
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
  logActivity($username, "Accessed Administrator Page");
}

// Fetch number of approved room reservations
$approvedRoomCountQuery = "SELECT COUNT(*) AS booked_rooms FROM approved_reservations WHERE reservation_type = 'Room'";
$roomResult = $admin_conn->query($approvedRoomCountQuery);
$booked_rooms = 0;
if ($roomResult->num_rows > 0) {
  $row = $roomResult->fetch_assoc();
  $booked_rooms = $row['booked_rooms'];
}

// Fetch number of approved event reservations
$approvedEventCountQuery = "SELECT COUNT(*) AS booked_events FROM approved_reservations WHERE reservation_type = 'Event'";
$eventResult = $admin_conn->query($approvedEventCountQuery);
$booked_events = 0;
if ($eventResult->num_rows > 0) {
  $row = $eventResult->fetch_assoc();
  $booked_events = $row['booked_events'];
}

// Fetch number of approved amenity reservations
$approvedAmenityCountQuery = "SELECT COUNT(*) AS booked_amenities FROM approved_reservations WHERE reservation_type = 'Amenity'";
$amenityResult = $admin_conn->query($approvedAmenityCountQuery);
$booked_amenities = 0;
if ($amenityResult->num_rows > 0) {
  $row = $amenityResult->fetch_assoc();
  $booked_amenities = $row['booked_amenities'];
}

// Rooms Total Deposit of approved reservations
$sql_room = "SELECT SUM(deposit_amount) AS total_room_deposit FROM approved_reservations WHERE reservation_type = 'Room'";
$result_room = $admin_conn->query($sql_room);
$total_room_deposit = 0;
if ($result_room->num_rows > 0) {
  $row = $result_room->fetch_assoc();
  $total_room_deposit = $row['total_room_deposit'];
}

// Event Total Deposit of approved reservations
$sql_event = "SELECT SUM(deposit_amount) AS total_event_deposit FROM approved_reservations WHERE reservation_type = 'Event'";
$result_event = $admin_conn->query($sql_event);
$total_event_deposit = 0;
if ($result_event->num_rows > 0) {
  $row = $result_event->fetch_assoc();
  $total_event_deposit = $row['total_event_deposit'];
}

// Amenity Total Deposit of approved reservations
$sql_amenity = "SELECT SUM(deposit_amount) AS total_amenity_deposit FROM approved_reservations WHERE reservation_type = 'Amenity'";
$result_amenity = $admin_conn->query($sql_amenity);
$total_amenity_deposit = 0;
if ($result_amenity->num_rows > 0) {
  $row = $result_amenity->fetch_assoc();
  $total_amenity_deposit = $row['total_amenity_deposit'];
}

// Total Deposit Calculation
$total_sales = $total_room_deposit + $total_event_deposit + $total_amenity_deposit;

// Fetch room reservations
$roomQuery = "
    SELECT 
        reservation_id, 
        first_name, 
        middle_name, 
        last_name, 
        contact_number, 
        email, 
        handle, 
        sources, 
        source_other, 
        room, 
        check_in_date, 
        check_out_date, 
        check_in_time, 
        check_out_time, 
        guests, 
        additional_guest, 
        total_cost, 
        deposit_amount, 
        remaining_balance, 
        payment_method, 
        proof_of_payment, 
        reservation_date,
        'Room' AS reservation_type
    FROM 
        pending_room_reservations
";
$roomResults = $conn->query($roomQuery);
$roomReservations = [];
if ($roomResults->num_rows > 0) {
  while ($row = $roomResults->fetch_assoc()) {
    $roomReservations[] = $row;
  }
}

// Fetch event reservations
$eventQuery = "
    SELECT 
        reservation_id, 
        first_name, 
        middle_name, 
        last_name, 
        contact_number, 
        email, 
        handle, 
        sources, 
        source_other, 
        package_category, 
        package, 
        event_type, 
        check_in_date, 
        check_out_date, 
        check_in_time, 
        check_out_time, 
        guests, 
        additional_guest, 
        catering_preference, 
        total_cost, 
        deposit_amount, 
        remaining_balance, 
        payment_method, 
        proof_of_payment, 
        reservation_date,
        'Event' AS reservation_type
    FROM 
        pending_event_reservations
";
$eventResults = $conn->query($eventQuery);
$eventReservations = [];
if ($eventResults->num_rows > 0) {
  while ($row = $eventResults->fetch_assoc()) {
    $eventReservations[] = $row;
  }
}

// Fetch amenity reservations
$amenityQuery = "
    SELECT 
        reservation_id, 
        first_name, 
        middle_name, 
        last_name, 
        contact_number, 
        email, 
        handle, 
        sources, 
        source_other, 
        package_category, 
        package, 
        check_in_date, 
        check_in_time, 
        check_out_time, 
        guests, 
        total_cost, 
        deposit_amount, 
        remaining_balance, 
        payment_method, 
        proof_of_payment, 
        reservation_date,
        'Amenity' AS reservation_type
    FROM 
        pending_amenity_reservations
";
$amenityResults = $conn->query($amenityQuery);
$amenityReservations = [];
if ($amenityResults->num_rows > 0) {
  while ($row = $amenityResults->fetch_assoc()) {
    $amenityReservations[] = $row;
  }
}

// Fetch package reservations
$packageQuery = "
    SELECT 
        reservation_id, 
        first_name, 
        middle_name, 
        last_name, 
        contact_number, 
        email, 
        handle, 
        sources, 
        source_other, 
        package, 
        check_in_date, 
        check_out_date, 
        check_in_time, 
        check_out_time, 
        guests, 
        additional_guest, 
        total_cost, 
        deposit_amount, 
        remaining_balance, 
        payment_method, 
        proof_of_payment, 
        reservation_date,
        'Package' AS reservation_type
    FROM 
        pending_package_reservations
";
$packageResults = $conn->query($packageQuery);
$packageReservations = [];
if ($packageResults->num_rows > 0) {
  while ($row = $packageResults->fetch_assoc()) {
    $packageReservations[] = $row;
  }
}

// Combine all results
$combinedResults = array_merge($roomReservations, $eventReservations, $amenityReservations, $packageReservations);

// LOGOUT section
include 'callospa_admin_database.php'; // $db for admin tasks
$db = mysqli_connect('localhost', 'root', '', 'callospa_admin_database');
if (isset($_POST['logout_user'])) {
  if (isset($_SESSION['session_id'])) {
    $session_id = $_SESSION['session_id'];
    $query = "DELETE FROM login_sessions WHERE session_id='$session_id'";
    if (!mysqli_query($db, $query)) {
      echo "Error: " . mysqli_error($db);
    }

    // Clear cookies
    setcookie("user", "", time() - 3600, "/");
    setcookie(session_name(), "", time() - 3600, "/");

    // End session
    session_unset();
    session_destroy();

    // Redirect to login page
    header("Location: AdminLogin.php");
    exit();
  } else {
    header("Location: AdminLogin.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <!-- My CSS -->
  <link rel="stylesheet" href="../CSS/AdministratorPage.css" />

  <title>Callospa Resort and Residences Admin</title>

</head>

<body>
  <?php include 'Sidebar.php'; ?>
  <!-- CONTENT -->
  <section id="content">
    <main>
      <div class="head-title">
        <div class="left">
          <h1>Dashboard</h1>
          <ul class="breadcrumb">
            <li>
              <a href="#">Dashboard</a>
            </li>
            <li><i class="bx bx-chevron-right"></i></li>
            <li>
              <a class="active" href="#">Home</a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Summary -->
      <ul class="box-info">
        <li>
          <a href="RoomsDashboard.php">
            <i class="bx bxs-calendar-check"></i>
            <span class="text">
              <h3><?php echo htmlspecialchars($booked_rooms, ENT_QUOTES, 'UTF-8'); ?></h3>
              <p>Rooms Booked</p>
            </span>
          </a>
        </li>
        <li>
          <a href="EventsDashboard.php">
            <i class="bx bxs-calendar-check"></i>
            <span class="text">
              <h3><?php echo htmlspecialchars($booked_events, ENT_QUOTES, 'UTF-8'); ?></h3>
              <p>Events Booked</p>
            </span>
          </a>
        </li>
        <li>
          <a href="AmenitiesDashboard.php">
            <i class="bx bxs-calendar-check"></i>
            <span class="text">
              <h3><?php echo htmlspecialchars($booked_amenities, ENT_QUOTES, 'UTF-8'); ?></h3>
              <p>Amenities Booked</p>
            </span>
          </a>
        </li>
        <li>
          <a href="SalesDashboard.php">
            <i class="bx bxs-dollar-circle"></i>
            <span class="text">
              <h3>₱ <?php echo number_format($total_sales, 2); ?></h3>
              <p>Total Sales</p>
            </span>
          </a>
        </li>
      </ul>
      <!-- Summary End -->

      <!-- Table Data -->
      <div class="table-data">
        <div class="order">
          <div class="head">
            <h3>Incoming Bookings</h3>
          </div>
          <table>
            <thead>
              <tr>
                <th>Name</th>
                <th>Reservation Type</th>
                <th>Reservation ID</th>
                <th>Reservation Date</th>
                <th>Check-in Date</th>
                <th>Check-out Date</th>
                <th>Check-in Time</th>
                <th>Check-out Time</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Handle</th>
                <th>Source</th>
                <th>Source Other</th>
                <th>Room/Event/Amenity/Package</th>
                <th>Guests</th>
                <th>Additional Guests</th>
                <th>Catering Preference</th>
                <th>Total Cost</th>
                <th>Deposit Amount</th>
                <th>Remaining Balance</th>
                <th>Payment Method</th>
                <th>Proof of Payment</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($combinedResults as $row): ?>
                <tr>
                  <td>
                    <?php
                    $firstName = htmlspecialchars($row['first_name']);
                    $middleName = htmlspecialchars($row['middle_name']);
                    $lastName = htmlspecialchars($row['last_name']);
                    echo !empty($middleName) ? $firstName . ' ' . $middleName . ' ' . $lastName : $firstName . ' ' . $lastName;
                    ?>
                  </td>
                  <td><?php echo htmlspecialchars($row['reservation_type']); ?></td>
                  <td><?php echo htmlspecialchars($row['reservation_id']); ?></td>
                  <td><?php echo htmlspecialchars($row['reservation_date']); ?></td>
                  <td><?php echo htmlspecialchars($row['check_in_date']); ?></td>
                  <td><?php echo htmlspecialchars($row['check_out_date'] ?? 'N/A'); ?></td>
                  <td><?php echo htmlspecialchars($row['check_in_time']); ?></td>
                  <td><?php echo htmlspecialchars($row['check_out_time']); ?></td>
                  <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
                  <td><?php echo htmlspecialchars($row['email']); ?></td>
                  <td><?php echo htmlspecialchars($row['handle']); ?></td>
                  <td><?php echo htmlspecialchars($row['sources']); ?></td>
                  <td><?php echo htmlspecialchars($row['source_other']); ?></td>
                  <td><?php echo htmlspecialchars($row['room'] ?? $row['package'] ?? $row['package_category']); ?></td> <!-- Room/Event/Amenity/Package -->
                  <td><?php echo htmlspecialchars($row['guests']); ?></td>
                  <td><?php echo htmlspecialchars($row['additional_guest'] ?? 'N/A'); ?></td>
                  <td><?php echo htmlspecialchars($row['catering_preference'] ?? 'N/A'); ?></td>
                  <td><?php echo htmlspecialchars($row['total_cost']); ?></td>
                  <td><?php echo htmlspecialchars($row['deposit_amount']); ?></td>
                  <td><?php echo htmlspecialchars($row['remaining_balance']); ?></td>
                  <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                  <td><a href="../../ProofOfPayment/<?php echo htmlspecialchars($row['proof_of_payment']); ?>" target="_blank" style="color: #007BFF; text-decoration: none;"><?php echo htmlspecialchars($row['proof_of_payment']); ?></a></td>
                  <td>
                    <form method="post" action="update_reservation_status.php">
                      <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($row['reservation_id']); ?>">
                      <input type="hidden" name="reservation_type" value="<?php echo htmlspecialchars($row['reservation_type']); ?>">
                      <button type="submit" name="action" value="approve" class="btn-approve">Approve</button>
                      <button type="submit" name="action" value="decline" class="btn-decline">Decline</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- Table Data End -->
    </main>
  </section>

  <script src="../JS/AdministratorPage.js"></script>
  <script src="../JS/Sidebar.js"></script>
</body>

</html>