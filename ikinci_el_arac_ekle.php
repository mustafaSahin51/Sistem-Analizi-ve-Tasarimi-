<?php
session_start();
include 'config.php';
include('error_handler.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $marka = $_POST['marka'];
    $model = $_POST['model'];
    $yil = $_POST['yil'];
    $fiyat = $_POST['fiyat'];

    // Resmi yükle
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($_FILES["resim"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["resim"]["tmp_name"]);

    if ($check !== false) {
        if (move_uploaded_file($_FILES["resim"]["tmp_name"], $target_file)) {
            // Veritabanına kaydet
            $resim_yolu = $target_file;
            $sql = "INSERT INTO ikinci_el_araclar (marka, model, yil, fiyat, resim) VALUES ('$marka', '$model', '$yil', '$fiyat', '$resim_yolu')";

            if (mysqli_query($conn_oto_galeri, $sql)) {
                $_SESSION['success_message'] = "İkinci el araç başarıyla eklendi.";
            } else {
                $_SESSION['error_message'] = "Hata: " . mysqli_error($conn_oto_galeri);
            }
        } else {
            $_SESSION['error_message'] = "Resim yüklenirken hata oluştu.";
        }
    } else {
        $_SESSION['error_message'] = "Yüklenen dosya bir resim değil.";
    }

    header('Location: admin_panel.php');
    exit();
}
?>
