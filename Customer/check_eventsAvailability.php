<?php
include 'callospa_resort_database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the incoming data from the request
    $packageCategory = $_POST['package_category'];
    $package = $_POST['package'];
    $selectedDate = $_POST['selected_date']; // Get the selected date from the request

    // Initialize an array to hold the dates that should be disabled
    $disableDates = [];
    $otherPackagesBooked = false;
    $nightBooked = false;

    // Check for conflicting bookings
    $sql = "SELECT check_in_date, check_out_date, package 
            FROM pending_event_reservations 
            WHERE (check_in_date <= ? AND check_out_date >= ? AND 
            (package IN ('Day Resort Grounds Exclusive', '1 Day with Reception Hall', '1 Day with Conference Room') OR 
            (package = 'Night Resort Grounds Exclusive')))";

    try {
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Preparation failed: " . $conn->error);
        }
        
        // Bind parameters and execute
        $stmt->bind_param("ss", $selectedDate, $selectedDate);
        if (!$stmt->execute()) {
            throw new Exception("Execution failed: " . $stmt->error);
        }

        $result = $stmt->get_result();
        
        // Fetch results and check for conflicts
        while ($row = $result->fetch_assoc()) {
            if ($row['package'] === 'Night Resort Grounds Exclusive') {
                $nightBooked = true; // If this package is booked
            } else {
                $otherPackagesBooked = true; // One of the other packages is booked
            }
        }

        $stmt->close();

        // Determine if the selected date should be disabled
        if ($nightBooked && $otherPackagesBooked) {
            // Disable this date for all bookings if both are booked
            $disableDates[] = $selectedDate;
        } elseif ($otherPackagesBooked) {
            // Disable only for the specified packages
            if (in_array($package, ['Day Resort Grounds Exclusive', '1 Day with Reception Hall', '1 Day with Conference Room'])) {
                $disableDates[] = $selectedDate;
            }
        }

        // Automatically disable dates for the 24-hour packages
        if ($package === '24-Hour with Conference Room' || $package === '24-Hour with Reception Hall') {
            $disableDates[] = $selectedDate;
        }

        // Return unique disabled dates as a JSON response
        echo json_encode(['disableDates' => array_unique($disableDates)]);
    } catch (Exception $e) {
        // Handle any exceptions and return an error message
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit; // Exit to prevent further output
}
?>