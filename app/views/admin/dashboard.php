<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-speedometer2 text-primary me-2"></i>Panel de Administración</h2>
    <span class="badge bg-primary fs-6">Administrador</span>
</div>

<div class="row g-4">
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm bg-primary text-white h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <div>
                    <h6 class="text-uppercase mb-1 opacity-75">Productos Catalogados</h6>
                    <h2 class="display-5 fw-bold mb-0"><?= $total_productos; ?></h2>
                </div>
                <i class="bi bi-box-seam display-4"></i>
            </div>
            <a href="<?= BASE_URL; ?>admin/productos" class="card-footer bg-primary-subtle text-primary fw-semibold text-decoration-none text-center">
                Gestionar Productos <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm bg-success text-white h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <div>
                    <h6 class="text-uppercase mb-1 opacity-75">Categorías Activas</h6>
                    <h2 class="display-5 fw-bold mb-0"><?= $total_categorias; ?></h2>
                </div>
                <i class="bi bi-tags display-4"></i>
            </div>
            <a href="<?= BASE_URL; ?>admin/categorias" class="card-footer bg-success-subtle text-success fw-semibold text-decoration-none text-center">
                Gestionar Categorías <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Añadir como una tercera tarjeta en el Dashboard de Admin -->
<div class="col-md-6 col-lg-4">
    <div class="card card-beauty border-0 shadow-sm h-100">
        <div class="card-body d-flex align-items-center justify-content-between p-4">
            <div>
                <h6 class="text-uppercase mb-1 text-muted">Analítica de Ventas</h6>
                <h4 class="fw-bold mb-0 text-beauty-dark">Reportes</h4>
            </div>
            <i class="bi bi-graph-up-arrow display-4 text-beauty-primary"></i>
        </div>
        <a href="<?= BASE_URL; ?>admin/reportes" class="card-footer bg-beauty-banner text-beauty-dark fw-semibold text-decoration-none text-center">
            Ver Métricas y KPIs <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
</div>