<?php
require 'callospa_resort_database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $packageName = mysqli_real_escape_string($conn, $_POST['packageName']);
    $packagePrice = mysqli_real_escape_string($conn, $_POST['packagePrice']);
    $packageDuration = mysqli_real_escape_string($conn, $_POST['packageDuration']);
    $packageDescription = mysqli_real_escape_string($conn, $_POST['packageDescription']);
    $packageCapacity = mysqli_real_escape_string($conn, $_POST['packageCapacity']);

    // Get selected rooms and spa subcategories as comma-separated values
    $selectedRooms = isset($_POST['rooms']) ? implode(',', $_POST['rooms']) : null;
    $selectedSpaSubcategories = isset($_POST['subcategories']) ? implode(',', $_POST['subcategories']) : null;

    // Escape values for selectedRooms and selectedSpaSubcategories to prevent SQL injection
    $selectedRooms = mysqli_real_escape_string($conn, $selectedRooms);
    $selectedSpaSubcategories = mysqli_real_escape_string($conn, $selectedSpaSubcategories);

    // Initialize an array to hold the image paths
    $imagePaths = [];

    // Check if there are images to upload
    if (!empty($_FILES['packagePhotos']['name'][0])) {
        $uploadDir = '../../Packages/';  // Folder to store images

        // Loop through uploaded files
        foreach ($_FILES['packagePhotos']['name'] as $key => $imageName) {
            // Get the temporary file path
            $tmpName = $_FILES['packagePhotos']['tmp_name'][$key];

            // Create a unique filename for the image
            $newFileName = uniqid() . '-' . basename($imageName);

            // Set the target file path
            $targetFilePath = $uploadDir . $newFileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($tmpName, $targetFilePath)) {
                // If upload was successful, store the path in the array
                $imagePaths[] = $newFileName;
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to upload image: ' . $imageName]);
                exit;
            }
        }
    }

    // Convert the image paths array to a comma-separated string
    $imagesString = !empty($imagePaths) ? implode(',', $imagePaths) : null;

    // Build SQL query to insert package details including selected rooms, spa subcategories, and image paths
    $sql = "INSERT INTO packages (package_name, price, duration, description, guests, room_ids, spa_subcategories, images)
            VALUES ('$packageName', '$packagePrice', '$packageDuration', '$packageDescription', '$packageCapacity', '$selectedRooms', '$selectedSpaSubcategories', '$imagesString')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add package: ' . $conn->error]);
    }

    $conn->close();
}
?>
