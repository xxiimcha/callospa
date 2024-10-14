<?php
include 'callospa_resort_database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amenitiesId = $_POST['amenitiesId'];
    $subcategoryName = $_POST['subcategoryName'];
    $subcategoryDescription = $_POST['subcategoryDescription'];
    $amenitiesPrice = $_POST['amenitiesPrice'];
    $amenitiesDuration = $_POST['amenitiesDuration'];

    $stmt = $conn->prepare("UPDATE amenities SET amenities_subcategory_name=?, amenities_subcategory_description=?, price=?, duration=? WHERE id=?");
    $stmt->bind_param("ssdsi", $subcategoryName, $subcategoryDescription, $amenitiesPrice, $amenitiesDuration, $amenitiesId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update amenities details.']);
    }

    $stmt->close();
    $conn->close();
}
