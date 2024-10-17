<?php
require_once 'dbcon.php';
require_once 'phpqrcode/qrlib.php';


$path = 'qrcode_images/';
$tableCount = 10;

for ($tableNumber = 1; $tableNumber <= $tableCount; $tableNumber++) {
    $filename = $path . 'table' . $tableNumber . ".png";
    // Data you want to encode in the QR code, e.g., URL to your menu page with table parameter
    $data = 'http://localhost:8081/Online-Food-Ordering-System-main/index.php' . $tableNumber;
    QRcode::png($data, $filename, 'H', 4, 4);

    // Check if the table number already has an entry in the database
    $check = mysqli_query($conn, "SELECT * FROM restaurant_tables WHERE table_number = $tableNumber");
    if (mysqli_num_rows($check) > 0) {
        // Update the existing entry
        mysqli_query($conn, "UPDATE restaurant_tables SET qr_code_path = '$filename' WHERE table_number = $tableNumber");
    } else {
        // Insert a new entry
        mysqli_query($conn, "INSERT INTO restaurant_tables (table_number, qr_code_path) VALUES ($tableNumber, '$filename')");
    }
}
