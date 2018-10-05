# ТЗ IG

Фичи, которые не делал
````
 1. Глобальные объекты у Application(Response, Router, Request).
 2. Response Facade не реализовывал.
 3. src (либу которая выполняет всю логику) вынес в отдельный namespase, но не выносил
    в отдельный пакет на github.
 4. JS не использовал.
 5. Интерфейс самый простой без каких либо излишеств.
 6. Тесты по группам не разносил.
 7. Тестами Application(подобие фреймворка) не покрывал, долго.
 
 Вроде все что вспомнил по памяти :)
 
 Как запустить:
 
 1. Git clone
 2. composer up
 3. Nginx config(указан ниже) + nginx reload
 4. Если надо подредактировать /etc/hosts
 5. Страница в корне: http://lg.loc/
````

Nginx config

````
server {
    charset utf-8;
    client_max_body_size 128M;
    listen 80; ## listen for ipv4
    #listen [::]:80 default_server ipv6only=on; ## listen for ipv6
    server_name ig.loc;
    root /var/www/innovationgroup/ig/web;
    index index.php;
    access_log /var/log/access.log;
    error_log /var/log/error.log;
    location / {
        # Redirect everything that isn't a real file to index.php
        try_files $uri $uri/ /index.php$is_args$args;
    }
    location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
        try_files $uri =404;
    }
    
    location ~ \.php$ {
        try_files      $uri = 404;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }i

    location ~* /\. {
        deny all;
    }
}
````

Tests:

````
./vendor/bin/phpunit --verbose --debug --colors
````

Test results:

````
ig branch: master petr$ ./vendor/bin/phpunit --verbose --debug --colors
PHPUnit 4.0.20-17-gc4051e4b2 by Sebastian Bergmann.

Configuration read from /private/var/www/ig/phpunit.xml


Starting test 'SorterTest::testJsonLoaders'.
.
Starting test 'SorterTest::testXMLLoaders'.
.
Starting test 'SorterTest::testARRAYLoaders'.
.
Starting test 'SorterTest::testProviderFactory'.
.
Starting test 'SorterTest::testGroup'.
.
Starting test 'SorterTest::testSort'.
.
Starting test 'SorterTest::testFilterNumberGreater'.
.
Starting test 'SorterTest::testFilterNumberLess'.
.
Starting test 'SorterTest::testFilterStringLike'.
.

Time: 45 ms, Memory: 4.00MB

OK (9 tests, 13 assertions)
````
