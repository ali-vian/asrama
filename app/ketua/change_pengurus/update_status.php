<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];
    $divisi = $_POST['divisi'];
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];
    $divisi = $_POST['divisi'];
    $jabatan = $_POST['jabatan'];
    $kamar = $_POST['kamar'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_hp = $_POST['no_hp']; 
    $email = $_POST['email']; 
    $password = $_POST['password']; 
    $foto_warga = $_POST['foto_warga']; 
    $gedung = $_POST['gedung'];


    // Menggunakan prepared statement dengan placeholder
    $insert_sql = "INSERT INTO pengurus (nim_pengurus, nama_pengurus, prodi_pengurus, divisi_pengurus, jabatan_pengurus, kamar_pengurus, jenis_kelamin_pengurus, no_hp_pengurus, email_pengurus, password_pengurus, foto_pengurus, gedung_pengurus) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($insert_sql);
    
    // Cek jika statement berhasil disiapkan
    if (!$stmt) {
        die("Error preparing insert statement: " . $conn->error);
    }
    
    // Bind parameter dengan benar
    $stmt->bind_param("ssssssssssss", $nim, $nama, $prodi, $divisi, $jabatan, $kamar,  $jenis_kelamin,  $no_hp, $email, $password, $foto_warga, $gedung);


    
    // Eksekusi statement
    if (!$stmt->execute()) {
        die("Error executing insert statement: " . $stmt->error);
    }

    // Hapus data dari tabel warga setelah dipindahkan ke pengurus
    $delete_sql = "DELETE FROM warga WHERE nim = ?";
    $stmt = $conn->prepare($delete_sql);
    
    // Cek jika statement berhasil disiapkan
    if (!$stmt) {
        die("Error preparing delete statement: " . $conn->error);
    }
    
    // Bind parameter untuk delete statement
    $stmt->bind_param("s", $nim);
    
    // Eksekusi delete statement
    if (!$stmt->execute()) {
        die("Error executing delete statement: " . $stmt->error);
    }

    echo "<script>alert('Status berhasil diperbarui menjadi pengurus'); window.location.href = 'penghuni.php';</script>";

    // Menutup statement
    $stmt->close();
}

// Menutup koneksi
$conn->close();
?>