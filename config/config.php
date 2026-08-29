<?php
// URL Base del sitio (Ajusta la carpeta según tu servidor local)
define('BASE_URL', 'http://localhost/beautyshop/');

// Nombre de la aplicación
define('APP_NAME', 'BeautyShop Online');

// Configuración de Zona Horaria
date_default_timezone_set('America/Bogota');

// Manejo de errores (Cambiar a 0 en entorno de producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);