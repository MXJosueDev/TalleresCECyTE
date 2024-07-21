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
RUN npm ci

RUN npm install -g webpack webpack-cli copy-webpack-plugin css-loader sass-loader style-loader

# Ejecuta el build de NPM
RUN npm run build

# Stage 3: Final stage using Apache with PHP support
FROM php:8.0-apache

# Copia los archivos de la aplicación desde el stage de PHP y Node.js
COPY --from=php-composer /app /var/www/html/
COPY --from=node-build /app /var/www/html/

# Instala el modulo mysqli
RUN docker-php-ext-install mysqli

# Habilita el módulo de reescritura de Apache y la configuración de .htaccess
RUN a2enmod rewrite

# Modulo de cache
RUN a2enmod expires

# Configura DocumentRoot
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Establece las variables de entorno
ENV LOADENV=OK

# Exponer el puerto 80
EXPOSE 80

# Comando de inicio 
CMD [ "apache2-foreground" ]