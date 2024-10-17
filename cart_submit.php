<?php
require_once 'dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $tableId = $_POST['table_id']; // The ID of the table from which the order is made
    $productId = $_POST['product_id']; // The ID of the product being ordered
    $quantity = $_POST['quantity']; // The quantity of the product being ordered


    $stmt = $conn->prepare("INSERT INTO cart_orders (cart_id, product_id, quantity) VALUES (?, ?, ?)");

    // Bind the parameters to the prepared statement
    $stmt->bind_param("iii", $tableId, $productId, $quantity);

    // Execute the prepared statement
    $success = $stmt->execute();

    if ($success) {
        // Handle the success, such as sending a confirmation message to the user
    } else {
        // Handle the error, such as informing the user that the order could not be placed
    }

    // Close the statement
    $stmt->close();

}
