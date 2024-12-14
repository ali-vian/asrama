<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "asrama";
$koneksi = mysqli_connect($host, $username, $password, $database);
// Query untuk mendapatkan SEMUA DATA DI TABEL WARGA,ASEN,DAN PENGURUS
$query = "SELECT nama, waktu_absen, warga.nim, kamar, nama_pengurus, keterangan, jenis_absen, status_kehadiran, id_absen
          FROM absensi 
          INNER JOIN warga ON absensi.nim = warga.nim 
          INNER JOIN pengurus ON warga.nim_pengurus = pengurus.nim_pengurus";
$result=mysqli_query($koneksi,$query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded shadow-lg">
        <form action="" method="POST">
            <div class="mb-4">
                <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                <select name="nim" id="nim" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Pilih NIM</option>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <option value="<?= $row['nim'] ?>"><?= $row['nim'] ?> - <?= $row['nama'] ?> - <?= $row['kamar'] ?> - <?= $row['nama_pengurus'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <select name="nama" id="nama" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" disabled>
                    <!-- Nama diisi otomatis berdasarkan pilihan NIM -->
                </select>
            </div>

            <div class="mb-4">
                <label for="kamar" class="block text-sm font-medium text-gray-700">Nomor Kamar</label>
                <select name="kamar" id="kamar" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" disabled>
                    <!-- Nomor kamar diisi otomatis berdasarkan pilihan NIM -->
                </select>
            </div>

            <div class="mb-4">
                <label for="nama_pengurus" class="block text-sm font-medium text-gray-700">Pendamping</label>
                <select name="nama_pengurus" id="nama_pengurus" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" disabled>
                    <!-- Nama pengurus diisi otomatis berdasarkan pilihan NIM -->
                </select>
            </div>

            <div class="flex justify-between">
                <input type="submit" value="Submit" name="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                <input type="reset" value="Batal" class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500">
            </div>
        </form>
    </div>

    <script>
        const nimSelect = document.getElementById('nim');
        const namaSelect = document.getElementById('nama');
        const kamarSelect = document.getElementById('kamar');
        const nama_pengurusSelect = document.getElementById('nama_pengurus');

        nimSelect.addEventListener('change', () => {
            const selectedOption = nimSelect.options[nimSelect.selectedIndex];
            if (selectedOption.value) {
                // Ambil data nama, nomor kamar, dan nama pengurus
                const [nim, nama, kamar, nama_pengurus] = selectedOption.text.split(' - ');
                namaSelect.innerHTML = `<option>${nama}</option>`;
                kamarSelect.innerHTML = `<option>${kamar}</option>`;
                nama_pengurusSelect.innerHTML = `<option>${nama_pengurus}</option>`;
                namaSelect.disabled = false;
                kamarSelect.disabled = false;
                nama_pengurusSelect.disabled = false;
            } else {
                namaSelect.innerHTML = `<option value="">Pilih NIM terlebih dahulu</option>`;
                kamarSelect.innerHTML = `<option value="">Pilih NIM terlebih dahulu</option>`;
                nama_pengurusSelect.innerHTML = `<option value="">Pilih NIM terlebih dahulu</option>`;
                namaSelect.disabled = true;
                kamarSelect.disabled = true;
                nama_pengurusSelect.disabled = true;
            }
        });
    </script>
</body>
</html>
