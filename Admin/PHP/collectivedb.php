<?php
function connectToResortDatabase() {
    $host = 'localhost'; // Update if necessary
    $user = 'root'; // Update with your database username
    $password = ''; // Update with your database password
    $dbname = 'callospa_resort_database';

    $connection = new mysqli($host, $user, $password, $dbname);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    return $connection;
}

function connectToAdminDatabase() {
    $host = 'localhost'; // Update if necessary
    $user = 'root'; // Update with your database username
    $password = ''; // Update with your database password
    $dbname = 'callospa_admin_database';

    $connection = new mysqli($host, $user, $password, $dbname);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    return $connection;
}
?>
