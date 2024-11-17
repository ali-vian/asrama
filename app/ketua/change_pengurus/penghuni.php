<?php
include('koneksi.php');

// Tentukan jumlah data per halaman
$limit = 5;

// Ambil parameter halaman dari URL, jika tidak ada, set ke 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Hitung total data
$total_sql = "SELECT COUNT(*) as total FROM warga;";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_data = $total_row['total'];

// Ambil data warga dengan LIMIT dan OFFSET
$sql = "SELECT * FROM warga LIMIT $limit OFFSET $offset;";
$result = $conn->query($sql);

if (isset($_POST['nim'])) {
    $nim = $_POST['nim'];
    $sql = "DELETE FROM warga WHERE nim = '$nim';";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil dihapus'); window.location.href = 'penghuni.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data'); window.location.href = 'penghuni.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Penghuni</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="d-flex">
        <div class="sidebar p-3">
            <div class="text-center mb-4">
                <img alt="Logo Asrama Mahasiswa Universitas Trunojoyo Madura" src="assets/hiljip 1.png" width="150"/>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link" href="#"> <img src="assets/home.png" alt="icon home" class="d-inline-block"> Dashboard</a>
                <a class="nav-link active" href="#"> <img src="assets/user.png" alt=""> Warga Asrama</a>
                <a class="nav-link" href="#"> <img src="assets/Shape.png" alt=""> Ekstrakulikuler </a>
            </nav>
        </div>
        <div class="content flex-grow-1">
            <div class="header">
                <h1>Manajemen Penghuni</h1>
                <div class="user-info">
                    <img alt="User Profile Picture" height="40" src="assets/orang.png" width="40"/>
                    <span class="user-name">Annisa F</span>
                </div>
            </div>
            <div class="container mt-4">
                <h2>Penghuni Asrama Mahasiswa Universitas Trunojoyo Madura</h2>
                <hr>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-danger mb-3">Delete All</button>
                </div>
            </div>
            <div class="table-container">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAMA</th>
                            <th>PROGRAM STUDI</th>
                            <th>OPSI</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['nim']}</td>
                                    <td>{$row['nama']}</td>
                                    <td>{$row['prodi']}</td>
                                    <td>
                                        <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modalPengurus' 
                                            data-nim='{$row['nim']}' data-nama='{$row['nama']}' data-prodi='{$row['prodi']}' data-no_hp='{$row['no_hp']}' data-email='{$row['email']}' data-password='{$row['password']}' data-foto_warga='{$row['foto_warga']}' data-gedung='{$row['gedung']}'>Jadikan Pengurus</button>
                                        
                                        <form action='' method='POST' style='display:inline;'>
                                            <input type='hidden' name='nim' value='{$row['nim']}'>
                                            <button type='submit' class='btn btn-danger' onclick='return confirm(\"Anda yakin ingin menghapus data ini?\");'>Hapus</button>
                                        </form>    
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Tidak ada data warga.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-3">
                <ul class="pagination justify-content -center">
                    <?php
                    $total_pages = ceil($total_data / $limit);
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $class = ($page == $i) ? 'active' : '';
                        echo "<li class='page-item $class'><a class='page-link' href='?page=$i'>$i</a></li>";
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Modal Bootstrap untuk Memilih Divisi dan Jabatan -->
    <div class="modal fade" id="modalPengurus" tabindex="-1" aria-labelledby="modalPengurusLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPengurusLabel">Jadikan Pengurus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="update_status.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="nim" id="modalNim">
                        <input type="hidden" name="nama" id="modalNama">
                        <input type="hidden" name="prodi" id="modalProdi">
                        
                        <div class="mb-3">
                            <label for="divisi" class="form-label">Divisi Pengurus</label>
                            <select name="divisi" id="divisi" class="form-select" required>
                                <option value="Kebersihan">Kebersihan dan Kesehatan</option>
                                <option value="Teknisi">Teknisi</option>
                                <option value="Keamanan">Keamanan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan Pengurus</label>
                            <select name="jabatan" id="jabatan" class="form-select" required>
                                <option value="Koordinator">Koordinator</option>
                                <option value="Bendahara">Bendahara</option>
                                <option value="Sekretaris">Sekretaris</option>
                                <option value="Anggota">Anggota</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="kamar" class="form-label">Kamar Pengurus</label>
                            <input type="text" class="form-control" name="kamar" id="kamar" placeholder="Masukkan kamar baru pengurus" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label><br>
                            <div>
                                <input type="radio" id="laki-laki" name="jenis_kelamin" value="Laki-laki" required>
                                <label for="laki-laki">Laki-laki</label>
                            </div>
                            <div>
                                <input type="radio" id="perempuan" name="jenis_kelamin" value="Perempuan" required>
                                <label for="perempuan">Perempuan</label>
                            </div>
                            <input type="hidden" name="no_hp" id="modalNoHp">
                            <input type="hidden" name="email" id="modalEmail">
                            <input type="hidden" name="password" id="modalPassword">
                            <input type="hidden" name="foto_warga" id="modalFotoWarga">
                            <input type="hidden" name="gedung" id="modalGedung">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Script untuk meneruskan data dari tombol ke modal
        var modalPengurus = document.getElementById('modalPengurus');
        modalPengurus.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var nim = button.getAttribute('data-nim');
            var nama = button.getAttribute('data-nama');
            var prodi = button.getAttribute('data-prodi');
            var no_hp = button.getAttribute('data-no_hp');
            var email = button.getAttribute('data-email');
            var password = button.getAttribute('data-password');
            var foto_warga = button.getAttribute('data-foto_warga');
            var gedung = button.getAttribute('data-gedung');
            
            document.getElementById('modalNim').value = nim;
            document.getElementById('modalNama').value = nama;
            document.getElementById('modalProdi').value = prodi;
            document.getElementById('modalNoHp').value = no_hp;
            document.getElementById('modalEmail').value = email;
            document.getElementById('modalPassword').value = password;
            document.getElementById('modalFotoWarga').value = foto_warga;
            document.getElementById('modalGedung').value = gedung;
        });
    </script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
