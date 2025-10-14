<?php
session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/controllers/ProductoController.php';

// Obtener la acción solicitada
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

// Instanciar el controlador
$controller = new ProductoController();

// Enrutamiento
switch ($action) {
    case 'index':
        // Listar productos
        require_once __DIR__ . '/views/productos/index.php';
        break;
    
    case 'create':
        // Mostrar formulario de crear
        require_once __DIR__ . '/views/productos/create.php';
        break;
    
    case 'store':
        // Guardar nuevo producto
        $controller->store();
        break;
    
    case 'edit':
        // Mostrar formulario de edición
        if ($id) {
            require_once __DIR__ . '/views/productos/edit.php';
        } else {
            header('Location: index.php');
            exit;
        }
        break;
    
    case 'update':
        // Actualizar producto
        $controller->update();
        break;
    
    case 'delete':
        // Eliminar producto
        if ($id) {
            $controller->delete($id);
        } else {
            header('Location: index.php');
            exit;
        }
        break;
    
    default:
        // Redirigir al index si la acción no existe
        header('Location: index.php');
        exit;
}

