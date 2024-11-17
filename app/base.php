<?php
$username = "root";
$password = "";
$host = "localhost";
$dbname = "asrama";

define("BASEPATH" ,  $_SERVER["DOCUMENT_ROOT"]."/asrama/");
define("BASEURL", "http://localhost/asrama/");

$conn = new mysqli($host, $username, $password,$dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
