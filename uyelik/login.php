<?php
include("baglanti.php");

session_start();

$kullanici_adi_hata = $parola_hata = "";
$giris_basarili = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CSRF token doğrulama
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Geçersiz CSRF token");
    }

    $kullanici_adi = mysqli_real_escape_string($baglanti, $_POST["kullaniciadi"]);
    $parola = mysqli_real_escape_string($baglanti, $_POST["parola"]);

    // Kullanıcı adı uzunluk kontrolü
    if (strlen($kullanici_adi) < 5) {
        $kullanici_adi_hata = "Kullanıcı adı en az 5 karakter olmalıdır.";
    }

    // Parola uzunluk kontrolü
    if (strlen($parola) < 8) {
        $parola_hata = "Parola en az 8 karakter olmalıdır.";
    }

    // Kullanıcı girişi kontrolü
    if (empty($kullanici_adi_hata) && empty($parola_hata)) {
        $sorgu = $baglanti->prepare("SELECT * FROM kullanicilar WHERE kullanici_adi = ?");
        $sorgu->bind_param("s", $kullanici_adi);
        $sorgu->execute();
        $sonuc = $sorgu->get_result();

        if ($sonuc->num_rows == 1) {
            $kullanici = $sonuc->fetch_assoc();
            if (password_verify($parola, $kullanici['parola'])) {
                $giris_basarili = true;
                $_SESSION['kullanici_adi'] = $kullanici_adi;
                $_SESSION['email'] = $kullanici['e_mail'];
                header("Location: ../index.php");
                exit;
            } else {
                $parola_hata = "Parola yanlış.";
            }
        } else {
            $kullanici_adi_hata = "Kullanıcı bulunamadı.";
        }
    }
}

// CSRF token oluşturma
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Üye Giriş</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #121212;
            color: #484848;
        }
        .card {
            background-color: #1e1e1e;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        max-width: 400px;
        margin: 0 auto;
        margin-top: 100px;
        color: #ffffff;
        }
        .btn-primary {
            background-color: #6200ea;
            border-color: #3700b3;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #3700b3;
            border-color: #6200ea;
        }
        .giris-link a {
            color: #bb86fc;
        text-decoration: underline;
        }
        .giris-link a:hover {
            text-decoration: underline;
        }
        .invalid-feedback {
            color: #cf6679;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card p-5">
        <?php if ($giris_basarili): ?>
            <div class="alert alert-success" role="alert">
                Giriş Başarılı! Yönlendiriliyorsunuz...
            </div>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Kullanıcı Adı</label>
                <input type="text" class="form-control <?php echo (!empty($kullanici_adi_hata)) ? 'is-invalid' : ''; ?>" id="exampleInputEmail1" name="kullaniciadi">
                <div class="invalid-feedback">
                    <?php echo $kullanici_adi_hata; ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Parola</label>
                <div class="input-group">
                    <input type="password" class="form-control <?php echo (!empty($parola_hata)) ? 'is-invalid' : ''; ?>" id="exampleInputPassword1" name="parola">
                    <button class="btn btn-outline-secondary" type="button" id="parolaGoster">Göster</button>
                </div>
                <div class="invalid-feedback">
                    <?php echo $parola_hata; ?>
                </div>
            </div>

            <button type="submit" name="giris" class="btn btn-primary">Giriş Yap</button>
            <br><br>
            <div class="giris-link">
                Üye değil misiniz? <a href="kayit.php">Hemen kayıt olun.</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Parolayı gösterme/gizleme işlevi
    var parolaInput = document.getElementById('exampleInputPassword1');
    var parolaGosterButton = document.getElementById('parolaGoster');

    parolaGosterButton.addEventListener('click', function() {
        if (parolaInput.type === 'password') {
            parolaInput.type = 'text';
            parolaGosterButton.textContent = 'Gizle';
        } else {
            parolaInput.type = 'password';
            parolaGosterButton.textContent = 'Göster';
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
