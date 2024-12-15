<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../../assets/js/rekap-absensi.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Manrope' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/bar-ketua.css">
    <link rel="stylesheet" href="../../assets/css/rekap-absensi.css">
    <link rel="stylesheet" href="../../assets/css/style_penghuni.css">

    <style>
        body {
            font-family: "Manrope", sans-serif;
            margin: 0;
            padding: 0;
        }

        .container-fluid {
            display: flex;
            min-height: 100vh;
            padding-left: 0;
        }

        /* Sidebar Style */
        .sidebar {
            width: 250px;
            background-color: #f8f8f8;
            padding: 20px;
            border-right: 1px solid #e0e0e0;
            position: fixed; /* Sidebar tetap di kiri */
            top: 0;
            left: 0;
            height: 100vh;
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

        /* Main Content Area */
        .main-content {
            flex-grow: 1;
            margin-left: 250px; /* Menambahkan margin kiri untuk konten setelah sidebar */
            padding: 40px 30px;
            background-color: #f9fafb;
            min-height: 100vh;
            position: relative;
        }

        /* Header Section (Profile & Notifications) */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-section h2 {
            font-size: 2rem;
            font-weight: 600;
            margin: 0;
        }

        .profile-menu {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .profile-menu img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .profile-menu span {
            font-size: 1.1rem;
            color: #4a4a4a;
        }

        .profile-menu i {
            font-size: 1.1rem;
            color: #6366f1;
        }

        .form-container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .form-title {
            font-size: 1.8rem;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .form-label {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .form-control, .form-select, textarea {
            width: 100%;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
            margin-bottom: 15px;
        }

        .form-control:focus, .form-select:focus, textarea:focus {
            border-color: #6366f1;
        }

        .btn-submit {
            background-color: #6366f1;
            color: white;
            padding: 15px;
            width: 100%;
            border-radius: 8px;
            border: none;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        .btn-submit:hover {
            background-color: #4f46e5;
        }

        /* Highlight active menu item in sidebar */
        #menu-aspirasi.active {
            background-color: #6366f1;
            color: white;
        }

        #menu-aspirasi.active img {
            filter: invert(1);
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .container-fluid {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }

            .profile-menu {
                display: none;
            }

            .notification-icon {
                right: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="container-fluid">

        <!-- Sidebar (from 'headersidebar.php') -->
        <div class="sidebar">
            <?php include '../warga/headersidebar.php'; ?>
        </div>

        <!-- Main Content Section -->
        <div class="main-content">
            <!-- Profile and Notification Section -->
            <div class="header-section">
                <div>
                    <h2>Formulir Kepuasan</h2>
                    <p>Berikan penilaian dan masukan kepada kami untuk peningkatan layanan</p>
                </div>
            </div>

            <!-- Form Section -->
            <div class="form-container">
                <form id="kepuasanForm" onsubmit="checkNIM(event)">
                    <div class="form-title">Berikan Kepuasan Anda</div>
                    
                    <label for="nim" class="form-label">NIM <span class="text-red-500">*</span></label>
                    <input type="text" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM" required />
                    
                    <label for="pesan" class="form-label">Pesan <span class="text-red-500">*</span></label>
                    <textarea class="form-control" id="pesan" name="pesan" placeholder="Masukkan Pesan" rows="4" required></textarea>
                    
                    <label for="kategori" class="form-label">Kategori <span class="text-red-500">*</span></label>
                    <select class="form-select" id="kategori" name="kategori">
                        <option disabled>Pilih Kategori</option>
                        <option value="Akademik">Akademik</option>
                        <option value="Fasilitas">Fasilitas</option>
                        <option value="Pelayanan">Pelayanan</option>
                    </select>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="confirm" required />
                        <label class="form-check-label" for="confirm">Apakah kamu yakin mengirim pesan ini?</label>
                    </div>

                    <button type="submit" class="btn-submit">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Menandai menu Aspirasi yang aktif
        document.addEventListener('DOMContentLoaded', function () {
            // Menghapus kelas active dari semua elemen sidebar
            const menuItems = document.querySelectorAll('.side-button');
            menuItems.forEach(item => item.classList.remove('active'));

            // Menambahkan kelas active pada menu Aspirasi
            const aspirasiMenu = document.getElementById('menu-aspirasi');
            if (aspirasiMenu) {
                aspirasiMenu.classList.add('active');
            }
        });

        function checkNIM(event) {
            event.preventDefault();
            const nim = document.getElementById("nim").value;

            fetch("check_nim.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "nim=" + nim
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        submitForm();
                    } else {
                        alert("NIM tidak terdaftar");
                    }
                })
                .catch(error => console.error("Error:", error));
        }

        function submitForm() {
            const formData = new FormData(document.getElementById("kepuasanForm"));

            fetch("submit1.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        document.getElementById("kepuasanForm").reset();
                    }
                })
                .catch(error => console.error("Error:", error));
        }
    </script>

</body>
</html>
