<?php
require_once __DIR__ . '/../core/AuthGuard.php';

class AuthController extends Controller {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = $this->model('UsuarioModel');
    }

    // Vista y procesamiento del Formulario de Login
    public function login(): void {
        AuthGuard::redirectIfLogged();

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = filter_var(trim($_POST['correo'] ?? ''), FILTER_VALIDATE_EMAIL);
            $password = trim($_POST['password'] ?? '');

            if (!$correo || empty($password)) {
                $error = 'Por favor, ingrese un correo válido y su contraseña.';
            } else {
                $usuario = $this->usuarioModel->obtenerPorCorreo($correo);

                if ($usuario && password_verify($password, $usuario['password'])) {
                    // Iniciar Sesión Segura
                    $_SESSION['user_id'] = $usuario['id_usuario'];
                    $_SESSION['user_name'] = $usuario['nombre'];
                    $_SESSION['user_email'] = $usuario['correo'];
                    $_SESSION['user_role_id'] = $usuario['id_rol'];
                    $_SESSION['user_role'] = $usuario['rol_nombre'];

                    // Redirección según rol (1: Admin, 2: Cliente)
                    if ($usuario['id_rol'] == 1) {
                        $this->redirect('admin/dashboard');
                    } else {
                        $this->redirect('');
                    }
                } else {
                    $error = 'Credenciales incorrectas o usuario inactivo.';
                }
            }
        }

        $this->view('auth/login', ['error' => $error]);
    }

    // Vista y procesamiento del Formulario de Registro
    public function register(): void {
        AuthGuard::redirectIfLogged();

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $correo = filter_var(trim($_POST['correo'] ?? ''), FILTER_VALIDATE_EMAIL);
            $password = trim($_POST['password'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');

            if (empty($nombre) || !$correo || empty($password)) {
                $error = 'Nombre, correo válido y contraseña son campos obligatorios.';
            } elseif (strlen($password) < 6) {
                $error = 'La contraseña debe tener al menos 6 caracteres.';
            } elseif ($this->usuarioModel->existeCorreo($correo)) {
                $error = 'El correo electrónico ya se encuentra registrado.';
            } else {
                // Encriptar contraseña con BCRYPT
                $passwordHash = password_hash($password, PASSWORD_BCRYPT);

                $datos = [
                    'nombre' => $nombre,
                    'correo' => $correo,
                    'password' => $passwordHash,
                    'telefono' => $telefono,
                    'direccion' => $direccion
                ];

                if ($this->usuarioModel->registrar($datos)) {
                    $success = '¡Registro exitoso! Ya puedes iniciar sesión.';
                } else {
                    $error = 'Ocurrió un error al registrar el usuario. Inténtalo de nuevo.';
                }
            }
        }

        $this->view('auth/register', ['error' => $error, 'success' => $success]);
    }

    // Cierre de Sesión
    public function logout(): void {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        $this->redirect('auth/login');
    }
}
