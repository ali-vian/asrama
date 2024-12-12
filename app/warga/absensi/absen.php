<?php
session_start();

// Konfigurasi koneksi database
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'asrama';

// Membuat koneksi
$connection = new mysqli($host, $user, $password, $database);

// Memeriksa koneksi
if ($connection->connect_error) {
    die("Koneksi gagal: " . $connection->connect_error);
}

// Cek apakah pengguna sudah login
if (!isset($_SESSION['nim'])) {
    //header("Location: login.php"); // Arahkan ke halaman login jika belum login
    exit();
}

// Mengambil NIM pengguna dari sesi
// $nim = $_SESSION['nim'];
$nim = '250511010004';
$tanggal = date("Y-m-d");

// Query untuk mengambil data absensi harian
$query = "
    SELECT 
        a.nim,
        k.nama_kegiatan AS nama_kegiatan,
        a.status_kehadiran AS status_kehadiran,
        a.waktu_absen AS waktu_absen,
        a.jenis_absen AS jenis_absen,
        a.keterangan AS keterangan
    FROM 
        absensi a
    LEFT JOIN 
        kegiatan k ON a.id_kegiatan = k.id_kegiatan
    WHERE 
        a.nim = ? AND DATE(a.waktu_absen) = ?
";

$stmt = $connection->prepare($query);
$stmt->bind_param("ss", $nim, $tanggal);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapan Absensi Harian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .container {
            max-width: 800px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            overflow: hidden;
        }
        h2 {
            text-align: center;
            background-color: #007bff;
            color: white;
            margin: 0;
            padding: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Rekapan Absensi Harian</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama Kegiatan</th>
                    <th>Status Kehadiran</th>
                    <th>Waktu Absen</th>
                    <th>Jenis Absen</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['nama_kegiatan'] ?: '-'; ?></td>
                            <td><?php echo $row['status_kehadiran']; ?></td>
                            <td><?php echo date("d-m-Y H:i:s", strtotime($row['waktu_absen'])); ?></td>
                            <td><?php echo $row['jenis_absen']; ?></td>
                            <td><?php echo $row['keterangan']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="no-data">Tidak ada data absensi untuk hari ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$stmt->close();
$connection->close();
?>
