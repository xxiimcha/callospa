<?php
include 'callospa_resort_database.php';

$response = [
    'success' => false,
    'message' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomName = isset($_POST['roomName']) ? trim($_POST['roomName']) : null;
    $subcategory = isset($_POST['subcategory']) ? trim($_POST['subcategory']) : null;
    $price = isset($_POST['roomPrice']) ? trim($_POST['roomPrice']) : null;
    $description = isset($_POST['roomDescription']) ? trim($_POST['roomDescription']) : null;
    $inclusions = isset($_POST['roomInclusions']) ? trim($_POST['roomInclusions']) : null;
    $guests = isset($_POST['roomCapacity']) ? (int)$_POST['roomCapacity'] : null;
    $uploadDir = '../../RoomImages/'; // Directory to store uploaded images
    $uploadedFiles = [];

    // Ensure required fields are filled
    if (empty($roomName) || empty($price) || empty($guests)) {
        $response['message'] = 'Room name, price, and guest capacity are required.';
    } else {
        // Handle image upload if files are selected
        if (!empty($_FILES['roomPhotos']['name'][0])) {
            foreach ($_FILES['roomPhotos']['tmp_name'] as $key => $tmp_name) {
                $fileName = basename($_FILES['roomPhotos']['name'][$key]);
                $fileTmp = $_FILES['roomPhotos']['tmp_name'][$key];
                $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                $uniqueFileName = uniqid() . '_' . time() . '.' . $fileExt; // Create unique file name

                // Check if directory exists, if not, create it
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Move the uploaded file to the destination directory
                if (move_uploaded_file($fileTmp, $uploadDir . $uniqueFileName)) {
                    $uploadedFiles[] = $uniqueFileName; // Store the file name in an array
                } else {
                    $response['message'] = 'Failed to upload images.';
                    echo json_encode($response);
                    exit();
                }
            }
        }

        // Convert uploaded file names array into a comma-separated string
        $imageString = implode(', ', $uploadedFiles);

        // Insert room details into the database along with image file names
        $stmt = $conn->prepare("INSERT INTO rooms (room_name, subcategory_rooms, price, description, inclusions, guests, `room-images`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsdis", $roomName, $subcategory, $price, $description, $inclusions, $guests, $imageString);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Room added successfully with images.';
        } else {
            $response['message'] = 'Failed to add room: ' . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
