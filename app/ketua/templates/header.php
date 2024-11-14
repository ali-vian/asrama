<?php
    include '../../base.php';

    $pages = basename($_SERVER['PHP_SELF']);

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
    <link rel="stylesheet" href="../../../assets/css/bar-ketua.css">
    <link rel="stylesheet" href="../../../assets/css/rekap-absensi.css">
    <title><?= $pageTitle ?></title>
</head>
<body>
    <div class="container">
        <?php require_once 'sidebar.php'?>

        <div class="rightbar">
            <div class="header">
                <div class="circle">
                    <a href="#"><img class="img" src="../../../assets/img/bar-ketua/profile.png" alt="profile"></a>
                </div>
                <div class="circle">
                    <a href="#"><img class="img" src="../../../assets/img/bar-ketua/logout.png" alt="logout"></a>
                </div>
            </div>