<?php
class Router {
    protected $controllerName = 'HomeController';
    protected $controller;
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // 1. Verificar si existe el controlador en la URL
        if (isset($url[0]) && !empty($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller';
            $file = __DIR__ . '/../controllers/' . $controllerName . '.php';
            
            if (file_exists($file)) {
                $this->controllerName = $controllerName;
                unset($url[0]);
            }
        }

        // Cargar el archivo e instanciar el controlador
        require_once __DIR__ . '/../controllers/' . $this->controllerName . '.php';
        $this->controller = new $this->controllerName();

        // 2. Verificar el método invocado
        if (isset($url[1]) && !empty($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // 3. Extraer parámetros restantes
        $this->params = $url ? array_values($url) : [];

        // 4. Ejecutar el controlador y el método con sus parámetros
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}