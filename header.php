<?php
include 'dbcon.php'; // Adjust the path as necessary
session_start();

// Fetch and sending table noumber to js
if (isset($_GET['table'])) {
	$tableNumber = intval($_GET['table']);
	// Store the table number in a session variable or pass directly to JavaScript
	echo "<script>var tableNumber = $tableNumber;</script>";
}

// Check if table number is in the URL and store it in the session
if (isset($_GET['table'])) {
	$_SESSION['table'] = intval($_GET['table']);  // Store table number in session
}

// Ensure the cart session variable is initialized as an array
if (!isset($_SESSION['cart'])) {
	$_SESSION['cart'] = array();
}

// Use the table number from the session if not present in the URL
$tableNumber = isset($_SESSION['table']) ? $_SESSION['table'] : null;

// Handling both AJAX and Form POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	handleCartActions();
}

function handleCartActions()
{
	global $tableNumber; // Ensure you can access this variable inside the function

	// Handling AJAX request for adding items to the cart
	if (isset($_POST['itemId']) && isset($_POST['quantity'])) {
		// Your AJAX handling code...
	}

	// Similar handling for 'update', 'remove' and 'checkout_button'
	// Ensure redirects include the table number if it's available
	if ($tableNumber !== null) {
		header('Location: cart.php?table=' . $tableNumber);
		exit;
	}
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Delixiouz Burger</title>
	<!-- font awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Baloo+Thambi+2:wght@400;600&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Bree+Serif&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&family=Anton&family=Dancing+Script:wght@400..700&family=Rubik+Scribble&family=Shadows+Into+Light&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
	<!-- Increament & Decreament JS -->
	<script type="text/javascript" src="../javascript/quantity_inc_dec.js"></script>
	<style>
		body {
			margin: 0px;
			padding: 0px;
			box-sizing: border-box;
			background-image: url("dataimg/header_background.jpg");
			background-repeat: repeat;
			background-size: contain;
			background-position: center;
		}


		.logo {
			text-align: center;
			width: 75vw;
			margin-left: 10%;
			font-family: Amatic SC, sans-serif;
			font-size: 50px;
		}

		.main-menu {
			width: 100%;
			position: relative;
		}

		.inner-menu {
			display: flex;
			padding: 25px 15px;
			background: #000000b0;
			color: #fff;
			height: 50px;
			background-repeat: no-repeat;
			background-size: cover;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		.inner-menu a {
			color: #fff;
			padding: 5px 10px;
			border-radius: 5px;
			border: 1px solid #fff;
			font-weight: 600;
			text-decoration: none;
		}

		.inner-menu a:hover {
			color: #000;
			background-color: #4CAF50;
			;
			text-decoration: none;
		}

		.menu-grid {
			display: inline-block;
			flex-wrap: wrap;
			margin: 50px;
		}

		.flex-container {
			display: flex;
			flex-wrap: wrap;
			justify-content: flex-start;
			/* Aligns items to the start of the container */
		}

		.flex-item {
			flex: 0 1 calc(33.333% - 20px);
			/* Adjust the percentage for 3 items per row and subtract margin */
			box-sizing: border-box;
			margin: 10px;
		}


		.menu-item {
			background-color: #fff;
			border-radius: 10px;
			overflow: hidden;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			transition: transform 0.3s ease, box-shadow 0.3s ease;
			padding: 15px;
			box-sizing: border-box;
		}

		.menu-item:hover {
			transform: translateY(-5px);
			box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
		}



		.log-reg {
			display: flex;
			align-items: center;
			justify-content: flex-end;
			gap: 20px;
			/* Space between login and cart buttons */
		}

		/* Styling for the Login/Sign up button */
		.log-reg a {
			background-color: #F44336;
			color: #fff;
			padding: 3px 10px;
			border-radius: 5px;
			border: 1px solid #fff;
			font-weight: 600;
			text-decoration: none;
		}


		.log-reg a:hover {
			border: 1px solid #ff105f;
			outline: none;
			color: #ffffff;
			background: linear-gradient(to left, #ff105f, #ffad06);
			box-shadow: 0 0 30px #ff105f, 0 0 60px #ffad06;
			text-decoration: none;
		}

		/* Styling for the Cart button */
		#cart-button {
			background-color: #f0f0f0;
			color: #333;
			border: none;
			padding: 10px 20px;
			border-radius: 5px;
			cursor: pointer;
			font-size: 16px;
			text-decoration: none;
			/* Ensures no underline on the link */
		}


		#cart-button:hover {
			background-color: #e0e0e0;
		}

		/* Styling for the cart count indicator */
		#cart-count {
			background-color: #ff0000;
			color: white;
			border-radius: 50%;
			padding: 2px 6px;
			font-size: 14px;
			margin-left: 8px;
		}



		.menu-item img {
			width: 27vw;
			height: 37vh;
			display: inline-block;
			transition: transform 0.3s ease;
			border-radius: 10px;
		}

		.menu-item:hover img {
			transform: scale(1.05);
		}

		.menu-item h3 {
			font-family: 'Baloo Thambi 2', cursive;
			background: rgba(255, 215, 0, 0.9);
			margin: 0;
			padding: 10px;
			color: #000;
			position: relative;
		}

		.menu-item-description {
			padding: 15px;
			margin: 0;
			background-color: rgba(0, 0, 0, 0.7);
			color: #fff;
		}

		.price {
			font-size: 1.2rem;
			font-weight: bold;
			padding: 10px 15px;
			color: #fff;
			background: green;
			margin: 0;
		}

		.add-to-cart {
			text-align: center;
			padding: 10px;
			background: #ff4500;
			color: #fff;
			font-weight: bold;
			cursor: pointer;
		}

		.add-to-cart:hover {
			background: #e03e00;
		}

		.quantity-controls {
			display: flex;
			justify-content: center;
			padding: 10px;
		}

		.quantity-controls button {
			background: #ddd;
			color: #333;
			border: none;
			padding: 5px 10px;
			margin: 0 5px;
			cursor: pointer;
		}

		.quantity-controls button:hover {
			background: #ccc;
		}

		@media (max-width: 768px) {


			.flex-container {
				flex: 0 1 calc(50% - 20px)
			}


		}

		@media (max-width: 480px) {


			.flex-container {
				flex: 0 1 100%;
				/* 1 item per row on small screens */
				margin: 10px 0;
				/* Adjust margin for small screens */
			}

		}
	</style>
</head>

<body>
	<div class="main-menu sticky-top">

		<div class="inner-menu sticky-top">
			<a href="index.php" style="float: left;">HOME</a>
			<div class="logo">Welcome to Dexlixiouz Burger</div>

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
					echo "<div style='font-family: Amatic SC, sans-serif; float: right; font-weight: bold; color: orange; text; margin-right: 25px; background-color: brown; padding: 10px 10px; border-radius: 10px'>You're now sitting at Table " . htmlspecialchars($tableNumber) . "</div>";
				} else {
					echo "<div style='font-family: Amatic SC, sans-serif; float: right; font-weight: bold; color: orange; text; margin-right: 25px; background-color: brown; padding: 10px 10px; border-radius: 10px'>Table information not found.</div>";
				}
				$stmt->close();
			} else {
				echo "<div style='font-family: Amatic SC, sans-serif; float: right; font-weight: bold; color: orange; text; margin-right: 25px; background-color: brown; padding: 10px 10px; border-radius: 10px'>No table information provided.</div>";
			}
			?>

			<div>
				<div class="log-reg">
					<?php
					if (isset($_SESSION['uid'])) {
					?><a href="ulogin/account.php"><i class="fa fa-user" aria-hidden="true">&nbsp;</i><?php echo $data['name'] ?></a><?php
																																	} else {
																																		?><a href="login.php">Login/Sign up</a><?php
																																											}
																																												?>
				</div>
				<br>
				<a href="cart.php" id="cart-button">
					Cart
					<span id="cart-count">
						<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : '0'; ?>
					</span>
				</a>
			</div>
		</div>

		<!-- Dynamic Menu Items Section -->
		<div class="menu-grid">
			<?php
			$categories = $conn->query("SELECT DISTINCT category FROM menu_items ORDER BY category");

			if ($categories->num_rows > 0) {
				while ($catRow = $categories->fetch_assoc()) {
					$category = $catRow['category'];
					echo "<div class='menu-category mt-4'>";
					echo "<h1 style= 'font-weight: 500; color: peru;'>" . htmlspecialchars($category) . "</h1>";
					echo "<div class='flex-container'>";

					$items = $conn->query("SELECT id, name, description, price, image FROM menu_items WHERE category = '" . $conn->real_escape_string($category) . "'");
					if ($items->num_rows > 0) {
						while ($itemRow = $items->fetch_assoc()) {
							echo "<div class='flex-item'>";
							echo "<div class='menu-item'>";
							echo "<img src='" . htmlspecialchars($itemRow['image']) . "' alt='" . htmlspecialchars($itemRow['name']) . "'>";
							echo "<h3>" . htmlspecialchars($itemRow['name']) . "</h3>";
							echo "<p class='menu-item-description'>" . htmlspecialchars($itemRow['description']) . "</p>";
							echo "<p class='price'>Price: " . htmlspecialchars($itemRow['price']) . "</p>";
							echo "<div class='item-actions'>";
							echo "<button class='quantity-decrease'>-</button>";
							echo "<input type='text' class='quantity-input' value='1' readonly>";
							echo "<button class='quantity-increase'>+</button>";
							echo "<button class='add-to-cart' data-item-id='" . $itemRow['id'] . "' onclick='addToCart(this)'>ADD TO CART</button>";
							echo "</div>";
							echo "</div>"; // Close 'menu-item'
							echo "</div>"; // Close 'flex-item'
						}
					} else {
						echo "<p>No items in this category.</p>";
					}

					echo "</div>"; // Close 'flex-container'
					echo "</div>"; // Close 'menu-category'
				}
			} else {
				echo "<p>0 results found in the menu.</p>";
			}
			$conn->close();
			?>
		</div>

	</div>

	<script>
		function updateQuantity(button, increment) {
			var quantityInput = button.closest('.menu-item').querySelector('.quantity-input');
			var currentQuantity = parseInt(quantityInput.value);
			var newQuantity = increment ? currentQuantity + 1 : currentQuantity - 1;
			quantityInput.value = newQuantity > -1 ? newQuantity : 0; // Prevent quantity from going below 1
		}

		function addToCart(button) {
			var itemId = button.getAttribute('data-item-id');
			var quantityInput = button.closest('.menu-item').querySelector('.quantity-input');
			var quantity = parseInt(quantityInput.value);

			fetch('update_cart.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
					},
					body: 'itemId=' + encodeURIComponent(itemId) + '&quantity=' + encodeURIComponent(quantity)
				})
				.then(response => response.text())
				.then(cartCount => {
					document.getElementById('cart-count').textContent = cartCount;
					alert('Cart updated! Total items: ' + cartCount);
				})
				.catch(error => {
					console.error('Error:', error);
				});
		}

		// Attach event listeners to '+' and '-' buttons
		document.querySelectorAll('.quantity-increase').forEach(button => {
			button.addEventListener('click', function() {
				updateQuantity(this, true);
			});
		});

		document.querySelectorAll('.quantity-decrease').forEach(button => {
			button.addEventListener('click', function() {
				updateQuantity(this, false);
			});
		});



		// Function for adding table number behind the url of other pages
		document.addEventListener('DOMContentLoaded', function() {
			var links = document.querySelectorAll('a'); // Select all links
			links.forEach(function(link) {
				var href = link.getAttribute('href');
				if (href) {
					link.setAttribute('href', href + (href.includes('?') ? '&' : '?') + 'table=' + tableNumber);
				}
			});
		});
	</script>