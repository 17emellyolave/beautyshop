<div class="row mb-4 align-items-center">
    <div class="col-md-5">
        <h2 class="fw-bold text-beauty-dark mb-1">
            <i class="bi bi-shop me-2 text-beauty-primary"></i>Catálogo de Productos
        </h2>
    </div>
    <div class="col-md-7 text-md-end mt-3 mt-md-0">
        <div class="btn-group flex-wrap" role="group">
            <a href="<?= BASE_URL; ?>tienda" 
               class="btn btn-beauty-filter btn-sm px-3 <?= !$cat_seleccionada ? 'active' : ''; ?>">
               Todos
            </a>
            <?php foreach ($categorias as $cat): ?>
                <a href="<?= BASE_URL; ?>tienda?cat=<?= $cat['id_categoria']; ?>" 
                   class="btn btn-beauty-filter btn-sm px-3 <?= $cat_seleccionada == $cat['id_categoria'] ? 'active' : ''; ?>">
                   <?= $cat['nombre']; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="row g-4">
    <?php if (empty($productos)): ?>
        <div class="col-12 text-center py-5">
            <i class="bi bi-emoji-frown display-1 text-muted"></i>
            <p class="fs-4 text-muted mt-3">No hay productos disponibles en esta categoría.</p>
        </div>
    <?php else: ?>
        <?php foreach ($productos as $p): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card card-beauty h-100 shadow-sm overflow-hidden">
                
                <!-- Imagen completa sin recortes dentro del bucle -->
                <img src="<?= BASE_URL; ?>public/uploads/<?= $p['imagen']; ?>" 
                     class="card-img-top img-product-fit" 
                     height="230" 
                     alt="<?= $p['nombre']; ?>">

                <div class="card-body d-flex flex-column p-4">
                    <div>
                        <span class="badge badge-beauty-cat mb-2"><?= $p['categoria_nombre']; ?></span>
                        <h5 class="card-title fw-bold text-beauty-dark mb-1"><?= $p['nombre']; ?></h5>
                        <p class="card-text text-muted small flex-grow-1"><?= substr($p['descripcion'], 0, 90) . '...'; ?></p>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                        <span class="fs-4 fw-bold text-beauty-primary">$<?= number_format($p['precio'], 0, ',', '.'); ?></span>
                        <small class="text-muted">Stock: <?= $p['stock']; ?></small>
                    </div>

                    <form action="<?= BASE_URL; ?>tienda/agregar" method="POST" class="mt-auto">
                        <input type="hidden" name="id_producto" value="<?= $p['id_producto']; ?>">
                        <button type="submit" class="btn btn-beauty w-100 py-2 fw-semibold" <?= $p['stock'] < 1 ? 'disabled' : ''; ?>>
                            <i class="bi bi-cart-plus me-1"></i> <?= $p['stock'] < 1 ? 'Agotado' : 'Añadir al Carrito'; ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>