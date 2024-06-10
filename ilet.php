<?php
include('baglan.php');
include('error_handler.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adsoyad = $_POST['adsoyad'];
    $email = $_POST['email'];
    $telno = $_POST['telno']; // Değişken ismi form ile uyumlu olacak şekilde güncellendi
    $il = $_POST['il'];
    $mesaj = $_POST['mesaj'];
    $adres = $_POST['adres'];

    try {
        // Veritabanına bağlanma
        $db = new PDO("mysql:host=localhost;dbname=k_kayit", "root", "");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verileri veritabanına ekleme
        $stmt = $db->prepare("INSERT INTO iletisim_tablo (adsoyad, email, telno, il, mesaj, adres, created_at) VALUES (:adsoyad, :email, :telno, :il, :mesaj, :adres, NOW())");
        $stmt->bindParam(':adsoyad', $adsoyad, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':telno', $telno, PDO::PARAM_STR); // Telefon numarası VARCHAR olarak bağlanıyor
        $stmt->bindParam(':il', $il, PDO::PARAM_STR);
        $stmt->bindParam(':mesaj', $mesaj, PDO::PARAM_STR);
        $stmt->bindParam(':adres', $adres, PDO::PARAM_STR);
        $stmt->execute();

        echo '<div class="alert alert-success" role="alert">
            Mesajınız başarıyla kaydedildi.
        </div>';
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger" role="alert">
            Mesajınız kaydedilirken bir hata oluştu. Lütfen tekrar deneyiniz.<br>
            Hata: ', $e->getMessage(), '
        </div>';
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Index Sayfası</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="indexstyle.css">
    <style>
        body {
            background-color: #000; /* Siyah arka plan */
            color: #fff; /* Beyaz metin */
        }
        .container {
            margin-top: 50px;
        }
        .form-control {
            background-color: #333; /* Koyu gri arka plan */
            color: #fff; /* Beyaz metin */
        }
        .form-control::placeholder {
            color: #bbb; /* Açık gri placeholder */
        }
        .btn-custom {
            background-color: #555; /* Koyu gri buton */
            color: #fff; /* Beyaz metin */
        }
        .btn-custom:hover {
            background-color: #777; /* Daha açık gri buton */
        }
        
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Hawk Oto Galeri</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                    <a class="nav-link" href="index.php">Anasayfa </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="hakkimizda.php">Hakkımızda  </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sifirarac.php">Sıfır Araçlar </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="araclistesi.php">İkinci El Araçlar  </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="kampanya.php">Kampanyalar  </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="satin_al.php">Satın Alma  </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ilet.php">İletişim </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="bulten.php">Bülten </a>
                </li>
                <?php
                session_start();
                if (isset($_SESSION['kullanici_adi'])) {
                    echo '<li class="nav-item"><a class="nav-link" href="#">' . htmlspecialchars($_SESSION['kullanici_adi']) . '</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Çıkış Yap</a></li>';
                } else {
                    echo '<li class="nav-item"><a class="nav-link" href="uyelik/login.php">Giriş Yap  </a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="uyelik/kayit.php">Kayıt Ol</a></li>';
                }
                ?>

                <li class="nav-item">
                    <a class="nav-link" href="admin_giris.php">Admin Girişi</a>
                </li>
            </ul>
        </div>
    </nav>




<div class="container">
    <h2>İletişim Formu</h2>
    <form action="index.php" method="post">
        <div class="form-group">
            <label for="adsoyad">Ad Soyad</label>
            <input type="text" class="form-control" id="adsoyad" name="adsoyad" placeholder="Adınızı ve soyadınızı yazın" required>
        </div>
        <div class="form-group">
            <label for="email">Email Adresiniz</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email adresinizi yazın" required>
        </div>
        <div class="form-group">
            <label for="telefon">Telefon Numaranız</label>
            <input type="tel" class="form-control" id="telefon" name="telno" placeholder="0(###)(###)(##)(##)" required>
        </div>
        <div class="form-group">
            <label for="il">İl</label>
            <select class="form-control" id="il" name="il" required>
                <option value="">İl Seçiniz</option>
                <?php
                    function getIller() {
                        try {
                            $db = new PDO("mysql:host=localhost;dbname=k_kayit", "root", "");
                            $stmt = $db->prepare("SELECT * FROM iller");
                            $stmt->execute();
                            return $stmt->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            error_log("İl verileri alınamadı: " . $e->getMessage(), 0);
                            die();
                        }
                    }
                    $iller = getIller();
                    foreach ($iller as $il) {
                        echo '<option value="' . $il["il_adi"] . '">' . $il["il_adi"] . '</option>';
                    }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="mesaj">Mesajınız</label>
            <textarea class="form-control" id="mesaj" name="mesaj" rows="5" placeholder="Mesajınızı veya istek/öneri,şikayetlerinizi buraya yazın..." required></textarea>
        </div>
        <div class="form-group">
            <label for="adres">Adresiniz</label>
            <input type="text" class="form-control" id="adres" name="adres" placeholder="Adresinizi yazın" required>
        </div>
        <button type="submit" class="btn btn-custom btn-block">Gönder</button>
    </form>
</div>

<br>
<br>
<br>
<br>
<br>
<div class="footer">
    &copy; 2024 Hawk Oto Galeri. Tüm hakları saklıdır.
</div>
</div>
  </body>
</html>

