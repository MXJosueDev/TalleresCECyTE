# WORKSHOPS CECYTE

En esta guia encontrarás los pasos para deplegar el proyecto en cualquiera de las siguientes opciones:

-   XAMPP (Desarrollo local)
-   RAILWAY (Produccion)
-   DOCKER Ubuntu (Produccion)

## Base de datos (MySQL o MariaDB)

Sigue estos pasos para inicializar la base de datos **(Necesario para desplegar el proyecto)**

1. Conectate a tu servidor de base de datos (PHPMyAdmin, CLI, etc) y crea una base de datos con el nombre de tu preferencia (Lo necesitarás mas tarde)
2. Copia el contenido del archivo [seed.sql](/seed.sql), pegalo y ejecutalo
3. Establece los instructores y talleres por defecto (Como en el archivo de ejemplo [sampleValues.sql](/sampleValues.sql))
4. ¡Listo! Tu base de datos esta lista para funcionar con el proyecto

## Proyecto

### Usando XAMPP:

(Nota: Este metodo solo esta recomendado para la etapa de desarrollo)

#### #1. Mover y construir el proyecto

Asegurate de tener instalado las siguientes dependencias: **(Importante)**

-   XAMMP
-   Composer
-   NPM

<br />

**Pasos**:

1. Mueve toda la carpeta a el directorio `/htdocs` de tu carpeta de XAMPP

2. Cambia el `DocumentRoot` a `(ruta_anterior)/htdocs/(nombre_de_carpeta_proyecto)/public` en el archivo `httpd.conf`

3. Ejecuta los siguientes comandos, estando en el directorio del proyecto (en orden)

```bash
composer install --no-interaction --no-scripts

npm install

npm run build
```

#### #2. Establece las variables de entorno (.env)

Cambia el nombre del archivo llamado [.env.sample](/.env.sample) a solo `.env`, después establece correctamente los valores de conexión a base de datos y constraseña de usuario administrador

#### #3. Inicia el servidor de Apache en tu _xampp control_

#### #4. ¡Listo!

### Usando Railway:

El proyecto ya cuenta con todas las configuraciones necesarias para desplegarse en Railway, lo unico que necesitas hacer es importar el proyecto desde el repositorio de GitHub a tu proyecto en Railway y establecer las variables de entorno correspondientes a la base de datos y la contraseña del usuario administrador (Ver [.env.sample](/.env.sample))

### Usando Docker:

Asegurate de tener instalado Docker en tu sistema operativo.

#### #1. Construir la imagen

Colocate en el directorio raiz del proyecto y ejecuta el siguiente comando:

```bash
docker build . -t cecyte-workshops --build-arg HOSTNAME=your_db_host --build-arg USERNAME=your_db_user --build-arg PASSWORD=your_db_password --build-arg DATABASE=your_db_name --build-arg PORT=your_db_port --build-arg ADMIN_PASSWORD=your_admin_password
```

(Cambia las build args por las variables de entorno deseadas)

#### #2. Ejecuta el contenedor de docker con la imagen construida

Ejecuta el siguiente comando:

```bash
docker run -p 80:80 -d cecyte-workshops
```

#### 3. ¡Listo!
