<div class="row justify-content-center">
    <div class="col-lg-8">
        <h2 class="fw-bold mb-4"><i class="bi bi-credit-card me-2 text-primary"></i>Finalizar Compra y Pago</h2>

        <div class="card border-0 shadow-sm p-4 mb-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Resumen de la Orden</h5>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cant.</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($_SESSION['carrito'] as $item): 
                            $subtotal = $item['precio'] * $item['cantidad'];
                            $total += $subtotal;
                        ?>
                        <tr>
                            <td><?= $item['nombre']; ?></td>
                            <td><?= $item['cantidad']; ?></td>
                            <td class="text-end fw-bold">$<?= number_format($subtotal, 0, ',', '.'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="table-light fs-5">
                            <td colspan="2" class="fw-bold">Total a Pagar:</td>
                            <td class="text-end fw-bold text-primary">$<?= number_format($total, 0, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <form action="<?= BASE_URL; ?>tienda/checkout" method="POST">
            <!-- Datos de Envío -->
            <div class="card border-0 shadow-sm p-4 mb-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2"><i class="bi bi-geo-alt me-2 text-primary"></i>Información de Envío</h5>
                <div class="mb-3">
                    <label for="direccion_envio" class="form-label fw-semibold">Dirección de Entrega *</label>
                    <input type="text" class="form-control" id="direccion_envio" name="direccion_envio" 
                           placeholder="Ej. Calle 123 #45-67, Apto 201, Bogotá" required>
                </div>
            </div>

            <!-- Simulación de Pasarela de Pago -->
            <div class="card border-0 shadow-sm p-4 mb-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2"><i class="bi bi-cash-stack me-2 text-primary"></i>Simulador de Pasarela de Pago</h5>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Selecciona el Método de Pago:</label>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="metodo_pago" id="pago_tarjeta" value="tarjeta" checked onclick="togglePago('tarjeta')">
                        <label class="form-check-label" for="pago_tarjeta">
                            <i class="bi bi-credit-card-2-front me-1"></i> Tarjeta de Crédito / Débito (Simulado)
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="metodo_pago" id="pago_pse" value="pse" onclick="togglePago('pse')">
                        <label class="form-check-label" for="pago_pse">
                            <i class="bi bi-bank me-1"></i> Transferencia Bancaria (PSE)
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="metodo_pago" id="pago_efectivo" value="efectivo" onclick="togglePago('efectivo')">
                        <label class="form-check-label" for="pago_efectivo">
                            <i class="bi bi-wallet2 me-1"></i> Pago Contra Entrega
                        </label>
                    </div>
                </div>

                <!-- Campos Tarjeta (Simulados) -->
                <div id="seccion_tarjeta" class="p-3 bg-light rounded border">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small text-muted">Número de Tarjeta de Prueba</label>
                            <input type="text" class="form-control" placeholder="4500 0000 0000 0000" maxlength="19" value="4500 1234 5678 9010">
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted">Fecha Vencimiento</label>
                            <input type="text" class="form-control" placeholder="MM/AA" value="12/28">
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted">CVC / CVV</label>
                            <input type="password" class="form-control" placeholder="123" maxlength="3" value="123">
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <a href="<?= BASE_URL; ?>tienda/carrito" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver al Carrito
                </a>
                <button type="submit" class="btn btn-success btn-lg px-4 fw-bold">
                    <i class="bi bi-shield-lock me-1"></i> Simular Pago y Confirmar ($<?= number_format($total, 0, ',', '.'); ?>)
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function togglePago(tipo) {
    const secTarjeta = document.getElementById('seccion_tarjeta');
    if (tipo === 'tarjeta') {
        secTarjeta.style.display = 'block';
    } else {
        secTarjeta.style.display = 'none';
    }
}
</script>
