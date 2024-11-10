<?php
include 'koneksi.php';

if (isset($_POST['id_kegiatan'])) {
    $id_kegiatan = $_POST['id_kegiatan'];

    // Query untuk menandai notifikasi sebagai sudah dibaca
    $sql = "UPDATE kegiatan SET read_status = 1 WHERE id_kegiatan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_kegiatan);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => 'Notifikasi telah ditandai sebagai sudah dibaca']);
    } else {
        echo json_encode(['error' => 'Gagal menandai notifikasi']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'ID kegiatan tidak ditemukan']);
}
$conn->close();
?>
