<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle create and edit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $event_title = $conn->real_escape_string($_POST['event_title']);
    $event_date = $conn->real_escape_string($_POST['event_date']);
    $event_time_start = $conn->real_escape_string($_POST['event_time_start']);
    $event_time_end = $conn->real_escape_string($_POST['event_time_end']);
    $event_location = $conn->real_escape_string($_POST['event_location']);
    $event_description = $conn->real_escape_string($_POST['event_description']);

    // Handle image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["event_image"]["name"]);

    if (!move_uploaded_file($_FILES["event_image"]["tmp_name"], $target_file)) {
        die("Failed to upload image.");
    }

    // Initialize event_id
    $event_id = isset($_POST['event_id']) ? $conn->real_escape_string($_POST['event_id']) : null;

    // Insert or update the event
    if ($event_id) {
        $sql = "UPDATE events 
                SET event_title='$event_title', event_date='$event_date', event_time_start='$event_time_start', 
                    event_time_end='$event_time_end', event_location='$event_location', 
                    event_description='$event_description', event_image='$target_file' 
                WHERE event_id='$event_id'";
    } else {
        $sql = "INSERT INTO events (event_title, event_date, event_time_start, event_time_end, event_location, event_description, event_image)
                VALUES ('$event_title', '$event_date', '$event_time_start', '$event_time_end', '$event_location', '$event_description', '$target_file')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: events.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $sql = "DELETE FROM events WHERE event_id='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: events.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch events from the database
$sql = "SELECT * FROM events ORDER BY event_date ASC";
$result = $conn->query($sql);
?>

<!----------------------------------------------------------------------------------------------->


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
	<meta name="description" content="Badastep" />
	
	<!-- OG -->
	<meta property="og:title" content="Badastep" />
	<meta property="og:description" content="Badastep" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="../error-404.html" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/finallogo.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Badastep </title>
	
	<!-- MOBILE SPECIFIC ============================================= -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.min.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
	
	<!-- All PLUGINS CSS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/assets.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/calendar/fullcalendar.css">
	
	<!-- TYPOGRAPHY ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/typography.css">
	
	<!-- SHORTCODES ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
	<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">
	
</head>
<body class="ttr-opened-sidebar ttr-pinned-sidebar">
	
	<!-- header start -->
	<header class="ttr-header">
		<div class="ttr-header-wrapper">
			<!--sidebar menu toggler start -->
			<div class="ttr-toggle-sidebar ttr-material-button">
				<i class="ti-close ttr-open-icon"></i>
				<i class="ti-menu ttr-close-icon"></i>
			</div>
			<!--sidebar menu toggler end -->
			<!--logo start -->
			<div class="ttr-logo-box">
				<div>
					<a href="index.php" class="ttr-logo"  >
						<img class="ttr-logo-mobile" alt="" src="assets/images/finallogo.png" width="30" height="30" >
						<img class="ttr-logo-desktop" alt="" src="assets/images/finallogo.png" width="90" height="70">
					</a>
				</div>
			</div>
			<!--logo end -->
			<div class="ttr-header-menu">
				<!-- header left menu start -->
				<ul class="ttr-header-navigation">
					<li>
						<a href="index.php" class="ttr-material-button ttr-submenu-toggle">HOME</a>
						<!-- <a href="../index.php" class="ttr-material-button ttr-submenu-toggle">HOME</a> -->
					</li>
					
				</ul>
				<!-- header left menu end -->
			</div>
			<div class="ttr-header-right ttr-with-seperator">
				<!-- header right menu start -->
				<ul class="ttr-header-navigation">
					<li>
						<a href="#" class="ttr-material-button ttr-search-toggle"><i class="fa fa-search"></i></a>
					</li>
					<li>
						<a href="#" class="ttr-material-button ttr-submenu-toggle"><i class="fa fa-bell"></i></a>
						<div class="ttr-header-submenu noti-menu">
							<div class="ttr-notify-header">
								<span class="ttr-notify-text-top">9 New</span>
								<span class="ttr-notify-text">User Notifications</span>
							</div>
							<div class="noti-box-list">
								<ul>
									<li>
										<span class="notification-icon dashbg-gray">
											<i class="fa fa-check"></i>
										</span>
										<span class="notification-text">
											<span>Sneha Jogi</span> sent you a message.
										</span>
										<span class="notification-time">
											<a href="#" class="fa fa-close"></a>
											<span> 02:14</span>
										</span>
									</li>
									<li>
										<span class="notification-icon dashbg-yellow">
											<i class="fa fa-shopping-cart"></i>
										</span>
										<span class="notification-text">
											<a href="#">Your order is placed</a> sent you a message.
										</span>
										<span class="notification-time">
											<a href="#" class="fa fa-close"></a>
											<span> 7 Min</span>
										</span>
									</li>
									<li>
										<span class="notification-icon dashbg-red">
											<i class="fa fa-bullhorn"></i>
										</span>
										<span class="notification-text">
											<span>Your item is shipped</span> sent you a message.
										</span>
										<span class="notification-time">
											<a href="#" class="fa fa-close"></a>
											<span> 2 May</span>
										</span>
									</li>
									<li>
										<span class="notification-icon dashbg-green">
											<i class="fa fa-comments-o"></i>
										</span>
										<span class="notification-text">
											<a href="#">Sneha Jogi</a> sent you a message.
										</span>
										<span class="notification-time">
											<a href="#" class="fa fa-close"></a>
											<span> 14 July</span>
										</span>
									</li>
									<li>
										<span class="notification-icon dashbg-primary">
											<i class="fa fa-file-word-o"></i>
										</span>
										<span class="notification-text">
											<span>Sneha Jogi</span> sent you a message.
										</span>
										<span class="notification-time">
											<a href="#" class="fa fa-close"></a>
											<span> 15 Min</span>
										</span>
									</li>
								</ul>
							</div>
						</div>
					</li>
					
				</ul>
				<!-- header right menu end -->
			</div>
			<!--header search panel start -->
			<div class="ttr-search-bar">
				<form class="ttr-search-form">
					<div class="ttr-search-input-wrapper">
						<input type="text" name="qq" placeholder="search something..." class="ttr-search-input">
						<button type="submit" name="search" class="ttr-search-submit"><i class="ti-arrow-right"></i></button>
					</div>
					<span class="ttr-search-close ttr-search-toggle">
						<i class="ti-close"></i>
					</span>
				</form>
			</div>
			<!--header search panel end -->
		</div>
	</header>
	<!-- header end -->
	<!-- Left sidebar menu start -->
	<div class="ttr-sidebar">
		<div class="ttr-sidebar-wrapper content-scroll">
			<!-- side menu logo start -->
			<div class="ttr-sidebar-logo" style=" border: none;" >
				<a href="#"><img alt="" src="assets/images/final-logo.png"  width="112" height="" ><strong>BADASTEP</strong></a>
				<!-- <div class="ttr-sidebar-pin-button" title="Pin/Unpin Menu">
					<i class="material-icons ttr-fixed-icon">hide</i>
					<i class="material-icons ttr-not-fixed-icon">show</i>
				</div> -->
				<div class="ttr-sidebar-toggle-button">
					<i class="ti-arrow-left"></i>
				</div>
			</div>
			<!-- side menu logo end -->
			<!-- sidebar menu start -->
			<nav class="ttr-sidebar-navi">
				<ul>
					<li>
						<a href="index.php" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-home"></i></span>
		                	<span class="ttr-label">Dashborad</span>
		                </a>
		            </li>
					<li>
						<a href="courses.php" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-book"></i></span>
		                	<span class="ttr-label">Courses</span>
		                </a>
		            </li>
					<li>
						<a href="topcolleges.php" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-book"></i></span>
		                	<span class="ttr-label">TopColleges</span>
		                </a>
		            </li>
					<li>
						<a href="blogs.php" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-book"></i></span>
		                	<span class="ttr-label">Blogs</span>
		                </a>
		            </li>
					<li>
						<a href="events.php" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-book"></i></span>
		                	<span class="ttr-label">Events</span>
		                </a>
		            </li>
					<li>
						<a href="notification.php" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-book"></i></span>
		                	<span class="ttr-label">Add Notifications</span>
		                </a>
		            </li>
					<li>
						<a href="topexams.php" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-book"></i></span>
		                	<span class="ttr-label">Add Top Exams</span>
		                </a>
		            </li>
					<li>
						<a href="college_ranking.php" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-book"></i></span>
		                	<span class="ttr-label">Add college Ranking</span>
		                </a>
		            </li>
					
					<li>
						<a href="#" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-calendar"></i></span>
		                	<span class="ttr-label">Calendar</span>
		                	<span class="ttr-arrow-icon"><i class="fa fa-angle-down"></i></span>
		                </a>
		                <ul>
		                	<li>
		                		<a href="basic-calendar.html" class="ttr-material-button"><span class="ttr-label">Basic Calendar</span></a>
		                	</li>
		                	<!-- <li>
		                		<a href="list-view-calendar.html" class="ttr-material-button"><span class="ttr-label">List View</span></a>
		                	</li> -->
		                </ul>
		            </li>
					
					<li>
						<a href="enquiry.php" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-comments"></i></span>
		                	<span class="ttr-label">Enquiry</span>
		                </a>
		            </li>
				
					<!-- <li>
						<a href="#" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-user"></i></span>
		                	<span class="ttr-label">My Profile</span>
		                	<span class="ttr-arrow-icon"><i class="fa fa-angle-down"></i></span>
		                </a>
		               
		            </li> -->
		            <li class="ttr-seperate"></li>
				</ul>
				<!-- sidebar menu end -->
			</nav>
			<!-- sidebar menu end -->
		</div>
	</div>
	<!-- Left sidebar menu end -->




<!-- --------------------------------------------------------------------------------------------- -->

<!-- <!DOCTYPE html>
<html lang="en">
<head> -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding:100px;
            padding-left:350px;
            padding-right:200px;
            background-color: #e7c6ff;
            
        }
        .container {
            width: 80%;
            margin: auto;
        }
        .event-bx {
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #fff;
        }
        .buttons a {
            text-decoration: none;
            padding: 8px 15px;
            margin-right: 10px;
            margin-top: 100px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }

        .create-button button {
    background-color: #4c1864; /* Initial background color */
    color: white; /* Text color */
    border: none; /* Remove border */
    padding: 10px 20px; /* Add padding for the button */
    font-size: 16px; /* Font size */
    border-radius: 8px; /* Border radius */
    cursor: pointer; /* Pointer cursor on hover */
    transition: background-color 0.3s ease; /* Smooth transition for background color */
}

.create-button button:hover {
    background-color: orange; /* Change background color on hover */
}


        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Events</h1>

        <div class="create-button">
            <button onclick="document.getElementById('eventForm').style.display='block'" >Create Event</button>
        </div>

        <div id="eventForm" style="display:none;">
            <h2>Add  Event</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="event_id" id="event_id">
                <label for="event_title">Event Title:</label><br>
                <input type="text" id="event_title" name="event_title" required><br><br>
                <label for="event_date">Event Date:</label><br>
                <input type="date" id="event_date" name="event_date" required><br><br>
                <label for="event_time_start">Start Time:</label><br>
                <input type="time" id="event_time_start" name="event_time_start" required><br><br>
                <label for="event_time_end">End Time:</label><br>
                <input type="time" id="event_time_end" name="event_time_end" required><br><br>
                <label for="event_location">Location:</label><br>
                <input type="text" id="event_location" name="event_location" required><br><br>
                <label for="event_description">Description:</label><br>
                <textarea id="event_description" name="event_description" required></textarea><br><br>
                <label for="event_image">Event Image:</label><br>
                <input type="file" id="event_image" name="event_image" accept="image/*" required><br><br>
                <button type="submit">Submit</button>
                <button type="button" onclick="document.getElementById('eventForm').style.display='none'">Cancel</button>
            </form>
        </div>

        <h2>Upcoming Events</h2>
        <div>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="event-bx">';
                    echo '<h3>' . $row['event_title'] . '</h3>';
                    echo '<p>Date: ' . $row['event_date'] . '</p>';
                    echo '<p>Time: ' . $row['event_time_start'] . ' - ' . $row['event_time_end'] . '</p>';
                    echo '<p>Location: ' . $row['event_location'] . '</p>';
                    echo '<p>' . $row['event_description'] . '</p>';
                    echo '<img src="' . $row['event_image'] . '" alt="Event Image" style="width: 100px;"><br>';
                    echo '<div class="buttons">';
                    echo '<a href="#" onclick="editEvent(' . $row['event_id'] . ', \'' . addslashes($row['event_title']) . '\', \'' . addslashes($row['event_date']) . '\', \'' . addslashes($row['event_time_start']) . '\', \'' . addslashes($row['event_time_end']) . '\', \'' . addslashes($row['event_location']) . '\', \'' . addslashes($row['event_description']) . '\')">Edit</a>';
                    echo '<a href="?delete=' . $row['event_id'] . '" onclick="return confirm(\'Are you sure you want to delete this event?\');">Delete</a>';
                    echo '</div></div>';
                }
            } else {
                echo '<p>No events available</p>';
            }
            ?>
        </div>
    </div>

    <script>
        function editEvent(id, title, date, timeStart, timeEnd, location, description) {
            document.getElementById('event_id').value = id;
            document.getElementById('event_title').value = title;
            document.getElementById('event_date').value = date;
            document.getElementById('event_time_start').value = timeStart;
            document.getElementById('event_time_end').value = timeEnd;
            document.getElementById('event_location').value = location;
            document.getElementById('event_description').value = description;
            document.getElementById('eventForm').style.display = 'block';
        }
    </script>


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
<script src='assets/vendors/scroll/scrollbar.min.js'></script>
<script src="assets/js/functions.js"></script>
<script src="assets/vendors/chart/chart.min.js"></script>
<script src="assets/js/admin.js"></script>
<script src='assets/vendors/calendar/moment.min.js'></script>
<script src='assets/vendors/calendar/fullcalendar.js'></script>
<script src='assets/vendors/switcher/switcher.js'></script>
<script>
</body>
</html>