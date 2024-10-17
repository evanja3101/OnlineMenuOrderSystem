<?php
session_start();
require_once 'dbcon.php';

// Ensure the cart and table number are initialized in the session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
if (!isset($_SESSION['table']) && isset($_GET['table'])) {
    $_SESSION['table'] = intval($_GET['table']);
}

function handleCartActions()
{
    global $conn; // Make sure to use the database connection globally if required
    // Extract the table number for use in redirects and database insertion
    $tableNumber = isset($_SESSION['table']) ? $_SESSION['table'] : null;

    // Handling AJAX request for adding items to the cart
    if (isset($_POST['itemId']) && isset($_POST['quantity'])) {
        $itemId = (int)$_POST['itemId'];
        $quantity = (int)$_POST['quantity'];

        if ($itemId > 0 && $quantity !== 0) {
            // Update or add the new item with its quantity
            $_SESSION['cart'][$itemId] = isset($_SESSION['cart'][$itemId]) ? $_SESSION['cart'][$itemId] + $quantity : $quantity;

            // Respond to AJAX request
            echo array_sum(array_values($_SESSION['cart']));
            exit;
        }
    }

    // Handle updating an item quantity in the cart from a form
    if (isset($_POST['update'])) {
        $itemIdToUpdate = (int)$_POST['update'];
        $newQuantity = (int)$_POST['items'][$itemIdToUpdate]['quantity'];

        if ($newQuantity > 0) {
            $_SESSION['cart'][$itemIdToUpdate] = $newQuantity;
        } else {
            unset($_SESSION['cart'][$itemIdToUpdate]);
        }
        header("Location: cart.php?table=" . $tableNumber);
        exit;
    }

    // Handle the checkout process from a form
    if (isset($_POST['checkout_button']) && !empty($_SESSION['cart'])) {
        // Prepare a statement for inserting data
        $stmt = $conn->prepare("INSERT INTO cart_orders (table_id, product_id, product_name, quantity) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            die('MySQL prepare error: ' . $conn->error);
        }

        // Bind parameters to the statement
        $stmt->bind_param('iisi', $table_id, $product_id, $product_name, $quantity);
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $table_id = $tableNumber;
            $product_id = $productId;

            // Fetch the product name from the database using the product ID
            $nameStmt = $conn->prepare("SELECT name FROM menu_items WHERE id = ?");
            $nameStmt->bind_param('i', $product_id);
            $nameStmt->execute();
            $nameResult = $nameStmt->get_result();
            if ($nameRow = $nameResult->fetch_assoc()) {
                $product_name = $nameRow['name'];
            } else {
                // Handle error if product name not found
                continue; // Skip this item or handle the error appropriately
            }
            $nameStmt->close();

            // Execute the statement for each item
            if (!$stmt->execute()) {
                die('Execute error: ' . $stmt->error);
            }
        }

        $stmt->close();
        $_SESSION['cart'] = []; // Clear the cart after checkout
        header("Location: cart_successful_submit.php?table=" . $tableNumber . "&orderSubmitted=true");
        exit;
    } else {
        header("Location: cart.php?table=" . $tableNumber . "&error=empty");
        exit;
    }
}

handleCartActions(); // Call the function to process cart actions
