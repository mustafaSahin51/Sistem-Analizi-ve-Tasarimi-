<?php
session_start();
include 'config.php';
include 'baglan.php';
include('error_handler.php');

$araclar_sorgu = "SELECT id, marka, model, fiyat, resim FROM araclar";
$ikinci_el_sorgu = "SELECT id, marka, model, fiyat, resim FROM ikinci_el_araclar";

$araclar_sonuc = mysqli_query($conn_oto_galeri, $araclar_sorgu);
$ikinci_el_sonuc = mysqli_query($conn_oto_galeri, $ikinci_el_sorgu);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Satın Al</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #000; /* Siyah arka plan */
            color: #fff; /* Beyaz metin */
        }
        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            background-color: #333; /* Kart arka plan rengi */
            color: #fff; /* Kart metin rengi */
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
        .footer {
    background-color: #343a40 !important;
    padding: 10px 0;
    text-align: center;
    position: fixed;
    bottom: 0;
    width: 100%;
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

<div class="container mt-5">
    <h3>Sıfır Araçlar</h3>
    <div class="row">
        <?php
        if (mysqli_num_rows($araclar_sonuc) > 0) {
            while ($arac = mysqli_fetch_assoc($araclar_sonuc)): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?= $arac['resim'] ?>" class="card-img-top img-fluid" alt="<?= $arac['marka'] . ' ' . $arac['model'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $arac['marka'] . ' ' . $arac['model'] ?></h5>
                            <p class="card-text">Yıl: <?= isset($arac['yil']) ? $arac['yil'] : 'Bilinmiyor' ?></p>
                            <p class="card-text">Fiyat: <?= $arac['fiyat'] ?> TL</p>
                            <a href="odeme.php?arac_id=<?= $arac['id'] ?>&tablo=araclar" class="btn btn-custom-satin-al">Satın Al</a>
                            <a href="iletisim.php" class="btn btn-custom-iletisim">İletişim</a>
                        </div>
                    </div>
                </div>
            <?php endwhile;
        } else { ?>
            <div class="col-12">
                <p>Henüz sıfır aracımız yoktur.</p>
            </div>
        <?php } ?>
    </div>

    <h3>İkinci El Araçlar</h3>
    <div class="row">
        <?php
        if (mysqli_num_rows($ikinci_el_sonuc) > 0) {
            while ($arac = mysqli_fetch_assoc($ikinci_el_sonuc)): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?= $arac['resim'] ?>" class="card-img-top img-fluid" alt="<?= $arac['marka'] . ' ' . $arac['model'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $arac['marka'] . ' ' . $arac['model'] ?></h5>
                            <p class="card-text">Yıl: <?= isset($arac['yil']) ? $arac['yil'] : 'Bilinmiyor' ?></p>
                            <p class="card-text">Fiyat: <?= $arac['fiyat'] ?> TL</p>
                            <a href="odeme.php?arac_id=<?= $arac['id'] ?>&tablo=ikinci_el_araclar" class="btn btn-custom-satin-al">Satın Al</a>
                            <a href="iletisim.php" class="btn btn-custom-iletisim">İletişim</a>
                        </div>
                    </div>
                </div>
            <?php endwhile;
        } else { ?>
            <div class="col-12">
                <p>Henüz ikinci el aracımız yoktur.</p>
            </div>
        <?php } ?>
    </div>
</div>
<br>
<br>
<br>
<br>
<div class="footer">
    &copy; 2024 Şirketiniz. Tüm hakları saklıdır.
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
