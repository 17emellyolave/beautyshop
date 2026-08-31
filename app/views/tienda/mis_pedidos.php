<h2 class="fw-bold mb-4 text-beauty-dark">
    <i class="bi bi-bag-check me-2 text-beauty-primary"></i>Mis Pedidos
</h2>

<?php if (empty($pedidos)): ?>
    <div class="text-center py-5 card card-beauty border-0 shadow-sm">
        <i class="bi bi-bag-x display-1 text-muted"></i>
        <h4 class="mt-3 text-muted">Aún no has realizado ningún pedido.</h4>
        <a href="<?= BASE_URL; ?>tienda" class="btn btn-beauty mt-3">Ir a la Tienda</a>
    </div>
<?php else: ?>
    <div class="card card-beauty border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>N° Pedido</th>
                        <th>Fecha y Hora</th>
                        <th>Dirección de Envío</th>
                        <th>Estado</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $p): ?>
                    <tr>
                        <td class="fw-bold text-beauty-dark">#<?= $p['id_pedido']; ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($p['fecha_pedido'])); ?></td>
                        <td><?= !empty($p['direccion_envio']) ? $p['direccion_envio'] : 'No especificada'; ?></td>
                        <td>
                            <?php 
                                $estado = strtolower($p['estado']);
                                $badgeClass = 'bg-warning text-dark';
                                if ($estado === 'pagado' || $estado === 'entregado') {
                                    $badgeClass = 'bg-success';
                                } elseif ($estado === 'enviado') {
                                    $badgeClass = 'btn-beauty';
                                } elseif ($estado === 'cancelado') {
                                    $badgeClass = 'bg-danger';
                                }
                            ?>
                            <span class="badge <?= $badgeClass; ?>">
                                <?= ucfirst($p['estado']); ?>
                            </span>
                        </td>
                        <td class="fw-bold text-end text-beauty-primary">$<?= number_format($p['total'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>