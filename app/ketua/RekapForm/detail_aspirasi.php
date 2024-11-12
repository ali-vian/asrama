<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Formulir Ruang Aspirasi</title>
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

        /* Detail Card Styles */
        .detail-actions {
            display: flex;
            justify-content: center;
            gap: 5rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e5e7eb;
            grid-column: span 2;
        }

        .detail-card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .detail-header {
            display: none;
        }

        /* Button Styles */
        .btn-action {
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 120px;
            justify-content: center;
        }

        .btn-back {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-back:hover {
            background-color: #1d4ed8;
            color: white;
            text-decoration: none;
        }

        .btn-delete {
            background-color: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background-color: #dc2626;
            color: white;
            text-decoration: none;
        }

        /* Detail Content Styles */
        .detail-content {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        .detail-group {
            margin-bottom: 1.5rem;
        }

        .detail-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .detail-value {
            color: #4b5563;
            font-size: 1rem;
            line-height: 1.5;
            padding: 0.75rem;
            background-color: #f9fafb;
            border-radius: 0.375rem;
            border: 1px solid #e5e7eb;
        }

        .detail-aspirasi {
            grid-column: span 2;
        }

        .detail-aspirasi .detail-value {
            min-height: 150px;
            white-space: pre-wrap;
        }

        .created-at {
            color: #6b7280;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        @media (max-width: 768px) {
            .detail-content {
                grid-template-columns: 1fr;
            }
            
            .detail-aspirasi {
                grid-column: span 1;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
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
    </div>

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
            <div class="page-header">
                <h1 class="page-title">Detail Aspirasi Warga</h1>
            </div>

            <div class="detail-card">
                <div class="detail-content">
                    <div class="detail-group">
                        <div class="detail-label">Nomor Induk Mahasiswa</div>
                        <div class="detail-value"><?php echo htmlspecialchars($aspirasi['nim']); ?></div>
                    </div>

                    <!-- <div class="detail-group">
                        <div class="detail-label">Nama Mahasiswa</div>
                        <div class="detail-value"><?php echo htmlspecialchars($aspirasi['nama']); ?></div>
                    </div>

                    <div class="detail-group">
                        <div class="detail-label">Program Studi</div>
                        <div class="detail-value"><?php echo htmlspecialchars($aspirasi['prodi']); ?></div>
                    </div> -->

                    <div class="detail-group">
                        <div class="detail-label">Kategori Aspirasi</div>
                        <div class="detail-value"><?php echo htmlspecialchars($aspirasi['kategori']); ?></div>
                    </div>

                    <div class="detail-group detail-aspirasi">
                        <div class="detail-label">Aspirasi</div>
                        <div class="detail-value">
                            <?php echo nl2br(htmlspecialchars($aspirasi['pesan'])); ?>
                            <div class="created-at">
                                Submitted on: <?php echo date('d M Y H:i', strtotime($aspirasi['created_at'])); ?>
                            </div>
                        </div>
                    </div>

                    <div class="detail-actions">
                        <a href="aspirasi.php" class="btn btn-action btn-back">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <a href="delete.php?id=<?php echo $id; ?>" class="btn btn-action btn-delete" onclick="return confirm('Are you sure you want to delete this aspirasi?')">
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