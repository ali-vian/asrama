<?php 

session_start();
if (!isset($_SESSION['nim']) && !$_SESSION['role'] == 'ketua') {
    header("Location: ../../../index.php");
    exit;
}


    $pageTitle = "Rekap Absensi Harian";

    require_once '../templates/new_header.php';
?>

<div class="content">

    <div class="content-top">
        <span class="h1">REKAP ABSENSI HARIAN</span>
        
        <div class="select">
            <div class="select-button">
                <button class="select-btn text-button" onclick="dropdownAbsensi()">Absensi Harian</button>
                <button class="select-btn v-button" onclick="dropdownAbsensi()">v</button>
            </div>
            <div class="select-content" id="absensiContent">
                <div class="select-option border-bottom" data-value="rekap_harian.php" onclick="selectAbsensi(this)" selected>Absensi Harian</div>
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

        <div class="kegiatan" style="display: none;">
                <div class="kegiatan-dropdown">
                    <div class="kegiatan-button">
                        <button class="kegiatan-btn text-kegiatan" onclick="kegiatanDropdown()">Pramuka</button>
                        <button class="kegiatan-btn v-kegiatan" onclick="kegiatanDropdown()">v</button>
                    </div>
                    <div class="kegiatan-content" id="kegiatanContent">
                    </div>
                </div>
            </div>


        <div class="rekap">
            <button class="cetak" onclick="exportHarian()">
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

            <?php
                $selectedMonth = isset($_GET['month']) ? (int)$_GET['month'] : date('n');

                $absensi = mysqli_query($conn, 
                "SELECT warga.nim, nama, prodi, waktu_absen, status_kehadiran FROM absensi
                        JOIN warga ON absensi.nim = warga.nim
                        WHERE jenis_absen = 'harian' 
                        AND MONTH(waktu_absen) = $selectedMonth"
                );

                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, date('Y'));
            ?>

            <table id="tableExcel">
                <thead>
                    <tr class="table-header">
                        <td class="header-radius-left no" rowspan="2">No</td>
                        <td class="nim" rowspan="2">NIM</td>
                        <td class="nama" rowspan="2">Nama</td>
                        <td class="prodi" rowspan="2">Prodi</td>
                        <td class="tanggal" <?php echo "colspan=".$daysInMonth ?>>Tanggal</td>
                        <td class="status header-radius-right" colspan="3">Total Absensi</td>
                    </tr>
                    <tr class="table-header">
                        <?php
                            for ($i = 1; $i <= $daysInMonth; $i++) {
                                echo "<td class='tanggal_'>$i</td>";
                            }
                        ?>
                        <td class="status-hadir">Hadir</td>
                        <td class="status-hadir">Izin</td>
                        <td class="status-hadir">Alfa</td>
                    </tr>
                </thead>
                    <?php
                        $students = mysqli_query($conn, 
                            "SELECT DISTINCT warga.nim, nama, prodi FROM warga
                                    JOIN absensi ON warga.nim = absensi.nim
                                    WHERE jenis_absen = 'harian'");

                        $rowNumber = 1;

                        while ($student = mysqli_fetch_assoc($students)) {
                            $nim = $student['nim'];

                            $rowClass = ($rowNumber % 2 == 0) ? 'even-row' : '';

                            $attendance = mysqli_query($conn, 
                            "SELECT DAY(waktu_absen) AS day, status_kehadiran FROM absensi 
                                    WHERE nim = '$nim' 
                                    AND jenis_absen = 'harian' 
                                    AND MONTH(waktu_absen) = $selectedMonth"
                            );
                            
                            $attendanceData = array_fill(1, $daysInMonth, '-');
                            $totalHadir = 0;
                            $totalIzin = 0;
                            $totalAlfa = 0;

                            while ($attend = mysqli_fetch_assoc($attendance)) {
                                $day = (int)$attend['day'];
                                $status = strtolower($attend['status_kehadiran']);

                                if ($status == 'hadir') {
                                    $attendanceData[$day] = 'H';
                                    $totalHadir++;
                                } elseif ($status == 'izin') {
                                    $attendanceData[$day] = 'I';
                                    $totalIzin++;
                                } elseif ($status == 'alfa') {
                                    $attendanceData[$day] = 'A';
                                    $totalAlfa++;
                                }
                            }

                            echo "<tr class='row-height $rowClass'>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $student['nim'] . "</td>";
                            echo "<td>" . $student['nama'] . "</td>";
                            echo "<td>" . $student['prodi'] . "</td>";

                            for ($i = 1; $i <= $daysInMonth; $i++) {
                                echo "<td>" . $attendanceData[$i] . "</td>";
                            }

                            echo "<td>" . $totalHadir . "</td>";
                            echo "<td>" . $totalIzin . "</td>";
                            echo "<td>" . $totalAlfa . "</td>";

                            echo "</tr>";

                            $rowNumber++;
                        }
                    ?>
            </table>
        </div>
    </div>
</div>



<?php 
    require_once '../templates/footer.php';
?>