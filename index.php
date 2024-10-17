<?php
session_start();
if (isset($_SESSION['uid'])) {
	include('dbcon.php');
	$uid = $_SESSION['uid'];
	$query = "SELECT * FROM `user` WHERE `id` = '$uid'";
	$run = mysqli_query($conn, $query);
	$data = mysqli_fetch_assoc($run);
} else {
}

// Fetch and sending table noumber to js
if (isset($_GET['table'])) {
	$tableNumber = intval($_GET['table']);
	// Store the table number in a session variable or pass directly to JavaScript
	echo "<script>var tableNumber = $tableNumber;</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>DeliXiouz Burgers </title>
	<!-- font awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<!-- Google font -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Anton&family=Dancing+Script:wght@400..700&family=Rubik+Scribble&display=swap" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Anton&family=Dancing+Script:wght@400..700&family=Rubik+Scribble&family=Shadows+Into+Light&display=swap" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&family=Anton&family=Dancing+Script:wght@400..700&family=Rubik+Scribble&family=Shadows+Into+Light&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
	<style>
		body {
			margin: 0px;
			padding: 0px;
			box-sizing: border-box;
		}

		.main {
			background-image: url("dataimg/burgermain_page.jpg");
			background-position: top, center;
			background-size: contain;
			background-repeat: repeat;
			width: 100vw;
			height: 100vh;
		}

		.logout a {
			float: right;
			margin: 15px 2px;
			padding: 5px 10px;
			border-radius: 5px;
			border: 1px solid #F44336;
			font-weight: 600;
			text-decoration: none;
			color: #fff;
			background-color: #F44336;
		}

		.log-reg a {
			background-color: #F44336;
			color: #fff;
			float: right;
			margin: 15px 2px;
			padding: 5px 10px;
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

		.fa:hover {
			color: #000 !important;
		}

		.site-title {
			position: absolute;
			top: 15%;
			left: 50%;
			-webkit-transform: translate(-50%);
			transform: translate(-50%, -50%);
			z-index: 2;
			font-family: 'Knewave', cursive;
		}

		.site-title h1 {
			font-size: 8.0rem;
			line-height: 50px;
			font-weight: 400;
			color: #fff;
			font-family: "Amatic SC", sans-serif;
			background-color: rgba(205, 18, 18, 0.4);
			padding: 15px;
			border-radius: 20px;
			display: block;
			/* Wrap content */
			margin-top: 0em;
			/* Space from the top */
		}

		.site-title_2 h2 {
			font-size: 1.7rem;
			line-height: 50px;
			font-weight: 400;
			color: burlywood;
			position: static;
			font-family: "Dancing Script", cursive;
			left: 30px;
			border: 2mm ridge peru;
			border-radius: 15px;
			padding: 10px;
		}


		.site-menu {
			position: absolute;
			top: 90%;
			left: 50%;
			-webkit-transform: translate(-50%);
			transform: translate(-50%, -50%);
			z-index: 2;
			font-family: 'Montserrat', sans-serif;
		}

		.site-menu a {
			background-color: #F44336;
			border: 1px solid #fff;
			border-radius: 15px;
			padding: 12px 35px;
			margin: 0 5px;
			outline: none;
			color: #fff;
			font-size: 2rem;
			font-weight: 600;
			line-height: 1.4;
			text-align: center;
			text-decoration: none;
			transition: 0.3s;
		}

		.site-menu a:hover {
			border: 1px solid #ff105f;
			outline: none;
			color: #ffffff;
			background: linear-gradient(to left, #ff105f, #ffad06);
			box-shadow: 0 0 30px #ff105f, 0 0 60px #ffad06;
			text-decoration: none;
		}

		.overlay {
			position: absolute;
			top: 50%;
			left: 50%;
			-webkit-transform: translate(-50%);
			transform: translate(-50%, -50%);
			z-index: 2;
			font-family: 'Montserrat', sans-serif;
		}

		.qr-code-background {
			background-color: rgba(73, 65, 54, 0.8);
			/* Vibrant orange with transparency */
			padding: 10px;
			border-radius: 15px;
			/* Rounded corners */
			display: block;
			/* Wrap content */
			margin-top: 100px;
			/* Space from the top */
		}

		.table-number {
			font-size: 18px;
			font-weight: 300;
			color: #000;
			text-align: center;
			margin-top: 20px;
		}


		@media screen and (max-width: 968px) and (min-width: 579px) {
			.site-title h1 {
				font-size: 1.7rem;
			}


			.site-title_2 h2 {
				font-size: 0.7rem;
			}
		}

		@media screen and (max-width: 579px) {
			.site-title h1 {
				font-size: 1.7rem;
			}

			.site-title_2 h2 {
				font-size: 0.8rem;
			}

			.site-steps {
				top: 70%;
			}

			.site-menu {
				top: 95%;
			}
		}
	</style>

</head>

<body>
	<div class="main">
		<div class="logout">
			<?php
			if (isset($_SESSION['uid'])) {
			?><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true">&nbsp;</i>Logout</a><?php
																								} else {
																								}
																									?>
		</div>
		<div class="log-reg">
			<?php
			if (isset($_SESSION['uid'])) {
			?><a href="ulogin/account.php"><i class="fa fa-user" aria-hidden="true">&nbsp;</i><?php echo $data['name'] ?></a><?php
																															} else {
																																?><a href="login.php">Login/Sign up</a><?php
																																									}
																																										?>
		</div>

		<div class="site-title">
			<h1>DeliXiouz Burgers</h1>

		</div>


	</div>


	<div class="overlay">

		<div class="qr-code-background">
			<div class="site-title_2">
				<h2>Life is more wonderful with our exceptional burger, Our burger shop was founded since 1982, enjoy and take a seats and make your order</h2>
			</div>
			<?php
			require_once 'dbcon.php';

			// Check if the 'table' query parameter is set
			if (isset($_GET['table'])) {
				$tableNumber = intval($_GET['table']); // Get the table number and ensure it's an integer

				// Fetch the QR code path from the database
				$stmt = $conn->prepare("SELECT qr_code_path FROM restaurant_tables WHERE table_number = ?");
				$stmt->bind_param("i", $tableNumber);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					$qrCodePath = $row['qr_code_path'];
					// Display the QR code and a message about the table number
					echo "<div style='text-align:center;'>";
					echo "<img src='" . htmlspecialchars($qrCodePath) . "' alt='QR Code for Table " . $tableNumber . "'>";
					echo "<p style='font-family: Amatic SC, sans-serif; font-size: 30px; color: #fff; text-align: center; margin-top: 20px;'>You are sitting at table number " . htmlspecialchars($tableNumber) . ".</p>";
					echo "</div>";
				} else {
					echo "<p>Table information not found.</p>";
				}
				$stmt->close();
			} else {
				echo "<p style='color: orange; text-align: center'; font-family: Amatic SC, sans-serif'>No table information provided.</p>";
			}
			?>
		</div>
	</div>

	<div class=" site-menu">
		<?php
		if (isset($_SESSION['uid'])) {
		?><a href="header.php">MENU</a><?php
									} else {
										?><a href="header.php">MENU</a><?php
																	} ?>
	</div>

	<script src="bootstrap/js/jquery.min.js"></script>
	<script src="bootstrap/js/popper.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
<script>
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

</html>