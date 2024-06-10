<?php
session_start();
include 'config.php';
include('error_handler.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $marka = $_POST['marka'];
    $model = $_POST['model'];
    $yil = $_POST['yil'];
    $fiyat = $_POST['fiyat'];
    $resim = $_FILES['resim']['name'];
    $resim_tmp = $_FILES['resim']['tmp_name'];

    $resim_yolu = 'uploads/' . basename($resim);
    move_uploaded_file($resim_tmp, $resim_yolu);

    $query = "INSERT INTO araclar (marka, model, yil, fiyat, resim) VALUES ('$marka', '$model', '$yil', '$fiyat', '$resim_yolu')";
    if (mysqli_query($conn_oto_galeri, $query)) {
        $_SESSION['success_message'] = "Araç başarıyla eklendi.";
    } else {
        $_SESSION['error_message'] = "Araç eklenirken bir hata oluştu.";
    }

    header('Location: admin_panel.php');
    exit();
}
?>
