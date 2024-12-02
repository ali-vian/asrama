<?php
// Konfigurasi status pendaftaran
include 'config.php'; // Ubah ke false untuk menutup pendaftaran
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>
    <script>
        function validateForm(event) {
            // Mengambil nilai input
            var nim = document.getElementById("nim").value;
            var no_hp_pendaftar = document.getElementById("no_hp_pendaftar").value;
            var no_hp_ortu = document.getElementById("no_hp_ortu").value;
            var email_pendaftar = document.getElementById("email_pendaftar").value;
            var foto_pendaftar = document.getElementById("foto_pendaftar").files[0];
            var foto_bukti_lolos_ptn = document.getElementById("foto_bukti_lolos_ptn").files[0];

            // Validasi NIM (12 karakter angka)
            if (!/^\d{12}$/.test(nim)) {
                alert("NIM harus terdiri dari 12 digit angka.");
                event.preventDefault();
                return false;
            }

            // Validasi Nomor HP Pendaftar (12 digit angka)
            if (!/^\d{12}$/.test(no_hp_pendaftar)) {
                alert("Nomor HP Pendaftar harus terdiri dari 12 digit angka.");
                event.preventDefault();
                return false;
            }

            // Validasi Nomor HP Orang Tua (12 digit angka)
            if (!/^\d{12}$/.test(no_hp_ortu)) {
                alert("Nomor HP Orang Tua harus terdiri dari 12 digit angka.");
                event.preventDefault();
                return false;
            }

            // Validasi Email
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!emailPattern.test(email_pendaftar)) {
                alert("Format email tidak valid.");
                event.preventDefault();
                return false;
            }

            // Validasi Foto Pendaftar
            if (foto_pendaftar && !/\.(jpg|jpeg|png)$/i.test(foto_pendaftar.name)) {
                alert("Foto Pendaftar harus berformat JPG atau PNG.");
                event.preventDefault();
                return false;
            }

            // Validasi Foto Bukti Lolos PTN
            if (foto_bukti_lolos_ptn && !/\.(jpg|jpeg|png)$/i.test(foto_bukti_lolos_ptn.name)) {
                alert("Foto Bukti Lolos PTN harus berformat JPG atau PNG.");
                event.preventDefault();
                return false;
            }

            return true;
        }
        function closeModal() {
            document.getElementById("modal-background").style.display = "none";
        }
    </script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="containerr">
        <div class="box">
            <h1>Form Pendaftaran</h1>

            <?php if ($registration_open): ?>
                <form action="proses_pendaftaran.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm(event)">
                    <div>
                        <label for="nim">NIM:</label>
                        <input type="text" id="nim" name="nim" maxlength="12" required>
                    </div>
                    <div>
                        <label for="nama_lengkap">Nama Lengkap:</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" maxlength="255" required>
                    </div>
                    <div>
                        <label for="prodi_pendaftar">Program Studi:</label>
                        <input type="text" id="prodi_pendaftar" name="prodi_pendaftar" maxlength="255" required>
                    </div>
                    <div>
                        <label for="foto_pendaftar">Foto Pendaftar:</label>
                        <input type="file" id="foto_pendaftar" name="foto_pendaftar" accept="image/*" required>
                    </div>
                    <div>
                        <label for="alamat_pendaftar">Alamat:</label>
                        <input type="text" id="alamat_pendaftar" name="alamat_pendaftar" maxlength="255" required>
                    </div>
                    <div>
                        <label for="ttl">Tempat, Tanggal Lahir:</label>
                        <input type="text" id="ttl" name="ttl" maxlength="255" required>
                    </div>
                    <div>
                        <label for="no_hp_pendaftar">Nomor HP:</label>
                        <input type="text" id="no_hp_pendaftar" name="no_hp_pendaftar" maxlength="12" required>
                    </div>
                    <div>
                        <label for="email_pendaftar">Email:</label>
                        <input type="email" id="email_pendaftar" name="email_pendaftar" maxlength="255" required>
                    </div>
                    <div>
                        <label for="nomor_pendaftaran">Nomor Pendaftaran:</label>
                        <input type="text" id="nomor_pendaftaran" name="nomor_pendaftaran" maxlength="12" required>
                    </div>
                    <div>
                        <label for="jenis_kelamin">Jenis Kelamin:</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label for="jalur_masuk">Jalur Masuk:</label>
                        <input type="text" id="jalur_masuk" name="jalur_masuk" maxlength="255" required>
                    </div>
                    <div>
                        <label for="foto_bukti_lolos_ptn">Foto Bukti Lolos PTN:</label>
                        <input type="file" id="foto_bukti_lolos_ptn" name="foto_bukti_lolos_ptn" accept="image/*" required>
                    </div>
                    <div>
                        <label for="nama_ayah">Nama Ayah:</label>
                        <input type="text" id="nama_ayah" name="nama_ayah" maxlength="255" required>
                    </div>
                    <div>
                        <label for="nama_ibu">Nama Ibu:</label>
                        <input type="text" id="nama_ibu" name="nama_ibu" maxlength="255" required>
                    </div>
                    <div>
                        <label for="no_hp_ortu">Nomor HP Orang Tua:</label>
                        <input type="text" id="no_hp_ortu" name="no_hp_ortu" maxlength="12" required>
                    </div>
                    <button type="submit">Daftar</button>
                </form>
            <?php else: ?>
                <!-- Pesan jika pendaftaran ditutup -->
                <div class="modal-background" id="modal-background" style="display: block;">
                    <div class="modal-container">
                        <span class="modal-close" onclick="closeModal()">&times;</span>
                        <h2 class="tutup">Pendaftaran Ditutup</h2>
                        <p class="tulis">Mohon maaf, pendaftaran saat ini tidak tersedia.</p>
                        <button class="btn-close" onclick="closeModal()">Tutup</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
