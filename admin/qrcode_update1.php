<?php
session_start();
require_once '../dbcon.php';

if (isset($_POST['submit'])) {
    $sid = $_POST['sid'];
    $tableNumber = $_POST['table_number'];
    $qrCode = $_FILES['qr_code']['name'];
    $tempName = $_FILES['qr_code']['tmp_name'];
    $uploadPath = "../qrcode_images/" . $qrCode;

    // Move uploaded file to the desired directory
    if (move_uploaded_file($tempName, $uploadPath)) {
        // Update the table entry
        $updateQuery = "UPDATE `restaurant_tables` SET `table_number` = ?, `qr_code_path` = ? WHERE `id` = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param('isi', $tableNumber, $qrCode, $sid);
        $success = $stmt->execute();

        if ($success) {
            echo "<script>alert('Table and QR Code updated successfully!');</script>";
            // Redirect to the QR code update page if successful
            echo "<script>window.location = 'qrcode_update.php';</script>";
        } else {
            echo "<script>alert('Error updating record: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Failed to upload QR Code image.');</script>";
    }
    $stmt->close();
}
$conn->close();
