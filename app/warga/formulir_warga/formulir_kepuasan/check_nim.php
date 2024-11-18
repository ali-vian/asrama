<?php
include '././db.php';

header('Content-Type: application/json');

if (isset($_POST['nim'])) {
    $nim = $_POST['nim'];

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM warga WHERE nim = :nim");
    $stmt->bindParam(':nim', $nim);
    $stmt->execute();

    echo json_encode(['exists' => $stmt->fetchColumn() > 0]);
} else {
    echo json_encode(['exists' => false]);
}
