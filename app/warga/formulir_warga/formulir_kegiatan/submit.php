<?php
include '././db.php';

header('Content-Type: application/json');

if (isset($_POST['nim'], $_POST['id_kegiatan'], $_POST['pertanyaan1'], $_POST['pertanyaan2'], $_POST['pertanyaan3'], $_POST['pertanyaan4'], $_POST['pertanyaan5'], $_POST['saran_masukan'])) {
    $nim = $_POST['nim'];
    $id_kegiatan = $_POST['id_kegiatan'];
    $pertanyaan1 = $_POST['pertanyaan1'];
    $pertanyaan2 = $_POST['pertanyaan2'];
    $pertanyaan3 = $_POST['pertanyaan3'];
    $pertanyaan4 = $_POST['pertanyaan4'];
    $pertanyaan5 = $_POST['pertanyaan5'];
    $saran_masukan = $_POST['saran_masukan'];

    // Insert data ke tabel formulir_kegiatan
    $stmt = $pdo->prepare("INSERT INTO formulir_kegiatan (id_kegiatan, nim, pertanyaan1, pertanyaan2, pertanyaan3, pertanyaan4, pertanyaan5, saran_masukan) VALUES (:id_kegiatan, :nim, :pertanyaan1, :pertanyaan2, :pertanyaan3, :pertanyaan4, :pertanyaan5, :saran_masukan)");
    $stmt->bindParam(':id_kegiatan', $id_kegiatan);
    $stmt->bindParam(':nim', $nim);
    $stmt->bindParam(':pertanyaan1', $pertanyaan1);
    $stmt->bindParam(':pertanyaan2', $pertanyaan2);
    $stmt->bindParam(':pertanyaan3', $pertanyaan3);
    $stmt->bindParam(':pertanyaan4', $pertanyaan4);
    $stmt->bindParam(':pertanyaan5', $pertanyaan5);
    $stmt->bindParam(':saran_masukan', $saran_masukan);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Formulir kegiatan berhasil dikirim']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal mengirim formulir kegiatan']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
}
