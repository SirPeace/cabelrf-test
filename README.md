# Запуск проекта

Установить composer зависимости
```
composer install
```

Установить npm зависимости и скомпилировать js
```
npm install && npm run dev
```

Создать **.env** файл
```
$ cp .env.example .env
```

Указать в нем свободные порты для приложения и базы данных, а также параметры соединения с базой данных
```
APP_PORT={your_app_port}

DB_NAME={database_name}
FORWARD_DB_PORT={your_db_port}
```

Запустить docker контейнеры на указанных в **.env** портах, используя утилиту Laravel Sail
```
$ ./vendor/bin/sail up
```

Создать базу данных с тем же именем, что указано в **.env**
```
$ docker exec -it cabelrf-test_mysql_1 bash
# mysql -u root -p
Enter password: {database_password}

mysql> CREATE DATABASE {database_name};
```

Сгенерировать ключ шифрования приложения
```
$ ./vendor/bin/sail artisan key:generate
```

Сгенерировать ссылки для файлов
```
$ ./vendor/bin/sail artisan storage:link
```

Запустить миграции и заполнить базу данных
```
$ ./vendor/bin/sail artisan migrate --seed
```
