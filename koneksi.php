<?php
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'asrama';

$koneksi = mysqli_connect($host,$user, $password, $db);
$conn = new mysqli($host,$user, $password, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>