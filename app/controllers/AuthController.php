<?php
class AuthController extends Controller {
    private $usuarioModel;

    public function __construct() {
        require_once __DIR__ . '/../models/UsuarioModel.php';
        $this->usuarioModel = new UsuarioModel();
    }

    // Mostrar vista de Login o procesar formulario POST
    public function login() {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('home');
            return;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = trim($_POST['correo'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($correo) || empty($password)) {
                $error = 'Por favor complete todos los campos.';
            } else {
                $usuario = $this->usuarioModel->obtenerPorCorreo($correo);

                if ($usuario && password_verify($password, $usuario['password'])) {
                    // Iniciar sesión guardando las claves requeridas
                    $_SESSION['user_id'] = $usuario['id_usuario'];
                    $_SESSION['user_name'] = $usuario['nombre'];
                    $_SESSION['user_role_id'] = $usuario['id_rol'];

                    if ($usuario['id_rol'] == 1) {
                        $this->redirect('admin/dashboard');
                    } else {
                        $this->redirect('tienda');
                    }
                    return;
                } else {
                    $error = 'Credenciales incorrectas o cuenta inactiva.';
                }
            }
        }

        $this->view('auth/login', ['error' => $error]);
    }

    // Mostrar vista de Registro o procesar formulario POST
    public function register() {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('home');
            return;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $correo = trim($_POST['correo'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');

            if (empty($nombre) || empty($correo) || empty($password)) {
                $error = 'Nombre, correo y contraseña son obligatorios.';
            } elseif ($this->usuarioModel->existeCorreo($correo)) {
                $error = 'El correo electrónico ya se encuentra registrado.';
            } else {
                $datos = [
                    'nombre' => $nombre,
                    'correo' => $correo,
                    'password' => password_hash($password, PASSWORD_BCRYPT),
                    'telefono' => $telefono,
                    'direccion' => $direccion
                ];

                if ($this->usuarioModel->registrar($datos)) {
                    $this->redirect('auth/login');
                    return;
                } else {
                    $error = 'Ocurrió un error al registrar el usuario.';
                }
            }
        }

        $this->view('auth/register', ['error' => $error]);
    }

    // Cerrar Sesión de forma limpia
    public function logout() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
        $this->redirect('auth/login');
    }
}