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
