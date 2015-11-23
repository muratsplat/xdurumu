[![Build Status](https://travis-ci.org/muratsplat/xdurumu.svg?branch=master)](https://travis-ci.org/muratsplat/xdurumu)
### XDurum

Hava.durumum.net's source codes.

This app uses Laravel framework.

This app gets weather data infotmation from Open Weather Map API

The development of this project is discontinued !!

ScreenShots
-----------
![GitHub Logo](screenshots/Screenshot\ from\ 2015-11-23\ 22-49-03.png)
![GitHub Logo](screenshots/Screenshot\ from\ 2015-11-23\ 22-49-23.png)
![GitHub Logo](screenshots/Screenshot\ from\ 2015-11-23\ 22-49-46.png)
![GitHub Logo](screenshots/Screenshot\ from\ 2015-11-23\ 22-55-51.png)
![GitHub Logo](screenshots/Screenshot\ from\ 2015-11-23\ 22-56-07.png)

Yapılacaklar
------------
- [x] Şehirler diye bir tablo oluşturulacak. openweathermap.org ait şehirler bilgisi sadece Türliye olanlar süzülerek veritabanı eklenecek. Elbette bunun için seeder ve migration sınıflar yazılacak. Basit testleri yapılacak.
- [x] openweathermap.org'dan anlık hava durumunu alacak servis yazılacak.
- [x] openweathermap.org'dan saatlik hava durumunu alacak servis yazılacak.
- [x] openweathermap.org'dan günlük hava durumu alacak olan servis yazılacak.
- [x] Servis tesleri yapılacak.
- [x] Şehir ve bazı verileri kontrol etmek için admin panel entegre edilecek.
- [x] Panel erişim yönetimi yapılacak.
- [x] otomatik sitemap.xml oluşturacak servis yazılacak.
- [x] Subdoman tanımlaması yapılacak.
- [x] Anasayfa yolu tanımlanıp temayla birlikte denetleyicisi yazılacak.
- [x] hava.xdurumu.com anasayafası hazırlanacak..
- [x] Domain alınacak ve site yayına sokulacak.
- [x] Google Analytics entegrasyonu yapılacak.
- [x] Şehirler için saatlik ve günlük sayfaları hazırlanacak.. 
- [x] Sadece Haftasonu gösteren sayfalar yapılacak..
- [ ] Anlık İstatislik gösteren sayfa yapılacak..
- [ ] Günlük hava durumu istatisliklerini gösteren sayfa yapılacak.

How To Install
--------------
```sh
git clone https://github.com/muratsplat/xdurumu
cd xdurumu
composer install
npm install
gulp

php artisan serve

```
You have to add this lines on /etc/hosts file  to access the app's hava.yourhost api.yourhost sub-domains.

```sh
127.0.0.1	durumum.dev
127.0.0.1	hava.durumum.dev
127.0.0.1 	api.durumum.dev

```
Now you can open http://hava.durumum.dev:8000/ via your browser.

 
License
--------
Copyright (C) 2015 Murat ÖDÜNÇ  GPLv3
