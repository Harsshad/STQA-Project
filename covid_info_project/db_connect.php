<?php
$host = "localhost";
$username = "root";  // Default for XAMPP/WAMP
$password = "";      // No password by default
$dbname = "login_system";  // The name of your database

$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
