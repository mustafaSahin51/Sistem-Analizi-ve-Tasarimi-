<?php
include("baglanti.php");

session_start();

$ad_hata = $email_hata = $parola_hata = $parola_tekrar_hata = "";
$eklendi = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CSRF token doğrulama
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Geçersiz CSRF token");
    }

    $name = mysqli_real_escape_string($baglanti, $_POST["kullaniciadi"]);
    $email = mysqli_real_escape_string($baglanti, $_POST["email"]);
    $password = mysqli_real_escape_string($baglanti, $_POST["parola"]);
    $password_repeat = mysqli_real_escape_string($baglanti, $_POST["parola_tekrar"]);

    // Uzunluk kontrolü
    if (strlen($name) < 5) {
        $ad_hata = "Kullanıcı adı en az 5 karakter olmalıdır.";
    }

    // Kullanıcı adı format kontrolü
    if (!preg_match('/^[a-zA-Z0-9_.]+$/', $name)) {
        $ad_hata = "Kullanıcı adı sadece harf, rakam, alt çizgi (_) ve nokta (.) içerebilir.";
    }

    if (strlen($email) < 5) {
        $email_hata = "Email en az 5 karakter olmalıdır.";
    }

    // E-posta format kontrolü
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_hata = "Geçersiz e-posta formatı.";
    }

    if (strlen($password) < 8) {
        $parola_hata = "Parola en az 8 karakter olmalıdır.";
    }

    // Parola tekrar kontrolü
    if (empty($password_repeat)) {
        $parola_tekrar_hata = "Parola tekrar boş bırakılamaz.";
    } elseif ($password != $password_repeat) {
        $parola_tekrar_hata = "Parolalar eşleşmiyor.";
    }

    // Şifreyi görünmez kılma
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Form doğrulaması
    if (empty($ad_hata) && empty($email_hata) && empty($parola_hata) && empty($parola_tekrar_hata)) {
        $ekle = $baglanti->prepare("INSERT INTO kullanicilar (kullanici_adi, e_mail, parola) VALUES (?, ?, ?)");
        $ekle->bind_param("sss", $name, $email, $hashed_password);
        if ($ekle->execute()) {
            $eklendi = true;
        } else {
            echo '<div class="alert alert-danger" role="alert">
            Bir sorun oluştu. Lütfen Yönetici ile iletişime geçiniz.
            </div>';
        }
    }
}

// CSRF token oluşturma
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Oturumu sonlandırma kodunu kaldırdım çünkü CSRF tokeni kullanmak için oturumun açık kalması gerekiyor.
// session_unset();
// session_destroy();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Üyelik</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
    body {
        background-color: #121212;
        color: #ffffff;
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
    .login-link {
        text-align: center;
        margin-top: 10px;
    }
    .login-link a {
        color: #bb86fc;
        text-decoration: underline;
    }
    .login-link a:hover {
        color: #bb86fc;
        text-decoration: underline;
    }
    .invalid-feedback {
        color: #cf6679;
    }
    label, .form-label, .btn, .login-link a {
        color: #ffffff; /* Yazıların beyaz yapılması */
    }
</style>
</head>
<body>
<div class="container">
    <div class="card p-5">
        <?php if ($eklendi): ?>
            <div class="alert alert-success" role="alert">
                Kayıt Başarılı Şekilde Eklenmiştir
            </div>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Kullanıcı Adı</label>
                <input type="text" class="form-control <?php echo (!empty($ad_hata)) ? 'is-invalid' : ''; ?>" id="exampleInputEmail1" name="kullaniciadi">
                <div class="invalid-feedback">
                    <?php echo $ad_hata; ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control <?php echo (!empty($email_hata)) ? 'is-invalid' : ''; ?>" id="exampleInputEmail1" name="email" placeholder="örnek@example.com">
                <div class="invalid-feedback">
                    <?php echo $email_hata; ?>
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

            <div class="mb-3">
                <label for="exampleInputPassword2" class="form-label">Parola Tekrar</label>
                <div class="input-group">
                    <input type="password" class="form-control <?php echo (!empty($parola_tekrar_hata)) ? 'is-invalid' : ''; ?>" id="exampleInputPassword2" name="parola_tekrar">
                    <button class="btn btn-outline-secondary" type="button" id="parolaTekrarGoster">Göster</button>
                </div>
                <div class="invalid-feedback">
                    <?php echo $parola_tekrar_hata; ?>
                </div>
            </div>

            <button type="submit" name="kaydet" class="btn btn-primary">Kayıt Ol</button>
        </form>
        <div class="login-link">
            Zaten üye misiniz? <a href="login.php">Giriş yap</a>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var emailInput = document.querySelector('input[name="email"]');
    var emailPlaceholder = emailInput.getAttribute('placeholder');

    emailInput.addEventListener("focus", function() {
        this.placeholder = '';
    });

    emailInput.addEventListener("blur", function() {
        if (this.value == '') {
            this.placeholder = emailPlaceholder;
        }
    });

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

    // Parola tekrar alanı için gösterme/gizleme işlevi
    var parolaTekrarInput = document.getElementById('exampleInputPassword2');
    var parolaTekrarGosterButton = document.getElementById('parolaTekrarGoster');

    parolaTekrarGosterButton.addEventListener('click', function() {
        if (parolaTekrarInput.type === 'password') {
            parolaTekrarInput.type = 'text';
            parolaTekrarGosterButton.textContent = 'Gizle';
        } else {
            parolaTekrarInput.type = 'password';
            parolaTekrarGosterButton.textContent = 'Göster';
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
