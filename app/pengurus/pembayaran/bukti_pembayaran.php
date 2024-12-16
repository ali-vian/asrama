<?php
session_start();
if (!isset($_SESSION['nim']) && !$_SESSION['role'] == 'pengurus') {
    header("Location: ../../../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Body styling */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f9fafc;
        }

        /* Main Container */
        .details-container {
            position: relative;
            background-color: #ffffff;
            width: 90%;
            max-width: 400px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        /* Close Icon */
        .close-icon {
            position: absolute;
            top: 10px;
            left: 15px;
            font-size: 18px;
            color: #555;
            cursor: pointer;
        }

        /* Checkmark Icon */
        .checkmark-icon {
            display: inline-block;
            width: 24px;
            height: 24px;
            background-color: #4CAF50;
            border-radius: 50%;
            color: #fff;
            font-size: 16px;
            line-height: 24px;
            margin-bottom: 10px;
        }

        /* Header styling */
        .header {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 10px 10px 0 0;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        /* Details Box */
        .details-box {
            text-align: left;
        }

        /* Dashed Line */
        .dashed-line {
            border: none;
            border-top: 1px dashed #e0e0e0;
            margin: 10px 0;
        }

        /* Payment Details Rows */
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            font-size: 14px;
        }

        .detail-row .label {
            color: #777;
        }

        .detail-row .value {
            color: #333;
            font-weight: bold;
            text-align: right;
        }

        .detail-row .value.amount {
            color: #000;
            font-weight: bold;
            font-size: 14px;
        }

        .detail-row .value.status {
            background-color: #e8f5e9;
            color: #4CAF50;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            text-align: center;
        }

        /* Button Container */
        .button-container {
            margin-top: 20px;
        }

        .pdf-button, .home-button {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            margin-bottom: 10px;
            text-decoration: none;
            display: block;
            text-align: center;
            font-weight: bold;
        }

        .pdf-button {
            background-color: #f0f0f0;
            color: #333;
        }

        .home-button {
            background-color: #4a00e0;
            color: #ffffff;
        }

        /* Success Text */
        .success-text {
            font-size: 18px;
            font-weight: bold;
            color: #4CAF50;
            margin-bottom: 10px;
        }

        /* Amount Text */
        .amount-text {
            font-size: 20px;
            font-weight: bold;
            color: #000;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="details-container">
        <!-- Close Icon -->
        <div class="close-icon" onclick="closeDetails()">✖</div>

        <!-- Checkmark Icon -->
        <div class="checkmark-icon">✓</div>

        <!-- Payment Success Text -->
        <p class="success-text">Payment Success!</p>

        <!-- Centered Amount Text -->
        <p class="amount-text">RP <?= number_format(1000000, 0, ',', '.'); ?></p>

        <!-- Header Section -->
        <div class="header">Payment Details</div>

        <!-- Payment Details Box -->
        <div class="details-box">
            <div class="detail-row">
                <span class="label">Ref Number</span>
                <span class="value">000085752257</span>
            </div>
            <div class="detail-row">
                <span class="label">Payment Time</span>
                <span class="value"><?= date('d-m-Y, H:i:s'); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Payment Method</span>
                <span class="value">Bank Transfer</span>
            </div>
            <div class="detail-row">
                <span class="label">Sender Name</span>
                <span class="value">Aurellia Zhullvita</span>
            </div>
            
            <!-- Dashed Line -->
            <hr class="dashed-line">
            
            <div class="detail-row">
                <span class="label">Amount</span>
                <span class="value amount">RP <?= number_format(1000000, 0, ',', '.'); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Admin Fee</span>
                <span class="value">RP <?= number_format(2500, 0, ',', '.'); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Payment Status</span>
                <span class="value status">Success</span>
            </div>
        </div>

        <!-- Buttons -->
        <div class="button-container">
            <!-- Share Button -->
            <button class="pdf-button" onclick="shareReceipt()">
                <span class="icon">🔗</span> Bagikan
            </button>
            <a href="home.php" class="home-button">Back to Home</a>
        </div>
    </div>

    <script>
        function closeDetails() {
            document.querySelector('.details-container').style.display = 'none';
        }

        function shareReceipt() {
            if (navigator.share) {
                navigator.share({
                    title: 'Payment Receipt',
                    text: 'Lihat struk pembayaran saya.',
                    url: window.location.href // Replace with actual URL if needed
                }).then(() => {
                    console.log('Berhasil dibagikan');
                }).catch((error) => {
                    console.error('Gagal dibagikan', error);
                });
            } else {
                alert('Fitur berbagi tidak didukung di browser ini.');
            }
        }
    </script>

</body>
</html>
