<?php
// Database connection settings for local use
$servername = "localhost"; // Usually 'localhost' for local development
$username   = "root";       // Default XAMPP username
$password   = "";           // Default XAMPP password is empty
$dbname     = "crud_db";       // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
