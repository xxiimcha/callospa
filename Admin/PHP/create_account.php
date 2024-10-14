<?php
include 'callospa_admin_database.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash the password for security
    $contactnum = mysqli_real_escape_string($conn, $_POST['contactnum']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
    $id = (int)$_POST['account_level'];  // Convert account level to integer

    // Prepare the SQL query
    $sql = "INSERT INTO admin1 (user_type, username, password, contactnum, firstname, lastname, middlename)
            VALUES ($id, '$username', '$password', '$contactnum', '$firstname', '$lastname', '$middlename')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo "New account created successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Redirect to the Administrator Page
    header('Location: AdministratorPage.php');
    exit(); // Stop script execution
}

// Close the database connection
$conn->close();
?>
