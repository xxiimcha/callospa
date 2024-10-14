<?php
require 'callospa_resort_database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $packageId = $_POST['packageId'];
    $packageName = $_POST['packageName'];
    $packagePrice = $_POST['packagePrice'];
    $packageDuration = $_POST['packageDuration'];
    $packageDescription = $_POST['packageDescription'];
    $packageInclusions = $_POST['packageInclusions'];
    $packageCapacity = $_POST['packageCapacity'];

    $stmt = $conn->prepare("UPDATE packages SET package_name=?, price=?, duration=?, description=?, inclusions=?, guests=? WHERE id=?");
    $stmt->bind_param("sdssssi", $packageName, $packagePrice, $packageDuration, $packageDescription, $packageInclusions, $packageCapacity, $packageId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update package.']);
    }

    $stmt->close();
}
$conn->close();
