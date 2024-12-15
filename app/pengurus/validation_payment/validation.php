<?php
include('koneksi.php');

$BASEPATH = "localhost/asrama/asrama/app";

$success = '';
$error = '';

// Proses update status pembayaran
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verifikasi'])) {
    $id_bukti = $_POST['id_bukti'];
    $status_verifikasi = $_POST['status_verifikasi'];
    $catatan_admin = $_POST['catatan_admin'];

    // Update status pembayaran di database
    $sql_update = "UPDATE bukti_pembayaran SET status_verifikasi = ?, catatan_admin = ? WHERE id_bukti = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("ssi", $status_verifikasi, $catatan_admin, $id_bukti);

    if ($stmt->execute()) {
        $success = "Status pembayaran berhasil diperbarui.";
    } else {
        $error = "Gagal memperbarui status pembayaran: " . $stmt->error;
    }
}

// Ambil semua data bukti pembayaran dari database
$sql = "SELECT bp.id_bukti, bp.nim, bp.tanggal_upload, bp.jumlah_bayar, bp.metode_bayar, bp.status_verifikasi, bp.gambar, bp.catatan_admin,
               w.nama, w.kamar
        FROM bukti_pembayaran bp
        JOIN warga w ON bp.nim = w.nim";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Verifikasi Bukti Pembayaran</h2>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= $success; ?></div>
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Bukti</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Kamar</th>
                    <th>Tanggal Upload</th>
                    <th>Jumlah Bayar</th>
                    <th>Metode Bayar</th>
                    <th>Status</th>
                    <th>Gambar</th>
                    <th>Catatan Admin</th>
                    <th>Verifikasi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id_bukti']; ?></td>
                    <td><?= $row['nim']; ?></td>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['kamar']; ?></td>
                    <td><?= $row['tanggal_upload']; ?></td>
                    <td><?= $row['jumlah_bayar']; ?></td>
                    <td><?= $row['metode_bayar']; ?></td>
                    <td>
                        <?php
                        if ($row['status_verifikasi'] === 'menunggu') {
                            echo '<span class="badge bg-warning text-dark">Menunggu</span>';
                        } elseif ($row['status_verifikasi'] === 'diterima') {
                            echo '<span class="badge bg-success">Diterima</span>';
                        } elseif ($row['status_verifikasi'] === 'ditolak') {
                            echo '<span class="badge bg-danger">Ditolak</span>';
                        }
                        ?>
                    </td>
                    <td>
                        <a href="/warga/upload_pembayaran/uploads/<?= $row['gambar']; ?>" target="_blank">
                            <img src="<?= $BASEPATH ?>/warga/upload_pembayaran/uploads/<?= $row['gambar']; ?>" alt="Bukti" width="100">
                        </a>
                    </td>
                    <td><?= $row['catatan_admin']; ?></td>
                    <td>
                        <!-- Form untuk verifikasi -->
                        <form action="" method="post">
                            <input type="hidden" name="id_bukti" value="<?= $row['id_bukti']; ?>">
                            <select name="status_verifikasi" class="form-select mb-2" required>
                                <option value="Diterima">Diterima</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                            <textarea name="catatan_admin" class="form-control mb-2" placeholder="Catatan (opsional)"></textarea>
                            <button type="submit" name="verifikasi" class="btn btn-primary btn-sm">Submit</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
