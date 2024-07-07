# Stage 1: Build stage for PHP and Composer
FROM php:8.0-cli AS php-composer

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia los archivos de la aplicación al contenedor
COPY ./ /app

# Define el directorio de trabajo
WORKDIR /app

# Instala los paquetes necesarios para el build
RUN apt-get update && apt-get install -y zip unzip git

# Instala dependencias de Composer
RUN composer install --no-interaction --no-scripts

# Stage 2: Build stage for Node.js
FROM node:22 AS node-build

# Copia los archivos de la aplicación al contenedor
COPY ./ /app

# Define el directorio de trabajo
WORKDIR /app

# Instala dependencias de NPM
RUN npm install

# Ejecuta el build de NPM
RUN npm run build

# Stage 3: Final stage using Apache with PHP support
FROM php:8.0-apache

# Copia los archivos de la aplicación desde el stage de PHP y Node.js
COPY --from=php-composer /app /var/www/html/
COPY --from=node-build /app /var/www/html/

# Habilita el módulo de reescritura de Apache y la configuración de .htaccess
RUN a2enmod rewrite

# Configura DocumentRoot
RUN sed -i 's#DocumentRoot "/var/www/html"#DocumentRoot "/var/www/html/public"#g' /etc/apache2/sites-available/000-default.conf

# Define variables de entorno para la base de datos
ARG HOSTNAME
ARG USERNAME
ARG PASSWORD
ARG DATABASE
ARG PORT

# Crea el archivo .env con los valores de la base de datos
RUN echo "HOSTNAME=${DB_HOST}" > /var/www/html/.env
RUN echo "USERNAME=${USERNAME}" >> /var/www/html/.env
RUN echo "PASSWORD=${PASSWORD}" >> /var/www/html/.env
RUN echo "DATABASE=${DATABASE}" >> /var/www/html/.env
RUN echo "PORT=${PORT}" >> /var/www/html/.env

# Exponer el puerto 80
EXPOSE 80
