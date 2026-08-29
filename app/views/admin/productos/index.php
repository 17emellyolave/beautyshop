<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bi bi-box-seam me-2"></i>Gestión de Productos</h3>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalProducto" onclick="limpiarProdForm()">
        <i class="bi bi-plus-lg me-1"></i> Nuevo Producto
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Imagen</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $p): ?>
                    <tr>
                        <td>
                            <img src="<?= BASE_URL; ?>public/uploads/<?= $p['imagen']; ?>" width="45" height="45" class="rounded object-fit-cover">
                        </td>
                        <td class="fw-bold"><?= $p['nombre']; ?></td>
                        <td><span class="badge bg-light text-dark border"><?= $p['categoria_nombre']; ?></span></td>
                        <td>$<?= number_format($p['precio'], 0, ',', '.'); ?></td>
                        <td>
                            <span class="badge bg-<?= $p['stock'] > 5 ? 'info' : 'danger'; ?>">
                                <?= $p['stock']; ?> unids
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-<?= $p['estado'] === 'activo' ? 'success' : 'secondary'; ?>">
                                <?= ucfirst($p['estado']); ?>
                            </span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary" 
                                    onclick='editarProd(<?= json_encode($p); ?>)' 
                                    data-bs-toggle="modal" data-bs-target="#modalProducto">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Producto -->
<div class="modal fade" id="modalProducto" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="<?= BASE_URL; ?>admin/guardarProducto" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="modalProdTitle">Nuevo Producto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          <input type="hidden" name="id_producto" id="prod_id">
          
          <div class="col-md-8">
            <label class="form-label">Nombre del Producto *</label>
            <input type="text" name="nombre" id="prod_nombre" class="form-control" required>
          </div>

          <div class="col-md-4">
            <label class="form-label">Categoría *</label>
            <select name="id_categoria" id="prod_categoria" class="form-select" required>
                <?php foreach ($categorias as $c): ?>
                    <option value="<?= $c['id_categoria']; ?>"><?= $c['nombre']; ?></option>
                <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-4">
            <label class="form-label">Precio ($) *</label>
            <input type="number" step="0.01" name="precio" id="prod_precio" class="form-control" required>
          </div>

          <div class="col-md-4">
            <label class="form-label">Stock Inicial *</label>
            <input type="number" name="stock" id="prod_stock" class="form-control" required>
          </div>

          <div class="col-md-4">
            <label class="form-label">Estado</label>
            <select name="estado" id="prod_estado" class="form-select">
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
            </select>
          </div>

          <div class="col-md-12">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" id="prod_descripcion" class="form-control" rows="3"></textarea>
          </div>

          <div class="col-md-12">
            <label class="form-label">Imagen del Producto</label>
            <input type="file" name="imagen" class="form-control" accept="image/*">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar Producto</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function limpiarProdForm() {
    document.getElementById('modalProdTitle').innerText = 'Nuevo Producto';
    document.getElementById('prod_id').value = '';
    document.getElementById('prod_nombre').value = '';
    document.getElementById('prod_precio').value = '';
    document.getElementById('prod_stock').value = '';
    document.getElementById('prod_descripcion').value = '';
    document.getElementById('prod_estado').value = 'activo';
}
function editarProd(p) {
    document.getElementById('modalProdTitle').innerText = 'Editar Producto';
    document.getElementById('prod_id').value = p.id_producto;
    document.getElementById('prod_nombre').value = p.nombre;
    document.getElementById('prod_categoria').value = p.id_categoria;
    document.getElementById('prod_precio').value = p.precio;
    document.getElementById('prod_stock').value = p.stock;
    document.getElementById('prod_descripcion').value = p.descripcion;
    document.getElementById('prod_estado').value = p.estado;
}
</script>
