<?php
include('koneksi.php'); // File koneksi database

// Proses verifikasi pembayaran
if (isset($_POST['verifikasi'])) {
    $id_bukti = $_POST['id_bukti'];
    $status_verifikasi = $_POST['status_verifikasi'];
    $catatan_admin = $_POST['catatan_admin'];

    $sql = "UPDATE bukti_pembayaran 
            SET status_verifikasi = '$status_verifikasi', catatan_admin = '$catatan_admin'
            WHERE id_bukti = '$id_bukti'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Status pembayaran berhasil diperbarui!');</script>";
    } else {
        echo "<script>alert('Gagal memperbarui status pembayaran.');</script>";
    }
}

// Ambil semua data bukti pembayaran
$sql = "SELECT * FROM bukti_pembayaran";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Pengurus - Verifikasi Pembayaran</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Verifikasi Bukti Pembayaran</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Tanggal Upload</th>
                    <th>Jumlah Bayar</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Catatan Admin</th>
                    <th>Bukti</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['nim']}</td>
                            <td>{$row['tanggal_upload']}</td>
                            <td>{$row['jumlah_bayar']}</td>
                            <td>{$row['metode_pembayaran']}</td>
                            <td>{$row['status_verifikasi']}</td>
                            <td>{$row['catatan_admin']}</td>
                            <td><img src='uploads/{$row['gambar']}' width='100'></td>
                            <td>
                                <form action='' method='post'>
                                    <input type='hidden' name='id_bukti' value='{$row['id_bukti']}'>
                                    <select name='status_verifikasi' class='form-select mb-2'>
                                        <option value='Menunggu'>Menunggu</option>
                                        <option value='Diterima'>Diterima</option>
                                        <option value='Ditolak'>Ditolak</option>
                                    </select>
                                    <textarea name='catatan_admin' class='form-control mb-2' placeholder='Catatan Admin'></textarea>
                                    <button type='submit' name='verifikasi' class='btn btn-primary'>Simpan</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Belum ada bukti pembayaran.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
