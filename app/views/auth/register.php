<div class="row justify-content-center my-3">
    <div class="col-md-7 col-lg-6">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <i class="bi bi-person-plus-fill fs-1 text-primary"></i>
                    <h3 class="fw-bold mt-2">Crear una Cuenta</h3>
                    <p class="text-muted small">Únete a BeautyShop Online y disfruta de nuestras ofertas</p>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger py-2" role="alert">
                        <small><?= $error; ?></small>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <div class="alert alert-success py-2" role="alert">
                        <small><?= $success; ?></small>
                    </div>
                <?php endif; ?>

                <form action="<?= BASE_URL; ?>auth/register" method="POST">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nombre" class="form-label">Nombre Completo *</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ej. Ana María Pérez">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="correo" class="form-label">Correo Electrónico *</label>
                            <input type="email" class="form-control" id="correo" name="correo" required placeholder="correo@ejemplo.com">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Contraseña *</label>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Mínimo 6 caracteres">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ej. 3001234567">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="direccion" class="form-label">Dirección de Envío</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ej. Calle 123 #45-67">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 mt-2 fw-semibold">
                        <i class="bi bi-check-circle me-1"></i> Registrarme
                    </button>
                </form>

                <div class="text-center mt-3">
                    <small class="text-muted">¿Ya tienes una cuenta? <a href="<?= BASE_URL; ?>auth/login" class="text-decoration-none fw-semibold">Inicia Sesión</a></small>
                </div>
            </div>
        </div>
    </div>
</div>
