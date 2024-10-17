<?php

session_start();

if (isset($_SESSION['aid'])) {
	header('location: admindash.php');
}

?>

<!DOCTYPE html>
<html>

<head>
	<title> Delixiouz Burger/Login </title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
</head>
<style>
	body {
		font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		background-image: url("admin_image/Catering_Menu_Background.jpg");
		margin: 0;
		padding: 0;
	}

	.bg-dark {
		background: linear-gradient(to right, #a52a2a, #a0522d);
		padding: 20px 0;
	}

	.banner {
		background-color: darkgrey;
		text-align: center;
		color: firebrick;
		padding-top: 10px;
		padding-bottom: 10px;
		margin-top: 30px;
		width: 50vw;
		border-radius: 15px;
		margin: auto;
	}

	.btn {
		border: none;
		padding: 10px 20px;
		border-radius: 5px;
		transition: all 0.3s ease;
	}

	.btn-success {
		background-color: #ff416c;
	}

	.btn-success:hover {
		background-color: #e63a5e;
		/* Darker shade on hover */
	}

	.btn-danger {
		background-color: #ff4b2b;
		/* Orange for back button */
	}

	.btn-danger:hover {
		background-color: #e64515;
		/* Darker shade on hover */
	}

	.text-center {
		text-align: center;
	}

	.text-light {
		color: #ffffff;
	}

	.container {
		width: 90%;
		margin: 40px auto;
		background-color: darkgray;
		color: #333333;
		border-radius: 8px;
		padding: 20px;
		box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
	}

	table {
		width: 100%;
		border-collapse: collapse;
	}

	td {
		padding: 12px;
		border-bottom: 2px solid #dee2e6;
	}

	input[type="text"],
	input[type="password"],
	input[type="submit"] {
		width: 100%;
		padding: 8px;
		border: 1px solid #ccc;
		border-radius: 4px;
	}

	input[type="submit"] {
		background: linear-gradient(to right, #ff416c, #ff4b2b);
		color: white;
		font-size: 16px;
		cursor: pointer;
		border: none;
	}

	input[type="submit"]:hover {
		background: linear-gradient(to right, #e63a5e, #e64515);
	}

	h1 {
		margin-bottom: 20px;
	}
</style>

<body>

	<div class=" bg-dark pt-3 pb-3">
		<a href="../index.php"><button type="button" class="btn btn-success ml-3" style="float:right;">HOME</button></a>
		<a href="../login.php"><button type="button" class="btn btn-danger mr-3" style="float:left;">
				<< Back</button></a>
		<h1 class="text-center text-light">Delixiouz Burger</h1>
	</div>
	<div class="banner">
		<h1 class="banner">ADMIN LOGIN</h1>
	</div>

	<div class="container mt-5 pt-5">
		<table align="center">
			<form action="adminlogin.php" method="post">
				<tr>
					<td>Username</td>
					<td><input type="text" name="uname" value="admin" required></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" name="pass" value="admin" required></td>
				</tr>
				<tr>
					<td colspan="2" align="center" height="80">
						<input type="submit" name="login" value="login">
					</td>
				</tr>
			</form>
		</table>
	</div>

	<script src="bootstrap/jss/jquery.min.js"></script>
	<script src="bootstrap/jss/popper.min.js"></script>
	<script src="bootstrap/jss/bootstrap.min.js"></script>
</body>

</html>

<?php

include('../dbcon.php');

if (isset($_POST['login'])) {
	$uname = trim($_POST['uname']);
	$pass = trim($_POST['pass']);

	// Debugging: Check input values
	// echo "Username: $uname , Password: $pass";

	$query = "SELECT * FROM `admin_register` WHERE `uname` = ? AND `password` = ?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ss", $uname, $pass);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->num_rows;

	if ($row < 1) {
?>
		<script>
			alert("Username and Password not match");
			window.open('adminlogin.php', '_self');
		</script>
<?php
	} else {
		$data = $result->fetch_assoc();
		$_SESSION['aid'] = $data['admin_id'];
		header('location: admindash.php');
	}
}
?>