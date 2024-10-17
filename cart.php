<?php
session_start();

require_once 'dbcon.php';
require_once 'cart_submit.php';

// Initialize $_SESSION['cart'] if not set
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$subtotal = 0;

// Check if the cart is not empty before trying to display its contents
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $itemId => $quantity) {
        // Database query and display logic here
    }
} else {
    echo "<p>Your cart is empty!</p>";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Your cart</title>
    <!-- Add your stylesheet links here -->
</head>


<style>
    body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Arial', sans-serif;
    }

    .main-menu {
        background-color: darkgrey;
        box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
        position: absolute;
        background-position: cover;
        width: 100%;
        height: 100%;
        z-index: 1000;
    }

    .inner-menu {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
    }

    .inner-menu a {
        text-decoration: none;
        color: aliceblue;
        font-weight: bold;
        font-size: 20px;
        background-color: dimgray;
        padding: 15px 15px;
        border-radius: 15px;
    }

    .inner-menu a:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(255, 215, 15, 0.1);
    }

    .inner-menu .cart-items {
        position: relative;
        cursor: pointer;
    }

    .table_info {
        position: relative;
    }

    #cart-count {
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 10px 15px;
        position: relative;
        top: -2px;
        right: 0px;
        font-size: 14px;
        width: 15px;
        height: 15px;
    }

    .cart-container {
        margin-top: 60px;
        /* Adjusted based on the height of the menu */
        background: #f9f9f9;
        padding: 20px;
        width: 80%;
        margin: 60px auto;
        /* Spacing from top and centering */
        border: 1px solid #ddd;
        border-radius: 10px;
    }

    .cart-title {
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
    }

    .cart-item {
        display: flex;
        align-items: center;
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
    }

    .cart-item img {
        width: 100px;
        /* Adjust as needed */
        height: auto;
        margin-right: 20px;
    }

    .item-details {
        flex-grow: 1;
    }

    .item-details p {
        margin: 5px 0;
    }

    .remove-item {
        color: #fff;
        background-color: #e74c3c;
        border: none;
        padding: 10px;
        cursor: pointer;
        text-decoration: none;
    }

    .remove-item:hover {
        background-color: #c0392b;
    }

    .cart-subtotal {
        text-align: right;
        margin-top: 20px;
        font-size: 18px;
    }

    .checkout-button {
        text-align: right;
        margin-top: 20px;
    }

    .checkout-button a {
        text-decoration: none;
        background-color: #2ecc71;
        color: #fff;
        padding: 10px 20px;
        border-radius: 4px;
        font-size: 18px;
    }

    .checkout-button a:hover {
        background-color: #27ae60;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .cart-container {
            width: 95%;
        }

        .cart-item img {
            width: 80px;
            /* Adjust as needed */
        }
    }

    @media (max-width: 992px) {
        .upper-div {
            display: none !important;
        }

        .remove-btn {
            margin-top: 30px;
        }
    }

    @media (max-width: 602px) {
        .top-heading {
            margin: 40px 20px 0px 0px !important;
        }
    }

    @media (max-width: 400px) {
        .empty-cart-div h2 {
            top: 56% !important;
        }

        .empty-cart-div h6 {
            top: 64% !important;
            width: 250px;
        }

        .empty-cart-div a {
            top: 75%;
        }
    }

    @media screen and (max-width: 480px) and (min-width: 350px) {
        .logo img {
            height: 40px;
        }
    }

    @media screen and (max-width: 350px) {
        .logo img {
            height: 35px;
        }
    }
</style>


















<body>
    <div class="main-menu sticky-top">
        <div class="inner-menu sticky-top">
            <a href="header.php">MENU</a>
            <a href="cart.php" style="float: right;">CART
                <span id="cart-count">
                    <?php echo count($_SESSION['cart']); ?>
                </span>
            </a>

        </div>

        <div class="cart-container">
            <h1>CART</h1>
            <form action='update_cart.php<?php echo isset($_GET['table']) ? "?table=" . intval($_GET['table']) : ""; ?>' method="POST">
                <!-- PHP Script to Display Table Number -->
                <?php
                require_once 'dbcon.php';

                if (isset($_GET['table'])) {
                    $tableNumber = intval($_GET['table']);
                    $stmt = $conn->prepare("SELECT table_number FROM restaurant_tables WHERE table_number = ?");
                    $stmt->bind_param("i", $tableNumber);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    // To inform user which table they are in
                    if ($result->num_rows > 0) {
                        echo "<div style='font-family: Amatic SC, sans-serif; float: right; font-weight: bold; color: orange; text; margin-top: -90px; background-color: brown; padding: 10px 10px; border-radius: 10px; position: relative'>Table " . htmlspecialchars($tableNumber) . "</div>";
                    } else {
                        echo "<div style='font-family: Amatic SC, sans-serif; float: right; font-weight: bold; color: orange; text; margin-top: -90px; background-color: brown; padding: 10px 10px; border-radius: 10px'>Table information not found.</div>";
                    }
                    $stmt->close();
                } else {
                    echo "<div style='font-family: Amatic SC, sans-serif; float: right; font-weight: bold; color: orange; text; margin-top: -90px; background-color: brown; padding: 10px 10px; border-radius: 10px'>No table information provided.</div>";
                }
                ?>
                <!-- Hidden input to keep the table number in case the refreshing of page -->


                <div class="cart-items">
                    <?php
                    $subtotal = 0;
                    if (!empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $itemId => $quantity) {
                            $stmt = $conn->prepare("SELECT name, price, image, description FROM menu_items WHERE id = ?");
                            $stmt->bind_param("i", $itemId);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                                $item = $result->fetch_assoc();

                                $totalPrice = $item['price'] * $quantity;
                                $subtotal += $totalPrice;

                                echo "<div class='cart-item'>";
                                echo "<img src='" . htmlspecialchars($item['image']) . "' alt='" . htmlspecialchars($item['name']) . "'>";
                                echo "<div class='item-details'>";
                                echo "<p>" . htmlspecialchars($item['name']) . "</p>";
                                echo "<p>" . htmlspecialchars($item['description']) . "</p>";
                                echo "<p>Price: $" . htmlspecialchars($item['price']) . "</p>";
                                echo "<p>Quantity: x" . $quantity . "</p>";
                                echo "<p>Amount: $" . $totalPrice . "</p>";
                                echo "</div>";
                                // Quantity form
                                echo "<input type='number' name='items[{$itemId}][quantity]' value='{$quantity}' min='0'>";
                                echo "<button type='submit' name='update' value='{$itemId}'>Update</button>";
                                // Remove button
                                echo "<button type='submit' name='remove' value='{$itemId}'>Remove</button>";
                                echo "</div>"; // Close cart-item
                            }
                        }
                    } else {
                        echo "<p>Your cart is empty!</p>";
                    }
                    ?>
                </div>
                <div class="cart-subtotal">
                    <p>Subtotal: $<?php echo $subtotal; ?></p>
                </div>
                <div class="checkout-button">
                    <button type="submit" name="checkout_button">SUBMIT THE ORDER >></button>
                </div>
            </form>
        </div>
    </div>
</body>


</html>