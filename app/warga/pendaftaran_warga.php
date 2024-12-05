<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>

    <style>
        /* Impor font Montserrat dari Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: #f8f8f8;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            border-right: 1px solid #e0e0e0;
            z-index: 100;
        }

        .sidebar img {
            width: 100%;
            margin-bottom: 20px;
        }

        .side-container {
            display: flex;
            flex-direction: column;
        }

        .side-button {
            display: flex;
            align-items: center;
            padding: 12px;
            margin-bottom: 12px;
            text-decoration: none;
            color: #333;
            font-size: 16px;
            border-radius: 8px;
        }

        .side-button:hover {
            background-color: #ddd;
        }

        .side-button img {
            width: 20px;
            margin-right: 10px;
        }

        #menu-pendaftaran-warga.active {
            background-color: #6366f1;
            color: white;
        }

        #menu-pendaftaran-warga.active img {
            filter: invert(1);
        }

        /* Main Content Styling */
        .main-content {
            margin-left: 250px;
            padding: 40px;
            background-color: #f9fafb;
        }

        .form-container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 28px;
            text-align: center;
            color: #000000;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            font-size: 14px;
            color: #181919;
            margin-bottom: 10px;
        }

        input,
        select,
        option {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 0px;
            font-size: 14px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-top: 40px;
            margin-bottom: 80px;
            background-color: #023da1;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding: 10px;
            }

            .form-container {
                width: 100%;
                padding: 15px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>

    <script>
        // Fungsi untuk memvalidasi input
        function validateForm(event) {
            var nim = document.getElementById("nim").value;
            var no_hp_pendaftar = document.getElementById("no_hp_pendaftar").value;
            var email_pendaftar = document.getElementById("email_pendaftar").value;
            var foto_pendaftar = document.getElementById("foto_pendaftar").files[0];
            var foto_bukti_lolos_ptn = document.getElementById("foto_bukti_lolos_ptn").files[0];

            // Validasi Nomor HP (hanya angka)
            if (!/^\d{12}$/.test(no_hp_pendaftar)) {
                alert("Nomor HP harus terdiri dari 12 digit angka.");
                event.preventDefault();  // Mencegah form submit
                return false;
            }

            // Validasi Email
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!emailPattern.test(email_pendaftar)) {
                alert("Format email tidak valid.");
                event.preventDefault();  // Mencegah form submit
                return false;
            }

            // Validasi Foto Pendaftar (harus jpg atau png)
            if (foto_pendaftar && !/\.(jpg|jpeg|png)$/i.test(foto_pendaftar.name)) {
                alert("Foto Pendaftar harus berformat JPG atau PNG.");
                event.preventDefault();  // Mencegah form submit
                return false;
            }

            // Validasi Foto Bukti Lolos PTN (harus jpg atau png)
            if (foto_bukti_lolos_ptn && !/\.(jpg|jpeg|png)$/i.test(foto_bukti_lolos_ptn.name)) {
                alert("Foto Bukti Lolos PTN harus berformat JPG atau PNG.");
                event.preventDefault();  // Mencegah form submit
                return false;
            }

            return true;  // Form dapat disubmit jika semua validasi berhasil
        }

        // Menandai menu Pendaftaran Warga yang aktif
        document.addEventListener('DOMContentLoaded', function () {
            const menuItems = document.querySelectorAll('.side-button');
            menuItems.forEach(item => item.classList.remove('active'));

            const pendaftaranWargaMenu = document.getElementById('menu-pendaftaran-warga');
            if (pendaftaranWargaMenu) {
                pendaftaranWargaMenu.classList.add('active');
            }
        });
    </script>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <?php include 'headersidebar.php'; ?>
    </div>

    <!-- Main Content Section -->
    <div class="main-content">
        <div class="form-container">
            <h1>Form Pendaftaran</h1>

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
                    <input type="text" id="nomor_pendaftaran" name="nomor_pendaftaran" maxlength="255" required>
                </div>

                <div>
                    <label for="jenis_kelamin">Jenis Kelamin:</label><br>
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
        </div>
    </div>

</body>
</html>
