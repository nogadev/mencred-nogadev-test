# daily-credits-manager
Daily Credits Manager - MencreDiario

* Laravel 5.7
* PHP 7
* MySQL
* Composer 1.7

Setting up:

1. Ejecutar el comando composer update para instalar los frameworks de Auditoria y Roles y permisos;

2. Crear el archivo .env a partir de .env.example y modificar los campos
		DB_CONNECTION=mysql
		DB_HOST=127.0.0.1
		DB_PORT=3306
		DB_DATABASE=daily_manager
		DB_USERNAME=root
		DB_PASSWORD=123456
	de acuerdo a los datos locales;
	
3. Ejecutar el comando php artisan key:generate para generar la KEY del archivo .env
	
4. Ejecutar el comando php artisan migrate para crear las tablas en la BD;

5. Ejecutar el comando php artisan migrate --seed para generar 5 usuarios en la base de datos. Todos los usuarios tendran 'secret' como contraseña;

6. Ejecutar el comando php artisan serve para poner en marcha el servidor.

7. Abrir la URL indicada por el servidor y loguearse con las credenciales generadas por el seeder.