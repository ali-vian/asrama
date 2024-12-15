<?php
session_start();
include('koneksi.php');

// Cek jika pengguna adalah warga
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'warga') {
    echo "<script>alert('Akses ditolak! Anda harus login sebagai warga.'); window.location.href = '../../../login.php';</script>";
    exit;
}

$nim = $_SESSION['nim']; // Ambil NIM dari sesi
$error = '';

// Ambil data status pembayaran terbaru dari database
$sql_status = "SELECT tanggal_upload, jumlah_bayar, metode_bayar, status_verifikasi, gambar 
               FROM bukti_pembayaran 
               WHERE nim = ? 
               ORDER BY tanggal_upload DESC LIMIT 1";
$stmt = $conn->prepare($sql_status);
$stmt->bind_param("s", $nim);
$stmt->execute();
$result = $stmt->get_result();
$pembayaran = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Status Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Status Pembayaran</h2>

        <?php if ($pembayaran): ?>
            <table class="table mt-3">
                <tr>
                    <th>Tanggal Upload</th>
                    <td><?= htmlspecialchars($pembayaran['tanggal_upload']); ?></td>
                </tr>
                <tr>
                    <th>Jumlah Pembayaran</th>
                    <td><?= htmlspecialchars($pembayaran['jumlah_bayar']); ?></td>
                </tr>
                <tr>
                    <th>Metode Pembayaran</th>
                    <td><?= htmlspecialchars($pembayaran['metode_bayar']); ?></td>
                </tr>
                <tr>
                    <th>Status Verifikasi</th>
                    <td>
                        <?php
                        if ($pembayaran['status_verifikasi'] === "menunggu") {
                            echo '<span class="badge bg-warning text-dark">Menunggu</span>';
                        } elseif ($pembayaran['status_verifikasi'] === "diterima") {
                            echo '<span class="badge bg-success">Diterima</span>';
                        } elseif ($pembayaran['status_verifikasi'] === "ditolak") {
                            echo '<span class="badge bg-danger">Ditolak</span>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Bukti Pembayaran</th>
                    <td>
                        <img src="uploads/<?= htmlspecialchars($pembayaran['gambar']); ?>" alt="Bukti Pembayaran" style="max-width: 200px;">
                    </td>
                </tr>
            </table>
        <?php else: ?>
            <div class="alert alert-info">Anda belum mengunggah bukti pembayaran.</div>
        <?php endif; ?>
    </div>
</body>
</html>
