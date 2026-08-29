<?php
require_once __DIR__ . '/../core/AuthGuard.php';

class TiendaController extends Controller {
    private $productoModel;
    private $categoriaModel;
    private $pedidoModel;

    public function __construct() {
        $this->productoModel = $this->model('ProductoModel');
        $this->categoriaModel = $this->model('CategoriaModel');
        $this->pedidoModel = $this->model('PedidoModel');

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
    }

    // Catálogo interactivo de productos
    public function index(): void {
        $idCategoria = filter_input(INPUT_GET, 'cat', FILTER_VALIDATE_INT);
        
        $productos = $this->productoModel->obtenerTodos();
        $categorias = $this->categoriaModel->obtenerActivas();

        // Filtrar productos por categoría si se selecciona una
        if ($idCategoria) {
            $productos = array_filter($productos, function($p) use ($idCategoria) {
                return $p['id_categoria'] == $idCategoria && $p['estado'] === 'activo';
            });
        } else {
            $productos = array_filter($productos, function($p) {
                return $p['estado'] === 'activo';
            });
        }

        $this->view('tienda/index', [
            'productos' => $productos,
            'categorias' => $categorias,
            'cat_seleccionada' => $idCategoria
        ]);
    }

    // Agregar producto al carrito en sesión
    public function agregar(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idProducto = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);
            $cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_INT) ?: 1;

            $producto = $this->productoModel->obtenerPorId($idProducto);

            if ($producto && $producto['stock'] >= $cantidad) {
                if (isset($_SESSION['carrito'][$idProducto])) {
                    $_SESSION['carrito'][$idProducto]['cantidad'] += $cantidad;
                } else {
                    $_SESSION['carrito'][$idProducto] = [
                        'id_producto' => $producto['id_producto'],
                        'nombre' => $producto['nombre'],
                        'precio' => $producto['precio'],
                        'imagen' => $producto['imagen'],
                        'cantidad' => $cantidad
                    ];
                }
            }
        }
        $this->redirect('tienda/carrito');
    }

    // Mostrar resumen del carrito
    public function carrito(): void {
        $total = 0;
        foreach ($_SESSION['carrito'] as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        $this->view('tienda/carrito', ['total' => $total]);
    }

    // Eliminar un ítem del carrito
    public function eliminar(int $idProducto): void {
        if (isset($_SESSION['carrito'][$idProducto])) {
            unset($_SESSION['carrito'][$idProducto]);
        }
        $this->redirect('tienda/carrito');
    }

    // Procesar Checkout / Compra
    public function checkout(): void {
        AuthGuard::requireLogin();

        if (empty($_SESSION['carrito'])) {
            $this->redirect('tienda');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $direccion = trim($_POST['direccion_envio'] ?? '');
            
            $total = 0;
            foreach ($_SESSION['carrito'] as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }

            $datosPedido = [
                'id_usuario' => $_SESSION['user_id'],
                'total' => $total,
                'direccion_envio' => $direccion
            ];

            $idPedido = $this->pedidoModel->crearPedido($datosPedido, $_SESSION['carrito']);

            if ($idPedido) {
                $_SESSION['carrito'] = []; // Vaciar carrito tras compra exitosa
                $this->redirect('tienda/confirmacion/' . $idPedido);
            } else {
                // CORRECCIÓN: Se envía $total a la vista del carrito junto con el mensaje de error
                $this->view('tienda/carrito', [
                    'error' => 'No hay suficiente stock disponible para completar el pedido. Por favor verifica las cantidades.',
                    'total' => $total
                ]);
                return;
            }
        }

        $this->view('tienda/checkout');
    }


    // Mensaje de éxito del pedido
    public function confirmacion(int $idPedido): void {
        AuthGuard::requireLogin();
        $this->view('tienda/confirmacion', ['id_pedido' => $idPedido]);
    }

    // Historial de Pedidos del Cliente
    public function misPedidos(): void {
        AuthGuard::requireLogin();
        $pedidos = $this->pedidoModel->obtenerPorUsuario($_SESSION['user_id']);
        $this->view('tienda/mis_pedidos', ['pedidos' => $pedidos]);
    }


    // Modificar la cantidad de un producto en el carrito (+ / -)
    public function actualizarCantidad(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idProducto = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);
            $accion = $_POST['accion'] ?? ''; // 'sumar' o 'restar'

            if ($idProducto && isset($_SESSION['carrito'][$idProducto])) {
                $producto = $this->productoModel->obtenerPorId($idProducto);

                if ($accion === 'sumar') {
                    // Verificar que no se supere el stock en BD
                    if ($_SESSION['carrito'][$idProducto]['cantidad'] < $producto['stock']) {
                        $_SESSION['carrito'][$idProducto]['cantidad']++;
                    }
                } elseif ($accion === 'restar') {
                    $_SESSION['carrito'][$idProducto]['cantidad']--;
                    // Si la cantidad llega a 0, se elimina del carrito
                    if ($_SESSION['carrito'][$idProducto]['cantidad'] <= 0) {
                        unset($_SESSION['carrito'][$idProducto]);
                    }
                }
            }
        }
        $this->redirect('tienda/carrito');
    }    

}
