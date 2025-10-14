<?php
$controller = new ProductoController();

// Búsqueda
$search = $_GET['search'] ?? '';
if (!empty($search)) {
    $productos = $controller->search($search);
} else {
    $productos = $controller->index();
}

include __DIR__ . '/../layouts/header.php';
?>

<!-- Mensajes de éxito/error -->
<?php if (isset($_SESSION['mensaje'])): ?>
    <div class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?>">
        <?php 
        echo $_SESSION['mensaje']; 
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo_mensaje']);
        ?>
    </div>
<?php endif; ?>

<!-- Barra de acciones -->
<div class="page-header">
    <h2>Gestión de Productos</h2>
    <a href="index.php?action=create" class="btn btn-primary">+ Nuevo Producto</a>
</div>

<!-- Barra de busqueda -->
<div class="search-bar">
    <form method="GET" action="index.php" class="search-form">
        <input 
            type="text" 
            name="search" 
            placeholder="Buscar por nombre o categoría..." 
            value="<?php echo htmlspecialchars($search); ?>"
            class="search-input"
        >
        <button type="submit" class="btn btn-secondary">Buscar</button>
        <?php if (!empty($search)): ?>
            <a href="index.php" class="btn btn-light">Limpiar</a>
        <?php endif; ?>
    </form>
</div>

<!-- Tabla de productos -->
<div class="table-container">
    <?php if (count($productos) > 0): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Disponible</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['id_producto']); ?></td>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td>
                            <span class="badge badge-info">
                                <?php echo htmlspecialchars($producto['categoria'] ?? 'Sin categoría'); ?>
                            </span>
                        </td>
                        <td class="precio">$<?php echo number_format($producto['precio'], 2); ?></td>
                        <td>
                            <?php if ($producto['disponible'] === 'SI'): ?>
                                <span class="badge badge-success">Disponible</span>
                            <?php else: ?>
                                <span class="badge badge-danger">No disponible</span>
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <a href="index.php?action=edit&id=<?php echo $producto['id_producto']; ?>" 
                               class="btn btn-sm btn-warning">
                                Editar
                            </a>
                            <a href="index.php?action=delete&id=<?php echo $producto['id_producto']; ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <p>📦 No se encontraron productos</p>
            <?php if (!empty($search)): ?>
                <p>Intenta con otra búsqueda o <a href="index.php">ver todos los productos</a></p>
            <?php else: ?>
                <a href="index.php?action=create" class="btn btn-primary">Crear primer producto</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

