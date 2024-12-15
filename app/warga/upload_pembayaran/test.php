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