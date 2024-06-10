<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}
if (!isset($_SESSION['admin'])) {
    header('Location: admin_giris.php');
    exit();
}
include('error_handler.php');

include 'config.php';

// Grafik verileri için rastgele satış ve zarar verileri oluşturma
$years = range(2015, 2024);
$sales_data = [];
$loss_data = [];
foreach ($years as $year) {
    $sales_data[] = rand(50, 200);
    $loss_data[] = rand(10, 50);
}

// Kullanıcı verilerini çekme
$users_query = "SELECT * FROM kullanicilar"; // Tablo adı kullanicilar olarak güncellendi
$users_result = mysqli_query($conn_uyelik, $users_query);
if (!$users_result) {
    die('Sorgu hatası: ' . mysqli_error($conn_uyelik));
}
$users = mysqli_fetch_all($users_result, MYSQLI_ASSOC);

// Araç verilerini çekme
$cars_query = "SELECT * FROM araclar";
$cars_result = mysqli_query($conn_oto_galeri, $cars_query);
if (!$cars_result) {
    die('Sorgu hatası: ' . mysqli_error($conn_oto_galeri));
}
$cars = mysqli_fetch_all($cars_result, MYSQLI_ASSOC);

// İkinci el araç verilerini çekme
$second_hand_cars_query = "SELECT * FROM ikinci_el_araclar";
$second_hand_cars_result = mysqli_query($conn_oto_galeri, $second_hand_cars_query);
if (!$second_hand_cars_result) {
    die('Sorgu hatası: ' . mysqli_error($conn_oto_galeri));
}
$second_hand_cars = mysqli_fetch_all($second_hand_cars_result, MYSQLI_ASSOC);

// Sosyal medya verileri oluşturma
$social_data = [
    'Instagram' => array_map(fn() => rand(1000, 5000), $years),
    'Twitter' => array_map(fn() => rand(1000, 5000), $years),
    'Facebook' => array_map(fn() => rand(1000, 5000), $years),
    'LinkedIn' => array_map(fn() => rand(1000, 5000), $years),
];
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Paneli</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="adminstyle.css">
    <style>
      #chartdiv {
  width: 100%;
  height: 500px;
}

    </style>
</head>
<div>



        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Admin Paneli/Anasayfa</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#kar_zarar_oranlari">Kâr & Zarar Oranları</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#satis_oranlari">Satış Oranları </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#kullanicilar">Kullanıcılarımız </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#harcamalar">Harcamalarımız</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#entegrasyonlar">Entegrasyonlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#arac_islemleri">Araç Ekle/Sil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#ikinci_el_araclar">İkinci El Araç Ekle/Sil</a>
                </li>
             </ul>
            </div>
        </nav>

        <div class="container">
       


        <!-- Session mesajını göster -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                <?= $_SESSION['message'] ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <br>
        <br>
        <br>

        <div id="kar_zarar_oranlari" class="mt-4">
            <h3>Kâr & Zarar Oranları</h3>
            <canvas id="profitLossChart"></canvas>
        </div>
        <div id="satis_oranlari" class="mt-4">
            <h3>Satış Oranları</h3>
            <canvas id="salesChart"></canvas>
        </div>
        <div id="kullanicilar" class="mt-4">
    <h3>Kullanıcılarımız</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kullanıcı Adı</th>
                <th>E-mail</th>
                <th>Kayıt Tarihi</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['kullanici_adi'] ?></td>
                    <td><?= $user['e_mail'] ?></td>
                    <td><?= $user['kayit_tarihi'] ?></td>
                    <td>
                        <form action="kullanici_sil.php" method="POST" style="display:inline;">
                            <input type="hidden" name="kullanici_id" value="<?= $user['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?');">Sil</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

        <div id="harcamalar" class="mt-4">
            <h3>Harcama Alanlarımız</h3>
            <div id="chartdiv"></div>
        </div>
        <div id="entegrasyonlar" class="mt-4">
            <h3>Entegrasyonlar</h3>
            <p>Firmamızın sunduğu araç galerisi entegrasyonu sayesinde, web sitenize veya mobil uygulamanıza kolayca araç galerisi ekleyebilirsiniz. Entegrasyonumuz, geniş bir araç veritabanına erişim sağlayarak, kullanıcılarınızın araçları filtreleyip arama yapmasını ve detaylı bilgilere ulaşmasını kolaylaştırır.

Entegrasyonumuzun sunduğu özellikler:

<p>Geniş Araç Veritabanı: Binlerce araç modeli ve markasıyla güncel araç veritabanına erişim sağlayın.</p>

<p>Filtreleme ve Arama Seçenekleri: Kullanıcılarınıza marka, model, fiyat aralığı, kilometre ve daha fazlasına göre arama ve filtreleme yapma imkanı sunun.</p>

<p>Detaylı Araç Bilgileri: Her araç için detaylı teknik özellikler, resim galerisi ve fiyat bilgisi gibi önemli detayları sunun.</p>

<p>Kullanıcı Dostu Arayüz: Entegrasyonumuz, kolayca anlaşılabilir ve kullanıcı dostu bir arayüze sahiptir, böylece kullanıcılarınız araçları rahatlıkla inceleyebilir.</p>

<p>Özelleştirme Seçenekleri: Arayüzü kendi marka ve tasarımınıza uyacak şekilde özelleştirme imkanı.</p>

<p>Araç galerisi entegrasyonumuzla müşterilerinize daha iyi bir alışveriş deneyimi sunun ve araçlarınızın görünürlüğünü artırın. Daha fazla bilgi için bizimle iletişime geçin.</p>

</p>
        
        <div id="arac_islemleri" class="mt-4">
            <h3>Araç Ekle/Sil</h3>
            <!-- Araç ekleme butonu -->
            <button id="showAddCarForm" class="btn btn-primary mb-3">Araç Ekle</button>
            
            <!-- Araç ekleme formu -->
            <form id="addCarForm" action="arac_ekle.php" method="post" enctype="multipart/form-data" style="display: none;">
                <div class="form-group">
                    <label for="marka">Marka</label>
                    <input type="text" class="form-control" id="marka" name="marka" required>
                </div>
                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" class="form-control" id="model" name="model" required>
                </div>
                <div class="form-group">
                    <label for="yil">Yıl</label>
                    <input type="number" class="form-control" id="yil" name="yil" required>
                </div>
                <div class="form-group">
                    <label for="fiyat">Fiyat</label>
                    <input type="text" class="form-control" id="fiyat" name="fiyat" required>
                </div>
                <div class="form-group">
                    <label for="resim">Resim</label>
                    <input type="file" class="form-control" id="resim" name="resim" required>
                </div>
                <button type="submit" class="btn btn-success">Araç Ekle</button>
            </form>

            <h4>Sıfır Araçlar</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Marka</th>
                        <th>Model</th>
                        <th>Yıl</th>
                        <th>Fiyat</th>
                        <th>Resim</th>
                        <th>Sil</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cars as $car): ?>
                        <tr>
                            <td><?= $car['id'] ?></td>
                            <td><?= $car['marka'] ?></td>
                            <td><?= $car['model'] ?></td>
                            <td><?= $car['yil'] ?></td>
                            <td><?= $car['fiyat'] ?></td>
                            <td><img src="<?= $car['resim'] ?>" alt="Araç Resmi" width="100"></td>
                            <td>
                                <form action="arac_sil.php" method="post">
                                    <input type="hidden" name="arac_id" value="<?= $car['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Sil</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="ikinci_el_araclar" class="mt-4">
            <h3>İkinci El Araçlar</h3>
            <!-- İkinci el araç ekleme butonu -->
            <button id="showAddSecondHandCarForm" class="btn btn-primary mb-3">İkinci El Araç Ekle</button>
            
            <!-- İkinci el araç ekleme formu -->
            <form id="addSecondHandCarForm" action="ikinci_el_arac_ekle.php" method="post" enctype="multipart/form-data" style="display: none;">
                <div class="form-group">
                    <label for="marka">Marka</label>
                    <input type="text" class="form-control" id="marka" name="marka" required>
                </div>
                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" class="form-control" id="model" name="model" required>
                </div>
                <div class="form-group">
                    <label for="yil">Yıl</label>
                    <input type="number" class="form-control" id="yil" name="yil" required>
                </div>
                <div class="form-group">
                    <label for="fiyat">Fiyat</label>
                    <input type="text" class="form-control" id="fiyat" name="fiyat" required>
                </div>
                <div class="form-group">
                    <label for="resim">Resim</label>
                    <input type="file" class="form-control" id="resim" name="resim" required>
                </div>
                <button type="submit" class="btn btn-success">İkinci El Araç Ekle</button>
            </form>

            <h4>Mevcut İkinci El Araçlar</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Marka</th>
                        <th>Model</th>
                        <th>Yıl</th>
                        <th>Fiyat</th>
                        <th>Resim</th>
                        <th>Sil</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($second_hand_cars as $car): ?>
                        <tr>
                            <td><?= $car['id'] ?></td>
                            <td><?= $car['marka'] ?></td>
                            <td><?= $car['model'] ?></td>
                            <td><?= $car['yil'] ?></td>
                            <td><?= $car['fiyat'] ?></td>
                            <td><img src="<?= $car['resim'] ?>" alt="Araç Resmi" width="100"></td>
                            <td>
                                <form action="ikinci_el_arac_sil.php" method="post">
                                    <input type="hidden" name="arac_id" value="<?= $car['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Sil</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
 <br>   
 <br>   
 <br>   
 <br>
 </div>
 <div class="footer">
    &copy; 2024 Hawk Oto Galeri. Tüm hakları saklıdır.
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function logout() {
        if (confirm("Çıkmak istediğinize emin misiniz?")) {
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 2000);
        }
    }

    document.getElementById('showAddCarForm').addEventListener('click', function() {
        var form = document.getElementById('addCarForm');
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    });

    document.getElementById('showAddSecondHandCarForm').addEventListener('click', function() {
        var form = document.getElementById('addSecondHandCarForm');
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    });

    var profitLossCtx = document.getElementById('profitLossChart').getContext('2d');
    var profitLossChart = new Chart(profitLossCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode($years) ?>,
            datasets: [
                {
                    label: 'Yıllık Kâr',
                    data: <?= json_encode($sales_data) ?>,
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Yıllık Zarar',
                    data: <?= json_encode($loss_data) ?>,
                    backgroundColor: 'rgba(255, 0, 0, 0.2)',
                    borderColor: 'rgba(255, 0, 0, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var salesCtx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode($years) ?>,
            datasets: [{
                label: 'Yıllık Satışlar',
                data: <?= json_encode($sales_data) ?>,
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<!-- Chart code -->
<script>
am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);

// Create chart
// https://www.amcharts.com/docs/v5/charts/radar-chart/
var chart = root.container.children.push(am5radar.RadarChart.new(root, {
  panX: false,
  panY: false,
  wheelX: "panX",
  wheelY: "zoomX",
  innerRadius: am5.percent(20),
  startAngle: -90,
  endAngle: 180
}));


// Data
var data = [{
  category: "Yeni Araç Tasarımları",
  value: 80,
  full: 100,
  columnSettings: {
    fill: chart.get("colors").getIndex(0)
  }
}, {
  category: "Satışlar",
  value: 35,
  full: 100,
  columnSettings: {
    fill: chart.get("colors").getIndex(1)
  }
}, {
  category: "Araçların Bakım Onarımı",
  value: 92,
  full: 100,
  columnSettings: {
    fill: chart.get("colors").getIndex(2)
  }
}, {
  category: "İnsan Kaynakları",
  value: 68,
  full: 100,
  columnSettings: {
    fill: chart.get("colors").getIndex(3)
  }
}];

// Add cursor
// https://www.amcharts.com/docs/v5/charts/radar-chart/#Cursor
var cursor = chart.set("cursor", am5radar.RadarCursor.new(root, {
  behavior: "zoomX"
}));

cursor.lineY.set("visible", false);

// Create axes and their renderers
// https://www.amcharts.com/docs/v5/charts/radar-chart/#Adding_axes
var xRenderer = am5radar.AxisRendererCircular.new(root, {
  //minGridDistance: 50
});

xRenderer.labels.template.setAll({
  radius: 10
});

xRenderer.grid.template.setAll({
  forceHidden: true
});

var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
  renderer: xRenderer,
  min: 0,
  max: 100,
  strictMinMax: true,
  numberFormat: "#'%'",
  tooltip: am5.Tooltip.new(root, {})
}));


var yRenderer = am5radar.AxisRendererRadial.new(root, {
  minGridDistance: 20
});

yRenderer.labels.template.setAll({
  centerX: am5.p100,
  fontWeight: "500",
  fontSize: 18,
  templateField: "columnSettings"
});

yRenderer.grid.template.setAll({
  forceHidden: true
});

var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
  categoryField: "category",
  renderer: yRenderer
}));

yAxis.data.setAll(data);


// Create series
// https://www.amcharts.com/docs/v5/charts/radar-chart/#Adding_series
var series1 = chart.series.push(am5radar.RadarColumnSeries.new(root, {
  xAxis: xAxis,
  yAxis: yAxis,
  clustered: false,
  valueXField: "full",
  categoryYField: "category",
  fill: root.interfaceColors.get("alternativeBackground")
}));

series1.columns.template.setAll({
  width: am5.p100,
  fillOpacity: 0.08,
  strokeOpacity: 0,
  cornerRadius: 20
});

series1.data.setAll(data);


var series2 = chart.series.push(am5radar.RadarColumnSeries.new(root, {
  xAxis: xAxis,
  yAxis: yAxis,
  clustered: false,
  valueXField: "value",
  categoryYField: "category"
}));

series2.columns.template.setAll({
  width: am5.p100,
  strokeOpacity: 0,
  tooltipText: "{category}: {valueX}%",
  cornerRadius: 20,
  templateField: "columnSettings"
});

series2.data.setAll(data);

// Animate chart and series in
// https://www.amcharts.com/docs/v5/concepts/animations/#Initial_animation
series1.appear(1000);
series2.appear(1000);
chart.appear(1000, 100);

}); // end am5.ready()
</script>
</body>
</html>
