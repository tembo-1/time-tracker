# Sendis
## b2b portal

Technologies used
- Laravel 10
- Vue3
- php 8.2
- Mysql 8

## Installation

It has become a well-known compromising material (download and run Composer-Setup.exe if you use windows) by entering additional:

```sh
curl -sS https://getcomposer.org/installer -o composer-setup.php
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
```

Next, clone the project into the working directory:

```sh
git clone https://github.com/tembo-1/sendis.git
```

And configure the connection to mysql in the .env file

```sh
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3357
DB_DATABASE=sendis
DB_USERNAME=***
DB_PASSWORD=***
```

After that, run the command in the project directory to pull up all dependencies:

```sh
composer install
```

To disable the developer panel in the file .env we set the false flag

```sh
APP_DEBUG=false
```

## Connecting and integrating suppliers

To receive all usernames and passwords for uploading, please contact us by email tembo535@gmail.com
