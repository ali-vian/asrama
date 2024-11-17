<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Formulir Kepuasan Kegiatan</title>
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
        .detail-card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

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

        .detail-full {
            grid-column: span 2;
        }

        .detail-actions {
            display: flex;
            justify-content: center;
            gap: 5rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e5e7eb;
            grid-column: span 2;
        }

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

        @media (max-width: 768px) {
            .detail-content {
                grid-template-columns: 1fr;
            }
            
            .detail-full {
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
        <a href="formulir-kepuasan-kegiatan.php" class="nav-item">
            <i class="fas fa-envelope-open-text"></i>
            Formulir Kepuasan Kegiatan
        </a>
    </div>

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
                <h1 class="page-title">Detail Kepuasan Kegiatan</h1>
            </div>

            <div class="detail-card">
                <div class="detail-content">
                    <div class="detail-group">
                        <div class="detail-label">Nama Kegiatan</div>
                        <div class="detail-value"><?= htmlspecialchars($form['nama_kegiatan']) ?></div>
                    </div>

                    <div class="detail-group detail-full">
                        <div class="detail-label">Pertanyaan 1</div>
                        <div class="detail-value"><?= nl2br(htmlspecialchars($form['pertanyaan1'])) ?></div>
                    </div>

                    <div class="detail-group detail-full">
                        <div class="detail-label">Pertanyaan 2</div>
                        <div class="detail-value"><?= nl2br(htmlspecialchars($form['pertanyaan2'])) ?></div>
                    </div>

                    <div class="detail-group detail-full">
                        <div class="detail-label">Pertanyaan 3</div>
                        <div class="detail-value"><?= nl2br(htmlspecialchars($form['pertanyaan3'])) ?></div>
                    </div>

                    <div class="detail-group detail-full">
                        <div class="detail-label">Pertanyaan 4</div>
                        <div class="detail-value"><?= nl2br(htmlspecialchars($form['pertanyaan4'])) ?></div>
                    </div>

                    <div class="detail-group detail-full">
                        <div class="detail-label">Pertanyaan 5</div>
                        <div class="detail-value"><?= nl2br(htmlspecialchars($form['pertanyaan5'])) ?></div>
                    </div>

                    <div class="detail-group detail-full">
                        <div class="detail-label">Saran dan Masukan</div>
                        <div class="detail-value"><?= nl2br(htmlspecialchars($form['saran_masukan'])) ?></div>
                    </div>

                    <div class="detail-actions">
                        <a href="puas-kegiatan.php" class="btn btn-action btn-back">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <a href="edit_formulir_kegiatan.php?id=<?= $form['id_formulir_kegiatan'] ?>" class="btn btn-action btn-success">
                            <i class="fas fa-edit"></i>
                            Edit
                        </a>
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