<?php 

session_start();
if (!isset($_SESSION['nim']) && !$_SESSION['role'] == 'ketua') {
    header("Location: ../../../index.php");
    exit;
}

include "../templates/new_header.php"?>

    <div class="main-content">
        <?php
        require_once 'config.php';

        if (!isset($_GET['id'])) {
            header("Location: index.php");
            exit;
        }

        $id = $_GET['id'];

        try {
            $query = "
                SELECT 
                    f.*,
                    k.nama_kegiatan
                FROM formulir_kegiatan f
                JOIN warga w ON f.nim = w.nim
                JOIN kegiatan k ON f.id_kegiatan = k.id_kegiatan
                WHERE f.id_formulir_kegiatan = ?
            ";
            
            $stmt = $pdo->prepare($query);
            $stmt->execute([$id]);
            $form = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$form) {
                header("Location: index.php");
                exit;
            }
        ?>
            <div class="page-header">
                <h1 class="page-title font-bold text-xl mb-3">Detail Kepuasan Kegiatan</h1>
            </div>

            <div class="detail-card">
                <div class="detail-content">
                    <div class="detail-group mb-3">
                        <div class="detail-label font-bold">Nomor Induk Mahasiswa</div>
                        <div class="detail-value bg-gray-50 border border-gray-300 text-gray-900 p-2 rounded"><?= htmlspecialchars($form['nim']) ?></div>
                    </div>

                    <div class="detail-group mb-3">
                        <div class="detail-label font-bold">Nama Kegiatan</div>
                        <div class="detail-value bg-gray-50 border border-gray-300 text-gray-900 p-2 rounded"><?= htmlspecialchars($form['nama_kegiatan']) ?></div>
                    </div>

                    <div class="detail-group mb-3 detail-full">
                        <div class="detail-label font-bold">Pertanyaan 1</div>
                        <div class="detail-value bg-gray-50 border border-gray-300 text-gray-900 p-2 rounded"><?= nl2br(htmlspecialchars($form['pertanyaan1'])) ?></div>
                    </div>

                    <div class="detail-group mb-3 detail-full">
                        <div class="detail-label font-bold">Pertanyaan 2</div>
                        <div class="detail-value bg-gray-50 border border-gray-300 text-gray-900 p-2 rounded"><?= nl2br(htmlspecialchars($form['pertanyaan2'])) ?></div>
                    </div>

                    <div class="detail-group mb-3 detail-full">
                        <div class="detail-label font-bold">Pertanyaan 3</div>
                        <div class="detail-value bg-gray-50 border border-gray-300 text-gray-900 p-2 rounded"><?= nl2br(htmlspecialchars($form['pertanyaan3'])) ?></div>
                    </div>

                    <div class="detail-group mb-3 detail-full">
                        <div class="detail-label font-bold">Pertanyaan 4</div>
                        <div class="detail-value bg-gray-50 border border-gray-300 text-gray-900 p-2 rounded"><?= nl2br(htmlspecialchars($form['pertanyaan4'])) ?></div>
                    </div>

                    <div class="detail-group mb-3 detail-full">
                        <div class="detail-label font-bold">Pertanyaan 5</div>
                        <div class="detail-value bg-gray-50 border border-gray-300 text-gray-900 p-2 rounded"><?= nl2br(htmlspecialchars($form['pertanyaan5'])) ?></div>
                    </div>

                    <div class="detail-group mb-3 detail-full">
                        <div class="detail-label font-bold">Saran dan Masukan</div>
                        <div class="detail-value bg-gray-50 border border-gray-300 text-gray-900 p-2 rounded"><?= nl2br(htmlspecialchars($form['saran_masukan'])) ?></div>
                    </div>

                    <div class="detail-actions text-center">
                        <a href="puas-kegiatan.php" class="bg-blue-600 hover:bg-blue-700 py-2 mr-3 px-2 text-white rounded">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <form action="puas-kegiatan.php" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?= $form['id_formulir_kegiatan'] ?>">
                            <button type="submit" name="delete" class="bg-red-600 hover:bg-red-700 py-0.5 px-2 text-white rounded" onclick="return confirm('Are you sure you want to delete this record?')">
                                <i class="fas fa-trash"></i>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php
        } catch(PDOException $e) {
            echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>