<!DOCTYPE html>
<html>

<head>
	<title>Menu Database</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
</head>
<style>
	body {
		background-image: url("admin_image/Catering_Menu_Background.jpg");
	}

	.enter_prompt {
		color: dodgerblue;
		background-color: gainsboro;
		border-radius: 10px;
		padding: 5px 5px;
		margin: 10px 10px;
		opacity: 0.9;
	}

	.menu_table {
		background-color:gainsboro;
		opacity: 0.8;
	}
</style>

<body>
	<div align="center" class="bg-dark text-light pt-4 pb-4">
		<a href="../logout.php"><button style="float: right;" class="btn btn-danger mr-3">LOGOUT</button></a>
		<a href="admindash.php"><button style="float: left;" class="btn btn-success ml-3">
				<< BACK</button></a>
		<h1>UPDATE ITEMS</h1>
	</div>

	<table align="center" style="margin-top: 20px">
		<form action="updateitem.php" method="post">
			<tr>
				<th class="enter_prompt">Enter Item Name</th>
				<td>
					<input type="text" name="name" placeholder="Enter Item Name" required>
				</td>
				<td>
					<input type="submit" name="submit" value="Search" class="btn btn-primary">
				</td>
			</tr>
		</form>
	</table>

	<table align="center" border="1" width="85%" style="margin-top: 20px;">
		<tr style="background-color: grey; color: skyblue;" align="center">
			<th width="100">No.</th>
			<th width="250">Name</th>
			<th>Type</th>
			<th>Detail</th>
			<th>Price</th>
			<th width="300">Image</th>
			<th>Edit</th>
		</tr>
		<?php
		include('../dbcon.php');
		$query = "SELECT * FROM `menu_items`";
		if (isset($_POST['submit'])) {
			$name = $_POST['name'];
			$query .= " WHERE `name` LIKE '%$name%'";
		}
		$run = mysqli_query($conn, $query);

		if (mysqli_num_rows($run) < 1) {
			echo "<tr><td colspan='7' align='center'>No data found</td><tr>";
		} else {
			$count = 0;
			while ($data = mysqli_fetch_assoc($run)) {
				$count++;
		?>
				<tr class="menu_table" align="center">
					<td><?php echo $count; ?></td>
					<td><?php echo $data['name']; ?></td>
					<td><?php echo $data['category']; ?></td>
					<td><?php echo $data['description']; ?></td>
					<td><?php echo $data['price']; ?></td>
					<td><img src="../dataimg/<?php echo $data['image']; ?>" style="max-width:100px;max-height: 100px;"></td>
					<td> <a href="updateitem1.php?sid=<?php echo $data['id']; ?>">EDIT</a></td>
				</tr>
		<?php
			}
		}
		?>
	</table>

	<script src="bootstrap/jss/jquery.min.js"></script>
	<script src="bootstrap/jss/popper.min.js"></script>
	<script src="bootstrap/jss/bootstrap.min.js"></script>
</body>

</html>