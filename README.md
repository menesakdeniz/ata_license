# ata_license
ÖZEL LISANSLAMA LUA

# PHP'ye Eklenicekler

Özellikler
-------------------
*Bir sunucuya ya da hepsine birden duyuru yapma (WebHook)

*Sunucu durumunu görme ve değiştirme.

*Sunucudaki kisi sayisini gorme

*Kayitli bilgileri duzenleme

*Kullanici sifre sifirlama talebi

*E-posta bilgi gonderme

*Kullanici ve data silme

*Paket ekleme ve paket ile lisanslama


# Bütün hakları Mustafa Ata'ya aittir çalınması veya kopyasının kullanılması yasaktır.

1-KURULUM​
-------------------

Öncelikle verdiğim sql dosyasını database'inize okutunuz.​

Eğer webhosting kullanıyosanız config.php içindeki database bağlantı bilgilerini değiştirin.​

XAMPP üzerine kuruyosanız değiştirmenize gerek yok bende localhost da kullandım.​

Daha sonra creator/sets/letcode.php deki kodun ipwithspaces yerini kendi adresinize uygun değiştirin​

Eğer mail serveriniz varsa unverified/sets/sendmail.php yi kendi serverinize göre uygulayın(E-Posta doğrulama sağlar)​

Eğer mail serveriniz yoksa config.php deki $enablemail = true'yu false yapın.(E-Posta doğrulama kapatır)​

Database kullanıcı adınız root ve şifreniz olmaması lazım ve database'in adı fivem olması lazım.​

Eğer UUID(Her sisteme özel uniq kod) ile lisanslama yapmak isterseniz(daha sağlam ve güvenilir) letcode.php'deki kodun ilk satırını local f = io.popen(wmic csproduct get uuid')
olarak değiştirin.​

2-ÖZELLİKLER​
-------------------

E-Posta doğrulama sistemi.​

Lisans ekleme otomasyonu.​

Gelişmiş admin menüsü.​

Uzaktan sunucu bilgilerini görme.​

2 Çeşit lisanslama seçeneği(IP veya (BIOS SERI NUMARASI veya UUID)).
