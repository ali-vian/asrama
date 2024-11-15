<?php
session_start(); 
include 'koneksi.php';

$nama_kegiatan = $_POST['nama_kegiatan'];
$tanggal_kegiatan = $_POST['tanggal_kegiatan'];
$deskripsi = $_POST['deskripsi'];
$tempat = $_POST['tempat'];

$foto_pamflet = null;
if (isset($_FILES['foto_pamflet']) && $_FILES['foto_pamflet']['error'] === UPLOAD_ERR_OK) {
    $foto_pamflet = basename($_FILES['foto_pamflet']['name']);
    move_uploaded_file($_FILES['foto_pamflet']['tmp_name'], "src/storage/" . $foto_pamflet);
}

$sql = "INSERT INTO kegiatan (nama_kegiatan, tanggal_kegiatan, deskripsi, foto_pamflet, tempat, created_at)
        VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $nama_kegiatan, $tanggal_kegiatan, $deskripsi, $foto_pamflet, $tempat);

if ($stmt->execute()) {
    $_SESSION['message'] = "Data kegiatan berhasil ditambahkan!";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Terjadi kesalahan: " . $stmt->error;
    $_SESSION['message_type'] = "error";
}

$stmt->close();
$conn->close();

header("Location: event.php");
exit();
?>
