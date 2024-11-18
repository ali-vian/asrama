<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formulir Kepuasan</title>
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
            const formData = new FormData(document.getElementById("kepuasanForm"));

            fetch("submit.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        document.getElementById("kepuasanForm").reset();
                    }
                })
                .catch(error => console.error("Error:", error));
        }
    </script>
</head>

<body class="bg-gray-100">
    <!-- Navbar Section with Logo and Title -->
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
            <h2 class="text-5xl font-bold mb-5 pt-3">Formulir Kepuasan</h2>
            <p class="text-gray-600 mb-4">Berikan penilaian dan masukan kepada kami untuk peningkatan layanan</p>
            <form id="kepuasanForm" onsubmit="checkNIM(event)">
                <div class="mb-3">
                    <label for="nim" class="block text-gray-700 font-semibold mb-1">NIM <span class="text-red-500">*</span></label>
                    <input type="text" class="form-control w-full border border-gray-300 p-2 rounded-md" id="nim" name="nim" placeholder="Masukkan NIM" required />
                </div>
                <div class="mb-3">
                    <label for="pesan" class="block text-gray-700 font-semibold mb-1">Pesan <span class="text-red-500">*</span></label>
                    <textarea class="form-control w-full border border-gray-300 p-2 rounded-md" id="pesan" name="pesan" placeholder="Masukkan Pesan" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="kategori" class="block text-gray-700 font-semibold mb-1">Kategori <span class="text-red-500">*</span></label>
                    <select class="form-select w-full border border-gray-300 p-2 rounded-md" id="kategori" name="kategori" required>
                        <option selected disabled>Pilih Kategori</option>
                        <option value="Akademik">Akademik</option>
                        <option value="Fasilitas">Fasilitas</option>
                        <option value="Pelayanan">Pelayanan</option>
                    </select>
                </div>
                <div class="flex items-center mb-3">
                    <input type="checkbox" class="form-check-input h-4 w-4 text-blue-600" id="confirm" required />
                    <label class="form-check-label text-gray-600 ml-2" for="confirm">Apakah kamu yakin mengirim pesan ini?</label>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md">Kirim Pesan</button>
            </form>
        </div>
        <div class="md:w-1/2 hidden md:block right-image rounded-md"></div>
    </div>
</body>

</html>