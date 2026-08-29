<h2 class="fw-bold mb-4"><i class="bi bi-bag-check me-2 text-primary"></i>Mis Pedidos</h2>

<?php if (empty($pedidos)): ?>
    <div class="text-center py-5">
        <i class="bi bi-box-seam display-1 text-muted"></i>
        <h4 class="mt-3 text-muted">Aún no has realizado ninguna compra</h4>
        <a href="<?= BASE_URL; ?>tienda" class="btn btn-primary mt-3">Explorar Tienda</a>
    </div>
<?php else: ?>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>N° Pedido</th>
                        <th>Fecha</th>
                        <th>Dirección de Envío</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $p): ?>
                    <tr>
                        <td class="fw-bold">#<?= $p['id_pedido']; ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($p['fecha_pedido'])); ?></td>
                        <td><?= $p['direccion_envio']; ?></td>
                        <td class="fw-bold text-primary">$<?= number_format($p['total'], 0, ',', '.'); ?></td>
                        <td>
                            <?php 
                            $badge = match($p['estado']) {
                                'pendiente' => 'bg-warning text-dark',
                                'pagado' => 'bg-info text-white',
                                'enviado' => 'bg-primary',
                                'entregado' => 'bg-success',
                                'cancelado' => 'bg-danger',
                                default => 'bg-secondary'
                            };
                            ?>
                            <span class="badge <?= $badge; ?>"><?= ucfirst($p['estado']); ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>
