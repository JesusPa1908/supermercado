<?php
// Asegurar que la sesión esté iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$controller = new ProductoController();

// Obtener todos los productos
$productos = $controller->index();

include __DIR__ . '/../layouts/header.php';
?>

<!-- Mensajes de éxito/error -->
<?php if (isset($_SESSION['mensaje'])): ?>
    <div class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?>" style="padding: 15px; margin: 20px 0; border: 2px solid <?php echo $_SESSION['tipo_mensaje'] === 'success' ? '#28a745' : '#dc3545'; ?>; background-color: <?php echo $_SESSION['tipo_mensaje'] === 'success' ? '#d4edda' : '#f8d7da'; ?>; color: <?php echo $_SESSION['tipo_mensaje'] === 'success' ? '#155724' : '#721c24'; ?>; border-radius: 5px;">
        <strong><?php echo $_SESSION['tipo_mensaje'] === 'success' ? '✅' : '❌'; ?></strong>
        <?php 
        echo $_SESSION['mensaje']; 
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo_mensaje']);
        ?>
    </div>
<?php endif; ?>

<!-- Debug temporal -->
<?php if (isset($_SESSION['mensaje'])): ?>
    <div style="background: #f0f0f0; padding: 10px; margin: 10px 0; border: 1px solid #ccc;">
        <strong>DEBUG:</strong> Mensaje encontrado: <?php echo $_SESSION['mensaje']; ?> | Tipo: <?php echo $_SESSION['tipo_mensaje']; ?>
    </div>
<?php endif; ?>

<!-- Barra de acciones -->
<div class="page-header">
    <h2>Gestión de Productos</h2>
    <a href="<?php echo BASE_URL; ?>index.php?action=create" class="btn btn-primary">+ Nuevo Producto</a>
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
                            <?php if ($producto['disponible'] == 1 || $producto['disponible'] === 'SI'): ?>
                                <span class="badge badge-success">Disponible</span>
                            <?php else: ?>
                                <span class="badge badge-danger">No disponible</span>
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <a href="<?php echo BASE_URL; ?>index.php?action=edit&id=<?php echo $producto['id_producto']; ?>" 
                               class="btn btn-sm btn-warning">
                                Editar
                            </a>
                            <a href="<?php echo BASE_URL; ?>index.php?action=delete&id=<?php echo $producto['id_producto']; ?>" 
                               class="btn btn-sm btn-danger">
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
            <a href="<?php echo BASE_URL; ?>index.php?action=create" class="btn btn-primary">Crear primer producto</a>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

