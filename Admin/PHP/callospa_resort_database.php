<?php

$servername = "localhost";
$username = "root"; // Change if needed
$password = ""; // Change if needed
$dbname = "callospa_resort_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
