<?php
include "connect.php";

// Cek koneksi
if ($connect->connect_error) {
    die(json_encode([
        "status" => "error",
        "message" => "Koneksi database gagal: " . $connect->connect_error
    ]));
}

// Mendapatkan data dari request
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['nim']) && isset($data['status_kehadiran'])) {
    $nim = $connect->real_escape_string($data['nim']);
    $status_kehadiran = $connect->real_escape_string($data['status_kehadiran']);

    // Periksa apakah NIM ada di database
    $checkNim = $connect->prepare("SELECT COUNT(*) as count FROM absensi WHERE nim = ?");
    $checkNim->bind_param("s", $nim);
    $checkNim->execute();
    $result = $checkNim->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] == 0) {
        echo json_encode([
            "status" => "error",
            "message" => "NIM tidak ditemukan!"
        ]);
        $checkNim->close();
        $connect->close();
        exit;
    }
    $checkNim->close();

    // Update status pada tabel absensi
    $stmt = $connect->prepare("UPDATE absensi SET status_kehadiran = ? WHERE nim = ?");
    $stmt->bind_param("ss", $status_kehadiran, $nim);
    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Status kehadiran berhasil diperbarui untuk NIM $nim"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Gagal memperbarui data: " . $stmt->error
        ]);
    }
    $stmt->close();
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Data tidak lengkap."
    ]);
}

$connect->close();
?>