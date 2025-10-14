<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2>Crear Nuevo Producto</h2>
    <a href="<?php echo BASE_URL; ?>" class="btn btn-light">← Volver</a>
</div>

<div class="form-container">
    <form method="POST" action="<?php echo BASE_URL; ?>index.php?action=store" class="form" id="productoForm">
        <div class="form-group">
            <label for="nombre">Nombre del Producto *</label>
            <input 
                type="text" 
                id="nombre" 
                name="nombre" 
                class="form-control" 
                required 
                maxlength="50"
                placeholder="Ej: Laptop Lenovo"
            >
        </div>

        <div class="form-group">
            <label for="categoria">Categoría</label>
            <input 
                type="text" 
                id="categoria" 
                name="categoria" 
                class="form-control" 
                maxlength="30"
                placeholder="Ej: Electrónica"
                list="categorias"
            >
            <datalist id="categorias">
                <option value="Electrónica">
                <option value="Muebles">
                <option value="Accesorios">
                <option value="Alimentos">
                <option value="Bebidas">
                <option value="Limpieza">
            </datalist>
        </div>

        <div class="form-group">
            <label for="precio">Precio *</label>
            <input 
                type="number" 
                id="precio" 
                name="precio" 
                class="form-control" 
                required 
                step="0.01" 
                min="0"
                placeholder="0.00"
            >
        </div>

        <div class="form-group">
            <label for="disponible">Disponibilidad *</label>
            <select id="disponible" name="disponible" class="form-control" required>
                <option value="SI" selected>Disponible</option>
                <option value="NO">No disponible</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar Producto</button>
            <a href="<?php echo BASE_URL; ?>" class="btn btn-light">Cancelar</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

