<?php
// Start the session to handle messages
session_start();

// Database connection
$host = 'localhost';
$user = 'root';
$pass = ''; // Update with your database password
$db = 'admin';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for form inputs
$title = $description = $price = "";
$errors = [];

// Handle Add Course
if (isset($_POST['add_course'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = $conn->real_escape_string($_POST['price']);
    $image = 'assets/images/courses/' . basename($_FILES["image"]["name"]);

    // Handle image upload
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $image)) {
        // Insert into database
        $sql = "INSERT INTO courses (title, description, price, image) VALUES ('$title', '$description', '$price', '$image')";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "New course added successfully.";
            header("Location: courses.php");
            exit();
        } else {
            $errors[] = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $errors[] = "Failed to upload image.";
    }
}

// Handle Update Course
if (isset($_POST['update_course'])) {
    $id = $_POST['id'];
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = $conn->real_escape_string($_POST['price']);

    // Check if a new image is uploaded
    if (!empty($_FILES["image"]["name"])) {
        $image = 'assets/images/courses/' . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $image)) {
            $sql = "UPDATE courses SET title='$title', description='$description', price='$price', image='$image' WHERE id=$id";
        } else {
            $errors[] = "Failed to upload image.";
        }
    } else {
        $sql = "UPDATE courses SET title='$title', description='$description', price='$price' WHERE id=$id";
    }

    if (empty($errors)) {
        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Course updated successfully.";
            header("Location: courses.php");
            exit();
        } else {
            $errors[] = "Error updating course: " . $conn->error;
        }
    }
}

// Handle Approve and Delete actions
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $course_id = intval($_GET['id']);

    if ($action == 'approve') {
        $conn->query("UPDATE courses SET status='approved' WHERE id=$course_id");
        $_SESSION['message'] = "Course approved successfully.";
        header("Location: courses.php");
        exit();
    } elseif ($action == 'delete') {
        // Optionally, delete the image file
        $result = $conn->query("SELECT image FROM courses WHERE id=$course_id");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (file_exists($row['image'])) {
                unlink($row['image']);
            }
        }
        $conn->query("DELETE FROM courses WHERE id=$course_id");
        $_SESSION['message'] = "Course deleted successfully.";
        header("Location: courses.php");
        exit();
    }
}

// Fetch all courses
$courses = $conn->query("SELECT * FROM courses ORDER BY id DESC");

// Fetch course for updating
$update_course = null;
if (isset($_GET['action']) && $_GET['action'] == 'update') {
    $course_id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM courses WHERE id=$course_id");
    if ($result->num_rows > 0) {
        $update_course = $result->fetch_assoc();
    } else {
        $_SESSION['message'] = "Course not found.";
        header("Location: courses.php");
        exit();
    }
}
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
    <title> Courses</title>
    <!-- Include your CSS files here -->
    <link rel="stylesheet" href="assets/css/assets.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Custom styles for simplicity */
        
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
			padding: 200px;
			padding-left: 330px;
			padding-top: 70px;
			background-color: #e7c6ff;
        }
        h1{
            color: #4c1864;
            text-align: center;
        }
        
        .message {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            margin-bottom: 15px;
        }
        .error {
            padding: 10px;
            background-color: #f44336;
            color: white;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: #2196F3;
        }
        .actions a.delete {
            color: #f44336;
        }
        .actions a.update {
            color: #FF9800;
        }
        .actions a.approve {
            color: #4CAF50;
        }
        .form-container {
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .form-container h2 {
            margin-top: 0;
        }
        .form-container label {
            display: block;
            margin-top: 10px;
        }
        .form-container input[type="text"],
        .form-container textarea,
        .form-container input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        .form-container input[type="file"] {
            margin-top: 5px;
        }
        .form-container input[type="submit"] {
            margin-top: 15px;
            padding: 10px 15px;
            background-color: #4CAF50;
            border: none;
            color: white;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h1> Course Management</h1>

    <!-- Display Messages -->
    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class='message'>" . $_SESSION['message'] . "</div>";
        unset($_SESSION['message']);
    }
    if (!empty($errors)) {
        echo "<div class='error'>";
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        echo "</div>";
    }
    ?>

    <!-- Add Course Form -->
    <?php if (!$update_course): ?>
    <div class="form-container">
        <h2>Add New Course</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label>Title:</label>
            <input type="text" name="title" required>

            <label>Description:</label>
            <textarea name="description" rows="5" required></textarea>

            <label>Price:</label>
            <input type="number" step="0.01" name="price" required>

            <label>Image:</label>
            <input type="file" name="image" accept="image/*" required>

            <input type="submit" name="add_course" value="Add Course">
        </form>
    </div>
    <?php endif; ?>

    <!-- Update Course Form -->
    <?php if ($update_course): ?>
    <div class="form-container">
        <h2>Update Course</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $update_course['id'] ?>">

            <label>Title:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($update_course['title']) ?>" required>

            <label>Description:</label>
            <textarea name="description" rows="5" required><?= htmlspecialchars($update_course['description']) ?></textarea>

            <label>Price:</label>
            <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($update_course['price']) ?>" required>

            <label>Change Image (Optional):</label>
            <input type="file" name="image" accept="image/*">

            <input type="submit" name="update_course" value="Update Course">
        </form>
    </div>
    <?php endif; ?>

    <!-- Courses Table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($course = $courses->fetch_assoc()): ?>
                <tr>
                    <td><?= $course['id'] ?></td>
                    <td><?= htmlspecialchars($course['title']) ?></td>
                    <td><?= htmlspecialchars($course['description']) ?></td>
                    <td><?= htmlspecialchars($course['price']) ?></td>
                    <td><img src="<?= htmlspecialchars($course['image']) ?>" alt="Course Image" style="width: 100px;"></td>
                    <td><?= htmlspecialchars($course['status']) ?></td>
                    <td class="actions">
                        <a href="?action=update&id=<?= $course['id'] ?>" class="update">Edit</a>
                        <a href="?action=approve&id=<?= $course['id'] ?>" class="approve">Approve</a>
                        <a href="?action=delete&id=<?= $course['id'] ?>" class="delete">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php $conn->close(); ?>
    



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