<?php
require 'callospa_admin_database.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['username'])) {
    $username = $data['username'];

    $stmt = $conn->prepare("DELETE FROM admin1 WHERE username = ?");
    
    if ($stmt) {
        $stmt->bind_param("s", $username); 

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'User not found.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete the user.', 'error' => $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare statement.', 'error' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

$conn->close();