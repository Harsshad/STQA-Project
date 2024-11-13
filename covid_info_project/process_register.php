<?php
session_start();
require 'db_connect.php';

// Assuming the form uses POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    $query = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashed_password', '$email')";

    if (mysqli_query($conn, $query)) {
        echo "User registered successfully!";
        // Redirect or handle after registration
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
