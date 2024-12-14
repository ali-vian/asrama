<?php
include "connect.php";
// Mengambil data JSON dari body request
$data = json_decode(file_get_contents('php://input'), true);

// Pastikan data yang diterima tidak kosong
if (isset($data['nim'], $data['id_kegiatan'], $data['status_kehadiran'], $data['keterangan'])) {
    $nim = $data['nim'];
    $id_kegiatan = $data['id_kegiatan'];
    $status_kehadiran = $data['status_kehadiran'];
    $keterangan = $data['keterangan'];

    // Lakukan query untuk memperbarui data ke database
    $query = "UPDATE absensi SET status_kehadiran = '$status_kehadiran', keterangan = '$keterangan' WHERE nim = '$nim' AND id_kegiatan = '$id_kegiatan'";
    
    // Eksekusi query
    if (mysqli_query($connect, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat memperbarui data.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap.']);
}
?>
