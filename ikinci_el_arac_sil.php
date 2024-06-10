<?php
session_start();
include 'config.php';
include('error_handler.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['arac_id'])) {
        $arac_id = $_POST['arac_id'];

        $stmt = $conn_oto_galeri->prepare("DELETE FROM ikinci_el_araclar WHERE id = ?");
        $stmt->bind_param("i", $arac_id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "İkinci el araç başarıyla silindi.";
        } else {
            $_SESSION['success_message'] = "İkinci el araç silinirken bir hata oluştu: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['success_message'] = "Geçersiz araç ID.";
    }

    header('Location: admin_panel.php');
    exit();
}
?>
