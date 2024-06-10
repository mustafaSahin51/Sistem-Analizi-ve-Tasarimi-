<!--Kullanıcı adı :  admin-->
<!-- Şifre : admin123 -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'config.php';
include('error_handler.php');


if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $conn_oto_galeri->prepare("SELECT * FROM admin WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin'] = $user['username'];
        header('Location: admin_panel.php');
        exit();
    } else {
        $hata_mesaji = "Kullanıcı adı veya şifre yanlış.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Giriş</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-form {
            background: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 300px;
        }
        .login-form h2 {
            margin-bottom: 20px;
        }
        .login-form label {
            color: #ffffff;
        }
        .login-form button {
            background-color: #6200ea;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
        .login-form button:hover {
            background-color: #3700b3;
        }
        .login-form .alert {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <form class="login-form" method="post" action="">
        <h4>Admin Girişi</h4>
        <?php if (isset($hata_mesaji)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $hata_mesaji; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password">Şifre:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button type="submit" name="login">Giriş Yap</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
