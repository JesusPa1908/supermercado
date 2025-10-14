<?php

// Detectar si estamos en Azure (producción) o local (desarrollo)
$isAzure = isset($_SERVER['WEBSITE_SITE_NAME']);

if ($isAzure) {
    // Configuración para Azure (producción)
    define('DB_HOST', 'marketperu.database.windows.net');
    define('DB_NAME', 'supermercado');
    define('DB_USER', 'adminsql');
    define('DB_PASS', 'Sql1908.');
    define('DB_CHARSET', 'utf8mb4');
    
    define('APP_NAME', 'Supermercado - Gestión de Productos');
    define('BASE_URL', 'https://' . $_SERVER['HTTP_HOST'] . '/');
} else {
    // Configuración para local (desarrollo)
    define('DB_HOST', 'marketperu.database.windows.net');
    define('DB_NAME', 'supermercado');
    define('DB_USER', 'adminsql');
    define('DB_PASS', 'Sql1908.');
    define('DB_CHARSET', 'utf8mb4');
    
    define('APP_NAME', 'Supermercado - Gestión de Productos');
    define('BASE_URL', 'http://localhost/supermercado/');
}

