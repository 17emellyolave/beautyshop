<h2 class="fw-bold mb-4 text-beauty-dark"><i class="bi bi-cart3 me-2 text-beauty-primary"></i>Carrito de Compras</h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger" role="alert"><?= $error; ?></div>
<?php endif; ?>

<?php if (empty($_SESSION['carrito'])): ?>
    <div class="text-center py-5">
        <i class="bi bi-cart-x display-1 text-muted"></i>
        <h4 class="mt-3 text-muted">Tu carrito está vacío</h4>
        <a href="<?= BASE_URL; ?>tienda" class="btn btn-beauty mt-3">Ir a la Tienda</a>
    </div>
<?php else: ?>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card card-beauty border-0 shadow-sm">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['carrito'] as $item): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= BASE_URL; ?>public/uploads/<?= $item['imagen']; ?>" width="50" height="50" class="rounded me-3 object-fit-cover">
                                        <span class="fw-semibold text-beauty-dark"><?= $item['nombre']; ?></span>
                                    </div>
                                </td>
                                <td>$<?= number_format($item['precio'], 0, ',', '.'); ?></td>
                                
                                <!-- Controles +/- para Cantidad -->
                                <td class="text-center" style="width: 140px;">
                                    <div class="input-group input-group-sm justify-content-center">
                                        <!-- Botón Restar (-) -->
                                        <form action="<?= BASE_URL; ?>tienda/actualizarCantidad" method="POST" class="d-inline">
                                            <input type="hidden" name="id_producto" value="<?= $item['id_producto']; ?>">
                                            <input type="hidden" name="accion" value="restar">
                                            <button type="submit" class="btn btn-outline-beauty px-2 py-1">
                                                <i class="bi bi-dash-lg"></i>
                                            </button>
                                        </form>

                                        <!-- Cantidad Actual -->
                                        <span class="input-group-text bg-light text-beauty-dark fw-bold px-3 border-beauty">
                                            <?= $item['cantidad']; ?>
                                        </span>

                                        <!-- Botón Sumar (+) -->
                                        <form action="<?= BASE_URL; ?>tienda/actualizarCantidad" method="POST" class="d-inline">
                                            <input type="hidden" name="id_producto" value="<?= $item['id_producto']; ?>">
                                            <input type="hidden" name="accion" value="sumar">
                                            <button type="submit" class="btn btn-outline-beauty px-2 py-1">
                                                <i class="bi bi-plus-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                                <td class="fw-bold text-end">$<?= number_format($item['precio'] * $item['cantidad'], 0, ',', '.'); ?></td>
                                
                                <td class="text-center">
                                    <a href="<?= BASE_URL; ?>tienda/eliminar/<?= $item['id_producto']; ?>" class="text-danger" title="Eliminar ítem">
                                        <i class="bi bi-trash fs-5"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-beauty border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-3 text-beauty-dark">Resumen del Pedido</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span>$<?= number_format($total, 0, ',', '.'); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Envío:</span>
                    <span class="text-success fw-bold">¡Gratis!</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-4 fs-4 fw-bold">
                    <span>Total:</span>
                    <span class="text-beauty-primary">$<?= number_format($total, 0, ',', '.'); ?></span>
                </div>
                <a href="<?= BASE_URL; ?>tienda/checkout" class="btn btn-beauty w-100 py-2 fw-semibold">
                    Proceder al Pago <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>