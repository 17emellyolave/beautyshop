<div class="row justify-content-center my-4">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <i class="bi bi-person-circle fs-1 text-primary"></i>
                    <h3 class="fw-bold mt-2">Iniciar Sesión</h3>
                    <p class="text-muted small">Ingresa tus datos para acceder a tu cuenta</p>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger py-2" role="alert">
                        <small><?= $error; ?></small>
                    </div>
                <?php endif; ?>

                <form action="<?= BASE_URL; ?>auth/login" method="POST">
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="correo" name="correo" required placeholder="correo@ejemplo.com">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 mt-2 fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                    </button>
                </form>

                <div class="text-center mt-3">
                    <small class="text-muted">¿No tienes cuenta? <a href="<?= BASE_URL; ?>auth/register" class="text-decoration-none fw-semibold">Regístrate aquí</a></small>
                </div>
            </div>
        </div>
    </div>
</div>
