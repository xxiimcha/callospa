<?php
include 'callospa_resort_database.php';

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = isset($_POST['image']) ? $_POST['image'] : '';
    $roomId = isset($_POST['roomId']) ? $_POST['roomId'] : '';

    if ($image && file_exists("../../RoomImages/$image")) {
        // Delete the image from the server
        if (unlink("../../RoomImages/$image")) {
            // Successfully deleted the file, now update the database
            // Fetch existing room images
            $sql = "SELECT `room-images` FROM rooms WHERE id = '$roomId'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $roomImages = $row['room-images'];

                // Remove the image from the list
                $updatedImages = array_filter(explode(", ", $roomImages), function($img) use ($image) {
                    return $img !== $image;
                });
                $updatedImagesStr = implode(", ", $updatedImages);

                // Update the room-images column in the database
                $updateSql = "UPDATE rooms SET `room-images` = '$updatedImagesStr' WHERE id = '$roomId'";
                if ($conn->query($updateSql)) {
                    $response['success'] = true;
                    $response['message'] = 'Image deleted and database updated successfully.';
                } else {
                    $response['message'] = 'Failed to update database.';
                }
            } else {
                $response['message'] = 'Room images not found in database.';
            }
        } else {
            $response['message'] = 'Failed to delete image file.';
        }
    } else {
        $response['message'] = 'Image not found on server.';
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
