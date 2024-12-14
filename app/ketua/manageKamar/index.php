<?php
include 'db_connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

include "../templates/new_header.php"
?>
<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbord Manajemen Pengurus Asrama</title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="d-flex">
        <aside class="sidebar bg-light border-right">
            <div class="text-center p-3">
                <img src="../asset/asrama_utm.png" alt="Logo Asrama" class="img-fluid mb-2" style="width: 80px;">
                <h5>ASRAMA</h5>
                <p class="text-muted">Universitas Trunojoyo Madura</p>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Aspirasi</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Pendaftaran Warga</a></li>
                <li class="nav-item"><a class="active" href="#">Pengurus Asrama</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Event</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Jajak Pendapat</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Aspirasi</a></li>
            </ul>
        </aside> -->

        <main class="flex-grow-1 p-4">
            <div class="container">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Manajemen Pengurus Asrama & Penetapan Musahhil kamar warga</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Jurusan</th>
                                    <th>Divisi</th>
                                    <th>Gedung</th>
                                    <th>Kamar Warga</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include 'fetch_pengurus.php'; ?>
                            </tbody>
                        </table>
                        <div class="pagination">
                            <?php if ($page > 1): ?>
                                <a href="?page=<?= $page - 1 ?>" class="btn btn-secondary btn-sm">Previous</a>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <a href="?page=<?= $i ?>" class="btn btn-<?= $i === $page ? 'primary' : 'light' ?> btn-sm"><?= $i ?></a>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <a href="?page=<?= $page + 1 ?>" class="btn btn-secondary btn-sm">Next</a>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </div>
    


    <!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="post" action="update_pengurus.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Pengurus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="nim_pengurus" id="editNimPengurus">
                    <div class="form-group">
                        <label for="editNamaPengurus">Nama</label>
                        <input type="text" class="form-control" id="editNamaPengurus" name="nama_pengurus" required>
                    </div>
                    <div class="form-group">
                        <label for="editProdiPengurus">Jurusan</label>
                        <input type="text" class="form-control" id="editProdiPengurus" name="prodi_pengurus" required>
                    </div>
                    <div class="form-group">
                        <label for="editDivisiPengurus">Divisi</label>
                        <input type="text" class="form-control" id="editDivisiPengurus" name="divisi_pengurus" required>
                    </div>
                    <div class="form-group">
                        <label for="editGedungPengurus">Gedung</label>
                        <input type="text" class="form-control" id="editGedungPengurus" name="gedung_pengurus" required>
                    </div>
                    <div class="form-group">
                        <label for="editKamarPengurus">Kamar</label>
                        <input type="text" class="form-control" id="editKamarPengurus" name="kamar_pengurus" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal(nama, nim, prodi, divisi, gedung, kamar) {
        document.getElementById('editNimPengurus').value = nim;
        document.getElementById('editNamaPengurus').value = nama;
        document.getElementById('editProdiPengurus').value = prodi;
        document.getElementById('editDivisiPengurus').value = divisi;
        document.getElementById('editGedungPengurus').value = gedung;
        document.getElementById('editKamarPengurus').value = kamar;

        $('#editModal').modal('show');
    }
</script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
