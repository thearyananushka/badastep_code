<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database configuration
    $servername = "localhost"; // Your server name (e.g., localhost)
    $username = "root"; // Your database username
    $password = ""; // Your database password
    $dbname = "badastep"; // Your database name

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $currentInstitution = $_POST['currentInstitution'];
    $degreeProgram = $_POST['degreeProgram'];
    $gpa = $_POST['gpa'];
    $essay = $_POST['essay'];
    $reference = $_POST['reference']; // Added reference field

    // Check if any of the required fields are empty
    if (empty($fullName) || empty($email) || empty($phone) || empty($address) || empty($currentInstitution) || empty($degreeProgram) || empty($gpa) || empty($essay) || empty($reference)) {
        echo '<script type="text/javascript">
                alert("All fields are required.");
                window.location.href = "scholarship.php";
              </script>';
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO scholarship (full_name, email, phone, address, current_institution, degree_program, gpa, essay, reference) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sssssssss", $fullName, $email, $phone, $address, $currentInstitution, $degreeProgram, $gpa, $essay, $reference);

        // Execute the query
        if ($stmt->execute()) {
            echo '<script type="text/javascript">
                    alert("Application submitted successfully!");
                    window.location.href = "scholarship.php";
                  </script>';
        } else {
            echo '<script type="text/javascript">
                    alert("There was an error submitting your application. Please try again.");
                    window.location.href = "scholarship.php";
                  </script>';
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="BadaStep Scholarship Application" />
    <link rel="icon" href="assets/images/final-logo.png" type="image/x-icon" />
    <title>BadaStep Scholarship Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="assets/css/assets.css">
    <link rel="stylesheet" type="text/css" href="assets/css/typography.css">
    <link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">
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
                        <h2 class="title-head">Scholarship Application Form</h2>
                        <p>Fill out the form below to apply for the scholarship.</p>
                    </div>
                    <form class="contact-bx" action="" method="POST">
                        <div class="row placeani">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Full Name:</label>
                                        <input name="fullName" type="text" required="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Email Address:</label>
                                        <input name="email" type="email" required="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Phone Number:</label>
                                        <input name="phone" type="tel" required="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Address:</label>
                                        <input name="address" type="text" required="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Current Institution:</label>
                                        <input name="currentInstitution" type="text" required="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Degree Program:</label>
                                        <input name="degreeProgram" type="text" required="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Current GPA:</label>
                                        <input name="gpa" type="number" step="0.01" required="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Personal Statement (Essay):</label>
                                        <textarea name="essay" rows="6" required="" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- Reference field -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label>Reference:</label>
                                        <input name="reference" type="text" required="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 m-b30">
                                <button name="submit" type="submit" value="Submit" class="btn button-md">Submit Application</button>
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
    <script src="assets/js/functions.js"></script>
</body>
</html>





