<?php
$servername = "localhost";
$username = "root";
$password = ""; // your MySQL root password
$dbname = "badastep";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password for security

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO register (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        // Successful registration alert
        echo "<script>
            $(document).ready(function(){
                alert('Account created successfully!');
                window.location.href = 'index.php'; // Redirect to homepage or login page
            });
        </script>";
    } else {
        echo "<script>
            $(document).ready(function(){
                alert('Error: " . $stmt->error . "');
            });
        </script>";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BadaStep Website - Signup</title>
    <link rel="stylesheet" type="text/css" href="assets/css/assets.css">
    <link rel="stylesheet" type="text/css" href="assets/css/typography.css">
    <link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body id="bg">

<div class="page-wraper">
    <div class="account-form">
        <div class="account-head" style="background-image:url(assets/images/background/bg2.jpg);">
            <a href="index.html"><img src="assets/images/final-logo.png" alt=""></a>
        </div>
        <div class="account-form-inner">
            <div class="account-container">
                <div class="heading-bx left">
                    <h2 class="title-head">Sign Up <span>Now</span></h2>
                    <p>Already have an account? <a href="login.html">Login here</a></p>
                </div>
                <form method="POST" class="contact-bx">
                    <div class="row placeani">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <label>Your Name</label>
                                    <input name="name" type="text" required="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <label>Your Email Address</label>
                                    <input name="email" type="email" required="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="input-group"> 
                                    <label>Your Password</label>
                                    <input name="password" type="password" class="form-control" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 m-b30">
                            <button name="submit" type="submit" class="btn button-md">Sign Up</button>
                        </div>
                        <div class="col-lg-12">
                            <h6>Sign Up with Social media</h6>
                            <div class="d-flex">
                                <a class="btn flex-fill m-r5 facebook" href="#"><i class="fa fa-facebook"></i> Facebook</a>
                                <a class="btn flex-fill m-l5 google-plus" href="#"><i class="fa fa-google-plus"></i> Google Plus</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- External JavaScripts -->
<script src="assets/vendors/bootstrap/js/popper.min.js"></script>
<script src="assets/vendors/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendors/bootstrap-select/bootstrap-select.min.js"></script>
<script src="assets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
<script src="assets/vendors/magnific-popup/magnific-popup.js"></script>
<script src="assets/vendors/counter/waypoints-min.js"></script>
<script src="assets/vendors/counter/counterup.min.js"></script>
<script src="assets/vendors/imagesloaded/imagesloaded.js"></script>
<script src="assets/vendors/masonry/masonry.js"></script>
<script src="assets/vendors/masonry/filter.js"></script>
<script src="assets/vendors/owl-carousel/owl.carousel.js"></script>
<script src="assets/js/functions.js"></script>
<script src="assets/js/contact.js"></script>
<script src='assets/vendors/switcher/switcher.js'></script>
</body>
</html>