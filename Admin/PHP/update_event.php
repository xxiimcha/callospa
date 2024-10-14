<?php
include 'callospa_resort_database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventId = $_POST['eventId'];
    $venue = $_POST['venue'];
    $eventType = $_POST['eventType'];
    $eventPrice = $_POST['eventPrice'];
    $eventDescription = $_POST['eventDescription'];
    $eventInclusions = $_POST['eventInclusions'];
    $eventCapacity = $_POST['eventCapacity'];

    $stmt = $conn->prepare("UPDATE events SET venue=?, event_type=?, price=?, description=?, inclusions=?, guests=? WHERE id=?");
    $stmt->bind_param("ssdssii", $venue, $eventType, $eventPrice, $eventDescription, $eventInclusions, $eventCapacity, $eventId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update event details.']);
    }

    $stmt->close();
    $conn->close();
}
