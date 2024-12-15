<?php 

session_start();


if ($_SESSION['role'] != 'warga') {
    header('Location: ../../login.php');
}

include 'headersidebar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
body {
            background-color: #f9fafb;
            position: relative;
        }
        .sidebar {
            height: 100vh;
            background-color: rgba(255, 255, 255, 0.9);
            border-right: 1px solid #e0e0e0;
            padding-top: 20px;
            position: fixed;
            width: 250px;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: transform 0.3s ease;
        }
        .sidebar.active {
            transform: translateX(0);
        }
        .sidebar .nav-link {
            color: #333;
            font-size: 0.95rem;
            padding: 15px 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            transition: background-color 0.3s;
        }
        .sidebar .nav-link.active {
            background-color: #e0e7ff;
            font-weight: bold;
            color: #1e40af;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(224, 231, 255, 0.8);
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            row-gap: 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                transform: translateX(-100%);
                z-index: 1000;
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .nav-link {
                justify-content: center;
                text-align: center;
            }
            .menu-button {
                display: inline-block;
                cursor: pointer;
                font-size: 1.5rem;
                color: #6366f1;
            }
            .dashboard-title {
                display: none;
            }
        }
</style>
<body>
    
</body>
</html>
<body>
    <!-- Main Content Section -->
    <div class="main-content">
        <img src="https://quickchart.io/qr?text=2200411100082/Muhammad Alivian Sidiq&size=500" alt="QR Code"
        class="qr-code img-thumbnail img-responsive"  width="500px"/>
        <h5>Tunjukan QR Code ini untuk melakukan absen</h5>
        <p>Satu QR Code untuk semua absen</p>
    </div>
</body>
</html>