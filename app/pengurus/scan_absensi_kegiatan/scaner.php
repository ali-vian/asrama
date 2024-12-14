<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>QR Code Scanner</title>
    <script
      type="text/javascript"
      src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"
    ></script>
    <style>
      body {
        display: flex;
        flex-direction: column;
        align-items: center;
        font-family: Arial, sans-serif;
        background-color: #f3f4f6;
        margin: 0;
        padding: 0;
      }

      #video-container {
        position: relative;
        width: 100%;
        max-width: 800px;
        margin: 20px auto;
      }

      video {
        width: 100%;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      }

      .camera-selection {
        margin: 10px;
      }

      select {
        padding: 5px;
        font-size: 14px;
        border-radius: 5px;
        border: 1px solid #ccc;
      }
    </style>
  </head>
  <body>
    <div class="camera-selection">
      <label for="cameraSelect">Pilih Kamera:</label>
      <select id="cameraSelect"></select>
    </div>
    <div id="video-container">
      <video id="preview"></video>
    </div>

    <script>
      // Inisialisasi Instascan
      let scanner = new Instascan.Scanner({
        video: document.getElementById("preview"),
      });

      // Tambahkan listener untuk hasil scan
      scanner.addListener("scan", function (content) {
        // Data QR Code yang di-scan
        const dataToSend = {
          nim: content, // Isi QR Code dianggap sebagai NIM
          status_kehadiran: "hadir",
        };

        // Kirim data ke server
        fetch("update_absensi.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(dataToSend),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.status === "success") {
              alert(data.message); // NIM ditemukan dan status diperbarui
            } else if (data.message.includes("NIM tidak ditemukan")) {
              alert("Error: NIM tidak ditemukan!"); // Pop-up khusus jika NIM tidak ada
            } else {
              alert("Gagal memperbarui absensi: " + data.message);
            }
          })
          .catch((error) => console.error("Error:", error));
      });

      // Pilih kamera
      Instascan.Camera.getCameras()
        .then(function (cameras) {
          const cameraSelect = document.getElementById("cameraSelect");
          cameras.forEach((camera, index) => {
            const option = document.createElement("option");
            option.value = index;
            option.text = camera.name || `Camera ${index + 1}`;
            cameraSelect.appendChild(option);
          });

          cameraSelect.addEventListener("change", function () {
            scanner.start(cameras[this.value]);
          });

          if (cameras.length > 0) {
            scanner.start(cameras[0]);
          } else {
            alert("No cameras found.");
          }
        })
        .catch(function (error) {
          console.error(error);
        });
    </script>
  </body>
</html>
