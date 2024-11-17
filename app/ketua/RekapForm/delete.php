<?php
if (isset($_GET['id'])) {
    $conn = new mysqli("localhost", "root", "", "asrama");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = intval($_GET['id']);
    $sql = "DELETE FROM formulir_kepuasan WHERE id_formulir = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: rekap_formulir.php"); // Redirect kembali ke halaman utama
        exit();
    } else {
        echo "Error deleting record: " . $conn->error; 
    }

    $conn->close();
}
?>
