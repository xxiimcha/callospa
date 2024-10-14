<?php
include "callospa_admin_database.php";

if (isset($_GET['reservation_id'])) {
    $reservation_id = intval($_GET['reservation_id']);
    error_log("Reservation ID: " . $reservation_id); // Debugging

    // Prepare the SQL query to fetch the reservation matching the given reservation_id
    $sql = "SELECT reservation_type, first_name, last_name, contact_number, email, room, check_in_date, check_out_date, guests, total_cost 
            FROM approved_reservations 
            WHERE reservation_id = ?"; // Temporarily remove 'reservation_type' condition for debugging
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        error_log("SQL Error: " . $conn->error); // Output SQL error (if any)
        echo json_encode(["error" => "SQL error occurred."]);
        exit;
    }

    $stmt->bind_param("i", $reservation_id); // Bind the reservation_id as an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $reservation = $result->fetch_assoc();
        echo json_encode($reservation);
    } else {
        echo json_encode(["error" => "Room reservation not found"]); // Error message
    }

    $stmt->close();
}

$conn->close();
?>
