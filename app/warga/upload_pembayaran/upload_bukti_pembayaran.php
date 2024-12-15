<?php
include('koneksi.php'); // Hubungkan ke database

// Jika form di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'];
    $tanggal_upload = date("Y-m-d H:i:s");
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $status_verifikasi = "Menunggu"; // Status default
    $catatan_admin = ""; // Default kosong

    // Proses upload file
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $upload_ok = 1;

    // Periksa apakah file adalah gambar
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if ($check !== false) {
        $upload_ok = 1;
    } else {
        echo "File yang diunggah bukan gambar.";
        $upload_ok = 0;
    }

    // Upload file jika valid
    if ($upload_ok && move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        // Masukkan data ke tabel `bukti_pembayaran`
        $sql_insert = "INSERT INTO bukti_pembayaran (nim, tanggal_upload, jumlah_bayar, metode_pembayaran, status_verifikasi, gambar, catatan_admin)
                       VALUES ('$nim', '$tanggal_upload', '$jumlah_bayar', '$metode_pembayaran', '$status_verifikasi', '" . basename($_FILES["gambar"]["name"]) . "', '$catatan_admin')";

        if ($conn->query($sql_insert) === TRUE) {
            echo "<script>alert('Bukti pembayaran berhasil diunggah.'); window.location.href = 'status_pembayaran.php?nim=$nim';</script>";
        } else {
            echo "Gagal mengunggah bukti pembayaran: " . $conn->error;
        }
    } else {
        echo "Maaf, terjadi kesalahan saat mengunggah file.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Bukti Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2>Upload Bukti Pembayaran</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control" name="nim" id="nim" required>
            </div>
            <div class="mb-3">
                <label for="jumlah_bayar" class="form-label">Jumlah Pembayaran</label>
                <input type="number" class="form-control" name="jumlah_bayar" id="jumlah_bayar" required>
            </div>
            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <select class="form-select" name="metode_pembayaran" id="metode_pembayaran" required>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="Cash">Cash</option>
                    <option value="E-Wallet">E-Wallet</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Upload Bukti Pembayaran</label>
                <input type="file" class="form-control" name="gambar" id="gambar" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
</body>
</html>
