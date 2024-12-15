    <?php 
    session_start();
    if (!isset($_SESSION['nim']) && !$_SESSION['role'] == 'ketua') {
        header("Location: ../../../index.php");
        exit;
    }
    
    include "../templates/new_header.php";?>
    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1 class="page-title text-2xl mb-3 font-bold">Rekap Formulir Ruang Aspirasi</h1>
        </div>

        <!-- Search Bar -->
        <div class="search-container">
            <form method="GET" class="d-flex align-items-center">
                <input type="text" name="search" class="search-input rounded " placeholder="Search..." 
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="btn btn-primary bg-blue-600 rounded ml-2">Search</button>
                <?php if(isset($_GET['search'])): ?>
                    <a href="aspirasi.php" class="btn btn-secondary bg-gray-500 rounded ml-2">Clear</a>
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
                            echo "<a href='detail_aspirasi.php?id=" . $row["id_formulir"] . "' class='p-2 bg-blue-600 hover:bg-blue-700 text-white mr-2 rounded'>
                                    <i class='fas fa-eye'></i> Detail
                                  </a>";
                            echo "<button class='py-0.5 px-1 bg-red-600 hover:bg-red-700 text-white rounded' onclick='deleteAspirasi(" . $row["id_formulir"] . ")'>
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