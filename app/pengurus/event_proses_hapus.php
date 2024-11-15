<?php
session_start();
include 'koneksi.php';

if (isset($_GET['id_kegiatan'])) {
    $id_kegiatan = $_GET['id_kegiatan'];

    $sql = "DELETE FROM kegiatan WHERE id_kegiatan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_kegiatan);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Data kegiatan berhasil dihapus!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Terjadi kesalahan: " . $stmt->error;
        $_SESSION['message_type'] = "error";
    }

    $stmt->close();
    $conn->close();
} else {
    $_SESSION['message'] = "ID kegiatan tidak ditemukan!";
    $_SESSION['message_type'] = "warning";
}

header("Location: event.php");
exit();
?>
