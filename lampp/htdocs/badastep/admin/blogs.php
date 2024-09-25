<?php
// Database connection
$servername = "localhost";
$username = "root";  // Update with your DB username
$password = "";  // Update with your DB password
$dbname = "admin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle blog creation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_blog'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    $image = "";

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = "uploads/" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    // Insert blog into database
    $sql = "INSERT INTO blogs (title, content, image, author) VALUES ('$title', '$content', '$image', '$author')";

    if ($conn->query($sql) === TRUE) {
        echo "New blog added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle blog deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM blogs WHERE id=$delete_id";
    $conn->query($sql);
    header("Location: ".$_SERVER['PHP_SELF']);
}

// Handle blog editing
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_blog'])) {
    $edit_id = $_POST['edit_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    $image = $_POST['existing_image'];

    // Handle image re-upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = "uploads/" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    $sql = "UPDATE blogs SET title='$title', content='$content', image='$image', author='$author' WHERE id=$edit_id";

    if ($conn->query($sql) === TRUE) {
        echo "Blog updated successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch blog for editing if edit_id is present
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql = "SELECT * FROM blogs WHERE id=$edit_id";
    $result = $conn->query($sql);
    $edit_blog = $result->fetch_assoc();
}

// Pagination setup
$limit = 5; // Number of blogs per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch blogs with pagination
$sql = "SELECT * FROM blogs ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Count total blogs for pagination
$sql_total = "SELECT COUNT(*) AS total FROM blogs";
$total_result = $conn->query($sql_total);
$total_blogs = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_blogs / $limit);
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
		                </ul>
		            </li>
		            <li class="ttr-seperate"></li>
				</ul>
				<!-- sidebar menu end -->
			</nav>
			<!-- sidebar menu end -->
		</div>
	</div>
	<!-- Left sidebar menu end -->

<!-- <!DOCTYPE html>
<html lang="en">
<head> -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
			padding: 200px;
			padding-left: 400px;
			padding-top: 50px;
			background-color: #e7c6ff;
        }
		h1{
            color: #4c1864;
            text-align: center;
        }
        .blog-form, .blog-edit-form {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .blog-form input, .blog-form textarea, .blog-edit-form input, .blog-edit-form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .blog-form input[type="submit"], .blog-edit-form input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .blog-post img {
            max-width: 300px;
            height: auto;
            display: block;
            margin-bottom: 10px;
        }
        .blog-details {
            margin-bottom: 20px;
        }
        .pagination a {
            margin: 0 5px;
            padding: 8px 16px;
            background-color: #f1f1f1;
            text-decoration: none;
            color: black;
        }
        .pagination a:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>

    <h1>Blog Admin Panel</h1>

    <!-- Blog Creation Form -->
    <div class="blog-form">
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="title">Blog Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="content">Blog Content:</label>
            <textarea id="content" name="content" rows="5" required></textarea>

            <label for="author">Author:</label>
            <input type="text" id="author" name="author" required>

            <label for="image">Image (optional):</label>
            <input type="file" id="image" name="image">

            <input type="submit" name="add_blog" value="Add Blog">
        </form>
    </div>

    <!-- Blog Editing Form -->
    <?php if (isset($edit_blog)): ?>
    <div class="blog-edit-form">
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="edit_id" value="<?php echo $edit_blog['id']; ?>">
            <label for="title">Blog Title:</label>
            <input type="text" id="title" name="title" value="<?php echo $edit_blog['title']; ?>" required>

            <label for="content">Blog Content:</label>
            <textarea id="content" name="content" rows="5" required><?php echo $edit_blog['content']; ?></textarea>

            <label for="author">Author:</label>
            <input type="text" id="author" name="author" value="<?php echo $edit_blog['author']; ?>" required>

            <label for="image">Current Image:</label>
            <?php if ($edit_blog['image']): ?>
                <img src="<?php echo $edit_blog['image']; ?>" alt="Blog Image">
            <?php endif; ?>
            <input type="hidden" name="existing_image" value="<?php echo $edit_blog['image']; ?>">

            <label for="image">Change Image (optional):</label>
            <input type="file" id="image" name="image">

            <input type="submit" name="edit_blog" value="Update Blog">
        </form>
    </div>
    <?php endif; ?>

    <!-- Display All Blogs -->
    <h2>All Blogs</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="blog-post">
                <?php if ($row['image']): ?>
                    <img src="<?php echo $row['image']; ?>" alt="Blog Image">
                <?php endif; ?>
                <div class="blog-details">
                    <p><small>Author: <?php echo $row['author']; ?> | Posted on: <?php echo $row['created_at']; ?></small></p>
                    <h2><?php echo $row['title']; ?></h2>
                    <p><?php echo $row['content']; ?></p>
                </div>
                <a href="?delete_id=<?php echo $row['id']; ?>">Delete</a> | 
                <a href="?edit_id=<?php echo $row['id']; ?>">Edit</a>
                <hr>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No blogs available.</p>
    <?php endif; ?>

    <!-- Pagination -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
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

<?php
$conn->close();
?>


