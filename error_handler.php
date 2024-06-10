<?php
function customError($errno, $errstr, $errfile, $errline) {
    // Hata detaylarını log dosyasına yazma
    error_log("Error: [$errno] $errstr - $errfile:$errline", 3, "error_log.log");

    // 404 sayfasına yönlendirme
    header("Location: 404.php");
    exit();
}

// Kullanıcı tanımlı hata işleyicisini ayarla
set_error_handler("customError");

// Exception'ları yakalamak için exception handler
function customException($exception) {
    // Exception detaylarını log dosyasına yazma
    error_log("Exception: " . $exception->getMessage(), 3, "error_log.log");

    // 404 sayfasına yönlendirme
    header("Location: 404.php");
    exit();
}

// Kullanıcı tanımlı exception işleyicisini ayarla
set_exception_handler("customException");
?>
