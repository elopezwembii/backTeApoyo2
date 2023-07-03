
# Backend TA

Api para la empresa Te Apoyo en sistema de gestión de finanzas.




## Installation
Se requiere PHP superior a 7.4 y composer como administrador de paquetes de php.

Para instalar las dependecias de la api ejecutar:

```bash
  composer install
```
Este comando instala las dependencias necesarias de laravel para ejecutar el proyecto.


## Deployment

Para desplegar la api, ejecutar:

```bash
  php artisan migrate:install
```

Para migrar la base de datos (Primera ejecución). Esto creará las tablas necesarias para la correcta ejecución de la api.

```bash
  php artisan passport:install
```
Este comando guarda las cedenciales de OAuth 2.0 para el correcto sistema de login de la api.

```bash
  php artisan db:seed
```

Este comando ejecuta los seeder de la base de datos poblando datos base de la api.

```bash
  php artisan serve
```
Comando que monta la api en un servidor php al puerto 8000.


## Estructura

API Construida mediante patrón MVC, los controladores se almacenan en la carpeta app/http/controllers. Cada controlador ejecuta una operacion elemental del negocio.
Para crear un controlador ejecutar:

```
php artisan make:controller "NombreControlador"
```

los modelos mapean la información a la base de datos y estan almacenados en app/Models.
Para crear un nuevo modelo de datos ejecutar:

```
php artisan make:model "NombreModelo"
```

Las migraciones ejecutan un script para crear la base de datos necesaria para la ejecución de la api.

Para crear una nueva migración ejecutar:
```
php artisan make:migration "NombreMigracion"
```

Las rutas corresponden a los endpoint de a API.
las rutas se almacenan en la carpeta routes/api.php


## Dependencias

Proyecto desarrollado con laravel 8, se requiere php v7.4 Mínimo.
Se utiliza la dependencia laravel/passport para la protección de las rutas mediante OAuth 2.0.
