<?php

session_start();
if (!isset($_SESSION['nim']) && !$_SESSION['role'] == 'ketua') {
    header("Location: ../../../index.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "asrama";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the NIM from POST request
$nim = isset($_POST['nim']) ? $_POST['nim'] : '';

// Fetch detailed data
$sql = "SELECT nim, nama_lengkap, prodi_pendaftar, foto_pendaftar, alamat_pendaftar, ttl, no_hp_pendaftar, email_pendaftar, created_at_pendaftar, nomor_pendaftaran, jenis_kelamin, jalur_masuk, foto_bukti_lolos_ptn, nama_ayah, nama_ibu, no_hp_ortu, status FROM pendaftaran WHERE nim = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nim);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<p><strong>NIM:</strong> " . $row['nim'] . "</p>";
    echo "<p><strong>Nama Lengkap:</strong> " . $row['nama_lengkap'] . "</p>";
    echo "<p><strong>Program Studi:</strong> " . $row['prodi_pendaftar'] . "</p>";
    echo "<p><strong>Alamat:</strong> " . $row['alamat_pendaftar'] . "</p>";
    echo "<p><strong>TTL:</strong> " . $row['ttl'] . "</p>";
    echo "<p><strong>No HP:</strong> " . $row['no_hp_pendaftar'] . "</p>";
    echo "<p><strong>Email:</strong> " . $row['email_pendaftar'] . "</p>";
    echo "<p><strong>Nomor Pendaftaran:</strong> " . $row['nomor_pendaftaran'] . "</p>";
    echo "<p><strong>Jenis Kelamin:</strong> " . $row['jenis_kelamin'] . "</p>";
    echo "<p><strong>Jalur Masuk:</strong> " . $row['jalur_masuk'] . "</p>";
    echo "<p><strong>Nama Ayah:</strong> " . $row['nama_ayah'] . "</p>";
    echo "<p><strong>Nama Ibu:</strong> " . $row['nama_ibu'] . "</p>";
    echo "<p><strong>No HP Orang Tua:</strong> " . $row['no_hp_ortu'] . "</p>";
    echo "<p><strong>Status:</strong> " . $row['status'] . "</p>";
} else {
    echo "<p>No details found.</p>";
}

$stmt->close();
$conn->close();
?>
