<?php
include 'callospa_resort_database.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $eventId = intval($data['id']);

    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $eventId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid ID']);
}

$conn->close();
