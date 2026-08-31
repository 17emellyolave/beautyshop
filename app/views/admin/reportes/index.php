<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-beauty-dark mb-1"><i class="bi bi-graph-up-arrow me-2 text-beauty-primary"></i>Reportes Analíticos Mensuales</h3>
        <p class="text-muted small mb-0">Balance de ventas, métricas e indicadores de rendimiento de BeautyShop</p>
    </div>
    
    <!-- Filtro Mensual -->
    <form action="<?= BASE_URL; ?>admin/reportes" method="GET" class="d-flex gap-2">
        <select name="mes" class="form-select border-beauty">
            <?php 
            $meses = [
                '01'=>'Enero', '02'=>'Febrero', '03'=>'Marzo', '04'=>'Abril',
                '05'=>'Mayo', '06'=>'Junio', '07'=>'Julio', '08'=>'Agosto',
                '09'=>'Septiembre', '10'=>'Octubre', '11'=>'Noviembre', '12'=>'Diciembre'
            ];
            foreach ($meses as $num => $nombre): 
            ?>
                <option value="<?= $num; ?>" <?= $mes === $num ? 'selected' : ''; ?>><?= $nombre; ?></option>
            <?php endforeach; ?>
        </select>

        <select name="anio" class="form-select border-beauty">
            <?php for ($i = date('Y'); $i >= date('Y') - 2; $i--): ?>
                <option value="<?= $i; ?>" <?= $anio == $i ? 'selected' : ''; ?>><?= $i; ?></option>
            <?php endfor; ?>
        </select>

        <button type="submit" class="btn btn-beauty px-3">
            <i class="bi bi-filter me-1"></i> Filtrar
        </button>
    </form>
</div>

<!-- Tarjetas KPI -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card card-beauty p-3 shadow-sm border-0">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small text-uppercase font-weight-bold">Ingresos Totales</span>
                    <h3 class="fw-bold text-beauty-dark mb-0 mt-1">$<?= number_format($kpis['ingresos_totales'], 0, ',', '.'); ?></h3>
                </div>
                <div class="rounded-circle p-3 bg-beauty-banner text-beauty-primary">
                    <i class="bi bi-currency-dollar fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-beauty p-3 shadow-sm border-0">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small text-uppercase font-weight-bold">Total Pedidos Completados</span>
                    <h3 class="fw-bold text-beauty-dark mb-0 mt-1"><?= $kpis['total_pedidos']; ?></h3>
                </div>
                <div class="rounded-circle p-3 bg-beauty-banner text-beauty-primary">
                    <i class="bi bi-bag-check fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-beauty p-3 shadow-sm border-0">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small text-uppercase font-weight-bold">Ticket Promedio</span>
                    <h3 class="fw-bold text-beauty-dark mb-0 mt-1">$<?= number_format($kpis['ticket_promedio'], 0, ',', '.'); ?></h3>
                </div>
                <div class="rounded-circle p-3 bg-beauty-banner text-beauty-primary">
                    <i class="bi bi-receipt fs-3"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Top Productos -->
    <div class="col-lg-6">
        <div class="card card-beauty shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold text-beauty-dark mb-0"><i class="bi bi-trophy text-warning me-2"></i>Top Productos Más Vendidos</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Unidades</th>
                                <th class="text-end">Recaudado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($top_productos)): ?>
                                <tr><td colspan="4" class="text-center py-3 text-muted">Sin datos en el periodo.</td></tr>
                            <?php else: ?>
                                <?php foreach ($top_productos as $tp): ?>
                                <tr>
                                    <td class="fw-semibold"><?= $tp['nombre']; ?></td>
                                    <td><span class="badge bg-light text-dark border"><?= $tp['categoria']; ?></span></td>
                                    <td><span class="badge btn-beauty"><?= $tp['unidades_vendidas']; ?> unids</span></td>
                                    <td class="text-end fw-bold">$<?= number_format($tp['total_recaudado'], 0, ',', '.'); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Ventas por Categoría -->
    <div class="col-lg-6">
        <div class="card card-beauty shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold text-beauty-dark mb-0"><i class="bi bi-pie-chart text-beauty-primary me-2"></i>Rendimiento por Categoría</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Categoría</th>
                                <th>Unidades</th>
                                <th class="text-end">Total Ventas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($ventas_categorias)): ?>
                                <tr><td colspan="3" class="text-center py-3 text-muted">Sin datos en el periodo.</td></tr>
                            <?php else: ?>
                                <?php foreach ($ventas_categorias as $vc): ?>
                                <tr>
                                    <td class="fw-semibold"><?= $vc['categoria']; ?></td>
                                    <td><?= $vc['total_unidades']; ?> unids</td>
                                    <td class="text-end fw-bold text-beauty-primary">$<?= number_format($vc['total_ventas'], 0, ',', '.'); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Listado General de Transacciones con Selector de Estado -->
<div class="card card-beauty shadow-sm border-0">
    <div class="card-header bg-white py-3 border-0">
        <h5 class="fw-bold text-beauty-dark mb-0"><i class="bi bi-list-check me-2 text-beauty-primary"></i>Detalle de Transacciones del Mes</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>N° Pedido</th>
                        <th>Fecha y Hora</th>
                        <th>Cliente</th>
                        <th class="text-end">Monto Total</th>
                        <th class="text-center" style="width: 200px;">Cambiar Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($detalle_ventas)): ?>
                        <tr><td colspan="5" class="text-center py-4 text-muted">No se registraron pedidos en el mes seleccionado.</td></tr>
                    <?php else: ?>
                        <?php foreach ($detalle_ventas as $dv): ?>
                        <tr>
                            <td class="fw-bold text-beauty-dark">#<?= $dv['id_pedido']; ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($dv['fecha_pedido'])); ?></td>
                            <td><?= $dv['cliente']; ?></td>
                            <td class="text-end fw-bold text-beauty-primary">$<?= number_format($dv['total'], 0, ',', '.'); ?></td>
                            <td class="text-center">
                                <form action="<?= BASE_URL; ?>admin/cambiarEstadoPedido" method="POST" class="d-flex align-items-center justify-content-center gap-1">
                                    <input type="hidden" name="id_pedido" value="<?= $dv['id_pedido']; ?>">
                                    
                                    <select name="estado" class="form-select form-select-sm border-beauty fw-semibold" onchange="this.form.submit()">
                                        <option value="pendiente" <?= $dv['estado'] === 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                        <option value="pagado" <?= $dv['estado'] === 'pagado' ? 'selected' : ''; ?>>Pagado</option>
                                        <option value="enviado" <?= $dv['estado'] === 'enviado' ? 'selected' : ''; ?>>Enviado</option>
                                        <option value="entregado" <?= $dv['estado'] === 'entregado' ? 'selected' : ''; ?>>Entregado</option>
                                        <option value="cancelado" <?= $dv['estado'] === 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

