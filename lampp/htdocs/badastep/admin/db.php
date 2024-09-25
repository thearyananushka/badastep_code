<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Array of SQL statements for creating tables
$sqls = [
    "CREATE TABLE IF NOT EXISTS courses (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        status ENUM('pending', 'approved') DEFAULT 'pending',
        image VARCHAR(255) NOT NULL
    )",
    "CREATE TABLE IF NOT EXISTS notifications (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        date DATE NOT NULL,
        author VARCHAR(100) NOT NULL,
        link VARCHAR(255) NOT NULL
    )",
    "CREATE TABLE IF NOT EXISTS topexams (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        mode VARCHAR(50) NOT NULL,
        participating_colleges INT NOT NULL,
        exam_date DATE NOT NULL,
        exam_level VARCHAR(50) NOT NULL,
        exam_logo VARCHAR(512),
        FOREIGN KEY (participating_colleges) REFERENCES colleges(id)
    )",
    "CREATE TABLE college_ranking (
        id INT AUTO_INCREMENT PRIMARY KEY,
        college_name VARCHAR(255) NOT NULL,
        ranking VARCHAR(50) NOT NULL,
        streams VARCHAR(255) NOT NULL,
        college_logo VARCHAR(255)
    )",
    "CREATE TABLE IF NOT EXISTS events (
        id INT AUTO_INCREMENT PRIMARY KEY,
        event_title VARCHAR(255) NOT NULL,
        event_date DATE NOT NULL,
        event_time_start TIME NOT NULL,
        event_time_end TIME NOT NULL,
        event_location VARCHAR(255) NOT NULL,
        event_image VARCHAR(255),
        event_description TEXT,
        event_category ENUM('happening', 'upcoming', 'expired') NOT NULL
    )",
    "CREATE TABLE IF NOT EXISTS blogs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        image VARCHAR(255) DEFAULT NULL,
        author VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )", // <-- Comma added here
    "CREATE TABLE topcolleges (
        id INT AUTO_INCREMENT PRIMARY KEY,
        rank INT NOT NULL,
        name VARCHAR(255) NOT NULL,
        location VARCHAR(255) NOT NULL,
        rating DECIMAL(3, 2) NOT NULL,
        ranking VARCHAR(50) NOT NULL, -- Added ranking column here
        cutoff VARCHAR(255) NOT NULL,
        application_deadline DATE NOT NULL,
        fees VARCHAR(100) NOT NULL,
        image LONGBLOB NOT NULL
    )"

    
    // "CREATE TABLE topcolleges (
    //     id INT AUTO_INCREMENT PRIMARY KEY,
    //     rank INT NOT NULL,
    //     name VARCHAR(255) NOT NULL,
    //     location VARCHAR(255) NOT NULL,
    //     rating DECIMAL(3, 2) NOT NULL,
    //     cutoff VARCHAR(255) NOT NULL,
    //     application_deadline DATE NOT NULL,
    //     fees VARCHAR(100) NOT NULL,
    //     image LONGBLOB NOT NULL
    // )"

    // "CREATE TABLE IF NOT EXISTS topcolleges (
    //     id INT AUTO_INCREMENT PRIMARY KEY,
    //     rank INT NOT NULL,
    //     name VARCHAR(255) NOT NULL,
    //     location VARCHAR(255) NOT NULL,
    //     rating FLOAT NOT NULL CHECK (rating >= 0 AND rating <= 5), -- Ensure rating is between 0 and 5
    //     cutoff VARCHAR(255) NOT NULL,
    //     application_deadline DATE NOT NULL, -- Changed to DATE type
    //     fees DECIMAL(10, 2) NOT NULL, -- Changed to DECIMAL for precise monetary values
    //     image_url VARCHAR(255) NOT NULL,
    //     UNIQUE (name) -- Ensure college names are unique
    // )"
];

// Execute each SQL statement
foreach ($sqls as $sql) {
    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully: " . strtok($sql, " ") . "<br>"; // Get table name
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }
}

$conn->close();
?>
