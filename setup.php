<?php
// Setup script to initialize the database and create necessary directories

// Include database configuration
require_once 'config/database.php';
require_once 'config/config.php';

// Create database connection
$database = new Database();
$conn = $database->getConnection();

// Check if connection is successful
if (!$conn) {
    die("Database connection failed. Please check your database configuration.");
}

// Read SQL script
$sql = file_get_contents('db_setup.sql');

// Execute SQL script
try {
    $conn->exec($sql);
    echo "Database setup completed successfully!<br>";
} catch (PDOException $e) {
    die("Error setting up database: " . $e->getMessage());
}

// Create uploads directory if it doesn't exist
if (!file_exists(UPLOAD_DIR)) {
    if (mkdir(UPLOAD_DIR, 0777, true)) {
        echo "Uploads directory created successfully!<br>";
    } else {
        echo "Failed to create uploads directory. Please create it manually.<br>";
    }
}

// Initialize courses from configuration
require_once 'models/Course.php';
$courseModel = new Course();
$courseModel->initializeCourses();
echo "Courses initialized successfully!<br>";

echo "<br>Setup completed! You can now <a href='index.php'>access the system</a>.";
?>