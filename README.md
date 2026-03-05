Instalación paso a paso

1. Clona el repositorio
bash
git clone https://github.com/MilagrosMunoz/VIP2CARS_CRUD.git
cd VIP2CARS_CRUD

2. Instala las dependencias de PHP
bash
composer install
Esperar hasta ver el mensaje Generating optimized autoload files.

3. Copia el archivo de configuración
bash
copy .env.example .env

4. Genera la clave de la aplicación
bash
php artisan key:generate

5. Configura la base de datos(Estoy usando MYSQL:XAMPP)
Abre el archivo .env y reemplaza estas líneas con tus datos(donde dice SQLITE):
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_vip2cars
DB_USERNAME=root
DB_PASSWORD=

6. Crea la base de datos
Abre phpMyAdmin en http://localhost/phpmyadmin y crea una base de datos llamada db_vip2cars. O puedes hacerlo desde MySQL con:
sql
CREATE DATABASE db_vip2cars;

7. Crea las tablas
bash
php artisan migrate

8. Limpia el caché
bash
php artisan config:clear
php artisan cache:clear

9. Levanta el servidor
bash
php artisan serve
Luego abre en el navegador:
http://localhost:8000/vehiculos
