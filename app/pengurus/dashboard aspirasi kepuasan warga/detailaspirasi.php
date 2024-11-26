<?php
$koneksi = mysqli_connect("localhost", "root", "", "asrama");

// Mendapatkan id_formulir dari URL
$id_frm = $_GET['id_formulir'];

// Query dengan INNER JOIN antara tabel warga dan formulir_kepuasan berdasarkan nim
$query = "SELECT formulir_kepuasan.*, warga.nama,warga.prodi FROM formulir_kepuasan INNER JOIN warga 
    ON formulir_kepuasan.nim = warga.nim WHERE formulir_kepuasan.id_formulir = '$id_frm'
";
$result = mysqli_query($koneksi, $query);

// Memeriksa apakah data ditemukan
if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
} else {
    echo "Data tidak ditemukan.";
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aspirasi Warga Asrama</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .content {
            padding: 10px;
            max-width: 1500px;
            margin: auto;
        }

        .container {
            background-color: #ffffff; 
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease;
        }

        .header {
            text-align: left;
            margin-bottom: 10px;
            font-weight: normal;
        }

        .header-container {
            text-align: center;
            font-size: 24px;
            /* font-weight: bold; */
            color: #4a4a4a;
            margin-bottom: 10px;
        }

        .header-border {
            border-top: 1px solid #333;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 14px;
            color: #555;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s;
            background-color: #f9f9f9;
        }

        .form-group input:focus, .form-group textarea:focus {
            border-color: #4a90e2;
            background-color: #fff;
        }

        .form-group textarea {
            resize: none;
            height: 100px;
        }

        .buttons {
            display: flex;
            gap: 200px; /* Jarak antar tombol */
            justify-content: center;
            margin-top: 18px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 25px; /* Jarak antara ikon dan teks */
            padding: 10px 20px;
            font-size: 16px;
            justify-content: center;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-back {
            background-color: #007bff;
            color: white;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #a71d2a;
        }

        .btn i {
            font-size: 18px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Media Queries */
        @media (max-width: 768px) {
            .content {
                max-width: 90%;
                padding: 10px;
            }

            .btn {
                width: 100%;
                margin-top: 10px;
            }

            .buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="content">
        <h2 class="header">Aspirasi Kepuasan Warga Asrama</h2>
        <div class="header-border"></div>
        
        <div class="container">
            <div class="header-container">Detail Aspirasi Warga</div>
            <div class="form-group">
                <label for="tanggal">Tanggal dikirim</label>
                <input type="text" id="tanggal" value="<?= $data['created_at']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="nim">Nomor Induk Mahasiswa</label>
                <input type="text" id="nim" value="<?= $data['nim']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="nama">Nama Mahasiswa</label>
                <input type="text" id="nama" value="<?= $data['nama']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="prodi">Program Studi Mahasiswa</label>
                <input type="text" id="prodi" value="<?= $data['prodi']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="kategori">Kategori Aspirasi</label>
                <input type="text" id="kategori" value="<?= $data['kategori']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="aspirasi">Aspirasi</label>
                <textarea id="aspirasi" readonly><?= $data['pesan']; ?></textarea>
            </div>
        </div>
        
        <div class="buttons">
            <a href="aspirasi.php" class="btn btn-back"><i class="fas fa-arrow-left"></i> Back</a>
            <a href="javascript:void(id=<?=$data['id_formulir'];?>);" onclick="hapus(<?= $data['id_formulir']; ?>)" class="btn btn-delete"><i class="fa fa-trash"></i> Delete</a>
        </div>
    </div>
    <script>
        function hapus(id) {
            if (confirm("Anda yakin akan menghapus data ini?")) {
                window.location = "hapus.php?id=" + id;
            }
        }
    </script>
</body>
</html>
