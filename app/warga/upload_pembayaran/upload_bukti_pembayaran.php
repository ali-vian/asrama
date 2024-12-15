<?php
session_start();
include('koneksi.php');

// Cek jika pengguna adalah warga
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'warga') {
    echo "<script>alert('Akses ditolak! Anda harus login sebagai warga.'); window.location.href = '../../../login.php';</script>";
    exit;
}

// $nim = $_SESSION['nim']; // Ambil NIM dari sesi
$error = '';
$success = false;
$nim = "250411100055";

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal_upload = date("Y-m-d H:i:s");
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $metode_bayar = $_POST['metode_bayar'];
    $status_verifikasi = "Menunggu";
    $catatan_admin = "";

    // Proses upload file
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $file_ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi file
    $allowed_types = ['jpg', 'jpeg', 'png'];
    $max_size = 2 * 1024 * 1024; // 2MB

    if (!in_array($file_ext, $allowed_types)) {
        $error = "Hanya file JPG, JPEG, atau PNG yang diperbolehkan.";
    } elseif ($_FILES["gambar"]["size"] > $max_size) {
        $error = "Ukuran file maksimal adalah 2MB.";
    } elseif (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        $sql_insert = "INSERT INTO bukti_pembayaran (nim, tanggal_upload, jumlah_bayar, metode_bayar, status_verifikasi, gambar, catatan_admin)
                       VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("sssssss", $nim, $tanggal_upload, $jumlah_bayar, $metode_bayar, $status_verifikasi, basename($_FILES["gambar"]["name"]), $catatan_admin);

        if ($stmt->execute()) {
            $success = true;
            header("Refresh:0"); // Refresh halaman untuk menampilkan status terbaru
        } else {
            $error = "Gagal menyimpan bukti pembayaran: " . $stmt->error;
        }
    } else {
        $error = "Gagal mengunggah file.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload Bukti Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Upload Bukti Pembayaran</h2>
        <?php if ($success): ?>
            <div class="alert alert-success">Bukti pembayaran berhasil diunggah.</div>
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>

        <!-- Form Upload -->
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="jumlah_bayar" class="form-label">Jumlah Pembayaran</label>
                <input type="number" class="form-control" name="jumlah_bayar" id="jumlah_bayar" required>
            </div>
            <div class="mb-3">
                <label for="metode_bayar" class="form-label">Metode Pembayaran</label>
                <select class="form-select" name="metode_bayar" id="metode_bayar" required>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="Teller">Teller</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Upload Bukti Pembayaran</label>
                <input type="file" class="form-control" name="gambar" id="gambar" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        <!-- Status Pembayaran -->
        <h3 class="mt-5">Status Pembayaran</h3>
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
