<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Asrama UTM</title>

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style.css">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Roboto:wght@400;700&family=Saira+Stencil+One&display=swap"
    rel="stylesheet">
</head>
<style>
        .h1.logo img {
            width: 110px; /* Atur sesuai ukuran yang diinginkan */
            height: auto; /* Menjaga proporsi gambar */
        }

        /* Gaya untuk tombol login */
        .login-btn {
            padding: 8px 13px;
            font-size: 12px;
            color: #fff;
            background-color: #007bff; /* Warna biru */
            border: none;
            border-radius: 50px;
            cursor: pointer;
            text-transform: uppercase;
        }
        .login-btn:hover {
            background-color: #0056b3; /* Warna biru lebih gelap saat hover */
        }

        .stats {
    padding-block: var(--section-padding);
}

.stats-list {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* Hanya dua kolom per baris */
    gap: 30px;
    justify-content: center; /* Agar rata tengah */
}

.stats-card {
    background: var(--bg-secondary);
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 25px;
    border-radius: var(--radius-12);
    box-shadow: var(--shadow-1);
    transition: var(--transition-1);
}

.stats-card:is(:hover, :focus) { 
    transform: translateY(-5px); 
}

.stats-card .card-icon {
    background: #007bff;
    width: 60px;
    height: 60px;
    display: grid;
    place-items: center;
    border-radius: 50%;
}

.stats-card .card-icon img {
    width: 100%;
}

.stats-card .card-title {
    width: calc(100% - 95px);
    color: #007bff; /* Ganti dengan kode warna yang sesuai */
    text-align: center;
}

.stats-card .card-title strong {
    text-align: justify;
    display: block;
    color: var(--color-primary); /* Jika var(--color-primary) sebelumnya oranye, ubah di variabel CSS */
    font-size: 9pt;
    line-height: 1.3;
    margin-top: 5px;
}

.stats-card > ion-icon { 
    color: var(--color-secondary); 
}

/* Responsif */
@media (max-width: 768px) {
    .stats-list {
        grid-template-columns: 1fr; /* Ubah menjadi satu kolom */
    }

    .stats-card {
        flex-direction: column; /* Mengubah arah flex menjadi kolom */
        align-items: flex-start; /* Rata kiri untuk elemen dalam */
        padding: 15px; /* Mengurangi padding untuk ukuran yang lebih kecil */
    }

    .stats-card .card-title {
        width: 100%; /* Memastikan judul menggunakan lebar penuh */
        text-align: left; /* Rata kiri untuk judul */
    }

    .stats-card .card-icon {
        margin-bottom: 10px; /* Jarak antara ikon dan judul */
    }
}

        /*administrasi*/

        .arabic-text {
            display: block; /* Agar teks Arab menjadi elemen blok */
            text-align: center; /* Memusatkan teks */
            font-size: 1.5rem; /* Ukuran font yang lebih besar, bisa disesuaikan */
            
        }


        /* Gaya dasar untuk section */
        .skills {
            display: flex;
            justify-content: center;
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }

        .skills-test {
            display: flex;
            flex-direction: column;
            width: 100%;
            text-align: center;
        }

        .section-title {
            font-size: 1.8rem;
            margin-top: 0;
        }

        .section-text {
            font-size: 1rem;
            color: #555;
            margin-bottom: 20px;
        }

        .main-container {
            display: flex;
            flex-direction: row;
            gap: 20px;
        }

        /* Tombol di sebelah kiri */
        /* Tombol di sebelah kiri */
        .button-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            width: 100px;
        }

        .toggle-button {
            padding: 15px;
            text-align: center;
            background-color: var(--bg-secondary);
            color: #007bff; /* Warna biru seperti stats */
            border: 1px solid #007bff;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .toggle-button.active,
        .toggle-button:hover {
            background-color: #007bff;
            color: white;
        }


        /* Konten di sebelah kanan */
        /* Konten di sebelah kanan */
        .content-area {
            flex-grow: 1;
            background-color: var(--bg-secondary);
            border: 1px solid #ddd;
            padding: 25px;
            border-radius: var(--radius-12);
            box-shadow: var(--shadow-1);
        }

        /* Konten area yang aktif */
        .content-section.active {
            display: block;
        }


        .content-section {
            display: none;
        }

        .content-section h3 {
            font-size: 1.4rem;
            color: #007bff;
            margin-bottom: 10px;
        }

        .content-section p {
            font-size: 1rem;
            color: var(--color-primary); /* Menggunakan warna utama dari stats-card */
            text-align: justify;
        }


        .content-section a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .content-section a:hover {
            text-decoration: underline;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }
            
            .button-grid {
                grid-template-columns: 1fr 1fr;
                width: 100%;
                max-width: 200px;
                margin: 0 auto 20px auto;
            }
        }

    </style>
<body id="top" class="dark_theme">

  <!-- 
    - #HEADER
  -->

  <header class="header" data-header>
    <div class="container">

      <h1 class="h1 logo">
        <a href="#"><img src='assets/logo2.png' alt="logo"></a>
      </h1>

      <div class="navbar-actions">

        
        <button class="login-btn" onclick="window.location.href='loginadmin.php'">Login Ketua</button>
        

        <button class="theme-btn" aria-label="Change Theme" title="Change Theme" data-theme-btn>
          <span class="icon"></span>
        </button>

      </div>

      <button class="nav-toggle-btn" aria-label="Toggle Menu" title="Toggle Menu" data-nav-toggle-btn>
        <span class="one"></span>
        <span class="two"></span>
        <span class="three"></span>
      </button>

      <nav class="navbar" data-navbar>
        <ul class="navbar-list">

          <li>
            <a href="#home" class="navbar-link">Home.</a>
          </li>

          <li>
            <a href="#tentangkami" class="navbar-link">Tentang Kami.</a>
          </li>

          <li>
            <a href="#administrasi" class="navbar-link">Administrasi.</a>
          </li>

          <li>
            <a href="#galeri" class="navbar-link">Galeri.</a>
          </li>

          <li>
            <a href="#aspirasi" class="navbar-link">Aspirasi.</a>
          </li>

        </ul>
      </nav>

    </div>
  </header>





  <main>
    <article class="container">

      <!-- 
        - #HERO
      -->

      <section class="hero" id="home">

        <figure class="hero-banner">

          <picture>
            <source srcset="./assets/head1.png" media="(min-width: 768px)">
            <source srcset="./assets/head1.png" media="(min-width: 500px)">
            <img src="./assets/head1.png" alt="A man in a blue shirt with a happy expression"
              class="w-100">
          </picture>

        </figure>

        <div class="hero-content">

          <h2 class="h2 hero-title"><br><br>Sistem Absensi Asrama UTM</h2>

          <a href="login.php" class="btn btn-primary">Login Pengurus & Warga</a>

        </div>

        <ul class="hero-social-list">

    <li>
        <a href="https://www.instagram.com/Trunojoyo.Asrama/" class="hero-social-link">
            <ion-icon name="logo-instagram"></ion-icon>
            <div class="tooltip">Instagram</div>
        </a>
    </li>

    <li>
        <a href="https://www.facebook.com/AsramaTrunojoyo/" class="hero-social-link">
            <ion-icon name="logo-facebook"></ion-icon>
            <div class="tooltip">Facebook</div>
        </a>
    </li>

    <li>
        <a href="https://x.com/AsramaTrunojoyo" class="hero-social-link">
            <ion-icon name="logo-twitter"></ion-icon>
            <div class="tooltip">Twitter</div>
        </a>
    </li>

    <li>
        <a href="https://www.youtube.com/@ASRAMATRUNOJOYO" class="hero-social-link">
            <ion-icon name="logo-youtube"></ion-icon>
            <div class="tooltip">YouTube</div>
        </a>
    </li>

    <li>
        <a href="https://www.tiktok.com/@asrama.trunojoyo" class="hero-social-link">
            <ion-icon name="logo-tiktok"></ion-icon>
            <div class="tooltip">TikTok</div>
        </a>
    </li>

</ul>


        <a href="#stats" class="scroll-down">Scroll</a>

      </section>





      <!-- 
        - #STATS
      -->

      <section class="stats" id="stats">
      <h2 class="h3 section-title">Setiap Warga Asrama wajib memiliki sikap antara lain:</h2>
    <ul class="stats-list">

        <li>
            <a href="#" class="stats-card">
                <div class="card-icon">
                    <img src="assets/icon/religius.png" alt="Badge icon">
                </div>
                <h2 class="h2 card-title">
                    RELIGIUS<strong>Berpegang pada nilai-nilai keagamaan dalam menjalani kehidupan.</strong>
                </h2>
                <ion-icon name="chevron-forward-outline"></ion-icon>
            </a>
        </li>

        <li>
            <a href="#" class="stats-card">
                <div class="card-icon">
                    <img src="assets/icon/amanah.png" alt="Checkmark icon">
                </div>
                <h2 class="h2 card-title">
                    AMANAH<strong>Dapat dipercaya dan bertanggung jawab atas kepercayaan yang diberikan.</strong>
                </h2>
                <ion-icon name="chevron-forward-outline"></ion-icon>
            </a>
        </li>

        <li>
            <a href="#" class="stats-card">
                <div class="card-icon">
                    <img src="assets/icon/peduli.png" alt="Peoples rating icon">
                </div>
                <h2 class="h2 card-title">
                    PEDULI<strong>Memiliki perhatian dan empati terhadap orang lain atau lingkungan.</strong>
                </h2>
                <ion-icon name="chevron-forward-outline"></ion-icon>
            </a>
        </li>

        <li>
            <a href="#" class="stats-card">
                <div class="card-icon">
                    <img src="assets/icon/kreatif.png" alt="Lightbulb icon">
                </div>
                <h2 class="h2 card-title">
                    KREATIF<strong>Mampu menghasilkan ide atau solusi inovatif dan unik.</strong>
                </h2>
                <ion-icon name="chevron-forward-outline"></ion-icon>
            </a>
        </li>

    </ul>
</section>






      <!-- 
        - #ABOUT
      -->

      <section class="about" id="tentangkami">

        <figure class="about-banner">
          <img src="assets/head22.png" alt="A man in a alice blue shirt with a thinking expression"
            class="w-100">
        </figure>

        <div class="about-content section-content">

          <p class="section-subtitle">Tentang Kami</p>

          <h2 class="h3 section-title">Visi</h2>

          <p class="section-text">Mewujudkan lingkungan kondusif bagi proses pendalaman spiritual, 
            perbaikan ahlaq, pengembangan intelektual dan pemantapan minat bakat  serta kepedulian 
            social mahasiswa sebagai generasi penerus bangsa yang bertaqwa, berahlaqul karimah, 
            cerdas dan professional serta peduli sesama.</p>

          <h2 class="h3 section-title">Misi</h2>

          <p class="section-text">Mengantarkan mahasiswa memiliki kemantapan akidah dan kedalaman spiritual, 
            dan keluhuran akhlak,Mendukung mahasiswa dalam memperoleh keluasan ilmu, prestasi dan kemantapan 
            profesional. Memberikan mahasiswa keterampilan tambahan dan dukungan pengembangan minat dan bakat.
            Memberikan bekal empati dan kepedulian sosial dan kemasyarakatan.</p>

          <h2 class="h3 section-title">Tujuan</h2>

          <p class="section-text">Terciptanya suasana kondusif bagi proses pembinaan kepribadian mahasiswa agar 
            memiliki kemantapan akidah, kedalaman spiritual, dan keluhuran akhlaqMembangun lingkungan yang mampu 
            mendorong mahasiswa mengembangkan wawasan keilmuan, prestasi dan kemantapan profesionalnya. Mendukung 
            pengembangan keterampilan tambahan dan pengembangan minat dan bakat. Terciptanya tempat berlatih 
            membangun kepekaan dalam menjalani kehidupan sosial masyarakat yang baik</p>

        </div>

      </section>





      <!-- 
        - #SKILLS
      -->

      <section class="skills" id="administrasi">
    <div class="skills-content section-content">
        <p class="section-subtitle">Administrasi</p>
        <h2 class="h3 section-title">Persyaratan dan Administrasi</h2>
        <p class="section-text">
            <span class="arabic-text">السَّلاَمُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَاتُهُ</span><br>
            Kami ucapkan Selamat dan Sukses kepada Calon Mahasiswa Baru Universitas Trunojoyo Madura🥳🥳🥳
            Dalam rangka mencetak generasi mahasiswa yang berkarakter, saat ini, Asrama Mahasiswa Universitas Trunojoyo Madura membuka pendaftaran Pendidikan Karakter untuk calon warga baru.
            Adapun rinciannya sebagai berikut:
        </p>


        <div class="main-container">
        <!-- Kolom tombol di sebelah kiri (2x4) -->
        <div class="button-grid">
            <button class="toggle-button active" data-toggle-btn="content-1">1</button>
            <button class="toggle-button" data-toggle-btn="content-2">2</button>
            <button class="toggle-button" data-toggle-btn="content-3">3</button>
            <button class="toggle-button" data-toggle-btn="content-4">4</button>
            <button class="toggle-button" data-toggle-btn="content-5">5</button>
            <button class="toggle-button" data-toggle-btn="content-6">6</button>
            <button class="toggle-button" data-toggle-btn="content-7">7</button>
            <button class="toggle-button" data-toggle-btn="content-8">8</button>
        </div>

        <!-- Kolom konten di sebelah kanan -->
        <div class="content-area">
            <div class="content-section active" id="content-1">
                <h3>Surat Pernyataan</h3>
                <p>Membuat surat pernyataan kesanggupan dengan format berikut:</p>
                <a href="http://bit.ly/SuratPernyataanKesanggupanMaba" target="_blank">http://bit.ly/SuratPernyataanKesanggupanMaba</a>
            </div>
            <div class="content-section" id="content-2">
                <h3>Pas Foto 4x6</h3>
                <p>Upload pas foto ukuran 4x6 sejumlah 2 lembar.</p>
            </div>
            <div class="content-section" id="content-3">
                <h3>Surat Kesanggupan</h3>
                <p>Upload surat pernyataan kesanggupan dan bermaterai. (Diunduh pada link yang telah disediakan dan diunggah pada Google Form)</p>
            </div>
            <div class="content-section" id="content-4">
                <h3>KTM/KTP</h3>
                <p>Scan atau foto Kartu Tanda Penduduk (KTP) Mahasiswa.</p>
            </div>
            <div class="content-section" id="content-5">
                <h3>KTP Orang Tua</h3>
                <p>Scan atau foto KTP orang tua.</p>
            </div>
            <div class="content-section" id="content-6">
                <h3>Kartu Keluarga</h3>
                <p>Scan atau foto Kartu Keluarga.</p>
            </div>
            <div class="content-section" id="content-7">
                <h3>Subscribe YouTube Asrama</h3>
                <p>Channel YouTube: ASRAMATRUNOJOYO</p>
            </div>
            <div class="content-section" id="content-8">
                <h3>Follow Akun Instagram Asrama</h3>
                <p>Akun Instagram: @trunojoyo.asrama</p>
            </div>
        </div>
    </div>

      </section>






      <!-- 
        - #PROJECTS
      -->

      <section class="project" id="galeri">

        <ul class="project-list">

          <li>
            <div class="project-content section-content">

              <p class="section-subtitle">Galeri</p>

              <h2 class="h3 section-title">Galeri Asrama Universitas Trunojoyo Madura</h2>

              <p class="section-text">
              Galeri Asrama Universitas Trunojoyo Madura menampilkan berbagai aktivitas 
              dan momen berharga yang memperlihatkan kehidupan mahasiswa di lingkungan asrama.
              </p>

            </div>
          </li>

          <li>
            <a href="#" class="project-card">

              <figure class="card-banner">
                <img src="assets/galeri/1.jpg" class="w-100" alt="A macintosh on a yellow background.">
              </figure>

              <div class="card-content">
                <h3 class="h4 card-title">Foto Kepengurusan</h3>

                <time class="publish-date" datetime="2022-04">Agustus 2024</time>
              </div>

            </a>
          </li>

          <li>
            <a href="#" class="project-card">

              <figure class="card-banner">
                <img src="assets/galeri/2.jpeg" class="w-100" alt="On a Blue background, a Wacom and a mouse.">
              </figure>

              <div class="card-content">
                <h3 class="h4 card-title">Prosesi Pendaftaran Warga Putri 2024</h3>

                <time class="publish-date" datetime="2022-04">5 Agustus 2024</time>
              </div>

            </a>
          </li>

          <li>
            <a href="#" class="project-card">

              <figure class="card-banner">
                <img src="assets/galeri/3.jpeg" class="w-100"
                  alt="A Cassette tape on a mellow apricot background.">
              </figure>

              <div class="card-content">
                <h3 class="h4 card-title">Prosesi Pendaftaran Warga Putra 2024</h3>

                <time class="publish-date" datetime="2022-04">5 Agustus 2024</time>
              </div>

            </a>
          </li>

          <li>
            <a href="#" class="project-card">

              <figure class="card-banner">
                <img src="assets/galeri/4.jpeg" class="w-100"
                  alt="Blue digital watch on a dark liver background.">
              </figure>

              <div class="card-content">
                <h3 class="h4 card-title">Peninjauan dan survey kepuasan</h3>

                <time class="publish-date" datetime="2022-04">5 Agustus 2024</time>
              </div>

            </a>
          </li>

          <li>
            <a href="#" class="project-card">

              <figure class="card-banner">
                <img src="assets/galeri/5.png" class="w-100"
                  alt="On a dark liver background, Airport luggage car carrying a luggage.">
              </figure>

              <div class="card-content">
                <h3 class="h4 card-title">Penyerahan Sertifikat Kegiatan</h3>

                <time class="publish-date" datetime="2022-04">Juli 2024</time>
              </div>

            </a>
          </li>

          <li>
            <a href="#" class="project-card">

              <figure class="card-banner">
                <img src="assets/galeri/6.png" class="w-100"
                  alt="On a yellow background, a digital watch and a glass.">
              </figure>

              <div class="card-content">
                <h3 class="h4 card-title">Sesi Dokumentasi Panitia Kegiatan</h3>

                <time class="publish-date" datetime="2022-04">Juli 2024</time>
              </div>

            </a>
          </li>

          <li>
            <a href="#" class="project-card">

              <figure class="card-banner">
                <img src="assets/galeri/7.png" class="w-100"
                  alt="A fujifilm instant camera on a dark electric blue background.">
              </figure>

              <div class="card-content">
                <h3 class="h4 card-title">Apresiasi Peserta Workshop</h3>

                <time class="publish-date" datetime="2022-04">Juni 2024</time>
              </div>

            </a>
          </li>

          <li>
            <a href="#" class="project-card">

              <figure class="card-banner">
                <img src="assets/galeri/8.png" class="w-100"
                  alt="A fujifilm instant camera on a dark electric blue background.">
              </figure>

              <div class="card-content">
                <h3 class="h4 card-title">Training Of Trainer 2023</h3>

                <time class="publish-date" datetime="2022-04">Februari 2024</time>
              </div>

            </a>
          </li>

          <li>
            <a href="#" class="project-card">

              <figure class="card-banner">
                <img src="assets/galeri/9.jpg" class="w-100"
                  alt="A fujifilm instant camera on a dark electric blue background.">
              </figure>

              <div class="card-content">
                <h3 class="h4 card-title">Dokumentasi Kepanitiaan Seminar</h3>

                <time class="publish-date" datetime="2022-04">September 2023</time>
              </div>

            </a>
          </li>
          

        </ul>

      </section>





      <!-- 
        - #CONTACT
      -->

      <section class="contact" id="aspirasi">

        <div class="contact-content section-content">

          <p class="section-subtitle">Aspirasi</p>

          <h2 class="h3 section-title">Kirimkan Aspirasi Kalian di form berikut ini :</h2>

          <p class="section-text">
          Asrama Mahasiswa, Universitas Trunojoyo Madura <br>
          Jl. Raya Telang, PO.Box 2 Kamal 69162 <br>
          Bangkalan-Madura, Jawa Timur <br>
          Telp:031 3011147 <br>
          email : – asrama@trunojoyo.ac.id <br><br>

          Contact Person <br>
          Dr. Sigit Dwi Saputro Asrama, S.Pd, M.Pd – Direktur atau Ketua Pengelola Asrama : https://wa.me/+62 852-2619-0457 <br>
          Nurki – Ketua Asrama Putra : https://wa.me/+62 81216144968 <br>
          Dyna – Ketua Asrama Putri : https://wa.me/+62 85730887469 <br>
          </p>

            <p class="section-text">
              --------------------------------------------------------------------------------
              </p>

              <ul class="contac-social-list">

                <li>
                  <a href="#" class="contact-social-link">
                    <div class="tooltip">Facebook</div>

                    <ion-icon name="logo-facebook"></ion-icon>
                  </a>
                </li>

                <li>
                  <a href="#" class="contact-social-link">
                    <div class="tooltip">Twitter</div>

                    <ion-icon name="logo-twitter"></ion-icon>
                  </a>
                </li>

                <li>
                  <a href="#" class="contact-social-link">
                    <div class="tooltip">Linkedin</div>

                    <ion-icon name="logo-linkedin"></ion-icon>
                  </a>
                </li>

                <li>
                  <a href="#" class="contact-social-link">
                    <div class="tooltip">Youtube</div>

                    <ion-icon name="logo-youtube"></ion-icon>
                  </a>
                </li>

              </ul>
            </li>

          </ul>

        </div>

        <form action="" class="contact-form">

          <div class="form-wrapper">

            <label for="name" class="form-label">Nama</label>

            <div class="input-wrapper">

              <input type="text" name="name" id="name" required placeholder="Farid Ghozali" class="input-field">

              <ion-icon name="person-circle"></ion-icon>

            </div>

          </div>

          <div class="form-wrapper">

            <label for="email" class="form-label">Email</label>

            <div class="input-wrapper">

              <input type="email" name="email" id="email" required placeholder="student@student.trunojoyo.ac.id"
                class="input-field">

              <ion-icon name="mail"></ion-icon>

            </div>

          </div>

          <div class="form-wrapper">

            <label for="phone" class="form-label">Nomor HP</label>

            <div class="input-wrapper">

              <input type="tel" name="phone" id="phone" required placeholder="+62 *** **** ****" class="input-field">

              <ion-icon name="call"></ion-icon>

            </div>

          </div>

          <div class="form-wrapper">

            <label for="message" class="form-label">Aspirasi</label>

            <div class="input-wrapper">

              <textarea name="message" id="message" required placeholder="Aspirasi..."
                class="input-field"></textarea>

              <ion-icon name="chatbubbles"></ion-icon>

            </div>

          </div>

          <button type="submit" class="btn btn-primary">kirim</button>

        </form>

      </section>

    </article>
  </main>





  <!-- 
    - #FOOTER
  -->

  <footer class="footer">
    <div class="container">

      <p class="h2 logo">
      <a href="#"><img src='assets/logo2.png' alt="logo"></a>
      </p>

      <p class="copyright">
        &copy; 2024 <a href="#">Asrama UTM</a>. All rights reserved
      </p>

    </div>
  </footer>





  <!-- 
    - #GO TO TOP
  -->

  <a href="#top" class="go-top" data-go-top title="Go to Top">
    <ion-icon name="arrow-up"></ion-icon>
  </a>





  <!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script>
        // JavaScript untuk mengelola toggle
        const toggleButtons = document.querySelectorAll('[data-toggle-btn]');
        const contentSections = document.querySelectorAll('.content-section');

        toggleButtons.forEach(button => {
            button.addEventListener('click', () => {
                toggleButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                const selectedContent = button.getAttribute('data-toggle-btn');
                contentSections.forEach(content => {
                    if (content.id === selectedContent) {
                        content.classList.add('active');
                    } else {
                        content.classList.remove('active');
                    }
                });
            });
        });
    </script>


</body>

</html>