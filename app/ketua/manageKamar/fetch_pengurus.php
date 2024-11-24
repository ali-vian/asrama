<?php
// fetch_pengurus.php
include 'db_connection.php';

// Define the number of results per page
$results_per_page = 5;

// Find out the total number of records
$sql = "SELECT COUNT(*) AS total FROM pengurus";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_results = $row['total'];
$total_pages = ceil($total_results / $results_per_page);

// Get the current page or set the default page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($page, $total_pages)); // Ensure page is within range
$starting_limit = ($page - 1) * $results_per_page;

// Fetch the records for the current page
$sql = "SELECT * FROM pengurus LIMIT $starting_limit, $results_per_page";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['nama_pengurus']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nim_pengurus']) . "</td>";
        echo "<td>" . htmlspecialchars($row['prodi_pengurus']) . "</td>";
        echo "<td>" . htmlspecialchars($row['divisi_pengurus']) . "</td>";
        echo "<td class='gedung-column'>" . htmlspecialchars($row['gedung_pengurus']) . "</td>";
        echo "<td>" . htmlspecialchars($row['kamar_pengurus']) . "</td>";
        echo "<td>";
        echo "<button class='btn btn-outline-primary btn-sm' onclick=\"openEditModal('" . htmlspecialchars($row['nama_pengurus']) . "', '" . htmlspecialchars($row['nim_pengurus']) . "', '" . htmlspecialchars($row['prodi_pengurus']) . "', '" . htmlspecialchars($row['divisi_pengurus']) . "', '" . htmlspecialchars($row['gedung_pengurus']) . "', '" . htmlspecialchars($row['kamar_pengurus']) . "')\">Edit</button>";
        echo "<a href='delete_pengurus.php?nim_pengurus=" . $row['nim_pengurus'] . "' class='btn btn-danger btn-sm' style='margin-left: 5px;' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No records found</td></tr>";
}

// Close the connection
$conn->close();
?>


