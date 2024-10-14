<?php
include 'callospa_resort_database.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amenitiesSubcategoryName = trim($_POST['addSubcategoryName']);
    $amenitiesSubcategoryDescription = trim($_POST['addSubcategoryDescription']);
    $price = trim($_POST['addAmenitiesPrice']);
    $duration = trim($_POST['addAmenitiesDuration']);
    $amenitiesCategory = trim($_POST['amenitiesCategories']);

    if (empty($amenitiesSubcategoryName) || empty($price) || empty($amenitiesCategory)) {
        $response['message'] = 'Please fill in all required fields.';
    } else {
        $stmt = $conn->prepare("INSERT INTO amenities (amenities_subcategory_name, amenities_subcategory_description, price, duration, amenities_categories) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $amenitiesSubcategoryName, $amenitiesSubcategoryDescription, $price, $duration, $amenitiesCategory);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Amenities added successfully!';
        } else {
            $response['message'] = 'Error adding amenities: ' . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
