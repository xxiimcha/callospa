<?php
include 'callospa_resort_database.php'; // Ensure this file connects to your database

if (isset($_POST['category'])) {
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // Fetch subcategories based on the selected category
    $sql = "SELECT amenities_subcategory_name FROM amenities WHERE amenities_categories = '$category'";
    $result = $conn->query($sql);

    // Check if query is successful
    if ($result) {
        // Generate the subcategory options
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . htmlspecialchars($row['amenities_subcategory_name']) . "'>" . htmlspecialchars($row['amenities_subcategory_name']) . "</option>";
        }
    } else {
        echo "Error fetching subcategories: " . $conn->error;
    }
}
?>
