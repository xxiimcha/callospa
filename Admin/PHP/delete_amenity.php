<?php
include 'callospa_resort_database.php';

header('Content-Type: application/json');

$response = ['success' => false];

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id'])) {
    $amenity_id = $data['id'];

    $stmt = $conn->prepare("DELETE FROM amenities WHERE id = ?");
    $stmt->bind_param("i", $amenity_id);

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['message'] = "Error deleting amenity: " . $stmt->error;
    }

    $stmt->close();
} else {
    $response['message'] = "ID not provided.";
}

$conn->close();

echo json_encode($response);
