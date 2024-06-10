<?php
include('baglan.php');
include('error_handler.php');

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Index Sayfası</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="indexstyle.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <style>
     body {
    background-color: #000; /* Siyah arka plan */
    color: #fff; /* Beyaz metin */
}

.container {
    margin-top: 50px;
}

.form-control {
    background-color: #333;
    color: #fff;
}

.btn-custom {
    background-color: #ff6600;
    color: #fff;
}

.footer {
    margin-top: 50px;
    text-align: center;
}

.chart-container {
    position: relative;
    margin: auto;
    height: 80vh;
    width: 80vw;
}

.row {
    margin-top: 20px;
}

.card {
    background-color: #222; /* Kart arka plan rengi */
    color: #fff; /* Kart metin rengi */
}




    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Hawk Oto Galeri</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                    <a class="nav-link" href="index.php">Anasayfa  </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="hakkimizda.php">Hakkımızda </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sifirarac.php">Sıfır Araçlar </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="araclistesi.php">İkinci El Araçlar  </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="kampanya.php">Kampanyalar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="satin_al.php">Satın Alma  </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ilet.php">İletişim </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ikinciel.php">Bülten  </a>
                </li>
                <?php
                session_start();
                if (isset($_SESSION['kullanici_adi'])) {
                    echo '<li class="nav-item"><a class="nav-link" href="#">' . htmlspecialchars($_SESSION['kullanici_adi']) . '</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Çıkış Yap</a></li>';
                } else {
                    echo '<li class="nav-item"><a class="nav-link" href="uyelik/login.php">Giriş Yap | </a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="uyelik/kayit.php">Kayıt Ol | </a></li>';
                }
                ?>

                <li class="nav-item">
                    <a class="nav-link" href="admin_giris.php">Admin Girişi</a>
                </li>
            </ul>
        </div>
    </nav>


<main class="container">
    <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
        <div class="col-lg-6 px-0">
            <h1 class="display-4 fst-italic">Hakkımızda</h1>
            <p class="lead my-3">Hawk oto galeri hakkında... </p>
        </div>
    </div>
</main>
<div class="b-example-divider"></div>
  <div class="container"> <h2>Hakkımızda</h2>
<p>Hawk Oto Galeri olarak, uzun yıllara dayanan deneyimimizle müşterilerimize kaliteli ve güvenilir ikinci el araçlar sunmaktan gurur duyuyoruz. Müşteri memnuniyetini ve güvenini her zaman en üst düzeyde tutarak, otomotiv sektöründe öncü bir konumda yer almaya çalışıyoruz.</p>
<p>Galerimizdeki her araç, titizlikle seçilmiş ve detaylı bir incelemeden geçirilmiştir. Güvenilirlik, kalite ve uygun fiyat politikamız sayesinde müşterilerimizin beklentilerini karşılamak için çalışıyoruz.</p>
<p>Profesyonel ekibimiz, müşterilerimizin ihtiyaçlarını anlamak ve en uygun çözümleri sunmak için her zaman hazırdır. İhtiyaçlarınıza uygun aracı bulmanıza yardımcı olmak için buradayız ve satış sonrası destek sunarak sizinle uzun vadeli bir ilişki kurmayı hedefliyoruz.</p>
<p>Güvenilirlik, şeffaflık ve müşteri odaklı hizmet anlayışıyla, Hawk Oto Galeri olarak otomobil alım ve satımında ilk tercihiniz olmayı amaçlıyoruz. Siz değerli müşterilerimizi galerimize bekliyor, kaliteli ve güvenilir araçlarımızı incelemeye davet ediyoruz.</p>
<p>Bizimle iletişime geçmekten çekinmeyin. Sizin için buradayız!</p> </div>
<div class="b-example-divider"></div>
  <div class="container">



    <h3>Satış İstatistikleri ve Araçların Geldiği Ülkeler </h3>
    <div class="row">
        <div class="col-md-6">
            <canvas id="salesChart"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="countryDistributionChart"></canvas>
        </div>
    </div>
</div>

<div class="container mt-5">
        <h1>Kazancınızın Grafiği</h1>
        <div class="btn-group mb-3" role="group" aria-label="Zaman Periyotları">
            <button type="button" class="btn btn-secondary" onclick="updateChart('1ay')">1 Ay</button>
            <button type="button" class="btn btn-secondary" onclick="updateChart('6ay')">6 Ay</button>
            <button type="button" class="btn btn-secondary" onclick="updateChart('1yil')">1 Yıl</button>
            <button type="button" class="btn btn-secondary" onclick="updateChart('5yil')">5 Yıl</button>
        </div>
        <canvas id="revenueChart" width="400" height="200"></canvas>
    </div>
<br>
<br>
<br>



<div id="chartdiv"></div>




<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>


<div class="footer">
    &copy; 2024 Hawk Oto Galeri. Tüm hakları saklıdır.
    <br>
    
    Güç ve Kazanç Bir Arada..
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-chart-geo@3.9.0/dist/chartjs-chart-geo.min.js"></script>
<script src="https://d3js.org/topojson.v1.min.js"></script>

<script>
    // Satış İstatistikleri için Çubuk Grafiği
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran'],
            datasets: [{
                label: 'Satış Miktarı',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Ülke Dağılımı için Pasta Grafiği
    const countryCtx = document.getElementById('countryDistributionChart').getContext('2d');
    const countryDistributionChart = new Chart(countryCtx, {
        type: 'pie',
        data: {
            labels: ['Amerika', 'Kanada', 'Almanya', 'Fransa', 'Türkiye', 'Diğer'],
            datasets: [{
                label: 'Ülkelere Göre Araç Dağılımı',
                data: [30, 20, 15, 10, 5, 20],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            return label + ': ' + value + '%';
                        }
                    }
                }
            }
        }
    });
</script>

<script>
    var ctx = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
            datasets: [
                {
                    label: 'Kazancımız',
                    data: [1200, 1900, 3000, 5000, 2000, 3000, 7000, 8000, 9000, 10000, 11000, 12000],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: true
                },
                {
                    label: 'Kullanıcı Kazancı',
                    data: [1500, 1600, 1700, 4000, 2500, 3100, 7300, 8200, 9500, 10200, 11500, 12500],
                    backgroundColor: 'rgba(0, 0, 0, 0)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1,
                    fill: false
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    function updateChart(period) {
        // Zaman periyoduna göre veri güncelleme işlemleri burada yapılacak
        var data1ay = [500, 700, 800, 1000, 1500, 2000, 2500, 3000, 3500, 4000, 4500, 5000];
        var data6ay = [3000, 4000, 5000, 6000, 7000, 8000, 9000, 10000, 11000, 12000, 13000, 14000];
        var data1yil = [1200, 1900, 3000, 5000, 2000, 3000, 7000, 8000, 9000, 10000, 11000, 12000];
        var data5yil = [2000, 3000, 5000, 7000, 10000, 12000, 14000, 16000, 18000, 20000, 22000, 24000];

        if (period === '1ay') {
            revenueChart.data.datasets[0].data = data1ay;
        } else if (period === '6ay') {
            revenueChart.data.datasets[0].data = data6ay;
        } else if (period === '1yil') {
            revenueChart.data.datasets[0].data = data1yil;
        } else if (period === '5yil') {
            revenueChart.data.datasets[0].data = data5yil;
        }

        revenueChart.update();
    }
    </script>



<!-- #region -->

<!-- #endregion -->
</body>
</html>