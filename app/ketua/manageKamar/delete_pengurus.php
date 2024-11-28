<?php
include 'db_connection.php';

if (isset($_GET['nim_pengurus'])) {
    $id = $_GET['nim_pengurus'];

    // Prepare the delete query
    $query = "DELETE FROM pengurus WHERE nim_pengurus = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Record deleted successfully'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error deleting record'); window.location.href='index.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
