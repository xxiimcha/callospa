<?php
include 'callospa_resort_database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $packageCategory = $_POST['package_category'];
    $package = $_POST['package'];
    $selectedDate = $_POST['selected_date'];

    // Escape input to prevent SQL injection
    $packageCategory = mysqli_real_escape_string($conn, $packageCategory);
    $package = mysqli_real_escape_string($conn, $package);
    $selectedDate = mysqli_real_escape_string($conn, $selectedDate);

    // SQL to get all bookings for the selected date
    $sql = "SELECT check_in_time, package
            FROM pending_amenity_reservations
            WHERE check_in_date = '$selectedDate'";

    $result = mysqli_query($conn, $sql);

    $bookedTimes = [];
    $availableTimes = generateAvailableTimes(); // Generate available times

    // Check all bookings for the selected date
    while ($row = mysqli_fetch_assoc($result)) {
        $checkInTime = $row['check_in_time'];
        $bookedPackage = $row['package'];

        // Convert check_in_time from 24-hour format with seconds to 12-hour format without seconds
        $checkInTimeFormatted = DateTime::createFromFormat('H:i:s', $checkInTime)->format('h:i A');

        // Debugging: log the converted check-in time
        error_log("Check-In Time (Formatted): $checkInTimeFormatted, Booked Package: $bookedPackage");

        // If the package matches the selected one, mark the time as booked
        if ($bookedPackage === $package) {
            $bookedTimes[] = $checkInTimeFormatted;
        }
    }


    // Determine if all times for the selected package are booked
    $allTimesBooked = count($bookedTimes) >= count($availableTimes);

    // Disable the date if all times are booked
    $dateStatus = $allTimesBooked ? 'disabled' : 'enabled';

    // Return the available times and the status of the date
    echo json_encode([
        'dateStatus' => $dateStatus,
        'bookedTimes' => $bookedTimes,
        'availableTimes' => $availableTimes
    ]);

    // Close the connection
    mysqli_close($conn);
    exit;
}

// Helper function to generate available times (same as in JavaScript)
function generateAvailableTimes() {
    $times = [];
    $startHour = 8; // 8 AM
    $endHour = 22; // 10 PM

    for ($hour = $startHour; $hour <= $endHour; $hour++) {
        for ($minute = 0; $minute < 60; $minute += 30) {
            $formattedHour = $hour > 12 ? $hour - 12 : $hour; // 12-hour format
            $ampm = $hour >= 12 ? 'PM' : 'AM'; // Determine AM/PM
            $formattedMinute = str_pad($minute, 2, '0', STR_PAD_LEFT);
            $times[] = "{$formattedHour}:{$formattedMinute} {$ampm}";
        }
    }

    return $times;
}
