TRUNON
=======

## 依赖

- python
- supervisord
- php
- php5_sqlite

## 安装

执行`setup.sh`

```
git clone https://github.com/imcj/trunon.git
cd trunon
sh setup.sh
```

或者依次执行下面的指令。

```
git clone https://github.com/imcj/trunon.git
cd trunon
composer install
cp .env.example .env
touch storage/trunon
php artisan migrate
php artisan db:seed
```

## 安装 Supervisord

```
pip install supervisor
```
