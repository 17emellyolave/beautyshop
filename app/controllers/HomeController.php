<?php
class HomeController extends Controller {
    private $productoModel;

    public function __construct() {
        $this->productoModel = $this->model('ProductoModel');
    }

    public function index(): void {
        // Consultamos los 3 productos más recientes para destacar
        $destacados = $this->productoModel->obtenerDestacados(3);

        $data = [
            'titulo' => 'Bienvenido a BeautyShop Online',
            'subtitulo' => 'Descubre los mejores productos para el cuidado personal y cosmética',
            'destacados' => $destacados
        ];

        $this->view('home/index', $data);
    }
}