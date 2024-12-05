<?php
    // include '../base.php';

    $pages = basename($_SERVER['PHP_SELF']);
    $no = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../../assets/js/rekap-absensi.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Manrope' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../assets/css/bar-ketua.css">
    <link rel="stylesheet" href="../../../assets/css/rekap-absensi.css">
    <link rel="stylesheet" href="../../../assets/css/style_penghuni.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Section -->
            <div class="col-md-3 col-lg-2 p-0 sidebar">
                <!-- Sidebar Content -->
                <img class="logo" src="../../warga1/images/logo.png" alt="logo">
                
                <div class="side-container">
                    <a class="side-button <?php if ($pages == 'dashboard.php') echo 'active'; ?>" href="dashboard.php">
                        <img class="side-img" src="../../warga1/images/dashboard.png" alt="dashboard">
                        Dashboard
                    </a>

                    <a class="side-button" id ="menu-aspirasi" <?php if ($pages == 'aspirasi.php') echo 'active'; ?> href="formulir_kepuasan.php">
                        <img class="side-img" src="../../warga1/images/aspirasi.png" alt="aspirasi">
                        Aspirasi
                    </a>

                    <a class="side-button" id="menu-pendaftaran-warga" <?php if ($pages == 'pendaftaran.php') echo 'active'; ?> href="pendaftaran_warga.php">
                        <img class="side-img" src="../../warga1/images/pendaftaran.png" alt="pendaftaran">
                        Pendaftaran Warga
                    </a>

                    <a class="side-button <?php if ($pages == 'penghuni.php') echo 'active'; ?>" href="penghuni.php">
                        <img class="side-img" src="../../warga1/images/user.png" alt="penghuni">
                        Warga Asrama
                    </a>

                    <a class="side-button <?php if ($pages == 'rekap_harian.php' || $pages == 'rekap_ekstra.php' || $pages == 'rekap_besar.php') echo 'active'; ?>" href="rekap_harian.php">
                        <img class="side-img" src="../../warga1/images/rekap.png" alt="rekap">
                        Rekap Absensi
                    </a>

                    <a class="side-button <?php if ($pages == 'event.php') echo 'active'; ?>" href="event.php">
                        <img class="side-img" src="../../warga1/images/event.png" alt="event">
                        Event
                    </a>

                    <a class="side-button" id="menu-jejak-pendapat" <?php if ($pages == 'pendapat.php') echo 'active'; ?> href="formulir_kegiatan.php">
                        <img class="side-img" src="../../warga1/images/pendapat.png" alt="pendapat">
                        Jejak Pendapat
                    </a>

                    <a class="side-button <?php if ($pages == 'aspirasi2.php') echo 'active'; ?>" href="aspirasi2.php">
                        <img class="side-img" src="../../warga1/images/aspirasi2.png" alt="aspirasi2">
                        Aspirasi 2
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and Custom JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add any custom JavaScript if needed
    </script>
</body>
</html>
