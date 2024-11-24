<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim_pengurus = $_POST['nim_pengurus'];
    $nama_pengurus = $_POST['nama_pengurus'];
    $prodi_pengurus = $_POST['prodi_pengurus'];
    $divisi_pengurus = $_POST['divisi_pengurus'];
    $gedung_pengurus = $_POST['gedung_pengurus'];
    $kamar_pengurus = $_POST['kamar_pengurus'];

    // Prepare the update query
    $stmt = $conn->prepare("UPDATE pengurus SET 
                            nama_pengurus = ?, 
                            prodi_pengurus = ?, 
                            divisi_pengurus = ?, 
                            gedung_pengurus = ?, 
                            kamar_pengurus = ? 
                            WHERE nim_pengurus = ?");
    $stmt->bind_param("ssssss", $nama_pengurus, $prodi_pengurus, $divisi_pengurus, $gedung_pengurus, $kamar_pengurus, $nim_pengurus);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect back to the main page
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
