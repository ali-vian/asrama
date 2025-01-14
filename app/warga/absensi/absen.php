<?php 
//     $pageTitle = "Rekap Absensi Harian";
//     session_start(); // Aktifkan sesi

//     // Validasi sesi login dan role warga
//     if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'warga') {
//         header('Location: ../../../login.php'); // Redirect ke halaman login jika tidak valid
//         exit();
//     }



// // Ambil NIM pengguna dari sesi login
//     $nim = $_SESSION['nim']; // Ambil NIM dari sesi yang dibuat saat login
    require_once 'templates.php';
    $nim = '250411100055';
    $sql = "SELECT nama FROM warga WHERE nim = '$nim'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Ambil nama
        $row = $result->fetch_assoc();
        $nama = $row['nama'];
    } else {
        $nama = 'Pengguna Tidak Ditemukan'; // Default jika tidak ada data
    }
    $selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

    // Query database untuk data absensi
    $stmt = $conn->prepare("
    SELECT 
        a.status_kehadiran, 
        a.waktu_absen, 
        a.jenis_absen, 
        a.keterangan
    FROM 
        absensi a
    WHERE 
        a.nim = ? AND DATE(a.waktu_absen) = ?
    ");

    if (!$stmt) {
        die("Kesalahan prepare statement: " . $conn->error);
    }
    $stmt->bind_param("ss", $nim, $selectedDate);
    $stmt->execute();
    $result = $stmt->get_result();
?>

<div class="content">
    <div class="content-top">
        <span class="h1">Rekap Absensi Harian <?php echo $nama; ?></span>
        
        <div class="select">
            <div class="select-button">
                <button class="select-btn text-button" onclick="dropdownAbsensi()">Absensi Harian</button>
                <button class="select-btn v-button" onclick="dropdownAbsensi()">v</button>
            </div>
            <div class="select-content" id="absensiContent" style="display: none;">
                <div class="select-option border-bottom" data-value="absen.php" onclick="selectAbsensi(this)">Absensi Harian</div>
                <div class="select-option border-bottom" data-value="ekstrakulikuler.php" onclick="selectAbsensi(this)">Absensi Ekstrakurikuler</div>
                <div class="select-option" data-value="harbes.php" onclick="selectAbsensi(this)">Absensi Hari Besar</div> 
                <div class="select-option" data-value="../dashboard.php" onclick="selectAbsensi(this)">Dashboard</div> 
            </div>
        </div>
    </div>

    <div class="content-bottom">
        <div class="periode">
            <span class="h3">Tanggal</span>
            <input type="date" id="filterDate" value="<?php echo $selectedDate; ?>" onchange="filterByDate(this.value)">
        </div>

        <div class="rekap">
            <button class="cetak" onclick="exportHarian()">
                <img src="../../../assets/img/cetak.png" alt="cetak">
                Cetak
            </button>

            <table id="tableExcel">
                <thead>
                    <tr class="table-header">
                        <td class="no">No</td>
                        <td class="status">Status Kehadiran</td>
                        <td class="waktu">Waktu Absen</td>
                        <td class="jenis">Jenis Absen</td>
                        <td class="keterangan">Keterangan</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $rowNumber = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='row-height'>";
                            echo "<td>" . $rowNumber++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['status_kehadiran']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['waktu_absen']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['jenis_absen']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['keterangan']) . "</td>";
                            echo "</tr>";
                        }
                        if ($result->num_rows === 0) {
                            echo "<tr><td colspan='5'>Tidak ada data untuk tanggal yang dipilih.</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk memfilter berdasarkan tanggal
    function filterByDate(selectedDate) {
        window.location.href = "?date=" + selectedDate;
    }

    // Fungsi untuk dropdown navigasi
    function dropdownAbsensi() {
        const dropdown = document.getElementById('absensiContent');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    // Fungsi untuk navigasi halaman berdasarkan pilihan
    function selectAbsensi(element) {
        const page = element.getAttribute('data-value');
        window.location.href = page;
    }

    // Close dropdown if clicked outside
    window.onclick = function(event) {
        const dropdown = document.getElementById("absensiContent");
        if (!event.target.matches('.select-btn') && !event.target.matches('.select-content') && !event.target.matches('.select-option')) {
            dropdown.style.display = "none";
        }
    }
</script>
