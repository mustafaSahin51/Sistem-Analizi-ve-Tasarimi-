# Sistem analizi dersi otomasyon proje dosyaları

Bu depoda veri büyüklüğü açısından resim dosyalarının tamamı bulunmamaktadır. !

Sistem analizi dersi oto galeri otomasyonu web projesi dosyaları. 

Hawk Oto Galeri : Bir araç galerisi web otomasyonu

Bu sitenin içeriği 

Anasayfa
Hakkımızda 
Sıfır Araçlar
İkinci El Araçlar
Kampanyalar
Satın Alma 
İletişim
Bülten
Giriş ve Kayıt Sayfaları
Admin yönetici Paneli 
Odeme sayfası 

Bu web sitesinde satışa sunulan sıfır ve ikinci el araçları satın alabilir oto galeri hakkında detaylı bilgilere sahip olabilirsiniz
İletişim metnini doldurarak sayfa hakkında istek şikayet ve önerilerinizi yazabilir ve kampanyalardan yararlanabilirsiniz.

                                KLASÖRLER
vendor klasörü mail işlemleri için composer dosyalarını vs içermektedir fakat Google Mail hataları sebebiyle mail gönderimi yapılmamaktadır.

uyelik klasöründe kullanıcının veritabanına üyelik işlemleri yapılmaktadır.

uploads klasörü eklenen araçların resimlerini içermektedir

maiL işlemleri klasörü mail işlemi için gerekli yolları ve dosyaları gösterir ve anlatır.

images2,images ve imagesindex klasörlerinde fazla resimler bulunabilir bu resimler sitenin hazırlık aşamasında ve daha sonrasında kullanılmak üzere bu klasörlerde tutulmaktadır 


                                DOSYALAR

index.php dosyası Anasayfaya gider ve sayfada bulunan iletişim formuyla kullanıcının bilgilerini alabilir giriş yapmasını ve diğer menülere erişimini sağlayabilir.
admin_giris.php dosyası admin girişinde kullanıcının giriş bilgilerini sormak için kullanılır admin bilgileri kod ile atanmıştır.
admin_panel.php dosyası araç ekleme kullanıcı bilgilerini görme ve kullanıcı silme ikinci el araç ekleme işlemleri yapabilir.

adminstyle.css admin_panel ve admin_giris dosyalarının stil düzenlemelerinin yapıldığı kod dosyasıdır.
arac_ekle ve arac_sil dosyaları admin panelinden araç silebilir.
baglan.php uyelik veritabanına baglanır
baglantisatis dosyası ilgili aracın satışı için gerekli php kodları içermektedir
bulten dosyası arac haberleri için oluşturulmuş bir sayfanın dosyasıdır.
cikis dosyası giriş yapan kullanıcının oturumunu sonlandırır
config dosyası admin paneli için veritabanı bağlantısı yapar 
hakkimizda dosyası hakkımızda sayfasını oluşturur 
ikinci_el_arac_ekle ve sil dosyaları admin panelinde ikinci el araçlar eklemeyi sağlayabilir
ilet.php iletişim sayfasını oluşturur
indexstyle.css hem diğer sayfaların hem anasayfanın css düzenlemelerini içermektedir.
kampanya.php Kampanyalar sayfasını oluşturur
kullanici_sil.php admin panelinden kullanıcı silme işlemini gerçekleştirir
logout.php admin panelinden çıkış yapar oturumu kapatır.
odeme.php satın alma sayfasında aracın satın alınıyorsa odeme bilgilerini girmesi için oluşturulmuştur.
satin_al dosyası satın alma sayfasını oluşturmaktadır
satiskosulları.php bültende bulunan satiş koşulları sayfasını oluştutur.
sifirarac.php sıfır araçlar sayfasını oluşturur
sss.php bültende bulunan sıkça sorulan sorular sayfasını oluşturur.
style.css dosyası ilgili sayfaların stil düzenlemelerini içermektedir.
