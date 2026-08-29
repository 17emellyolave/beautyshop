<?php
class AuthGuard {

    // Verificar si existe una sesión activa
    public static function isLogged(): bool {
        return isset($_SESSION['user_id']);
    }

    // Restringir páginas solo a usuarios autenticados
    public static function requireLogin(): void {
        if (!self::isLogged()) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit();
        }
    }

    // Restringir páginas según el rol del usuario (Ej: 1 = Administrador)
    public static function requireRole(int $idRol): void {
        self::requireLogin();
        if ((int)$_SESSION['user_role_id'] !== $idRol) {
            header('Location: ' . BASE_URL);
            exit();
        }
    }

    // Prevenir que un usuario logueado vuelva a ver el Login o Registro
    public static function redirectIfLogged(): void {
        if (self::isLogged()) {
            header('Location: ' . BASE_URL);
            exit();
        }
    }
}
