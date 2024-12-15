<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapan Absensi Harian</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .filter-container {
            text-align: center;
            margin-bottom: 20px;
        }
        select {
            padding: 10px;
            margin: 0 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s;
        }
        select:focus {
            border-color: #4CAF50;
            outline: none;
        }
        button {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        .stats {
            display: flex;
            justify-content: center;
            margin: 20px 0;
            font-size: 1.2em;
        }
        .stat-item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin: 0 10px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 150px;
            transition: transform 0.3s;
        }
        .stat-item:hover {
            transform: translateY(-5px);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>

    <h1>Rekapan Absensi Harian</h1>
    
    <div class="filter-container">
        <label for="month">Pilih Bulan:</label>
        <select id="month">
            <option value="1">Januari</option>
            <option value="2">Februari</option>
            <option value="3">Maret</option>
            <option value="4">April</option>
            <option value="5">Mei</option>
            <option value="6">Juni</option>
            <option value="7">Juli</option>
            <option value="8">Agustus</option>
            <option value="9">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
        </select>

        <label for="year">Pilih Tahun:</label>
        <select id="year">
            <option value="2024">2024</option>
            <option value="2023">2023</option>
            <option value="2022">2022</option>
            <!-- Tambahkan tahun lainnya sesuai kebutuhan -->
        </select>

        <button onclick="filterAbsensi()">Tampilkan Absensi</button>
    </div>

    <div class="stats" id="stats">
        <!-- Statistik kehadiran akan ditampilkan di sini -->
    </div>

    <table id="absensiTable">
        <thead>
            <tr>
                <th>ID Absen</th>
                <th>Status Kehadiran</th>
                <th>Waktu Absen</th>
                <th>Keterangan</th>
                <th>Jenis Absen</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data absensi akan ditampilkan di sini -->
        </tbody>
    </table>

    <div class="footer">
        <p>&copy; 2024 Asrama Anda. Semua hak dilindungi.</p>
    </div>

    <script>
        const absensiData = [
            { id_absen: 1, status_kehadiran: 'Hadir', waktu_absen: '2024-12-01 08:00:00', keterangan: '-', jenis_absen: 'Absen Harian' },
            { id_absen: 2, status_kehadiran: 'Tidak Hadir', waktu_absen: '2024-12-02 00:00:00', keterangan: 'Sakit', jenis_absen: 'Absen Harian' },
            { id_absen: 3, status_kehadiran: 'Izin', waktu_absen: '2024-12-03 08:15:00', keterangan: 'Acara Keluarga', jenis_absen: 'Absen Harian' },
            { id_absen: 4, status_kehadiran: 'Sakit', waktu_absen: '2024-12-04 00:00:00', keterangan: 'Demam', jenis_absen: 'Absen Harian' },
            { id_absen: 5, status_kehadiran: 'Hadir', waktu_absen: '2024-11-30 08:00:00', keterangan: '-', jenis_absen: 'Absen Harian' },
            { id_absen: 6, status_kehadiran: 'Hadir', waktu_absen: '2024-11-29 08:00:00', keterangan: '-', jenis_absen: 'Absen Harian' },
            // Tambahkan data absensi lainnya sesuai kebutuhan
        ];

        function filterAbsensi() {
            const month = document.getElementById('month').value;
            const year = document.getElementById('year').value;
            const filteredData = absensiData.filter(item => {
                const date = new Date(item.waktu_absen);
                return date.getMonth() + 1 == month && date.getFullYear() == year;
            });
            displayAbsensi(filteredData);
            displayStats(filteredData);
        }

        function displayAbsensi(data) {
            const tbody = document.querySelector('#absensiTable tbody');
            tbody.innerHTML = ''; // Clear previous data
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5">Tidak ada data absensi untuk bulan dan tahun yang dipilih.</td></tr>';
                return;
            }
            data.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.id_absen}</td>
                    <td>${item.status_kehadiran}</td>
                    <td>${new Date(item.waktu_absen).toLocaleString('id-ID')}</td>
                    <td>${item.keterangan}</td>
                    <td>${item.jenis_absen}</td>
                `;
                tbody.appendChild(row);
            });
        }

        function displayStats(data) {
            const statsDiv = document.getElementById('stats');
            const hadirCount = data.filter(item => item.status_kehadiran === 'Hadir').length;
            const izinCount = data.filter(item => item.status_kehadiran === 'Izin').length;
            const sakitCount = data.filter(item => item.status_kehadiran === 'Sakit').length;

            statsDiv.innerHTML = `
                <div class="stat-item">
                    <strong>Jumlah Kehadiran:</strong><br>
                    ${hadirCount}
                </div>
                <div class="stat-item">
                    <strong>Jumlah Izin:</strong><br>
                    ${izinCount}
                </div>
                <div class="stat-item">
                    <strong>Jumlah Sakit:</strong><br>
                    ${sakitCount}
                </div>
            `;
        }
    </script>

</body>
</html>
