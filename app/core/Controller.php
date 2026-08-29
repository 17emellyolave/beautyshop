<?php
abstract class Controller {
    // Renderiza una vista inyectando variables y los layouts (Header/Footer)
    public function view(string $viewPath, array $data = []): void {
        extract($data);

        $fullPath = __DIR__ . '/../views/' . $viewPath . '.php';

        if (file_exists($fullPath)) {
            require_once __DIR__ . '/../views/layouts/header.php';
            require_once $fullPath;
            require_once __DIR__ . '/../views/layouts/footer.php';
        } else {
            die("La vista '{$viewPath}' no existe.");
        }
    }

    // Carga e instancia un modelo de forma dinámica
    public function model(string $modelName) {
        $modelPath = __DIR__ . '/../models/' . $modelName . '.php';

        if (file_exists($modelPath)) {
            require_once $modelPath;
            return new $modelName();
        } else {
            die("El modelo '{$modelName}' no existe.");
        }
    }

    // Redirección amigable
    public function redirect(string $url): void {
        header('Location: ' . BASE_URL . $url);
        exit();
    }
}