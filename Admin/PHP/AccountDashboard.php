<?php
require 'activity_log.php';
require 'archiving.php';

session_start();
include 'callospa_admin_database.php';
include 'LogOut.php';

if (isset($_SESSION['username'])) {
    $adminUsername = $_SESSION['username'];
    logActivity($adminUsername, "Accessed Accounts Page");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $newUsername = mysqli_real_escape_string($conn, $_POST['username']);
    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);  
    $contactnum = mysqli_real_escape_string($conn, $_POST['contactnum']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
    $user_type = mysqli_real_escape_string($conn, $_POST['account_level']);

    $sql = "INSERT INTO admin1 (user_type, username, password, contactnum, firstname, lastname, middlename)
            VALUES ($user_type, '$newUsername', '$hashedPassword', '$contactnum', '$firstname', '$lastname', '$middlename')";

    if (mysqli_query($conn, $sql)) {
        echo "New account created successfully!";
        logActivity($adminUsername, "Created a new account for: $newUsername"); 
    } else {
        echo "Error: " . mysqli_error($conn); 
        logActivity($adminUsername, "Error creating account for: $newUsername - " . mysqli_error($conn)); 
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../CSS/AccountDashboard.css" />
    <title>Callospa Resort and Residences Admin</title>
</head>
<style>
  
</style>
<body>
    
  <?php include 'Sidebar.php'; ?>

  <section id="content">

    <main>
      <div class="head-title">
        <div class="left">
          <h1>Account</h1>
          <ul class="links">
            <li>
              <a href="#">Account</a>
            </li>
            <li><i class="bx bx-chevron-right"></i></li>
            <li>
              <a class="active" href="AdministratorPage.php">Home</a>
            </li>
          </ul>
        </div>
      </div>
       
    <div class="create-account">
    <form action="create_account.php" method="POST">
        <!-- Username -->
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <!-- Password -->
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <!-- Contact Number -->
        <label for="contactnum">Contact Number:</label><br>
        <input type="text" id="contactnum" name="contactnum" required><br><br>

        <!-- First Name -->
        <label for="firstname">First Name:</label><br>
        <input type="text" id="firstname" name="firstname" required><br><br>

        <!-- Last Name -->
        <label for="lastname">Last Name:</label><br>
        <input type="text" id="lastname" name="lastname" required><br><br>

        <!-- Middle Name -->
        <label for="middlename">Middle Name:</label><br>
        <input type="text" id="middlename"><br><br>

        <!-- Account Level Selection -->
         <h3>Select Account Level:</h3>
        <label for="account_level">Account Level:</label><br>
        <select id="account_level" name="account_level" required>
            <option value="admin">Admin</option>
            <option value="staff">Desk</option>
        </select><br><br>

        <!-- Submit button -->
        <input type="submit" value="Create Account">  
    </form>
    </div>
    </main>
  </section>
  <script src="../JS/AdministratorPage.js"></script>
  <script src="../JS/Sidebar.js"></script>   

</body>

</html>
