# WORKSHOPS CECYTE

En esta guia encontrarás los pasos para deplegar el proyecto en cualquiera de las siguientes opciones:

-   XAMPP (Desarrollo local)
-   RAILWAY (Produccion)
-   DOCKER Ubuntu (Produccion)

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

#### #2. Base de datos

1. Conectate a tu servidor de base de datos (PHPMyAdmin) y crea una base de datos con el nombre de tu preferencia (Lo necesitarás mas tarde)
2. Copia el contenido del archivo [seed.sql](/seed.sql), pegalo y ejecutalo
3. Establece los instructores y talleres por defecto (Como en el archivo de ejemplo [sampleValues.sql](/sampleValues.sql))
4. ¡Listo! Tu base de datos esta lista para funcionar con el proyecto

#### #3. Establece las variables de entorno (.env)

Cambia el nombre del archivo llamado [.env.sample](/.env.sample) a solo `.env`, después establece correctamente los valores de conexión a base de datos y constraseña de usuario administrador

#### #4. Inicia el servidor de Apache en tu _xampp control_

#### #5. ¡Listo!

### Usando Railway:

El proyecto ya cuenta con todas las configuraciones necesarias para desplegarse en Railway, lo unico que necesitas hacer es importar el proyecto desde el repositorio de GitHub a tu proyecto en Railway, crear una base de datos en tu proyecto de Railway, conectarse a la base de datos pegar el contenido del siguiente archivo [seed.sql](/seed.sql) seguido del archivo [sampleValues.sql](/sampleValues.sql), y despues establecer las variables de entorno correspondientes a la base de datos y la contraseña del usuario administrador (Ver [.env.sample](/.env.sample))

### Usando Docker:

Asegurate de tener instalado Docker en tu sistema operativo.

#### #1. Establece las variables de entorno personalizadas en el .env.docker

#### #2. Ejecuta el archivo de inicio

(Nota: puedes opcionalmente pasarle parametros al archivo de inicio, como --build o -d)

##### Windows:

Da doble click o ejecuta desde tu terminal el archivo [start.bat](/start.bat)

##### Linux:

1. Ejecuta el siguiente comando para darle permisos de ejecucion al archivo de inicio:
```bash
chmod +x start.sh
```

2. Da doble click o ejecuta desde tu terminal el archivo [start.sh](/start.sh)

#### #3. Base de datos

1. Conectate a PHPMyAdmin en el puerto que estableciste y selecciona la base de datos con el nombre que estableciste en las variables de entorno
2. Copia el contenido del archivo [seed.sql](/seed.sql), pegalo y ejecutalo
3. Establece los instructores y talleres por defecto (Como en el archivo de ejemplo [sampleValues.sql](/sampleValues.sql))
4. ¡Listo! Tu base de datos esta lista para funcionar con el proyecto

#### #4. ¡Listo!
