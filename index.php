<?php
// Iniciar sesión global de PHP
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cargar configuración global y componentes base
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/core/Controller.php';
require_once __DIR__ . '/app/core/Model.php';
require_once __DIR__ . '/app/core/Router.php';

// Iniciar la aplicación
$app = new Router();