<?php 
    // session_start();
    // // Validasi sesi login dan role warga
    // if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'warga') {
    //     header('Location: ../landing_page.php'); // Redirect ke halaman login jika tidak valid
    //     exit();
    // }

    // require_once '../templates/header.php';

    // // Ambil NIM pengguna dari sesi login
    // $user_nim = $_SESSION['nim'];
    

    // Ambil NIM pengguna dari sesi login
    require_once '../../ketua/templates/header.php';
    $nim = '12345678901'; // NIM pengguna
?>


<div class="content">

    <div class="content-top">
        <span class="h1">REKAP ABSENSI KEGIATAN HARI BESAR SAYA</span>
        
        <div class="select">
            <div class="select-button">
                <button class="select-btn text-button" onclick="dropdownAbsensi()">Absensi Hari Besar</button>
                <button class="select-btn v-button" onclick="dropdownAbsensi()">v</button>
            </div>
            <div class="select-content" id="absensiContent">
                <div class="select-option border-bottom" data-value="hari_besar.php" onclick="selectAbsensi(this)">Absensi Harian</div>
                <div class="select-option border-bottom" data-value="ekstrakulikuler.php" onclick="selectAbsensi(this)">Absensi Ekstrakulikuler</div>
                <div class="select-option" data-value="harbes.php" onclick="selectAbsensi(this)" selected>Absensi Hari Besar</div>
            </div>
        </div>
    </div>

    <div class="content-bottom">

    <div class="periode" style="display: none;">
            <span class="h3">Bulan</span>
            <div class="select-bulan">
                <div class="bulan-dropdwon">     
                    <div class="button-bulan">
                        <button class="bulan-btn text-bulan" onclick="bulanDropdown()"></button>
                        <button class="bulan-btn v-bulan" onclick="bulanDropdown()">v</button>
                    </div>
                    <div class="bulan-content" id="bulanContent"></div>
                </div>
            </div>
        </div>


        <?php 
            $selectedMonth = isset($_GET['month']) ? (int)$_GET['month'] : date('n');
            $selectedKegiatan = isset($_GET['kegiatan']) ? (int)$_GET['kegiatan'] : 1;

            $ekstra = mysqli_query($conn, 
                "SELECT id_kegiatan, nama_kegiatan FROM kegiatan"
            );

            $options = [];
            if ($ekstra->num_rows > 0) {
                while($row = $ekstra->fetch_assoc()) {
                    $options[] = $row;
                }
            }

            // Ambil data absensi berdasarkan kegiatan yang dipilih
                $studentsQuery = mysqli_query($conn, 
                "SELECT warga.nim, warga.nama, warga.prodi, absensi.status_kehadiran
                FROM warga 
                JOIN absensi ON absensi.nim = warga.nim
                WHERE absensi.id_kegiatan = $selectedKegiatan AND warga.nim = '$nim'"
            );

            $monthDateCount = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, date('Y'));
        ?>

        <div class="nama-kegiatan">
            <span class="h3">Nama Kegiatan</span>
            <div class="kegiatan">
                <div class="kegiatan-dropdown">
                    <div class="kegiatan-button">
                    <button class="kegiatan-btn text-kegiatan" onclick="kegiatanDropdown()">
                        <?php 
                            $selectedName = '';
                            foreach ($options as $option) {
                                if ($option['id_kegiatan'] == $selectedKegiatan) {
                                    $selectedName = $option['nama_kegiatan'];
                                    break;
                                }
                            }
                            echo $selectedName; 
                        ?>
                    </button>
                        <button class="kegiatan-btn v-kegiatan" onclick="kegiatanDropdown()">v</button>
                    </div>
                    <div class="kegiatan-content" id="kegiatanContent">
                        <?php foreach ($options as $option): ?>
                            <div class="kegiatan-option border-bottom-kegiatan" data-id="<?= $option['id_kegiatan'] ?>" onclick="selectKegiatanBesar(this)">
                                <?= htmlspecialchars($option['nama_kegiatan']) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="rekap">
            <button class="cetak" onclick="exportBesar()">
                <img src="../../../assets/img/cetak.png" alt="cetak">
                Cetak
            </button>

            <table id="tableExcel">
                <thead>
                    <tr class="table-header">
                        <td class="header-radius-left no">No</td>
                        <td class="nim">NIM</td>
                        <td class="nama">Nama</td>
                        <td class="prodi">Prodi</td>
                        <td class="status header-radius-right">Status</td>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $no = 1;
                    while ($student = mysqli_fetch_assoc($studentsQuery)):

                    ?>
                    <tr class="row-height <?= $no % 1 == 0 ? 'even-row' : '' ?>">
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($student['nim']) ?></td>
                        <td><?= htmlspecialchars($student['nama']) ?></td>
                        <td><?= htmlspecialchars($student['prodi']) ?></td>
                        <td><?= htmlspecialchars($student['status_kehadiran']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

        </div>

    </div>

</div>

<script>    
    function selectKegiatanBesar(element) {
        const selectedId = element.getAttribute('data-id');
        const currentPage = window.location.pathname;
        window.location.href = `${currentPage}?kegiatan=${selectedId}`;
    }

    let kegiatan = <?php echo json_encode($selectedName); ?>;
</script>



<?php 
    require_once '../templates/footer.php';
?>
