<?php
include '././db.php';

$query = "SELECT id_kegiatan, nama_kegiatan FROM kegiatan";
$stmt = $pdo->query($query);
$kegiatan = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formulir Kegiatan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: "Roboto", sans-serif;
        }

        .navbar-fixed-top {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: white;
            z-index: 50;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-container {
            padding-top: 130px;
        }

        .right-image {
            background-image: url('././images/rightbg.png');
            background-position: center;
        }
    </style>
    <script>
        function checkNIM(event) {
            event.preventDefault();
            const nim = document.getElementById("nim").value;

            fetch("check_nim.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "nim=" + nim
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        submitForm();
                    } else {
                        alert("NIM tidak terdaftar");
                    }
                })
                .catch(error => console.error("Error:", error));
        }

        function submitForm() {
            const formData = new FormData(document.getElementById("kegiatanForm"));

            fetch("submit.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        document.getElementById("kegiatanForm").reset();
                    }
                })
                .catch(error => console.error("Error:", error));
        }
    </script>
</head>

<body class="bg-gray-100">
    <div class="navbar-fixed-top p-3 border-b bg-white">
        <div class="md:w-9/12 container mx-auto flex items-center justify-between">
            <div class="flex items-center">
                <img src="././images/logo.png" alt="Logo" class="mr-3" />
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="md:w-9/12 container mx-auto form-container flex flex-col md:flex-row">
        <div class="md:w-1/2 px-4">
            <h2 class="text-5xl font-bold mb-5 pt-3">Formulir Kegiatan</h2>
            <p class="text-gray-600 mb-4">Berikan penilaian dan masukan untuk peningkatan kegiatan</p>
            <form id="kegiatanForm" onsubmit="checkNIM(event)">
                <div class="mb-3">
                    <label for="nim" class="block text-gray-700 font-semibold mb-1">NIM <span class="text-red-500">*</span></label>
                    <input type="text" class="form-control w-full border border-gray-300 p-2 rounded-md" id="nim" name="nim" placeholder="Masukkan NIM" required />
                </div>
                <div class="mb-3">
                    <label for="id_kegiatan" class="block text-gray-700 font-semibold mb-1">Kegiatan <span class="text-red-500">*</span></label>
                    <select class="form-select w-full border border-gray-300 p-2 rounded-md" id="id_kegiatan" name="id_kegiatan" required>
                        <option selected disabled>Pilih Kegiatan</option>
                        <?php foreach ($kegiatan as $item): ?>
                            <option value="<?= $item['id_kegiatan']; ?>"><?= $item['nama_kegiatan']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="pertanyaan1" class="block text-gray-700 font-semibold mb-1">Pertanyaan 1</label>
                    <input type="text" class="form-control w-full border border-gray-300 p-2 rounded-md" id="pertanyaan1" name="pertanyaan1" placeholder="Masukkan Pertanyaan 1" />
                </div>
                <div class="mb-3">
                    <label for="pertanyaan2" class="block text-gray-700 font-semibold mb-1">Pertanyaan 2</label>
                    <input type="text" class="form-control w-full border border-gray-300 p-2 rounded-md" id="pertanyaan2" name="pertanyaan2" placeholder="Masukkan Pertanyaan 2" />
                </div>
                <div class="mb-3">
                    <label for="pertanyaan3" class="block text-gray-700 font-semibold mb-1">Pertanyaan 3</label>
                    <input type="text" class="form-control w-full border border-gray-300 p-2 rounded-md" id="pertanyaan3" name="pertanyaan3" placeholder="Masukkan Pertanyaan 3" />
                </div>
                <div class="mb-3">
                    <label for="pertanyaan4" class="block text-gray-700 font-semibold mb-1">Pertanyaan 4</label>
                    <input type="text" class="form-control w-full border border-gray-300 p-2 rounded-md" id="pertanyaan4" name="pertanyaan4" placeholder="Masukkan Pertanyaan 4" />
                </div>
                <div class="mb-3">
                    <label for="pertanyaan5" class="block text-gray-700 font-semibold mb-1">Pertanyaan 5</label>
                    <input type="text" class="form-control w-full border border-gray-300 p-2 rounded-md" id="pertanyaan5" name="pertanyaan5" placeholder="Masukkan Pertanyaan 5" />
                </div>
                <div class="mb-3">
                    <label for="saran_masukan" class="block text-gray-700 font-semibold mb-1">Saran dan Masukan</label>
                    <textarea class="form-control w-full border border-gray-300 p-2 rounded-md" id="saran_masukan" name="saran_masukan" placeholder="Masukkan Saran dan Masukan" rows="4"></textarea>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md">Kirim Pesan</button>
            </form>
        </div>
        <div class="md:w-1/2 hidden md:block right-image rounded-md"></div>
    </div>
</body>

</html>