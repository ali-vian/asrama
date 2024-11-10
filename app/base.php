<?php
$username = "root";
$password = "";
$host = "localhost";
$dbname = "asrama";

$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>