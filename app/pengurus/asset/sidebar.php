<div class="side-container">
            <a class="side-button <?php if (basename($_SERVER['PHP_SELF']) == "dashboard.php") echo "active"; ?>" href="./index.php">
                <img class="side-img" src="./asset/img/dashboard.png" alt="dashboard">
                Dashboard
            </a>
            <a class="side-button <?php if (basename($_SERVER['PHP_SELF']) == "aspirasi.php") echo "active"; ?>" href="./jejakPendapat/aspirasi.php">
                <img class="side-img" src="./asset/img/aspirasi.png" alt="aspirasi">
                Jejak Pendapat
            </a>

            <a class="side-button <?php if (basename($_SERVER['PHP_SELF']) == "rekap_harian.php" || basename($_SERVER['PHP_SELF']) == "rekap_ekstra.php" || basename($_SERVER['PHP_SELF']) == "rekap_besar.php") echo "active"; ?>" href="../pengurus/absensi_asrama/public/absensi_harian.php">
                <img class="side-img" src="./asset/img/rekap.png" alt="rekap">
                Rekap Absensi
            </a>
            <a class="side-button <?php if (basename($_SERVER['PHP_SELF']) == "event.php") echo "active"; ?>" href="./dashboard Kegiatan/event.php">
                <img class="side-img" src="./asset/img/event.png" alt="event">
                Event
            </a>
            <a class="side-button <?php if (basename($_SERVER['PHP_SELF']) == "pendapat.php") echo "active"; ?>" href="./aspirasiWarga/aspirasi.php">
                <img class="side-img" src="./asset/img/pendapat.png" alt="pendapat">
                Aspirasi
            </a>
            <a class="side-button <?php if (basename($_SERVER['PHP_SELF']) == "ekstrakurikuler.php") echo "active"; ?>" href="daftarekstrakurikuler1.php">
                <img class="side-img" src="./asset/img/ekstrakurikuler.png" alt="ekstrakurikuler">
                Ekstrakurikuler
            </a>
            <a class="side-button <?php if (basename($_SERVER['PHP_SELF']) == "validation.php") echo "active"; ?>" href="./validation_payment/validation.php">
                <img class="side-img" src="./asset/img/pembayaran.png" alt="pembayaran">
                Pembayaran
            </a>
        </div>