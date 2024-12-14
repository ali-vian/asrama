<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Static data for the extracurricular activity
$extrakurikuler = [
    'nama_extra' => 'Nama Ekstrakurikuler',
    'deskripsi_extra' => 'Deskripsi mengenai ekstrakurikuler ini.',
    'jadwal' => 'Setiap Senin, pukul 15:00 - 17:00',
    'kuota' => '20'
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_pendaftaran'])) {
    // Sanitize input
    $nama_pendaftar = htmlspecialchars(trim($_POST['nama_pendaftar']));
    $nim_pendaftar = htmlspecialchars(trim($_POST['nim_pendaftar']));
    $prodi_pendaftar = htmlspecialchars(trim($_POST['prodi_pendaftar']));
    $tanggal_pendaftaran = date("Y-m-d");

    // Folder for storing uploaded files if not existing
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Create a unique file name
    $target_file = $target_dir . uniqid() . '-' . basename($_FILES["foto_bukti_lolos_ptn"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verify if the uploaded file is an image
    $check = getimagesize($_FILES["foto_bukti_lolos_ptn"]["tmp_name"]);
    if ($check === false) {
        echo "File bukan gambar.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["foto_bukti_lolos_ptn"]["size"] > 500000) {
        echo "Maaf, ukuran file terlalu besar.";
        $uploadOk = 0;
    }

    // Only allow JPG and JPEG formats
    if ($imageFileType != "jpg" && $imageFileType != "jpeg") {
        echo "Maaf, hanya JPG dan JPEG yang diperbolehkan.";
        $uploadOk = 0;
    }

    // Attempt to upload the file
    if ($uploadOk && move_uploaded_file($_FILES["foto_bukti_lolos_ptn"]["tmp_name"], $target_file)) {
        // Connect to the database
        require_once("koneksi.php");

        // Check if NIM exists in the 'warga' table
        $check_nim_query = "SELECT COUNT(*) FROM warga WHERE nim = ?";
        if ($stmt_check_nim = $db->prepare($check_nim_query)) {
            $stmt_check_nim->bind_param("s", $nim_pendaftar);
            $stmt_check_nim->execute();
            $stmt_check_nim->bind_result($count);
            $stmt_check_nim->fetch();
            $stmt_check_nim->close();

            if ($count == 0) {
                echo "NIM tidak ditemukan di tabel warga. Silakan daftar sebagai warga terlebih dahulu.";
                exit;
            }
        } else {
            echo "Error preparing NIM check statement: " . htmlspecialchars($db->error);
            exit;
        }

        // Prepare SQL statement to insert registration data
        $query_pendaftaran = "INSERT INTO pendaftaran (nim, nama_lengkap, prodi_pendaftar, foto_bukti_lolos_ptn, created_at_pendaftar) 
                              VALUES (?, ?, ?, ?, ?)";
        
        if ($stmt_pendaftaran = $db->prepare($query_pendaftaran)) {
            // Bind parameters
            $stmt_pendaftaran->bind_param("sssss", $nim_pendaftar, $nama_pendaftar, $prodi_pendaftar, $target_file, $tanggal_pendaftaran);

            // Execute the statement and check for success
            if ($stmt_pendaftaran->execute()) {
                // Menampilkan alert berhasil dengan link WhatsApp
                echo "<script>
                        alert('Pendaftaran berhasil! Klik OK untuk bergabung ke grup WhatsApp kami.');
                        window.location.href = 'https://chat.whatsapp.com/yourgroupinvitecode'; // Ganti dengan link grup WhatsApp yang benar
                      </script>";
                exit;
            } else {
                echo "Error inserting registration: " . htmlspecialchars($stmt_pendaftaran->error);
            }
            // Close the statement
            $stmt_pendaftaran->close();
        } else {
            echo "Error preparing registration statement: " . htmlspecialchars($db->error);
        }
        
        // Close database connection
        $db->close();
        
    } else {
        echo "Maaf, terjadi kesalahan saat mengupload file.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran Ekstrakurikuler</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        h2 {
            margin-bottom: 10px;
            color: #333;
        }

        p {
            margin-bottom: 15px;
            line-height: 1.6;
            color: #555;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Formulir Pendaftaran Ekstrakurikuler</h1>
        
        <div style="background-color: lightblue; border: 1px solid #ccc; padding: 10px;">
          Ketentuan:
          <p>1. Setiap calon peserta wajib mengisi formulir pendaftaran dengan lengkap.</p>
          <p>2. Data-data yang diisikan pada formulir Online harus sesuai dengan data asli dan benar adanya.</p>
          <p>3. Calon peserta yang sudah mendaftar secara online wajib mencetak bukti pendaftaran sebagai bukti pendaftaran dan dilampirkan dalam persyaratan yang diminta oleh Panitia.</p>
          <p>4. Calon peserta didik yang sudah mendaftarkan diri melalui Online wajib menyerahkan dokumen persyaratan yang sudah ditentukan oleh Panitia.</p>
          <p>5. Calon peserta didik yang telah mendaftar tidak dapat mencabut berkas pendaftaran dengan alasan apapun.</p>
      </div> 
      <br/>

      <form action="" method="post" enctype="multipart/form-data">
          <label for="nim_pendaftar">NIM:</label>
          <input type="text" id="nim_pendaftar" name="nim_pendaftar" required>

          <label for="nama_pendaftar">Nama Lengkap:</label>
          <input type="text" id="nama_pendaftar" name="nama_pendaftar" required>

          <label for="prodi_pendaftar">Program Studi:</label>
          <input type="text" id="prodi_pendaftar" name="prodi_pendaftar" required>

          <label for="foto_bukti_lolos_ptn">Foto Bukti Pendaftar:</label>
          <input type="file" id="foto_bukti_lolos_ptn" name="foto_bukti_lolos_ptn" accept="image/jpeg" required>

          <input type="submit" name="submit_pendaftaran" value="Daftar">
      </form>
   </div>
</body>
</html>