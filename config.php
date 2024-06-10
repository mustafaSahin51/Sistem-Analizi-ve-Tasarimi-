<?php
// Oto Galeri veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "";
$dbname_oto_galeri = "oto_galeri";

$conn_oto_galeri = mysqli_connect($servername, $username, $password, $dbname_oto_galeri);

if (!$conn_oto_galeri) {
    die("Oto Galeri veritabanına bağlantı hatası: " . mysqli_connect_error());
}

// Uyelik veritabanı bağlantısı
$dbname_uyelik = "uyelik";

$conn_uyelik = mysqli_connect($servername, $username, $password, $dbname_uyelik);

if (!$conn_uyelik) {
    die("Uyelik veritabanına bağlantı hatası: " . mysqli_connect_error());
}
?>
