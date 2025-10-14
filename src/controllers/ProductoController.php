<?php
require_once __DIR__ . '/../database/Database.php';
require_once __DIR__ . '/../models/Producto.php';

class ProductoController {
    private $db;
    private $producto;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->producto = new Producto($this->db);
    }

    //Listar  los productos
    public function index() {
        $stmt = $this->producto->leer();
        $productos = $stmt->fetchAll();
        return $productos;
    }

    // Mostrar formulario de creación
    public function create() {
        require_once __DIR__ . '/../../views/productos/create.php';
    }

    // Guardar un nuevo producto
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->producto->nombre = $_POST['nombre'] ?? '';
            $this->producto->categoria = $_POST['categoria'] ?? '';
            $this->producto->precio = $_POST['precio'] ?? 0;
            $this->producto->disponible = $_POST['disponible'] ?? 'SI';

            if ($this->producto->crear()) {
                $_SESSION['mensaje'] = 'Producto creado exitosamente';
                $_SESSION['tipo_mensaje'] = 'success';
            } else {
                $_SESSION['mensaje'] = 'Error al crear el producto';
                $_SESSION['tipo_mensaje'] = 'error';
            }
            
            header('Location: index.php');
            exit;
        }
    }

    // Formulario de edición
    public function edit($id) {
        $this->producto->id_producto = $id;
        if ($this->producto->leerUno()) {
            return $this->producto;
        }
        return null;
    }

    //Actualizar un producto
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->producto->id_producto = $_POST['id_producto'] ?? 0;
            $this->producto->nombre = $_POST['nombre'] ?? '';
            $this->producto->categoria = $_POST['categoria'] ?? '';
            $this->producto->precio = $_POST['precio'] ?? 0;
            $this->producto->disponible = $_POST['disponible'] ?? 'SI';

            // Depuración: verificar que los datos se reciban
            if (empty($this->producto->id_producto)) {
                $_SESSION['mensaje'] = 'Error: ID de producto no válido';
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php');
                exit;
            }

            if ($this->producto->actualizar()) {
                $_SESSION['mensaje'] = 'Producto actualizado exitosamente';
                $_SESSION['tipo_mensaje'] = 'success';
            } else {
                // Si no hay mensaje de error de SQL, usar uno genérico
                if (!isset($_SESSION['mensaje'])) {
                    $_SESSION['mensaje'] = 'Error al actualizar el producto';
                    $_SESSION['tipo_mensaje'] = 'error';
                }
            }
            
            header('Location: index.php');
            exit;
        } else {
            $_SESSION['mensaje'] = 'Método no permitido';
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php');
            exit;
        }
    }

    //Eliminar un producto
    public function delete($id) {
        $this->producto->id_producto = $id;
        
        if ($this->producto->eliminar()) {
            $_SESSION['mensaje'] = 'Producto eliminado exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al eliminar el producto';
            $_SESSION['tipo_mensaje'] = 'error';
        }
        
        header('Location: index.php');
        exit;
    }

}

