<?php
require_once __DIR__ . '/../core/AuthGuard.php';

class AdminController extends Controller {
    private $productoModel;
    private $categoriaModel;

    public function __construct() {
        AuthGuard::requireRole(1); // Solo administradores
        $this->productoModel = $this->model('ProductoModel');
        $this->categoriaModel = $this->model('CategoriaModel');
    }

    // Dashboard principal del Admin
    public function dashboard(): void {
        $data = [
            'total_productos' => count($this->productoModel->obtenerTodos()),
            'total_categorias' => count($this->categoriaModel->obtenerTodas())
        ];
        $this->view('admin/dashboard', $data);
    }

    // --- MÓDULO CATEGORÍAS ---
    public function categorias(): void {
        $categorias = $this->categoriaModel->obtenerTodas();
        $this->view('admin/categorias/index', ['categorias' => $categorias]);
    }

    public function guardarCategoria(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'id_categoria', FILTER_VALIDATE_INT);
            $nombre = trim($_POST['nombre'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $estado = $_POST['estado'] ?? 'activo';

            $datos = [
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'estado' => $estado
            ];

            if ($id) {
                $this->categoriaModel->actualizar($id, $datos);
            } else {
                $this->categoriaModel->crear($datos);
            }
            $this->redirect('admin/categorias');
        }
    }

    // --- MÓDULO PRODUCTOS ---
    public function productos(): void {
        $productos = $this->productoModel->obtenerTodos();
        $categorias = $this->categoriaModel->obtenerActivas();
        $this->view('admin/productos/index', [
            'productos' => $productos,
            'categorias' => $categorias
        ]);
    }

    public function guardarProducto(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);
            $id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_VALIDATE_INT);
            $nombre = trim($_POST['nombre'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
            $stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);
            $estado = $_POST['estado'] ?? 'activo';

            // Procesar subida de imagen
            $imagenNombre = 'default.png';
            if ($id) {
                $prodActual = $this->productoModel->obtenerPorId($id);
                $imagenNombre = $prodActual['imagen'];
            }

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
                $extPermitidas = ['jpg', 'jpeg', 'png', 'webp'];

                if (in_array($ext, $extPermitidas)) {
                    $imagenNombre = md5(time() . rand()) . '.' . $ext;
                    $destino = __DIR__ . '/../../public/uploads/' . $imagenNombre;
                    move_uploaded_file($_FILES['imagen']['tmp_name'], $destino);
                }
            }

            $datos = [
                'id_categoria' => $id_categoria,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'precio' => $precio,
                'stock' => $stock,
                'imagen' => $imagenNombre,
                'estado' => $estado
            ];

            if ($id) {
                $this->productoModel->actualizar($id, $datos);
            } else {
                $this->productoModel->crear($datos);
            }
            $this->redirect('admin/productos');
        }
    }


    // Método a incorporar dentro de AdminController

    public function reportes(): void {
        $reporteModel = $this->model('ReporteModel');

        // Obtener mes y año seleccionado (Por defecto el mes actual)
        $mes = $_GET['mes'] ?? date('m');
        $anio = $_GET['anio'] ?? date('Y');

        // Fechas de inicio y fin del mes seleccionado
        $fechaInicio = "{$anio}-{$mes}-01";
        $fechaFin = date("Y-m-t", strtotime($fechaInicio));

        // Cargar datos analíticos
        $kpis = $reporteModel->obtenerKPIs($fechaInicio, $fechaFin);
        $topProductos = $reporteModel->obtenerTopProductos($fechaInicio, $fechaFin);
        $ventasCategorias = $reporteModel->obtenerVentasPorCategoria($fechaInicio, $fechaFin);
        $detalleVentas = $reporteModel->obtenerDetalleVentas($fechaInicio, $fechaFin);

        $data = [
            'mes' => $mes,
            'anio' => $anio,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'kpis' => $kpis,
            'top_productos' => $topProductos,
            'ventas_categorias' => $ventasCategorias,
            'detalle_ventas' => $detalleVentas
        ];

        $this->view('admin/reportes/index', $data);
    }

}
