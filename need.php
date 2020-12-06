<?php
// assigning credential for db connection.
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password, "exl.db");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
