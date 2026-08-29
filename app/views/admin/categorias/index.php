<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bi bi-tags me-2"></i>Gestión de Categorías</h3>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCategoria" onclick="limpiarForm()">
        <i class="bi bi-plus-lg me-1"></i> Nueva Categoría
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorias as $cat): ?>
                    <tr>
                        <td><?= $cat['id_categoria']; ?></td>
                        <td class="fw-bold"><?= $cat['nombre']; ?></td>
                        <td class="text-muted"><?= $cat['descripcion']; ?></td>
                        <td>
                            <span class="badge bg-<?= $cat['estado'] === 'activo' ? 'success' : 'secondary'; ?>">
                                <?= ucfirst($cat['estado']); ?>
                            </span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary me-1" 
                                    onclick='editarCat(<?= json_encode($cat); ?>)' 
                                    data-bs-toggle="modal" data-bs-target="#modalCategoria">
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

<!-- Modal Categoría -->
<div class="modal fade" id="modalCategoria" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= BASE_URL; ?>admin/guardarCategoria" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCatTitle">Nueva Categoría</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_categoria" id="cat_id">
          <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" id="cat_nombre" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" id="cat_descripcion" class="form-control" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" id="cat_estado" class="form-select">
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function limpiarForm() {
    document.getElementById('modalCatTitle').innerText = 'Nueva Categoría';
    document.getElementById('cat_id').value = '';
    document.getElementById('cat_nombre').value = '';
    document.getElementById('cat_descripcion').value = '';
    document.getElementById('cat_estado').value = 'activo';
}
function editarCat(cat) {
    document.getElementById('modalCatTitle').innerText = 'Editar Categoría';
    document.getElementById('cat_id').value = cat.id_categoria;
    document.getElementById('cat_nombre').value = cat.nombre;
    document.getElementById('cat_descripcion').value = cat.descripcion;
    document.getElementById('cat_estado').value = cat.estado;
}
</script>
