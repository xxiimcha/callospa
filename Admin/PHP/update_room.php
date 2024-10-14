<?php
include 'callospa_resort_database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomId = $_POST['roomId'];
    $roomName = $_POST['roomName'];
    $subcategory = $_POST['subcategory'];
    $roomPrice = $_POST['roomPrice'];
    $roomDescription = $_POST['roomDescription'];
    $roomInclusions = $_POST['roomInclusions'];
    $roomCapacity = $_POST['roomCapacity'];

    $stmt = $conn->prepare("UPDATE rooms SET room_name=?, subcategory_rooms=?, price=?, description=?, inclusions=?, guests=? WHERE id=?");
    $stmt->bind_param("ssdsisi", $roomName, $subcategory, $roomPrice, $roomDescription, $roomInclusions, $roomCapacity, $roomId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update room details.']);
    }

    $stmt->close();
    $conn->close();
}
