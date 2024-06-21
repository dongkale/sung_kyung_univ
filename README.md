# SungKyung University

## Requirements

-   php: PHP 8.3.2 & composer
-   node.js: v20.11.0
-   mysql: v8.0.36

## PHP Configuration

`php.ini`:

```ini
max_execution_time = 180
post_max_size = 50M
upload_max_filesize = 10M
```

Setting `.env` file.

## Development

```sh
npm run dev
```

## Watching

```sh
npm run watch
```

## Build

```sh
Connect to `http://localhost:3000`
```

## Recommended VSCode extensions

-   EditorConfig for VS Code
-   Prettier - Code formatter
-   ENV (or `DotENV`)
-   PHP IntelliSense (not `PHP Intelephense`)
-   PHP Debug (for `xdebug`)

## DB Schema

## Server Apply

-- gitpull.sh

```sh
sudo git pull
sudo npm run dev
sudo chown -R www-data:www-data *
sudo php artisan l5-swagger:generate
sudo chown -R www-data:www-data *
```

## Excel Download

```sh
composer require maatwebsite/excel --ignore-platform-reqs
```

## System Install

```sh
0. time zone
sudo dpkg-reconfigure tzdata

1. # 패키지 목록 업데이트
sudo apt-get update

2. # 시스템 패키지 업데이트
sudo apt-get -y upgrade

3. ## PHP8 설치
sudo apt-get install -y php8.1-cli php8.1-sqlite3 php8.1-curl  php8.1-mysql php8.1-readline php8.1-mbstring php8.1-xml php8.1-zip php8.1-intl

4. ## PHP8 fpm 설치
sudo apt-get install php8.1-fpm

5. nginx 설치
sudo apt-get install -y nginx

sudo apt install -y unzip

6. composer setup download
curl -sS https://getcomposer.org/installer -o composer-setup.php

7. composer 설치
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

8. laravel 설치
omposer global require laravel/installer

9. 테스트 프로젝트 생성
    composer create-project --prefer-dist laravel/laravel helloworld

    cd /var/www/helloworld
    chown -R :www-data ./{storage,bootstrap/cache}
    chmod -R 777 storage
    chmod -R 775 bootstrap/cache

    php artisan key:generate

    cat .env | grep APP_KEY

10. nodejs 설치
sudo apt install -y nodejs

11. npm 설치
sudo apt install -y npm

12. mysql 설치
sudo apt install -y mysql-server
sudo systemctl start mysql.service

13. 계정 생성
create user lennon@'%' identified by 'lennon0108!';

sudo vim /etc/mysql/mysql.conf.d/mysqld.cnf
bind-address            = 0.0.0.0

sudo service mysql restart

-- 권한 부여
GRANT ALL PRIVILEGES ON *.* TO lennon@'%';
FLUSH PRIVILEGES;

14. AWS 3306 허용

15. 소스 다운로드
git clone https://github.com/dongkale/lennon_api.git

16. laravel, npm  설치
sudo chown -R www-data:www-data *

sudo composer install --ignore-platform-req=ext-gd
#sudo npm config -g set strict-ssl false
sudo npm install
sudo composer require fruitcake/laravel-cors --ignore-platform-req=ext-gd

17. mysql root 접속
sudo mysql -u root -p
```
