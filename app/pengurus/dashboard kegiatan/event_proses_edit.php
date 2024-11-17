<?php
session_start();
include 'koneksi.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_kegiatan = $_POST['id_kegiatan'];
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $tanggal_kegiatan = $_POST['tanggal_kegiatan'];
    $tempat = $_POST['tempat'];
    $deskripsi = $_POST['deskripsi'];
    $foto_pamflet = $_FILES['foto_pamflet'];

    if ($foto_pamflet['name']) {
        $target_dir = "./src/storage/";
        $target_file = $target_dir . basename($foto_pamflet["name"]);
        move_uploaded_file($foto_pamflet["tmp_name"], $target_file);

        $sql = "UPDATE kegiatan SET 
                    nama_kegiatan='$nama_kegiatan', 
                    tanggal_kegiatan='$tanggal_kegiatan', 
                    tempat='$tempat', 
                    deskripsi='$deskripsi', 
                    foto_pamflet='" . basename($foto_pamflet["name"]) . "' 
                WHERE id_kegiatan='$id_kegiatan'";
    } else {
        $sql = "UPDATE kegiatan SET 
                    nama_kegiatan='$nama_kegiatan', 
                    tanggal_kegiatan='$tanggal_kegiatan', 
                    tempat='$tempat', 
                    deskripsi='$deskripsi' 
                WHERE id_kegiatan='$id_kegiatan'";
    }

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Data kegiatan berhasil diperbarui!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Terjadi kesalahan: " . $conn->error;
        $_SESSION['message_type'] = "error";
    }

    $conn->close();
    header("Location: event.php");
    exit();
}
?>
