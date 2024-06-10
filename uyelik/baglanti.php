<?php
$host = "localhost";
$kullanici = "root";
$parola = "";
$dbname = "uyelik";


$baglanti = mysqli_connect($host,$kullanici,$parola,$dbname);
mysqli_set_charset($baglanti,"UTF8");


?>
