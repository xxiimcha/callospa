<?php
function connectToAdminDatabase() {
    $host = 'localhost'; // Your database host
    $user = 'root'; // Your database username
    $password = ''; // Your database password
    $dbname = 'callospa_admin_database'; // Your database name

    $connection = new mysqli($host, $user, $password, $dbname);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    return $connection;
}
?>
