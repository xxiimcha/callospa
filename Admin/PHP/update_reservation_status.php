<?php
include_once 'collectivedb.php';
include_once 'callospa_resort_database.php';

$resort_conn = connectToResortDatabase();
$admin_conn = connectToAdminDatabase();

if (isset($_POST['reservation_id']) && isset($_POST['reservation_type'])) {
    $reservation_id = $_POST['reservation_id'];
    $reservation_type = $_POST['reservation_type'];

    if ($_POST['action'] === 'approve') {
        // Fetch the reservation details based on reservation_type
        switch ($reservation_type) {
            case 'Room':
                $query = "SELECT * FROM pending_room_reservations WHERE reservation_id = ?";
                break;
            case 'Event':
                $query = "SELECT * FROM pending_event_reservations WHERE reservation_id = ?";
                break;
            case 'Amenity':  // Adjusted from Spa to Amenity
                $query = "SELECT * FROM pending_amenity_reservations WHERE reservation_id = ?";
                break;
            case 'Package':
                $query = "SELECT * FROM pending_package_reservations WHERE reservation_id = ?";
                break;
            default:
                die("Invalid reservation type.");
        }

        if ($stmt = $resort_conn->prepare($query)) {
            $stmt->bind_param("i", $reservation_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $reservation = $result->fetch_assoc();

            if ($reservation) {
                // Prepare insert into approved_reservations
                $insert_query = "INSERT INTO approved_reservations (
                    reservation_type, first_name, middle_name, last_name, contact_number, email, handle, sources, source_other, 
                    package_category, package, event_type, room, check_in_date, check_out_date, check_in_time, check_out_time, guests, 
                    additional_guest, catering_preference, total_cost, deposit_amount, remaining_balance, payment_method, 
                    proof_of_payment, reservation_date
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                if ($insert_stmt = $admin_conn->prepare($insert_query)) {
                    // Bind parameters, ensuring the right data types
                    $insert_stmt->bind_param(
                        "ssssssssssssssssssiissddss",
                        $reservation_type,  // Reservation type directly from the request
                        $reservation['first_name'],
                        $reservation['middle_name'],
                        $reservation['last_name'],
                        $reservation['contact_number'],
                        $reservation['email'],
                        $reservation['handle'],
                        $reservation['sources'],
                        $reservation['source_other'],
                        $reservation['package_category'],
                        $reservation['package'],
                        $reservation['event_type'],  // Nullable for other types
                        $reservation['room'],  // Nullable for other types
                        $reservation['check_in_date'],
                        $reservation['check_out_date'],  // Nullable for some types
                        $reservation['check_in_time'],
                        $reservation['check_out_time'],
                        $reservation['guests'],
                        $reservation['additional_guest'],  // Nullable for some types
                        $reservation['catering_preference'],  // Nullable for some types
                        $reservation['total_cost'],
                        $reservation['deposit_amount'],
                        $reservation['remaining_balance'],
                        $reservation['payment_method'],
                        $reservation['proof_of_payment'],
                        $reservation['reservation_date']
                    );

                    // Execute the insert
                    if ($insert_stmt->execute()) {
                        // Delete from the pending reservations table
                        switch ($reservation_type) {
                            case 'Room':
                                $delete_query = "DELETE FROM pending_room_reservations WHERE reservation_id = ?";
                                break;
                            case 'Event':
                                $delete_query = "DELETE FROM pending_event_reservations WHERE reservation_id = ?";
                                break;
                            case 'Amenity':
                                $delete_query = "DELETE FROM pending_amenity_reservations WHERE reservation_id = ?";
                                break;
                            case 'Package':
                                $delete_query = "DELETE FROM pending_package_reservations WHERE reservation_id = ?";
                                break;
                        }

                        if ($delete_stmt = $resort_conn->prepare($delete_query)) {
                            $delete_stmt->bind_param("i", $reservation_id);
                            $delete_stmt->execute();
                        }
                        
                        // Redirect to AdministratorPage.php after approval
                        header("Location: AdministratorPage.php");
                        exit; // Ensure no further code is executed after redirection
                    } else {
                        echo "Error executing insert: " . $insert_stmt->error;
                    }
                } else {
                    echo "Error preparing insert statement: " . $admin_conn->error;
                }
            } else {
                echo "No reservation found for the provided ID.";
            }
        } else {
            echo "Error preparing select statement: " . $resort_conn->error;
        }
    } elseif ($_POST['action'] === 'decline') {
        // Delete operation for declined reservations
        switch ($reservation_type) {
            case 'Room':
                $query = "DELETE FROM pending_room_reservations WHERE reservation_id = ?";
                break;
            case 'Event':
                $query = "DELETE FROM pending_event_reservations WHERE reservation_id = ?";
                break;
            case 'Amenity':
                $query = "DELETE FROM pending_amenity_reservations WHERE reservation_id = ?";
                break;
            case 'Package':
                $query = "DELETE FROM pending_package_reservations WHERE reservation_id = ?";
                break;
            default:
                die("Invalid reservation type.");
        }

        if ($stmt = $resort_conn->prepare($query)) {
            $stmt->bind_param("i", $reservation_id);
            $stmt->execute();

            // Redirect to AdministratorPage.php after decline
            header("Location: AdministratorPage.php");
            exit; // Ensure no further code is executed after redirection
        }
    }
}
?>
