<?php
header('Content-Type: application/json');

// Database connection parameters
$servername = "localhost";
$username = "root"; // Change if needed
$password = ""; // Change if needed
$dbname = "callospa_admin_database"; // Your database name

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch events
    $stmt = $pdo->query('
        SELECT 
            reservation_id, 
            first_name, 
            last_name, 
            room, 
            check_in_date, 
            check_out_date, 
            check_in_time, 
            check_out_time 
        FROM 
            approved_reservations 
        WHERE
            reservation_type = "Room"'
    );

    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the data for FullCalendar
    $formattedEvents = array_map(function ($event) {
        // Default times if not available
        $checkInTime = !empty($event['check_in_time']) ? $event['check_in_time'] : '00:00:00';
        $checkOutTime = !empty($event['check_out_time']) ? $event['check_out_time'] : '23:59:59';

        return [
            'title' => $event['first_name'] . ' ' . $event['last_name'] . ' - ' . $event['room'],
            'start' => $event['check_in_date'] . 'T' . $checkInTime,
            'end' => $event['check_out_date'] . 'T' . $checkOutTime,
            'extendedProps' => [
                'reservation_id' => $event['reservation_id'],
                'first_name' => $event['first_name'],
                'last_name' => $event['last_name'],
                'room' => $event['room'],
            ]
        ];
    }, $events);

    // Output JSON
    echo json_encode($formattedEvents);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
