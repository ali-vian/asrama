<?php
// Mengatur header JSON
header("Content-Type: application/json");

// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "asrama";
$koneksi = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($koneksi->connect_error) {
    echo json_encode(["success" => false, "message" => "Koneksi database gagal: " . $koneksi->connect_error]);
    exit();
}

// Mendapatkan data JSON dari JavaScript
$data = json_decode(file_get_contents("php://input"), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["success" => false, "message" => "Input JSON tidak valid"]);
    exit();
}

$nim = $data['nim'];
$status_kehadiran = $data['status'];
$waktu_absen = $data['date'] . ' ' . $data['time'];
$sholat = $data['sholat'];

// Cek apakah NIM ada di database
$checkNimQuery = "SELECT nim FROM absensi WHERE nim = ?";
$stmt = $koneksi->prepare($checkNimQuery);
$stmt->bind_param("s", $nim);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Masukkan data jika NIM ada
    $insertQuery = "INSERT INTO absensi (id_kegiatan, nim, nim_pengurus, status_kehadiran, waktu_absen, jenis_absen, sholat) VALUES (NULL, ?, NULL, ?, ?, 'Harian', ?)";
    $stmt = $koneksi->prepare($insertQuery);
    $stmt->bind_param("ssss", $nim, $status_kehadiran, $waktu_absen, $sholat);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Gagal memasukkan data"]);
    }
} else {
    // Jika NIM tidak ditemukan
    echo json_encode(["success" => false, "message" => "NIM tidak ditemukan di database"]);
}

// Tutup statement dan koneksi
$stmt->close();
$koneksi->close();
?>
