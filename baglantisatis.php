<?php
$host = "localhost";
$dbname = "aracsatis";
$kullanici = "root";
$parola = "";

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname; charset=utf8", $kullanici, $parola);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $marka = $_POST["marka"];
        $model = $_POST["model"];
        $yil = $_POST["yil"];
        $kilometre = $_POST["kilometre"];
        $fiyat = $_POST["fiyat"];
        $renk = $_POST["renk"];
        $durumu = $_POST["durumu"];
        $motor_hacim = $_POST["motor_hacim"];
        $arac_ss_ad = $_POST["arac_ss_ad"];
        $motor_gucu = $_POST["motor_gucu"];
        $eklenen_tarih = date("Y-m-d H:i:s"); // Şu anki tarih ve saat
        $arac_yeri = $_POST["arac_yeri"];

        $sql = "INSERT INTO araclar (marka, model, yil, kilometre, fiyat, renk, durumu, motor_hacim, arac_ss_ad, motor_gucu, eklenen_tarih, arac_yeri) 
                VALUES (:marka, :model, :yil, :kilometre, :fiyat, :renk, :durumu, :motor_hacim, :arac_ss_ad, :motor_gucu, :eklenen_tarih, :arac_yeri)";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(":marka", $marka);
        $stmt->bindParam(":model", $model);
        $stmt->bindParam(":yil", $yil);
        $stmt->bindParam(":kilometre", $kilometre);
        $stmt->bindParam(":fiyat", $fiyat);
        $stmt->bindParam(":renk", $renk);
        $stmt->bindParam(":durumu", $durumu);
        $stmt->bindParam(":motor_hacim", $motor_hacim);
        $stmt->bindParam(":arac_ss_ad", $arac_ss_ad);
        $stmt->bindParam(":motor_gucu", $motor_gucu);
        $stmt->bindParam(":eklenen_tarih", $eklenen_tarih);
        $stmt->bindParam(":arac_yeri", $arac_yeri);

        $stmt->execute();

        // Başarı mesajı
        echo '<div class="alert alert-success" role="alert">
                Veritabanına başarıyla eklendi!
              </div>';
    }
} catch (PDOException $e) {
    // Hata mesajı
    echo '<div class="alert alert-danger" role="alert">
            Veritabanına eklenirken bir hata oluştu: ' . $e->getMessage() . '
          </div>';
    die();
}
?>
