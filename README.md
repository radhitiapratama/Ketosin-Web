#### Syarat yang di butuhkan
- PHP Versi 8.X Ke atas
- Composer


### Langkah-langkah Install
 - Download Project ini
 - Install library yang di butuhkan dengan menjalankan perintah
 ```
composer install
 ```
- Buat database dengan nama ketosin
- Ubah file env.example menjadi .env dan sesuakan configurasinya
- Jalankan perintah berikut untuk mengenerate Key App
```
php artisan key:generate
```
- Jalankan perintah berikut untuk menjalankan migrasi table
```
php artisan migrate
```
- Import Database yang ada di folder z_db -> ketosin.sql
- Jalankan aplikasi dengan menjalankan perintah berikut
```
php artisan serve
```

### Info
- Akun superadmin => username = sipokesip | password = 12345678
