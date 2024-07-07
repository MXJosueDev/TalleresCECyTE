# Stage 1: Build stage for PHP and Composer
FROM php:8.0-cli AS php-composer

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia los archivos de la aplicación al contenedor
COPY ./ /app

# Define el directorio de trabajo
WORKDIR /app

# Instala los paquetes necesarios para el build
RUN apt-get update && apt-get install -y zip unzip
RUN apt-get update && apt-get install -y git

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

# Stage 3: Final stage using httpd
FROM httpd:2.4

# Copia los archivos de la aplicación desde el stage de PHP y Node.js
COPY --from=php-composer /app /usr/local/apache2/htdocs/
COPY --from=node-build /app /usr/local/apache2/htdocs/

# Configura DocumentRoot
RUN sed -i 's#DocumentRoot "/usr/local/apache2/htdocs"#DocumentRoot "/usr/local/apache2/htdocs/public"#g' /usr/local/apache2/conf/httpd.conf

# Define variables de entorno para la base de datos
ARG HOSTNAME
ARG USERNAME
ARG PASSWORD
ARG DATABASE
ARG PORT

# Crea el archivo .env con los valores de la base de datos
RUN echo "HOSTNAME=${DB_HOST}" > /usr/local/apache2/htdocs/.env
RUN echo "USERNAME=${USERNAME}" >> /usr/local/apache2/htdocs/.env
RUN echo "PASSWORD=${PASSWORD}" >> /usr/local/apache2/htdocs/.env
RUN echo "DATABASE=${DATABASE}" >> /usr/local/apache2/htdocs/.env
RUN echo "PORT=${PORT}" >> /usr/local/apache2/htdocs/.env

CMD ["httpd","-D","FOREGROUND"]

# Exponer el puerto 80
EXPOSE 80
