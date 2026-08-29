<div class="text-center py-5">
    <div class="mb-3">
        <i class="bi bi-check-circle-fill text-beauty-primary display-1"></i>
    </div>
    <h2 class="fw-bold text-beauty-dark mt-2">¡Gracias por tu compra!</h2>
    <p class="fs-5 text-muted">Tu pedido <strong class="text-beauty-primary">#<?= $id_pedido; ?></strong> ha sido procesado exitosamente.</p>
    
    <div class="mt-4">
        <a href="<?= BASE_URL; ?>tienda/misPedidos" class="btn btn-outline-beauty me-2 px-4 py-2 fw-semibold">
            <i class="bi bi-bag-check me-1"></i> Ver Mis Pedidos
        </a>
        <a href="<?= BASE_URL; ?>tienda" class="btn btn-beauty px-4 py-2 fw-semibold">
            <i class="bi bi-shop me-1"></i> Volver a la Tienda
        </a>
    </div>
</div>