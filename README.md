# 💄 BeautyShop Online - E-Commerce Web MVC

**BeautyShop Online** es una plataforma web de comercio electrónico desarrollada para el sector de cosméticos, cuidado personal y perfumería. El sistema permite gestionar catálogos de productos, inventarios en tiempo real, usuarios con control de acceso basado en roles (RBAC), un flujo completo de compras con carrito de compras y simulador de pagos, además de un módulo de analítica mensual para la toma de decisiones empresariales.

---

## 🚀 Características Principales

* **Arquitectura MVC Pura:** Implementación desde cero en PHP 8 sin frameworks pesados, con enrutamiento limpio (*Front Controller*) mediante `.htaccess`.
* **Seguridad Avanzada:** Consultas preparadas con PDO para evitar SQL Injection, hashing de contraseñas con `password_hash()` (BCrypt) y gestión de sesiones seguras.
* **Control de Acceso (RBAC):** Autenticación de usuarios diferenciando entre cliente y administrador (`AuthGuard`).
* **Gestión de Inventario Dinámico:** Control de stock en tiempo real mediante transacciones SQL PDO (`beginTransaction` / `commit` / `rollBack`).
* **Interfaz de Usuario Atractiva:** Diseño 100% responsivo con Bootstrap 5, paleta de colores personalizada para la industria cosmética y soporte para imágenes completas sin recortes.
* **Módulo Analítico:** Métricas e Indicadores Clave de Rendimiento (KPIs), ventas por categoría y productos más vendidos con filtrado mensual.

---

## 🛠️ Stack Tecnológico

* **Lenguaje Principal:** PHP 8.x (Programación Orientada a Objetos - POO).
* **Base de Datos:** MySQL / MariaDB (Motor InnoDB, codificación `utf8mb4`).
* **Acceso a Datos:** PHP Data Objects (PDO).
* **Frontend:** HTML5, CSS3 personalizado (`style.css`), JavaScript (Vanilla) y Bootstrap 5.3 + Bootstrap Icons.
* **Servidor Web:** Apache con módulo `mod_rewrite` activado.

---

## 📁 Estructura del Proyecto (Patrón MVC)

```text
beautyshop/
│
├── config/
│   ├── config.php             # Constantes globales (URL base, nombre de app)
│   └── database.php           # Conexión Singleton a la Base de Datos con PDO
│
├── app/
│   ├── core/
│   │   ├── Controller.php     # Clase base para controladores
│   │   ├── Model.php          # Clase base para modelos con PDO
│   │   ├── Router.php         # Front Controller / Enrutador de URLs amigables
│   │   └── AuthGuard.php      # Helper de seguridad y control de sesiones (RBAC)
│   │
│   ├── controllers/
│   │   ├── HomeController.php # Controlador de la página de bienvenida y destacados
│   │   ├── AuthController.php # Gestión de Login, Registro y Logout
│   │   ├── AdminController.php# Dashboard administrativo, CRUDs y Reportes
│   │   └── TiendaController.php# Catálogo, Carrito, Checkout y Mis Pedidos
│   │
│   ├── models/
│   │   ├── UsuarioModel.php   # Consultas de usuarios y autenticación
│   │   ├── CategoriaModel.php # Consultas y operaciones de categorías
│   │   ├── ProductoModel.php  # Consultas, CRUD e inventario de productos
│   │   ├── PedidoModel.php    # Transacciones de compra y detalle de pedidos
│   │   └── ReporteModel.php   # Agregaciones SQL, KPIs y analítica mensual
│   │
│   └── views/
│       ├── layouts/
│       │   ├── header.php     # Menú de navegación dinámico y cabecera
│       │   └── footer.php     # Pie de página estilo Sticky Footer
│       ├── home/
│       │   └── index.php      # Landing page con banner y productos destacados
│       ├── auth/
│       │   ├── login.php      # Formulario de inicio de sesión
│       │   └── register.php   # Formulario de registro de clientes
│       ├── admin/
│       │   ├── dashboard.php  # Panel general del Administrador
│       │   ├── categorias/    # Gestión CRUD de categorías
│       │   ├── productos/     # Gestión CRUD de productos con subida de imágenes
│       │   └── reportes/      # Panel de reportes analíticos mensuales
│       └── tienda/
│           ├── index.php      # Catálogo público con filtros
│           ├── carrito.php    # Carrito interactivo con controles +/-
│           ├── checkout.php   # Formulario de envío y simulador de pagos
│           ├── confirmacion.php# Resumen de compra exitosa
│           └── mis_pedidos.php# Historial de compras del cliente
│
├── public/
│   ├── css/
│   │   └── style.css          # Paleta de colores y estilos personalizados
│   ├── js/
│   │   └── main.js            # Funcionalidad JS del lado del cliente
│   └── uploads/               # Directorio para imágenes subidas de productos
│
├── .htaccess                  # Reescribidor de URLs para enrutamiento limpio
└── index.php                  # Punto de entrada único a la aplicación

🛠️ Fases de Desarrollo Realizadas

📌 Fase 1: Arquitectura Base y Base de Datos (MySQL)
Diseño del Modelo Entidad-Relación normalizado en Tercera Forma Normal (3FN).

Creación de las tablas roles, usuarios, categorias, productos, pedidos y detalle_pedidos con llaves foráneas e índices.

Inserción de datos iniciales y hashing de credenciales de prueba (Admin123*).

📌 Fase 2: Estructura del Proyecto y Configuración MVC
Implementación de la arquitectura de carpetas MVC y el patrón Singleton para la conexión PDO (database.php).

Creación del enrutador centralizado (Router.php) y reglas .htaccess para gestión de URLs amigables.

Integración del Maquetado Base responsivo con Bootstrap 5 y técnica Sticky Footer.

📌 Fase 3: Módulo de Autenticación y Control de Acceso (RBAC)
Desarrollo de la lógica de registro de clientes y login seguro con password_verify().

Implementación de AuthGuard para restringir el acceso a zonas administrativas según el rol del usuario.

Adaptación del Navbar dinámico para reflejar el estado de la sesión activa.

📌 Fase 4: Módulos CRUD Base (Panel de Administración)
Creación del Dashboard Administrativo con indicadores básicos.

Gestión completa (Listar, Crear, Editar y Cambiar Estado) de Categorías y Productos.

Soporte para carga y almacenamiento de imágenes de productos en el servidor.

📌 Fase 5: Frontend Tienda, Carrito de Compras y Pedidos
Catálogo interactivo de productos con filtrado dinámico por categorías.

Carrito de compras basado en sesiones con controles interactivos para incrementar (+) o decrementar (-) cantidades.

Pasarela de simulación de pagos (Tarjeta de Crédito, PSE, Efectivo) con transacciones PDO seguras que garantizan la consistencia y descuento de stock.

Panel del cliente para consulta del historial de compras (Mis Pedidos).

📌 Fase 6: Módulo de Reportes Mensuales y Análisis de Métricas Clave
Creación de ReporteModel.php para consultas analíticas agregadas en MySQL.

Panel de administración de reportes con selección de mes/año.

Cálculo de KPIs clave: Ingresos Totales, Total de Pedidos y Ticket Promedio.

Tablas desglosadas de Productos Más Vendidos, Rendimiento por Categoría y Transacciones del Mes.

🎨 Fase de Personalización Estética
Adaptación de la guía de estilos visuales a una paleta cosmética de tonos rosa pastel, rosa viejo (#d48b97), nude/maquillaje (#fcebe6) y marrón oscuro (#7a4a51).

Optimización de renderizado de imágenes de productos mediante la propiedad CSS object-fit: contain para visualizar los empaques completos sin recortes.

⚙️ Instalación en Entorno Local (XAMPP / WAMP)
Clonar o copiar la carpeta del proyecto beautyshop dentro del directorio htdocs (ej. C:\xampp\htdocs\beautyshop).

Importar la Base de Datos:

Abre phpMyAdmin o tu gestor MySQL.

Crea la base de datos beautyshop_db.

Ejecuta el script SQL suministrado en la Fase 1.

Asegurar Módulos de Apache:

Verifica que el módulo mod_rewrite de Apache esté activado.

Configuración de la URL:

Revisa config/config.php y confirma que BASE_URL coincida con tu ruta local:

PHP
define('BASE_URL', 'http://localhost/beautyshop/');
