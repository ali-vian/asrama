<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "asrama";
$koneksi = mysqli_connect($host, $username, $password, $database);

$id_absen =$_GET['id_absen'];
$query ="SELECT * FROM absensi WHERE id_absen =$id_absen";
$result = mysqli_query($koneksi,$query);

if (isset($_POST['submit'])) {
    $NIM = $_POST['nim'];
    $sholat = $_POST['keterangan'];
    $status = $_POST['status_kehadiran'];
    $date = $_POST['date'];

    $update = "UPDATE absensi SET 
    nim = '$NIM',
    waktu_absen = '$date',
    status_kehadiran = '$status',
    keterangan = '$sholat'
    WHERE id_absen = '$id_absen'"; // Tambahkan kondisi WHERE untuk menghindari update semua data.

    $hasil = mysqli_query($koneksi, $update);
    if ($hasil) {
        header("Location: absensi_harian.php");
    } else {
        echo "Data gagal diubah";
    }
}

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded shadow-lg">
        <?php 
        while ($row = mysqli_fetch_assoc($result)):
        ?>
        <form action="" method="POST">
            <div class="mb-4">
                <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                <input type="text" name="nim" value="<?= $row['nim'] ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            
            <div class="mb-4">
                <label for="keterangan" class="block text-sm font-medium text-gray-700">Sholat</label>
                <select name="keterangan" id="keterangan" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="maghrib" <?= $row['keterangan'] == 'maghrib' ? 'selected' : '' ?>>Maghrib</option>
                    <option value="isya" <?= $row['keterangan'] == 'isya' ? 'selected' : '' ?>>Isya</option>
                    <option value="shubuh" <?= $row['keterangan'] == 'shubuh' ? 'selected' : '' ?>>Shubuh</option>
                    <option value="liqoan" <?= $row['keterangan'] == 'liqoan' ? 'selected' : '' ?>>Liqoan</option>
                    <option value="kajian" <?= $row['keterangan'] == 'kajian' ? 'selected' : '' ?>>Kajian</option>
                    <option value="tahajut" <?= $row['keterangan'] == 'tahajut' ? 'selected' : '' ?>>Tahajut</option>
                    <option value="alpha" <?= $row['keterangan'] == 'alpha' ? 'selected' : '' ?>>Alpha</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="status_kehadiran" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status_kehadiran" id="status_kehadiran" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="hadir" <?= $row['status_kehadiran'] == 'hadir' ? 'selected' : '' ?>>Hadir</option>
                    <option value="izin" <?= $row['status_kehadiran'] == 'izin' ? 'selected' : '' ?>>Izin</option>
                    <option value="sakit" <?= $row['status_kehadiran'] == 'sakit' ? 'selected' : '' ?>>Sakit</option>
                    <option value="alpha" <?= $row['status_kehadiran'] == 'alpha' ? 'selected' : '' ?>>Alpha</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                <input type="datetime-local" name="date" id="date" value="<?= date('Y-m-d\TH:i') ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="flex justify-between">
                <input type="submit" value="Submit" name="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                <input type="reset" value="Batal" class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500">
            </div>
        </form>
        <?php endwhile; ?>
    </div>
</body>
</html>
