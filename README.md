# 🎉 Event Management System

**event management system** is an application designed to simplify the management of various events souch of **meeting, seminar, workshop and other event well online and offline**.
this app build with concept **modern, structured, and esay to use**, so that halp organizer in setting event more efficient.

---

## features

- 📅 **Management Event**  
  create, update, and manage data event centrally.

- 🗂️ **Management category**  
  Grouping event based on type or spesific category.

- 🏢 **Management Venue**  
  Grouping location or place event organizer.

- 📝 **registration Event**  
  user have registration event directly through app.

- 🎫 **Tiket Digital**  
  Systme to make tiket digital as prof registration event.

---

## Application flow usage

1. Admin create **Venue** will use event location.
2. Admin create **category Event**.
3. Admin create **Event** dengan mengisi form sesuai data yang dibutuhkan.
4. Pengguna dapat melihat daftar event dan melakukan **pendaftaran atau pemesanan tiket** secara langsung melalui aplikasi.

---

## ⚙️ How to run the application

### :one: Clone Repository
 ```bash
 git clone https://github.com/by-budiana/event-app
 ```

### :two: Composer Install
```
composer install
```
### :three: Create database and migrate 
```
create new database event_db
adjust .env with .env.xample
and php artisan key:generate
```
### :four: Configuration Laravel Sanctum
```
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```
### :five: Migrate database
```
php artisan migrate
```
### :six: Run
```
php artisan serve
```
---
Build with :heart: for esay **event** management 
