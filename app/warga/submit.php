<?php
include '././db.php';

header('Content-Type: application/json');

try {
    $nim = $_POST['nim'] ?? null;
    $id_kegiatan = $_POST['id_kegiatan'] ?? null;
    $saran_masukan = $_POST['saran_masukan'] ?? null;

    // Ambil semua pertanyaan dinamis
    $pertanyaan = [];
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'pertanyaan') === 0) {
            $pertanyaan[] = $value;
        }
    }

    // Validasi minimal data
    if (!$nim || !$id_kegiatan) {
        echo json_encode(['success' => false, 'message' => 'NIM atau kegiatan tidak boleh kosong']);
        exit;
    }

    // Simpan ke database
    $query = "INSERT INTO formulir_kegiatan 
                (nim, id_kegiatan, pertanyaan1, pertanyaan2, pertanyaan3, pertanyaan4, pertanyaan5, saran_masukan)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        $nim,
        $id_kegiatan,
        $pertanyaan[0] ?? null,
        $pertanyaan[1] ?? null,
        $pertanyaan[2] ?? null,
        $pertanyaan[3] ?? null,
        $pertanyaan[4] ?? null,
        $saran_masukan
    ]);

    echo json_encode(['success' => true, 'message' => 'Formulir berhasil dikirim!']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan formulir', 'error' => $e->getMessage()]);
}
