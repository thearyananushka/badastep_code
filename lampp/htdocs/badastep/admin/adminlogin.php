<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database configuration
    $host = 'localhost'; // Change to your database host
    $dbname = 'badastep'; // Change to your database name
    $username = 'root'; // Change to your database username
    $password = ''; // Change to your database password

    // Create a connection
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Set fixed username and password
    $fixedUsername = 'totaltechstudio';
    $fixedPassword = 'badastep';

    // Retrieve form data
    $name = $_POST['dzName'];
    $password = $_POST['dzPassword']; // Changed to 'dzPassword' to match input name

    // Check if the credentials match
    if ($name === $fixedUsername && $password === $fixedPassword) {
        echo '<script type="text/javascript">
                alert("Login successful!");
                window.location.href = "index.php"; // Redirect to index.php
              </script>';
    } else {
        echo '<script type="text/javascript">
                alert("Invalid username or password. Please try again.");
                window.location.href = "login.php";
              </script>';
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META ============================================= -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />

    <!-- DESCRIPTION -->
    <meta name="description" content="BadaStep Website" />

    <!-- OG -->
    <meta property="og:title" content="BadaStep Website" />
    <meta property="og:description" content="BadaStep Website" />
    <meta property="og:image" content="" />
    <meta name="format-detection" content="telephone=no">

    <!-- FAVICONS ICON ============================================= -->
    <link rel="icon" href="assets/images/final-logo.png" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/final-logo.png" />

    <!-- PAGE TITLE HERE ============================================= -->
    <title>BadaStep Website</title>

    <!-- MOBILE SPECIFIC ============================================= -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- All PLUGINS CSS ============================================= -->
    <link rel="stylesheet" type="text/css" href="assets/css/assets.css">

    <!-- TYPOGRAPHY ============================================= -->
    <link rel="stylesheet" type="text/css" href="assets/css/typography.css">

    <!-- SHORTCODES ============================================= -->
    <link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">

    <!-- STYLESHEETS ============================================= -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">
</head>

<body id="bg">
    <div class="page-wraper">
        <div id="loading-icon-bx"></div>
        <div class="account-form">
            <div class="account-head" style="background-image:url(assets/images/background/bg2.jpg);">
                <a href="index.html"><img src="assets/images/final-logo.png" alt=""></a>
            </div>
            <div class="account-form-inner">
                <div class="account-container">
                    <div class="heading-bx left">
                        <h2 class="title-head">Admin Login  <span>Account</span></h2>
                        <!-- Removed the "Create one here" line -->
                    </div>
                    <form class="contact-bx" action="" method="POST">
                        <div class="row placeani">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Your Name</label>
                                        <input name="dzName" type="text" required="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Your Password</label>
                                        <input name="dzPassword" type="password" class="form-control" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group form-forget">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                                        <label class="custom-control-label" for="customControlAutosizing">Remember me</label>
                                    </div>
                                    <a href="forget-password.html" class="ml-auto">Forgot Password?</a>
                                </div>
                            </div>
                            <div class="col-lg-12 m-b30">
                                <button name="submit" type="submit" value="Submit" class="btn button-md">Login</button>
                            </div>
                            <div class="col-lg-12">
                                <h6>Login with Social media</h6>
                                <div class="d-flex">
                                    <a class="btn flex-fill m-r5 facebook" href="#"><i class="fa fa-facebook"></i>Facebook</a>
                                    <a class="btn flex-fill m-l5 google-plus" href="#"><i class="fa fa-google-plus"></i>Google Plus</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- External JavaScripts -->
    <script src="assets/js/jquery.min.js"></script>
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