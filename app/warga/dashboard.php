<?php
// Menyertakan file koneksi
include 'koneksi.php';

// Menyertakan File HeaderSidebar.php
include 'headersidebar.php';

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Validasi email dan password
    $sql_warga = "SELECT * FROM warga WHERE email = '$email'";
    $result_warga = $conn->query($sql_warga);

    if ($result_warga->num_rows > 0) {
        $warga = $result_warga->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $warga['password'])) {
            // Data warga
            $nim = $warga['nim'];
            $nama_warga = $warga['nama'];
            $email_warga = $warga['email'];
            $prodi = $warga['prodi'];
            $kamar = $warga['kamar'];

            // Ambil data absensi
            $sql_absensi = "SELECT * FROM absensi WHERE nim = '$nim'";
            $result_absensi = $conn->query($sql_absensi);
            $total_hadir = 0;
            $total_tidak_hadir = 0;
            $total_izin = 0;

            while ($absensi = $result_absensi->fetch_assoc()) {
                switch ($absensi['status_kehadiran']) {
                    case 'Hadir':
                        $total_hadir++;
                        break;
                    case 'Tidak Hadir':
                        $total_tidak_hadir++;
                        break;
                    case 'Izin':
                        $total_izin++;
                        break;
                }
            }

            // Simpan informasi di sesi
            $_SESSION['nim'] = $nim;
            $_SESSION['nama'] = $nama_warga;
            $_SESSION['email'] = $email_warga;
            $_SESSION['prodi'] = $prodi;
            $_SESSION['kamar'] = $kamar;
            $_SESSION['total_hadir'] = $total_hadir;
            $_SESSION['total_tidak_hadir'] = $total_tidak_hadir;
            $_SESSION['total_izin'] = $total_izin;

            // Arahkan ke dashboard
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Password salah.";
        }
    } else {
        echo "Email tidak ditemukan.";
    }
}

// Mendapatkan tanggal saat ini
$tanggal_sekarang = date('Y-m-d');

// Mengambil semua data kegiatan yang belum dilaksanakan
$sql_kegiatan = "SELECT nama_kegiatan, tanggal_kegiatan, tempat 
                 FROM kegiatan 
                 WHERE tanggal_kegiatan > '$tanggal_sekarang'
                 ORDER BY tanggal_kegiatan ASC";
$result_kegiatan = $conn->query($sql_kegiatan);

// Mengambil data notifikasi terbaru dari view notifikasi_kegiatan
$sql_notifikasi = "SELECT * FROM notifikasi_kegiatan ORDER BY created_at DESC";
$result_notifikasi = $conn->query($sql_notifikasi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Asrama</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9fafb;
            position: relative;
        }
        .sidebar {
            height: 100vh;
            background-color: rgba(255, 255, 255, 0.9);
            border-right: 1px solid #e0e0e0;
            padding-top: 20px;
            position: fixed;
            width: 250px;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: transform 0.3s ease;
        }
        .sidebar.active {
            transform: translateX(0);
        }
        .sidebar .nav-link {
            color: #333;
            font-size: 0.95rem;
            padding: 15px 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            transition: background-color 0.3s;
        }
        .sidebar .nav-link.active {
            background-color: #e0e7ff;
            font-weight: bold;
            color: #1e40af;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(224, 231, 255, 0.8);
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                transform: translateX(-100%);
                z-index: 1000;
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .nav-link {
                justify-content: center;
                text-align: center;
            }
            .menu-button {
                display: inline-block;
                cursor: pointer;
                font-size: 1.5rem;
                color: #6366f1;
            }
            .dashboard-title {
                display: none;
            }
        }
        @media (min-width: 769px) {
            .menu-button {
                display: none;
            }
        }
        .profile-menu {
            display: flex;
            align-items: center;
            position: relative;
            cursor: pointer;
        }
        .profile-menu img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }
        .profile-menu span {
            font-size: 1.2rem;
            color: #6366f1;
            font-weight: bold;
        }
        .profile-menu i {
            color: #6366f1;
            margin-left: 5px;
        }
        .profile-dropdown {
            display: none;
            position: absolute;
            top: 60px;
            right: 0;
            background-color: white;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            z-index: 10;
            min-width: 150px;
        }
        .profile-dropdown a {
            padding: 10px 10px;
            display: block;
            color: #333;
            text-decoration: none;
        }
        .profile-dropdown a:hover {
            background-color: #f0f0f0;
        }
        .profile-menu.show .profile-dropdown {
            display: block;
        }
        .welcome-banner {
            background-color: #6366f1;
            color: white;
            padding: 20px;
            border-radius: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .welcome-banner img {
            width: 150px;
            border-radius: 10px;
        }
        .attendance-section {
            display: flex;
            gap: 1rem;
            margin-top: 20px;
        }
        @media (max-width: 768px) {
            .attendance-section {
                flex-direction: column;
            }
        }
        .attendance-card {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            flex: 1;
        }
        .attendance-card .circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
        }
        .attendance-card.hadir .circle {
            background-color: #4caf50;
            color: white;
        }
        .attendance-card.tidak-hadir .circle {
            background-color: #f44336;
            color: white;
        }
        .attendance-card.izin .circle {
            background-color: #ff9800;
            color: white;
        }
        .next-activity {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .next-activity-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .next-activity-item:last-child {
            border-bottom: none;
        }
        .next-activity-item span {
            background-color: #ffedd5;
            color: #f97316;
            font-weight: bold;
            text-align: center;
            padding: 10px;
            border-radius: 50%;
            margin-right: 15px;
            min-width: 50px;
        }
        .next-activity-item div p {
            margin: 0;
        }
        .notification-icon {
            font-size: 1.5rem;
            margin-left: 590px;
            cursor: pointer;
            color: #6366f1;
            position: relative;
        }
        .notification-dropdown {
            display: none;
            position: absolute;
            top: 60px;
            right: 60px;
            background-color: white;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            z-index: 1000;
            width: 250px;
        }
        .notification-dropdown .notification-item {
            padding: 10px;
            border-bottom: 1px solid #e0e0e0;
            cursor: pointer;
        }
        .notification-dropdown .notification-item:hover {
            background-color: #f0f0f0;
        }
        .notification-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body onclick="closeSidebar(event)">

<div class="container-fluid">
    <div class="row">

        <!-- Main Content -->
        <main class="col-md-10 ml-sm-auto px-4 main-content" onclick="closeSidebar(event)">
            <!-- Mobile Menu Button -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="menu-button d-block d-md-none" onclick="toggleSidebar(event)">
                    <i class="fas fa-bars"></i>
                </div>
                <!-- Title for Desktop -->
                <h3 class="text-dark dashboard-title d-none d-md-block">Dashboard</h3>

                <!-- Notification Icon -->
                <i class="fas fa-bell notification-icon" onclick="toggleNotifications()"></i>
                <div class="notification-dropdown" id="notificationDropdown">
                    <?php
                    if ($result_notifikasi->num_rows > 0) {
                        while ($notif = $result_notifikasi->fetch_assoc()) {
                            echo "<div class='notification-item' onclick='markAsRead(" . $notif['id_kegiatan'] . ")'>
                                    <p><strong>" . $notif['nama_kegiatan'] . "</strong></p>
                                    <small>" . $notif['tanggal_kegiatan'] . "</small>
                                  </div>";
                        }
                    } else {
                        echo "<p>Tidak ada notifikasi baru.</p>";
                    }
                    ?>
                </div>

                <!-- Profile Section -->
                <div class="profile-menu" onclick="toggleProfileDropdown(event)">
                    <img src="../warga/images/Artboard.png" alt="Profile Image">
                    <span><?php echo $nama_warga; ?></span>
                    <i class="fas fa-chevron-down"></i>
                    <div class="profile-dropdown">
                        <a href="#">Profil</a>
                        <a href="#">Pengaturan</a>
                        <a href="#">Keluar</a>
                    </div>
                </div>
            </div>

            <!-- Welcome Banner -->
            <div class="welcome-banner mt-4">
                <div>
                    <h2>Selamat Datang, <?php echo $nama_warga; ?>!</h2>
                    <p>Selalu semangat dan sukses dalam kegiatan belajar dan aktivitas kampus. Bersama, kita ciptakan lingkungan yang inspiratif dan mendukung!</p>
                </div>
                <img src="../warga/images/Artboard.png" alt="Profile Image">
            </div>

            <!-- Attendance Section -->
            <div class="attendance-section">
                <div class="attendance-card hadir">
                    <div class="circle"><?php echo $total_hadir; ?></div>
                    <p>Hadir</p>
                </div>
                <div class="attendance-card tidak-hadir">
                    <div class="circle"><?php echo $total_tidak_hadir; ?></div>
                    <p>Tidak Hadir</p>
                </div>
                <div class="attendance-card izin">
                    <div class="circle"><?php echo $total_izin; ?></div>
                    <p>Izin</p>
                </div>
            </div>

            <!-- Next Activities Section -->
            <div class="next-activity">
                <h6>Kegiatan Selanjutnya</h6>
                <?php
                if ($result_kegiatan->num_rows > 0) {
                    while ($kegiatan = $result_kegiatan->fetch_assoc()) {
                        echo "<div class='next-activity-item'>
                                <span>K</span>
                                <div>
                                    <p class='mb-0'><strong>{$kegiatan['nama_kegiatan']}</strong></p>
                                    <small>{$kegiatan['tanggal_kegiatan']} di {$kegiatan['tempat']}</small>
                                </div>
                              </div>";
                    }
                } else {
                    echo "<p>Tidak ada kegiatan terdaftar.</p>";
                }
                ?>
            </div>
        </main>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function toggleSidebar(event) {
        event.stopPropagation();
        document.getElementById('sidebar').classList.toggle('active');
    }

    function closeSidebar(event) {
        if (!event.target.closest('#sidebar') && !event.target.closest('.menu-button')) {
            document.getElementById('sidebar').classList.remove('active');
        }
    }

    function toggleNotifications() {
        const dropdown = document.getElementById('notificationDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    function markAsRead(idKegiatan) {
        $.ajax({
            url: 'mark_read.php',
            type: 'POST',
            data: { id_kegiatan: idKegiatan },
            success: function(response) {
                location.reload();
            }
        });
    }

    function toggleProfileDropdown(event) {
        event.stopPropagation();
        const profileMenu = document.querySelector('.profile-menu');
        profileMenu.classList.toggle('show');
    }

    // Close the profile dropdown if clicked outside
    document.addEventListener('click', function(event) {
        const profileMenu = document.querySelector('.profile-menu');
        if (!profileMenu.contains(event.target)) {
            profileMenu.classList.remove('show');
        }
    });
</script>
</body>
</html>
