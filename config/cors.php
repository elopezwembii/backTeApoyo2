<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],  // Asegúrate de que las rutas correctas estén incluidas

    'allowed_methods' => ['*'],  // Permitir todos los métodos HTTP

    'allowed_origins' => [
        'https://te-apoyo.cl',  // Agregar comilla de cierre correctamente
        'https://app.te-apoyo.cl',  // Agregar comilla de cierre correctamente
        'https://api-v2.te-apoyo.cl',
        'https://api-php.te-apoyo.cl',
    ],

    'allowed_origins_patterns' => [],  // Deja vacío si no necesitas patrones específicos

    'allowed_headers' => ['*'],  // Permitir todos los encabezados

    'exposed_headers' => [],  // Si necesitas exponer encabezados, agrégalos aquí

    'max_age' => 0,  // Sin caché de solicitudes preflight

    'supports_credentials' => true,  // Habilitar soporte para credenciales (como cookies)

];
