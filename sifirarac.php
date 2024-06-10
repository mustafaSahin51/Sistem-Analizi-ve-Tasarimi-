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
    <title>Hakkımızda</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000; /* Siyah arka plan */
            color: #fff; /* Beyaz metin */
        }
        .container {
            margin-top: 50px;
        }
        .form-control {
            background-color: #333;
            color: #fff;
        }
        .btn-custom {
            background-color: #ff6600;
            color: #fff;
        }
        .footer {
            margin-top: 50px;
            background-color: #343a40;
            color: white;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .navbar-light .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.8);
        }
        .navbar-light .navbar-nav .nav-link:hover {
            color: #fff;
        }
        .card {
            background-color: #333;
            color: #fff;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%; /* Kartların aynı yüksekliğe gelmesi için */
        }
        .card + .card {
            margin-top: 20px; /* Kartlar arasına boşluk ekler */
        }
        .card-img-top {
            max-height: 200px;
            object-fit: cover;
        }
        .btn-custom-satin-al {
            background-color: #28a745; /* Satın Al butonu için yeşil */
            color: white;
            flex-grow: 1;
            margin-right: 5px;
        }
        .btn-custom-iletisim {
            background-color: #007bff; /* İletişim butonu için mavi */
            color: white;
            flex-grow: 1;
        }
        .btn-custom-satin-al:hover, .btn-custom-iletisim:hover {
            opacity: 0.8;
        }
        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: auto;
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

    <div class="container mt-5">
        <h2>İşte Sıfır Araçlarımız</h2>
        <div class="row">
            <?php
            include 'config.php';
            $query = "SELECT * FROM araclar";
            $result = mysqli_query($conn_oto_galeri, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($arac = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="<?= $arac['resim'] ?>" class="card-img-top img-fluid" alt="<?= $arac['marka'] . ' ' . $arac['model'] ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= $arac['marka'] . ' ' . $arac['model'] ?></h5>
                                <p class="card-text">Yıl: <?= $arac['yil'] ?></p>
                                <p class="card-text">Fiyat: <?= $arac['fiyat'] ?> TL</p>
                                <div class="btn-group">
                                    <a href="odeme.php?arac_id=<?= $arac['id'] ?>" class="btn btn-custom-satin-al">Satın Al</a>
                                    <a href="ilet.php" class="btn btn-custom-iletisim">İletişim</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; 
            } else { ?>
                <div class="col-12">
                    <p>Henüz sıfır aracımız yoktur</p>
                    <a href="araclistesi.php" class="btn btn-primary">İkinci El Araçlara Göz Atın</a>
                </div>
            <?php } ?>
        </div>
    </div>
<br><br><br><br><br><br><br><br>
    <footer class="footer">
        <p>&copy; 2024 Hawk Oto Galeri. Tüm hakları saklıdır.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
