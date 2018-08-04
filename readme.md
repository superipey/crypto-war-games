# Crypto War Games
Crypto War Games - Small Games for Learn about Cryptography using PHP

## Requirement
- PHP 7.1 atau terbaru
- Composer
- Laravel 5.6

## How to Install
- Clone ke komputer anda
- ```$ composer install``` untuk menginstall dependencies
- Buat file .env, copy dari .env.example lalu konfigurasi database anda 
- ```$ php artisan migrate```
- Buka halaman utama di localhost/crypto-war-games (Mode Server)
- ```$ php artisan serve``` lalu buka localhost:8000 di browser anda (Mode Severless)

## How to Play The Games - Single Mode
- Buka Website https://cwg.smkn4bdg.sch.id
- Klik tombol Register
- Lengkapi form, username dan password mohon diingat dengan baik
- Setelah berhasil, silakan login dengan menggunakan username dan password tersebut
- Ketika game sudah mulai, akan muncul Contoh Soal, silakan dikerjakan dengan menebak cipher method yang digunakan dan salt yang digunakan, setelah berhasil menebak maka akan muncul cipher text level 1 (Plain text yang sudah di shift), silakan tebak cipher text tersebut sampai didapatkan Plain Text. Jika sudah mendapatkan plain text, submit jawaban di kolom Answer.
- Siapa yang paling cepat menjawab pertanyaan tersebut maka akan mendapatkan score dan pertanyaan tersebut akan hilang dan diganti dengan pertanyaan lain.
- Hanya satu soal yang akan muncul sampai soal tersebut dijawab, setelah dijawab akan muncul satu soal berikutnya (random)
- Satu siswa maksimal menjawab 10 soal
- Score tertinggi akan mendapatkan nilai tertinggi dikelas

Selamat mencoba :)