<?php
include '././db.php';

$nim = $_POST['nim'] ?? '';

header('Content-Type: application/json');

if ($nim) {
    try {
        // Perbaikan: Query ke tabel 'warga' bukan 'pendaftaran'
        $stmt = $pdo->prepare("SELECT * FROM warga WHERE nim = ?");
        $stmt->execute([$nim]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo json_encode(['exists' => true]);
        } else {
            echo json_encode(['exists' => false]);
        }
    } catch (PDOException $e) {
        echo json_encode(['exists' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['exists' => false, 'error' => 'NIM tidak disediakan']);
}
