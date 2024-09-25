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

    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $category = $_POST['category'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO apply_now (name, email, phone, category) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $category);

    // Execute the query
    if ($stmt->execute()) {
        echo '<script type="text/javascript">
                alert("Your application has been submitted successfully!");
                window.location.href = "index.php";
              </script>';
    } else {
        echo '<script type="text/javascript">
                alert("There was an error submitting your application. Please try again.");
                window.location.href = "index.php";
              </script>';
    }

    // Close the statement and connection
    $stmt->close();
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
    <meta name="description" content="BadaStep: Apply Now" />

    <!-- OG -->
    <meta property="og:title" content="Apply Now | BadaStep Website" />
    <meta property="og:description" content="Apply for your desired course with BadaStep." />
    <meta property="og:image" content="" />
    <meta name="format-detection" content="telephone=no">

    <!-- FAVICONS ICON ============================================= -->
    <link rel="icon" href="assets/images/final-logo.png" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/final-logo.png" />

    <!-- PAGE TITLE HERE ============================================= -->
    <title>Apply Now | BadaStep Website</title>

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
                <a href="index.php"><img src="assets/images/final-logo.png" alt=""></a>
            </div>
            <div class="account-form-inner">
                <div class="account-container">
                    <div class="heading-bx left">
                        <h2 class="title-head">Apply for Your <span>Desired Course</span></h2>
                        <p>Already have an account? <a href="login.php">Login here</a></p>
                    </div>
                    <form class="contact-bx" action="" method="POST">
                        <div class="row placeani">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Full Name</label>
                                        <input name="name" type="text" required="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Email Address</label>
                                        <input name="email" type="email" required="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Phone Number</label>
                                        <input name="phone" type="tel" required="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Select Course Category</label>
                                        <select name="category" required="" class="form-control">
                                            <option value="">-- Select Category --</option>
                                            <option value="engineering">Engineering</option>
                                            <option value="medical">Medical</option>
                                            <option value="management">Management</option>
                                            <option value="agriculture">Agriculture</option>
                                            <option value="pharmacy">Pharmacy</option>
                                            <option value="paramedical">Paramedical</option>
                                            <option value="nursing">Nursing</option>
                                            <option value="veterinary_science">Veterinary Science</option>
                                            <option value="fisheries_science">Fisheries Science</option>
                                            <option value="applied_science">Applied Science</option>
                                            <option value="law">Law</option>
                                            <option value="polytechnic">Polytechnic</option>
                                            <option value="international_studies">International Studies</option>
                                            <option value="fire_and_safety">Fire and Safety</option>
                                            <option value="architecture_and_design">Architecture and Design</option>
                                            <option value="arts">Arts</option>
                                            <option value="mass_communication">Mass Communication</option>
                                            <option value="hotel_management">Hotel Management</option>
                                            <option value="aviation">Aviation</option>
                                            <option value="online_education">Online Education</option>
                                            <option value="computer_applications">Computer Applications</option>
                                            <option value="skill_development">Skill Development</option>
                                            <option value="ayurvedic">Ayurvedic</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 m-b30">
                                <button name="submit" type="submit" value="Submit" class="btn button-md">Apply Now</button>
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
