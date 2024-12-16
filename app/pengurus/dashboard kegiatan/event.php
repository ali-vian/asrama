<?php
    session_start();
    if (!isset($_SESSION['nim']) && !$_SESSION['role'] == 'pengurus') {
        header("Location: ../../../index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event</title>
    <link href="./src/output.css" rel="stylesheet"> 
    <style>
        .highlight {
            background-color: #fde68a;
        }
        .table-container {
            max-height: 90%; 
            overflow-y: auto;
        }
        .top-head {
            border-top: 1px solid rgba(156, 163, 175, 0.1);
        }
        .aksi-column {
            text-align: center;
        }
</style>
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-white font-sans leading-normal tracking-normal">
    <div class="flex h-screen bg-white">
        <div class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-semibold">Kegiatan Asrama</h1>
                    <p class="text-gray-600 mt-1">Berikut adalah daftar kegiatan yang diadakan di asrama. Anda dapat mencari, melihat, dan mengelola kegiatan yang ada.</p>
                </div>
                <div class="flex items-center">
                    <input type="text" id="searchInput" placeholder="Search..." class="border rounded p-2 mr-4" onkeyup="searchTable()">
                    <button class="bg-gray-200 p-2 rounded">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M21 19l-4.35-4.35a7.5 7.5 0 10-1.42 1.42L19 21l2-2zM10.5 17a6.5 6.5 0 110-13 6.5 6.5 0 010 13z"/></svg>
                    </button>
                </div>
            </div>

            <div class="table-container shadow-lg">
                <table class="min-w-full bg-white-100 rounded overflow-hidden" id="eventTable">
                    <thead>
                        <tr class="bg-blue-500 text-white">
                            <th class="py-3 px-4 text-center">Nama Kegiatan</th>
                            <th class="py-3 px-4 text-center">Tanggal Kegiatan</th>
                            <th class="py-3 px-4 text-center">Tempat</th>
                            <th class="py-3 px-4 text-center">Deskripsi</th>
                            <th class="py-3 px-4 text-center">Foto Pamflet</th>
                            <th class="py-3 px-4 text-center align-middle aksi-column">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'koneksi.php';
                        $sql = "SELECT id_kegiatan, nama_kegiatan, tanggal_kegiatan, tempat, deskripsi, foto_pamflet FROM kegiatan";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr class='top-head'>";
                                echo "<td class='py-3 px-4 text-left event-name'>" . $row["nama_kegiatan"] . "</td>";
                                echo "<td class='py-3 px-4 text-center'>" . $row["tanggal_kegiatan"] . "</td>";
                                echo "<td class='py-3 px-4 text-center'>" . $row["tempat"] . "</td>";
                                echo "<td class='py-3 px-4 text-center'>" . $row["deskripsi"] . "</td>";
                                echo "<td class='py-3 px-4 text-center flex justify-center'><img src='./src/storage/" . $row["foto_pamflet"] . "' alt='" . $row["nama_kegiatan"] . "' class='h-10 w-auto cursor-pointer' onclick='showPopup(\"./src/storage/" . $row["foto_pamflet"] . "\")'></td>";
                                echo "<td class='py-3 px-4 aksi-column'>"
                                    . "<a href='event_edit.php?id_kegiatan=" . $row["id_kegiatan"] . "' class='text-blue-500 hover:underline'>Edit</a> | "
                                    . "<a href='#' class='text-red-500 hover:underline' onclick='confirmDelete(" . $row["id_kegiatan"] . ")'>Hapus</a>"
                                    . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='py-3 px-4 text-center'>Tidak ada kegiatan yang ditemukan.</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <a href="event_tambah.php" class="fixed bottom-6 right-6 bg-blue-500 text-white rounded-full shadow-lg hover:bg-blue-600 transition duration-300 flex items-center justify-center text-3xl font-bold leading-none w-14 h-14">
        <span class="relative bottom-[3px]">+</span>
    </a>

    <div class="fixed hidden inset-0 bg-black bg-opacity-50 justify-center items-center flex" id="popup" onclick="this.classList.add('hidden')">
        <img id="popup-img" src="" alt="" class="max-w-full max-h-full">
    </div>

    <script>
        function searchTable() {
            var input = document.getElementById("searchInput").value.toLowerCase();
            var rows = document.querySelectorAll("#eventTable tbody tr");
            var firstMatch = null; 

            if (input === "") {
                rows.forEach(function(row) {
                    row.classList.remove("highlight");
                });
            } else {
                rows.forEach(function(row) {
                    var eventName = row.querySelector(".event-name").textContent.toLowerCase();
                    if (eventName.includes(input)) {
                        row.classList.add("highlight");
                        if (!firstMatch) {
                            firstMatch = row;
                        }
                    } else {
                        row.classList.remove("highlight");
                    }
                });
                if (firstMatch) {
                    firstMatch.scrollIntoView({ behavior: "smooth", block: "center" });
                }
            }
        }

        document.getElementById("searchInput").addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault(); 
                searchTable();
            }
        });

        function showPopup(imgSrc) {
            var popup = document.getElementById("popup");
            var popupImg = document.getElementById("popup-img");
            popupImg.src = imgSrc;
            popup.classList.remove('hidden');
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data kegiatan akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'event_proses_hapus.php?id_kegiatan=' + id;
                }
            });
        }
    </script>

    <?php
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            $messageType = $_SESSION['message_type'];
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: '" . ($messageType == 'success' ? 'Berhasil!' : 'Error!') . "',
                        text: '$message',
                        icon: '$messageType',
                        confirmButtonText: 'OK'
                    });
                });
            </script>";
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }
    ?>
</body>
</html>
