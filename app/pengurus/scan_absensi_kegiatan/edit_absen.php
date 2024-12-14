<?php
include "connect.php";

$id = isset($_GET['id_kegiatan']) ? $_GET['id_kegiatan'] : '';
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 2;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page - 1) * $limit : 0;

$search = isset($_GET['search']) ? mysqli_real_escape_string($connect, $_GET['search']) : '';

// Validasi jika `$id` kosong
if (empty($id)) {
    die("ID kegiatan tidak ditemukan.");
}

// Query total data
$total_query = "SELECT COUNT(*) as total FROM absensi
                JOIN warga ON absensi.nim = warga.nim
                JOIN kegiatan ON absensi.id_kegiatan = kegiatan.id_kegiatan
                WHERE (warga.nama LIKE '%$search%' 
                   OR kegiatan.nama_kegiatan LIKE '%$search%' 
                   OR absensi.status_kehadiran LIKE '%$search%')
                  AND absensi.id_kegiatan = '$id'";

$total_result = mysqli_query($connect, $total_query);
if (!$total_result) {
    die("Error Query Total: " . mysqli_error($connect));
}

$total_data = mysqli_fetch_assoc($total_result)['total'];
$total_page = ceil($total_data / $limit);

// Query data dengan limit
$query = "SELECT absensi.nim, 
                 warga.nama AS nama_warga, 
                 kegiatan.nama_kegiatan, 
                 absensi.status_kehadiran,
                 absensi.keterangan, 
                 kegiatan.tanggal_kegiatan,
                 absensi.waktu_absen,
                 kegiatan.deskripsi,
                 absensi.id_kegiatan
          FROM absensi
          JOIN warga ON absensi.nim = warga.nim
          JOIN kegiatan ON absensi.id_kegiatan = kegiatan.id_kegiatan
          WHERE (warga.nama LIKE '%$search%' 
             OR kegiatan.nama_kegiatan LIKE '%$search%'
             OR absensi.status_kehadiran LIKE '%$search%')
            AND absensi.id_kegiatan = '$id'
          LIMIT $start, $limit";

$result = mysqli_query($connect, $query);
if (!$result) {
    die("Query Error: " . mysqli_error($connect));
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Class Attendance List</title>
    <link rel="stylesheet" href="asset/css/absen_kegiatan.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
      .breadcrumb {
        display: flex;
        align-items: center;
        font-size: 16px;
        color: #333;
      }
      .breadcrumb a {
        text-decoration: none;
        color: #333;
        display: flex;
        align-items: center;
      }
      .breadcrumb a:hover {
        text-decoration: underline;
      }
      .breadcrumb i {
        margin-right: 5px;
      }
      .breadcrumb span {
        margin: 0 5px;
        color: #888;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="breadcrumb">
          <a href="index.php"><i class="fas fa-home"></i>Absensi Kegiatan</a>
      </div>
      <?php if ($row = mysqli_fetch_assoc($result)): ?>
        <h1>Daftar Absensi Kegiatan <?php echo $row['nama_kegiatan'];?></h1>
        <div class="details">
          <?php 
              // Format tanggal menjadi hari, tanggal bulan tahun
              $tanggalKegiatan = date("l, d F Y", strtotime($row['tanggal_kegiatan']));
              $deskripsiKegiatan = $row['deskripsi'];
          ?>
          <dl>
              <dt>Tanggal Kegiatan:</dt>
              <dd><?php echo $tanggalKegiatan; ?></dd>
              <dt>Deskripsi:</dt>
              <dd><?php echo $deskripsiKegiatan; ?></dd>
          </dl>
      <?php endif; ?>

      <?php mysqli_data_seek($result, 0); // Mengatur ulang pointer ke baris pertama untuk tampilan tabel ?>
      </div>
      <div class="details">
        <div class="search-container" style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
          <button class="qr-button">
            <a href="scaner.php" style="display: flex; align-items: center; justify-content: center;">
              <img src="asset/img/qrcode.jpg" alt="Tambah Absen" />
            </a>
          </button>
          <form action="" method="get" style="display: flex; align-items: center; flex: 1; gap: 10px;">
              <!-- Tambahkan input tersembunyi untuk id_kegiatan -->
              <input type="hidden" name="id_kegiatan" value="<?php echo htmlspecialchars($id); ?>">
              
              <input 
                  type="text" 
                  name="search" 
                  placeholder="Cari absensi kegiatan..." 
                  value="<?php echo htmlspecialchars($search); ?>" 
                  style="padding: 10px; border-radius: 8px; border: 1px solid #ddd; flex: 1;">
                  
              <button type="submit" class="search-button">
                  <img src="asset/img/search.png" alt="">
              </button>
          </form>
        </div>

        <!-- Modal untuk mengubah status dan keterangan -->
        <div id="statusModal" class="modal">
          <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Ubah Status Kehadiran dan Keterangan</h3>
            
            <!-- Pilih Status Kehadiran -->
            <div class="status-option hadir" onclick="setStatus('hadir')">Hadir</div>
            <div class="status-option alpha" onclick="setStatus('alpha')">Alpha</div>
            <div class="status-option izin" onclick="setStatus('izin')">Izin</div>
            
            <!-- Input untuk Keterangan -->
            <label for="keteranganInput">Keterangan:</label>
            <input type="text" id="keteranganInput" value="<?=$row['keterangan']?>" style="width: 100%; padding: 8px; margin-top: 8px; border: 1px solid #ddd; border-radius: 4px;">

            <!-- Tombol Simpan -->
            <button onclick="saveChanges()" style="margin-top: 15px; background-color: #007bff; color: #fff; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px;">
              Simpan
            </button>
          </div>
        </div>

        <table class="attendance-table">
          <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Nama Kegiatan</th>
                <th>Status Kehadiran</th>
                <th>Keterangan</th>
            </tr>
          </thead>
          <tbody id="attendanceTableBody">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php $no = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $row['nim']; ?></td>
                        <td><?php echo $row['nama_warga']; ?></td>
                        <td><?php echo $row['nama_kegiatan']; ?></td>
                        <td>
                          <button onclick="openModal(this, '<?php echo $row['nim']; ?>')" 
                                  class="status-button <?php echo strtolower($row['status_kehadiran']); ?>" 
                                  data-status="<?php echo $row['status_kehadiran']; ?>"
                                  data-id-kegiatan="<?php echo $row['id_kegiatan']; ?>">
                              <?php echo ucfirst($row['status_kehadiran'] ?: 'Alpha'); ?>
                          </button>
                          <span class="status-time">
                              <?php echo date("d-m-Y", strtotime($row['waktu_absen'])); ?>
                          </span>
                          <span class="status-time">
                              <?php echo date("H:i:s", strtotime($row['waktu_absen'])); ?>
                          </span>
                        </td>
                        <td><?php echo $row['keterangan'] ? $row['keterangan'] : 'Belum Terisi'; ?></td>
                    </tr>
                    <?php $no++; ?>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Tidak ada data yang ditemukan.</td>
                </tr>
            <?php endif; ?>
          </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <button onclick="window.location.href='?page=1&id_kegiatan=<?php echo $id; ?>&search=<?php echo urlencode($search); ?>'">&#171;</button>
                <button onclick="window.location.href='?page=<?php echo $page - 1; ?>&id_kegiatan=<?php echo $id; ?>&search=<?php echo urlencode($search); ?>'">&#8249;</button>
            <?php else: ?>
                <button disabled>&#171;</button>
                <button disabled>&#8249;</button>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_page; $i++): ?>
                <?php if ($i == $page): ?>
                    <span class="current-page"><?php echo $i; ?></span>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $total_page): ?>
                <button onclick="window.location.href='?page=<?php echo $page + 1; ?>&id_kegiatan=<?php echo $id; ?>&search=<?php echo urlencode($search); ?>'">&#8250;</button>
                <button onclick="window.location.href='?page=<?php echo $total_page; ?>&id_kegiatan=<?php echo $id; ?>&search=<?php echo urlencode($search); ?>'">&#187;</button>
            <?php else: ?>
                <button disabled>&#8250;</button>
                <button disabled>&#187;</button>
            <?php endif; ?>
        </div>
      </div>
    </div>

    <script>
      // Get modal element
      const modal = document.getElementById("statusModal");
      const closeModal = document.getElementsByClassName("close")[0];
      let currentButton;
      let currentNim;

      // Function to open modal
      function openModal(button, nim) {
        modal.style.display = "block";
        currentButton = button;
        currentNim = nim;

        const status = currentButton.dataset.status || ''; // Ambil status saat ini
        const keteranganInput = document.getElementById("keteranganInput");

        // Atur input keterangan berdasarkan status awal
        if (status === 'izin') {
          keteranganInput.disabled = false; // Aktifkan input jika status adalah izin
        } else {
          keteranganInput.value = ''; // Kosongkan input
          keteranganInput.disabled = true; // Nonaktifkan input
        }

        console.log("NIM:", currentNim);
      }

      // Function to close modal
      closeModal.onclick = function () {
        modal.style.display = "none";

        // Reset input keterangan saat modal ditutup
        const keteranganInput = document.getElementById("keteranganInput");
        keteranganInput.value = ''; // Kosongkan input
        keteranganInput.disabled = true; // Nonaktifkan input

        // Reset status jika diperlukan
        currentButton = null;
        currentNim = null;
      };

      // Close modal when clicking outside
      window.onclick = function (event) {
        if (event.target === modal) {
          modal.style.display = "none";

          // Reset input keterangan saat modal ditutup
          const keteranganInput = document.getElementById("keteranganInput");
          keteranganInput.value = ''; // Kosongkan input
          keteranganInput.disabled = true; // Nonaktifkan input

          // Reset status jika diperlukan
          currentButton = null;
          currentNim = null;
        }
      };

      // Function to capitalize first letter of a string
      function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
      }

      function setStatus(status) {
        currentButton.innerText = capitalizeFirstLetter(status); // Tampilkan status di tombol
        currentButton.dataset.status = status; // Simpan status pada dataset

        const keteranganInput = document.getElementById("keteranganInput");
        
        // Atur input keterangan berdasarkan status
        if (status === 'izin') {
          keteranganInput.disabled = false; // Aktifkan input
        } else {
          keteranganInput.value = ''; // Kosongkan input
          keteranganInput.disabled = true; // Nonaktifkan input
        }
      }

      function saveChanges() {
        const status = currentButton.dataset.status || null;
        const keterangan = document.getElementById("keteranganInput").value.trim();
        const idKegiatan = currentButton.dataset.idKegiatan || null;

        // Validasi input
        if (!status) {
          alert("Pilih status kehadiran terlebih dahulu.");
          return;
        }

        if (status === 'izin' && !keterangan) {
          alert("Keterangan harus diisi untuk status izin.");
          return;
        }

        const dataToSend = {
          nim: currentNim,
          id_kegiatan: idKegiatan,
          status_kehadiran: status,
          keterangan: status === 'izin' ? keterangan : '' // Hanya kirim keterangan jika izin
        };

        // Kirim data menggunakan fetch
        fetch('edit.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(dataToSend)
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            alert(data.message);
            location.reload();
          } else {
            alert(data.message);
          }
        })
        .catch(error => console.error('Error:', error));
      }
    </script>
  </body>
</html>