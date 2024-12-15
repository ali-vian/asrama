<?php

session_start();
if (!isset($_SESSION['nim']) && !$_SESSION['role'] == 'ketua') {
    header("Location: ../../../index.php");
    exit;
}

 include "../templates/new_header.php"
 ?>
    <!-- Sidebar
    <div class="sidebar">
        <div class="sidebar-header">
            <h4>Dashboard</h4>
        </div>
        <a href="aspirasi.php" class="nav-item active">
            <i class="fas fa-comments"></i>
            Aspirasi
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-user-plus"></i>
            Pendaftaran Warga
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-clipboard-list"></i>
            Rekap Absensi
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-calendar-alt"></i>
            Event
        </a>
        <a href="puas-kegiatan.php" class="nav-item">
            <i class="fas fa-poll"></i>
            Jajak Pendapat
        </a>
    </div> -->

    <div class="main-content">
        <?php
        // Database connection
        $conn = new mysqli("localhost", "root", "", "asrama");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get aspirasi details
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $stmt = $conn->prepare("SELECT fk.*, w.nama, w.prodi 
                               FROM formulir_kepuasan fk 
                               LEFT JOIN warga w ON fk.nim = w.nim 
                               WHERE fk.id_formulir = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($aspirasi = $result->fetch_assoc()) {
        ?>
            <div class="bg-white shadow-sm p-3 mb-3 rounded">
                <h1 class="page-title text-2xl font-bold">Detail Aspirasi Warga</h1>
            </div>

            <div class="detail-card  shadow-sm p-3 mb-3 rounded bg-white">
                <div class="detail-content grid grid-cols-2 gap-3">
                    <div class="detail-group">
                        <div class="detail-label font-bold">Nomor Induk Mahasiswa</div>
                        <div class="detail-value bg-gray-50 border border-gray-300 text-gray-900 p-2 rounded"><?php echo htmlspecialchars($aspirasi['nim']); ?></div>
                    </div>

                    <!-- <div class="detail-group">
                        <div class="detail-label font-bold">Nama Mahasiswa</div>
                        <div class="detail-value"><?php echo htmlspecialchars($aspirasi['nama']); ?></div>
                    </div>

                    <div class="detail-group">
                        <div class="detail-label font-bold">Program Studi</div>
                        <div class="detail-value"><?php echo htmlspecialchars($aspirasi['prodi']); ?></div>
                    </div> -->

                    <div class="detail-group">
                        <div class="detail-label font-bold">Kategori Aspirasi</div>
                        <div class="bg-gray-50 border border-gray-300 text-gray-900 p-2 rounded"><?php echo htmlspecialchars($aspirasi['kategori']); ?></div>
                    </div>

                    <div class="detail-group col-span-2 detail-aspirasi">
                        <div class="detail-label font-bold">Aspirasi</div>
                        <div class="detail-value bg-gray-50 border border-gray-300 text-gray-900 p-5">
                            <?php echo nl2br(htmlspecialchars($aspirasi['pesan'])); ?>
                            <div class="created-at">
                                Submitted on: <?php echo date('d M Y H:i', strtotime($aspirasi['created_at'])); ?>
                            </div>
                        </div>
                    </div>

                    <div class="detail-actions flex gap-4 justify-center col-span-2">
                        <a href="aspirasi.php" class="py-1 px-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <a href="delete.php?id=<?php echo $id; ?>" class="py-1 px-2 bg-red-600 hover:bg-red-700 text-white rounded" onclick="return confirm('Are you sure you want to delete this aspirasi?')">
                            <i class="fas fa-trash"></i>
                            Delete
                        </a>
                    </div>
                </div>
            </div>
        <?php
        } else {
            echo '<div class="alert alert-danger">Aspirasi not found.</div>';
        }
        
        $stmt->close();
        $conn->close();
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>