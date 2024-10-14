<?php
require 'callospa_resort_database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $venue = $_POST['venue'] ?? null;
    $event_type = $_POST['eventType'] ?? null;
    $price = $_POST['eventPrice'] ?? null;
    $description = $_POST['eventDescription'] ?? null;
    $inclusions = $_POST['eventInclusions'] ?? null;
    $guests = $_POST['eventCapacity'] ?? null;

    if (empty($venue) || empty($event_type) || empty($price) || !is_numeric($price) || empty($description) || empty($inclusions) || !is_numeric($guests)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input. Please check your data.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO events (venue, event_type, price, description, inclusions, guests) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsdi", $venue, $event_type, $price, $description, $inclusions, $guests);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add event: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
