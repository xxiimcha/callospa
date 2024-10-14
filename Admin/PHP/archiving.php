<?php
require 'vendor/autoload.php'; // Include PhpSpreadsheet

function archiveData() {
    error_log("called archiveData");
    $resortDb = connectToResortDatabase();
    $adminDb = connectToAdminDatabase();
    
    // Fetch data from the four tables
    $tables = ['room_reservations', 'event_reservations', 'amenity_reservations', 'package_reservations'];
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    
    $sheetIndex = 0;

    foreach ($tables as $table) {
        $query = "SELECT * FROM $table";
        $result = $resortDb->query($query);

        if ($result->num_rows > 0) {
            // Create a new sheet for each table
            if ($sheetIndex > 0) {
                $spreadsheet->createSheet(); // Create new sheet
            }
            $spreadsheet->setActiveSheetIndex($sheetIndex);
            $spreadsheet->getActiveSheet()->setTitle($table);

            // Set the header row
            $header = [];
            while ($fieldInfo = $result->fetch_field()) {
                $header[] = $fieldInfo->name;
            }
            $spreadsheet->getActiveSheet()->fromArray($header, NULL, 'A1');

            // Set the data rows
            $row = 2; // Start from the second row (after header)
            while ($data = $result->fetch_assoc()) {
                $spreadsheet->getActiveSheet()->fromArray(array_values($data), NULL, 'A' . $row);
                $row++;
            }
            $sheetIndex++;
        }
    }

    // Save the spreadsheet to a file in the archives directory
    $date = date('Y-m-d');
    $fileName = "archives/archived_data_$date.xlsx";
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save($fileName);

    // Store the archive information in callospa_admin_database
    $archiveQuery = "INSERT INTO archived_files (file_name, archived_on) VALUES (?, NOW())";
    $stmt = $adminDb->prepare($archiveQuery);
    $stmt->bind_param("s", $fileName);
    $stmt->execute();

    // Call the function to delete the data from the tables after archiving
    deleteDataFromTables($resortDb, $tables);
    
    // Close the connections
    $resortDb->close();
    $adminDb->close();
    
    return $fileName; // Return the name of the archived file
}

// Function to delete all data from the tables after archiving
function deleteDataFromTables($dbConnection, $tables) {
    foreach ($tables as $table) {
        $deleteQuery = "TRUNCATE TABLE $table"; // TRUNCATE is faster and resets the auto-increment counter
        $dbConnection->query($deleteQuery);
    }
}
?>
