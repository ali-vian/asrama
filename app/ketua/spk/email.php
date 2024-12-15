<?php

session_start();
if (!isset($_SESSION['nim']) && !$_SESSION['role'] == 'ketua') {
    header("Location: ../../../index.php");
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



require '../../../vendor/autoload.php';

// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "asrama";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil daftar email dari database
$sql = "SELECT email,status,nama,nim,id_calon_kr FROM warga JOIN hasil_spk ON nim=id_calon_kr";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $email = $row['email'];
        $status = $row['status'];
        $nama = $row['nama'];
        $nim = $row['nim'];

        // Mengatur isi email (HTML)
        $subject = $status === 'Lulus' ? 'Selamat! Kamu dinyatakan Lolos Seleksi Warga Asrama' : 'Pengumumman Seleksi Warga Asrama';
        $messageBody = $status === 'Lulus' ?
            ' <p>
            Dengan senang hati kami sampaikan bahwa pada kesempatan kali ini, Anda
            dinyatakan <strong>Lolos</strong> sebagai Warga Asrama Universitas
            Trunojoyo Madura. Keputusan ini diambil berdasarkan pertimbangan yang
            matang dan tidak mengurangi rasa hormat kami warga asrama.
            </p>' 
            :
            ' <p>
            Dengan berat hati kami sampaikan bahwa pada kesempatan kali ini, Anda
            diyatakan <strong> Tidak Lolos </Strong> sebagai Warga Asrama Universitas Trunojoyo
            Madura. Keputusan ini diambil berdasarkan pertimbangan yang matang dan
            tidak mengurangi rasa hormat kami warga asrama.
            </p>
            <p>
            Kami sangat mengapresiasi semangat dan dedikasi Anda. Kami berharap
            Anda tidak berkecil hati dan terus mengembangkan diri. Kegagalan kali
            ini bukan akhir dari segalanya, justru menjadi motivasi untuk terus
            belajar dan meraih prestasi yang lebih baik lagi
            </p>';
        $message = '<html>
        <head>
            <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f9;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .email-container {
                width: 600px;
                background-color: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 20px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .email-header {
                text-align: center;
            }
            .email-header h2 {
                color: #333;
                font-size: 24px;
            }
            .email-body {
                margin-top: 20px;
                font-size: 16px;
                color: #555;
                line-height: 1.6;
            }
            .email-body p {
                margin: 10px 0;
            }
            .email-signature {
                margin-top: 30px;
                font-size: 16px;
                color: #333;
            }
            .contact-link {
                color: #007bff;
                text-decoration: none;
            }
            .contact-link:hover {
                text-decoration: underline;
            }
            .email-logo {
                display: flex;
                justify-content: center;
                margin-bottom: 20px;
            }
            .email-logo img {
                max-width: 100px;
            }
            </style>
        </head>
        <body>
            <div class="email-container">
            <div class="email-logo" style="text-align: center;">
                <img
                src="https://asrama.trunojoyo.ac.id/wp-content/uploads/2024/07/cropped-asrama-utm-logo.png"
                width="100px"
                style="display: block; margin: 0 auto;"
                alt="Asrama Logo"
                />
            </div>
            <div class="email-body">
                <NIM>Dear, '.$nama.'<br>NIM. '.$nim.'</p>
                <p>
                Kami telah melakukan proses evaluasi yang sangat ketat terhadap
                seluruh warga, dan setelah mempertimbangkan berbagai aspek, kami telah
                memutuskan warga yang lolos.
                </p>
                '.$messageBody.'
                <p>
                Untuk pertanyaan lebih lanjut, silakan hubungi
                <a href="https://wa.me/6288803528451" class="contact-link">contact person</a> atau kunjungi
                sosial media asrama.
                </p>
                <p>Selamat bergabung dan semangat belajar!</p>
            </div>
            <div class="email-signature">
                <p>Salam,<br />Pengurus Asrama UTM</p>
            </div>
            </div>
        </body>
        </html>';  

        // Mengirim email menggunakan PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Konfigurasi server email
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'alivian7373@gmail.com'; 
            $mail->Password = 'utjw oxpd ccap iaun'; 
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Mengatur email pengirim dan penerima
            $mail->setFrom('alivian7373@gmail.com', 'Asrama Universitas Trunojoyo Madura');
            $mail->addAddress($email);

            // Mengatur konten email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();

            echo "Email berhasil dikirim ke $email <br>";
        } catch (Exception $e) {
            
            echo "Gagal mengirim email ke $email. Error: {$mail->ErrorInfo} <br>";

        }

    }
} else {
    echo "Tidak ada data email dalam database.\n";
}

$conn->close();
?>

<a href="lap_penilaian.php">Kembali</a>