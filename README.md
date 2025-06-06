# DrHome

Platform Digital untuk Memudahkan Perencanaan dan Pembangunan Rumah. Temukan designer, contractor untuk membangun rumah Anda.

## Installation Steps

```bash
git clone https://github.com/aryayudh06/DrHome
cd DrHome
composer install
npm install
cp .env.example .env

php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link

npm run dev
php artisan serve
```
![Landing Page Preview](https://github.com/aryayudh06/DrHome/blob/main/public/images/previewlanding.png?raw=true)