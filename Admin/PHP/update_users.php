<?php
include 'callospa_admin_database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adminId = $_POST['adminId'];
    $username = $_POST['username'];
    $password = $_POST['password']; // New password input
    $contactnum = $_POST['contactnum'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $middlename = $_POST['middlename'];

    // Prepare the SQL statement
    if (!empty($password)) {
        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Update the database with the new hashed password
        $stmt = $conn->prepare("UPDATE admin1 SET username=?, password=?, contactnum=?, firstname=?, lastname=?, middlename=? WHERE id=?");
        $stmt->bind_param("ssisssi", $username, $hashed_password, $contactnum, $firstname, $lastname, $middlename, $adminId);
    } else {
        // If no new password is provided, just update the other fields
        $stmt = $conn->prepare("UPDATE admin1 SET username=?, contactnum=?, firstname=?, lastname=?, middlename=? WHERE id=?");
        $stmt->bind_param("ssisssi", $username, $contactnum, $firstname, $lastname, $middlename, $adminId);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update admin details.']);
    }

    $stmt->close();
    $conn->close();
}
?>
