<?php
$koneksi = mysqli_connect("localhost", "root", "", "asrama");

$query = "SELECT * FROM formulir_kepuasan";

if (isset($_GET['keyword'])) {
  $keyword = $_GET['keyword'];
  // Menambahkan operator LIKE yang benar pada setiap kolom
  $query .= " WHERE id_formulir LIKE '%$keyword%' OR nim LIKE '%$keyword%' OR pesan LIKE '%$keyword%' OR created_at LIKE '%$keyword%' OR kategori LIKE '%$keyword%'";
  $key = "keyword=$keyword&";
} else {
  $key = '';
}

$showData = isset($_GET['show']) ? (int)$_GET['show'] : ($_SESSION['show'] ?? 5);

if (isset($_GET['destroy'])) {
    $showData = 5;
    unset($_SESSION['show']);
} else {
    $_SESSION['show'] = $showData;
}

$nowPage = (isset($_GET['page'])) ? (int)$_GET['page'] : 1 ;

if (isset($_GET['sort'])){
  $sorts = $_GET['sort'];
  $urut = "sort=$_GET[sort]&";

  if ($_GET['sort'] == 'nim'){
      $sort = "ORDER BY nim";
  }else if ($_GET['sort'] == 'kategori'){
      $sort = "ORDER BY kategori";
  }else if ($_GET['sort'] == 'created_at'){
      $sort = "ORDER BY created_at";
  }else if ($_GET['sort'] == 'pesan'){
      $sort = "ORDER BY pesan";
  }
}else{
  $sorts = '';
  $sort = '';
  $urut = '';
}

if (isset($_GET['page'])){
  $dataAwal = ($nowPage*$showData)-$showData;
  $take = mysqli_query($koneksi, "$query $sort LIMIT $dataAwal, $showData");
}else{
  $dataAwal = (1*$showData)-$showData;
  $take = mysqli_query($koneksi, "$query $sort LIMIT $dataAwal, $showData");
}

$resultCount = mysqli_num_rows($take);

$maxShow = ceil(mysqli_num_rows(mysqli_query($koneksi, $query))/$showData);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aspirasi Kepuasan Warga Asrama</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
    }
    .content {
      padding: 10px;
      max-width: 1500px;
      margin: auto;
    }
    .table-container {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }
    .entries,
    .search-form-container {
      margin-bottom: 10px;
    }
    .search-form-container {
      display: flex;
      justify-content: flex-end; /* Menyesuaikan posisi form di sebelah kanan */
      margin-top: 0px; /* Jika ingin lebih dekat ke bagian entries */
    }
    .filter-container {
      display: flex;
      align-items: center;
    }
    .filter-container form {
      display: flex;
      align-items: center;
      gap: 10px; /* Memberikan jarak antar-elemen */
    }
    .form-label {
      white-space: nowrap; /* Agar teks label tidak membungkus */
    }
    .custom-select {
      width: auto; /* Menyesuaikan ukuran dropdown */
    }
    .table thead th {
      border-bottom: 2px solid #f0f0f0;
      padding: 20px;
      text-align: center;
    }
    .table tbody tr {
      border-top: 1px solid #f0f0f0;
      padding: 15px;
      text-align: center;
    }
    .table td, .table th {
      vertical-align: middle;
      padding: 15px;
    }
    .entries {
      display: flex;
      align-items: center;
      gap: 5px;
      margin-bottom: 10px;
    }
    .header-border {
      border-top: 1px solid #333;
      margin-top: 10px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <div class="content">
    <h2>Aspirasi Kepuasan Warga Asrama</h2>
    <div class="header-border"></div>
    
    <div class="entries-container d-flex justify-content-between align-items-center">
      <!-- Entries Selector -->
      <div class="entries d-flex align-items-center">
          <label for="entriesSelect" class="mb-0 mr-2">Show</label>
          <select id="entriesSelect" class="custom-select custom-select-sm mx-2" style="width: auto;" onchange="location = this.value;">
              <?php for ($i = 5; $i <= 25; $i+=5) : ?>
                  <option value="?show=<?= $i ?>" <?= (isset($_GET['show']) && $_GET['show'] == $i) ? 'selected' : '' ?>><?= $i ?></option>
              <?php endfor; ?>
          </select>
          <span>entries</span>
      </div>

      <!-- Form Pencarian -->
      <div class="search-form-container">
        <form action="" method="get" class="d-flex">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search.." name="keyword">
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
          </div>
        </form>
      </div>
    </div>

    <!-- Table Container -->
    <div class="table-container">
      <table class="table">
        <thead>
          <tr>
            <th>No</th>
            <th><a href="?<?=$key?>sort=nim" <?=($sorts == 'nim') ? "style='textdecoration: none;'" : "style='color: inherit; text-decoration: none;'"?>>Nim</a></th>
            <th><a href="?<?=$key?>sort=kategori" <?=($sorts == 'kategori') ? "style='textdecoration: none;'" : "style='color: inherit; text-decoration: none;'"?>>Kategori</a></th>
            <th><a href="?<?=$key?>sort=created_at" <?=($sorts == 'created_at') ? "style='textdecoration: none;'" : "style='color: inherit; text-decoration: none;'"?>>Created at</a></th>
            <th><a href="?<?=$key?>sort=pesan" <?=($sorts == 'pesan') ? "style='textdecoration: none;'" : "style='color: inherit; text-decoration: none;'"?>>Aspirasi</a></th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $num = 1;
        if ($resultCount > 0) :
          while ($show = mysqli_fetch_array($take)) :
        ?>
          <tr>
            <td><?= $num; ?></td>
            <td><?= $show['nim']; ?></td>
            <td><?= $show['kategori']; ?></td>
            <td><?= $show['created_at']; ?></td>
            <td><?= substr($show['pesan'], 0, 35) . (strlen($show['pesan']) > 35 ? "..." : ""); ?></td>
            <td>
              <a href="detailaspirasi.php?id_formulir=<?= $show['id_formulir']; ?>" class="btn btn-primary"><i class="fa fa-eye"></i>Detail</a>
              <a href="javascript:void(id=<?=$show['id_formulir'];?>);" onclick="hapus(<?= $show['id_formulir']; ?>)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
            </td>
          </tr>
          <?php $num++; endwhile; else : ?>
          <tr>
              <td colspan="6" class="text-center">Tidak ada data yang sesuai dengan pencarian Anda</td>
          </tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
    <nav aria-label="dataPages">
        <ul class="pagination justify-content-center">
            <?php if ($nowPage != 1) :?>
            <li class="page-item">
                <a class="page-link" href="?<?=$key.$urut?>page=<?=$nowPage-1?>&show=<?=$showData?>">Previous</a>
            </li>
            <?php endif; ?>
            
            <?php for($i = 1; $i <= $maxShow; $i++) : ?>
            <li class="page-item <?= ($nowPage == $i) ? 'active' : '' ?>">
                <a class="page-link" href="?<?=$key.$urut?>page=<?=$i?>&show=<?=$showData?>"><?=$i?></a>
            </li>
            <?php endfor; ?>
            
            <?php if ($nowPage != $maxShow) :?>
            <li class="page-item">
                <a class="page-link" href="?<?=$key.$urut?>page=<?=$nowPage+1?>&show=<?=$showData?>">Next</a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
  </div>
  <script>
      function hapus(id) {
          if (confirm("Anda yakin akan menghapus data ini?")) {
              window.location = "hapus.php?id=" + id;
          }
      }
  </script>
</body>
</html>