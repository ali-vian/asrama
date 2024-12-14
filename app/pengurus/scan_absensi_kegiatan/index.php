<?php
// Koneksi ke database
include "connect.php";

// Query untuk mengambil daftar kegiatan
$query = "SELECT * FROM kegiatan";
$result = $connect->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Daftar Absensi Kegiatan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="asset/css/rekap-absensi.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Manrope' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="asset/css/bar-ketua.css">
    <link rel="stylesheet" href="asset/css/rekap-absensi.css">
    <link rel="stylesheet" href="asset/css/style_penghuni.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex; /* Mengatur tata letak flexbox */
        }

        .sidebar {
            width: 250px; /* Lebar sidebar */
            height: 100vh;
            background: #f8f9fa;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            position: fixed;
            left: 0; /* Menempatkan sidebar di sebelah kiri */
        }

        .content {
            padding: 20px;
            flex: 1; /* Menyebabkan content mengisi sisa ruang yang tersedia */
        }

        .container {
            width: calc(100% - 250px); /* Pastikan lebar container menyesuaikan dengan lebar sidebar */
            margin-left: 270px; /* Beri jarak dari sidebar */
            margin-right: 30px; /* Beri jarak dari sisi kanan */
            margin-top: 20px; /* Menurunkan container beberapa piksel */
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: dashed;
            border-color: grey; 
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            background-color: #e9ecef;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card h2 {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 14px;
            color: #6c757d;
            margin: 5px 0;
        }

        .card a {
            text-decoration: none;
            color: #fff;
        }

        .card .btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            background-color: #007bff;
            color: #fff;
        }

        .card .btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <img class="logo" src="asset/img/logo.png" alt="logo">
        <div class="side-container">
            <a class="side-button <?php if (basename($_SERVER['PHP_SELF']) == "dashboard.php") echo "active"; ?>" href="#dashboard.php">
                <img class="side-img" src="asset/img/dashboard.png" alt="dashboard">
                Dashboard
            </a>
            <a class="side-button <?php if (basename($_SERVER['PHP_SELF']) == "aspirasi.php") echo "active"; ?>" href="#aspirasi.php">
                <img class="side-img" src="asset/img/aspirasi.png" alt="aspirasi">
                Aspirasi
            </a>
            <a class="side-button <?php if (basename($_SERVER['PHP_SELF']) == "pendaftaran.php") echo "active"; ?>" href="#pendaftaran.php">
                <img class="side-img" src="asset/img/pendaftaran.png" alt="pendaftaran">
                Pendaftaran Warga
            </a>
            <a class="side-button <?php if (basename($_SERVER['PHP_SELF']) == "penghuni.php") echo "active"; ?>" href="#penghuni.php">
                <img class="side-img" src="asset/img/user.png" alt="Penghuni">
                Warga Asrama
            </a>
            <a class="side-button <?php if (basename($_SERVER['PHP_SELF']) == "rekap_harian.php" || basename($_SERVER['PHP_SELF']) == "rekap_ekstra.php" || basename($_SERVER['PHP_SELF']) == "rekap_besar.php") echo "active"; ?>" href="rekap_harian.php">
                <img class="side-img" src="asset/img/rekap.png" alt="rekap">
                Rekap Absensi
            </a>
            <a class="side-button <?php if (basename($_SERVER['PHP_SELF']) == "event.php") echo "active"; ?>" href="#event.php">
                <img class="side-img" src="asset/img/event.png" alt="event">
                Event
            </a>
            <a class="side-button <?php if (basename($_SERVER['PHP_SELF']) == "pendapat.php") echo "active"; ?>" href="#pendapat.php">
                <img class="side-img" src="asset/img/pendapat.png" alt="pendapat">
                Jejak Pendapat
            </a>
            <a class="side-button <?php if (basename($_SERVER['PHP_SELF']) == "aspirasi2.php") echo "active"; ?>" href="#aspirasi2.php">
                <img class="side-img" src="asset/img/aspirasi2.png" alt="aspirasi2">
                Aspirasi
            </a>
        </div>
    </div>
    <div class="container">
        <!-- Konten Utama -->
        <div class="content">
            <h1>Daftar Absensi Kegiatan</h1>
            <div class="card-container">
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="card">
                        <h2><?php echo htmlspecialchars($row['nama_kegiatan']); ?></h2>
                        <p><?php echo date('d-m-Y', strtotime($row['tanggal_kegiatan'])); ?></p>
                        <p><?php echo htmlspecialchars($row['tempat']); ?></p>
                        <a href="edit_absen.php?id_kegiatan=<?php echo $row['id_kegiatan']; ?>">
                            <button class="btn btn-absensi">
                                ABSENSI <i class="fas fa-arrow-right"></i>
                            </button>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$connect->close();
?>
