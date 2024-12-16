<?php

session_start();
if (!isset($_SESSION['nim']) && !$_SESSION['role'] == 'pengurus') {
    header("Location: ../../../index.php");
    exit;
}

include 'koneksi.php';

if (isset($_GET['id_kegiatan'])) {
    $id_kegiatan = $_GET['id_kegiatan'];

    $sql = "SELECT id_kegiatan, nama_kegiatan, tanggal_kegiatan, tempat, deskripsi, foto_pamflet FROM kegiatan WHERE id_kegiatan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_kegiatan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Kegiatan tidak ditemukan.";
        exit;
    }
} else {
    echo "ID kegiatan tidak ditentukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link href="./src/output.css" rel="stylesheet">
</head>
<body class="bg-white font-sans leading-normal tracking-normal">
    <div class="flex h-screen bg-white">
        <div class="w-64 bg-white shadow-lg p-5">
            <div class="mb-8 text-center">
                <img src="./src/img/logo asrama.jpg" alt="Logo Asrama" class="h-10 w-auto mx-auto">
            </div>
            <nav class="text-gray-700">
                <a href="#" class="block p-3 mb-2 rounded-lg hover:bg-blue-100">Dashboard</a>
                <a href="#" class="block p-3 mb-2 rounded-lg hover:bg-blue-100">Aspirasi</a>
                <a href="#" class="block p-3 mb-2 rounded-lg hover:bg-blue-100">Warga Asrama</a>
                <a href="#" class="block p-3 mb-2 rounded-lg hover:bg-blue-100">Absen Warga</a>
                <a href="#" class="flex items-center p-3 mb-4 rounded-lg bg-blue-500 text-white">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M10 0C4.48 0 0 4.48 0 10s4.48 10 10 10 10-4.48 10-10S15.52 0 10 0zm0 18.75C5.13 18.75 1.25 14.87 1.25 10S5.13 1.25 10 1.25 18.75 5.13 18.75 10 14.87 18.75 10 18.75z"/>
                        <path d="M9 10h2v5h-2zm0-5h2v2H9z"/>
                    </svg>
                    Event
                </a>
                <a href="#" class="block p-3 mb-2 rounded-lg hover:bg-blue-100">Jajak Pendapat</a>
            </nav>
        </div>

        <div class="flex-1 p-6 ">
            <h1 class="text-2xl font-semibold mb-4">Edit Kegiatan Asrama</h1>
            <form action="event_proses_edit.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="id_kegiatan" value="<?php echo $row['id_kegiatan']; ?>">

                <div>
                    <label for="nama_kegiatan" class="block text-sm font-medium text-gray-700">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" id="nama_kegiatan" value="<?php echo $row['nama_kegiatan']; ?>" required class="border rounded p-2 w-full">
                </div>
                
                <div>
                    <label for="tanggal_kegiatan" class="block text-sm font-medium text-gray-700">Tanggal Kegiatan</label>
                    <input type="datetime-local" name="tanggal_kegiatan" id="tanggal_kegiatan" value="<?php echo date('Y-m-d\TH:i', strtotime($row['tanggal_kegiatan'])); ?>" class="border rounded p-2 w-full">
                </div>
                
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="border rounded p-2 w-full" rows="4"><?php echo $row['deskripsi']; ?></textarea>
                </div>
                
                <div>
                    <label for="foto_pamflet" class="block text-sm font-medium text-gray-700">Foto Pamflet (Upload foto baru)</label>
                    <input type="file" name="foto_pamflet" id="foto_pamflet" class="border rounded p-2 w-full">
                    <p class="text-gray-600 text-sm">Foto saat ini: <img src='./src/storage/<?php echo $row['foto_pamflet']; ?>' alt='<?php echo $row['nama_kegiatan']; ?>' class='h-10 w-auto cursor-pointer ml-3' onclick="showPopup('./src/storage/<?php echo $row['foto_pamflet']; ?>')"></p>
                </div>
                
                <div>
                    <label for="tempat" class="block text-sm font-medium text-gray-700">Tempat</label>
                    <input type="text" name="tempat" id="tempat" value="<?php echo $row['tempat']; ?>" class="border rounded p-2 w-full">
                </div>
                
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Perubahan</button>
                <a href="event.php" class="inline-block mt-4 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-400">Batal</a>
            </form>
        </div>
    </div>

    <div class="fixed hidden inset-0 bg-black bg-opacity-50 justify-center items-center flex" id="popup" onclick="this.classList.add('hidden')">
        <img id="popup-img" src="" alt="" class="max-w-full max-h-full">
    </div>

    <script>
        function showPopup(imgSrc) {
            var popup = document.getElementById("popup");
            var popupImg = document.getElementById("popup-img");
            popupImg.src = imgSrc;
            popup.classList.remove('hidden');
        }
    </script>
</body>
</html>
