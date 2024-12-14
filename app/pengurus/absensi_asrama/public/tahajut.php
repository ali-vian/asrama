<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "asrama";
$koneksi = mysqli_connect($host, $username, $password, $database);

// Pastikan koneksi berhasil
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$query ="SELECT nama,waktu_absen,warga.nim,kamar,nama_pengurus,keterangan,jenis_absen,sholat,status_kehadiran,id_absen 
        FROM absensi 
        INNER JOIN warga ON absensi.nim=warga.nim
        INNER JOIN pengurus ON warga.nim_pengurus=pengurus.nim_pengurus";
$hasil = mysqli_query($koneksi, $query);
// Cek apakah query berhasil dijalankan
if (!$hasil) {
    die("Error pada query: " . mysqli_error($koneksi));
}

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard - Absensi</title>
    <link href="./css/output.css" rel="stylesheet" />
  </head>
  <body class="bg-gray-200 font-sans leading-normal tracking-normal">
    <!-- Sidebar -->
    <div class="flex">
      <aside
        class="w-64 bg-white text-black min-h-screen fixed h-full stroke-black"
      >
        <div class="p-6">
          <img class="h-24" src="../img/asrama utm (1).png" alt="asrama" />
          <nav class="mt-8 space-y-2">
            <a href="absensi_harian.php" class="block py-2.5 px-4 rounded hover:bg-gray-700"
              >Jamaah Wajib</a
            >
            <a
              href="liqoan.php"
              class="block py-2.5 px-4 rounded hover:bg-gray-700"
              >Liqoan</a
            >
            <a
              href="tahajud.#"
              class="block py-2.5 px-4 rounded hover:bg-gray-700"
              >Tahajud</a
            >
            <a
              href="kajian.php"
              class="block py-2.5 px-4 rounded hover:bg-gray-700"
              >Kajian</a
            >
            <a
              href="index.html"
              class="block py-2.5 px-4 rounded bg-red-700 text-white hover:bg-red-500"
              >Kembali</a
            >
          </nav>
        </div>
      </aside>

      <!-- Main Content -->
      <div class="flex-1 ml-64 p-6 overflow-scroll h-screen">
        <!-- Header -->
        <header class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-semibold text-gray-800">Absensi Harian Warga Asrama UTM</h2>
          <div class="flex items-center">
            <span class="mr-4">Admin</span>
            <img
              class="w-10 h-10 rounded-full"
              src="https://via.placeholder.com/40"
              alt="profile photo"
            />
          </div>
        </header>

        <!-- Action Buttons -->
        <div class="flex space-x-6 mb-4"> <!-- Ubah space-x-4 menjadi space-x-6 -->
          <button
            onclick="printPDF()"
            class="bg-red-500 text-white px-4 py-2 rounded"
          >
            Cetak PDF
          </button>
          <button
            onclick="exportToExcel()"
            class="bg-green-500 text-white px-4 py-2 rounded"
          >
            Cetak Excel
          </button>
          <a
            href="scan_kamera.php"
            class="bg-blue-500 text-white px-4 py-2 rounded flex items-center hover:bg-blue-600"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-5 h-5 mr-2"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M3 5h2v14H3V5zm4 0h1v14H7V5zm4 0h2v14h-2V5zm5 0h1v14h-1V5zm4 0h2v14h-2V5z"
              />
            </svg>
            Scan Barcode
          </a>
        </div>
        <!-- Attendance Table for Each Prayer -->
        <div class="pdf_magrib bg-white p-6 rounded-lg shadow-lg mb-10">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold text-gray-800">Tahajud</h3>
            <input
              type="text"
              placeholder="Cari..."
              class="border border-gray-300 rounded px-3 py-1 text-gray-700 focus:outline-none focus:border-blue-500"
            />
          </div>
          <table class="min-w-full bg-white border">
            <thead>
              <tr>
                <th class="py-2 px-3 bg-gray-200">Date</th>
                <th class="py-2 px-3 bg-gray-200">Nama</th>
                <th class="py-2 px-3 bg-gray-200">NIM</th>
                <th class="py-2 px-3 bg-gray-200">Nomor Kamar</th>
                <th class="py-2 px-3 bg-gray-200">Pendamping</th>
                <th class="py-2 px-3 bg-gray-200">Absensi</th>
                <th class="py-2 px-3 bg-gray-200">Tahajud</th>
                <th class="py-2 px-3 bg-gray-200">Status</th>
                <th class="py-2 px-3 bg-gray-200">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>
                  <tr class="border-b border-gray-200 hover:bg-gray-100">
                      <td class="py-2 px-4">
                      <?php if ($row['waktu_absen'] != "0000-00-00 00:00:00") {?>
                        <?php echo $row['waktu_absen'] ?>
                        <?php } else { ?>
                          <span class="text-red-700 bg-red-200 rounded-full px-3 py-1 text-xs font-semibold">00000</span>
                        <?php } ?>
                      </td>
                      <td class="py-2 px-4"><?= $row['nama']; ?></td>
                      <td class="py-2 px-4"><?= $row['nim']; ?></td>
                      <td class="py-2 px-4"><?= $row['kamar']; ?></td>
                      <td class="py-2 px-4"><?= $row['nama_pengurus']; ?></td>
                      <td class="py-2 px-4"><?= $row['jenis_absen']; ?></td>
                      <td class="py-2 px-4">
                        <?php if ($row['keterangan'] == 'maghrib') {?>
                          Maghrib
                        <?php } elseif ($row['keterangan'] == 'isya') { ?>
                          Isya
                        <?php } elseif ($row['keterangan'] == 'shubuh') { ?>
                          Shubuh
                        <?php } elseif ($row['keterangan'] == 'liqoan') { ?>
                          Liqoan
                        <?php } elseif ($row['keterangan'] == 'kajian') { ?>
                          Kajian
                        <?php } elseif ($row['keterangan'] == 'tahajut') { ?>
                          Tahajut
                        <?php } elseif ($row['keterangan'] == 'alpha') { ?>
                          <span class="text-red-700 bg-red-200 rounded-full px-3 py-1 text-xs font-semibold">SholatTidakTerdeteksi</span>
                        <?php } else { ?>
                          <span class="text-red-700 bg-red-200 rounded-full px-3 py-1 text-xs font-semibold">SholatTidakTerdeteksi</span>
                        <?php } ?>
                      </td>
                      <td class="py-2 px-4">
                      <?php if ($row['status_kehadiran'] == 'hadir') { ?>
                          <span class="text-green-700 bg-green-200 rounded-full px-3 py-1 text-xs font-semibold">Hadir</span>
                      <?php } elseif ($row['status_kehadiran'] == 'sakit') { ?>
                          <span class="text-yellow-700 bg-yellow-400 rounded-full px-3 py-1 text-xs font-semibold">Sakit</span>
                      <?php } elseif ($row['status_kehadiran'] == 'izin') { ?>
                        <span class="text-blue-700 bg-blue-200 rounded-full px-3 py-1 text-xs font-semibold">Izin</span>
                      <?php } elseif ($row['status_kehadiran'] == 'alpha') { ?>
                        <span class="text-red-700 bg-red-200 rounded-full px-3 py-1 text-xs font-semibold">Alpha</span>
                      <?php } else { ?>
                        <span class="text-red-700 bg-red-200 rounded-full px-3 py-1 text-xs font-semibold">Alpha</span>
                      <?php } ?>

                      </td>
                      <td class="py-2 px-4">
                          <a href="edit.php?id_absen=<?= $row['id_absen']; ?>" class="text-blue-500 hover:underline">Edit</a>
                      </td>
                     
                  </tr>
              <?php } ?>
          </tbody>

          </table>
        </div>
      </div>
    </div>
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script>
      function printPDF() {
        const element = document.querySelector(".pdf_magrib");
        html2pdf()
          .set({
            margin: 0.5,
            filename: "Sholat_Maghrib_Report.pdf",
            image: { type: "jpeg", quality: 0.98 },
            html2canvas: { scale: 3 },
            jsPDF: { unit: "in", format: "A4", orientation: "landscape" },
          })
          .from(element)
          .save();
      }

      function exportToExcel() {
        const table = document.querySelector(".pdf_magrib");
        const workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
        XLSX.writeFile(workbook, "Sholat_Maghrib_Report.xlsx");
      }
    </script>
  </body>
</html>
