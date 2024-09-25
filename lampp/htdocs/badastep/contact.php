<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost"; // Change to your server
    $username = "root"; // Change to your database username
    $password = ""; // Change to your database password
    $dbname = "badastep"; // Change to your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO contact (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

    // Set parameters and execute
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];


	if ($stmt->execute()) {
        echo '<script type="text/javascript">
                alert("Message received successfully!");
                window.location.href = "index.php";
              </script>';
    } else {
        echo '<script type="text/javascript">
                alert("Error");
                window.location.href = "contact.php";
              </script>';
    }

	// if ($stmt->execute()) {
	// 	echo "<script>alert('Your message received successfully');
	// 	window.location.href = "index.php";
	// 	</script>";

	// } else {
	// 	echo "<script>alert('Error: " . $stmt->error . "');</script>";
	// }
    
    // if ($stmt->execute()) {
    //     echo "New record created successfully";
    // } else {
    //     echo "Error: " . $stmt->error;
    // }

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
	<meta name="description" content="BadaStep" />
	
	<!-- OG -->
	<meta property="og:title" content="BadaStep" />
	<meta property="og:description" content="BadaStep" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/images/finallogo.png" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/finallogo.png" />
	
	<!-- PAGE TITLE HERE ============================================ -->
	<title>BadaStep </title>
	
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
	<!-- Header Top ==== -->
    <header class="header rs-nav">
		<div class="top-bar">
			<div class="container">
				<div class="row d-flex justify-content-between">
					<div class="topbar-left">
						<ul>
							<li><a href="faq-1.php"><i class="fa fa-question-circle"></i>Ask a Question</a></li>
							<li><a href="javascript:;"><i class="fa fa-envelope-o"></i>https://badastep.com</a></li>
						</ul>
					</div>
					<div class="topbar-right">
						<ul>
							<li>
								<select class="header-lang-bx">
									<option data-icon="flag flag-uk">English UK</option>
									<option data-icon="flag flag-us">English US</option>
								</select>
							</li>
							<li><a href="login.php">Login</a></li>
							<li><a href="register.php">Register</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="sticky-header navbar-expand-lg">
            <div class="menu-bar clearfix">
                <div class="container clearfix">
					<!-- Header Logo ==== -->
					<div class="menu-logo">
						<a href="index.php"><img src="assets/images/finallogo.png" width="500px" alt=""></a>
					</div>
					<!-- Mobile Nav Button ==== -->
                    <button class="navbar-toggler collapsed menuicon justify-content-end" type="button" data-toggle="collapse" data-target="#menuDropdown" aria-controls="menuDropdown" aria-expanded="false" aria-label="Toggle navigation">
						<span></span>
						<span></span>
						<span></span>
					</button>
					<!-- Author Nav ==== -->
                    <div class="secondary-menu">
                        <div class="secondary-inner">
                            <ul>
								<li><a href="javascript:;" class="btn-link"><i class="fa fa-facebook"></i></a></li>
								<li><a href="javascript:;" class="btn-link"><i class="fa fa-google-plus"></i></a></li>
								<li><a href="javascript:;" class="btn-link"><i class="fa fa-linkedin"></i></a></li>
								<!-- Search Button ==== -->
								<li class="search-btn"><button id="quik-search-btn" type="button" class="btn-link"><i class="fa fa-search"></i></button></li>
							</ul>
						</div>
                    </div>
					<!-- Search Box ==== -->
                    <div class="nav-search-bar">
                        <form action="#">
                            <input name="search" value="" type="text" class="form-control" placeholder="Type to search">
                            <span><i class="ti-search"></i></span>
                        </form>
						<span id="search-remove"><i class="ti-close"></i></span>
                    </div>
					<!-- Navigation Menu ==== -->
                    <div class="menu-links navbar-collapse collapse justify-content-start" id="menuDropdown">
						<div class="menu-logo">
							<a href="index.php"><img src="assets/images/final-logo.jpeg" alt=""></a>
						</div>
                        <ul class="nav navbar-nav">	
						<li class="active"><a href="index.php">Home </a><a href="javascript:;"></a>
								
							</li>
							<li class="active"><a href="about.php">About Us </a><a href="javascript:;"></a>
								
							</li>
							<li class="active"><a href="courses.php">Courses </a><a href="javascript:;"></a>
								
							</li>
							<li class="active"><a href="event.php">Events </a><a href="javascript:;"></a>
								
							</li>
							<li class="active"><a href="blog.php">Blogs </a><a href="javascript:;"></a>
								
							</li>
							<li class="active"><a href="scholarship.php">Scholarship </a><a href="javascript:;"></a>
								
							</li>
							
							<li class="active"><a href="contact.php">Contact </a><a href="javascript:;"></a>
								
							</li>
							
							
						</ul>
						<div class="nav-social-link">
							<a href="javascript:;"><i class="fa fa-facebook"></i></a>
							<a href="javascript:;"><i class="fa fa-google-plus"></i></a>
							<a href="javascript:;"><i class="fa fa-linkedin"></i></a>
						</div>
                    </div>
					<!-- Navigation Menu END ==== -->
                </div>
            </div>
        </div>
    </header>
    <!-- header END ==== -->
    <!-- Content -->
    <div class="page-content bg-white">
    <!-- inner page banner -->
    <div class="page-banner ovbl-dark" style="background-image:url(assets/images/banner/banner3.jpg);">
        <div class="container">
            <div class="page-banner-entry">
                <h1 class="text-white">Contact Us For More</h1>
            </div>
        </div>
    </div>
    <!-- Breadcrumb row -->
    <div class="breadcrumb-row">
        <div class="container">
            <ul class="list-inline">
                <li><a href="#">Home</a></li>
                <li>Contact Us</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb row END -->

    <!-- inner page banner -->
	<div class="page-banner contact-page section-sp2">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5 m-b30">
                <div class="bg-primary text-white contact-info-bx">
                    <h2 class="m-b10 title-head">Contact <span>Information</span></h2>
                    <p>Have a question? Need Some Help? Or Just want to say hello? We would love to hear from you.</p>
                    
                    <div class="widget widget_getintuch">
                        <h5 class="m-t0 m-b20">We Are Located At</h5>
                        <ul>
                            <li><i class="ti-location-pin"></i>C-22 Harmukh apartments, Alpha -1, Greater Noida</li>
                            <li><i class="ti-mobile"></i>9876543210 (24/7 Support Line)</li>
                            <li><i class="ti-email"></i>info@example.com</li>
                        </ul>
                    </div>
                    <h5 class="m-t0 m-b20">Follow Us</h5>
                    <ul class="list-inline contact-social-bx">
                        <li><a href="#" class="btn outline radius-xl"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" class="btn outline radius-xl"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" class="btn outline radius-xl"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#" class="btn outline radius-xl"><i class="fa fa-google-plus"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7 col-md-7">
                <form class="contact-bx" action="contact.php" method="POST">
                    <div class="ajax-message"></div>
                    <div class="heading-bx left">
                        <h2 class="title-head">Get In <span>Touch</span></h2>
                        <p>Got a question? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
                    </div>
                    <div class="row placeani">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <label>Your Name</label>
                                    <input name="name" type="text" required class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <label>Your Email Address</label>
                                    <input name="email" type="email" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <label>Your Phone</label>
                                    <input name="phone" type="text" required class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <label>Subject</label>
                                    <input name="subject" type="text" required class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <label>Type Message</label>
                                    <textarea name="message" rows="4" class="form-control" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button name="submit" type="submit" value="Submit" class="btn button-md">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- inner page banner END -->
</div>


    </div>
    <!-- Content END-->
    <!-- Footer ==== -->
	<footer>
        <div class="footer-top">
			<div class="pt-exebar">
				<div class="container">
					<div class="d-flex align-items-stretch">
						<div class="pt-logo mr-auto">
							<a href="index.html"><img src="assets/images/finallogo.png" alt=""/></a>
						</div>
						<div class="pt-social-link">
							<ul class="list-inline m-a0">
								<li><a href="#" class="btn-link"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#" class="btn-link"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#" class="btn-link"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#" class="btn-link"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
						<div class="pt-btn-join">
							<a href="#" class="btn ">Join Now</a>
						</div>
					</div>
				</div>
			</div>
            <div class="container">
                <div class="row">
					<div class="col-lg-4 col-md-12 col-sm-12 footer-col-4">
                        <div class="widget">
                            <h5 class="footer-title">Sign Up For A Newsletter</h5>
							<p class="text-capitalize m-b20">Weekly Breaking news analysis and cutting edge advices on job searching.</p>
                            <div class="subscribe-form m-b20">
								<form class="subscription-form" action="" method="post">
									<div class="ajax-message"></div>
									<div class="input-group">
										<input name="email" required="required"  class="form-control" placeholder="Your Email Address" type="email">
										<span class="input-group-btn">
											<button name="submit" value="Submit" type="submit" class="btn"><i class="fa fa-arrow-right"></i></button>
										</span> 
									</div>
								</form>
							</div>
                        </div>
                    </div>
					<div class="col-12 col-lg-5 col-md-7 col-sm-12">
						<div class="row">
							<div class="col-4 col-lg-4 col-md-4 col-sm-4">
								<div class="widget footer_widget">
									<h5 class="footer-title">Company</h5>
									<ul>
										<li><a href="index.php">Home</a></li>
										<li><a href="about.php">About</a></li>
										<li><a href="faq-1.php">FAQs</a></li>
										<li><a href="contact.php">Contact</a></li>
									</ul>
								</div>
							</div>
							<div class="col-4 col-lg-4 col-md-4 col-sm-4">
								<div class="widget footer_widget">
									<h5 class="footer-title">Get In Touch</h5>
									<ul>
										<li><a href="index.php">Dashboard</a></li>
										<li><a href="blog.php">Blog</a></li>
	
										<li><a href="event.php">Event</a></li>
									</ul>
								</div>
							</div>
							<div class="col-4 col-lg-4 col-md-4 col-sm-4">
								<div class="widget footer_widget">
									<h5 class="footer-title">Courses</h5>
									<ul>
										<li><a href="courses.php">Courses</a></li>

										
										
									</ul>
								</div>
							</div>
						</div>
                    </div>
					<div class="col-12 col-lg-3 col-md-5 col-sm-12 footer-col-4">
                        <div class="widget widget_gallery gallery-grid-4">
                            <h5 class="footer-title">Our Gallery</h5>
                            <ul class="magnific-image">
								<li><a href="assets/images/gallery/pic1.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic1.jpg" alt=""></a></li>
								<li><a href="assets/images/gallery/pic2.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic2.jpg" alt=""></a></li>
								<li><a href="assets/images/gallery/pic3.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic3.jpg" alt=""></a></li>
								<li><a href="assets/images/gallery/pic4.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic4.jpg" alt=""></a></li>
								<li><a href="assets/images/gallery/pic5.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic5.jpg" alt=""></a></li>
								<li><a href="assets/images/gallery/pic6.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic6.jpg" alt=""></a></li>
								<li><a href="assets/images/gallery/pic7.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic7.jpg" alt=""></a></li>
								<li><a href="assets/images/gallery/pic8.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic8.jpg" alt=""></a></li>
							</ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 text-center"> © 2024 Badastep | All rights reserved and developed by <a target="_blank" href="https://www.instagram.com/totaltech_studio/">totaltech_studio</a></div>

            </div>
        </div>
    </footer>
    <!-- Footer END ==== -->
    <!-- scroll top button -->
    <button class="back-to-top fa fa-chevron-up" ></button>
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
<script src='../../www.google.com/recaptcha/api.js'></script>
</body>


</html>