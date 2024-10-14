<?php
include 'callospa_resort_database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $package = mysqli_real_escape_string($conn, $_POST['package']); // Sanitize the input

    // Query to get room_ids and spa_subcategories for the selected package
    $sql_package_info = "SELECT room_ids, spa_subcategories FROM packages WHERE package_name = '$package'";
    $result_package_info = mysqli_query($conn, $sql_package_info);

    if (!$result_package_info || mysqli_num_rows($result_package_info) === 0) {
        echo json_encode(['error' => 'Package not found']);
        exit;
    }

    $package_info = mysqli_fetch_assoc($result_package_info);
    $room_ids = $package_info['room_ids'];
    $spa_subcategory = $package_info['spa_subcategories'];

    $bookedDates = [];

    // Function to accumulate booked dates from the result set
    function accumulateBookedDates($result, &$bookedDates) {
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $checkInDate = $row['check_in_date'];
                $checkOutDate = isset($row['check_out_date']) ? $row['check_out_date'] : $checkInDate; // Handle single-day bookings

                $currentDate = $checkInDate;
                while ($currentDate <= $checkOutDate) {
                    $bookedDates[] = $currentDate;
                    $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                }
            }
        }
    }

    // Get the names of the rooms based on the room_ids
    $roomNames = [];
    if (!empty($room_ids)) {
        $sql_room_names = "SELECT room_name FROM rooms WHERE id IN ($room_ids)";
        $result_room_names = mysqli_query($conn, $sql_room_names);

        if ($result_room_names) {
            while ($row = mysqli_fetch_assoc($result_room_names)) {
                $roomNames[] = $row['room_name'];
            }
        } else {
            echo json_encode(['error' => 'Error fetching room names']);
            exit;
        }
    }

    // Convert roomNames array to a comma-separated string for SQL query
    $roomNamesList = "'" . implode("', '", $roomNames) . "'";

    // Check availability in pending_package_reservations
    $sql_package = "SELECT check_in_date, check_out_date FROM pending_package_reservations WHERE package = '$package'";
    $result_package = mysqli_query($conn, $sql_package);
    if ($result_package) {
        accumulateBookedDates($result_package, $bookedDates);
    } else {
        echo json_encode(['error' => 'Error querying package reservations']);
        exit;
    }

    // Check availability in pending_room_reservations for the selected room_names
    if (!empty($roomNames)) {
        $sql_room = "SELECT check_in_date, check_out_date FROM pending_room_reservations WHERE room IN ($roomNamesList)";
        $result_room = mysqli_query($conn, $sql_room);
        if ($result_room) {
            accumulateBookedDates($result_room, $bookedDates);
        } else {
            echo json_encode(['error' => 'Error querying room reservations']);
            exit;
        }
    }

    // Check availability in pending_amenity_reservations for the selected spa_subcategory
    if (!empty($spa_subcategory)) {
        $sql_amenity = "SELECT check_in_date FROM pending_amenity_reservations WHERE package = '$spa_subcategory'";
        $result_amenity = mysqli_query($conn, $sql_amenity);
        if ($result_amenity) {
            accumulateBookedDates($result_amenity, $bookedDates);
        } else {
            echo json_encode(['error' => 'Error querying amenity reservations']);
            exit;
        }
    }

    // Remove duplicate dates if any
    $bookedDates = array_unique($bookedDates);
    sort($bookedDates); // Sort the dates in ascending order

    // Return both booked dates and room names for the selected package
    echo json_encode([
        'available' => empty($bookedDates),
        'bookedDates' => $bookedDates,
        'roomNames' => $roomNames // Include the room names in the response
    ]);
    exit;
}
?>
