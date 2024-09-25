<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Set your username
$password = ""; // Set your password
$dbname = "admin"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission to add or update notification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $date = $_POST['date'];
    $author = $_POST['author'];
    $link = $_POST['link'];

    // Check if updating or inserting a new record
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Update record
        $id = $_POST['id'];
        $stmt = $conn->prepare("UPDATE notifications SET title=?, content=?, date=?, author=?, link=? WHERE id=?");
        $stmt->bind_param("sssssi", $title, $content, $date, $author, $link, $id);
    } else {
        // Insert new record
        $stmt = $conn->prepare("INSERT INTO notifications (title, content, date, author, link) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $content, $date, $author, $link);
    }

    if ($stmt->execute()) {
        echo "Notification saved successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle delete operation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM notifications WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Notification deleted successfully!";
    } else {
        echo "Error deleting notification: " . $stmt->error;
    }
}

// Handle edit operation
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM notifications WHERE id=$id");
    if ($result->num_rows > 0) {
        $notification = $result->fetch_assoc();
        $title = $notification['title'];
        $content = $notification['content'];
        $date = $notification['date'];
        $author = $notification['author'];
        $link = $notification['link'];
    }
}

// Fetch all notifications
$sql = "SELECT * FROM notifications";
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


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Management</title>
    <style>
        body {
           
            font-family: Arial, sans-serif;
            padding:100px;
            padding-left:350px;
            padding-right:200px;
            background-color: #e7c6ff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color:#fff;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        form {
            margin-bottom: 20px;
        }
        .btn{
            background-color: #4c1864; /* Initial background color */
    color: white; /* Text color */
    border: none; /* Remove border */
    padding: 10px 20px; /* Add padding for the button */
    font-size: 16px; /* Font size */
    border-radius: 8px; /* Border radius */
    cursor: pointer; /* Pointer cursor on hover */
    transition: background-color 0.3s ease; /* Smooth transition for background color */
        }
        .btn:hover{
            background-color: orange;
        }
    </style>
</head>
<body>

<h2>Manage Notifications</h2>

<!-- Form to add or update notification -->
<form method="POST" action="">
    <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
    <label>Title: </label><input type="text" name="title" value="<?php echo isset($title) ? $title : ''; ?>" required><br>
    <label>Content: </label><textarea name="content" required><?php echo isset($content) ? $content : ''; ?></textarea><br>
    <label>Date: </label><input type="date" name="date" value="<?php echo isset($date) ? $date : ''; ?>" required><br>
    <label>Author: </label><input type="text" name="author" value="<?php echo isset($author) ? $author : ''; ?>" required><br>
    <label>Link: </label><input type="url" name="link" value="<?php echo isset($link) ? $link : ''; ?>" required><br><br>
    <button class="btn" type="submit">Submit</button>
</form>

<h2>Notifications List</h2>
<!-- Table to display notifications -->
<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Content</th>
            <th>Date</th>
            <th>Author</th>
            <th>Link</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['content']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['author']; ?></td>
                    <td><a href="<?php echo $row['link']; ?>" target="_blank">View</a></td>
                    <td>
                        <a href="?edit=<?php echo $row['id']; ?>">Edit</a> |
                        <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this notification?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No notifications found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

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

<?php $conn->close(); ?>
