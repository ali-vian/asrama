<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "asrama";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil status dari request POST
$status = isset($_POST['status']) ? $_POST['status'] : 'pending';

// Tentukan query berdasarkan status
$sql = "";
if ($status == 'pending') {
    $sql = "SELECT nim, nama_lengkap, prodi_pendaftar, ttl FROM pendaftaran WHERE status = 'pending'";
} elseif ($status == 'accepted') {
    $sql = "SELECT nim, nama_lengkap, prodi_pendaftar, ttl, 'Accepted' AS status FROM pendaftaran WHERE status = 'accepted'";
} elseif ($status == 'rejected') {
    $sql = "SELECT nim, nama_lengkap, prodi_pendaftar, ttl, 'Rejected' AS status FROM pendaftaran WHERE status = 'rejected'";
}

// Eksekusi query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='table'>";
    echo "<thead><tr><th>Nama</th><th>NIM</th><th>Jurusan</th><th>TTL</th>";

    if ($status == 'pending') {
        echo "<th>Cek Detail Data</th><th>Tindakan</th>";
    } else {
        echo "<th>Status</th>";
        if ($status == 'rejected') {
            echo "<th>Aksi</th>";
        }
    }

    echo "</tr></thead><tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['nama_lengkap'] . "</td>";
        echo "<td>" . $row['nim'] . "</td>";
        echo "<td>" . $row['prodi_pendaftar'] . "</td>";
        echo "<td>" . $row['ttl'] . "</td>";

        if ($status == 'pending') {
            echo "<td><button class='btn btn-info btn-sm' onclick='showDetail(\"" . $row['nim'] . "\")'>Detail</button></td>";
            echo "<td>
                    <button type='button' onclick='showAcceptModal(\"" . $row['nim'] . "\")' class='btn btn-success btn-sm'>Accept</button>
                    <form method='post' style='display:inline;'>
                      <input type='hidden' name='nim' value='" . $row['nim'] . "'>
                      <button type='submit' name='action' value='reject' class='btn btn-danger btn-sm'>Reject</button>
                    </form>
                  </td>";
        } else {
            echo "<td>" . $row['status'] . "</td>";
            if ($status == 'rejected') {
                echo "<td><button class='btn btn-danger btn-sm' onclick='confirmDelete(\"" . $row['nama_lengkap'] . "\", \"" . $row['nim'] . "\")'>Hapus</button></td>";
            }
        }
        echo "</tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<p class='text-center'>No data found.</p>";
}

$conn->close();
?>

<!-- Modal for showing details -->
<div id="detailModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Pendaftar</h5>
        <button type="button" class="close" onclick="closeModal()">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalBody">
        <!-- Detail data will be loaded here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
// Function to load detail data
function showDetail(nim) {
    fetch('get_detail.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'nim=' + nim
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('modalBody').innerHTML = data;
        document.getElementById('detailModal').style.display = 'block';
    })
    .catch(error => console.error('Error:', error));
}

// Function to close modal
function closeModal() {
    document.getElementById('detailModal').style.display = 'none';
}

// Function to confirm delete
function confirmDelete(nama, nim) {
    if (confirm(`Apakah Anda ingin menghapus data pendaftar dengan nama ${nama}?`)) {
        window.location.href = `hapus_pendaftar.php?nim=${nim}`;
    }
}
</script>

<style>
/* Basic modal styling */
.modal {
    display: none;
    position: fixed;
    z-index: 1050;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    background-color: rgba(0,0,0,0.5);
}
.modal-dialog {
    margin: 1.75rem auto;
    max-width: 500px;
}
</style>
