<?php
session_start();
if (!isset($_SESSION['nim']) && !$_SESSION['role'] == 'ketua') {
    header("Location: ../../../index.php");
    exit;
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "asrama";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data for visualization
$sqlGenderCount = "SELECT jenis_kelamin, COUNT(*) as count FROM warga JOIN pendaftaran ON warga.nim=pendaftaran.nim GROUP BY jenis_kelamin";
$resultGenderCount = $conn->query($sqlGenderCount);

$femaleCount = 0;
$maleCount = 0;

while ($row = $resultGenderCount->fetch_assoc()) {
    switch (strtolower($row['jenis_kelamin'])) {
        case 'perempuan':
            $femaleCount = $row['count'];
            break;
        case 'laki-laki':
            $maleCount = $row['count'];
            break;
    }
}

// Proses validasi pendaftaran (accept atau reject)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['nim'])) {
  $nim = $conn->real_escape_string($_POST['nim']);
  $action = $_POST['action'];

  if ($action === 'accept' && isset($_POST['kamar'], $_POST['gedung'],$_POST['pengurus'])) {
      $kamar = $_POST['kamar'];
      $gedung = $_POST['gedung'];
      $pengurus = $_POST['pengurus'];

      
      
      if ($sqlAccept->execute()) {
          // Insert into warga table
          $sqlInsertWarga = $conn->prepare("INSERT INTO warga (nama,nim,no_hp, password,kamar,email,gedung,prodi,foto_warga,nim_pengurus) 
                                            SELECT nama_lengkap, nim,no_hp_pendaftar,password,?, email_pendaftar, ?, prodi_pendaftar,foto_pendaftar,?
                                            FROM pendaftaran WHERE nim = ?");
          $sqlInsertWarga->bind_param("ssss", $kamar, $gedung,$pengurus, $nim);
          
          if ($sqlInsertWarga->execute()) {
              // Prepare and execute accept query
              $sqlAccept = $conn->prepare("UPDATE pendaftaran SET status = 'accepted' WHERE nim = ?");
              $sqlAccept->bind_param("s", $nim);
              echo "<script>alert('Data pendaftar berhasil diterima.'); window.location.href = 'index.php';</script>";
          } else {
              echo "<script>alert('Gagal memasukkan data ke tabel warga.'); window.location.href = 'index.php';</script>";
          }
      } else {
          echo "<script>alert('Gagal memperbarui status pendaftaran.'); window.location.href = 'index.php';</script>";
      }

  } elseif ($action === 'reject') {
      // Prepare and execute reject query
      $sqlReject = $conn->prepare("UPDATE pendaftaran SET status = 'rejected' WHERE nim = ?");
      $sqlReject->bind_param("s", $nim);

      if ($sqlReject->execute()) {
          echo "<script>alert('Data pendaftar berhasil ditolak.'); window.location.href = 'index.php';</script>";
      } else {
          echo "<script>alert('Gagal memperbarui status penolakan.'); window.location.href = 'index.php';</script>";
      }
  }
}
// Fetch status count for registration status
$sqlStatusCount = "SELECT status, COUNT(*) as count FROM pendaftaran GROUP BY status";
$resultStatusCount = $conn->query($sqlStatusCount);

$pengurus = "SELECT nama_pengurus,nim_pengurus FROM pengurus";
$resultPengurus = $conn->query($pengurus);

$pendingCount = 0;
$acceptedCount = 0;
$rejectedCount = 0;

while ($row = $resultStatusCount->fetch_assoc()) {
    switch (strtolower($row['status'])) {
        case 'pending':
            $pendingCount = $row['count'];
            break;
        case 'accepted':
            $acceptedCount = $row['count'];
            break;
        case 'rejected':
            $rejectedCount = $row['count'];
            break;
    }
}

// Calculate total students
$totalStudents = $femaleCount + $maleCount;

// Fetch data from the `pendaftaran` table for the table display
$sql = "SELECT nama_lengkap, nim, prodi_pendaftar, ttl FROM pendaftaran";
$result = $conn->query($sql);

include "../templates/new_header.php"
?>
  <!-- Main Content -->
  <div class="main-content">
    <div class="container-fluid">
      <div class="row mb-4">
        <!-- Dashboard Cards -->
        <div class="col-md-6">
          <div class="card p-4">
            <h5>Dasbord Visualisasi Warga Asrama</h5>
            <div class="row">
              <div class="col-6">
                <div class="text-center">
                  <canvas id="pieChart" width="100" height="100"></canvas>
                </div>
              </div>
              <div class="col-6 mt-10">
                <div class="text-left">
                  <h3><?php echo $totalStudents; ?></h3>
                  <p>Total Mahasiswa</p>
                  <p><span style="color: #ffc107;">●</span> <?php echo $femaleCount; ?> Perempuan</p>
                  <p><span style="color: #007bff;">●</span> <?php echo $maleCount; ?> Laki-laki</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card p-3">
            <h5>Pendaftaran Warga Asrama</h5>
            <div class="text-center">
              <canvas id="donutChart" width="150" height="150"></canvas>
              <div>
                <div class="container">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="status-box">
                        <div>
                          <span class="status-icon semua"></span> belum validasi
                        </div>
                        <h5><?php echo $pendingCount; ?></h5>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="status-box">
                        <div>
                          <span class="status-icon diterima"></span> Diterima
                        </div>
                        <h5><?php echo $acceptedCount; ?></h5>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="status-box">
                        <div>
                          <span class="status-icon ditolak"></span> Ditolak
                        </div>
                        <h5><?php echo $rejectedCount; ?></h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Tabel Pendaftaran Warga Asrama -->
      <div class="card p-3">
        <h5>Pendaftaran Warga Asrama</h5>
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" href="#" onclick="loadData('pending', this)">Pendaftar Baru</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="loadData('accepted', this)">Diterima</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="loadData('rejected', this)">Tidak diterima</a>
          </li>
        </ul>

        <div class="table-responsive mt-3" id="registrationTable">
          <!-- Konten tabel akan dimuat di sini dengan JavaScript -->
        </div>
      </div>
    </div>
  </div>

  <!-- Accept Modal -->
  <div class="modal fade" id="acceptModal" tabindex="-1" role="dialog" aria-labelledby="acceptModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="acceptModalLabel">Lengkapi Data Warga</h5>
        </div>
        <form id="acceptForm" method="post">
          <div class="modal-body">
            <input type="hidden" id="acceptNim" name="nim">
            <div class="form-group">
              <label for="kamar">Kamar:</label>
              <input type="text" class="form-control rounded" id="kamar" name="kamar" required>
            </div>
            <div class="form-group">
              <label for="gedung">Gedung:</label>
              <input type="text" class="form-control rounded" id="gedung" name="gedung" required>
            </div>
            <div class="form-group">
              <label for="pengurus">Musahhil/Pengurus Pendamping:</label>
              <select name="pengurus" class="form-control" id="pengurus">
                <?php while ($row = $resultPengurus->fetch_assoc()) : ?>
                  <option value="<?php echo $row['nim_pengurus']; ?>"><?php echo $row['nama_pengurus']; ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary bg-gray-500 rounded" data-dismiss="modal">Close</button>
            <button type="submit" name="action" value="accept" class="btn btn-primary bg-blue-600 rounded ">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Reject Modal -->
  <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="rejectModalLabel">Reject Pendaftaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="rejectForm" method="post">
          <div class="modal-body">
            <p>Are you sure you want to reject this registration?</p>
            <input type="hidden" id="rejectNim" name="nim">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="script.js"></script>
</body>
</html>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- JS for Chart -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    var femaleCount = <?php echo $femaleCount; ?>;
    var maleCount = <?php echo $maleCount; ?>;
    var pendingCount = <?php echo $pendingCount; ?>;
    var acceptedCount = <?php echo $acceptedCount; ?>;
    var rejectedCount = <?php echo $rejectedCount; ?>;

    var ctx = document.getElementById('donutChart').getContext('2d');
    var ctp = document.getElementById('pieChart').getContext('2d');
    var donutChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Pending', 'Accepted', 'Rejected'],
        datasets: [{
          data: [pendingCount, acceptedCount, rejectedCount],
          backgroundColor: ['#f39c12', '#28a745', '#dc3545']
        }]
      },
      options: {
        cutoutPercentage: 70,
        legend: {
          display: true,
          position: 'bottom'
        }
      }
    });

    // Chart for gender distribution
    var pieChart = new Chart(ctp, {
      type: 'doughnut',
      data: {
        labels: ['Perempuan', 'Laki-laki'],
        datasets: [{
          data: [femaleCount, maleCount],
          backgroundColor: ['#ffc107', '#007bff']
        }]
      },
      options: {
        cutoutPercentage: 70,
        tooltips: { enabled: false },
        plugins: {
          legend: { display: false }
        }
      }
    });

     // JavaScript function to open the accept modal and set the NIM
     function showAcceptModal(nim) {
      document.getElementById('acceptNim').value = nim;
      $('#acceptModal').modal('show');
    }

    document.addEventListener("DOMContentLoaded", function() {
  // Temukan elemen "Pendaftar Baru" secara otomatis dan tetapkan sebagai default
  const defaultTab = document.querySelector('.nav-link[href="#"]:first-child');
  loadData('pending', defaultTab);
});

function loadData(status, element) {
  // Hapus class 'active' dari semua tab
  document.querySelectorAll('.nav-link').forEach(link => {
    link.classList.remove('active');
    link.style.color = ''; // Reset warna teks
  });

  // Tambahkan class 'active' ke tab yang diklik dan ubah warna teksnya menjadi hitam
  element.classList.add('active');
  element.style.color = 'black';

  // AJAX untuk mengambil data berdasarkan status
  $.ajax({
    url: "fetch_data.php",
    type: "POST",
    data: { status: status },
    success: function(data) {
      $('#registrationTable').html(data);
    }
  });
}


  </script>
</body>
</html>
