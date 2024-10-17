<?php

include('../dbcon.php');

$sid = $_GET['table_number'];
$query = "DELETE FROM `restaurant_tables` WHERE `id` = '$sid'";

$run = mysqli_query($conn, $query);

if ($run == true) {
?>

    <script type="text/javascript">
        alert("Item Deleted Successfully!");
        window.open('admindash.php?sid=<?php echo $sid ?>', '_self');
    </script>

<?php
}

?>