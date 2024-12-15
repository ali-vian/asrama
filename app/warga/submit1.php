<?php
include '././db.php';

header('Content-Type: application/json');



try {
    $nim = $_POST['nim'] ?? null;
    $pesan = $_POST['pesan'] ?? null;
    $kategori = $_POST['kategori'] ?? null;

    // Ambil semua pertanyaan dinamis
    // $pertanyaan = [];
    // foreach ($_POST as $key => $value) {
    //     if (strpos($key, 'pertanyaan') === 0) {
    //         $pertanyaan[] = $value;
    //     }
    // }

    // Validasi minimal data
    if (!$nim || !$pesan) {
        echo json_encode(['success' => false, 'message' => 'NIM atau Pesan tidak boleh kosong']);
        exit;
    }

    // Simpan ke database
    $query = "INSERT INTO formulir_kepuasan
                (nim, pesan, kategori)
              VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        $nim,
        $pesan,
        $kategori
    ]);

    echo json_encode(['success' => true, 'message' => 'Formulir berhasil dikirim!']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan formulir', 'error' => $e->getMessage()]);
}
