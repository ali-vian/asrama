<?php
// admin.php
// Pastikan file config.php dapat diakses
$config_file = 'config.php';

// Proses perubahan status pendaftaran
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'] ?? 'close'; // Default ke 'close' jika tidak ada input
    $new_status = $status === 'open' ? 'true' : 'false';

    // Update file konfigurasi
    $config_content = "<?php\n\$registration_open = $new_status;\n?>";
    file_put_contents($config_file, $config_content); // Overwrite file config.php
}

// Ambil status saat ini dari file konfigurasi
include $config_file;
$current_status = $registration_open ? 'open' : 'close';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Kelola Pendaftaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .status {
            font-size: 20px;
            margin-bottom: 20px;
        }
        .btn {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-open {
            background-color: #28a745;
            color: white;
        }
        .btn-close {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Kelola Status Pendaftaran</h1>
    <div class="status">
        <p>Status Pendaftaran Saat Ini: <strong><?php echo strtoupper($current_status); ?></strong></p>
    </div>

    <form method="POST">
        <button type="submit" name="status" value="open" class="btn btn-open">Buka Pendaftaran</button>
        <button type="submit" name="status" value="close" class="btn btn-close">Tutup Pendaftaran</button>
    </form>
</body>
</html>
