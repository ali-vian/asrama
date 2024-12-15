<?php
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
$sqlGenderCount = "SELECT jenis_kelamin, COUNT(*) as count FROM warga w join pendaftaran p on w.nim=p.nim GROUP BY jenis_kelamin";
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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Jangan lupa mengacu ke file Composer autoload

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['nim'])) {
    $nim = $conn->real_escape_string($_POST['nim']);
    $action = $_POST['action'];

    // Fungsi untuk mengirim email
    function kirimEmail($email, $nama, $subject, $body) {
        $mail = new PHPMailer(true);
        try {
            // Konfigurasi SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'mahrusk123@gmail.com'; // Email Anda
            $mail->Password = 'xpny dven cleh inzg'; // Password aplikasi Gmail Anda
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Gunakan TLS
            $mail->Port = 587;

            // Pengaturan dari dan tujuan email
            $mail->setFrom('mahrusk123@gmail.com', 'ASRAMA UTM');
            $mail->addAddress($email, $nama);

            // Konten email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            // Anda bisa mencatat kesalahan ke log server atau email admin
            error_log("Error saat mengirim email: {$mail->ErrorInfo}");
            return false;
        }
        $mail->SMTPDebug = 2;  // Set SMTPDebug ke 2 untuk mendapatkan output debugging

    }

    if ($action === 'accept' && isset($_POST['kamar'], $_POST['gedung'])) {
        $kamar = $_POST['kamar'];
        $gedung = $_POST['gedung'];

        // Prepare dan eksekusi query untuk menerima pendaftaran
        $sqlAccept = $conn->prepare("UPDATE pendaftaran SET status = 'accepted' WHERE nim = ?");
        $sqlAccept->bind_param("s", $nim);

        if ($sqlAccept->execute()) {
            // Prepare dan eksekusi query untuk memasukkan data ke tabel warga
            $sqlInsertWarga = $conn->prepare("INSERT INTO warga (nama, nim, prodi, ttl, jenis_kelamin, no_hp, foto_warga, email, kamar, gedung, id) 
                                              SELECT nama_lengkap, nim, prodi_pendaftar, ttl, jenis_kelamin, no_hp_pendaftar, foto_pendaftar, email_pendaftar, ?, ?, id 
                                              FROM pendaftaran WHERE nim = ?");
            $sqlInsertWarga->bind_param("sss", $kamar, $gedung, $nim);

            if ($sqlInsertWarga->execute()) {
                // Ambil data pendaftar untuk email
                $sqlEmail = $conn->prepare("SELECT  nim, nama_lengkap, email_pendaftar FROM pendaftaran WHERE nim = ?");
                $sqlEmail->bind_param("s", $nim);
                $sqlEmail->execute();
                $result = $sqlEmail->get_result();
                $row = $result->fetch_assoc();

                $nim = $row['nim'];
                $nama = $row['nama_lengkap'];
                $email = $row['email_pendaftar'];
                $subject = "Pendaftaran Diterima";
                $body = "
                <div style='background: linear-gradient(to right, #0A3B61, #0971B8); padding-top: 20px; padding-bottom: 20px; padding-left: 10px; padding-right: 10px; '>
                    <strong style='color: white; font-size: 20px;'>SELAMAT !! ANDA DINYATAKAN DITERIMA DI ASRAMA UTM 2025</strong>
                </div><br>
                Halo, selamat anda dinyatakan diterima di asrama universitas trunojoyo madura atas nama :
                <table style='border: 0; width: 100%;'>
                    <tr>
                        <th style='padding: 8px; text-align: left;'>Nama</th>
                        <td style='padding: 8px;'>$nama</td>
                    </tr>
                    <tr>
                        <th style='padding: 8px; text-align: left;'>NIM</th>
                        <td style='padding: 8px;'>$nim</td>
                    </tr>
                    <tr>
                        <th style='padding: 8px; text-align: left;'>Email</th>
                        <td style='padding: 8px;'>$email</td>
                    </tr>
                    <tr>
                        <th style='padding: 8px; text-align: left;'>Gedung</th>
                        <td style='padding: 8px;'>$gedung</td>
                    </tr>
                    <tr>
                        <th style='padding: 8px; text-align: left;'>Kamar</th>
                        <td style='padding: 8px;'>$kamar</td>
                    </tr>
                </table><br><br>

                Salam hormat saya ucapkan terima kasih,
                <br>Admin.";



                if (kirimEmail($email, $nama, $subject, $body)) {
                    echo "<script>alert('Data pendaftar berhasil diterima dan email notifikasi telah dikirim.'); window.location.href = 'index.php';</script>";
                } else {
                    echo "<script>alert('Data pendaftar diterima, tetapi email gagal dikirim.'); window.location.href = 'index.php';</script>";
                }
            } else {
                echo "<script>alert('Gagal memasukkan data ke tabel warga.'); window.location.href = 'index.php';</script>";
            }
        } else {
            echo "<script>alert('Gagal memperbarui status pendaftaran.'); window.location.href = 'index.php';</script>";
        }
    } elseif ($action === 'reject') {
        // Prepare dan eksekusi query untuk menolak pendaftaran
        $sqlReject = $conn->prepare("UPDATE pendaftaran SET status = 'rejected' WHERE nim = ?");
        $sqlReject->bind_param("s", $nim);

        if ($sqlReject->execute()) {
            // Ambil data pendaftar untuk email
            $sqlEmail = $conn->prepare("SELECT nama_lengkap, email_pendaftar FROM pendaftaran WHERE nim = ?");
            $sqlEmail->bind_param("s", $nim);
            $sqlEmail->execute();
            $result = $sqlEmail->get_result();
            $row = $result->fetch_assoc();

            $nama = $row['nama_lengkap'];
            $email = $row['email_pendaftar'];
            $subject = "Pendaftaran Ditolak";
            $body = "
                <div style='background: linear-gradient(to right, #B90D0C, #E32F32); padding-top: 20px; padding-bottom: 20px; padding-left: 10px; padding-right: 10px; '>
                    <strong style='color: white; font-size: 20px;'>MAAF !! ANDA DINYATAKAN DITOLAK DI ASRAMA UTM 2025</strong>
                </div><br>
                Halo, maaf anda dinyatakan ditolak di asrama universitas trunojoyo madura atas nama :
                <table style='border: 0; width: 100%;'>
                    <tr>
                        <th style='padding: 8px; text-align: left;'>Nama</th>
                        <td style='padding: 8px;'>$nama</td>
                    </tr>
                    <tr>
                        <th style='padding: 8px; text-align: left;'>NIM</th>
                        <td style='padding: 8px;'>$nim</td>
                    </tr>
                    <tr>
                        <th style='padding: 8px; text-align: left;'>Email</th>
                        <td style='padding: 8px;'>$email</td>
                    </tr>
                </table><br><br>

                Salam hormat saya ucapkan terima kasih,
                <br>Admin.";

            if (kirimEmail($email, $nama, $subject, $body)) {
                echo "<script>alert('Data pendaftar berhasil ditolak dan email notifikasi telah dikirim.'); window.location.href = 'index.php';</script>";
            } else {
                echo "<script>alert('Data pendaftar ditolak, tetapi email gagal dikirim.'); window.location.href = 'index.php';</script>";
            }
        } else {
            echo "<script>alert('Gagal memperbarui status penolakan.'); window.location.href = 'index.php';</script>";
        }
    }
}


// Fetch status count for registration status
$sqlStatusCount = "SELECT status, COUNT(*) as count FROM pendaftaran GROUP BY status";
$resultStatusCount = $conn->query($sqlStatusCount);

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Asrama Dashboard</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="text-center">
      <img src="asset/asrama_utm.png" alt="Logo" style="width: 100px;">
      <h5>ASRAMA</h5>
    </div>
    <a href="#">Dashboard</a>
    <a href="#">Aspirasi</a>
    <a href="#" class="active">Pendaftaran Warga</a>
    <a href="#">Event</a>
    <a href="#">Jajak Pendapat</a>
  </div>

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
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="acceptForm" method="post"> 
          <div class="modal-body">
            <input type="hidden" id="acceptNim" name="nim">
            <div class="form-group">
              <label for="kamar">Kamar:</label>
              <input type="text" class="form-control" id="kamar" name="kamar" required>
            </div>
            <div class="form-group">
              <label for="gedung">Gedung:</label>
              <input type="text" class="form-control" id="gedung" name="gedung" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="action" value="accept" class="btn btn-primary">Save changes</button>
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
