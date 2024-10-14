<?php
require 'callospa_resort_database.php'; // Include your database connection file

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $roomId = $data['roomId'] ?? null;

    if ($roomId) {
        $stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
        $stmt->bind_param('i', $roomId);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting room.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'No room ID provided.']);
    }
}

$conn->close();
?>
