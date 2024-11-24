<?php
include '././db.php';

header('Content-Type: application/json');

if (isset($_POST['nim'], $_POST['pesan'], $_POST['kategori'])) {
    $nim = $_POST['nim'];
    $pesan = $_POST['pesan'];
    $kategori = $_POST['kategori'];

    $stmt = $pdo->prepare("INSERT INTO formulir_kepuasan (nim, pesan, kategori) VALUES (:nim, :pesan, :kategori)");
    $stmt->bindParam(':nim', $nim);
    $stmt->bindParam(':pesan', $pesan);
    $stmt->bindParam(':kategori', $kategori);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Pesan berhasil dikirim!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan saat mengirim pesan.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']);
}
