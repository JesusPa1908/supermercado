<?php
$id = $_GET['id'] ?? 0;
$producto = $controller->edit($id);

if (!$producto) {
    header('Location: index.php');
    exit;
}

include __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h2>Editar Producto</h2>
    <a href="<?php echo BASE_URL; ?>" class="btn btn-light">← Volver</a>
</div>

<div class="form-container">
    <form method="POST" action="<?php echo BASE_URL; ?>index.php?action=update" class="form" id="productoForm">
        <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($producto->id_producto); ?>">
        
        <div class="form-group">
            <label for="nombre">Nombre del Producto *</label>
            <input 
                type="text" 
                id="nombre" 
                name="nombre" 
                class="form-control" 
                required 
                maxlength="50"
                value="<?php echo htmlspecialchars($producto->nombre); ?>"
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
                value="<?php echo htmlspecialchars($producto->categoria); ?>"
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
                value="<?php echo htmlspecialchars($producto->precio); ?>"
            >
        </div>

        <div class="form-group">
            <label for="disponible">Disponibilidad *</label>
            <select id="disponible" name="disponible" class="form-control" required>
                <option value="SI" <?php echo ($producto->disponible === 'SI') ? 'selected' : ''; ?>>Disponible</option>
                <option value="NO" <?php echo ($producto->disponible === 'NO') ? 'selected' : ''; ?>>No disponible</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
            <a href="<?php echo BASE_URL; ?>" class="btn btn-light">Cancelar</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

