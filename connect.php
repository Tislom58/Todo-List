<?php
$servername = "servername";
$username = "username";
$password = "password";
$db = "db";
$port = "port";

// Create connection
$conn = new mysqli($servername, $username, $password, $db, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
