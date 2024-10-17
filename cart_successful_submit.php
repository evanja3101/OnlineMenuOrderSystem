<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission successful</title>
    <!-- Redirect to header.php after 3 seconds -->
    <meta http-equiv="refresh" content="3;url=header.php">
</head>
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }

    .close-btn {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-btn:hover,
    .close-btn:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<body>
    <div id="orderSuccessModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <p>Your order has been submitted successfully! Redirecting to Menu in 3 seconds...</p>
        </div>
    </div>


</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const orderSubmitted = urlParams.get('orderSubmitted');

        if (orderSubmitted === 'true') {
            var modal = document.getElementById("orderSuccessModal");
            var span = document.getElementsByClassName("close-btn")[0];

            modal.style.display = "block";

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        }
    });

    setTimeout(function() {
        window.location.href = "header.php";
    }, 3000); // Redirect after 3 seconds

    
</script>

</html>