<?php
include '././db.php';

header('Content-Type: application/json');

if (isset($_POST['nim'])) {
    $nim = $_POST['nim'];

    // Cek apakah NIM terdaftar di tabel pendaftaran
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM pendaftaran WHERE nim = :nim");
    $stmt->bindParam(':nim', $nim);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }
} else {
    echo json_encode(['exists' => false]);
}
