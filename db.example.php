<?php
// Example database connection file (do NOT use real credentials here)
$conn = new mysqli("DB_HOST", "DB_USER", "DB_PASS", "DB_NAME");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
