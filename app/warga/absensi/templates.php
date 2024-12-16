<?php
    include '../../base.php';

    $pages = basename($_SERVER['PHP_SELF']);
    // include 'config.php';

    $no = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../../assets/js/rekap-absensi.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Manrope' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../assets/css/bar-ketua.css">
    <link rel="stylesheet" href="../../../assets/css/rekap-absensi.css">
    <link rel="stylesheet" href="../../../assets/css/style_penghuni.css">
    <title><?= $pageTitle ?></title>
</head>
<body>
    <div class="container">
       

        <div class="rightbar">
            <div class="header">
                <div class="circle">
                    <a href="#"><img class="img" src="../../../assets/img/bar-ketua/profile.png" alt="profile"></a>
                </div>
                <div class="circle">
                    <a href="#"><img class="img" src="../../../assets/img/bar-ketua/logout.png" alt="logout"></a>
                </div>
            </div>