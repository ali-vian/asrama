<?php
require_once 'config.php';

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
            f.saran_masukan
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Formulir Kepuasan Kegiatan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --sidebar-width: 250px;
            --header-height: 60px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        /* Sidebar Styles */
        .sidebar {
            height: 100vh;
            width: var(--sidebar-width);
            background: white;
            position: fixed;
            left: 0;
            top: 0;
            border-right: 1px solid #e5e7eb;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .sidebar-header h4 {
            color: var(--primary-color);
            font-weight: 600;
            margin: 0;
        }

        .nav-item {
            padding: 0.75rem 1.5rem;
            color: #4b5563;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .nav-item:hover {
            background-color: #f3f4f6;
            color: var(--primary-color);
            text-decoration: none;
        }

        .nav-item i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
        }

        .page-header {
            background: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.5rem;
            color: #111827;
            font-weight: 600;
            margin: 0;
        }

        /* Table Styles */
        .custom-table {
            background: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #f9fafb;
            color: #374151;
            font-weight: 600;
            border-bottom: 2px solid #e5e7eb;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            color: #4b5563;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f9fafb;
        }
        
        .table td {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .pagination-container {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            background: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .pagination li {
            border-right: 1px solid #e5e7eb;
        }

        .pagination li:last-child {
            border-right: none;
        }

        .pagination li a,
        .pagination li span {
            color: #4b5563;
            padding: 0.75rem 1rem;
            display: block;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .pagination li.active span {
            background-color: var(--primary-color);
            color: white;
        }

        .pagination li a:hover {
            background-color: #f3f4f6;
            color: var(--primary-color);
        }

        .pagination li.disabled span {
            color: #9ca3af;
            cursor: not-allowed;
            background-color: #f9fafb;
        }

        /* Tooltip styles */
        .truncate-text {
            position: relative;
            cursor: pointer;
        }

        .truncate-text:hover::after {
            content: attr(data-full-text);
            position: absolute;
            left: 0;
            top: 100%;
            background-color: #374151;
            color: white;
            padding: 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            z-index: 1000;
            max-width: 300px;
            white-space: normal;
            word-wrap: break-word;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Button Styles */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
        }

        .btn-detail {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-detail:hover {
            background-color: #1d4ed8;
            color: white;
        }

        .btn-delete {
            background-color: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background-color: #dc2626;
            color: white;
        }

        /* Search Bar Styles */
        .search-container {
            background: white;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .search-input {
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            width: 100%;
            max-width: 300px;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4>Dashboard</h4>
        </div>
        <a href="aspirasi.php" class="nav-item">
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
        <a href="#" class="nav-item">
            <i class="fas fa-poll"></i>
            Jajak Pendapat
        </a>
    </div>

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
                        <th>NIM</th>
                        <th>Nama Kegiatan</th>
                        <th>Pertanyaan 1</th>
                        <th>Saran Masukan</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($forms)): ?>
                        <?php foreach ($forms as $form): ?>
                        <tr>
                            <td><?= htmlspecialchars($form['nim']) ?></td>
                            <td class="truncate-text" data-full-text="<?= htmlspecialchars($form['nama_kegiatan']) ?>">
                                <?= truncateText($form['nama_kegiatan'], 30) ?>
                            </td>
                            <td class="truncate-text" data-full-text="<?= htmlspecialchars($form['pertanyaan1']) ?>">
                                <?= truncateText($form['pertanyaan1'], 40) ?>
                            </td>
                            <td class="truncate-text" data-full-text="<?= htmlspecialchars($form['saran_masukan']) ?>">
                                <?= truncateText($form['saran_masukan'], 40) ?>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="detail_kegiatan.php?id=<?= $form['id_formulir_kegiatan'] ?>" class="btn btn-action btn-detail">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <form action="" method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="<?= $form['id_formulir_kegiatan'] ?>">
                                        <button type="submit" name="delete" class="btn btn-action btn-delete" 
                                                onclick="return confirm('Are you sure you want to delete this record?')">
                                            <i class="fas fa-trash"></i> Delete
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