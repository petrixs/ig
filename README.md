# ig

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
