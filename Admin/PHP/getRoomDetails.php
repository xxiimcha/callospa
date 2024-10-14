<?php
include 'callospa_resort_database.php';

if (isset($_GET['id'])) {
    $roomId = intval($_GET['id']);
    $sql = "SELECT id, room_name, price, description, inclusions, guests FROM rooms WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $roomId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["error" => "Room not found."]);
    }

    $stmt->close();
}

$conn->close();
?>
