<?php
include('../dbcon.php');
?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">


    <style type="text/css">
        .abc button {
            width: 350px;
            font-size: 20px;
        }

        body {
            background-image: url("admin_image/Catering_Menu_Background.jpg");
        }

        .table_detail {
            background-color: gainsboro;
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <div align="center" class="bg-dark text-light pt-4 pb-4">
        <a href="../logout.php"><button style="float: right;" class="btn btn-danger mr-3">LOGOUT</button></a>
        <a href="admindash.php"><button style="float: left;" class="btn btn-success ml-3">
                << BACK</button></a>
        <h1>QR CODE MANAGEMENT</h1>
    </div>

    <table align="center" border="1" width="70%" style="margin-top: 20px;" class="mb-5">
        <tr style="background-color: black; color: white;" align="center">
            <th width="20">Table ID</th>
            <th width="20">Table Number</th>
            <th width="100">QR Code Image</th>
            <th width="100">Update</th>
            <th width="100">Delete</th>
        </tr>

        <?php

        include('../dbcon.php');

        $query = "SELECT * FROM `restaurant_tables` ";
        $run = mysqli_query($conn, $query);

        if (mysqli_num_rows($run) < 1) {
            echo "<tr><td colspan='5' align='center'>No data found</td><tr>";
        } else {
            while ($data = mysqli_fetch_assoc($run)) {
        ?>
                <tr class="table_detail" align="center">
                    <td> <?php echo $data['id']; ?> </td>
                    <td> <?php echo $data['table_number']; ?> </td>
                    <td> <img src="../qrcode_images/ echo $data['qr_code_path'] ?>" style="max-width:100px;max-height: 100px;"></td>
                    <td> <a href="qrcode_update.php?sid=<?php echo $data['id']; ?>"> Update </a></td>
                    <td> <a href="qrcode_delete.php?sid=<?php echo $data['id']; ?>"> Delete </a></td>
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