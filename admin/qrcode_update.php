<?php

include('../dbcon.php');

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0; // Sanitize and validate input as an integer

if ($sid > 0) {
    $stmt = $conn->prepare("SELECT * FROM `restaurant_tables` WHERE `id` = ?");
    if ($stmt) {
        $stmt->bind_param("i", $sid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            // Proceed with your logic using $data
        } else {
            echo "No record found.";
            // Handle no data found scenario
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
        // Handle SQL preparation errors
    }
} else {
    echo "Invalid ID provided.";
    // Handle error when ID is invalid or not provided
}

?>


<!DOCTYPE html>
<html>

<head>
    <title>Update QR Code</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <style type="text/css">
        .abc {
            border-radius: 50px;
            padding-bottom: 50px;
            margin-left: 50px;
            margin-right: 50px;
            background-color: #24262dd9;
        }
    </style>
</head>

<body>
    <div align="center" class="bg-dark text-light pt-4 pb-4">
        <a href="../logout.php"><button style="float: right;" class="btn btn-danger mr-3">LOGOUT</button></a>
        <a href="menudb.php"><button style="float: left;" class="btn btn-success ml-3">
                << BACK</button></a>
        <h1>UPDATE QR CODE DETAILS</h1>
    </div>

    <div class="text-light abc">
        <div class="text-center mt-5 pt-5">
            <h1>Update QR Code for Table</h1>
        </div>

        <table align="center" style="margin-top: 50px;" cellpadding="3">
            <form action="updateitem2.php" method="post" enctype="multipart/form-data">
                <tr>
                    <td>Table Number</td>
                    <td>
                        <input type="number" name="table_number" value="<?php echo $data['table_number']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>QR Code Image</td>
                    <td>
                        <input type="file" name="qr_code" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="sid" value="<?php echo $data['id']; ?>">
                    </td>
                    <td colspan="2" align="center">
                        <br><input type="submit" name="submit" value="UPDATE" class="btn btn-success" style="width: 150px;">
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