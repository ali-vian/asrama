<?php
include "koneksi.php";

session_start(); // Memulai session

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'pengurus') {
        header('Location: app/pengurus/');
    } else if ($_SESSION['role'] === 'warga') {
        header('Location: app/warga/');
    } else {
        header('Location: app/ketua/');
    }
}

// Mengambil data dari form login
$error = ''; // Inisialisasi variabel error
$success = false; // Inisialisasi variabel sukses
$nama_pengurus = ''; // Inisialisasi variabel nama pengurus
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk mencari user di database dengan prepared statement
    $queryPengurus = "SELECT * FROM pengurus WHERE email_pengurus=? AND password_pengurus=MD5(?) AND divisi_pengurus='Pengurus Harian'"; // Assuming passwords are stored in plain text
    $stmtPengurus = $conn->prepare($queryPengurus);
    $stmtPengurus->bind_param("ss", $email, $password);
    $stmtPengurus->execute();
    $resultPengurus = $stmtPengurus->get_result();

    if ($resultPengurus->num_rows == 1) {
        // Login berhasil
        $success = true; // Set variabel sukses
        $data = $resultPengurus->fetch_assoc(); // Ambil data pengurus
        $_SESSION['nama'] = $data['nama_pengurus']; // Simpan nama pengurus
        $_SESSION['email'] = $data['email_pengurus']; // Simpan email pengurus ke session
        $_SESSION['nim'] = $data['nim_pengurus']; // Simpan nim pengurus ke session
        $_SESSION['role'] = 'ketua'; // Simpan role pengurus ke session 
        // Mengarahkan ke ketua di JavaScript
        header("Location: app/ketua/");

    } else {
        // Login gagal
        $error = 'Periksa kembali email dan password.';
    }

    // Menutup statement
    $stmtPengurus->close();
}

// Menutup koneksi database
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Asrama</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        .login-container img {
            width: 100px;
            margin-bottom: 20px;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 15px;
            background-image: linear-gradient(to right, #ff007f, #a001ff);
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        input[type="submit"]:hover {
            background-image: linear-gradient(to right, #ff007f, #8b00e6);
        }
        .remember {
            display: flex;
            align-items: center;
            width: 100%;
        }
        .remember input {
            margin-right: 10px;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <script>
            // Cek jika login berhasil
            <?php if ($success) { ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Login berhasil!',
                    text: 'Selamat datang, <?php echo $nama_pengurus; ?>!',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.href = 'app/ketua/dashboard.php'; // Redirect setelah alert ditutup
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
        <img src="assets/logo2.png" alt="Logo Asrama"> <!-- Ganti dengan path logo Anda -->
        <form action="loginadmin.php" method="POST">
            <input type="email" name="email" placeholder="student@student.trunojoyo.ac.id" required>
            <input type="password" name="password" placeholder="********" required>
            <div class="remember">
                <input type="checkbox" name="remember"> Simpan Informasi login saya
            </div>
            <input type="submit" name="login" value="MASUK">
        </form>
    </div>
</body>
</html>
