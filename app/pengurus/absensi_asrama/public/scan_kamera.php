<?php 
// Pengkondisian PHP yang salah; tidak diperlukan kode ini di dalam HTML
// INSERT INTO `absensi` (`id_absen`, `id_kegiatan`, `nim`, `id_extra`, `nim_pengurus`, `status_kehadiran`, `waktu_absen`, `jenis_absen`, `keterangan`, `sholat`) VALUES ('2', NULL, '22041110001', NULL, '220411100020', NULL, current_timestamp(), 'Harian', NULL, 'Maghrib');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HTML QR Code Demo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="html5-qrcode.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-6 max-w-md w-full">
        <h1 class="text-2xl font-bold mb-4 text-center text-gray-800">
            QR Code Scanner
        </h1>
        <div id="qr-reader" class="w-full mb-4 border border-gray-300 rounded-lg"></div>
        <div id="qr-reader-results" class="text-gray-600 text-sm mb-4"></div>

        <!-- Tombol Kembali -->
        <div class="text-center">
            <a href="absensi_harian.php" class="inline-block px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600">
                Kembali
            </a>
        </div>
    </div>

    <script>
    function docReady(fn) {
        if (document.readyState === "complete" || document.readyState === "interactive") {
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    docReady(function () {
        var resultContainer = document.getElementById("qr-reader-results");
        var lastResult, countResults = 0;

        // Fungsi untuk mengirim data ke server
        function sendDataToServer(nim, status, date, time, sholat) {
            fetch('insert_absen.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ nim, status, date, time, sholat }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    resultContainer.innerHTML += `<p class="text-green-600">Data berhasil dimasukkan</p>`;
                } else {
                    resultContainer.innerHTML += `<p class="text-red-600">Error: ${data.message}</p>`;
                }
            })
            .catch(error => {
                resultContainer.innerHTML += `<p class="text-red-600">Error: ${error.message}</p>`;
            });
        }

        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;

                // Mendapatkan waktu saat ini
                const currentDate = new Date();
                const formattedDate = currentDate.toLocaleDateString("en-CA"); // Format YYYY-MM-DD
                const formattedTime = currentDate.toLocaleTimeString("en-GB"); // Format HH:MM:SS
                const status = "hadir";
                const sholat = "maghrib";

                resultContainer.innerHTML = `${decodedText}<br> ${formattedDate} <br> ${formattedTime} <br> ${status} <br> ${sholat} <br>`;

                // Kirim data ke server
                sendDataToServer(decodedText, status, formattedDate, formattedTime, sholat);
            }
        }

        var html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", {
            fps: 10,
            qrbox: 250,
        });
        html5QrcodeScanner.render(onScanSuccess);
    });
    </script>
</body>
</html>
