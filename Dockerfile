FROM php:8.2-apache

# Instalacja bibliotek dla PostgreSQL i rozszerzeń PHP
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Włączenie modułu rewrite w Apache (wymagane dla własnego routera MVC)
RUN a2enmod rewrite