<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Formulir Ruang Aspirasi</title>
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
            position: relative;
        }

        /* Truncate Text Styles */
        .truncate-text {
            position: relative;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
        }

        .truncate-text:hover::after {
            content: attr(data-full-text);
            position: absolute;
            left: 0;
            top: 100%;
            background-color: #374151;
            color: white;
            padding: 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            z-index: 1000;
            min-width: 200px;
            max-width: 400px;
            white-space: normal;
            word-wrap: break-word;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 0.5rem;
        }

        /* Button Styles */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            align-items: start;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            font-size: 0.875rem;
            display: inline-flex; /* Mengubah display ke inline-flex */
            align-items: center; /* Mengatur alignment vertikal ke center */
            justify-content: start; /* Mengatur alignment horizontal ke start */
            gap: 0.5rem; /* Memberikan jarak antara icon dan teks */
            border: none; /* Menghapus border bawaan */
            cursor: pointer; /* Memberikan cursor pointer */
        }

        .btn-detail {
            background-color: var(--primary-color);
            color: white;
            margin-right: 0.5rem;
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

        /* Pagination Styles */
        .pagination-container {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
            padding: 1rem;
        }

        .pagination {
            display: inline-flex;
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
            display: flex;
        }

        .pagination li:last-child {
            border-right: none;
        }

        .pagination li a,
        .pagination li span {
            color: #4b5563;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .pagination li.active span,
        .pagination li.active a {
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

        /* Add z-index management */
        .table tr {
            position: relative;
        }

        .table tr:hover {
            z-index: 1;
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
        <a href="puas-kegiatan.php" class="nav-item">
            <i class="fas fa-poll"></i>
            Jajak Pendapat
        </a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1 class="page-title">Rekap Formulir Ruang Aspirasi</h1>
        </div>

        <!-- Search Bar -->
        <div class="search-container">
            <form method="GET" class="d-flex align-items-center">
                <input type="text" name="search" class="search-input" placeholder="Search..." 
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="btn btn-primary ml-2">Search</button>
                <?php if(isset($_GET['search'])): ?>
                    <a href="aspirasi.php" class="btn btn-secondary ml-2">Clear</a>
                <?php endif; ?>
            </form>
        </div>
        <!-- Table -->
        <div class="custom-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Kategori Aspirasi</th>
                        <th>Created At</th>
                        <th>Aspirasi</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Database connection
                    $conn = new mysqli("localhost", "root", "", "asrama");
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Search functionality
                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    $whereClause = "";
                    if (!empty($search)) {
                        $searchTerm = "%" . $conn->real_escape_string($search) . "%";
                        $whereClause = "WHERE fk.nim LIKE ? 
                                        OR fk.kategori LIKE ? 
                                        OR fk.pesan LIKE ?";
                    }

                    // Pagination
                    $limit = 10;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $start = ($page - 1) * $limit;

                    // Get total records with search
                    $totalRecordsQuery = "SELECT COUNT(id_formulir) AS total FROM formulir_kepuasan fk " . $whereClause;
                    if (!empty($search)) {
                        $stmtCount = $conn->prepare($totalRecordsQuery);
                        $stmtCount->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
                        $stmtCount->execute();
                        $totalResult = $stmtCount->get_result();
                    } else {
                        $totalResult = $conn->query("SELECT COUNT(id_formulir) AS total FROM formulir_kepuasan");
                    }
                    $totalRecords = $totalResult->fetch_assoc()['total'];
                    $totalPages = ceil($totalRecords / $limit);

                    // Fetch records with search
                    $query = "SELECT fk.*, w.nama, w.prodi 
                            FROM formulir_kepuasan fk 
                            LEFT JOIN warga w ON fk.nim = w.nim " 
                            . $whereClause . 
                            " ORDER BY fk.created_at DESC LIMIT ?, ?";

                    if (!empty($search)) {
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("sssii", $searchTerm, $searchTerm, $searchTerm, $start, $limit);
                    } else {
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("ii", $start, $limit);
                    }

                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["nim"]) . "</td>";
                            echo "<td><span class='truncate-text' data-full-text='" . htmlspecialchars($row["kategori"]) . "'>" 
                                . htmlspecialchars($row["kategori"]) . "</span></td>";
                            echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
                            echo "<td><span class='truncate-text' data-full-text='" . htmlspecialchars($row["pesan"]) . "'>" 
                                . htmlspecialchars(substr($row["pesan"], 0, 100)) . "...</span></td>";
                            echo "<td>";
                            echo "<div class='action-buttons'>";
                            echo "<a href='detail_aspirasi.php?id=" . $row["id_formulir"] . "' class='btn btn-action btn-detail'>
                                    <i class='fas fa-eye'></i> Detail
                                  </a>";
                            echo "<button class='btn btn-action btn-delete' onclick='deleteAspirasi(" . $row["id_formulir"] . ")'>
                                    <i class='fas fa-trash'></i> Delete
                                  </button>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
                    }

                    $stmt->close();
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
        <div class="pagination-container">
            <ul class="pagination">
                <?php
                // Calculate range of pages to show
                $range = 2;
                $initial_num = $page - $range;
                $condition_limit_num = ($page + $range) + 1;

                // Show previous button
                if ($page > 1): ?>
                    <li>
                        <a href="?page=<?= ($page-1) ?><?= $search ? '&search=' . urlencode($search) : '' ?>">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                <?php endif;

                // Show first page button if not in first range
                if ($initial_num > 1): ?>
                    <li><a href="?page=1<?= $search ? '&search=' . urlencode($search) : '' ?>">1</a></li>
                    <?php if ($initial_num > 2): ?>
                        <li><span>...</span></li>
                    <?php endif;
                endif;

                // Show page numbers
                for ($i = $initial_num; $i < $condition_limit_num; $i++):
                    if ($i > 0 && $i <= $totalPages): ?>
                        <li class="<?= $page == $i ? 'active' : '' ?>">
                            <?php if ($page == $i): ?>
                                <span><?= $i ?></span>
                            <?php else: ?>
                                <a href="?page=<?= $i ?><?= $search ? '&search=' . urlencode($search) : '' ?>"><?= $i ?></a>
                            <?php endif; ?>
                        </li>
                    <?php endif;
                endfor;

                // Show last page button if not in last range
                if ($condition_limit_num <= $totalPages): 
                    if ($condition_limit_num < $totalPages): ?>
                        <li><span>...</span></li>
                    <?php endif; ?>
                    <li><a href="?page=<?= $totalPages ?><?= $search ? '&search=' . urlencode($search) : '' ?>"><?= $totalPages ?></a></li>
                <?php endif;

                // Show next button
                if ($page < $totalPages): ?>
                    <li>
                        <a href="?page=<?= ($page+1) ?><?= $search ? '&search=' . urlencode($search) : '' ?>">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function deleteAspirasi(id) {
            if (confirm('Are you sure you want to delete this aspirasi?')) {
                window.location.href = 'delete.php?id=' + id;
            }
        }
    </script>
</body>
</html>