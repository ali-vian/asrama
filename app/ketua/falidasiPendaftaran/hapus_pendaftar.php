<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "asrama";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];

    // Query untuk menghapus data berdasarkan NIM
    $sql = "DELETE FROM pendaftaran WHERE nim = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nim);

    if ($stmt->execute()) {
        echo "<script>alert('Data pendaftar berhasil dihapus.'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data pendaftar.'); window.location.href = 'index.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
