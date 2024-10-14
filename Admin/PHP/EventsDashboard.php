<?php
require 'activity_log.php';

session_start();

include('callospa_admin_database.php');
include 'LogOut.php';

if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
  logActivity($username, "Accessed Events Dashboard Page");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <link rel="stylesheet" href="../CSS/ReservationsDashboard.css">

  <title>Callospa Resort and Residences Admin</title>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'timeGridWeek',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      navLinks: true, // can click day/week names to navigate views
      selectable: true,
      selectMirror: true,
      events: 'EventsReservations.php', // Path to your PHP script
      eventDidMount: function(info) {
        console.log('Event Mounted:', info.event); // Debug: Check the event data
      },
      eventsSet: function(events) {
        console.log('Events Set:', events); // Debug: Check the full list of events
      },
      eventClick: function(info) {
        // Populate modal with event details
        document.getElementById('modalTitle').textContent = info.event.title;
        document.getElementById('reservationId').textContent = info.event.extendedProps.reservation_id;
        document.getElementById('name').textContent = info.event.extendedProps.first_name + ' ' + info.event.extendedProps.last_name;
        document.getElementById('package').textContent = info.event.extendedProps.package;
        document.getElementById('checkIn').textContent = info.event.start.toLocaleString();
        document.getElementById('checkOut').textContent = info.event.end ? info.event.end.toLocaleString() : 'N/A';

        // Show the modal
        document.getElementById('eventModal').style.display = 'block';
      }
    });

    calendar.render();

    // Close the modal when the "X" is clicked
    var modal = document.getElementById('eventModal');
    var span = document.getElementsByClassName('close')[0];
    span.onclick = function() {
      modal.style.display = 'none';
    };

    // Close the modal if the user clicks outside of it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = 'none';
      }
    };
  });
</script>

  <style>
    body {
      margin: 40px 10px;
      padding: 0;
      font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
      font-size: 14px;
    }

    #calendar {
      max-width: 1800px;
      margin: 0 auto;
    }
    .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
  }

  .modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
    border-radius: 10px;
  }

  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
  </style>
</head>

<body>

  <?php include 'Sidebar.php'; ?>

  <section id="content">
    <main>
      <div class="head-title">
        <div class="left">
          <h1>Events Reservation Dashboard</h1>
          <ul class="links">
            <li>
              <a href="#">Event Reservation Dashboard</a>
            </li>
            <li><i class="bx bx-chevron-right"></i></li>
            <li>
            <li><a class="active" href="AdministratorPage.php">Home</a></li>
            </li>
          </ul>
        </div>
      </div>
      <div id='calendar'></div>
    </main>
  </section>
  <div id="eventModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2 id="modalTitle"></h2>
    <p><strong>Reservation ID:</strong> <span id="reservationId"></span></p>
    <p><strong>Name:</strong> <span id="name"></span></p>
    <p><strong>Package:</strong> <span id="package"></span></p>
    <p><strong>Check-In:</strong> <span id="checkIn"></span></p>
    <p><strong>Check-Out:</strong> <span id="checkOut"></span></p>
  </div>
</div>
  <script src="../JS/Sidebar.js"></script>

</body>

</html>