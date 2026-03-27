<?php
$servername = "localhost";
$username = "root";  // XAMPP default
$password = "";      // XAMPP default
$dbname = "cartify"; // jo DB aapne banayi hai

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$conn = mysqli_connect("localhost", "root", "", "cartify");
if(!$conn){
    die("Database connection failed");
}