<?php
session_start();
include('baglan.php');
include('error_handler.php');

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Index Sayfası</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000; /* Siyah arka plan */
            color: #fff; /* Beyaz metin */
        }
        .navbar {
            margin-bottom: 20px;
        }
        .container {
            margin-top: 20px;
        }
        .card {
            margin-bottom: 20px;
            background-color: #333; /* Kart arka plan rengi */
            color: #fff; /* Kart metin rengi */
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }
        .card-img-top {
            max-height: 200px;
            object-fit: cover;
        }
        .btn-custom-satin-al {
            background-color: #28a745; /* Satın Al butonu için yeşil */
            color: white;
        }
        .btn-custom-iletisim {
            background-color: #007bff; /* İletişim butonu için mavi */
            color: white;
        }
        .btn-custom-satin-al:hover, .btn-custom-iletisim:hover {
            opacity: 0.8;
        }
        .mt-auto {
            margin-top: auto;
        }
        .navbar-light .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.8);
        }
        .navbar-light .navbar-nav .nav-link:hover {
            color: #fff;
        }
        .navbar-light .navbar-brand {
            color: #fff;
        }
        .navbar-light .navbar-toggler {
            color: #fff;
            border-color: rgba(255, 255, 255, 0.1);
        }
        .navbar-light .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%28255, 255, 255, 0.5%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand" href="index.php">Hawk Oto Galeri</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Anasayfa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="hakkimizda.php">Hakkımızda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sifirarac.php">Sıfır Araçlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="araclistesi.php">İkinci El Araçlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="kampanya.php">Kampanyalar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="satin_al.php">Satın Alma</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ilet.php">İletişim</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ikinciel.php">Bülten</a>
                </li>
                <?php
                if (isset($_SESSION['kullanici_adi'])) {
                    echo '<li class="nav-item"><a class="nav-link" href="#">' . htmlspecialchars($_SESSION['kullanici_adi']) . '</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Çıkış Yap</a></li>';
                } else {
                    echo '<li class="nav-item"><a class="nav-link" href="uyelik/login.php">Giriş Yap</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="uyelik/kayit.php">Kayıt Ol</a></li>';
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="admin_giris.php">Admin Girişi</a>
                </li>
            </ul>
        </div>
    </nav>

  
        <main class="container">
            <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
                <div class="col-lg-6 px-0">
                    <h1 class="display-4 fst-italic">İkinci El Araçlarımız</h1>
                    <p class="lead my-3">Son zamanlarda ikinci el araç piyasasında yaşanan gelişmeler hakkında en güncel bilgilere ulaşın. Uzmanlarımızın analizleri ve önerileriyle, doğru aracı seçmenin önemini keşfedin.</p>
                </div>
            </div>
        </main>
        <div class="container mt-5">
            <h2>İkinci El Araçlarımız</h2>
            <div class="row">
                <?php
                include 'config.php';
                $query = "SELECT * FROM ikinci_el_araclar";
                $result = mysqli_query($conn_oto_galeri, $query);
                while ($arac = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <img src="<?= $arac['resim'] ?>" class="card-img-top img-fluid" alt="<?= $arac['marka'] . ' ' . $arac['model'] ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= $arac['marka'] . ' ' . $arac['model'] ?></h5>
                                <p class="card-text">Yıl: <?= $arac['yil'] ?></p>
                                <p class="card-text">Fiyat: <?= $arac['fiyat'] ?> TL</p>
                                <div class="mt-auto d-flex justify-content-between">
                                    <a href="odeme.php?arac_id=<?= $arac['id'] ?>" class="btn btn-custom-satin-al">Satın Al</a>
                                    <a href="ilet.php" class="btn btn-custom-iletisim">İletişim</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
  
    <br>
    <br>

    <br>
    <br>

    <br>

    <footer class="footer">
        <p>&copy; 2023 Hawk Oto Galeri. Tüm hakları saklıdır.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
