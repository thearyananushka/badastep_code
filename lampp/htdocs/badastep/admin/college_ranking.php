<?php
// Connection to MySQL Database
$servername = "localhost";
$username = "root"; // Set your username
$password = ""; // Set your password
$dbname = "admin"; // Database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission to add or update college ranking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $college_name = $_POST['college_name'];
    $ranking = $_POST['ranking'];
    $streams = $_POST['streams'];
    
    // Handle file upload for college logo
    $college_logo = '';
    if (isset($_FILES['college_logo']) && $_FILES['college_logo']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["college_logo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is an image
        $check = getimagesize($_FILES["college_logo"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size (limit to 2MB)
        if ($_FILES["college_logo"]["size"] > 2000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if everything is ok and upload file
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["college_logo"]["tmp_name"], $target_file)) {
                $college_logo = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Check if updating or inserting a new record
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Prepared statement for update
        $id = $_POST['id'];
        if (!empty($college_logo)) {
            $stmt = $conn->prepare("UPDATE college_ranking SET college_name=?, ranking=?, streams=?, college_logo=? WHERE id=?");
            $stmt->bind_param("ssssi", $college_name, $ranking, $streams, $college_logo, $id);
        } else {
            // Update without changing the logo if not uploaded
            $stmt = $conn->prepare("UPDATE college_ranking SET college_name=?, ranking=?, streams=? WHERE id=?");
            $stmt->bind_param("sssi", $college_name, $ranking, $streams, $id);
        }
    } else {
        // Prepared statement for insert
        $stmt = $conn->prepare("INSERT INTO college_ranking (college_name, ranking, streams, college_logo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $college_name, $ranking, $streams, $college_logo);
    }

    if ($stmt->execute()) {
        echo "Record saved successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle delete operation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM college_ranking WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
}

// Handle edit operation
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM college_ranking WHERE id=$id");
    if ($result->num_rows > 0) {
        $college = $result->fetch_assoc();
        $college_name = $college['college_name'];
        $ranking = $college['ranking'];
        $streams = $college['streams'];
        $college_logo = $college['college_logo'];
    }
}

// Fetch college ranking records
$sql = "SELECT * FROM college_ranking";
$result = $conn->query($sql);
?>

<!----------------------------------------------------------------------------------------- --- -->



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





<!----------------------------------------------------------------------------------------- --- -->

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>College Ranking Management</title>
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
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img.logo {
            width: 70px;
            height: auto;
            margin-right: 10px;
            vertical-align: middle;
        }
        .college-info {
            display: flex;
            align-items: center;
        }
        .college-info span {
            margin-left: 10px;
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

<h2>Manage College Rankings</h2>

<form method="POST" action="college_ranking.php" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
    <label>College Name: </label><input type="text" name="college_name" value="<?php echo isset($college_name) ? $college_name : ''; ?>" required><br>
    <label>Ranking : </label><input type="text" name="ranking" value="<?php echo isset($ranking) ? $ranking : ''; ?>" required><br>
    <label>Streams: </label><input type="text" name="streams" value="<?php echo isset($streams) ? $streams : ''; ?>" required><br>
    <label>College Logo: </label><input type="file" name="college_logo" accept="image/*"><br><br>
    <button class="btn" type="submit">Submit</button>
</form>

<h2>College Rankings List</h2>
<table>
    <thead>
        <tr>
            <th>College</th>
            <th>Ranking</th>
            <th>Streams</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="college-info">
                        <?php if (!empty($row['college_logo'])): ?>
                            <img src="<?php echo $row['college_logo']; ?>" class="logo" alt="College Logo">
                        <?php endif; ?>
                        <span><?php echo $row['college_name']; ?></span>
                    </td>
                    <td><?php echo $row['ranking']; ?></td>
                    <td><?php echo $row['streams']; ?></td>
                    <td>
                        <a href="college_ranking.php?delete=<?php echo $row['id']; ?>">Delete</a> | 
                        <a href="college_ranking.php?edit=<?php echo $row['id']; ?>">Edit</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No records found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- </body>
</html> -->

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
 

</script>
</body>
</html>