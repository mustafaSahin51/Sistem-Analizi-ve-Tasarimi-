<?php
session_start();
include('baglan.php'); // Üyelik veritabanı bağlantısı
include('error_handler.php');

// Oto Galeri veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "";
$dbname_oto_galeri = "oto_galeri";

$conn_oto_galeri = new mysqli($servername, $username, $password, $dbname_oto_galeri);

if ($conn_oto_galeri->connect_error) {
    die("Oto Galeri bağlantı hatası: " . $conn_oto_galeri->connect_error);
}

$conn_k_kayit = new mysqli($servername, $username, $password, "k_kayit");

if ($conn_k_kayit->connect_error) {
    die("K_Kayit veritabanı bağlantı hatası: " . $conn_k_kayit->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $email = $_POST['email'];
    $adres = $_POST['adres'];
    $sehir = $_POST['sehir'];
    $posta_kodu = $_POST['posta_kodu'];
    $ulke = $_POST['ulke'];
    $kart_adi = $_POST['kart_adi'];
    $kart_numarasi = $_POST['kart_numarasi'];
    $kart_son_kullanma_tarihi = $_POST['kart_son_kullanma_tarihi'];
    $kart_cvv = $_POST['kart_cvv'];
    $arac_id = $_POST['arac_id'] ?? null;

    if ($arac_id) {
        $query = "INSERT INTO odeme (ad, soyad, email, adres, sehir, posta_kodu, ulke, kart_adi, kart_numarasi, kart_son_kullanma_tarihi, kart_cvv, arac_id) 
                  VALUES ('$ad', '$soyad', '$email', '$adres', '$sehir', '$posta_kodu', '$ulke', '$kart_adi', '$kart_numarasi', '$kart_son_kullanma_tarihi', '$kart_cvv', '$arac_id')";

        if (mysqli_query($conn_uyelik, $query)) {
            $delete_query = "DELETE FROM araclar WHERE id='$arac_id'; DELETE FROM ikinci_el_araclar WHERE id='$arac_id'";
            if (mysqli_multi_query($conn_oto_galeri, $delete_query)) {
                do {
                    // Her bir sonuç setini boşaltmak için bu döngüyü kullanın
                    if ($result = mysqli_store_result($conn_oto_galeri)) {
                        mysqli_free_result($result);
                    }
                } while (mysqli_more_results($conn_oto_galeri) && mysqli_next_result($conn_oto_galeri));
                echo "<script>alert('Ödeme başarılı bir şekilde kaydedildi. Sizinle iletişime geçeceğiz.');</script>";
                echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 3000);</script>";
            } else {
                echo "<script>alert('Hata: Araç silinirken bir sorun oluştu.');</script>";
            }
        } else {
            echo "<script>alert('Hata: " . mysqli_error($conn_uyelik) . "');</script>";
        }
    } else {
        echo "<script>alert('Lütfen bir araç seçin.');</script>";
    }
}

// Kampanya bilgileri
$kampanyalar = [
    ["id" => 1, "ad" => "Kampanya 1: %10 indirim!"],
    ["id" => 2, "ad" => "Kampanya 2: 12 ay taksit imkanı!"],
    ["id" => 3, "ad" => "Kampanya 3: Ücretsiz bakım!"]
];

// Oto Galeri veritabanından araç bilgilerini çekiyoruz
$araclar_query = "SELECT id, marka, model, fiyat FROM araclar UNION SELECT id, marka, model, fiyat FROM ikinci_el_araclar";
$araclar_result = mysqli_query($conn_oto_galeri, $araclar_query);
$araclar = [];
while ($row = mysqli_fetch_assoc($araclar_result)) {
    $araclar[] = $row;
}

// Şehirleri K_Kayit veritabanından çekiyoruz
$iller_query = "SELECT id, il_adi FROM iller";
$iller_result = mysqli_query($conn_k_kayit, $iller_query);
$iller = [];
while ($row = mysqli_fetch_assoc($iller_result)) {
    $iller[] = $row;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ödeme Sayfası</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000;
            color: #fff;
        }
        .form-control {
            background-color: #333;
            color: #fff;
        }
        .form-select {
            background-color: #333;
            color: #fff;
        }
        .btn-custom {
            background-color: #ff6600;
            color: #fff;
            border: none;
        }
        .btn-custom:hover {
            background-color: #e65c00;
        }
    </style>
    <script>
        function updatePrice() {
            var select = document.getElementById('arac_id');
            var priceInput = document.getElementById('fiyat');
            var selectedOption = select.options[select.selectedIndex];
            priceInput.value = selectedOption.getAttribute('data-price');
        }
    </script>
</head>
<body>
    <div class="container">
        <main>
            <div class="py-5 text-center">
                <h2>Ödeme Formu</h2>
            </div>
            <div class="row g-5">
                <div class="col-md-7 col-lg-8 mx-auto">
                    <h4 class="mb-3">Fatura Adresi</h4>
                    <form class="needs-validation" novalidate method="post" action="odeme.php">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="ad" class="form-label">Ad</label>
                                <input type="text" class="form-control" id="ad" name="ad" required>
                                <div class="invalid-feedback">
                                    Geçerli bir ad gereklidir.
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label for="soyad" class="form-label">Soyad</label>
                                <input type="text" class="form-control" id="soyad" name="soyad" required>
                                <div class="invalid-feedback">
                                    Geçerli bir soyad gereklidir.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label">E-posta</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">
                                    Lütfen geçerli bir e-posta adresi girin.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="adres" class="form-label">Adres</label>
                                <input type="text" class="form-control" id="adres" name="adres" required>
                                <div class="invalid-feedback">
                                    Lütfen adresinizi girin.
                                </div>
                            </div>

                            <div class="col-md-5">
                                <label for="ulke" class="form-label">Ülke</label>
                                <select class="form-select" id="ulke" name="ulke" required>
                                    <option value="">Seç...</option>
                                    <option>Türkiye</option>
                                </select>
                                <div class="invalid-feedback">
                                    Lütfen geçerli bir ülke seçin.
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="sehir" class="form-label">Şehir</label>
                                <select class="form-select" id="sehir" name="sehir" required>
                                    <option value="">Seç...</option>
                                    <?php foreach ($iller as $il): ?>
                                        <option value="<?= $il['il_adi'] ?>"><?= $il['il_adi'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    Lütfen geçerli bir şehir seçin.
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="posta_kodu" class="form-label">Posta Kodu</label>
                                <input type="text" class="form-control" id="posta_kodu" name="posta_kodu" required>
                                <div class="invalid-feedback">
                                    Posta kodu gereklidir.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="arac_id" class="form-label">Araç Seçimi</label>
                                <select class="form-select" id="arac_id" name="arac_id" onchange="updatePrice()" required>
                                    <option value="">Araç Seç...</option>
                                    <?php foreach ($araclar as $arac): ?>
                                        <option value="<?= $arac['id'] ?>" data-price="<?= $arac['fiyat'] ?>"><?= $arac['marka'] . ' ' . $arac['model'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    Lütfen geçerli bir araç seçin.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="fiyat" class="form-label">Araç Fiyatı</label>
                                <input type="text" class="form-control" id="fiyat" name="fiyat" readonly>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h4 class="mb-3">Ödeme</h4>

                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label for="kart_adi" class="form-label">Kart Üzerindeki İsim</label>
                                <input type="text" class="form-control" id="kart_adi" name="kart_adi" required>
                                <div class="invalid-feedback">
                                    Kart üzerinde yazan isim gereklidir.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="kart_numarasi" class="form-label">Kart Numarası</label>
                                <input type="text" class="form-control" id="kart_numarasi" name="kart_numarasi" required>
                                <div class="invalid-feedback">
                                    Kart numarası gereklidir.
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="kart_son_kullanma_tarihi" class="form-label">Son Kullanma Tarihi</label>
                                <input type="text" class="form-control" id="kart_son_kullanma_tarihi" name="kart_son_kullanma_tarihi" required>
                                <div class="invalid-feedback">
                                    Son kullanma tarihi gereklidir.
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="kart_cvv" class="form-label">CVV</label>
                                <input type="text" class="form-control" id="kart_cvv" name="kart_cvv" required>
                                <div class="invalid-feedback">
                                    CVV kodu gereklidir.
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <button class="w-100 btn btn-custom btn-lg" type="submit">Ödemeyi Tamamla</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        (function () {
            'use strict'

            var forms = document.querySelectorAll('.needs-validation')

            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        function updatePrice() {
            var select = document.getElementById('arac_id');
            var priceInput = document.getElementById('fiyat');
            var selectedOption = select.options[select.selectedIndex];
            priceInput.value = selectedOption.getAttribute('data-price');
        }
    </script>
</body>
</html>
