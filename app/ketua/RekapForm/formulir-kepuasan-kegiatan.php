<?php
require_once 'config.php';


session_start();
if (!isset($_SESSION['nim']) && !$_SESSION['role'] == 'ketua') {
    header("Location: ../../../index.php");
    exit;
}

// Handle Delete Action
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM formulir_kegiatan WHERE id_formulir_kegiatan = ?");
        $stmt->execute([$id]);
        header("Location: puas-kegiatan.php");
        exit;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Pagination Configuration
$records_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Search Functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchCondition = '';
$params = [];

if ($search) {
    $searchCondition = "WHERE w.nim LIKE ? OR w.nama LIKE ? OR w.prodi LIKE ? OR k.nama_kegiatan LIKE ?";
    $params = ["%$search%", "%$search%", "%$search%", "%$search%"];
}

// Count total records for pagination
try {
    $count_query = "
        SELECT COUNT(*) 
        FROM formulir_kegiatan f
        JOIN warga w ON f.nim = w.nim
        JOIN kegiatan k ON f.id_kegiatan = k.id_kegiatan
        $searchCondition
    ";
    $count_stmt = $pdo->prepare($count_query);
    $count_stmt->execute($params);
    $total_records = $count_stmt->fetchColumn();
    $total_pages = ceil($total_records / $records_per_page);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Fetch Data
try {
    $query = "
        SELECT 
            f.id_formulir_kegiatan,
            w.nim,
            k.nama_kegiatan,
            f.pertanyaan1,
            f.pertanyaan2,
            f.pertanyaan3,
            f.pertanyaan4,
            f.pertanyaan5,
            f.saran_masukan,
            f.status
        FROM formulir_kegiatan f
        JOIN warga w ON f.nim = w.nim
        JOIN kegiatan k ON f.id_kegiatan = k.id_kegiatan
        $searchCondition
        ORDER BY f.id_formulir_kegiatan DESC
        LIMIT $records_per_page OFFSET $offset
    ";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $forms = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Function to truncate text
function truncateText($text, $length = 50) {
    if (strlen($text) > $length) {
        return substr($text, 0, $length) . '...';
    }
    return $text;
}
if (isset($_POST['toggle_access'])) {
    // Dapatkan ID dan status akses saat ini dari form
    $id = $_POST['id_formulir_kegiatan'];
    $current_status = $_POST['status'];

    // Toggle status akses (jika 'aktif' menjadi 'tidak aktif', dan sebaliknya)
    $new_status = ($current_status === 'aktif') ? 'tidak_aktif' : 'aktif';

    // Perbarui status akses di database
    try {
        $stmt = $pdo->prepare("UPDATE formulir_kegiatan SET status = ? WHERE id_formulir_kegiatan = ?");
        $stmt->execute([$new_status, $id]);

        // Redirect untuk menghindari resubmission form
        header("Location: formulir-kepuasan-kegiatan.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}



$no = 1;

include "../templates/new_header.php"
?>


    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1 class="page-title">Rekap Formulir Kepuasan Kegiatan</h1>
        </div>

        <!-- Search Bar -->
        <div class="search-container">
            <form method="GET" class="d-flex align-items-center">
                <input type="text" name="search" class="search-input" placeholder="Search..." 
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="btn btn-primary ml-2">Search</button>
                <?php if(isset($_GET['search'])): ?>
                    <a href="puas-kegiatan.php" class="btn btn-secondary ml-2">Clear</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Table -->
        <div class="custom-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($forms)): ?>
                        <?php foreach ($forms as $form): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="truncate-text" data-full-text="<?= htmlspecialchars($form['nama_kegiatan']) ?>">
                                <?= truncateText($form['nama_kegiatan'], 30) ?>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="detail_formulir.php?id=<?= $form['id_formulir_kegiatan'] ?>" class="btn btn-action btn-detail">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <form action="" method="POST" class="d-inline">
                                        <input type="hidden" name="id_formulir_kegiatan" value="<?= $form['id_formulir_kegiatan'] ?>">
                                        <input type="hidden" name="status" value="<?= $form['status'] ?>">
                                        <button type="submit" name="toggle_access" class="btn btn-action <?= $form['status'] === 'aktif' ? 'btn-danger' : 'btn-success' ?>">
                                            <i class="fas fa-toggle-<?= $form['status'] === 'aktif' ? 'off' : 'on' ?>"></i> 
                                            <?= $form['status'] === 'aktif' ? 'Deactivate Access' : 'Activate Access' ?>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No records found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="pagination-container">
            <ul class="pagination">
                <li class="<?= $page <= 1 ? 'disabled' : '' ?>">
                    <?php if ($page <= 1): ?>
                        <span><i class="fas fa-chevron-left"></i></span>
                    <?php else: ?>
                        <a href="?page=<?= $page - 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    <?php endif; ?>
                </li>

                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="<?= $page == $i ? 'active' : '' ?>">
                        <?php if ($page == $i): ?>
                            <span><?= $i ?></span>
                        <?php else: ?>
                            <a href="?page=<?= $i ?><?= $search ? '&search=' . urlencode($search) : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endif; ?>
                    </li>
                <?php endfor; ?>

                <li class="<?= $page >= $total_pages ? 'disabled' : '' ?>">
                    <?php if ($page >= $total_pages): ?>
                        <span><i class="fas fa-chevron-right"></i></span>
                    <?php else: ?>
                        <a href="?page=<?= $page + 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>