<?php 

session_start();
if (!isset($_SESSION['nim']) && !$_SESSION['role'] == 'ketua') {
    header("Location: ../../../index.php");
    exit;
}

    $pageTitle = "Rekap Absensi Kegiatan Ekstrakulikuler";
    require_once '../templates/new_header.php';
?>

<div class="content" style="zoom: 0.8">
<div class="content-top">
        <span class="h1">REKAP ABSENSI KEGIATAN EKSTRAKULIKULER</span>
        
        <div class="select">
            <div class="select-button">
                <button class="select-btn text-button" onclick="dropdownAbsensi()">Absensi Ekstrakulikuler</button>
                <button class="select-btn v-button" onclick="dropdownAbsensi()">v</button>
            </div>
            <div class="select-content" id="absensiContent">
                <div class="select-option border-bottom" data-value="rekap_harian.php" onclick="selectAbsensi(this)">Absensi Harian</div>
                <div class="select-option border-bottom" data-value="rekap_ekstra.php" onclick="selectAbsensi(this)">Absensi Ekstrakulikuler</div>
                <div class="select-option" data-value="rekap_besar.php" onclick="selectAbsensi(this)">Absensi Hari Besar</div>
            </div>
        </div>
    </div>

    <div class="content-bottom">
    <div class="periode">
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
                "SELECT id_extra, nama_extra FROM extrakulikuler"
            );

            $options = [];
            if ($ekstra->num_rows > 0) {
                while($row = $ekstra->fetch_assoc()) {
                    $options[] = $row;
                }
            }

            $studentsQuery = mysqli_query($conn, 
                "SELECT DISTINCT warga.nim, warga.nama, warga.prodi 
                 FROM warga 
                 JOIN absensi ON absensi.nim = warga.nim
                 WHERE absensi.id_extra = $selectedKegiatan"
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
                                if ($option['id_extra'] == $selectedKegiatan) {
                                    $selectedName = $option['nama_extra'];
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
                            <div class="kegiatan-option border-bottom-kegiatan" data-id="<?= $option['id_extra'] ?>" onclick="selectKegiatan(this)">
                                <?= htmlspecialchars($option['nama_extra']) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="rekap">
            <button class="cetak" onclick="exportEkstra()">
                <img src="../../../assets/img/cetak.png" alt="cetak">
                Cetak
            </button>

            <div class="keterangan" id="keterangan">
                Keterangan:
                <table>
                    <tr>
                        <td>H</td>
                        <td class="left">= Hadir</td>
                    </tr>
                    <tr>
                        <td>I</td>
                        <td class="left">= Izin</td>
                    </tr>
                    <tr>
                        <td>A</td>
                        <td class="left">= Alfa</td>
                    </tr>
                </table>
            </div>

            <table id="tableExcel">
                <thead>
                    <tr class="table-header">
                        <td class="header-radius-left no" rowspan="2">No</td>
                        <td class="nim" rowspan="2">NIM</td>
                        <td class="nama" rowspan="2">Nama</td>
                        <td class="prodi" rowspan="2">Prodi</td>
                        <td class="tanggal" colspan="<?= $monthDateCount ?>">Tanggal</td>
                        <td class="status header-radius-right" colspan="3">Total Absensi</td>
                    </tr>
                    <tr class="table-header">
                        <?php for ($i = 1; $i <= $monthDateCount; $i++): ?>
                            <td class="tanggal_"><?= $i ?></td>
                        <?php endfor; ?>
                        <td class="status-hadir">Hadir</td>
                        <td class="status-hadir">Izin</td>
                        <td class="status-hadir">Alfa</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while ($student = mysqli_fetch_assoc($studentsQuery)): 
                        $nim = $student['nim'];

                        $attendanceQuery = mysqli_query($conn, 
                            "SELECT DAY(waktu_absen) AS day, status_kehadiran 
                             FROM absensi
                             WHERE nim = '$nim'
                             AND id_extra = $selectedKegiatan
                             AND MONTH(waktu_absen) = $selectedMonth"
                        );

                        $attendanceData = array_fill(1, $monthDateCount, '-');

                        while ($attendanceRow = mysqli_fetch_assoc($attendanceQuery)) {
                            $day = (int)$attendanceRow['day'];
                            $status = strtoupper(substr($attendanceRow['status_kehadiran'], 0, 1));
                            $attendanceData[$day] = $status;
                        }

                        $hadirCount = 0;
                        $izinCount = 0;
                        $alfaCount = 0;

                        foreach ($attendanceData as $status) {
                            if ($status === 'H') $hadirCount++;
                            elseif ($status === 'I') $izinCount++;
                            elseif ($status === 'A') $alfaCount++;
                        }
                    ?>
                    <tr class="row-height <?= $no % 2 == 0 ? 'even-row' : '' ?>">
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($student['nim']) ?></td>
                        <td><?= htmlspecialchars($student['nama']) ?></td>
                        <td><?= htmlspecialchars($student['prodi']) ?></td>
                        <?php 
                            foreach ($attendanceData as $dayStatus) {
                                echo "<td>$dayStatus</td>";
                            }
                        ?>
                        <td class="status-hadir"><?= $hadirCount ?></td>
                        <td class="status-hadir"><?= $izinCount ?></td>
                        <td class="status-hadir"><?= $alfaCount ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    var month = <?= $selectedMonth ?>;
    let kegiatan = <?php echo json_encode($selectedName); ?>;
</script>

<?php 
    require_once '../templates/footer.php';
?>
