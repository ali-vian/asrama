<?php
function generateID($conn) {
    $query = "SELECT id FROM pendaftaran ORDER BY id DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $lastID = $result->fetch_assoc()['id'];
        $number = intval(substr($lastID, -5)) + 1;
    } else {
        $number = 1;
    }

    return "DA-UTM-" . str_pad($number, 5, "0", STR_PAD_LEFT);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $prodi_pendaftar = $_POST['prodi_pendaftar'];
    $alamat_pendaftar = $_POST['alamat_pendaftar'];
    $ttl = $_POST['ttl'];
    $no_hp_pendaftar = $_POST['no_hp_pendaftar'];
    $email_pendaftar = $_POST['email_pendaftar'];
    $nomor_pendaftaran = $_POST['nomor_pendaftaran'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $jalur_masuk = $_POST['jalur_masuk'];
    $nama_ayah = $_POST['nama_ayah'];
    $nama_ibu = $_POST['nama_ibu'];
    $no_hp_ortu = $_POST['no_hp_ortu'];

    // Proses upload file
    $foto_pendaftar = $_FILES['foto_pendaftar'];
    $foto_bukti_lolos_ptn = $_FILES['foto_bukti_lolos_ptn'];

    $targetDir = "uploads/";
    $fotoPendaftarPath = $targetDir . basename($foto_pendaftar['name']);
    $fotoBuktiPath = $targetDir . basename($foto_bukti_lolos_ptn['name']);

    move_uploaded_file($foto_pendaftar['tmp_name'], $fotoPendaftarPath);
    move_uploaded_file($foto_bukti_lolos_ptn['tmp_name'], $fotoBuktiPath);

    // Simpan ke database
    $conn = new mysqli("localhost", "root", "", "asrama");

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $id = generateID($conn);

    $sql = "INSERT INTO pendaftaran (id, nim, nama_lengkap, prodi_pendaftar, alamat_pendaftar, ttl, no_hp_pendaftar, email_pendaftar, nomor_pendaftaran, jenis_kelamin, jalur_masuk, foto_pendaftar, foto_bukti_lolos_ptn, nama_ayah, nama_ibu, no_hp_ortu)
            VALUES ('$id', '$nim', '$nama_lengkap', '$prodi_pendaftar', '$alamat_pendaftar', '$ttl', '$no_hp_pendaftar', '$email_pendaftar', '$nomor_pendaftaran', '$jenis_kelamin', '$jalur_masuk', '$fotoPendaftarPath', '$fotoBuktiPath', '$nama_ayah', '$nama_ibu', '$no_hp_ortu')";

    if ($conn->query($sql) === TRUE) {
        echo "Pendaftaran berhasil!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
