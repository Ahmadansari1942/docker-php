FROM php:8.2-apache

COPY index.php /var/www/html/

COPY ..

EXPOSE 80
