<?php
include 'callospa_resort_database.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'])) {
    echo json_encode(['success' => false, 'message' => 'No room ID provided']);
    exit;
}

$roomId = (int)$data['id'];

$stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
$stmt->bind_param("i", $roomId);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Room deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Room not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error deleting room']);
}

$stmt->close();
$conn->close();
