<?php
include 'db.php';

// Ambil kegiatan dari database
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../../assets/js/rekap-absensi.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Manrope' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/bar-ketua.css">
    <link rel="stylesheet" href="../../assets/css/rekap-absensi.css">
    <link rel="stylesheet" href="../../assets/css/style_penghuni.css">

    <style>
        body {
            font-family: "Manrope", sans-serif;
            margin: 0;
            padding: 0;
        }

        .container-fluid {
            display: flex;
            min-height: 100vh;
            padding-left: 0;
        }

        /* Sidebar Style */
        .sidebar {
            width: 250px;
            background-color: #f8f8f8;
            padding: 20px;
            border-right: 1px solid #e0e0e0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 100;
        }

        .sidebar img {
            width: 100%;
            margin-bottom: 20px;
        }

        .side-container {
            display: flex;
            flex-direction: column;
        }

        .side-button {
            display: flex;
            align-items: center;
            padding: 12px;
            margin-bottom: 12px;
            text-decoration: none;
            color: #333;
            font-size: 16px;
            border-radius: 8px;
        }

        .side-button:hover {
            background-color: #ddd;
        }

        .side-button img {
            width: 20px;
            margin-right: 10px;
        }

        /* Main Content Area */
        .main-content {
            flex-grow: 1;
            margin-left: 250px;
            padding: 40px 30px;
            background-color: #f9fafb;
            min-height: 100vh;
            position: relative;
        }

        /* Header Section (Profile & Notifications) */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-section h2 {
            font-size: 2rem;
            font-weight: 600;
            margin: 0;
        }

        .profile-menu {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .profile-menu img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .profile-menu span {
            font-size: 1.1rem;
            color: #4a4a4a;
        }

        .profile-menu i {
            font-size: 1.1rem;
            color: #6366f1;
        }

        .form-container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .form-title {
            font-size: 1.8rem;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .form-label {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .form-control,
        .form-select,
        textarea {
            width: 100%;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
            margin-bottom: 15px;
        }

        .form-control:focus,
        .form-select:focus,
        textarea:focus {
            border-color: #6366f1;
        }

        .btn-submit {
            background-color: #6366f1;
            color: white;
            padding: 15px;
            width: 100%;
            border-radius: 8px;
            border: none;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        .btn-submit:hover {
            background-color: #4f46e5;
        }

        /* Highlight active menu item in sidebar */
        #menu-jejak-pendapat.active {
            background-color: #6366f1;
            color: white;
        }

        #menu-jejak-pendapat.active img {
            filter: invert(1);
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .container-fluid {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }

            .profile-menu {
                display: none;
            }

            .notification-icon {
                right: 20px;
            }
        }
    </style>
    <script>
        let questionCount = 1; // Jumlah pertanyaan awal
        const maxQuestions = 5; // Maksimal 5 pertanyaan

        // Daftar pertanyaan default
        const defaultQuestions = [
            "Secara keseluruhan, seberapa puas Anda dengan kegiatan ini?",
            "Apakah kegiatan ini memenuhi harapan Anda?",
            "Apa hal yang paling Anda sukai dari kegiatan ini?",
            "Apa yang dapat ditingkatkan dari kegiatan ini?",
            "Apakah Anda ingin berpatisipasi kalau ada kegiatan lagi?"
        ];

        function addQuestion() {
            if (questionCount < maxQuestions) {
                questionCount++;
                const container = document.getElementById("questions-container");
                const newQuestion = document.createElement("div");
                newQuestion.classList.add("mb-3");
                newQuestion.innerHTML = `
                <label for="pertanyaan${questionCount}" class="block text-gray-700 font-semibold mb-1">${defaultQuestions[questionCount - 1]}</label>
                <input type="text" class="form-control w-full border border-gray-300 p-2 rounded-md" id="pertanyaan${questionCount}" name="pertanyaan${questionCount}" placeholder="${defaultQuestions[questionCount - 1]}" />
            `;
                container.appendChild(newQuestion);

                // Jika sudah mencapai batas maksimal, nonaktifkan tombol
                if (questionCount === maxQuestions) {
                    document.getElementById("addQuestionButton").disabled = true;
                    alert("Pertanyaan maksimal sudah tercapai!");
                }
            }
        }

        function checkNIM(event) {
            event.preventDefault();
            const nim = document.getElementById("nim").value;

            fetch("././check_nim.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: "nim=" + encodeURIComponent(nim),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.exists) {
                        submitForm();
                    } else {
                        alert("NIM tidak terdaftar");
                    }
                })
                .catch((error) => console.error("Error:", error));
        }

        function submitForm() {
            const formData = new FormData(document.getElementById("kegiatanForm"));

            fetch("././submit.php", {
                    method: "POST",
                    body: formData,
                })
                .then((response) => response.json())
                .then((data) => {
                    alert(data.message);
                    if (data.success) {
                        document.getElementById("kegiatanForm").reset();
                    }
                })
                .catch((error) => console.error("Error:", error));
        }
    </script>

</head>

<body>

    <div class="container-fluid">
        <!-- Sidebar -->
        <div class="sidebar">
            <?php include 'headersidebar.php'; ?>
        </div>

        <!-- Main Content Section -->
        <div class="main-content">
            <!-- Header Section -->
            <div class="header-section">
                <div>
                    <h2>Formulir Kegiatan</h2>
                    <p>Berikan penilaian dan masukan untuk peningkatan kegiatan</p>
                </div>
            </div>

            <!-- Form Section -->
            <div class="form-container">
                <form id="kegiatanForm" onsubmit="checkNIM(event)">
                    <div class="form-title">Berikan Penilaian Kegiatan</div>

                    <label for="nim" class="form-label">NIM <span class="text-red-500">*</span></label>
                    <input type="text" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM" required />

                    <label for="id_kegiatan" class="form-label">Kegiatan <span class="text-red-500">*</span></label>
                    <select class="form-select" id="id_kegiatan" name="id_kegiatan" required>
                        <option selected disabled>Pilih Kegiatan</option>
                        <?php foreach ($kegiatan as $item): ?>
                            <option value="<?= $item['id_kegiatan']; ?>"><?= $item['nama_kegiatan']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Dynamic Questions -->
                    <div id="questions-container">
                        <div class="mb-3">
                            <label for="pertanyaan1" class="block text-gray-700 font-semibold mb-1">Secara keseluruhan, seberapa puas Anda dengan kegiatan ini?</label>
                            <input type="text" class="form-control" id="pertanyaan1" name="pertanyaan1" placeholder="Secara keseluruhan, seberapa puas Anda dengan kegiatan ini?" />
                        </div>
                    </div>

                    <button type="button" onclick="addQuestion()" class="text-blue-500">+ Tambah Pertanyaan</button>
                    <div class="mb-3">
                        <label for="saran_masukan" class="block text-gray-700 font-semibold mb-1">Saran dan Masukan</label>
                        <textarea class="form-control w-full border border-gray-300 p-2 rounded-md" id="saran_masukan" name="saran_masukan" placeholder="Masukkan Saran dan Masukan" rows="4"></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="confirm" required />
                        <label class="form-check-label" for="confirm">Apakah kamu yakin mengirim pesan ini?</label>
                    </div>

                    <button type="submit" class="btn-submit">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
