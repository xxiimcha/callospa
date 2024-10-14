<?php
require 'callospa_resort_database.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $packageId = intval($data['id']);

    $stmt = $conn->prepare("DELETE FROM packages WHERE id = ?");
    $stmt->bind_param("i", $packageId);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Package not found.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting package.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

$conn->close();
