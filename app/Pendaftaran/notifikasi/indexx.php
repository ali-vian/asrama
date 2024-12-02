<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHMailer\Exception;

require 'vendor/autoload.php';  // Pastikan path sesuai dengan lokasi autoload.php Composer

// Fungsi untuk mengirim email
function kirimEmail($emailTujuan, $namaPenerima, $subjek, $pesan) {
    $mail = new PHPMailer(true);

    try {
        // Konfigurasi SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Server SMTP Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'mahrusk123@gmail.com';  // Ganti dengan email Anda
        $mail->Password = 'xpny dven cleh inzg';  // Ganti dengan password aplikasi Gmail Anda
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Pengaturan pengirim dan penerima
        $mail->setFrom('mahrusk123@gmail.com', 'Admin Pendaftaran');
        $mail->addAddress($emailTujuan, $namaPenerima);

        // Konten email
        $mail->isHTML(true);  
        $mail->Subject = $subjek;
        $mail->Body    = $pesan;

        // Mengirim email
        $mail->send();
        echo 'Email berhasil dikirim';
    } catch (Exception $e) {
        echo "Email gagal dikirim. Error: {$mail->ErrorInfo}";
    }
}

// Menyusun email yang akan dikirim
$email = 'mahrzstwn@gmail.com';  // Ganti dengan alamat email penerima
$nama = 'tes';  // Nama penerima
$subjek = 'Test Pengiriman Email';
$pesan = 'Ini adalah pesan tes menggunakan PHPMailer.';

kirimEmail($email, $nama, $subjek, $pesan);
?>
