<?php 
$totalCarritoItems = isset($_SESSION['carrito']) ? array_sum(array_column($_SESSION['carrito'], 'cantidad')) : 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL; ?>public/css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg bg-beauty-nav sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= BASE_URL; ?>">
      <i class="bi bi-heart-fill me-2 text-beauty-primary"></i><?= APP_NAME; ?>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item">
          <a class="nav-link fw-semibold" href="<?= BASE_URL; ?>">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-semibold" href="<?= BASE_URL; ?>tienda">Tienda</a>
        </li>
        <li class="nav-item me-lg-2">
          <a class="nav-link position-relative" href="<?= BASE_URL; ?>tienda/carrito">
            <i class="bi bi-bag-heart fs-5"></i>
            <?php if ($totalCarritoItems > 0): ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill btn-beauty">
                <?= $totalCarritoItems; ?>
              </span>
            <?php endif; ?>
          </a>
        </li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if ($_SESSION['user_role_id'] == 1): ?>
              <li class="nav-item">
                <a class="nav-link text-beauty-primary fw-semibold" href="<?= BASE_URL; ?>admin/dashboard"><i class="bi bi-speedometer2 me-1"></i>Panel Admin</a>
              </li>
            <?php endif; ?>

            <li class="nav-item dropdown ms-lg-2">
              <a class="nav-link dropdown-toggle btn btn-outline-beauty px-3 py-1" href="#" role="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle me-1"></i><?= $_SESSION['user_name']; ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                <li><a class="dropdown-item" href="<?= BASE_URL; ?>tienda/misPedidos"><i class="bi bi-bag-check me-2"></i>Mis Pedidos</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="<?= BASE_URL; ?>auth/logout"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a></li>
              </ul>
            </li>
        <?php else: ?>
            <li class="nav-item">
              <a class="nav-link fw-semibold" href="<?= BASE_URL; ?>auth/login">Iniciar Sesión</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn btn-beauty ms-lg-2 px-3 py-1" href="<?= BASE_URL; ?>auth/register">Registrarse</a>
            </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<main class="container py-4 flex-grow-1">