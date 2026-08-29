<!-- Banner de Bienvenida -->
<div class="p-5 mb-5 bg-beauty-banner shadow-sm border-0">
  <div class="container-fluid py-3">
    <h1 class="display-5 fw-bold text-beauty-dark"><?= $titulo; ?></h1>
    <p class="col-md-8 fs-4 text-beauty-dark opacity-75"><?= $subtitulo; ?></p>
    <a href="<?= BASE_URL; ?>tienda" class="btn btn-beauty btn-lg mt-2 fw-semibold px-4">
      <i class="bi bi-bag-check me-2"></i>Ver Todos los Productos
    </a>
  </div>
</div>

<!-- Sección de Productos Destacados -->
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-beauty-dark"><i class="bi bi-star-fill text-warning me-2"></i>Productos Destacados</h3>
            <p class="text-muted small mb-0">Lo más popular y nuevo en nuestra tienda de cosmética</p>
        </div>
        <a href="<?= BASE_URL; ?>tienda" class="btn btn-outline-beauty btn-sm">
            Ver todo el catálogo <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="row g-4">
        <?php if (empty($destacados)): ?>
            <div class="col-12 text-center py-4">
                <p class="text-muted">Próximamente agregaremos productos destacados.</p>
            </div>
        <?php else: ?>
            <?php foreach ($destacados as $p): ?>
            <div class="col-md-4">
                <div class="card card-beauty h-100 shadow-sm overflow-hidden">
                    
                    <!-- Imagen adaptada sin recorte dentro del bucle donde $p existe -->
                    <img src="<?= BASE_URL; ?>public/uploads/<?= $p['imagen']; ?>" 
                         class="card-img-top img-product-fit" 
                         height="230" 
                         alt="<?= $p['nombre']; ?>">

                    <div class="card-body d-flex flex-column p-4">
                        <span class="badge badge-beauty-cat w-fit-content mb-2"><?= $p['categoria_nombre']; ?></span>
                        <h5 class="card-title fw-bold text-beauty-dark mb-1"><?= $p['nombre']; ?></h5>
                        <p class="card-text text-muted small flex-grow-1"><?= substr($p['descripcion'], 0, 80) . '...'; ?></p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                            <span class="fs-4 fw-bold text-beauty-primary">$<?= number_format($p['precio'], 0, ',', '.'); ?></span>
                            <small class="text-muted">Stock: <?= $p['stock']; ?></small>
                        </div>

                        <form action="<?= BASE_URL; ?>tienda/agregar" method="POST">
                            <input type="hidden" name="id_producto" value="<?= $p['id_producto']; ?>">
                            <button type="submit" class="btn btn-beauty w-100 py-2 fw-semibold" <?= $p['stock'] < 1 ? 'disabled' : ''; ?>>
                                <i class="bi bi-cart-plus me-1"></i> Añadir al Carrito
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>