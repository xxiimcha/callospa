<?php
require 'collectivedb.php'; // Include your database connection functions

if (isset($_GET['file'])) {
    $fileName = basename($_GET['file']); // Get the filename from the query string
    $filePath = 'archives/' . $fileName; // Path to the file

    // Check if the file exists
    if (file_exists($filePath)) {
        // Set headers to initiate download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath); // Read the file and send it to the output buffer
        exit;
    } else {
        echo "File not found: " . htmlspecialchars($filePath);
    }
} else {
    echo "No file specified.";
}
?>
