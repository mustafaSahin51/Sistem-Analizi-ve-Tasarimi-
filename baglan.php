<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uyelik";

// Veritabanına bağlanma
$conn_uyelik = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn_uyelik->connect_error) {
    die("Bağlantı hatası: " . $conn_uyelik->connect_error);
}
?>
