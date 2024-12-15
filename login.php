<?php
session_start();
include "koneksi.php";

$error = '';
$success = false;
$userRole = '';
$nama_pengguna = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Login untuk pengurus
    $queryPengurus = "SELECT * FROM pengurus WHERE email_pengurus=? AND password_pengurus=?";
    $stmtPengurus = $conn->prepare($queryPengurus);
    $stmtPengurus->bind_param("ss", $email, $password);
    $stmtPengurus->execute();
    $resultPengurus = $stmtPengurus->get_result();

    if ($resultPengurus->num_rows == 1) {
        $data = $resultPengurus->fetch_assoc();
        $_SESSION['role'] = 'pengurus'; // Simpan role
        $_SESSION['nama'] = $data['nama_pengurus']; // Nama pengguna
        $_SESSION['id'] = $data['id_pengurus']; // ID pengurus
        $success = true;
        $userRole = 'pengurus';
    } else {
        // Login untuk warga
        $queryWarga = "SELECT * FROM warga WHERE email=? AND password=?";
        $stmtWarga = $conn->prepare($queryWarga);
        $stmtWarga->bind_param("ss", $email, $password);
        $stmtWarga->execute();
        $resultWarga = $stmtWarga->get_result();

        if ($resultWarga->num_rows == 1) {
            $data = $resultWarga->fetch_assoc();
            $_SESSION['role'] = 'warga';
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['nim'] = $data['nim']; // Simpan NIM
            $success = true;
            $userRole = 'warga';
        } else {
            $error = 'Periksa kembali email dan password.';
        }
        $stmtWarga->close();
    }

    $stmtPengurus->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="./assets/css/stylelogin.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container" id="container">
    <div class="form-container register-container">
        <script>
            // Cek jika login berhasil
            <?php if ($success) { ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Login berhasil!',
                    text: 'Selamat datang, <?php echo $nama_pengguna; ?>!',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.href = '<?php echo $userRole === "pengurus" ? "app/pengurus/dashboard.php" : "app/warga/dashboard.php"; ?>';
                });
            <?php } ?>

            // Cek jika ada error
            <?php if (!empty($error)) { ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Login gagal!',
                    text: '<?php echo $error; ?>',
                    confirmButtonText: 'OK'
                });
            <?php } ?>
        </script>
        <form action="login.php" method="POST">
            <img src="assets/logo2.png" alt="Logo Asrama" class="logo">
            <h1>Login Pengurus</h1>
            <div class="form-control">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="student@student.trunojoyo.ac.id" required>
                <small id="email-error"></small>
                <span></span>
            </div>
            <div class="form-control">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" placeholder="********" required />
                <small id="password-error"></small>
                <span></span>
            </div>
            <div class="content">
                <div class="checkbox">
                    <input type="checkbox" name="checkbox" id="checkbox" />
                    <label for="">Simpan Informasi Saya</label>
                </div>
            </div>
            <button type="submit" value="submit">Login</button>
        </form>
    </div>

    <div class="form-container login-container">
        <form action="login.php" method="POST">
            <img src="assets/logo2.png" alt="Logo Asrama" class="logo" />
            <h1>Login Warga</h1>
            <div class="form-control">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="student@student.trunojoyo.ac.id" required />
            </div>
            <div class="form-control">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" placeholder="********" required />
            </div>
            <div class="content">
                <div class="checkbox">
                    <input type="checkbox" name="checkbox" id="checkbox" />
                    <label for="checkbox">Simpan Informasi Saya</label>
                </div>
            </div>
            <button type="submit" value="submit">Login</button>
        </form>
    </div>

    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1 class="title">Masuk ke Dashboard <br />Pengurus</h1>
                <p>Silahkan masukan email dan password anda yang sudah ada untuk masuk ke tampilan dashboard pengurus</p>
                <button class="ghost" id="login">Login Warga<i class="fa-solid fa-arrow-left"></i></button>
            </div>

            <div class="overlay-panel overlay-right">
                <h1 class="title">Masuk ke Dashboard <br />Warga</h1>
                <p>Silahkan masukan email dan password anda yang sudah ada untuk masuk ke tampilan dashboard warga</p>
                <button class="ghost" id="register">Login Pengurus<i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
    </div>
</div>
<script src="./assets/js/scriptlogin.js"></script>
</body>
</html>
