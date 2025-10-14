<?php
class Producto {
    private $conn;
    private $table = 'productos';

    // Propiedades del producto
    public $id_producto;
    public $nombre;
    public $categoria;
    public $precio;
    public $disponible;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * 
     * @return PDOStatement
     */
    public function leer() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id_producto DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * 
     * @return bool
     */
    public function leerUno() {
        $query = "SELECT * FROM " . $this->table . " WHERE id_producto = :id_producto LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_producto', $this->id_producto, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            $this->nombre = $row['nombre'];
            $this->categoria = $row['categoria'];
            $this->precio = $row['precio'];
            $this->disponible = $row['disponible'];
            return true;
        }
        return false;
    }

    /**
     * 
     * @return bool
     */
    public function crear() {
        $query = "INSERT INTO " . $this->table . " (nombre, categoria, precio, disponible) 
                  VALUES (:nombre, :categoria, :precio, :disponible)";
        
        $stmt = $this->conn->prepare($query);

        // Limpiar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->categoria = htmlspecialchars(strip_tags($this->categoria));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->disponible = htmlspecialchars(strip_tags($this->disponible));

        // Vincular parámetros
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->bindParam(':precio', $this->precio);
        $stmt->bindParam(':disponible', $this->disponible);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * 
     * @return bool
     */
    public function actualizar() {
        $query = "UPDATE " . $this->table . " 
                  SET nombre = :nombre, 
                      categoria = :categoria, 
                      precio = :precio, 
                      disponible = :disponible
                  WHERE id_producto = :id_producto";
        
        $stmt = $this->conn->prepare($query);

        // Limpiar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->categoria = htmlspecialchars(strip_tags($this->categoria));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->disponible = htmlspecialchars(strip_tags($this->disponible));
        $this->id_producto = htmlspecialchars(strip_tags($this->id_producto));

        // Vincular parámetros
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->bindParam(':precio', $this->precio);
        $stmt->bindParam(':disponible', $this->disponible);
        $stmt->bindParam(':id_producto', $this->id_producto, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * 
     * @return bool
     */
    public function eliminar() {
        $query = "DELETE FROM " . $this->table . " WHERE id_producto = :id_producto";
        $stmt = $this->conn->prepare($query);
        
        $this->id_producto = htmlspecialchars(strip_tags($this->id_producto));
        $stmt->bindParam(':id_producto', $this->id_producto, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * 
     * @param string $search
     * @return PDOStatement
     */
    public function buscar($search) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE nombre LIKE :search OR categoria LIKE :search 
                  ORDER BY id_producto DESC";
        
        $stmt = $this->conn->prepare($query);
        $search = "%{$search}%";
        $stmt->bindParam(':search', $search);
        $stmt->execute();
        
        return $stmt;
    }
}

